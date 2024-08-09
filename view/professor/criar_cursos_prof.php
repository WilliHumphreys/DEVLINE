<?php
    require_once("../../control/control_conexao.php");
    require_once("../../control/control_session.php");

    $name_curso = 0;
    $file_banner = 0;
    $file_capa = 0;
    $desc_curso = 0;
    $categoria_curso = 0;
    $quant_curso = 0;
    $res_name_exist = 0;
    $professor = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DEVLINE - Criar curso</title>
        <link rel="icon" type="image/jpg" href="../../src/img/flavicon.png" />
        <link rel='stylesheet' type='text/css' media='screen' href='../../src/css/styles_default.css'>
        <link rel='stylesheet' type='text/css' media='screen' href='../../src/css/styles_criar_cursos_prof.css'>
        <noscript><meta http-equiv="refresh" content="0; URL='../error_js_disable.html '"/></noscript>
    </head>
    <body>
        <a href="../profile.php"><img id="logo" src="../../src/img/LOGO_DV_PROF.png"></a>
        <section class="main_criar_curso_prof">
            <section class="sec_criar_curso_prof left">
                <form id="form_curso" action="#" method="post" enctype="multipart/form-data"> 
                    <h2 class="title_criar_curso_prof">Criar curso</h2>
                    <section class="input-group">
                        <input name="name_curso" type="text" id="name_curso" class="input-group__input required formatarCampo"  maxlength="20" required>
                        <label for="name_curso" class="input-group__label msg_required">Nome do curso</label>
                    </section>
                    <section class="sec_file_banner">
                        <input type="file" name="file_banner" id="file_banner" required>
                        <label for="file_banner"><section class="label_file_banner">Imagem do banner</section></label>
                    </section>
                    <section class="sec_file_banner">
                        <input type="file" name="file_capa" id="file_capa" required>
                        <label for="file_capa"><section class="label_file_banner">Imagem de capa</section></label>
                    </section>
                    <section class="input-group">
                        <input name="desc_curso" type="text" id="desc_curso" class="input-group__input required formatarCampo"  maxlength="255" required>
                        <label for="desc_curso" class="input-group__label msg_required">Descrição</label>
                    </section>
                    <select class="input_prof" name="categoria_curso" required>
                        <option class="option_prof" value="" disabled selected>CATEGORIA</option>
                        <option class="option_prof" value="FRONT-END">FRONT-END</option>
                        <option class="option_prof" value="BACK-END">BACK-END</option>
                        <option class="option_prof" value="FULLL-STACK">FULLL-STACK</option>
                        <option class="option_prof" value="DE JOGOS">JOGOS</option>
                        <option class="option_prof" value="BANCO DE DADOS">BANCO DE DADOS</option>
                        <option class="option_prof" value="REDES">REDES</option>
                        <option class="option_prof" value="WEB DESIGNER">WEB DESIGN</option>
                        <option class="option_prof" value="UX DESIGNER">UX DESIGN</option>
                    </select>   
                    <section class="input-group">
                        <input name="quant_curso" type="number" id="quant_curso" class="input-group__input required formatarCampo" min="1" max="100" required>
                        <label for="quant_curso" class="input-group__label msg_required">Quantidade de modulos</label>
                    </section>   
                    <input style="display: none;" id="submit_criar_curso_prof" type="submit" name="submit_criar_curso_prof">
                    <label for="submit_criar_curso_prof"><section class="button medium">Adicionar modulos</section></label>       
                </form>
                    <?php
                        if (isset($_POST['submit_criar_curso_prof'])) {
                            $name_curso = $_POST['name_curso'];
                            $desc_curso = $_POST['desc_curso'];
                            $categoria_curso = $_POST['categoria_curso'];
                            $quant_curso = $_POST['quant_curso'];

                            $arqBannerName = $_FILES['file_banner']['name'];
                            $arqBannerType = $_FILES['file_banner']['type'];
                            $arqBannerSize = $_FILES['file_banner']['size'];
                            $arqBannerTemp = $_FILES['file_banner']['tmp_name'];
                            $arqBannerError = $_FILES['file_banner']['error'];

                            $arqCapaName = $_FILES['file_capa']['name'];
                            $arqCapaType = $_FILES['file_capa']['type'];
                            $arqCapaSize = $_FILES['file_capa']['size'];
                            $arqCapaTemp = $_FILES['file_capa']['tmp_name'];
                            $arqCapaError = $_FILES['file_capa']['error'];

                            $tiposPermitidos= array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png');

                            $res_name_exist = $pdo->query("SELECT * FROM cursos WHERE nome = '$name_curso'");

                            $dados_name_exist = $res_name_exist->fetchAll(PDO::FETCH_ASSOC);
                            $rows_name_exist = count($dados_name_exist);

                            if ($rows_name_exist == 0) {

                                /* SALVANDO O BANNER */

                                if ($arqBannerName != "") {
                                    $tamanhoPermitido = 3456 * 1728; 
                        
                                    if ($arqBannerError == 0) {
                                        if (array_search($arqBannerType, $tiposPermitidos) === false) {
                                        echo("<script> alert('O tipo de arquivo enviado é inválido!'); </script>");
                                        } else if ($arqBannerSize > $tamanhoPermitido) {
                                        echo("<script> alert('O tamanho do arquivo enviado é maior que o limite!'); </script>");
                                        } else {
                        
                                            $pasta = '../../src/img/CURSOS/BANNERS/';
                                            $extensao_explode = explode('.', $arqBannerName);
                                            $extensao = strtolower(end($extensao_explode));
                                            $nomeBanner = time() . "_BANNER_" . $professor . '.' . $extensao;
                        
                                            $upload = move_uploaded_file($arqBannerTemp, $pasta . $nomeBanner);
                        
                                        }
                                    }
                                }

                                /* SALVANDO A CAPA */

                                if ($arqCapaName != "") {
                                    $tamanhoPermitido = 1224 * 1224; 
                        
                                    if ($arqCapaError == 0) {
                                        if (array_search($arqCapaType, $tiposPermitidos) === false) {
                                        echo("<script> alert('O tipo de arquivo enviado é inválido!'); </script>");
                                        header("Location: ../view/profile.php");
                                        } else if ($arqCapaSize > $tamanhoPermitido) {
                                        echo("<script> alert('O tamanho do arquivo enviado é maior que o limite!'); </script>");
                                        } else {
                        
                                            $pasta = '../../src/img/CURSOS/CAPAS/';
                                            $extensao_explode = explode('.', $arqBannerName);
                                            $extensao = strtolower(end($extensao_explode));
                                            $nomeCapa = time() . "_CAPA_" . $professor . '.' . $extensao;
                        
                                            $upload = move_uploaded_file($arqCapaTemp, $pasta . $nomeCapa);
                        
                                        }
                                    }
                                }

                                $pdo->query("INSERT INTO cursos (nome, descricao, categoria, ft_capa, ft_banner, professor, modulos, status) VALUES ('$name_curso','$desc_curso','$categoria_curso','$nomeCapa','$nomeBanner','$professor','$quant_curso','EM ANALISE')");

                                echo('
                                    <style>
                                        #form_curso {
                                            display: none;
                                        }
                                    </style>
                                    <form action="../../control/control_criar_cursor_prof.php" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="nome_curso_pass" value="'.$name_curso.'">
                                        <h2 class="title_criar_curso_prof">Criar modulos</h2>
                                ');

                                for ($i=0; $i < $quant_curso; $i++) { 
                                    echo('
                                        <h2 class="title_criar_curso_prof">Modulo '. $i + 1 .'</h2>
                                        <section class="input-group">
                                            <input name="name_mod_'.$i.'" type="text" id="name_mod" class="input-group__input required formatarCampo inp_name_mod"  maxlength="20" required>
                                            <label for="name_mod" class="input-group__label msg_required">Nome do modulo</label>
                                        </section>
                                        <section class="input-group">
                                            <input name="desc_mod_'.$i.'" type="text" id="desc_mod" class="input-group__input required formatarCampo inp_desc_mod"  maxlength="255" required>
                                            <label for="desc_mod" class="input-group__label msg_required">Descrição do modulo</label>
                                        </section>
                                        <section class="sec_file_banner">
                                            <input type="file" name="file_capa_mod_'.$i.'" id="file_capa_mod" class="inp_capa_mod" required>
                                            <label for="file_capa_mod"><section class="label_file_banner">Capa do modulo</section></label>
                                        </section>
                                        <section class="input-group">
                                            <input name="file_aula_'.$i.'" type="text" id="file_aula" class="input-group__input required formatarCampo"  maxlength="400" required>
                                            <label for="file_aula" class="input-group__label msg_required">Incorporar video</label>
                                        </section>
                                    ');
                                }

                                echo('
                                        <input style="display: none;" id="submit_criar_curso_prof_final" type="submit" name="submit_criar_curso_prof_final">
                                        <label for="submit_criar_curso_prof_final"><section class="button medium">Criar curso</section></label> 
                                    </form>
                                ');
                            }
                        }
                    ?>   
            </section>
            <section class="right">
                <?php
                    if (isset($_POST['submit_criar_curso_prof'])) {
                        $name_curso = $_POST['name_curso'];
                        $res_name_rec = $pdo->query("SELECT * FROM cursos WHERE nome = '$name_curso'");
                
                        $dados_name_rec = $res_name_rec->fetchAll(PDO::FETCH_ASSOC);
                        $rows_name_rec = count($dados_name_rec);
                
                        for ($i=0; $i < count($dados_name_rec); $i++) { 
                            $capaCurso = $dados_name_rec[$i]['ft_capa'];
                            $bannerCurso = $dados_name_rec[$i]['ft_banner'];
                        }
                    }
                ?>
                <section class="top_banner_capa">
                    <section class="banner_prof"><img class="exibir_banner" src="../../src/img/CURSOS/BANNERS/<?php if (isset($_POST['submit_criar_curso_prof'])) { echo($bannerCurso); }else{ echo("BANNER_EXEMPLO_CRIACAO.png"); } ?>"></section>
                    <section class="capa_name_prof">
                        <section class="capa_prof"><img class="exibir_banner" src="../../src/img/CURSOS/CAPAS/<?php if (isset($_POST['submit_criar_curso_prof'])) { echo($capaCurso);   }else{ echo("CAPA_EXEMPLO_CRIACAO.png");   } ?>"></section>
                        <span class="name_curso_prof" id="exibir_name_curso"><?php if (isset($_POST['submit_criar_curso_prof'])) { echo($name_curso); }else{ echo("NOME DO CURSO"); } ?></span>
                    </section>
                </section>
                <section class="btn_desc_criar_curso_prof">
                    <section class="btn_criar_curso">Ativar curso</section>
                    <span id="exibir_desc_curso" class="desc_exibir_criar_curso"><?php if (isset($_POST['submit_criar_curso_prof'])) { echo($desc_curso); }else{ echo("Descrição do curso lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati tempore corporis quas facilis placeat quisquam reprehenderit dignissimos debitis dolore unde magni expedita at praesentium odit laboriosam, iste consequuntur? Minus, voluptatum."); } ?></span>
                </section>
                <section class="sec_mod_exibir">
                    <h2 class="title_sec_mod_exibir">Modulos</h2>
                    <section class="mod_exibir_grid">
                        <?php
                            if (isset($_POST['submit_criar_curso_prof'])) {
                                $quant_curso = $_POST['quant_curso'];

                                if ($rows_name_exist == 0) {
                                    for ($i=0; $i < $quant_curso; $i++) { 
                                        echo('
                                            <section class="card_mod">
                                                <section class="exibir_capa_mod">
                                                    <img src="../../src/img/CURSOS/BANNERS/'.$bannerCurso.'">
                                                </section>
                                                <h2 class="title_mod">MODULO '.$i + 1 .'</h2>
                                                <p class="desc_mod">Descrição do curso lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati tempore corporis quas facilis placeat quisquam reprehenderit dignissimos debitis dolore unde magni expedita at praesentium odit laboriosam, iste consequuntur? Minus, voluptatum.</p>
                                                <section class="hover_card"><img src="../../src/img/SETAS_DUPLAS.png"></section>
                                            </section>  
                                        ');
                                    }
                                }
                            }
                        ?>           
                    </section>
                </section>
            </section>
        </section>
        <script>
            var input_name_curso = document.getElementById('name_curso');
            var name_curso = document.getElementById('exibir_name_curso');
            const exibir_banner = document.querySelectorAll(".exibir_banner");
            const banner_custom = document.getElementById("file_banner");
            const capa_custom = document.getElementById("file_capa");
            var input_desc_curso = document.getElementById('desc_curso');
            var desc_curso = document.getElementById('exibir_desc_curso');
            const msg = document.querySelectorAll(".msg_required");
            const inputBorder = document.querySelectorAll(".input-group__input");

            function setError(index, msgError) {
                msg[index].style.color = "#FF0149";
                msg[index].innerText= msgError;
                inputBorder[index].style.outline = "2px solid #FF0149"
            }

            /* ALTERAR O NOME DE EXIBIÇÃO DO CURSO */

            input_name_curso.addEventListener("keyup", alterar_name);

            function alterar_name(e) {
                var name = e.target.value.toUpperCase();
                var v=e.target.value.toUpperCase();

                e.target.value = v;
                name_curso.innerText=name;

                if (name == "") {
                    name_curso.innerText="NOME DO CURSO";
                }
            }

            /* ALTERAR BANNER EXIBIR */

            capa_custom.addEventListener("change", readImageBanner, false);

            function readImageBanner() {
                if (this.files && this.files[0]) {
                    var file = new FileReader();
                    file.onload = function(e) {
                        exibir_banner[1].src = e.target.result;
                    };       
                    file.readAsDataURL(this.files[0]);
                }
            }

            /* ALTERAR CAPA EXIBIR */

            banner_custom.addEventListener("change", readImageCapa, false);

            function readImageCapa() {
                if (this.files && this.files[0]) {
                    var file = new FileReader();
                    file.onload = function(e) {
                        exibir_banner[0].src = e.target.result;
                    };       
                    file.readAsDataURL(this.files[0]);
                }
            }

            /* ALTERAR A DESCRIÇÃO DE EXIBIÇÃO DO CURSO */

            input_desc_curso.addEventListener("keyup", alterar_desc);

            function alterar_desc(e) {
                var name = e.target.value
                var v=e.target.value

                e.target.value = v;
                desc_curso.innerText=name;

                if (name == "") {
                    desc_curso.innerText="Descrição do curso lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati tempore corporis quas facilis placeat quisquam reprehenderit dignissimos debitis dolore unde magni expedita at praesentium odit laboriosam, iste consequuntur? Minus, voluptatum.";
                }
            }
        </script>
    </body>
</html>
<script>
    const inp_name_mod = document.querySelectorAll(".inp_name_mod");
    const inp_desc_mod = document.querySelectorAll(".inp_desc_mod");
    const title_mod = document.querySelectorAll(".title_mod");
    const desc_mod = document.querySelectorAll(".desc_mod");
    <?php 
        if (isset($_POST['submit_criar_curso_prof'])) {
            $quant_curso = $_POST['quant_curso'];
            for ($i=0; $i < $quant_curso; $i++) { 
                echo('

                        /* ALTERAR NOME DO CURSO EXIBIR */

                        inp_name_mod['.$i.'].addEventListener("keyup", alterar_name_mod_'.$i.');

                        function alterar_name_mod_'.$i.'(e) {
                            var name = e.target.value.toUpperCase();
                            var v=e.target.value.toUpperCase();

                            e.target.value = v;
                            title_mod['.$i.'].innerText=name;

                            if (name == "") {
                                title_mod['.$i.'].innerText="MODAL '.$i + 1 .'";
                            }
                        }

                        /* ALTERAR A DESCRIÇÃO DE EXIBIÇÃO DO MODULO */

                        inp_desc_mod['.$i.'].addEventListener("keyup", alterar_desc_mod_'.$i.');

                        function alterar_desc_mod_'.$i.'(e) {
                            var name = e.target.value
                            var v=e.target.value

                            e.target.value = v;
                            desc_mod['.$i.'].innerText=name;

                            if (name == "") {
                                desc_mod['.$i.'].innerText="Descrição do curso lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati tempore corporis quas facilis placeat quisquam reprehenderit dignissimos debitis dolore unde magni expedita at praesentium odit laboriosam, iste consequuntur? Minus, voluptatum.";
                            }
                        }
                ');
            }
        }
    ?>
</script>
<?php
    if (isset($_POST['submit_criar_curso_prof'])) {
        if ($rows_name_exist > 0) {
            echo('
                <script>
                    setError(0, "Curso já existente");
                </script>
            ');
        }
    }
?>