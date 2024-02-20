<?php require_once 'Side_Bar_home.php'; ?>
<?php require_once('../DB_Querys/solicitacao_entrevista.php'); ?>
<?php require_once('../DB_Querys/aprovacao.php'); ?>
<?php require_once '../DB_Querys/home_Paginacao_Tabela.php'; ?>

<?php
$VisitasAprovadas = readVisitasAprovadas($dbDB);
$EntrevistasAprovadas = readEntrevistasAprovadas($dbDB);
$resultado = readVisitasPendentes($dbDB);


?>

<div class=" d-flex flex-column col">

    <div class="d-flex justify-content-between mt-5 ps-5 pe-5">
        <div class="d-flex justify-content-start align-items-center text-dark">
            <span class="titulo">
                Aprovar visitante
            </span>
        </div>
        <div class="d-flex align-items-center justify-content-end" id="div_img">
            <img src="" alt="">
        </div>
    </div>

    <div class="d-flex flex-row align-items-center justify-content-center mb-5 mt-5">
        <div class="d-flex flex-row col-sm-10 justify-content-around">
            <div class="card-home-back justify-content-end shadow">
                <div class="card-home-front p-3">
                    <p class="m-0 text-white titulo-card">Total de visitas pendentes: <?php echo count($resultado) ?></p>
                </div>
            </div>
            <div class="card-home-back-success shadow ">
                <div class="card-home-front-success " data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <p class="m-0 text-white titulo-card p-2">Total de visitas aprovadas: <?php echo count($VisitasAprovadas) ?> </p>
                </div>
            </div>
            <div class="card-home-back-success shadow ">
                <div class="card-home-front-success " data-bs-toggle="modal" data-bs-target="#exampleModal2">
                    <p class="m-0 text-white titulo-card p-2">Total de entrevistas aprovadas: <?php echo count($EntrevistasAprovadas) ?> </p>
                </div>
            </div>
        </div>
    </div>
    </form>

    <div class="d-flex flex-column align-items-center justify-content-center mt-5 col-sm-12">
        <table class="d-flex align-items-center table-css flex-column col-sm-12">
            <thead class="">
                <tr class="thead-designer p-3 font-css-dark">
                    <th class="th-designer" scope="col">Nome</th>
                    <th class="th-designer" scope="col">Empresa </th>
                    <th class="th-designer" scope="col">Area da Visita</th>
                    <th class="th-designer" scope="col">Data da Visita</th>
                    <th class="th-designer">aprovar</th>
                    <th class="th-designer">enviar</th>
                </tr>
            </thead>
            <?php
            foreach ($resultado as $resultados) { ?>
                <tbody>
                    <tr class="listagem-back-blue mb-4">
                        <td class="listagem-front-white p-3 font-css" id="">
                            <span class="table-designer text-center ">
                                <?php
                                if ($resultados['motivo_visita'] == "Entrevista") : ?>
                                    <a href="solicitacaoEntrevistaIndex.php?id=<?= $resultados['id'] ?>" class="font-id-css">
                                        <?= $resultados['nome'] ?>
                                    </a>
                                <?php else : ?>
                                    <a href="solicitacaoIndex.php?id=<?= $resultados['id'] ?>" class="font-id-css">
                                        <?= $resultados['visitante'] ?>
                                    </a>
                                <?php endif; ?>
                            </span>
                            <span class="table-designer d-flex text-center "><?= $resultados['empresa']; ?></span>
                            <span class="table-designer d-flex text-center">
                                <?php if ($resultados['motivo_visita'] == "Entrevista") : ?>
                                    Entrevista
                                <?php else : ?>
                                    <?= $resultados['area_da_visita'] ?>
                                <?php endif; ?>
                            </span>
                            <span class="table-designer d-flex text-center"><?= date('d/m/Y - H:i', strtotime($resultados['periodo_visita_de'])) ?></span>

                            <form action="../DB_Querys/aprovacao.php" method="POST" class="d-flex w-form">
                                <input type="hidden" name="id_visitante" value="<?= $resultados['id']; ?>">
                                <div class="d-flex align-items-center justify-content-center col-sm-6">
                                    <input type="checkbox" class="d-flex align-items-center justify-content-center" id="aprovado" name="aprovado"><span class="ms-3">Aprovar</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-center col-sm-6 ">
                                    <input type="submit" class="btn btn-outline-info d-flex align-items-center justify-content-center" id="reprovado"></input>
                                </div>
                            </form>
                        </td>
                    </tr>
                </tbody>
            <?php   } ?>
        </table>
    </div>
</div>

