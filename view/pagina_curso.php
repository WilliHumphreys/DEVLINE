<?php
    require_once("../control/control_conexao.php");
    require_once("../control/control_session.php");

    $cursos_ativos_checked = 0;

    if (isset($_GET['id_curso'])) {
        $id_curso = $_GET['id_curso'];

        $res = $pdo->query("SELECT * FROM cursos WHERE id_cursos='$id_curso'");
                    
        $dados = 0;
                        
        $dados = $res->fetchAll(PDO::FETCH_ASSOC);
        $rows = count($dados);

        if ($rows > 0) {
            for ($i=0; $i < count($dados); $i++) { 
                $nome_curso = $dados[$i]['nome'];
                $desc_curso = $dados[$i]['descricao'];
                $ft_capa = $dados[$i]['ft_capa'];
                $ft_banner = $dados[$i]['ft_banner'];
                $prof_curso = $dados[$i]['professor'];
            }
        }

        if (isset($_SESSION['user'])) {
            $res_aluno_saved = $pdo->prepare("SELECT * FROM aluno WHERE usuario = :usuario");

            $res_aluno_saved->bindValue(":usuario", $_SESSION['user']);
            $res_aluno_saved->execute();
        
            $dados_aluno_saved = $res_aluno_saved->fetchAll(PDO::FETCH_ASSOC);
        
            for ($i=0; $i < count($dados_aluno_saved); $i++) { 
                $nivel = $dados_aluno_saved[$i]['nivel'];
                $salvos_brut = $dados_aluno_saved[$i]['salvos'];
                $cursos_ativos = $dados_aluno_saved[$i]['cursos_ativos'];
                $cod_cursos_ativos = $dados_aluno_saved[$i]['cod_cursos_ativos'];
            }
    
            $salvos_checked = 0;
            
            if ($salvos_brut > 0) {
                $salvos = explode("S", $salvos_brut);
    
                for ($i=0; $i < count($salvos); $i++) { 
                    if ($salvos[$i] == $id_curso) {
                        $salvos_checked = "true";
                    }
                }
            }

            if ($cursos_ativos > 0) {
                $cod_cursos_ativos = explode("A", $cod_cursos_ativos);
                
                for ($i=0; $i < count($cod_cursos_ativos); $i++) { 
                    if ($cod_cursos_ativos[$i] == $id_curso) {
                        $cursos_ativos_checked = "true";
                    }
                }
            }
        }

        if (isset($_SESSION['user'])) {
            if ($nivel == "Default" && $cursos_ativos < 1) {
                $modal_curso = 0;
            }elseif ($nivel == "DV Pro" && $cursos_ativos < 2) {
                $modal_curso = 0;
            }elseif ($nivel == "DV Elite" && $cursos_ativos < 5) {
                $modal_curso = 0;
            }else {
                $modal_curso = 2;
            }
        }else{
            $modal_curso = 1;
        }
    }else{
        header('Location: ./cursos.php');
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DEVLINE - <?php echo($nome_curso); ?></title>
        <noscript><meta http-equiv="refresh" content="0; URL='./error_js_disable.html '"/></noscript>
        <link rel="icon" type="image/jpg" href="../src/img/flavicon.png" />
        <link rel="stylesheet" href="../src/css/styles_pagina_curso.css">
        <link rel="stylesheet" href="../src/css/styles_default.css">
        <link rel="stylesheet" href="../src/css/styles_modal.css">
    </head>
    <body>
        <header>
            <?php
                include_once('./header.php');
            ?>
        </header>
        <section class="modalBg">
            <section class="modal modal_error_ativar_curso">
                <section class="modal_content">   
                    <section class="x_fechar_modal" onclick="fecharModal(0)"><img src="../src/img/letra-x.png"></section>
                    <p class="msg_error_curso_limite">Deseja ativar o curso<br><?php echo($nome_curso); ?></p>
                    <a href="../control/control_curso_ativate.php?id_curso=<?php echo($id_curso); ?>"><section class="button medium">Ativar</section></a>
                </section>
            </section>
            <section class="modal modal_error_ativar_curso">
                <section class="modal_content">   
                    <section class="x_fechar_modal" onclick="fecharModal(1)"><img src="../src/img/letra-x.png"></section>
                    <p class="msg_error_curso_limite">Você deve estar logado<br>para ativar o curso<br><?php echo($nome_curso); ?></p>
                    <a href="./login.php"><section class="button medium">Logar</section></a>
                </section>
            </section>
            <section class="modal modal_error_ativar_curso">
                <section class="modal_content">   
                    <section class="x_fechar_modal" onclick="fecharModal(2)"><img src="../src/img/letra-x.png"></section>
                    <p class="msg_error_curso_limite">Você atingiu o numero<br>maximo de cursos ativos</p>
                    <?php
                        if (isset($_SESSION['user'])) {
                            if ($cursos_ativos == "") {
                                $cursos_ativos_msg_error = 0;
                            }
            
                            if ($nivel == "Default") {
                                $cursos_ativos_msg_error = $cursos_ativos.'/1';
                                echo('
                                    <section class="cursos_ativos_msg">
                                        <p>Cursos ativos</p>
                                        <span>'.$cursos_ativos_msg_error.'</span>
                                    </section>
                                    <p class="msg_seja_dv_curso">Assine um plano para<br>ativar mais cursos</p>
                                    <a href="./seja_dv.php"><section class="button medium">Seja DV</section></a>
                                ');
                            }elseif ($nivel == "DV Pro") {
                                $cursos_ativos_msg_error = $cursos_ativos.'/2';
                                echo('
                                    <section class="cursos_ativos_msg">
                                        <p>Cursos ativos</p>
                                        <span>'.$cursos_ativos_msg_error.'</span>
                                    </section>
                                    <p class="msg_seja_dv_curso">Assine um plano para<br>ativar mais cursos</p>
                                    <a href="./config_pagamentos.php"><section class="button medium">Seja DV</section></a>
                                ');
                            }elseif ($nivel == "DV Elite") {
                                $cursos_ativos_msg_error = $cursos_ativos.'/5';
                                echo('
                                    <section class="cursos_ativos_msg">
                                        <p>Cursos ativos</p>
                                        <span>'.$cursos_ativos_msg_error.'</span>
                                    </section>
                                ');
                            }
                        }
                    ?>
                </section>
            </section>
        </section>
        <section class="main_pag_curso">
            <?php
                if (isset($_SESSION['user'])) {
                    if ($cursos_ativos == "") {
                        $cursos_ativos = 0;
                    }
    
                    if ($nivel == "Default") {
                        $cursos_ativos = $cursos_ativos.'/1';
                    }elseif ($nivel == "DV Pro") {
                        $cursos_ativos = $cursos_ativos.'/2';
                    }elseif ($nivel == "DV Elite") {
                        $cursos_ativos = $cursos_ativos.'/5';
                    }
    
                    echo('
                        <section class="cursos_ativos">
                            <p>Cursos ativos</p>
                            <span>'.$cursos_ativos.'</span>
                        </section>
                    ');
                }
            ?>
            <section class="sec_banner_top">
                <section class="banner">
                    <img src="../src/img/CURSOS/BANNERS/<?php echo($ft_banner); ?>" alt="Banner curso">
                </section>
                <section class="banner_bottom">
                    <section class="capa">
                        <img src="../src/img/CURSOS/CAPAS/<?php echo($ft_capa); ?>" alt="Capa curso">
                    </section>
                    <h2 class="title_pag_curso"><?php echo($nome_curso); ?></h2>
                </section>
                <section class="banner_desc">
                    <section class="banner_btn_svd">
                        <?php
                            if ($cursos_ativos_checked == "true") {
                                echo('<a href="./player_video.php?id_curso='.$id_curso.'&cod_modulo='.$id_curso.'M1"><section class="transparent btn_curso_atv")">Curso ativo</section></a>');
                            }else{
                                echo('<section class="button btn_curso" onclick="exibirModal('.$modal_curso.')">Ativar curso</section>');
                            }
                        ?>
                        <form id="form_salvos" action="../control/control_salvos.php" method="post">
                            <input type="hidden" name="id_curso" value="<?php echo($id_curso); ?>">
                            <input type="submit" name="submit_saved" id="submit_saved">
                            <label for="submit_saved"><?php if (isset($_SESSION['user'])) { if ($salvos_checked == "true"){ echo("<img class='tam_img_salvos' src='../src/img/SALVO_CHECKED.png' >"); } else { echo("<img class='tam_img_salvos' src='../src/img/SALVO_NOT.png' >"); } }else{ echo("<style> #form_salvos { display: none; }  .btn_curso { width: 256px; } </style>"); } ?></label>
                        </form>
                    </section>
                    <p class="desc_curso"><?php echo($desc_curso); ?></p>
                </section>
                <section class="mod_cursos">
                    <h2 class="title_mod_curso">MODULOS</h2>
                    <section class="cards_mod">
                        <?php 
                            $id_modulo = $id_curso.'M';

                            $res_mod = $pdo->query("SELECT * FROM modulos WHERE cod_modulo LIKE '$id_modulo%'");
                                                    
                            $dados_mod = $res_mod->fetchAll(PDO::FETCH_ASSOC);
                            $rows_mod = count($dados_mod);
                            
                            if ($rows_mod > 0) {
                                for ($i=0; $i < count($dados_mod); $i++) { 
                                    echo('
                                        <section class="card_mod">
                                            <section class="capa_card_mod">
                                                <img src="../src/img/CURSOS/BANNERS/'.$dados_mod[$i]['capa'].'">
                                            </section>
                                            <h2 class="title_mod">'.$dados_mod[$i]['nome'].'</h2>
                                            <p class="desc_mod">'.$dados_mod[$i]['descricao'].'</p>
                                            <section class="hover_card"><img src="../src/img/SETAS_DUPLAS.png"></section>
                                        </section>
                                    ');
                                }
                            }
                        ?>
                    </section>
                </section>
            </section>
        </section>
        <footer>
            <?php
                include_once('./footer.php');
            ?>  
        </footer>
        <script>
            const modal = document.querySelectorAll(".modal");
            const modalBg = document.querySelectorAll(".modalBg");
            
            function exibirModal(e) {
                modal[e].style.display = 'flex'
                modalBg[0].style.display = 'flex'
            }

            function fecharModal(e) {
                modal[e].style.display = 'none'
                modalBg[0].style.display = 'none'
            }
        </script>
    </body>
</html>