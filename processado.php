<?php
// Chamar o método para carregar as variáveis de ambiente
include  './BD_Conncetion/connection.php';
include  './Toten_Token/View/Side_Bar_Toten.php';

$hoje = date('Y-m-d'); // Formato: Ano-Mês-Dia
$visitas_Hoje = $dbDB->prepare("SELECT * FROM Visitante WHERE CONVERT(DATE, periodo_visita_de) = :hoje ORDER BY id");
$visitas_Hoje->bindValue(':hoje', $hoje, PDO::PARAM_STR);
$visitas_Hoje->execute();
$resultadosHoje = $visitas_Hoje->fetchAll(PDO::FETCH_ASSOC);
?>

<body class=" d-flex flex-row">
    <div class=" d-flex flex-column col">
        <div class="d-flex justify-content-center mt-5">
            <div class="d-flex justify-content-start text-dark col-sm-10 justify-content-between align-items-center ">
                <span class="titulo">
                    Consultar Visita:
                </span>
                <div class="d-flex justify-content-around col-sm-7">
                    <span>
                        <a href="./View/home.php" id="btn-primary" class=" text-decoration-none btn btn-primary font-css" role="button">
                            Painel Administrativo
                        </a>
                    </span>
                    <span>
                        <a href="./View/home.php" id="btn-primary" class=" text-decoration-none btn btn-primary font-css" role="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Ajuda/Ramais
                        </a>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-sm-12  d-flex justify-content-center mt-5">
            <div class="d-flex flex-column col-sm-12 d-flex justify-content-center align-items-center">
                <span class="titulo"> Digite seu CPF para confirmar sua visita</span>
                <div class="d-flex align-items-center justify-content-center mt-5 col-sm-12">
                    <div class="col-sm-10 align-items-center justify-content-center">
                        <form action="" method="post" class="col-sm-11 mt-5">
                            <div class="d-flex align-items-center justify-content-between rounded-pill col-sm-12 bg-light border-radius-css">
                                <input type="text" autocomplete="off" placeholder="Pesquisar" id="pesquisar" name="token" class="input rounded-pill border-0 p-1 me-2 bg-light col-sm-10 focus-outline-none-css">
                                <button type="submit" class="border-0 bg-transparent d-flex flex-row align-items-center justify-content-end col-sm-1 me-3 rounded-pill">
                                    <i class="fa-solid fa-magnifying-glass me-3" style="color: #00b0f2;"> </i>
                                    <span class="font-css">PESQUISAR</span>
                                </button>
                            </div>
                            <div class="simple-keyboard "></div>
                        </form>

                        <div class="d-flex flex-column align-items-center justify-content-center mt-5 col-sm-12 ">
                            <?php
                            $token  = "";
                            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                                if (isset($_POST['token'])) {
                                    $token = $_POST['token'];
                                    $_SESSION['token'] = $token;
                                    $consulta_token = $dbDB->prepare("SELECT * FROM Visitante WHERE cpf = :cpf ORDER BY id ASC");
                                    $consulta_token->bindParam(':cpf', $token);
                                    $consulta_token->execute();
                                    $id_consulta_token = $consulta_token->fetchAll(PDO::FETCH_ASSOC);
                                } else {
                                    echo "Nenhum resultado encontrado.";
                                }
                            }
                            if (isset($id_consulta_token)) {
                            ?>
                                <table class="d-flex align-items-center table-css flex-column col-sm-12 table-fixed">
                                    <thead class="thead-designer-front">
                                        <tr class="thead-designer p-3 font-css-dark">
                                            <th class="th-designer">Nome</th>
                                            <th class="th-designer">Empresa </th>
                                            <th class="th-designer">Celular</th>
                                            <th class="th-designer">Presença</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach ($id_consulta_token as $consulta) { ?>
                                            <tr class="listagem-back-blue mb-4">
                                                <td class="listagem-front-white p-3 font-css">
                                                    <span class="table-designer"><?= $consulta['visitante']; ?></span>
                                                    <span class="table-designer"><?= $consulta['empresa']; ?></span>
                                                    <span class="table-designer"><?= $consulta['celular']; ?></span>
                                                    <span class="table-designer">
                                                        <a class="btn btn-info  font-id-css" href="./Toten_Token/DB_Query_Portaria_Toten/portaria.php?id=<?= $consulta['id'] ?>">
                                                            Confirmar
                                                        </a>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            <?php
                            } else {
                                // Caso não haja resultados para exibir
                                echo "Nenhum resultado encontrado";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


<?php
if (isset($_SESSION['visita_confirmada'])) {
?>
    <div class="alert position-absolute flash-message">
        <div class="flash-message-child p-4">
            <i class="fa-solid fa-circle-exclamation fa-shake" style="color: #fb1313; font-size: 5rem;"></i>
            <div class="d-flex flex-column justify-content-between align-items-center mt-4">

                <?php
                if ($_SESSION['visita_confirmada'] == "Você está tentando confirmar uma visita que não é sua ou o token está incorreto") {
                ?>

                    <p class="font-flash-message" id="font-flash-message">
                        Algo deu errado
                    </p>

                <?php
                } else {
                ?>

                    <p class="font-flash-message" id="font-flash-message">
                        Já confirmamos sua visita.
                    </p>

                <?php
                }
                ?>

                <span class="font-css" id="">
                    <?php
                    echo $_SESSION['visita_confirmada'];
                    unset($_SESSION['visita_confirmada']);
                    ?>
                </span>
            </div>
            <div class="d-flex flex-row justify-content-around col-sm-7 mt-4">
                <button type="submit" class="btn btn-danger col-sm-5" data-bs-dismiss="alert" aria-label="Close">Cancelar</button>
            </div>
        </div>
    </div>
<?php
}
?>

<?php
if (isset($_SESSION['MensagemPortaria'])) {
?>
    <div class="alert position-absolute flash-message">
        <div class="flash-message-child p-4">

            <i class="fa-solid fa-circle-check" style="color: #08d415; font-size: 5rem;"></i>

            <div class="d-flex flex-column justify-content-between align-items-center mt-4">
                <p class="font-flash-message">
                    Recebido com sucesso
                </p>
                <span class="font-css text-center">
                    <?php
                    echo $_SESSION['MensagemPortaria'];
                    unset($_SESSION['MensagemPortaria']);
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

<div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-css-index ">
        <div class="d-flex flex-row justify-content-end col-sm-12">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-content border-0 bg-transparent">
            <div class="modal-header modal-header-css border-0">
                <h1 class="modal-title fs-5 font-css" id="exampleModalLabel"> Todos os ramais.</h1>
            </div>
            <div class="modal-body">
                <img src="./Img/Lista de Contatos (1)_page-0001.jpg" alt="" class="col-sm-12">
                <img src="./Img/Lista de Contatos (1)_page-0002.jpg" alt="" class="col-sm-12">

            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/simple-keyboard@latest/build/index.js"></script>
<script src="./Toten_Token/JS/main.js"></script>