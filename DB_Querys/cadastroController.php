<?php
include_once('../BD_Conncetion/connection.php');

$allCargo = $dbDB->prepare("SELECT * FROM Cargos ORDER BY id ASC");
$allCargo->execute();
$cargos = $allCargo->fetchAll(PDO::FETCH_ASSOC);


// criando cadastro e validando dados

$nome = "";
$email = "";
$senha = "";
$celular = "";
$usuarioErro = "";
$senhaErro = "";
$emailErro = "";
$usuarioExiste = "";
$selectErro = "";
$celularErro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (empty(trim($_POST["nome"]))) {
        $usuarioErro = "Por favor, coloque um nome de usuário";
    } else {
        $nome = trim($_POST["nome"]);
    }

    if (empty(trim($_POST["celular"]))) {
        $celularErro = "Por favor, coloque um número de celular válido";
    } else {
        $celular = trim($_POST["celular"]);
    }

    if (empty(trim($_POST["email"]))) {
        $emailErro = "Por favor, coloque um email válido";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty($_POST["cargoid"])) {
        $selectErro = "Selecione sua função";
    } else {
        $cargoid = $_POST["cargoid"];
    }

    if (empty(trim($_POST["senha"]))) {
        $senhaErro = "Por favor, insira uma senha";
    } elseif (strlen(trim($_POST["senha"])) < 6) {
        $senhaErro = "A senha deve ter pelo menos 6 caracteres";
    } else {
        $senha = $_POST["senha"];
        $senha_hash = trim(password_hash($senha, PASSWORD_DEFAULT));
    }

    if (empty($usuarioErro) && empty($emailErro) && empty($selectErro) && empty($senhaErro) && empty($celularErro)) {
        // Verifica se o email já existe no banco de dados
        $verificarUser = $dbDB->prepare("SELECT email FROM usuarios WHERE email = :email");
        $verificarUser->bindParam(':email', $email);
        $verificarUser->execute();
        $resultado = $verificarUser->fetchAll(PDO::FETCH_ASSOC);

        if ($verificarUser->rowCount() >= 1) {
            $usuarioExiste = "Você já tem um cadastro com esse email";
        } else {
            // Realiza a inserção no banco de dados
            $inserir = $dbDB->prepare("INSERT INTO usuarios (nome, celular, cargoid, email, senha) VALUES (:nome, :celular, :cargoid, :email, :senha)");
            $inserir->bindParam(':nome', $nome);
            $inserir->bindParam(':celular', $celular);
            $inserir->bindParam(':cargoid', $cargoid);
            $inserir->bindParam(':email', $email);
            $inserir->bindParam(':senha', $senha_hash);
            $inserir->execute();

            header("Location: login.php");
        }
    }
}
