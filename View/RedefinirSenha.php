<?php
include_once('../DB_Querys/NovaSenhaController.php'); 
?>
<!DOCTYPE html>

<html lang="pt-BR">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../Css/login.css">
        <script src="script.js"></script>
        <title>Login</title>
    </head>
    <body class="">
        <div class=" col-sm-12 col-md-12 col-lg-12 d-flex flex-row color_bg">
            <div class="d-flex justify-content-center align-items-center col-sm-5 col-md-5 col-lg-5 color_bg2 ">
                <img src="../Img/Logo sem Fundo.png " alt="Logo sem Fundo" class="col-sm-10">
            </div>
            <div class="d-flex flex-column col-sm-7 col-md-7 col-lg-7 justify-content-center align-items-center">
                <div class="background_DataWake d-flex flex-column justify-content-center align-items-center ">
                    <div class="circulo d-flex justify-content-center align-items-center shadow  ">
                        <img src="../Img/P_logo.svg" alt="">
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="d-flex flex-column form-input">

                        <input type="email" name="email" id="" placeholder="Seu Email:" class="form-control shadow  <?php echo (!empty($emailErro)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                        <span class="invalid-feedback"><?php echo $emailErro; ?></span>

                        <input type="password" name="senha" placeholder="Senha" class="form-control shadow <?php echo (!empty($senhaErro)) ? 'is-invalid' : ''; ?>" value="<?php echo $senha; ?>">
                        <span class="invalid-feedback"><?php echo $senhaErro; ?></span>

                        <input type="password" name="senhaRepetida" placeholder="Repetir Senha" class="form-control shadow <?php echo (!empty($senhaErro)) ? 'is-invalid' : ''; ?>" value="<?php echo $senhaRepetida; ?>">
                        <span class="invalid-feedback"><?php echo $senhaErro; ?></span>

                        <button type="submit" class="shadow login-button">Redefinir Senha</button>
                        <button class="btn btn-danger rounded-pill col-sm-4 mt-3"><a href="login.php" class="text-white  ">Cancelar</a></button>
                    </form>
                   
                </div>
            </div>
        </div>
    </body>
</html>
