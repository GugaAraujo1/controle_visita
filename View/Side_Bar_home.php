<?php include_once('../DB_Querys/side_Bar_homeController.php');

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../View/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Css/style-navBar-home.css">
    <link rel="stylesheet" href="../Css/home.css">
    <link rel="stylesheet" href="../Css/solicitacao.css">
    <link rel="stylesheet" href="../Css/aprovacao.css">
    <link rel="stylesheet" href="../Css/flash-message.css">
    <link rel="stylesheet" href="../Css/Responsive/responsiveHome.css">
    <link rel="icon" type="image/x-icon" href="../Img/Logo_P.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>Home</title>
</head>

<body class=" d-flex flex-row ">

    <div class="d-flex menu-css flex-column ">
        <img src="../Img/Logo sem Fundo.png" alt="Logo Paranoá" class="mt-5 col-sm-11 ps-2">
        <div class="d-flex flex-column sub-menu col-sm-12">
            <a href="./home.php" class="text-decoration-none">
                <div class="icon-home-css">
                    <span id="icon-text-home" class=" m-0 " for="mudar-thema">
                        <div class="col-sm-4  d-flex flex-row justify-content-center align-items-center">
                            <i class="fa-solid fa-house icon-large" style="color: #ffffff;"></i>
                        </div>
                        <p class="m-0 font-header">Home</p>
                    </span>
                </div>
            </a>


            <a href="solicitacao.php" class="text-decoration-none">
                <div class="icon-home-css">
                    <span id="icon-text-home" class="m-0" for="mudar-thema">
                        <div class="col-sm-4  d-flex flex-row justify-content-center align-items-center">
                            <i class="fa-solid fa-magnifying-glass-plus icon-large" style="color: #ffffff;"></i>
                        </div>
                        <p class="m-0 font-header">Solicitação</p>
                    </span>
                </div>
            </a>

            <a href="solicitacao_entrevista.php" class="text-decoration-none">
                <div class="icon-home-css">
                    <span id="icon-text-home" class="m-0" for="mudar-thema">
                        <div class="col-sm-4  d-flex flex-row justify-content-center align-items-center">
                            <i class="fa-regular fa-address-book icon-large" style="color: #ffffff;"></i>
                        </div>
                        <p class="m-0 font-header">Solicitação Entrevista</p>
                    </span>
                </div>
            </a>

            <?php
            // Verificar se o usuário tem permissão de acesso à seção, Se o usuário for diretor ou gestor, eles têm permissão de acesso
            if (isset($acesso)) { ?>
                <a href="aprovacao.php" class="text-decoration-none">
                    <div class="icon-home-css">
                        <span id="icon-text-home" class="m-0" for="mudar-thema">
                            <div class="col-sm-4 d-flex flex-row justify-content-center align-items-center">
                                <i class="fa-solid fa-user-check icon-large" style="color: #ffffff;"></i>
                            </div>
                            <p class="m-0 font-header">Aprovação</p>
                        </span>
                    </div>
                </a>
            <?php
            } else {
                echo "";
            }
            ?>

            <div class="icon-home-css">
                <input type="checkbox" name="mudar-thema" id="mudar-thema">
                <label id="icon-text-home" class="m-0" for="mudar-thema">
                    <div class="col-sm-4 d-flex flex-row justify-content-center align-items-center">
                        <i class="fa-solid fa-moon icon-large" style="color: #ffffff;" id="modo-icon"></i>
                    </div>
                    <p class="m-0 font-header" id="modo-text">Modo Noturno</p>
                </label>
            </div>

            <a href="../DB_Querys/logout.php" class=" d-flex flex-row text-decoration-none mt-3 link-sair-css">
                <div class="col-sm-3 d-flex flex-row justify-content-center align-items-center ps-3">
                    <i class="fa-solid fa-arrow-right-from-bracket icon-large" style="color: #ffffff;"></i>
                </div>
                <p class="m-0 ms-2"><span class=" font-header text-logout">Sair</span></p>
            </a>
        </div>

        <script src="../Js/style-navBar-home.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    </div>
</body>

</html>