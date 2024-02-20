<?php
include_once('../BD_Conncetion/connection.php');

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../View/login.php");
    exit;
}

function identificador($dbDB)
{
    $identificador = rand(1, 1000);

    $stmt = $dbDB->prepare("SELECT COUNT(*) FROM Visitante WHERE identificador = :identificador");
    $stmt->bindParam(':identificador', $identificador, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    // Se o identificador já existe no banco de dados, gere um novo
    while ($count > 0) {
        $identificador = rand(1, 1000); // Gere um novo identificador
        $stmt->bindParam(':identificador', $identificador, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    }

    return $identificador;
}

function inserirSolicitacao($dbDB, $nome, $celular, $cpf, $email, $data_entrevista, $motivo_visita, $identificador)
{
    $inserir = $dbDB->prepare("INSERT INTO Visitante (nome, celular,cpf, email, periodo_visita_de, motivo_visita ,identificador) VALUES (:nome, :celular, :cpf, :email, :periodo_visita_de, :motivo_visita, :identificador)");
    $inserir->bindParam(':nome', $nome);
    $inserir->bindParam(':celular', $celular);
    $inserir->bindParam(':cpf', $cpf);
    $inserir->bindParam(':email', $email);
    $data_entrevista = date('Y-m-d H:i:s', strtotime($data_entrevista));
    $inserir->bindParam(':periodo_visita_de', $data_entrevista);
    $inserir->bindParam(':motivo_visita', $motivo_visita);
    $inserir->bindParam(':identificador', $identificador);

    if ($inserir->execute()) {
        $id_usuario = $_SESSION["id"];
        $id = $dbDB->lastInsertId();
        $inserir_aprov = $dbDB->prepare("INSERT INTO aprovacao (id_visitante, id_usuario, aprovado_reprovado) VALUES (:resultados, :id_usuario, 'on' )");
        $inserir_aprov->bindParam(':id_usuario', $id_usuario);
        $inserir_aprov->bindParam(':resultados', $id);
        if ($inserir_aprov->execute()) {
            $_SESSION['sucesso'] = "Entrevista foi criada e aprovada com sucesso";
            header("Location: ../View/solicitacao_entrevista.php");
        }
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    for ($i = 0; $i < count($_POST['nome']); $i++) {
        $nome = $_POST['nome'][$i];
        $celular = $_POST['celular'][$i];
        $cpf = $_POST['cpf'][$i];
        $email = $_POST['email'][$i];
        $data_entrevista = $_POST['periodo_visita_de'][$i];
        $motivo_visita = $_POST["motivo_visita"];

        // Chame a função para inserir os dados.
        $identificador = identificador($dbDB);

        inserirSolicitacao($dbDB, $nome, $celular, $cpf, $email, $data_entrevista, $motivo_visita, $identificador);
    }
}
function readSolicitacaoEntrevista($dbDB)
{
    $read = $dbDB->prepare("SELECT * FROM Visitante WHERE motivo_visita = 'Entrevista' ORDER BY id ASC");
    $read->execute();
    $query = $read->fetchAll(PDO::FETCH_ASSOC);

    return $query;
}
function readEntrevistasAprovadas($dbDB)
{
    $query = $dbDB->prepare("SELECT Visitante.* FROM aprovacao 
    JOIN Visitante ON aprovacao.id_visitante = Visitante.id WHERE Visitante.motivo_visita = 'Entrevista' ORDER BY id ASC ");
    $query->execute();
    $EntrevistasAprovadas = $query->fetchAll(PDO::FETCH_ASSOC);

    return $EntrevistasAprovadas;
}

function paginacao($dbDB, $paginaAtual = 1, $limite = 5)
{
    $paginaAtual = 1;
    $limite = 5;

    if (isset($_GET['paginaAtual'])) {
        $paginaAtual = filter_input(INPUT_GET, "paginaAtual", FILTER_VALIDATE_INT);
    } else {
        $paginaAtual = 1;
    }

    if ($paginaAtual) {

        $inicio = ($paginaAtual * $limite) - $limite;

        $consulta = $dbDB->prepare("SELECT * FROM solicitacao_entrevista ORDER BY  id OFFSET $inicio ROWS FETCH NEXT $limite ROWS ONLY");
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $registro = $dbDB->query("SELECT COUNT(id) as count FROM solicitacao_entrevista")->fetch()["count"];
        $_SESSION["paginas"] = $paginas = ceil($registro / $limite);
        return $resultado;
    }
}
