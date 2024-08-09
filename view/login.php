<?php
  require_once('../control/control_session.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>DEVLINE - Login</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel="icon" type="image/jpg" href="../src/img/flavicon.png" />
        <link rel='stylesheet' type='text/css' media='screen' href='../src/css/styles_login_signin.css'>
        <link rel='stylesheet' type='text/css' media='screen' href='../src/css/styles_default.css'>
        <noscript><meta http-equiv="refresh" content="0; URL='./error_js_disable.html '"/></noscript>
    </head>
    <body>
      <section id="frameTransition" class="frameTransitionCad-valid"></section>
      <form name="form_login" action="../control/control_login.php" method="POST">
        <a href="./landing_page.php"><img id="logo-login" src="../src/img/LOGO_DV.png"></a>
        <section class="main main-log">
            <section class="container container-login">
              <section class="form">
                <h2 class="form_title title">LOGIN</h2>
                <section class="input-group">
                  <input name="usuario_log" type="text" id="usuario_lg" class="input-group__input required formatarCampo"  maxlength="15" required>
                  <label for="usuario_lg" class="input-group__label msg_required">Usuario</label>
                </section>
                <section class="input-group">
                  <input name="senha_log" type="password" id="senha_lg" class="input-group__input required password" maxlength="32" required>
                  <label for="senha_lg" class="input-group__label msg_required">Senha</label>
                  <span class="lnr lnr-eye"></span>
                </section>
                <input id="submit_login" type="submit" name="submit_log">
                <label for="submit_login"><section class="button medium transparent">LOGIN</section></label>
              </section>
            </section>
            <section class="switch switch-login">
                <h2 class="title">JUNTE-SE A UMA<br>COMUNIDADE<br>EXCLUSIVA</h2>
                <p class="description">Você está prestes a entrar em um mundo de oportunidades e conhecimento</p>
                <section id="btn_switch_cad" class="button medium">CADASTRE-SE AGORA</section>
            </section>
          </section>
        </form>
        <script>
          const btn_switch_cad = document.getElementById("btn_switch_cad");
          const frameTransition = document.getElementById("frameTransition");
          const campos = document.querySelectorAll(".required");
          const msg = document.querySelectorAll(".msg_required");
          const inputBorder = document.querySelectorAll(".input-group__input");

          if (frameTransition.classList == "frameTransitionCad-valid") {
              setTimeout(() => {
                  frameTransition.classList.remove('frameTransitionCad-valid');
                  frameTransition.classList.add('frameTransitionCad-none');    
                }, 600);
            }

          btn_switch_cad.addEventListener("click", verifyBtn);
            function verifyBtn() {
              frameTransition.classList.remove('frameTransition-none');
              frameTransition.classList.add('frameTransition-valid');
              setTimeout(() => {
                window.location.href='./signin.php';    
              }, 500);
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

            /* FORMATAÇÃO DO CAMPO USUARIO */

            campos[0].addEventListener("keyup", formatarUserLog);

            function formatarUserLog(e) {
              var v=e.target.value.replace(/\s+|[[!@#$%¨&*§°/?>|\{}<,()"':+;-]/g, '');
              v=v.charAt(0).toUpperCase() + v.slice(1).toLowerCase();
              e.target.value =v;
            }

            /* SET ERROR */

            function setError(index, msgError) {
              msg[index].style.color = "#FF0149";
              msg[index].innerText= msgError;
              inputBorder[index].style.outline = "2px solid #FF0149"
            }

        </script>
    </body>
</html>

<?php
    if (isset($_SESSION['user_valid'])) {
      if ($_SESSION['user_valid'] == "false") {
        echo("
          <script>
            setError(0, 'Usuario invalido');
            setError(1, 'Senha invalida');
          </script>
        ");
      }
    }
?>