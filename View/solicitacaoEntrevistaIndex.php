<?php
require_once 'Side_Bar_home.php';
require_once '../DB_Querys/home_Paginacao_Tabela.php';
require_once '../DB_Querys/solicitacaoUpdate.php';


if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../View/login.php");
    exit;
}
?>


<div class="col d-flex justify-content-center">
    <div class="d-flex flex-column col align-items-center">
        <div class="d-flex border-0 mt-5 mb-5 col-sm-10 justify-content-between bg-transparent">
            <div class="d-flex justify-content-start align-items-center text-dark">
                <span class="titulo">
                    Solicitação de entrevista
                </span>
            </div>
            <div class="d-flex align-items-center justify-content-end" id="div_img">
                <img src="" alt="">
            </div>
        </div>

        <div class=" d-flex col-sm-10 mb-5 bg-form-css align-items-center justify-content-around p-0 ">
            <form action="../DB_Querys/solicitacaoUpdate.php" onsubmit="return validarForm_Update()" method="post" class=" col-sm-12 d-flex flex-column pt-4 align-items-center" id="form_Update">
                <div class="col-sm-10 d-flex justify-content-around p-0 m-0">

                    <?php if (isset($resultadoRead)) { ?>
                        <div class="d-flex flex-column col-sm-5 p-0">
                            <input type="hidden" id="id" class="input-css" name="id" value="<?= $resultadoRead['id']; ?>">

                            <label class="label-css" for="visitante">Nome do visitante:</label>
                            <input type="text" id="visitante" class="input-css" name="nome" value="<?= $resultadoRead['nome']; ?>">

                            <label class="label-css" for="cpf">CPF do visitante:</label>
                            <input type="text" placeholder="Nome completo" id="cpf_Input_Update" required class="input-css" minlength="11" maxlength="11" name="cpf" value="<?= $resultadoRead['cpf']; ?>" required>
                            <div id="resultado_Div_Update"></div>

                            <label class="label-css" for="celular">Celular do visitante:</label>
                            <input type="text" id="celular" class="input-css" name="celular" value="<?= $resultadoRead['celular']; ?>">
                        </div>
                        <div class="d-flex flex-column col-sm-5 p-0">

                            <label class="label-css" for="email"> Email do visitante:</label>
                            <input type="email" id="email" class="input-css" name="email" value="<?= $resultadoRead['email']; ?>">

                            <label class="label-css" for="periodo_visita_de">Período de Visita (de):</label>
                            <input type="datetime-local" id="periodo_visita_de" class="input-css" name="periodo_visita_de" value="<?= date("Y-m-d H:i", strtotime($resultadoRead['periodo_visita_de'])) ?>">

                        </div>
                    <?php } ?>
                </div>
                <div class="d-flex justify-content-center mt-4 mb-4  col-sm-12">
                    <input type="submit" value="Editar" class="btn-submit-css mt-3 ">
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../Js/solicitacao.js" crossorigin="anonymous"></script>