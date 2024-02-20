<?php

include_once('../BD_Conncetion/connection.php');

// NIVEIS DE ACESSO
$cargoid = "";

if (isset($_SESSION["cargoid"])) { //confere se cargo id esta null ou não  

    $cargoid = $_SESSION["cargoid"];   //PEGA A SESSÃO DO Cargoid QUE ESTÁ VINDO DA PAGINA LOGIN.PHP
    $allCargo = $dbDB->prepare("SELECT cargo FROM Cargos WHERE id = :cargoid");   //COMPARA O id da TABELA Cargos com Cargoid DO USUARIO LOGADO  
    $allCargo->bindParam(':cargoid', $cargoid);
    $allCargo->execute();
    $cargos = $allCargo->fetchAll(PDO::FETCH_ASSOC);

    foreach ($cargos as $cargo) {    //INTERA SOBRE A CONSULTA QUE DEVOLVE UM ARRAY 
        switch ($cargo['cargo']) {    //REGRA PRA DEFINIR O NÍVEL DE ACESSO DO USUARIO
            case 'Gestor':
                $acesso = true;
                break;
            case 'Diretor':
                $acesso = true;
                break;
        }
    }
}
