<?php
include_once('../BD_Conncetion/connection.php');

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../View/login.php");
    exit;
}


// Faz a paginaçao da tabela sepra de 5 em 5 a consulta
$paginaAtual = 1;
$limite = 5;


if(isset($_GET['paginaAtual'])) { 
    $paginaAtual = filter_input(INPUT_GET, "paginaAtual", FILTER_VALIDATE_INT);
} else {
    $paginaAtual = 1;
}

if($paginaAtual){

    $inicio = ($paginaAtual * $limite) - $limite;
    
    $consulta = $dbDB->prepare("SELECT * FROM Visitante ORDER BY  id OFFSET $inicio ROWS FETCH NEXT $limite ROWS ONLY");
    $consulta->execute();
    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    
    $consultaContagem  =$dbDB->query("SELECT COUNT(id) as count FROM Visitante")->fetch();
    $registro = $consultaContagem['count'];
    $paginas = ceil($registro / $limite);
    
}

// FAZ A PESQUISA NA TABELA 
if (isset($_GET['pesquisar']) && !empty($_GET['pesquisar'])) {
    $pesquisa = '%' . strtolower($_GET['pesquisar']) . '%'; // Converter para minúsculas
    $consulta = $dbDB->prepare("SELECT * FROM Visitante WHERE LOWER(visitante) LIKE ? OR LOWER(nome) LIKE ? ORDER BY id OFFSET $inicio ROWS FETCH NEXT $limite ROWS ONLY");
    $consulta->execute([$pesquisa, $pesquisa]);
} else {
    $consulta = $dbDB->prepare("SELECT * FROM Visitante ORDER BY id OFFSET $inicio ROWS FETCH NEXT $limite ROWS ONLY");
    $consulta->execute();
}
$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);