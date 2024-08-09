<?php
    require_once("../control/control_conexao.php");
    require_once("../control/control_session.php");

    if (isset($_SESSION['user'])) {
        $res_aluno_atvs = $pdo->prepare("SELECT * FROM aluno WHERE usuario = :usuario");

        $res_aluno_atvs->bindValue(":usuario", $_SESSION['user']);
        $res_aluno_atvs->execute();
    
        $dados_aluno_atvs = $res_aluno_atvs->fetchAll(PDO::FETCH_ASSOC);
    
        for ($i=0; $i < count($dados_aluno_atvs); $i++) { 
            $cursos_avts_brut = $dados_aluno_atvs[$i]['favoritos'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DEVLINE - Salvos</title>
        <link rel="stylesheet" href="../src/css/styles_meus_curso.css">
        <link rel="stylesheet" href="../src/css/styles_default.css">
    </head>
    <body>
        <a href="./profile.php"><img id="logo" src="../src/img/LOGO_DV.png"></a>
        <section class="main_meus_cursos">
            <h2 class="title_meus_cursos">Suas aulas favoritas</h2>
            <section class="container_cursos_favs">
                <?php
                    if ($cursos_avts_brut > 0) {
                        $cursos_atvs = explode("F", $cursos_avts_brut);

                        for ($i=0; $i < count($cursos_atvs); $i++) { 
                            $res = $pdo->query("SELECT * FROM modulos WHERE cod_modulo='$cursos_atvs[$i]'");
                                
                            $dados = $res->fetchAll(PDO::FETCH_ASSOC);

                            $id_curso = explode("M", $cursos_atvs[$i]);
                            
                            for ($i_curso=0; $i_curso < count($dados); $i_curso++) { 
                                echo('
                                    <a href="./player_video.php?id_curso='.$id_curso[0].'&cod_modulo='.$cursos_atvs[$i].'">
                                        <section class="card_cursos_favs">
                                            <span class="title_card_cursos">'.$dados[$i_curso]['nome'].'</span>
                                            <section class="capa_favs_mod"><img src="../src/img/CURSOS/MODULOS/CAPAS/'.$dados[$i_curso]['capa'].'"></section>
                                        </section>
                                    </a>
                                ');
                            }
                        }
                    }else{
                        echo('
                            <style>
                                .container_cursos_favs {
                                    display: flex;
                                }
                            </style>
                            <section class="align_msg_error_meus_cursos">
                                <h2 class="msg_error_meus_cursos">Você ainda não tem uma aula favorita</h2>
                            </section>
                        ');
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