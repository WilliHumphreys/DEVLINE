<?php
    require_once("../control/control_conexao.php");
    require_once("../control/control_session.php");

    if (isset($_SESSION['user'])) {
        $res_aluno_atvs = $pdo->prepare("SELECT * FROM aluno WHERE usuario = :usuario");

        $res_aluno_atvs->bindValue(":usuario", $_SESSION['user']);
        $res_aluno_atvs->execute();
    
        $dados_aluno_atvs = $res_aluno_atvs->fetchAll(PDO::FETCH_ASSOC);
    
        for ($i=0; $i < count($dados_aluno_atvs); $i++) { 
            $cursos_avts_brut = $dados_aluno_atvs[$i]['cod_cursos_ativos'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DEVLINE - Cursos ativos</title>
        <link rel="stylesheet" href="../src/css/styles_meus_curso.css">
    </head>
    <body>
        <header>
            <?php
                include_once('./header.php');
            ?>
        </header>
        <section class="main_meus_cursos">
            <h2 class="title_meus_cursos">Seus cursos ativos</h2>
            <section class="container_cursos">
                <?php
                    if ($cursos_avts_brut > 0) {
                        $cursos_atvs = explode("A", $cursos_avts_brut);

                        for ($i=0; $i < count($cursos_atvs); $i++) { 
                            $res = $pdo->query("SELECT * FROM cursos WHERE id_cursos='$cursos_atvs[$i]'");
                                
                            $dados = $res->fetchAll(PDO::FETCH_ASSOC);
                            
                            for ($i_curso=0; $i_curso < count($dados); $i_curso++) { 
                                echo('
                                    <a href="./player_video.php?id_curso='.$dados[$i_curso]['id_cursos'].'&cod_modulo='.$dados[$i_curso]['id_cursos'].'M1">
                                        <section class="card_cursos">
                                            <span class="title_card_cursos">'.$dados[$i_curso]['nome'].'</span>
                                            <img src="../src/img/CURSOS/CAPAS/'.$dados[$i_curso]['ft_capa'].'">
                                        </section>
                                    </a>
                                ');
                            }
                        }
                    }else{
                        echo('
                            <style>
                                .container_cursos {
                                    display: flex;
                                }
                            </style>
                            <section class="align_msg_error_meus_cursos">
                                <h2 class="msg_error_meus_cursos">Ainda não á nenhum curso ativo</h2>
                                <a href="./cursos.php"><section class="button medium">Ativar curso</section></a>
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