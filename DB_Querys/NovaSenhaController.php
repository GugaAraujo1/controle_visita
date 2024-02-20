<?php

include_once('../BD_Conncetion/connection.php');

$email = "";
$senha = "";
$senhaRepetida = "";
$senhaErro = "";
$emailErro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $emailErro = "";
    $email = trim($_POST["email"]);
    $senhaErro = "";
    $senha = $_POST["senha"];
    $senhaRepetida = $_POST["senhaRepetida"];

    if ($email && $senha && $senhaRepetida) {

        getPost($dbDB, $email, $senha, $senhaRepetida);
    }
}

function getPost($dbDB, $email, $senha, $senhaRepetida)
{
    global $emailErro, $email, $senhaErro, $senha, $senhaRepetida, $senha_hash;

    if (empty(trim($_POST["email"]))) {
        $emailErro = "Por favor, coloque um email válido";
    }
    if (empty(trim($_POST["senha"])) && empty(trim($_POST["senhaRepetida"]))) {
        $senhaErro = "Por favor, insira uma senha";
    } elseif (strlen(trim($_POST["senha"])) < 6 && strlen(trim($_POST["senhaRepetida"])) < 6) {
        $senhaErro = "A senha deve ter pelo menos 6 caracteres";
    } elseif (trim($_POST["senha"]) !== trim($_POST["senhaRepetida"])) {
        $senhaErro = "As senhas não são iguais. Por favor, digite a mesma senha nos dois campos.";
    } else {
        $senha;
        $senhaRepetida;
        $senha_hash = trim(password_hash($senha, PASSWORD_DEFAULT));
        $senha_hash_repetida = trim(password_hash($senhaRepetida, PASSWORD_DEFAULT));
    }

    if (empty($emailErro) && empty($senhaErro)) {
        updatekey($dbDB, $email, $emailErro, $senha, $senhaRepetida, $senha_hash_repetida);
    }
}

function updatekey($dbDB, $email, $emailErro, $senha, $senhaRepetida, $senha_hash_repetida)
{
    global $emailErro;
    if ($senha === $senhaRepetida) {
        $verificarEmail = $dbDB->prepare("SELECT * FROM usuarios WHERE email = :email");
        $verificarEmail->bindParam(':email', $email);
        $verificarEmail->execute();
        $verificado = $verificarEmail->fetchColumn();

        if ($verificado > 0) {
            $inserir = $dbDB->prepare("UPDATE usuarios SET senha = :senha WHERE email = :email ");
            $inserir->bindParam(':email', $email);
            $inserir->bindParam(':senha', $senha_hash_repetida);
            if ($inserir->execute()) {
                header("Location: ../View/login.php");
            }
        } else {
            $emailErro = "Email não foi encontrado";
        }
    }
}
