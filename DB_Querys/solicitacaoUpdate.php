<?php
include_once('../BD_Conncetion/connection.php');

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../View/login.php");
    exit;
}

////////// READ SOLICITACAOINDEX.PHP ///////////////
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $read = $dbDB->prepare("SELECT * FROM Visitante WHERE id = :id");
    $read->bindValue(':id', $id, PDO::PARAM_INT);
    $read->execute();
    $resultadoRead = $read->fetch(PDO::FETCH_ASSOC);
}

function validaCPF($cpf)
{
    if ($_POST["cpf"]) {
        $cpf = $_POST["cpf"];

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
    }
    // Remove caracteres não numéricos

    return true;
    // Faz o cálculo para validar o CPF

}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtenha os dados do formulário POST
    $id = $_POST['id'];
    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $celular = $_POST["celular"];
    $email = $_POST["email"];
    $periodo_visita_de = date('Y-m-d H:i', strtotime($_POST["periodo_visita_de"]));
    $periodo_visita_ate = isset($_POST["periodo_visita_ate"]) ? date('Y-m-d H:i', strtotime($_POST["periodo_visita_ate"])) : null;
    $empresa = isset($_POST["empresa"]) ? $_POST["empresa"] : '';
    $visitante = isset($_POST["visitante"]) ? $_POST["visitante"] : '';
    $area_da_visita = isset($_POST["area_da_visita"]) ? $_POST["area_da_visita"] : '';
    $integracao = isset($_POST["confirmar_integracao"]) ? 1 : 0;
    $acesso_fabrica = isset($_POST["acesso_fabrica"]) ? 1 : 0;
    $carro_oficina = isset($_POST["carro_oficina"]) ? 1 : 0;
    $carro_cliente = isset($_POST["carro_cliente"]) ? 1 : 0;
    $datawake = isset($_POST["datawake"]) ? 1 : 0;
    $observacao = isset($_POST["observacao"]) ? $_POST["observacao"] : '';
    $motivo_visita = isset($_POST["motivo_visita"]) ? $_POST["motivo_visita"] : NULL;
    // Faça a atualização dos dados usando a função updateVisita
    if (validaCPF($cpf)) {
        $updateSuccess = updateVisita($dbDB, $id, $nome, $cpf, $celular, $email, $periodo_visita_de, $periodo_visita_ate, $empresa, $visitante, $area_da_visita, $integracao, $acesso_fabrica, $carro_oficina, $carro_cliente, $datawake, $observacao, $motivo_visita);
    } else {
        echo "Erro no CPF";
    }
    // Verifique se a atualização foi bem-sucedida
    if ($updateSuccess) {
        // Processar a aprovação, se necessário
        processarAprovacao($dbDB, $id, $acesso_fabrica);
    } else {
        echo "Erro";
    }
}

