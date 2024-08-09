<?php
    require_once("../control/control_conexao.php");
    require_once("../control/control_session.php");

    $res = $pdo->prepare("SELECT * FROM pagamento WHERE user_compra = :usuario");

    $res->bindValue(":usuario", $_SESSION['user']);
    $res->execute();

    $dados = $res->fetchAll(PDO::FETCH_ASSOC);
    $rows = count($dados);

    if ($rows > 0) {
        for ($i=0; $i < count($dados); $i++) { 
            $data_compra = $dados[$i]['data_compra'];
            $name_pack = $dados[$i]['nome_pack'];
        }
    
        $data_compra_space = explode(" ", $data_compra);
        $data_compra_exp = explode("/", $data_compra_space[0]);
    
        if ($data_compra_exp[1] == 12) {
            $next_m = "01";
            $next_y = $data_compra_exp[2] + 1;
        }else{
            $next_m = $data_compra_exp[1] + 1;
            $next_y = $data_compra_exp[2];
        }

        if ($name_pack == "DV Pro") {
            echo('
                <style>
                    .card_painel_packs {
                        background: rgb(56,255,20,0.5);
                        background: linear-gradient(45deg, rgb(56,255,20,0.15) 0%,rgba(2,0,20,0.3) 100%);
                        border: 1px solid #39FF14;
                        box-shadow: #37ff1490 0px 0px 25px;
                    }
                </style>
            ');
        }elseif ($name_pack == "DV Elite") {
            echo('
                <style>
                    .card_painel_packs {
                        background: rgba(255,215,0,0.5);
                        background: linear-gradient(315deg, rgba(255,215,0,0.15) 0%, rgba(2,0,20,0.3) 100%);
                        border: 1px solid #FFD700;
                        box-shadow: #ffd900a1 0px 0px 25px;
                    }
                </style>
            ');
        }

        $res_card = $pdo->prepare("SELECT * FROM cards WHERE user_card = :usuario");

        $res_card->bindValue(":usuario", $_SESSION['user']);
        $res_card->execute();
    
        $dados_card = $res_card->fetchAll(PDO::FETCH_ASSOC);
        $rows_card = count($dados_card);

        if ($rows_card > 0) {
            for ($i=0; $i < count($dados_card); $i++) { 
                $num_exp = $dados_card[$i]['num_exibir'];
                $name_card = $dados_card[$i]['name_card'];
                $val_card = $dados_card[$i]['val_card'];
            }
            $num_exibir = explode("/", $num_exp);

        }

    }

    if (isset($_SESSION['user_valid'])) {
        if ($_SESSION['user_valid'] != "true") {
            header("Location: ./error_session_invalid.html");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DEVLINE - Pagamentos</title>
        <link rel="stylesheet" href="../src/css/styles_default.css">
        <link rel="stylesheet" href="../src/css/styles_config_pags.css">
        <link rel="stylesheet" href="../src/css/styles_modal.css">
        <noscript><meta http-equiv="refresh" content="0; URL='./error_js_disable.html '"/></noscript>
    </head>
    <body>
        <form action="../control/control_form_packs.php" method="post">
            <section class="modalBg">
                <section class="modal modal_card_exibir">
                    <section class="modal_content">   
                        <section class="x_fechar_modal" onclick="fecharModal(0)"><img src="../src/img/letra-x.png"></section>
                        <?php
                            include('./form_pagamento.html');
                        ?>
                    </section>
                </section>
            </section>
        </form>
        <section>
            <a href="./profile.php"><img id="logo" src="../src/img/LOGO_DV.png"></a>
            <section class="cards_top_config_pags">
                <section class="card_top left">
                    <section class="card_title">
                        <h2 class="title_card_top">Cartão cadastrado</h2>
                        <?php
                            if ($rows > 0) {
                                if ($rows_card > 0) {
                                    echo('
                                        <section id="flipper_exibir">
                                            <section class="cred_card_exibir front_exibir" id="cred_card_id_exibir" onclick="flipper_exibir_func()">
                                                <section class="sec_card_flag">
                                                    <img class="img_chip" src="../src/img/CHIP_CARD.png">
                                                    <img id="img_flag_exibir" class="img_flag_exibir" src="../src/img/LOGO_DV.png">
                                                </section>
                                                <section class="sec_card_num">
                                                    <span id="span_num" class="span_num">XXXX XXXX XXXX '.$num_exibir[1].'</span>
                                                </section>
                                                <section class="sec_name_date">
                                                    <span id="span_name" class="span_name">'.$name_card.'</span>
                                                    <span id="span_date" class="span_date">'.$val_card.'</span>
                                                </section>
                                            </section>
                                            <section class="cred_card_exibir back_exibir" onclick="return_cvv()">
                                                <section class="sec_card_bar">
                                                    <p>Platinum</p>
                                                    <img class="img_flag_exibir" src="../src/img/HOLOGRAM.png">
                                                </section>
                                                <section class="sec_card_img_cvv">
                                                    <img src="../src/img/AGUIA_CARD.png">
                                                </section>
                                                <section class="sec_cvv">       
                                                    <span id="span_cvv" class="span_cvv">XXX</span>
                                                </section>
                                            </section>
                                        </section>
                                    ');
                                }else{
                                    echo('
                                        <section class="sec_card_not_exist">
                                            <img class="gif_ghost" src="../src/img/GIF_GHOST.gif">
                                            <p class="text_card_not_exist">Não há cartões cadastrados</p>
                                            <section class="button medium transparent" onclick="exibirModal(0)">Cadastrar cartão</section>
                                        </section>
                                    ');
                                }
                            }else{
                                echo('
                                    <section class="sec_card_not_exist">
                                        <img class="gif_ghost" src="../src/img/GIF_GHOST.gif">
                                        <p class="text_card_not_exist">Não há cartões cadastrados</p>
                                    </section>
                                ');
                            }
                        ?>
                    </section>
                    <?php
                        if (isset($rows_card)) {
                            if ($rows_card > 0) {
                                echo('
                                    <section class="card_top_btn">
                                        <section class="button small transparent" onclick="exibirModal(0)">Alterar</section>
                                        <section class="button small transparent">Remover</section>
                                    </section>
                                ');
                            }
                        }
                    ?>
                </section>
                <section class="card_top right">
                    <section class="card_title">
                        <h2 class="title_card_top">Plano Ativo</h2>
                        <?php
                            if ($rows > 0) {
                                echo('
                                    <section class="sec_painel_packs left">
                                        <section class="card_painel_packs">
                                            <h2>'.$name_pack.'</h2>
                                            <p>Proxima mensalidade</p>
                                            <span>'.$data_compra_exp[0].'/'.$next_m.'/'.$next_y.'</span>
                                        </section>
                                    </section>     
                                ');
                                if ($rows_card == 0) {
                                    echo('
                                        <p class="text_card_not_exist">Atenção, se não houver nenhum cartão cadastrado até o vencimento de sua mensalidade seu plano será cancelado dia '.$data_compra_exp[0].'/'.$next_m.'/'.$next_y.'</p>
                                    ');
                                }
                            }else{
                                echo('
                                    <section class="sec_card_not_exist">
                                        <p class="text_card_not_exist">Ainda não há nenhum plano ativo</p>
                                        <a href="./seja_dv.php"><section class="button medium">Assinar um plano</section></a>
                                    </section>
                                ');
                            }
                        ?>
                    </section>
                    <?php
                        if ($rows > 0) {
                            echo('
                                <section class="card_top_btn">
                                    <section class="button small transparent">Alterar</section>
                                    <section class="button small transparent">Cancelar</section>
                                </section>
                            ');
                        }
                    ?>
                </section>
            </section>
        </section>
        <footer>
            <?php
                include_once("./footer.php");
            ?>
        </footer>
        <script>
            var img_flag_exibir = document.getElementById('img_flag_exibir');
            var card_exibir = document.getElementById('cred_card_id_exibir');
            var flipper_exibir = document.getElementById('flipper_exibir');
            var cred_card_exibir  = document.querySelectorAll('.cred_card_exibir');
            var front_exibir = document.querySelector('.front_exibir');
            var back_exibir = document.querySelector('.back_exibir');
            const modal = document.querySelectorAll(".modal");
            const modalBg = document.querySelectorAll(".modalBg");

            function flipper_exibir_func() {
                cvv_click = 1;
                flipper_exibir.style.transition = "transform 0.8s";
                flipper_exibir.style.transform = "rotateY(180deg)";
                setTimeout(() => {
                    front_exibir.style.display = 'none';
                    back_exibir.style.display = 'flex';
                }, 300);
            }

            function return_cvv() {
                if (cvv_click == 1) {
                    cvv_click = 0;
                    flipper_exibir.style.transition = "transform 0.8s";
                    flipper_exibir.style.transform = "rotateY(360deg)";
                    setTimeout(() => {
                        back_exibir.style.display = 'none';
                        front_exibir.style.display = 'flex';
                    }, 300);
                }
            }
            
            function exibirModal(e) {
                modal[e].style.display = 'flex'
                modalBg[0].style.display = 'flex'
            }

            function fecharModal(e) {
                modal[e].style.display = 'none'
                modalBg[0].style.display = 'none'
            }
        </script>
        <?php 
            if (isset($num_exibir[0])) {
                echo('
                    <script>
                        if ('.$num_exibir[0].' == "") {
                            img_flag_exibir.src = "../src/img/LOGO_DV.png";
                            cred_card_exibir[0].style.background = "linear-gradient(230deg, rgba(101, 0, 32, 0.7) 0%, rgba(4, 0, 40, 0.718) 40%, rgba(6, 1, 42, 0.734) 60%, rgba(122, 0, 34, 0.6) 100%)";
                            cred_card_exibir[1].style.background = "linear-gradient(230deg, rgba(101, 0, 32, 0.7) 0%, rgba(4, 0, 40, 0.718) 40%, rgba(6, 1, 42, 0.734) 60%, rgba(122, 0, 34, 0.6) 100%)";
                        }else if ('.$num_exibir[0][0].' == 5 && '.$num_exibir[0][1].' <= 5 && '.$num_exibir[0][1].' != 0) {
                            img_flag_exibir.src = "../src/img/MASTERCARD.png";
                            cred_card_exibir[0].style.background = "linear-gradient(165deg, rgba(235, 0, 27, 0.600) 0%, rgba(4, 0, 40, 0.718) 40%, rgba(6, 1, 42, 0.734) 60%, rgba(247, 158, 27, 0.400) 100%)";
                            cred_card_exibir[1].style.background = "linear-gradient(165deg, rgba(235, 0, 27, 0.600) 0%, rgba(4, 0, 40, 0.718) 40%, rgba(6, 1, 42, 0.734) 60%, rgba(247, 158, 27, 0.400) 100%)";
                        }else if ('.$num_exibir[0][0].' == 4) {
                            img_flag_exibir.src = "../src/img/VISA.png";
                            cred_card_exibir[0].style.background = "linear-gradient(130deg, rgba(26, 30, 113, 0.600) 0%, rgba(4, 0, 40, 0.718) 40%, rgba(6, 1, 42, 0.734) 60%, rgba(202, 151, 9, 0.400) 100%)";
                            cred_card_exibir[1].style.background = "linear-gradient(130deg, rgba(26, 30, 113, 0.600) 0%, rgba(4, 0, 40, 0.718) 40%, rgba(6, 1, 42, 0.734) 60%, rgba(202, 151, 9, 0.400) 100%)";
                        }else if ('.$num_exibir[0][0].' == 3 && '.$num_exibir[0][1].' == 1) {
                            img_flag_exibir.src = "../src/img/ELO.png";
                            cred_card_exibir[0].style.background = "linear-gradient(210deg, rgba(0,64,127, 0.600) 0%, rgba(4, 0, 40, 0.718) 40%, rgba(6, 1, 42, 0.734) 60%, rgba(235, 0, 27, 0.400) 100%)";
                            cred_card_exibir[1].style.background = "linear-gradient(210deg, rgba(0,64,127, 0.600) 0%, rgba(4, 0, 40, 0.718) 40%, rgba(6, 1, 42, 0.734) 60%, rgba(235, 0, 27, 0.400) 100%)";
                        }else if ('.$num_exibir[0][0].' == 3 && '.$num_exibir[0][1].' == 6 || '.$num_exibir[0][0].' == 3 && '.$num_exibir[0][1].' == 8) {
                            img_flag_exibir.src = "../src/img/DINERS_CLUB.png";
                            cred_card_exibir[0].style.background = "linear-gradient(230deg, rgba(0,101,235, 0.3) 0%, rgba(4, 0, 40, 0.718) 40%, rgba(6, 1, 42, 0.734) 60%, rgba(255,255,255, 0.2) 100%)";
                            cred_card_exibir[1].style.background = "linear-gradient(230deg, rgba(0,101,235, 0.3) 0%, rgba(4, 0, 40, 0.718) 40%, rgba(6, 1, 42, 0.734) 60%, rgba(255,255,255, 0.2) 100%)";
                        }else if ('.$num_exibir[0][0].' == 6 && '.$num_exibir[0][1].' == 0 && '.$num_exibir[0][2].' == 1 && '.$num_exibir[0][3].' == 1 || '.$num_exibir[0][0].' == 6 && '.$num_exibir[0][1].' == 5) {
                            img_flag_exibir.src = "../src/img/DISCOVER.png";
                            cred_card_exibir[0].style.background = "linear-gradient(250deg, rgba(255,255,255, 0.2) 0%, rgba(4, 0, 40, 0.718) 40%, rgba(6, 1, 42, 0.734) 60%, rgba(255,104,0,0.3) 100%)";
                            cred_card_exibir[1].style.background = "linear-gradient(250deg, rgba(255,255,255, 0.2) 0%, rgba(4, 0, 40, 0.718) 40%, rgba(6, 1, 42, 0.734) 60%, rgba(255,104,0,0.3) 100%)";
                        }else if ('.$num_exibir[0][0].' == 3 && '.$num_exibir[0][1].' == 5) {
                            img_flag_exibir.src = "../src/img/JCB.png";
                            cred_card_exibir[0].style.background = "linear-gradient(195deg, rgba(0,101,235, 0.3) 0%, rgba(4, 0, 40, 0.718) 40%, rgba(6, 1, 42, 0.734) 60%, rgba(0,235,101, 0.3) 100%)";
                            cred_card_exibir[1].style.background = "linear-gradient(195deg, rgba(0,101,235, 0.3) 0%, rgba(4, 0, 40, 0.718) 40%, rgba(6, 1, 42, 0.734) 60%, rgba(0,235,101, 0.3) 100%)";
                        }else if ('.$num_exibir[0][0].' == 3 && '.$num_exibir[0][1].' == 4 || '.$num_exibir[0][0].' == 3 && '.$num_exibir[0][1].' == 7) {
                            img_flag_exibir.src = "../src/img/AMERICAN_EXPRESS.png";
                            cred_card_exibir[0].style.background = "linear-gradient(45deg, rgba(0,101,235, 0.3) 0%, rgba(4, 0, 40, 0.718) 40%, rgba(6, 1, 42, 0.734) 60%, rgba(0,101,235, 0.3) 100%)";
                            cred_card_exibir[1].style.background = "linear-gradient(45deg, rgba(0,101,235, 0.3) 0%, rgba(4, 0, 40, 0.718) 40%, rgba(6, 1, 42, 0.734) 60%, rgba(0,101,235, 0.3) 100%)";
                        }else{
                            img_flag_exibir.src = "../src/img/LOGO_DV.png";
                            cred_card_exibir[0].style.background = "linear-gradient(230deg, rgba(101, 0, 32, 0.7) 0%, rgba(4, 0, 40, 0.718) 40%, rgba(6, 1, 42, 0.734) 60%, rgba(122, 0, 34, 0.6) 100%)";
                            cred_card_exibir[1].style.background = "linear-gradient(230deg, rgba(101, 0, 32, 0.7) 0%, rgba(4, 0, 40, 0.718) 40%, rgba(6, 1, 42, 0.734) 60%, rgba(122, 0, 34, 0.6) 100%)";
                        }
                    </script>
                ');
            }
        ?>
    </body>
</html>