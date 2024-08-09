<?php
    require_once('../control/control_session.php'); 
    
    if (isset($_SESSION['user_valid'])) {
        if ($_SESSION['user_valid'] == "true") {
            header("Location: ./profile.php");
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>DEVLINE - Inicio</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel="icon" type="image/jpg" href="../src/img/flavicon.png" />
        <link rel='stylesheet' type='text/css' media='screen' href='../src/css/styles_default.css'>
        <link rel='stylesheet' type='text/css' media='screen' href='../src/css/styles_inicio.css'>
        <noscript><meta http-equiv="refresh" content="0; URL='./error_js_disable.html '"/></noscript>
    </head>
    <body class="body_corection">
        <header>
            <?php
                include_once("./header.php");
            ?>
        </header>
        <main id="first_view">
            <section id="lp_left" class="lp_content">
                <h1 class="title">DESBLOQUEIE SEU<br>POTENCIAL COM A<br>DEVLINE</h1>
                <p class="text">Bem-vindo à revolução da<br>aprendizagem online!</p>
                <a href="./login.php"><button class="button medium">COMECE AGORA</button></a>
            </section>
            <section id="lp_right" class="lp_content">
                <figure>
                    <img src="../src/img/IMG_LANDING_PAGE.png">
                </figure>
            </section>
        </main>
        <section id="lp_content">
            <section id="lp_cards">
                <section class="card">
                    <h2 class="card_title">APRENDA NO SEU RITMO</h2>
                    <p class="content_card">Estude quando e onde quiser, adaptando o aprendizado à sua agenda.</p>
                </section>
                <section class="card">
                    <h2 class="card_title">INSTRUTORES<br>ESPECIALIZADOS</h2>
                    <p class="content_card">Nossos cursos são ministrados por especialistas em seus campos, garantindo qualidade excepcional.</p>
                </section>
                <section class="card">
                    <h2 class="card_title">CERTIFICAÇÕES<br>RECONHECIDAS</h2>
                    <p class="content_card">Obtenha credenciais que impulsionam sua carreira e abrem portas para oportunidades incríveis.</p>
                </section>
                <section class="card">
                    <h2 class="card_title">COMUNIDADE DE<br>APRENDIZAGEN</h2>
                    <p class="content_card">Conecte-se com colegas de todo o mundo, compartilhe experiências e cresça juntos.</p>
                </section>
                <section class="card">
                    <h2 class="card_title">SUPORTE EXCEPCIONAL</h2>
                    <p class="content_card">Nossa equipe está sempre pronta para ajudá-lo, do início ao fim da sua jornada de aprendizado.</p>
                </section>
            </section>
        </section>
        <footer>
            <?php
                include_once("./footer.php");
            ?>
        </footer>
    </body>
</html>