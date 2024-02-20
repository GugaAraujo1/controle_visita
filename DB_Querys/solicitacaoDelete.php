<?php
include_once('../BD_Conncetion/connection.php');

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    deletarVisita($id, $dbDB);
}
function deletarVisita($id, $dbDB)
{
    $verdica_Registro = $dbDB->prepare("SELECT * FROM Registro_da_Visita WHERE id_Visitante = :id ");
    $verdica_Registro->bindValue(':id', $id, PDO::PARAM_STR);
    $verdica_Registro->execute();
    $registro_Verificado = $verdica_Registro->fetch();

    if ($registro_Verificado > 0) {
        $verdica_Data = $dbDB->prepare("SELECT * FROM Visitante WHERE id = :id ");
        $verdica_Data->bindValue(':id', $id, PDO::PARAM_STR);
        $verdica_Data->execute();
        $verificado = $verdica_Data->fetch();
        $periodo_visita_de = $verificado['periodo_visita_de'];

        $_SESSION['deletar_Visitas'] = "Essa visita foi realizada no dia " . date('d/m/Y', strtotime($periodo_visita_de)) . ". Deseja excluir?";
        $_SESSION['excluir'] = $id; // Armazena o ID a ser excluído na sessão
        header("Location: ../View/home.php");
    } else {
        //  Verificar se o registro já foi aprovado ou reprovado
        $verifica_aprovacao = $dbDB->prepare("SELECT COUNT(id) FROM aprovacao WHERE id_visitante = :id");
        $verifica_aprovacao->bindValue(':id', $id, PDO::PARAM_INT);
        $verifica_aprovacao->execute();
        $aprovacao_verificada = $verifica_aprovacao->fetchColumn();

        if ($aprovacao_verificada > 0) {
            $_SESSION['Erro_Para_deletar_Aprovados'] = "Essa visita já foi aprovada. Deseja excluir mesmo assim?";
            $_SESSION['id_a_excluir'] = $id; // Armazena o ID a ser excluído na sessão
            header("Location: ../View/home.php");
            exit;
        } else {
            $deleteAprovado = $dbDB->prepare("DELETE FROM Visitante WHERE id = :id");
            $deleteAprovado->bindValue(':id', $id, PDO::PARAM_INT);
            if ($deleteAprovado->execute()) {
                $_SESSION['deletado'] = "Visita foi deletada com sucesso";
                header("Location: ../View/home.php");
                exit;
            } else {
                echo "Erro ao excluir o registro.";
            }
        }
    }
}

if (isset($_GET['id_aprovado'])) {
    $id_a_excluir = $_SESSION['id_a_excluir'];
    deletarVisitasAprovadas($id_a_excluir, $dbDB);
}

function deletarVisitasAprovadas($id_a_excluir, $dbDB)
{
    $delete_aprovacao = $dbDB->prepare("DELETE FROM aprovacao WHERE id_visitante = :id_visitante");
    $delete_aprovacao->bindValue(':id_visitante', $id_a_excluir, PDO::PARAM_INT);

    if ($delete_aprovacao->execute()) {
        // Exclua o registro da tabela "Visitante"
        $delete_visitante = $dbDB->prepare("DELETE FROM Visitante WHERE id = :id");
        $delete_visitante->bindValue(':id', $id_a_excluir, PDO::PARAM_INT);
        $delete_visitante->execute();
        $_SESSION['deletado'] = "Visita foi deletada com sucesso";
        header("Location: ../View/home.php");
        exit;
    }
}

// Exclua o registro da tabela "aprovacao"

function deletarVisitasRegistradas($id_excluir_Regitro, $dbDB)
{
    $delete_registro = $dbDB->prepare("DELETE FROM Registro_da_Visita WHERE id_Visitante = :id_visitante");
    $delete_registro->bindValue(':id_visitante', $id_excluir_Regitro, PDO::PARAM_INT);

    if ($delete_registro->execute()) {
        // Exclua o registro da tabela "aprovacao"
        $delete_aprovacao = $dbDB->prepare("DELETE FROM aprovacao WHERE id_visitante = :id_visitante");
        $delete_aprovacao->bindValue(':id_visitante', $id_excluir_Regitro, PDO::PARAM_INT);
        $delete_aprovacao->execute();

        // Exclua o registro da tabela "Visitante"
        $delete_visitante = $dbDB->prepare("DELETE FROM Visitante WHERE id = :id");
        $delete_visitante->bindValue(':id', $id_excluir_Regitro, PDO::PARAM_INT);
        $delete_visitante->execute();

        $_SESSION['deletado'] = "Visita foi deletada com sucesso";
        header("Location: ../View/home.php");
        exit;
    }
}
if (isset($_GET['excluir_Registro'])) {
    $id_excluir_Regitro = $_SESSION['excluir'];;
    deletarVisitasRegistradas($id_excluir_Regitro, $dbDB);
}