<!-------------- Modal------------->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-css modal-dialog-css-success">
        <div class="d-flex flex-row justify-content-end col-sm-12">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-content modal-content-css border-0 bg-transparent">
            <div class="d-flex justify-content-between mt-5 ps-5 pe-5">
                <div class="d-flex justify-content-start align-items-center text-dark">
                    <div class="modal-header modal-header-css border-0">
                        <h1 class="modal-title fs-5 font-css" id="exampleModalLabel"> Total:</h1>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end" id="div_img">
                    <img src="" alt="">
                </div>
            </div>
            <div class="modal-body modal-body-css">
                <div class="d-flex flex-column align-items-center justify-content-center mt-3 col-sm-12">
                    <table class="d-flex align-items-center table-css flex-column col-sm-12">
                        <thead class="thead-designer-front">
                            <tr class="thead-designer p-3 font-css-dark">
                                <th class="th-designer" scope="col">Nome</th>
                                <th class="th-designer" scope="col">Empresa </th>
                                <th class="th-designer" scope="col">Area da Visita</th>
                                <th class="th-designer" scope="col">Data da Visita</th>
                                <th class="th-designer" scope="col">Aprovação</th>
                            </tr>
                        </thead>
                        <?php
                        foreach ($VisitasAprovadas as $querys) {
                        ?>
                            <tbody>
                                <tr class=" mb-4 listagem-back-green bg-success ">
                                    <td class=" listagem-front-white-green p-3 font-css border-success" id="">
                                        <span class="table-designer">
                                            <a href="solicitacaoIndex.php?id=<?= $querys['id'] ?>" class="font-id-css ">
                                                <?= $querys['visitante'] ?>
                                            </a>
                                        </span>
                                        <span class="table-designer"><?= $querys['empresa']; ?></span>
                                        <span class="table-designer "><?= $querys['area_da_visita']; ?></span>
                                        <span class="table-designer "><?= date('d/m/Y - H:i', strtotime($querys['periodo_visita_de'])) ?></span>
                                        <span class="table-designer ">Aprovado</span>
                                    </td>
                                </tr>
                            </tbody>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-danger col-sm-3" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-------------- Modal------------->

<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-css modal-dialog-css-success">
        <div class="d-flex flex-row justify-content-end col-sm-12">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-content modal-content-css border-0 bg-transparent">
            <div class="d-flex justify-content-between mt-5 ps-5 pe-5">
                <div class="d-flex justify-content-start align-items-center text-dark">
                    <div class="modal-header modal-header-css border-0">
                        <h1 class="modal-title fs-5 font-css" id="exampleModalLabel"> Total:</h1>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end" id="div_img">
                    <img src="" alt="">
                </div>
            </div>
            <div class="modal-body modal-body-css">
                <div class="d-flex flex-column align-items-center justify-content-center mt-3 col-sm-12">
                    <table class="d-flex align-items-center table-css flex-column col-sm-12">
                        <thead class="thead-designer-front">
                            <tr class="thead-designer p-3 font-css-dark">
                                <th class="th-designer" scope="col">Nome</th>
                                <th class="th-designer" scope="col">Celular </th>
                                <th class="th-designer" scope="col">Email</th>
                                <th class="th-designer" scope="col">Cpf</th>
                                <th class="th-designer" scope="col">Data da Visita</th>
                            </tr>
                        </thead>
                        <?php
                        foreach ($EntrevistasAprovadas as $querys) {
                        ?>
                            <tbody>
                                <tr class=" mb-4 listagem-back-green bg-success ">
                                    <td class=" listagem-front-white-green p-3 font-css border-success" id="">
                                        <span class="table-designer">
                                            <a href="solicitacaoEntrevistaIndex.php?id=<?= $querys['id'] ?>" class="font-id-css ">
                                                <?= $querys['nome'] ?>
                                            </a>
                                        </span>
                                        <span class="table-designer"><?= $querys['celular']; ?></span>
                                        <span class="table-designer "><?= $querys['email']; ?></span>
                                        <span class="table-designer "><?= $querys['cpf']; ?></span>
                                        <span class="table-designer "><?= date('d/m/Y - H:i', strtotime($querys['periodo_visita_de'])) ?></span>
                                    </td>
                                </tr>
                            </tbody>
                        <?php
                        } ?>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-danger col-sm-3" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_SESSION['status'])) {
?>
    <div class="alert position-absolute flash-message">
        <div class="flash-message-child p-4">

            <i class="fa-solid fa-circle-check" style="color: #08d415; font-size: 5rem;"></i>

            <div class="d-flex flex-column justify-content-between align-items-center mt-4">
                <p class="font-flash-message">
                    Aprovado com sucesso
                </p>
                <span class="font-css text-center">
                    <?php
                    echo $_SESSION['status'];
                    unset($_SESSION['status']);
                    ?>
                </span>
            </div>

            <div class="d-flex flex-row justify-content-center col-sm-7 mt-4">
                <button type="submit" class="btn btn-danger col-sm-6" data-bs-dismiss="alert" aria-label="Close">Fechar</button>
            </div>

        </div>
    </div>
<?php
}
?>

<?php
if (isset($_SESSION['danger'])) {
?>
    <div class="alert position-absolute flash-message">
        <div class="flash-message-child p-4">
            <i class="fa-solid fa-circle-exclamation fa-shake " style="color: #fb1313; font-size: 5rem;"></i>
            <div class="d-flex flex-column justify-content-between align-items-center mt-4">
                <p class="font-flash-message">
                    Reprovado
                </p>
                <span class="font-css text-center">
                    <?php
                    echo $_SESSION['danger'];
                    unset($_SESSION['danger']);
                    ?>
                </span>
            </div>
            <div class="d-flex flex-row justify-content-center col-sm-7 mt-4">
                <button type="submit" class="btn btn-danger col-sm-6" data-bs-dismiss="alert" aria-label="Close">Fechar</button>
            </div>
        </div>
    </div>
<?php
}
?>