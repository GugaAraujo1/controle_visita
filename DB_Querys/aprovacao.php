<?php
include_once('../BD_Conncetion/connection.php');


if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../View/login.php");
    exit;
}

$id_usuario = "";
$resultados = "";
$aprovado = "";
$aprovacaoErro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_usuario = $_SESSION["id"];
    $resultados =  $_POST["id_visitante"];
    $aprovado = $_POST["aprovado"];
    $aprovacaoErro = "";
    aprovacao($dbDB, $id_usuario, $resultados, $aprovado, $aprovacaoErro);
}


function aprovacao($dbDB, $id_usuario, $resultados, $aprovado, $aprovacaoErro)
{
    $count_id_visitante = $dbDB->prepare("SELECT COUNT(id_visitante) AS count FROM aprovacao WHERE id_visitante = :resultados");
    $count_id_visitante->bindParam(':resultados', $resultados);
    $count_id_visitante->execute();
    $count_total = $count_id_visitante->fetch(PDO::FETCH_ASSOC)['count'];


    if ($count_total > 0) {
        echo $aprovacaoErro = "vc já aprovou ou reprovou essa visita";
    } else {
        if ($aprovado ===  NULL) {
            $deleteQuery = $dbDB->prepare("DELETE FROM aprovacao WHERE aprovado_reprovado IS NULL");
            $deleteQuery->execute();

            $deletevisitante = $dbDB->prepare("DELETE FROM Visitante WHERE id = :resultados");
            $deletevisitante->bindParam(':resultados', $resultados);
            $deletevisitante->execute();

            $_SESSION['danger'] = "Visitas reprovadas são automaticamente deletadas";
            header("location: ../View/aprovacao.php");
        } else {
            $insertInto = $dbDB->prepare("INSERT INTO aprovacao (id_visitante, id_usuario, aprovado_reprovado) VALUES (:resultados, :id_usuario, :aprovado )");
            $insertInto->bindParam(':id_usuario', $id_usuario);
            $insertInto->bindParam(':resultados', $resultados);
            $insertInto->bindParam(':aprovado', $aprovado);

            if ($insertInto->execute()) {

                $consulta_numero = $dbDB->prepare("SELECT * FROM Visitante WHERE id = :id_visitante");
                $consulta_numero->bindParam(':id_visitante', $resultados);
                $consulta_numero->execute();
                $consulta = $consulta_numero->fetch(PDO::FETCH_ASSOC);

                if ($consulta) {

                    $nome = $consulta['nome'];

                    $celular = $consulta['celular'];

                    $identificador = $consulta['identificador'];

                    $data = $consulta['periodo_visita_de'];

                    $mensagem = "Olá " . $nome . ". A Paranoá agradece sua visita, confirmada para o dia " . $data . ". Seu código de identificação é " . $identificador . ". Por favor, apresente-o no dia da visita. Estamos ansiosos para recebê-lo(a).";


                    $_SESSION['status'] = "Visita foi aprovada.";
                    $_SESSION['mensagemAprovada'] = "Visita foi aprovada.";

                    header("location: ../View/aprovacao.php");
                }
            }
        }
    }
}


function readVisitasAprovadas($dbDB)
{
    $query = $dbDB->prepare("SELECT Visitante.* FROM aprovacao 
    JOIN Visitante ON aprovacao.id_visitante = Visitante.id WHERE Visitante.motivo_visita = 'Visita' OR Visitante.motivo_visita = 'Prestador de serviço' ORDER BY id ASC ");
    $query->execute();
    $VisitasAprovadas = $query->fetchAll(PDO::FETCH_ASSOC);

    return $VisitasAprovadas;
}

function readVisitasPendentes($dbDB)
{
    $query = $dbDB->prepare("SELECT Visitante.* FROM Visitante LEFT JOIN aprovacao 
    ON Visitante.id = aprovacao.id_visitante WHERE aprovacao.id_visitante IS NULL");
    $query->execute();
    $resultado = $query->fetchAll(PDO::FETCH_ASSOC);

    return $resultado;
}
