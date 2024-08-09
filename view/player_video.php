<?php
    require_once("../control/control_conexao.php");
    require_once("../control/control_session.php");

    if (isset($_GET['id_curso'])) {
        $id_curso = $_GET['id_curso'];
        $cod_modulo = $_GET['cod_modulo'];

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
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/jpg" href="../src/img/flavicon.png" />
        <noscript><meta http-equiv="refresh" content="0; URL='./error_js_disable.html '"/></noscript>
        <title><?php echo($nome_curso); ?></title>
        <link rel="stylesheet" href="../src/css/styles_default.css">
        <link rel="stylesheet" href="../src/css/styles_player_video.css">
    </head>
    <body>
        <a href="./meus_cursos.php"><img id="logo" src="../src/img/LOGO_DV.png"></a>
        <section class="main_player_video">
            <section>
                <?php
                    if (isset($cod_modulo)) {
                        $res_modulo = $pdo->query("SELECT * FROM modulos WHERE cod_modulo='$cod_modulo'");
                                        
                        $dados_modulo = $res_modulo->fetchAll(PDO::FETCH_ASSOC);
                        $rows_modulo = count($dados_modulo);
                
                        if ($rows_modulo > 0) {
                            for ($i=0; $i < count($dados_modulo); $i++) { 
                                $nome_modulo = $dados_modulo[$i]['nome'];
                                $desc_modulo = $dados_modulo[$i]['descricao'];
                                $aula_modulo = $dados_modulo[$i]['aula'];
                                $chat_modulo = $dados_modulo[$i]['chat'];
                            }

                            echo('
                                <style>
                                    #list_mod_item_'.$cod_modulo.' {
                                        background: #ff0149;
                                    }
                                </style>
                            ');
                        }

                        if (isset($_SESSION['user'])) {
                            $res_aluno_fav = $pdo->prepare("SELECT * FROM aluno WHERE usuario = :usuario");
                
                            $res_aluno_fav->bindValue(":usuario", $_SESSION['user']);
                            $res_aluno_fav->execute();
                        
                            $dados_aluno_fav = $res_aluno_fav->fetchAll(PDO::FETCH_ASSOC);
                        
                            for ($i=0; $i < count($dados_aluno_fav); $i++) { 
                                $fav_brut = $dados_aluno_fav[$i]['favoritos'];
                            }
                    
                            $fav_checked = 0;
                            
                            if ($fav_brut > 0) {
                                $fav = explode("F", $fav_brut);
                    
                                for ($i=0; $i < count($fav); $i++) { 
                                    if ($fav[$i] == $cod_modulo) {
                                        $fav_checked = "true";
                                    }
                                }
                            }
                        }
                    }
                ?>
                <section class="video_player">
                    <?php echo($aula_modulo); ?>
                </section>
                <p class="title_curso"><?php echo($nome_curso); ?></p>
                <section class="align_fav">
                    <p class="title_modulo"><?php echo($nome_modulo); ?></p>
                    <?php if (isset($_SESSION['user'])) { if ($fav_checked == "true"){ echo("<a href='../control/control_favoritos.php?id_curso=".$id_curso."&cod_modulo=".$cod_modulo."&fav_verif=true'><img src='../src/img/estrela_fav.png' ></a>"); } else { echo("<a href='../control/control_favoritos.php?id_curso=".$id_curso."&cod_modulo=".$cod_modulo."&fav_verif=false'><img src='../src/img/estrela.png' ></a>"); } } ?>
                </section>
                <p class="desc_modulo"><?php echo($desc_modulo); ?></p>
            </section>
            <section class="list_mods">
                <?php
                    $id_curso_new = $id_curso.'M';
                    $res_modulo_list = $pdo->query("SELECT * FROM modulos WHERE cod_modulo LIKE '$id_curso_new%'");
                                        
                    $dados_modulo_list = $res_modulo_list->fetchAll(PDO::FETCH_ASSOC);
                    $rows_modulo_list = count($dados_modulo_list);
            
                    if ($rows_modulo_list > 0) {
                        for ($i=0; $i < count($dados_modulo_list); $i++) {
                            echo('
                                <a href="./player_video.php?id_curso='.$id_curso.'&cod_modulo='.$dados_modulo_list[$i]['cod_modulo'].'">
                                    <section class="list_mods_item" id="list_mod_item_'.$dados_modulo_list[$i]['cod_modulo'].'">
                                        <section class="capa_list_mod"><img src="../src/img/CURSOS/BANNERS/'.$dados_modulo_list[$i]['capa'].'"></section>
                                        <p class="text_list_mod">'.$i + 1 .'. '.$dados_modulo_list[$i]['nome'].'</p>
                                    </section>
                                </a>
                            ');
                        }
                    }
                ?>
            </section>
        </section>
        <footer>
            <?php
                include_once('./footer.php');
            ?>
        </footer>
    </body>
</html>