<?php
require_once 'Side_Bar_home.php';
include_once('../BD_Conncetion/connection.php');
require_once('../DB_Querys/solicitacao_entrevista.php');
$dados = readSolicitacaoEntrevista($dbDB);
$dado =   paginacao($dbDB, $paginaAtual = 1, $limite = 5);
$paginas =  $_SESSION["paginas"];


if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../View/login.php");
    exit;
}
?>

<div class="col d-flex justify-content-center">
    <div class="d-flex flex-column col align-items-center ">
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

        <div class="d-flex mt-5 mb-5 col-sm-10 justify-content-end">
            <div class="d-flex flex-row col-sm-10 justify-content-end">
                <div class="card-home-back-2 justify-content-end shadow me-4" id="cursor">
                    <div class="card-home-front-2 p-3" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <p class="m-0 text-white titulo-card">Total de entrevistas cadastradas: <?php echo count($dados) ?> </p>
                    </div>
                </div>
            </div>
        </div>

        <div class=" d-flex col-sm-10 mb-5 bg-form-css align-items-center justify-content-around p-3 ">
            <div class="col-sm-10 d-flex justify-content-around">
                <div class="d-flex flex-column col-sm-5">
                    <label class="label-css" for="nome">Nome:</label>
                    <input type="text" id="nome" class="input-css" placeholder="Nome" required>

                    <label class="label-css" for="celular">Celular:</label>
                    <input type="text" id="celular" class="input-css" placeholder="Celular">

                    <label class="label-css" for="cpf">CPF:</label>
                    <input type="text" id="cpf" class="input-css" placeholder="CPF" minlength="11" maxlength="11" required>
                    <div id="resultado_Div_Entrevista"></div>
                </div>

                <div class="d-flex flex-column col-sm-5">
                    <label class="label-css" for="email">Email:</label>
                    <input type="email" id="email" class="input-css" placeholder="Email">

                    <label class="label-css" for="periodo_visita_de">Data da entrevista:</label>
                    <input type="datetime-local" id="periodo_visita_de" class="input-css">
                </div>
            </div>

            <div class="btn btn-success d-flex align-items-center" id="btnAdd">
                <i class="fa-solid fa-plus" style="color: #ffffff;"></i>
            </div>
        </div>

        <div class="bg-form-css d-flex col-sm-10 ">
            <form action="../DB_Querys/solicitacao_entrevista.php" method="POST" class=" d-flex col-sm-12 justify-content-between ">
                <div class="d-flex flex-row justify-content-around p-3 col-sm-12">
                    <div class="d-flex flex-row col-sm-10">
                        <div class="d-flex flex-column col-sm-6" id="myForm"></div>

                        <div class="d-flex flex-column col-sm-6" id="myForm2"></div>
                    </div>
                    <div class=" d-flex align-items-center justify-content-around flex-column " id="remove-btn"></div>

                    <div class=" d-flex flex-row align-items-end justify-content-end col-sm-1">
                        <input class="btn btn-success  col-sm-12" type="submit" value="Enviar" id="btn-enviar" disabled>
                    </div>
                    <select name="motivo_visita" id="motivo_visita" class="d-none">
                        <option value="Entrevista">Entrevista</option>
                    </select>
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

<div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aprov p-3">
        <div class="d-flex flex-row justify-content-end col-sm-12">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-content modal-content-css border-0 bg-transparent">
            <div class="d-flex justify-content-between mt-5 ps-5 pe-5">
                <div class="d-flex justify-content-start align-items-center text-dark">
                    <div class="modal-header modal-header-css border-0">
                        <h1 class="modal-title fs-5 font-css" id="exampleModalLabel"> Total de entrevistas: <strong><?php echo count($dados) ?></strong> </h1>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end" id="div_img">
                    <img src="" alt="">
                </div>
            </div>
            <div class="modal-body modal-body-css">
                <div class="d-flex flex-column align-items-center justify-content-center mt-5 col-sm-12">
                    <table class="d-flex align-items-center table-css flex-column col-sm-12 table-fixed">
                        <thead class="">
                            <tr class="thead-designer font-css font-css-dark">
                                <th class="th-designer">Nome</th>
                                <th class="th-designer">Celular</th>
                                <th class="th-designer">Email</th>
                                <th class="th-designer">Data da entrevista</th>

                            </tr>
                        </thead>

                        <?php
                        foreach ($dados as $registros) { ?>
                            <tbody>
                                <tr class="listagem-back-blue mb-4">
                                    <td class="listagem-front-white font-css ">
                                        <span class="table-designer p-3">
                                            <a href="solicitacaoEntrevistaIndex.php?id=<?= $registros['id'] ?>" class="font-id-css ">
                                                <?= $registros['nome'] ?>
                                            </a>
                                        </span>
                                        <span class="table-designer">
                                            <?php echo $registros['celular'] ?>
                                        </span>
                                        <span class="table-designer">
                                            <?php echo $registros['email']; ?>
                                        </span>
                                        <span class="table-designer">
                                            <?php echo date('d/m/Y - H:i', strtotime($registros['periodo_visita_de'])) ?>
                                        </span>
                                    </td>
                                </tr>

                            </tbody>

                        <?php } ?>
                    </table>

                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-danger col-sm-3" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<script src="../Js/main.js" crossorigin="anonymous"></script>
<script src="../Js/dataTable.js" crossorigin="anonymous"></script>