function updateVisita(
    $dbDB,
    $id,
    $nome,
    $cpf,
    $celular,
    $email,
    $periodo_visita_de,
    $periodo_visita_ate,
    $empresa,
    $visitante,
    $area_da_visita,
    $integracao,
    $acesso_fabrica,
    $carro_oficina,
    $carro_cliente,
    $datawake,
    $observacao,
    $motivo_visita
) {

    $update = $dbDB->prepare("UPDATE Visitante SET 
        nome = :nome,
        cpf = :cpf,
        celular = :celular,
        email = :email,
        periodo_visita_de = :periodo_visita_de,
        periodo_visita_ate = :periodo_visita_ate,
        empresa = :empresa,
        visitante = :visitante,
        area_da_visita = :area_da_visita,
        integracao = :integracao,
        acesso_fabrica = :acesso_fabrica,
        carro_oficina = :carro_oficina,
        carro_cliente = :carro_cliente,
        datawake = :datawake,
        observacao = :observacao,
        motivo_visita = COALESCE(:motivo_visita, motivo_visita)
        WHERE id = :id");

    $update->bindValue(':id', $id, PDO::PARAM_INT);
    $update->bindValue(':nome', $nome, PDO::PARAM_STR);
    $update->bindValue(':cpf', $cpf, PDO::PARAM_STR);
    $update->bindValue(':celular', $celular, PDO::PARAM_STR);
    $update->bindValue(':email', $email, PDO::PARAM_STR);
    $update->bindValue(':periodo_visita_de', $periodo_visita_de, PDO::PARAM_STR);
    $update->bindValue(':periodo_visita_ate', $periodo_visita_ate, PDO::PARAM_STR);
    $update->bindValue(':empresa', $empresa, PDO::PARAM_STR);
    $update->bindValue(':visitante', $visitante, PDO::PARAM_STR);
    $update->bindValue(':area_da_visita', $area_da_visita, PDO::PARAM_STR);
    $update->bindValue(':integracao', $integracao, PDO::PARAM_BOOL);
    $update->bindValue(':acesso_fabrica', $acesso_fabrica, PDO::PARAM_BOOL);
    $update->bindValue(':carro_oficina', $carro_oficina, PDO::PARAM_BOOL);
    $update->bindValue(':carro_cliente', $carro_cliente, PDO::PARAM_BOOL);
    $update->bindValue(':datawake', $datawake, PDO::PARAM_BOOL);
    $update->bindValue(':observacao', $observacao, PDO::PARAM_STR);
    $update->bindValue(':motivo_visita', $motivo_visita, PDO::PARAM_STR);
    if ($update->execute()) {
        return true;
    } else {
        return false;
    }
}

function processarAprovacao($dbDB, $id, $acesso_fabrica)
{
    $query = $dbDB->prepare("SELECT COUNT(id) FROM aprovacao WHERE id_visitante = :id_visitante");
    $query->bindValue(':id_visitante', $id, PDO::PARAM_INT);
    $query->execute();
    $resultado = $query->fetchColumn();

    if ($acesso_fabrica == 0) {
        if ($resultado <= 0) {
            $id_usuario = $_SESSION["id"];
            $insertInto = $dbDB->prepare("INSERT INTO aprovacao (id_visitante, id_usuario, aprovado_reprovado) VALUES (:resultados, :id_usuario, 'on' )");
            $insertInto->bindParam(':id_usuario', $id_usuario);
            $insertInto->bindParam(':resultados', $id);
            $insertInto->execute();
            $_SESSION['atualizado_sucesso'] = "Visita foi atualizada e aprovada com sucesso";
            header("Location: ../View/home.php");
            exit;
        } else {
            //Deleta o formulario da tabela aprovação assim que edita o mesmo 
            $atualizando = $dbDB->prepare("DELETE FROM aprovacao WHERE id_visitante = :id_visitante");
            $atualizando->bindValue(':id_visitante', $id, PDO::PARAM_INT);
            if ($atualizando->execute()) {
                $_SESSION['atualizado_sucesso'] = "Visitantes que foram editados, precisam ser aprovados novamente.";
                header("Location: ../View/home.php");
                exit;
            } else {
                echo "Erro ao excluir o registro.";
            }
        }
    } elseif ($resultado > 0) {
        //Deleta o formulario da tabela aprovação assim que edita o mesmo 
        $atualizando = $dbDB->prepare("DELETE FROM aprovacao WHERE id_visitante = :id_visitante");
        $atualizando->bindValue(':id_visitante', $id, PDO::PARAM_INT);
        if ($atualizando->execute()) {
            $_SESSION['atualizado_sucesso'] = "Visitantes aprovados, mas que foram editados, precisam ser aprovados novamente.";
            header("Location: ../View/home.php");
        } else {
            echo "Erro ao excluir o registro.";
        }
    } else {
        $_SESSION['atualizado_sucesso'] = "Atualizado com sucesso";
        header("Location: ../View/home.php");
    }
}
