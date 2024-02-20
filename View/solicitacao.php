<?php require_once 'Side_Bar_home.php';

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
                    Solicitação de visita
                </span>
            </div>
            <div class="d-flex align-items-center justify-content-end" id="div_img">
                <img src="" alt="">
            </div>
        </div>
        <div class="bg-form-css d-flex  col-sm-10 mb-5  ">
            <form id="myForm" action="../DB_Querys/solicitacaoController.php" method="post" class="col-sm-12 d-flex flex-column pt-4" onsubmit="return validarForm()">
                <div class="d-flex flex-row justify-content-around">
                    <div class="d-flex flex-column col-sm-5 ">
                        <label class="label-css" for="visitante">Nome do visitante:</label>
                        <input type="text" placeholder="Nome completo" id="visitante" class="input-css" name="visitante" required>

                        <label class="label-css" for="cpf">CPF do visitante:</label>
                        <input type="text" placeholder="Nome completo" id="cpf" class="input-css" minlength="11" maxlength="11" name="cpf" required>
                        <div id="resultado"></div>

                        <label class="label-css" for="celular">Celular do visitante:</label>
                        <input type="text" id="celular" class="input-css" name="celular" required placeholder="celular">

                        <label class="label-css" for="email">Email do visitante:</label>
                        <input type="email" id="email" class="input-css" name="email" placeholder="email">

                        <label class="label-css" for="periodo_visita_de">Período de visita (de):</label>
                        <input type="datetime-local" id="periodo_visita_de" class="input-css" name="periodo_visita_de" required>

                        <label class="label-css" for="periodo_visita_ate">Período de visita (até):</label>
                        <input type="datetime-local" id="periodo_visita_ate" class="input-css" name="periodo_visita_ate" required>
                    </div>

                    <div class="d-flex flex-column col-sm-5">
                        <label class="label-css" for="nome">Responsável pela visita:</label>
                        <input type="text" id="nome" class="input-css" placeholder="Nome" name="nome" required>

                        <label class="label-css" for="empresa">Empresa:</label>
                        <input type="text" id="empresa" class="input-css" name="empresa" placeholder="Nome">

                        <input type="hidden" id="identificador" class="input-css" name="identificador">

                        <label for="observacao" class="label-css">Objetivo da visita:</label>
                        <textarea id="observacao" class="input-textarea-css mb-1" name="observacao"></textarea>

                        <select name="motivo_visita" id="motivo_visita" required>
                            <option selected disabled>Selecione o motivo da visita</option>
                            <option value="Visita">Visita</option>
                            <option value="Prestador de serviço">Prestador de serviço</option>
                        </select>

                        <div class="d-flex align-items-center mt-3 mb-2" id="integracao">

                        </div>

                        <div class="d-flex align-items-center mt-2">
                            <label class="pe-2  label-acesso-css" for="acesso_fabrica">Acesso à fábrica:</label>
                            <input type="checkbox" id="acesso_fabrica" class="inputBox-css" name="acesso_fabrica">
                        </div>

                        <label class="label-css display-none" id="area_visita" for="area_da_visita">Área da visita:</label>
                        <input type="text" id="area_da_visita" class="input-css display-none" name="area_da_visita">

                        <div class="d-flex align-items-center mt-3">
                            <label class="pe-2 label-acesso-css" for="carro_oficina">Carro Oficina:</label>
                            <input type="checkbox" id="carro_oficina " class="inputBox-css " name="carro_oficina">
                        </div>

                        <div class="d-flex align-items-center mt-3">
                            <label class="pe-2 label-acesso-css" for="carro_cliente">Carro cliente:</label>
                            <input type="checkbox" id="carro_cliente" class="inputBox-css" name="carro_cliente">
                        </div>

                        <div class="d-flex align-items-center mt-3">
                            <label class="pe-2 label-acesso-css" for="datawake ">Visita Datawake:</label>
                            <input type="checkbox" id="datawake " class="inputBox-css " name="datawake">
                        </div>

                    </div>
                </div>

                <div class="d-flex justify-content-center mt-4 mb-4">
                    <input type="submit" value="Enviar" class="btn-submit-css mt-3 " onsubmit="validarForm(event)">
                </div>
            </form>
        </div>
    </div>
</div>



<?php
if (isset($_SESSION['sucesso'])) {
?>
    <div class="alert position-absolute flash-message">
        <div class="flash-message-child p-4">
            <i class="fa-solid fa-circle-check" style="color: #08d415; font-size: 5rem;"></i>

            <div class="d-flex flex-column justify-content-between align-items-center mt-4">
                <p class="font-flash-message">
                    Sucesso
                </p>
                <span class="font-css">
                    <?php
                    echo $_SESSION['sucesso'];
                    unset($_SESSION['sucesso']);
                    ?>
                </span>
            </div>

            <div class="d-flex flex-row justify-content-around col-sm-7 mt-4">
                <button type="submit" class="btn btn-danger col-sm-5" data-bs-dismiss="alert" aria-label="Close">Fechar</button>
            </div>
        </div>
    </div>

<?php
}
?>
<script src="../Js/solicitacao.js" crossorigin="anonymous"></script>