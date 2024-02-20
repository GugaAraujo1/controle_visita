<?php
include_once('../BD_Conncetion/connection.php');

// Verifica se o usuário já está logado
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: ../View/home.php");
    exit;
}

// Validação para logar o usuarios
$email = "";
$senha = "";
$senhaErro = "";
$emailErro = "";
$usuarioExiste = "";
$email_login = "";

$url_completa = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '?email=' . $email;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $emailErro = "";
    $email = ($_POST["email"]);

    $senhaErro = "";
    $senha = ($_POST["senha"]);

    login($dbDB, $email, $senha);
}

if($_SERVER["REQUEST_METHOD"] === "GET"){

    if (!empty($_GET['email'])) {
        // Obtenha e armazene o valor do parâmetro 'email'
        $email = $_GET['email'];
    
        // Exiba o endereço de e-mail
        $consulta = $dbDB->prepare('SELECT * FROM usuarios WHERE email = :email');
        $consulta->bindParam(':email', $email);
        $consulta->execute();
        $repeatemail = $consulta->fetchAll(PDO::FETCH_ASSOC);
        // Verifica se o e-mail existe na tabela de usuários
        if ($consulta->rowCount() >= 1) {
            $echo = "O e-mail '$email' está presente na tabela de usuários.";
            loginSemValidacao($dbDB, $email);
        } else {
            cadastroSemValidacao($dbDB, $email);
        }
        // Agora você pode usar $email para o que precisar
    } else {
        // Se o parâmetro 'email' não estiver presente na URL
        $echo = "O parâmetro 'email' não foi fornecido na URL.";
    }
}


function cadastroSemValidacao($dbDB, $email)
{
    $inserir = $dbDB->prepare("INSERT INTO usuarios (nome, celular, cargoid, email, senha) VALUES (NULL, NULL, 1, :email, NULL)");
    $inserir->bindParam(':email', $email);
    $inserir->execute();
    loginSemValidacao($dbDB, $email);
}
function loginSemValidacao($dbDB, $email)
{
    $verificarUser = $dbDB->prepare("SELECT * FROM usuarios WHERE email = :email");
    $verificarUser->bindParam(':email', $email);
    $verificarUser->execute();
    $resultado = $verificarUser->fetch(PDO::FETCH_ASSOC);
    if ($resultado) {
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $resultado['id'];
        $_SESSION["cargoid"] = $resultado['cargoid'];
        $_SESSION["celular"] = $resultado['celular'];
        $_SESSION["nome"] = $resultado['nome'];
        $_SESSION["loginSemValidacao"] = $email;
        header("Location: ../View/home.php");

    }
}

function login($dbDB, $email, $senha)
{
    global $senhaErro, $emailErro, $email_login, $usuarioExiste;
    if (empty(trim($email))) {
        $emailErro = "Por favor, coloque um email válido";
    }

    if (empty(trim($senha))) {
        $senhaErro = "Por favor, insira uma senha";
    }

    if (!empty($email) && !empty($senha)) {
        // Verifica se o email já existe no banco de dados
        $verificarUser = $dbDB->prepare("SELECT * FROM usuarios WHERE email = :email");
        $verificarUser->bindParam(':email', $email);
        $verificarUser->execute();
        $resultado = $verificarUser->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $email_login = $resultado['email'];
            $senha_hash_login = $resultado['senha'];
            if (password_verify($senha, $senha_hash_login)) {
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $resultado['id'];
                $_SESSION["email"] = $email;
                $_SESSION["cargoid"] = $resultado['cargoid'];
                $_SESSION["celular"] = $resultado['celular'];
                $_SESSION["nome"] = $resultado['nome'];
                header("Location: ../View/home.php");
            } else {
                $usuarioExiste = "Senha inválida";
            }
        } else {
            $usuarioExiste = "Email inválido";
        }
    }
}
