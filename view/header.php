<?php
    require_once("../control/control_conexao.php");
    require_once('../control/control_session.php');

    if (isset($_SESSION['user'])) {
        $ft_perfil = 0;
        $rows_prof = 0;

        if ($_SESSION['user_type'] == "professor") {
            $res = $pdo->prepare("SELECT * FROM professor WHERE usuario = :usuario");

            $res->bindValue(":usuario", $_SESSION['user']);
            $res->execute();

            $dados = $res->fetchAll(PDO::FETCH_ASSOC);
            $rows_prof__header = count($dados);

            for ($i=0; $i < count($dados); $i++) { 
                $username = $dados[$i]['usuario'];
                $cpf = $dados[$i]['cpf'];
            }

            $res_prof_aluno = $pdo->query("SELECT * FROM aluno WHERE cpf = '$cpf'");

            $dados_prof_aluno = $res_prof_aluno->fetchAll(PDO::FETCH_ASSOC);

            for ($i=0; $i < count($dados_prof_aluno); $i++) { 
                $ft_perfil = $dados_prof_aluno[$i]['ft_perfil'];
            }

        }elseif ($_SESSION['user_type'] == "aluno") {
            $res = $pdo->prepare("SELECT * FROM aluno WHERE usuario = :usuario");

            $res->bindValue(":usuario", $_SESSION['user']);
            $res->execute();

            $dados = $res->fetchAll(PDO::FETCH_ASSOC);

            for ($i=0; $i < count($dados); $i++) { 
                $ft_perfil = $dados[$i]['ft_perfil'];
                $nivel_user = $dados[$i]['nivel'];
            }

            if (isset($_SESSION['email_aluno'])) {
                $email = $_SESSION['email_aluno'];

                $res_prof = $pdo->query("SELECT * FROM professor WHERE email = '$email'");
                $dados_prof = $res_prof->fetchAll(PDO::FETCH_ASSOC);
                $rows_prof = count($dados_prof);
            }

            if ($nivel_user == "DV Pro") {
                echo('
                    <style>
                        .btn_header_sj_dv {
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            background: #39FF14;
                            border: 1px solid #39FF14;
                            box-shadow: #37ff1490 0px 0px 25px;
                            cursor: pointer;
                        }
                    </style>
                ');
            } elseif ($nivel_user == "DV Elite") {
                echo('
                    <style>
                        .btn_header_sj_dv {
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            background: #FFD700;
                            border: 1px solid #FFD700;
                            box-shadow: #ffd900a1 0px 0px 25px;
                            cursor: pointer;
                        }
                    </style>
                ');
            } else {
                echo('
                    <style>
                        .btn_header_sj_dv {
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            background: #FF0149;
                            border: 1px solid #FF0149;
                            cursor: pointer;
                        }
                    </style>
                ');
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='stylesheet' type='text/css' media='screen' href='../src/css/styles_default.css'>
        <link rel='stylesheet' type='text/css' media='screen' href='../src/css/styles_header.css'>
        <noscript><meta http-equiv="refresh" content="0; URL='./error_js_disable.html '"/></noscript>
    </head>
    <body>
        <section id="header_display">
            <figure>
                <img class="logo" src="../src/img/LOGO_DV.png">
            </figure>
            <nav id="menu_itens">
                <ul class="menu_itens_ul">
                    <?php
                        if (!isset($rows_prof__header)) {
                            echo('
                                <li class="session_true" id="inicio_false"><a class="itens" href="./landing_page.php">Inicio</a></li>
                                <li class="session_true"><a class="itens" href="#">Comunidade</a></li>
                                <li class="session_true"><a class="itens" href="./cursos.php">Cursos</a></li>
                                <li class="session_false"><a class="itens" href="./meus_cursos.php">Meus cursos</a></li>
                                <li class="session_false"><a class="itens" href="#">Gaming</a></li>
                            ');
                        }
                        
                    ?>
                    <section>
                        <li class="session_true" id="btn_header_login">
                            <button onclick="window.location.href='./login.php'" class="button small transparent">
                                <a>Login</a>
                            </button>
                        </li>
                        <li class="session_false" id="btn_header_DV">
                            <a href="<?php if (isset($nivel_user)) { if($nivel_user == "Default") { echo('./seja_dv.php'); } elseif ($nivel_user == "DV Pro") { echo('./painel_pack.php'); } elseif ($nivel_user == "DV Elite") { echo('./painel_pack.php'); } } ?>">
                                <section class="
                                small btn_header_sj_dv">
                                    <?php if (isset($nivel_user)) { if($nivel_user == "Default") { echo('SEJA DV'); } elseif ($nivel_user == "DV Pro") { echo('DV Pro'); } elseif ($nivel_user == "DV Elite") { echo('DV Elite'); } } ?>
                                </section>
                            </a>
                        </li>
                        <li class="session_false" id="header_profile">
                            <a href="./profile.php">
                                <figure class="profile_image">
                                    <img src="../src/img/PROFILES/<?php echo($ft_perfil); ?>" alt="">
                                </figure>
                            </a>
                        </li>
                        <li class="session_false" id="header_hamburguer">
                            <nav class="menu">
                                <input type="checkbox" id="menu-faketrigger">

                                <label for="menu-faketrigger" class="menu-lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </label>
                                <ul class="ul_menu_h_itens">
                                    <input type="checkbox" id="input_sair">
                                    <?php
                                        if (!isset($rows_prof__header)) {
                                            echo('
                                                <a class="align_links_menu_h" href="#"><li class="menu_h_itens"><img src="../src/img/engrenagem.png">Configurações</li></a>
                                                <!-- <a class="align_links_menu_h" href="#"><li class="menu_h_itens"><img src="../src/img/do-utilizador.png">Privacidade</li></a> -->
                                                <a class="align_links_menu_h" href="./config_salvos.php"><li class="menu_h_itens"><img src="../src/img/SALVO_NOT.png">Salvos</li></a>
                                                <a class="align_links_menu_h" href="./config_favs.php"><li class="menu_h_itens"><img src="../src/img/estrela.png">Favoritos</li></a>
                                                <a class="align_links_menu_h" href="./config_pagamentos.php"><li class="menu_h_itens"><img src="../src/img/cartao-de-credito.png">Pagamentos</li></a>
                                                <a class="align_links_menu_h" href="'); if($rows_prof > 0) { echo('./status_conta_profissional.php'); }else{ echo('./conta_profissional.php'); } echo('"><li class="menu_h_itens"><img src="../src/img/grupo.png">'); if($rows_prof) { echo('Conta profissional'); }else{ echo('Junte-se a nós'); } echo('</li></a>
                                                <a class="align_links_menu_h" href="#"><label for="input_sair"><li class="menu_h_itens"><img src="../src/img/letra-x.png">Sair</li></label></a>
                                            ');
                                        }else{
                                            echo('
                                                <a class="align_links_menu_h" href="#"><li class="menu_h_itens"><img src="../src/img/engrenagem.png">Configurações</li></a>
                                                <a class="align_links_menu_h" href="#"><label for="input_sair"><li class="menu_h_itens"><img src="../src/img/letra-x.png">Sair</li></label></a>
                                            ');
                                        }
                                    ?>
                                    <li class="menu_h_sair">
                                        <h2 class="text_sair">Tem certeza que deseja sair</h2>
                                        <a href="../control/control_session_destroy.php"><section class="button small transparent">Sim sair</section></a>
                                    </li>
                                </ul>

                                <section class="bgMenu"></section>
                            </nav>
                        </li>
                    </section>
                </ul>
            </nav>
        </section>
        <script>
            bgMenu = document.querySelectorAll(".bgMenu");
            fecharMenu = document.getElementById('menu-faketrigger');

            bgMenu[0].addEventListener("click", fecharMenuFunc);

            function fecharMenuFunc() {
                fecharMenu.checked = false;
            }
        </script>
    </body>
</html>

<?php
    if (isset($_SESSION['user_valid'])) {
        if ($_SESSION['user_valid'] == "true") {
          echo("<style>
            .session_false {
                display: block;
            }

            #inicio_false {
                display: none;
            }

            #btn_header_login {
                display: none;
            }
          </style>");
        }
    }
?>