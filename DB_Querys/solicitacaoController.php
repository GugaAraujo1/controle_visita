<?php
include_once('../BD_Conncetion/connection.php');

$cpfErro = "";

function gerarIdentificador($dbDB)
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

function validaCPF($cpf)
{
    // Remove caracteres não numéricos
    $cpf = preg_replace('/[^0-9]/', "", $cpf);

    // verifica se o CPF possui exatamente 11 dígitos 
    if (strlen($cpf) != 11) {

        return false;
    }

    if (strlen($cpf) != 11 || preg_match('/([0-9])\1{10}/', $cpf)) {
        return false;
    }

    $número_quantidade_para_loop = [9, 10];

    foreach ($número_quantidade_para_loop as $item) {
        $num = 0;
        $numero_para_multiplicar = $item + 1;

        for ($i = 0; $i < $item; $i++) {

            $num += $cpf[$i] * ($numero_para_multiplicar--);
        }

        $result = (($num * 10) % 11);

        if ($cpf[$item] != $result) {
            return false;
        }
    }
    return true;
}

function inserirVisita($dbDB, $nome, $cpf, $celular, $email, $periodo_visita_de, $periodo_visita_ate, $empresa, $visitante, $area_da_visita, $integracao, $acesso_fabrica, $carro_oficina, $carro_cliente, $datawake, $observacao, $motivo_visita, $identificador)
{
    $client = new GuzzleHttp\Client();

    $inserir = $dbDB->prepare(
        "INSERT INTO Visitante (
            nome,
            cpf,
            celular,
            email,
            periodo_visita_de,
            periodo_visita_ate,
            empresa,
            visitante,
            area_da_visita,
            integracao,
            acesso_fabrica,
            carro_oficina,
            carro_cliente,
            datawake,
            observacao,
            motivo_visita,
            identificador
            ) VALUES (
                :nome,
                :cpf,
                :celular,
                :email,
                :periodo_visita_de,
                :periodo_visita_ate,
                :empresa,
                :visitante,
                :area_da_visita,
                :integracao,
                :acesso_fabrica,
                :carro_oficina,
                :carro_cliente,
                :datawake,
                :observacao,
                :motivo_visita,
                :identificador)"
    );
    $inserir->bindParam(':nome', $nome);
    $inserir->bindParam(':cpf', $cpf);
    $inserir->bindParam(':celular', $celular);
    $inserir->bindParam(':email', $email);
    $inserir->bindParam(':periodo_visita_de', $periodo_visita_de);
    $inserir->bindParam(':periodo_visita_ate', $periodo_visita_ate);
    $inserir->bindParam(':empresa', $empresa);
    $inserir->bindParam(':visitante', $visitante);
    $inserir->bindParam(':area_da_visita', $area_da_visita);
    $inserir->bindValue(':integracao', $integracao, PDO::PARAM_BOOL);
    $inserir->bindValue(':acesso_fabrica', $acesso_fabrica, PDO::PARAM_BOOL);
    $inserir->bindValue(':carro_oficina', $carro_oficina, PDO::PARAM_BOOL);
    $inserir->bindValue(':carro_cliente', $carro_cliente, PDO::PARAM_BOOL);
    $inserir->bindValue(':datawake', $datawake, PDO::PARAM_BOOL);
    $inserir->bindParam(':observacao', $observacao);
    $inserir->bindParam(':motivo_visita', $motivo_visita);
    $inserir->bindParam(':identificador', $identificador);

    if ($inserir->execute()) {

        $mensagem = "Olá " . $visitante . ". Apenas um lembrete de sua visita no dia " . $periodo_visita_de;

        $response = $client->request('POST', 'https://v5.chatpro.com.br/chatpro-7f76318222/api/v1/send_message', [
            'json' =>
            [
                'number' => $celular,
                'message' => $mensagem,
                'quoted_message_id' => '',
            ],

            'headers' => [
                'Authorization' => '801c73f9bb8fdaf169d7e7ed297f79b7',
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ],
        ]);

        $response->getBody();

        // aprovacao automatica caso acesso_fabrica seja igua a 0.0
        $id = $dbDB->lastInsertId();
        $consulta = $dbDB->prepare("SELECT acesso_fabrica FROM Visitante WHERE id = :visitante_id");
        $consulta->bindParam(':visitante_id', $id);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($resultado && $resultado['acesso_fabrica'] == 0) {
            $id_usuario = $_SESSION["id"];
            $id = $dbDB->lastInsertId();
            $insertInto = $dbDB->prepare("INSERT INTO aprovacao (id_visitante, id_usuario, aprovado_reprovado) VALUES (:resultados, :id_usuario, 'on' )");
            $insertInto->bindParam(':id_usuario', $id_usuario);
            $insertInto->bindParam(':resultados', $id);

            if ($insertInto->execute()) {
                $_SESSION['sucesso'] = "Visita foi criada e aprovada com sucesso";
                header("Location: ../View/solicitacao.php");
                exit;
            }
        } else {
            $_SESSION['sucesso'] = "Visita foi criada com sucesso";
            header("Location: ../View/solicitacao.php");
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = isset($_POST["nome"]) ? $_POST["nome"] : '';
    $cpf = isset($_POST["cpf"]) ?  $_POST["cpf"] : '';
    $celular = isset($_POST["celular"]) ?  $_POST["celular"] : '';
    $email = isset($_POST["email"]) ?  $_POST["email"] : '';
    $periodo_visita_de = date('Y-m-d H:i', strtotime($_POST["periodo_visita_de"]));
    $periodo_visita_ate = date('Y-m-d H:i', strtotime($_POST["periodo_visita_ate"]));
    $empresa = isset($_POST["empresa"]) ? $_POST["empresa"] : '';
    $visitante = isset($_POST["visitante"]) ? $_POST["visitante"] : '';
    $area_da_visita = isset($_POST["area_da_visita"]) ? $_POST["area_da_visita"] : '';
    $integracao = isset($_POST["confirmar_integracao"]) ? true : false;
    $acesso_fabrica = isset($_POST["acesso_fabrica"]) ? true : false;
    $carro_oficina = isset($_POST["carro_oficina"]) ? true : false;
    $carro_cliente = isset($_POST["carro_cliente"]) ? true : false;
    $datawake = isset($_POST["datawake"]) ? true : false;
    $observacao = isset($_POST["observacao"]) ? $_POST["observacao"] : '';
    $motivo_visita = isset($_POST["motivo_visita"]) ? $_POST["motivo_visita"] : NULL;
    $identificador = gerarIdentificador($dbDB);
    if (validaCPF($cpf)) {
        // Se o CPF for válido, prossiga com a inserção no banco de dados
        inserirVisita($dbDB, $nome, $cpf, $celular, $email, $periodo_visita_de, $periodo_visita_ate, $empresa, $visitante, $area_da_visita, $integracao, $acesso_fabrica, $carro_oficina, $carro_cliente, $datawake, $observacao, $motivo_visita, $identificador);
    } else {

        echo "Erro no CPF";
    }
}
