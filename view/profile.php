<?php
    require_once("../control/control_conexao.php");
    require_once("../control/control_session.php");

    if (isset($_SESSION['cont_prof_negado'])) {
        if ($_SESSION['cont_prof_negado'] == "true") {
            $email_delet = $_SESSION['cont_prof_negado_email'];
            $pdo->query("DELETE FROM professor WHERE email = '$email_delet'");
        }
    }

    if ($_SESSION['user_valid'] != "true" || $_SESSION['user_type'] == "adm") {
        header("Location: ./error_session_invalid.html");
    }

    $username = 0;
    $ft_perfil = 0;
    $rank = 0;
    $dvbucks = 0;

    echo('
        <style>
            #header_profile {
                display: none;
            }
        </style>
    ');

    $res = $pdo->prepare("SELECT * FROM aluno WHERE usuario = :usuario");

    $res->bindValue(":usuario", $_SESSION['user']);
    $res->execute();

    $dados = $res->fetchAll(PDO::FETCH_ASSOC);

    for ($i=0; $i < count($dados); $i++) { 
        $username = $dados[$i]['usuario'];
        $ft_perfil = $dados[$i]['ft_perfil'];
        $rank = $dados[$i]['rank'];
        $dvbucks = $dados[$i]['dvbucks'];
    }

    if ($rank != 1) {
        echo('
            <style>
                #king_rank {
                    display: none;
                }
            </style>
        ');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>DEVLINE - Perfil</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel="icon" type="image/jpg" href="../src/img/flavicon.png" />
        <link rel='stylesheet' type='text/css' media='screen' href='../src/css/styles_default.css'>
        <link rel='stylesheet' type='text/css' media='screen' href='../src/css/styles_profile.css'>
        <link rel='stylesheet' type='text/css' media='screen' href='../src/css/styles_modal.css'>
        <noscript><meta http-equiv="refresh" content="0; URL='./error_js_disable.html '"/></noscript>
    </head>
    <body class="body_corection">
        <header>
            <?php
                include_once("./header.php");
            ?>
        </header>
        <section class="modalBg">
          <section class="modal avatar_profile">
            <section class="modal_content avatar_content">
                <form class="inp_avatar_default" action="../control/control_atualizate.php" method="POST" enctype="multipart/form-data">
                    <input class="required" id="avatar_default_01"  type="radio" name="avatar_profile" value="1">
                    <input class="required" id="avatar_default_02"  type="radio" name="avatar_profile" value="2">
                    <input class="required" id="avatar_default_03"  type="radio" name="avatar_profile" value="3">
                    <input class="required" id="avatar_default_04"  type="radio" name="avatar_profile" value="4">
                    <input class="required" id="avatar_default_05"  type="radio" name="avatar_profile" value="5">
                    <input class="required" id="avatar_default_06"  type="radio" name="avatar_profile" value="6">
                    <input class="required" id="avatar_default_07"  type="radio" name="avatar_profile" value="7">
                    <input class="required" id="avatar_default_08"  type="radio" name="avatar_profile" value="8">
                    <input class="required" id="avatar_default_09"  type="radio" name="avatar_profile" value="9">
                    <input class="required" id="avatar_default_010" type="radio" name="avatar_profile" value="10">
                    <input class="required" id="avatar_default_011" type="radio" name="avatar_profile" value="11">
                    <input class="required" id="avatar_default_012" type="radio" name="avatar_profile" value="12">
                    <input class="required" id="avatar_default_013" type="radio" name="avatar_profile" value="13">
                    <input class="required" id="avatar_default_014" type="radio" name="avatar_profile" value="14">
                    <input class="required" id="avatar_default_015" type="radio" name="avatar_profile" value="15">
                    <input id="avatar_custom"      type="file"  name="avatar_custom"  accept="image/png, image/jpeg, image/gif, image/pjpeg" oninput="verifyFile()">
                    <input id="submit_avatar"      type="submit" name="submit_avatar">
                </form>
                <h1 class="text_avatar">Alterar foto de perfil</h1>
                <section class="avatar_image_overflow">
                    <section class="avatar_image_grid">
                        <label for="avatar_custom" id="avatar_custom_lb" class="avatar_image"><img class="custom" src="../src/img/PLUS.png"></label>
                        <?php
                            for ($i=1; $i < 16; $i++) { 
                                echo('<label for="avatar_default_0'.$i.'" class="avatar_image"><img class="default" src="../src/img/PROFILES/PROFILE_AVATAR_0'.$i.'.png"></label>');
                            }
                        ?>
                    </section>
                </section>
                <section class="avatar_buttons">
                    <label for="submit_avatar"><section class="button medium">Aplicar</section></label>
                    <section class="button medium transparent" onclick="fecharModal(0)">Cancelar</section>
                </section>
            </section>
          </section>
          <section class="modal update_user_modal">
            <section class="modal_content user_mod_content">
                <h1 class="title_user_modal">Alterar nome<br>de usuario</h1>
                <form id="form_update_username" class="form_update_username" action="#" method="POST">
                    <section class="input-group">
                        <input name="usuario" type="text" id="usuario" class="input-group__input campos formatarCampo" maxlength="15" oninput="userUpValidate()" required>
                        <label for="usuario" class="input-group__label msg_required">Usuario</label>
                    </section>
                    <input class="submit_username_class" type="submit" name="submit_username" id="submit_username">
                    <section class="username_buttons">
                        <section id="btn_username_submit-invalid" class="button btn_username btn_username_update">Alterar</section>
                        <label id="btn_username_submit" class="btn_username_update" for="submit_username"><section class="button btn_username">Alterar</section></label>
                        <section class="button transparent btn_username" onclick="fecharModal(1)">Cancelar</section>
                    </section>
                </form>
                <?php
                    if (isset($_POST['submit_username'])) {
                        $newUsername = $_POST['usuario'];
                        $_SESSION['newUsername'] = $newUsername;

                        $resUp = $pdo->prepare("SELECT * FROM aluno WHERE usuario = :usuario");

                        $resUp->bindValue(":usuario", $newUsername);
                        $resUp->execute();

                        $dadosUp = $resUp->fetchAll(PDO::FETCH_ASSOC);
                        $rows = count($dadosUp);

                        if ($rows > 0) {
                            echo('
                                <script>
                                    setTimeout(() => {
                                        exibirModal(1);
                                        setError(0, "Usuario indisponivel");
                                    }, 20);
                                </script>
                            ');
                        }else{
                            echo('
                                <style>
                                    .title_user_modal {
                                        display: none;
                                    }

                                    .form_update_username {
                                        display: none;
                                    }

                                    .title_user_modal_password {
                                        letter-spacing: 1px;
                                        font-family: "Anton", sans-serif;
                                        text-transform: uppercase;
                                        color: #ffffff;
                                        font-size: 20pt;
                                        text-align: center;
                                    }
                                </style>
                                <h1 class="title_user_modal_password">Confirme sua senha<br>para continuar</h1>
                                <form class="form_update_username_password" action="../control/control_update_user.php" method="POST">
                                    <section class="input-group">
                                        <input name="senha_up" type="password" id="senha_lg" class="input-group__input required password" maxlength="32" required>
                                        <label for="senha_lg" class="input-group__label msg_required">Senha</label>
                                        <span class="lnr lnr-eye"></span>
                                    </section>
                                    <input class="submit_username_class" type="submit" name="submit_username_password" id="submit_username_password">
                                    <section class="username_buttons">
                                        <label for="submit_username_password"><section class="button btn_username">Alterar</section></label>
                                        <section class="button transparent btn_username" onclick="fecharModal(1)">Cancelar</section>
                                    </section>
                                </form>
                                <script>
                                    setTimeout(() => {
                                        exibirModal(1);
                                    }, 20);
                                </script>
                            ');
                        }
                    }

                    if (isset($_SESSION['password_valid'])) {
                        if ($_SESSION['password_valid'] == "false") {
                          echo('
                              <style>
                                  .title_user_modal {
                                      display: none;
                                  }
                  
                                  .form_update_username {
                                      display: none;
                                  }
                  
                                  .title_user_modal_password {
                                      letter-spacing: 1px;
                                      font-family: "Anton", sans-serif;
                                      text-transform: uppercase;
                                      color: #ffffff;
                                      font-size: 20pt;
                                      text-align: center;
                                  }
                              </style>
                              <h1 class="title_user_modal_password">Confirme sua senha<br>para continuar</h1>
                              <form class="form_update_username_password" action="../control/control_update_user.php" method="POST">
                                  <section class="input-group">
                                      <input name="senha_up" type="password" id="senha_lg" class="input-group__input required password" maxlength="32" required>
                                      <label for="senha_lg" class="input-group__label msg_required">Senha</label>
                                      <span class="lnr lnr-eye"></span>
                                  </section>
                                  <input class="submit_username_class" type="submit" name="submit_username_password" id="submit_username_password">
                                  <section class="username_buttons">
                                      <label for="submit_username_password"><section class="button btn_username">Alterar</section></label>
                                      <section class="button transparent btn_username" onclick="fecharModal(1)">Cancelar</section>
                                  </section>
                              </form>
                              <script>
                                  setTimeout(() => {
                                      exibirModal(1);
                                      setError(1, "Senha incorreta");
                                  }, 20);
                              </script>
                          ');
                        }
                    }
                ?>
            </section>
          </section>
        </section>
        <section class="main_profile">
            <section id="card_profile">
                <section class=" card_top">
                    <?php
                        if ($_SESSION['user_type'] == "aluno") {
                            echo('
                                <section class="icon_dvbucks">
                                    <section class="dv_container">
                                        <img src="../src/img/DVBUCKS_ICON.png">
                                        <span class="dvbucks">'.$dvbucks.'</span>
                                    </section>
                                </section>
                                <section class="avatar_rank">
                                    <section class="avatar_username">
                                        <figure class="avatar_container">
                                            <img id="profile_image" src="../src/img/PROFILES/'.$ft_perfil.'" alt="IMAGEM DE PERFIL">
                                        </figure>
                                        <section class="avatar_container_hover" onclick="exibirModal(0)">
                                            <img id="edit_img" src="../src/img/EDITAR.png">
                                        </section>
                                        <section class="user_container" onclick="exibirModal(1)">
                                            <span class="username">'.$username.'</span>
                                            <img id="edit_username" src="../src/img/EDITAR.png">
                                        </section>
                                    </section>
                                    <section class="hex_rank">
                                        <section class="hex">
                                            <img id="king_rank" src="../src/img/KING_RANK.png">
                                            <span class="rank">'.$rank.'</span>
                                            <p class="rank_text">RANK</p>
                                        </section>
                                    </section>
                                </section>
                            ');
                        }elseif ($_SESSION['user_type'] == "professor") {
                            $res = $pdo->prepare("SELECT * FROM professor WHERE usuario = :usuario");

                            $res->bindValue(":usuario", $_SESSION['user']);
                            $res->execute();

                            $dados = $res->fetchAll(PDO::FETCH_ASSOC);

                            for ($i=0; $i < count($dados); $i++) { 
                                $username = $dados[$i]['usuario'];
                                $cpf = $dados[$i]['cpf'];
                            }

                            $res_prof_aluno = $pdo->query("SELECT * FROM aluno WHERE cpf = '$cpf'");

                            $dados_prof_aluno = $res_prof_aluno->fetchAll(PDO::FETCH_ASSOC);

                            for ($i=0; $i < count($dados_prof_aluno); $i++) { 
                                $ft_perfil = $dados_prof_aluno[$i]['ft_perfil'];
                            }

                            echo('
                            <style>
                                #hexagono {
                                    margin-top: 4px;
                                    width: 128px;
                                    height: 133px;
                                    background: transparent url(../src/img/PROFILES/'.$ft_perfil.') no-repeat; 
                                    background-size: cover;
                                    background-position: center center;
                                    position: relative;
                                }
                                
                            </style>
                            <section class="avatar_rank_prof">
                                <section class="avatar_username_hexg">
                                    <img class="logo_card_prof_front" src="../src/img/flavicon.png">
                                    <figure class="avatar_container_hexg">
                                        <div id="hexagono"></div>
                                    </figure>
                                    <section class="avatar_container_hover_hexg" onclick="exibirModal(0)">
                                        <img id="edit_img" src="../src/img/EDITAR.png">
                                    </section>
                                    <section class="user_container" onclick="exibirModal(1)">
                                        <span class="username_hexg">'.$username.'</span>
                                        <img id="edit_username_hexg" src="../src/img/EDITAR.png">
                                    </section>
                                    <p class="txt_professor">PROFESSOR</p>
                                </section>
                                <section class="card_btns_profile_prof">
                                    <a href="#"><section class="button medium transparent">Alunos</section></a>
                                    <a href="./professor/criar_cursos_prof.php"><section class="button medium transparent">Criar curso</section></a>
                                    <a href="./professor/meus_cursos_prof.php"><section class="button medium transparent">Meus cursos</section></a>
                                    <a href="#"><section class="button medium transparent">Faturamento</section></a>
                                </section>
                            </section>
                            ');
                        }
                    ?>
                </section>
                <section class=" card_botom">

                </section>
            </section>
        </section>
        <script>
            var campos = document.querySelectorAll(".campos");
            const msg = document.querySelectorAll(".msg_required");
            const inputBorder = document.querySelectorAll(".input-group__input");
            const modal = document.querySelectorAll(".modal");
            const modalBg = document.querySelectorAll(".modalBg");
            const required = document.querySelectorAll(".required");
            const avatar_image = document.querySelectorAll(".avatar_image");
            const avatar_custom = document.getElementById("avatar_custom");
            const avatar_custom_lb = document.getElementById("avatar_custom_lb");
            const custom = document.querySelectorAll(".custom");
            const btn_username_submit_invalid = document.getElementById("btn_username_submit-invalid");
            const btn_username_submit = document.getElementById("btn_username_submit");
            var validateCampos = 0;
            var validate_file = "false";
            
            /* MODAL */

            function exibirModal(e) {
                modal[e].style.display = 'flex'
                modalBg[0].style.display = 'flex'
            }

            function fecharModal(e) {
                modal[e].style.display = 'none'
                modalBg[0].style.display = 'none'
            }

            /* FUNÇÕES ALTERAR IMAGEM DO PERFIL */

            avatar_custom.addEventListener("change", readImage, false);

            function readImage() {
                if (this.files && this.files[0]) {
                    var file = new FileReader();
                    file.onload = function(e) {
                        custom[0].src = e.target.result;
                    };       
                    file.readAsDataURL(this.files[0]);
                }
            }

            function verifyFile() {
                validate_file = "true";
                for (let index = 0; index < avatar_image.length; index++) {
                    avatar_image[index].style.border = "2px solid #FF0149"; 
                }
                avatar_custom_lb.style.border = "4px solid #00ff62";
                readURL(avatar_custom);
            }

            for (let index = 0; index < required.length; index++) {
                if (validate_file == "false") {
                    required[index].addEventListener("click", verifyCheckRadio);
                    function verifyCheckRadio() {
                        for (let index = 0; index < avatar_image.length; index++) {
                            avatar_image[index].style.border = "2px solid #FF0149"; 
                        }
                        if (required[index].checked) {
                            avatar_image[index+1].style.border = "4px solid #00ff62";
                        }
                    }
                }
            }

            /* FUNÇÕES/VALIDAÇÕES DO USERNAME */

            /* Set errors */

            function setError(index, msgError) {
              msg[index].style.color = "#FF0149";
              msg[index].innerText= msgError;
              inputBorder[index].style.outline = "2px solid #FF0149"
            }

            function removeError(index, msgCorect) {
              msg[index].style.color = "#00ff62";
              msg[index].innerText= msgCorect;
              inputBorder[index].style.outline = "2px solid #00ff62"
            }

            /* Formatação do usuario */

            campos[0].addEventListener("keyup", formatarUserUp);

            function formatarUserUp(e) {
              var v=e.target.value.replace(/\s+|[[!@#$%¨&*§°/?>|\{}<,()"':+;-]/g, '');
              v=v.charAt(0).toUpperCase() + v.slice(1).toLowerCase();
              e.target.value =v;
            }

            /* Validação do usuario */

            function userUpValidate(){
              var validate = campos[0].value.length;
              if (validate < 5) {
                setError(0, "User deve ser maior que "+validate+"/5");
                validateCampos = 0;
              }else if(validate > 25){
                setError(0, "User deve ser menor que "+validate+"/25");
                validateCampos = 0;
              }else{
                removeError(0, "Usuario");
                validateCampos = 1;
              }

              if (validateCampos == 1) {
                btn_username_submit_invalid.style.display = 'none'
                btn_username_submit.style.display = 'flex';
              }else{
                btn_username_submit_invalid.style.display = 'flex';
                btn_username_submit.style.display = 'none';
              }
            }

            /* MOSTRAR SENHA */

            let eye = document.querySelectorAll('.lnr-eye');
            var url = ["../src/img/OLHO_ABERTO.png","../src/img/OLHO_FECHADO.png"];
            for (let index = 0; index < eye.length; index++) {
              eye[index].addEventListener('click', verificaEye);
              function verificaEye() {
              let inputSenha = document.querySelectorAll(".password");
                if(inputSenha[index].type == "password") {
                  inputSenha[index].type = "text";
                  eye[index].style.backgroundImage = `url(${url[0]})`;
                } else {
                  inputSenha[index].type = "password";
                  eye[index].style.backgroundImage = `url(${url[1]})`;
                }
              }
            }
        </script>
    </body>
</html>

<?php
    echo('
        <style>
            #header_hamburguer {
                display: block;
            }
        </style>
    ');
?>