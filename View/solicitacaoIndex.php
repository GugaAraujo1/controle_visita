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
                    Solicitação de visita
                </span>
            </div>
            <div class="d-flex align-items-center justify-content-end" id="div_img">
                <img src="" alt="">
            </div>
        </div>
        <div class="bg-form-css d-flex  col-sm-10 mb-5  ">
            <form action="../DB_Querys/solicitacaoUpdate.php" onsubmit="return validarForm_Update()" method="post" class=" col-sm-12 d-flex flex-column pt-4 " id="form_Update">
                <div class="d-flex flex-row justify-content-around">
                    <div class="d-flex flex-column col-sm-5 ">
                        <?php if (isset($resultadoRead)) { ?>
                            <input type="hidden" id="id" class="input-css" name="id" value="<?= $resultadoRead['id']; ?>">

                            <label class="label-css" for="visitante">Nome do visitante:</label>
                            <input type="text" id="visitante" class="input-css" name="visitante" value="<?= $resultadoRead['visitante']; ?>">

                            <label class="label-css" for="cpf">CPF do visitante:</label>
                            <input type="text" placeholder="Nome completo" id="cpf_Input_Update" required class="input-css" minlength="11" maxlength="11" name="cpf" value="<?= $resultadoRead['cpf']; ?>" required>
                            <div id="resultado_Div_Update"></div>

                            <label class="label-css" for="celular">Celular do visitante:</label>
                            <input type="text" id="celular" class="input-css" name="celular" value="<?= $resultadoRead['celular']; ?>">

                            <label class="label-css" for="email"> Email do visitante:</label>
                            <input type="email" id="email" class="input-css" name="email" value="<?= $resultadoRead['email']; ?>">

                            <label class="label-css" for="periodo_visita_de">Período de Visita (de):</label>
                            <input type="datetime-local" id="periodo_visita_de" class="input-css" name="periodo_visita_de" value="<?= date("Y-m-d H:i", strtotime($resultadoRead['periodo_visita_de'])) ?>">

                            <label class="label-css" for="periodo_visita_ate">Período de Visita (até):</label>
                            <input type="datetime-local" id="periodo_visita_ate" class="input-css" name="periodo_visita_ate" value="<?= date("Y-m-d H:i", strtotime($resultadoRead['periodo_visita_ate'])) ?>">
                    </div>

                    <div class="d-flex flex-column col-sm-5">
                        <label class="label-css" for="nome">Responsável pela visita:</label>
                        <input type="text" id="nome" class="input-css" name="nome" value="<?= $resultadoRead['nome']; ?>">

                        <label class="label-css" for="empresa">Empresa:</label>
                        <input type="text" id="empresa" class="input-css" name="empresa" value="<?= $resultadoRead['empresa']; ?>">


                        <input type="hidden" id="identificador" class="input-css" name="identificador">

                        <label for="observacao" class="label-css">Observação:</label>
                        <textarea id="observacao" class="input-textarea-css mb-1" name="observacao"><?= $resultadoRead['observacao']; ?></textarea>

                        <label for="motivo_visita" class="label-css">Motivo da visita:</label>
                        <select name="motivo_visita" id="motivo_visita" class="m-0">
                            <option value="<?= $resultadoRead['motivo_visita']; ?>"><?= $resultadoRead['motivo_visita']; ?></option>
                            <option value="Visita">Visita</option>
                            <option value="Prestador de serviço">Prestador de serviço</option>
                        </select>



                        <div class="d-flex flex-column justify-content-around mt-4">
                            <div class="d-flex align-items-center mt-3 mb-2" id="integracao"> </div>
                            <?php ?>
                            <div class="d-flex align-items-center mb-3" id="confirmacao_update">
                                <?php
                                if ($resultadoRead['motivo_visita'] == "Prestador de serviço") { ?>

                                    <label class="pe-2 label-acesso-css" for="confirmar_integracao" id="confirmar">Fará integração?</label>
                                    <input type="checkbox" id="confirmar_integracao" class="inputBox-css" name="confirmar_integracao" <?= $resultadoRead['integracao'] ? 'checked' : ''; ?>>

                                <?php  } ?>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <label class="pe-2 label-acesso-css" for="acesso_fabrica">Acesso à Fábrica:</label>
                                <input type="checkbox" id="acesso_fabrica" class="inputBox-css" name="acesso_fabrica" <?= $resultadoRead['acesso_fabrica'] ? 'checked' : ''; ?>>
                            </div>
                            <div class="d-flex align-items-center flex-row mb-3" id="area_visita">
                                <label class="label-css" for="area_da_visita">Área da Visita:</label>
                                <input type="text" id="area_da_visita" class="input-css ms-2" name="area_da_visita" value="<?= $resultadoRead['area_da_visita']; ?>">
                            </div>

                            <div class="d-flex align-items-center mb-3">
                                <label class="pe-2 label-acesso-css " for="carro_oficina ">Carro Oficina:</label>
                                <input type="checkbox" id="carro_oficina" class="inputBox-css" name="carro_oficina" <?= $resultadoRead['carro_oficina'] ? 'checked' : ''; ?>>
                            </div>

                            <div class="d-flex align-items-center mb-3">
                                <label class="pe-2 label-acesso-css" for="carro_cliente">Carro cliente:</label>
                                <input type="checkbox" id="carro_cliente" class="inputBox-css" name="carro_cliente" <?= $resultadoRead['carro_cliente'] ? 'checked' : ''; ?>>
                            </div>

                            <div class="d-flex align-items-center">
                                <label class="pe-2 label-acesso-css" for="carro_oficina ">Visita Datawake:</label>
                                <input type="checkbox" id="datawake " class="inputBox-css " name="datawake" <?= $resultadoRead['datawake'] ? 'checked' : ''; ?>>
                            </div>
                        </div>

                    </div>
                <?php } ?>
                </div>
                <div class="d-flex justify-content-center mt-4 mb-4">
                    <input type="submit" value="Editar" class="btn-submit-css mt-3 ">
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../Js/solicitacaoUpdate.js" crossorigin="anonymous"></script>

<script src="../Js/solicitacao.js" crossorigin="anonymous"></script>