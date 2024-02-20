<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["concordo"])) {
        // O usuário concordou com os termos, você pode adicionar o código aqui para processar o aceite.
        header("Location: processado.php");
        exit;
    } else {
        // O usuário não concordou, você pode redirecioná-lo de volta ao formulário ou realizar outra ação.
        echo "Por favor, concorde com os termos para continuar.";
    }
}
