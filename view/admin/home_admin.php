<!DOCTYPE html>
<?php
    require_once("../../control/control_session.php");

    if ($_SESSION['user_valid'] != "true" || $_SESSION['user_type'] != "adm") {
        header("Location: ../error_session_invalid.html");
    }
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DEVLINE - Painel de administração</title>
        <link rel='stylesheet' type='text/css' media='screen' href='../../src/css/styles_default.css'>
        <link rel='stylesheet' type='text/css' media='screen' href='../../src/css/styles_pn_adm.css'>
    </head>
    <body>
        <section class="main_home_admin">
            <section class="home_admin_sec left">
                <section class="home_admin_card">
                    <a href=""><section class="button medium transparent">Analytics</section></a>
                    <a href=""><section class="button medium transparent">Conquistas</section></a>
                    <a href="./contas_profissionais.php"><section class="button medium transparent">Contas profissionais</section></a>
                    <a href=""><section class="button medium transparent">Cursos</section></a>
                    <a href=""><section class="button medium transparent">Pacotes</section></a>
                    <a href=""><section class="button medium transparent">Usuarios</section></a>
                    <a href="../../control/control_session_destroy.php"><section class="button medium">Sair</section></a>
                </section>
            </section>
            <section class="home_admin_sec right">
                <h2 class="title_home_admin">Bem-vindo ao Painel de Administração!</h2>
                <p class="text_home_admin">Este é o centro de controle que capacita você a moldar a experiência dos usuários em nosso site. Aqui, você encontrará ferramentas poderosas para gerenciar conteúdo, analisar dados e aprimorar a funcionalidade da plataforma.</p>
            </section>
        </section>
    </body>
</html>