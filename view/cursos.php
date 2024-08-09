<?php
    require_once("../control/control_conexao.php");
    require_once("../control/control_session.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DEVLINE - Cursos</title>
        <link rel="stylesheet" href="../src/css/styles_default.css">
        <link rel="stylesheet" href="../src/css/styles_cursos.css">
        <noscript><meta http-equiv="refresh" content="0; URL='./error_js_disable.html '"/></noscript>
        <link rel="icon" type="image/jpg" href="../src/img/flavicon.png" />
    </head>
    <body>
        <header>
            <?php
                include_once('./header.php');
            ?>
        </header>
        <section class="main_cursos">
            <section class="align_search_bar">
                <form class="search_bar" action="#" method="post">
                    <input type="text" name="search" id="input_text_search" maxlength="30" placeholder="Buscar cursos">
                    <input type="submit" name="submit_search" id="submit_search">
                    <label for="submit_search" id="lupa_search"><img src="../src/img/lupa.png"></label>
                </form>
            </section>
            <section class="container_cursos">
                <?php
                    if (!isset($_POST['submit_search'])) {
                        $res = $pdo->query("SELECT * FROM cursos");
                    
                        $dados = $res->fetchAll(PDO::FETCH_ASSOC);
                        
                        for ($i=0; $i < count($dados); $i++) { 
                            echo('
                                <a href="./pagina_curso.php?id_curso='.$dados[$i]['id_cursos'].'">
                                    <section class="card_cursos">
                                        <span class="title_card_cursos">'.$dados[$i]['nome'].'</span>
                                        <img src="../src/img/CURSOS/CAPAS/'.$dados[$i]['ft_capa'].'">
                                    </section>
                                </a>
                            ');
                        }
                    }

                    if (isset($_POST['submit_search'])) {
                        $search = strtoupper($_POST['search']);

                        $res = $pdo->query("SELECT * FROM cursos WHERE nome LIKE '$search%' OR categoria LIKE '$search%' OR professor LIKE '$search%'");
                    
                        $dados = 0;
                        
                        $dados = $res->fetchAll(PDO::FETCH_ASSOC);
                        $rows = count($dados);

                        if ($rows > 0) {
                            for ($i=0; $i < count($dados); $i++) { 
                                echo('
                                    <a href="./pagina_curso.php?id_curso='.$dados[$i]['id_cursos'].'">
                                        <section class="card_cursos">
                                            <span class="title_card_cursos">'.$dados[$i]['nome'].'</span>
                                            <img src="../src/img/CURSOS/CAPAS/'.$dados[$i]['ft_capa'].'">
                                        </section>
                                    </a>
                                ');
                            }
                        }else{
                            echo('
                                <style>
                                    .container_cursos {
                                        display: flex;
                                        justify-content: center;
                                        align-itens: center; 
                                    }

                                    .text_error_search {
                                        font-family: "AnonymousPro-Regular", monospace;
                                        color: #ffffff;
                                        font-size: 16pt;
                                        margin-bottom: 250px;
                                    }
                                </style>
                                <p class="text_error_search">Nenhum curso encontrado para o termo <strong>"'.$_POST['search'].'"</strong></p>
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