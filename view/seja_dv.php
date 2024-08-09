<?php
    require_once("../control/control_conexao.php");
    require_once("../control/control_session.php");

    date_default_timezone_set('America/Sao_Paulo');

    $dataLocal = date('d/m/Y H:i');

    $res = $pdo->prepare("SELECT * FROM aluno WHERE usuario = :usuario");

    $res->bindValue(":usuario", $_SESSION['user']);
    $res->execute();

    $dados = $res->fetchAll(PDO::FETCH_ASSOC);

    for ($i=0; $i < count($dados); $i++) { 
        $id_user = $dados[$i]['id_aluno'];
        $nivel = $dados[$i]['nivel'];
    }

    $res = $pdo->query("SELECT * FROM pacotes");
    $dados = $res->fetchAll(PDO::FETCH_ASSOC);

    $preco_DV_Pro = $dados[1]['preco'];
    $preco_DV_Elite = $dados[2]['preco'];
    $nome_DV_Pro = $dados[1]['nome'];
    $nome_DV_Elite = $dados[2]['nome'];

    if ($_SESSION['user_valid'] != "true") {
        header("Location: ./error_session_invalid.html");
    }elseif ($nivel != "Default") {
        header("Location: ./painel_pack.php");
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DEVLINE - Seja DV</title>
        <link rel="icon" type="image/jpg" href="../src/img/flavicon.png" />
        <link rel="stylesheet" href="../src/css/styles_default.css">
        <link rel="stylesheet" href="../src/css/styles_seja_dv.css">
        <link rel="stylesheet" href="../src/css/styles_modal.css">
        <noscript><meta http-equiv="refresh" content="0; URL='./error_js_disable.html '"/></noscript>
    </head>
    <body>
        <header>
            <?php
                include_once("./header.php");
            ?>
        </header>
        <form action="../control/control_form_packs.php" method="post">
            <input type="hidden" name="user_pack" value="<?php echo($_SESSION['user']); ?>">
            <input type="hidden" name="date_sale" value="<?php echo($dataLocal); ?>">
            <input type="hidden" name="cod_sale" value="<?php echo(date('dmYHi').$id_user); ?>">
            <section class="modalBg">
                <section class="modal modal_pag_pack">
                    <section class="modal_content">
                        <section class="md_cont_left md_muda_variavel">
                            <input class="inp_pack" type="hidden" name="name_pack" value="<?php echo($nome_DV_Pro); ?>">
                            <input class="inp_pack" type="hidden" name="preco_pack" value="<?php echo($preco_DV_Pro); ?>">
                            <section class="sec_mod_pag_title">
                                <h2><?php echo($nome_DV_Pro); ?></h2>
                            </section>
                            <section class="sec_mod_pag_res">
                                <h2>Resumo do pedido</h2>
                                <p>&copy; Devline LTDA</p>
                                <p>DATA: <?php echo($dataLocal); ?></p>
                                <p>CODIGO DO PEDIDO: <?php echo(date('dmYHi').$id_user); ?> </p>
                            </section>
                            <section class="sec_mod_pag_val">
                                <h2>Valor total</h2>
                                <span><?php echo($preco_DV_Pro.' / mês'); ?></span>
                            </section>
                            <section class="sec_mod_pag_btn">
                                <section class="button medium transparent" onclick="fecharModal(0)">Cancelar</section>
                            </section>
                        </section>
                        <section class="md_cont_left md_muda_variavel">
                            <input class="inp_pack" type="hidden" name="name_pack" value="<?php echo($nome_DV_Elite); ?>">
                            <input class="inp_pack" type="hidden" name="preco_pack" value="<?php echo($preco_DV_Elite); ?>">
                            <section class="sec_mod_pag_title">
                                <h2><?php echo($nome_DV_Elite); ?></h2>
                            </section>
                            <section class="sec_mod_pag_res">
                                <h2>Resumo do pedido</h2>
                                <p>&copy; Devline LTDA</p>
                                <p>DATA: <?php echo($dataLocal); ?></p>
                                <p>CODIGO DO PEDIDO: <?php echo(date('dmYHi').$id_user); ?> </p>
                            </section>
                            <section class="sec_mod_pag_val">
                                <h2>Valor total</h2>
                                <span><?php echo($preco_DV_Elite.' / mês'); ?></span>
                            </section>
                            <section class="sec_mod_pag_btn">
                                <section class="button medium transparent" onclick="fecharModal(0)">Cancelar</section>
                            </section>
                        </section>
                        <section class="md_cont_right">
                            
                                <?php
                                    include('./form_pagamento.html');
                                ?>
                            
                        </section>
                    </section>
                </section>
            </section>
        </form>
        <section class="main_seja_dv">
            <section class="container_seja_dv">
                <section class="seja_dv_packs">
                    <?php
                        $class_card = ['DV_Basic','DV_Pro','DV_Elite'];
                        $class_btn = ['btn_default','btn_dv_pro','btn_dv_elite'];
                        $class_preco = ['preco_default','',''];

                        $res = $pdo->query("SELECT * FROM pacotes");
                        $dados = $res->fetchAll(PDO::FETCH_ASSOC);

                        for ($i=0; $i < count($dados); $i++) { 
                            $nome = $dados[$i]['nome'];
                            $promo = $dados[$i]['promo'];
                            $preco = $dados[$i]['preco'];
                            $descricao = $dados[$i]['descricao'];
                            $exp_acessos = $dados[$i]['acessos'];
                            $acessos = explode("?",$exp_acessos);
                            $img_01 = $acessos[0];
                            $img_02 = $acessos[1];
                            $img_03 = $acessos[2];
                            $img_04 = $acessos[3];
                            $img_05 = $acessos[4];

                            echo('
                                <section class="seja_dv_cards '.$class_card[$i].'">
                                    <section class="seja_dv_nome">
                                        <h2>'.$nome.'</h2>
                                    </section>
                                    <section class="seja_dv_preco '.$class_preco[$i].'">
                                        <span class="dv_promo '.$class_preco[$i].'">'.$promo.'</span>
                                        <span class="dv_preco">'.$preco.'</span>
                                    </section>
                                    <section class="seja_dv_desc txt_'.$class_preco[$i].'">
                                        <p class="text_desc">'.$descricao.'</p>
                                        <section class="overflow_list_text overflow_list_text_'.$class_card[$i].'">
                                            <section class="align_text_list"><img class="img_text_list" src="../src/img/'.$img_01.'.png"><span class="text_list">Acesso a todos os cursos</span></section>
                                            <section class="align_text_list"><img class="img_text_list" src="../src/img/'.$img_02.'.png"><span class="text_list">Acesso a comunidade</span></section>
                                            <section class="align_text_list"><img class="img_text_list" src="../src/img/'.$img_03.'.png"><span class="text_list">Certificações gratuitas</span></section>
                                            <section class="align_text_list"><img class="img_text_list" src="../src/img/'.$img_04.'.png"><span class="text_list">Suporte 24h</span></section>
                                            <section class="align_text_list"><img class="img_text_list" src="../src/img/'.$img_05.'.png"><span class="text_list">Cursos ilimitados</span></section>
                                        </section>
                                    </section>
                                    <section class="seja_dv_btn">
                                        <section class="btn_dv '.$class_btn[$i].'" onclick="exibirModal(0), muda_variavel('.$i - 1 .')">Assinar</section>
                                    </section>
                                </section>
                            ');
                        }
                    ?>
                </section>
                <section class="seja_dv_table">
                    <section class="sj_dv_sec left">
                        <h2 class="title_table">
                            Desperte Sua Excelência Profissional com o<br>Suporte DV Elite!
                        </h2>
                        <p class="desc_table">
                            Você aspira alcançar a excelência profissional? A Devline está aqui para apoiar cada passo da sua jornada. Com DV Elite, abra caminho para o sucesso e alcance seus objetivos profissionais com confiança. Seja DV, seja excepcional!  
                        </p>
                    </section>
                    <section class="sj_dv_sec right">
                        <section class="card_table_seja_dv">
                            <table>
                                <tr>
                                    <th>Beneficios</th>
                                    <th>DV Basic</th>
                                    <th>DV Pro</th>
                                    <th>DV Elite</th>
                                </tr>
                                <tr>
                                    <th>Acesso a todos os cursos</th>
                                    <th>2 cursos</th>
                                    <th><img class="img_text_list" src="../src/img/POSITIVO.png"></th>
                                    <th><img class="img_text_list" src="../src/img/POSITIVO.png"></th>
                                </tr>
                                <tr>
                                    <th>Acesso a comunidade</th>
                                    <th><img class="img_text_list" src="../src/img/POSITIVO.png"></th>
                                    <th><img class="img_text_list" src="../src/img/POSITIVO.png"></th>
                                    <th><img class="img_text_list" src="../src/img/POSITIVO.png"></th>
                                </tr>
                                <tr>
                                    <th>Certificações gratuitas</th>
                                    <th><img class="img_text_list" src="../src/img/NEGATIVO.png"></th>
                                    <th>1 por mês</th>
                                    <th>3 por mês</th>
                                </tr>
                                <tr>
                                    <th>Limite de cursos ativos</th>
                                    <th>1</th>
                                    <th>2</th>
                                    <th>5</th>
                                </tr>
                                <tr>
                                    <th>Acesso a comunidade Elite</th>
                                    <th><img class="img_text_list" src="../src/img/NEGATIVO.png"></th>
                                    <th><img class="img_text_list" src="../src/img/NEGATIVO.png"></th>
                                    <th><img class="img_text_list" src="../src/img/POSITIVO.png"></th>
                                </tr>
                                <tr>
                                    <th>Suporte VIP</th>
                                    <th><img class="img_text_list" src="../src/img/NEGATIVO.png"></th>
                                    <th><img class="img_text_list" src="../src/img/NEGATIVO.png"></th>
                                    <th><img class="img_text_list" src="../src/img/POSITIVO.png"></th>
                                </tr>
                            </table>
                        </section>
                    </section>
                </section>
            </section>
        </section>
        <footer>
            <?php
               include_once("./footer.php");
            ?>
        </footer>
        <script>
            const modal = document.querySelectorAll(".modal");
            const modalBg = document.querySelectorAll(".modalBg");
            const  md_muda_variavel = document.querySelectorAll(".md_muda_variavel");
            const  inp_pack = document.querySelectorAll(".inp_pack");

            function  muda_variavel(e) {
                if (e == 0) {
                    md_muda_variavel[e].style.display = 'block';
                    md_muda_variavel[e + 1].style.display = 'none';
                    inp_pack[0].disabled = false;
                    inp_pack[1].disabled = false;
                    inp_pack[2].disabled = true;
                    inp_pack[3].disabled = true;
                    
                }else {
                    md_muda_variavel[e].style.display = 'block';
                    md_muda_variavel[e - 1].style.display = 'none';
                    inp_pack[0].disabled = true;
                    inp_pack[1].disabled = true;
                    inp_pack[2].disabled = false;
                    inp_pack[3].disabled = false;
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
    </body>
</html>