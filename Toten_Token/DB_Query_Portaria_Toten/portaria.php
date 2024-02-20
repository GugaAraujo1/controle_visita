<?php
include_once('../../BD_Conncetion/connection.php');
// require_once('../../vendor/autoload.php');
//  $client = new \GuzzleHttp\Client();

$confirmacao = "";
$id_Visitante = "";
$token = "";
if (isset($_GET['id'])) {
    $id_Visitante = $_GET['id'];

    return getVisita($dbDB, $id_Visitante);
} else {
    return "Nenhum resultado encontrado.";
}


function getVisita($dbDB, $id_Visitante)
{
    $pesquisar = $dbDB->prepare("SELECT COUNT(id_Visitante) AS count FROM Registro_da_Visita WHERE id_Visitante = :id_Visitante");
    $pesquisar->bindParam(':id_Visitante', $id_Visitante);
    $pesquisar->execute();
    $select = $pesquisar->fetch(PDO::FETCH_ASSOC)['count'];

    if ($select > 0) {
        $_SESSION['visita_confirmada'] = "Estamos a caminho para ajudá-lo, aguarde um momento";
        header("Location: ../../index.php");
    } else {
        if (isset($_SESSION['token'])) {
            $token = $_SESSION['token'];

            $verificarToken = $dbDB->prepare("SELECT id, cpf FROM Visitante WHERE id = :id_Visitante AND cpf = :cpf");
            $verificarToken->bindParam(':id_Visitante', $id_Visitante);
            $verificarToken->bindParam(':cpf', $token);
            $verificarToken->execute();
            $visitante = $verificarToken->fetch(PDO::FETCH_ASSOC);

            if ($visitante) {
                $id_Visitante;
                $token;
                return  insertInto($dbDB, $id_Visitante);
            } else {
                $_SESSION['visita_confirmada'] = "Você está tentando confirmar uma visita que não é sua ou o token está incorreto";
                header("Location: ../../index.php");
            }
        } else {
            $_SESSION['visita_confirmada'] = "Você está tentando confirmar uma visita que não é sua ou o token está incorreto";
            header("Location: ../../index.php");
        }
    }
}

function insertInto($dbDB, $id_Visitante)
{
    if (!empty($id_Visitante)) {
        $confirmar = $dbDB->prepare("INSERT INTO Registro_da_Visita (id_Visitante) VALUES (:id_Visitante)");
        $confirmar->bindParam(':id_Visitante', $id_Visitante);
        $confirmar->execute();
        $_SESSION['MensagemPortaria'] = "Nossa equipe recebeu sua solicitação e já está indo ao seu encontro";
        header("Location: ../../index.php");
    } else {
        $_SESSION['visita_confirmada'] = "Você está tentando confirmar uma visita que não é sua ou o token está incorreto";
        header("Location: ../../index.php");
    }
}
