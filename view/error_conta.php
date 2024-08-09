<?php
    require_once('../control/control_session.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>DEVLINE - Error</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel="icon" type="image/jpg" href="../src/img/flavicon.png" />
        <link rel='stylesheet' type='text/css' media='screen' href='../src/css/styles_default.css'>
        <link rel='stylesheet' type='text/css' media='screen' href='../src/css/styles_error.css'>
        <noscript><meta http-equiv="refresh" content="0; URL='./error_js_disable.html '"/></noscript>
    </head>
    <body>
        <section class="main_error">
            <section class="error_right">
                <img class="error_img" src="../src/img/ERROR_CONTA.png">
            </section>
            <section class="error_left">
                <section class="error_container">
                    <h2 class="title_error"><strong>Oops...</strong><br>Tivemos um problema</h2>
                    <p class="msg_error">Parece que já existe uma conta cadastrada com esse <?php echo($_SESSION['type_error']); ?>, entre ou crie uma nova contra</p>
                    <a class="button large transparent" href="./login.php">Entrar</a>
                    <a class="button large transparent" href="./signin.php">Criar conta</a>
                </section>
            </section>
        </section>
    </body>
</html>