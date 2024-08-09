<?php
    require_once("../control/control_conexao.php");
    require_once("../control/control_session.php");

    $email = $_SESSION['email_aluno'];

    $res = $pdo->query("SELECT * FROM professor WHERE email = '$email'");
    $dados = $res->fetchAll(PDO::FETCH_ASSOC);
    $rows = count($dados);

    for ($i=0; $i < count($dados); $i++) { 
        $nome = $dados[$i]['nome'];
        $dt_nascimento = $dados[$i]['dt_nascimento'];
        $email = $dados[$i]['email'];
        $especialidade = $dados[$i]['especialidade'];
        $status = $dados[$i]['status'];
        $idade_exp = explode("/",$dt_nascimento);
        $data = date('Y');
        $idade =  $data - $idade_exp[2];
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>DEVLINE - Conta profissional</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel="icon" type="image/jpg" href="../src/img/flavicon.png" />
        <link rel='stylesheet' type='text/css' media='screen' href='../src/css/styles_default.css'>
        <link rel='stylesheet' type='text/css' media='screen' href='../src/css/styles_conta_profissional.css'>
        <noscript><meta http-equiv="refresh" content="0; URL='./error_js_disable.html '"/></noscript>
    </head>
    <body>
        <a href="./profile.php"><img id="logo" src="../src/img/LOGO_DV.png"></a>
        <section class="main_conta_profissional">
            <section class="conta_profissional_secs left">
                <h2 class="title_conta_profissional"><?php if (isset($status)){ if ($status == "CRIANDO"){ echo('PARABENS, SUA CONTA<br>FOI APROVADA!'); } elseif ($status == "NEGADO") { echo('DESCULPE, SUA CONTA<br>NÃO FOI ACEITA'); }else{ echo('SUA CONTA ESTA<br>SENDO ANALISADA'); }} ?></h2>
                <p class="text_conta_profissional"><?php if (isset($status)){ if ($status == "CRIANDO"){ echo('Crie um nome de usuario e uma<br>senha para sua conta profissional'); } elseif ($status == "NEGADO") { echo('Por algum motivo sua conta não<br>foi aceita, tente novamente mais tarde'); }else{ echo('Avisaremos quando sua<br>conta for aprovada'); }} ?></p>
                <a href="./profile.php"><section class="button medium">Voltar</section></a>
            </section>
            <section class="conta_profissional_secs right">
                <section class="card_conta_profissional">
                    <?php
                        if (isset($status)) {
                            if ($status == "CRIANDO") {
                                $_SESSION['cont_prof_negado'] = "false";
                                $_SESSION['cont_prof_negado_email'] = 0;
                                echo('
                                    <form action="#" method="POST" class="form_cont_prof">
                                        <section class="input-group">
                                            <input name="usuario" type="text" id="usuario" class="input-group__input required formatarCampo" maxlength="15" oninput="userValidate()" required>
                                            <label for="usuario" class="input-group__label msg_required">Usuario</label>
                                        </section>
                                        <section class="input-group">
                                            <input type="password" id="senha" class="input-group__input required password" maxlength="64" oninput="senhaValidate()" required>
                                            <label for="senha" class="input-group__label msg_required">Senha</label>
                                            <span class="lnr lnr-eye"></span>
                                        </section>
                                        <section class="input-group">
                                            <input name="senha" type="password" id="confirm_senha" class="input-group__input required password" maxlength="32" oninput="confirmSenhaValidate()" required>
                                            <label for="confirm_senha" class="input-group__label msg_required">Confirmar senha</label>
                                            <span class="lnr lnr-eye"></span>
                                        </section>
                                        <input type="submit" name="submit_updade_user_prof" id="submit_updade_user_prof">
                                        <label for="submit_updade_user_prof"><section class="button medium transparent">CADASTRAR</section></label>
                                    </form>
                                ');
                            } elseif ($status == "NEGADO") {
                                $_SESSION['cont_prof_negado'] = "true";
                                $_SESSION['cont_prof_negado_email'] = $email;
                                echo('
                                    <style>
                                        .card_conta_profissional {
                                            background: transparent;
                                            border: none;
                                            box-shadow: none;
                                        }
                                    </style>
                                    <img id="img_error" src="../src/img/ERROR_SESSION_INVALID.png">
                                ');
                            }elseif ($status == "EM ANALISE") {
                                $_SESSION['cont_prof_negado'] = "false";
                                $_SESSION['cont_prof_negado_email'] = 0;
                                echo('
                                    <section class="title_card">
                                        <h2>Parabens por se cadastrar</h2>
                                        <p>Seus dados estão sendo analisados</p>
                                    </section>
                                    <span><p><strong>Nome </strong> '.$nome.' </p></span>
                                    <span><p><strong>Idade </strong> '.$idade.' </p></span>
                                    <span><p><strong>Email </strong> '.$email.' </p></span>
                                    <span><p><strong>Especialidade </strong> '.$especialidade.' </p></span>
                                ');
                            }else{
                                session_destroy();
                                header('Location: ./login.php');
                            }
                        }
                    ?>
                </section>
                <script>
                    var campos = document.querySelectorAll(".required");
                    const msg = document.querySelectorAll(".msg_required");
                    const inputBorder = document.querySelectorAll(".input-group__input");
                    const senhaRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!%$*&@#])[0-9a-zA-Z!%$*&@#]{8,}$/;

                    /* VER SENHA */

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

                    /* FORMATAR O CAMPO USUARIO */

                    campos[0].addEventListener("keyup", formatarUserCad);

                    function formatarUserCad(e) {
                        var v=e.target.value.replace(/\s+|[[!@#$%¨&*§°/?>|\{}<,()"':+;-]/g, '');
                        v=v.charAt(0).toUpperCase() + v.slice(1).toLowerCase();
                        e.target.value =v;
                    }

                    /* SET ERRORS */

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

                    /* VALIDAÇÕES DOS CAMPOS */

                    function userValidate(){
                        var validate = campos[0].value.length;
                        if (validate < 5) {
                            setError(0, "User deve ser maior que "+validate+"/5");
                            validateCampos[0] = 'false'
                        }else if(validate > 25){
                            setError(0, "User deve ser menor que "+validate+"/25");
                            validateCampos[0] = 'false'
                        }else{
                            removeError(0, "Usuario");
                            validateCampos[0] = 'true'
                        }
                    }

                    function senhaValidate(){
                        var validate = campos[1].value.length;

                        if (validate >= 8) {
                            if (senhaRegex.test(campos[1].value)) {
                            removeError(1, "Senha");
                            validateCampos[1] = 'true'
                            }else{
                            setError(1, "Faltam (1234) ou (M e m) ou (@#$)");
                            validateCampos[1] = 'false'
                            }
                        }else{
                            setError(1, "Senha deve ter "+validate+"/8 digitos");
                            validateCampos[1] = 'false'
                        }
                    }

                    function confirmSenhaValidate(){
                    var validate = campos[2].value.length;

                    if (validate >= 8) {
                        if (senhaRegex.test(campos[2].value)) {
                        if (campos[1].value == campos[2].value) {
                            removeError(2, "Confirmar senha");
                            validateCampos[2] = 'true'
                        }else{
                            setError(2, "As senhas devem ser iguais");
                            validateCampos[2] = 'false'
                        }
                        }else{
                        setError(2, "As senhas devem ser iguais");
                        validateCampos[2] = 'false'
                        }
                    }else{
                        setError(2, "As senhas devem ser iguais");
                        validateCampos[2] = 'false'
                    }
                    
                    }
                </script>
            </section>
        </section>
    </body>
</html>

<?php
    if (isset($_POST['submit_updade_user_prof'])) {
        $new_user_prof = $_POST['usuario'];
        $new_password_prof = sha1($_POST['senha']);

        $res_user = $pdo->query("SELECT * FROM aluno WHERE usuario = '$new_user_prof'");
        $dados_user = $res_user->fetchAll(PDO::FETCH_ASSOC);
        $rows_user = count($dados_user);

        $res_user_prof = $pdo->query("SELECT * FROM professor WHERE usuario = '$new_user_prof'");
        $dados_user_prof = $res_user_prof->fetchAll(PDO::FETCH_ASSOC);
        $rows_user_prof = count($dados_user_prof);

        $res_user_adm = $pdo->query("SELECT * FROM adm WHERE usuario = '$new_user_prof'");
        $dados_user_adm = $res_user_adm->fetchAll(PDO::FETCH_ASSOC);
        $rows_user_adm = count($dados_user_adm);

        if ($rows_user > 0 || $rows_user_prof > 0 || $rows_user_adm > 0) {
            echo("
                <script>
                    setError(0, 'Usuario já existente');
                </script>
            ");
        }else{
            $pdo->query("UPDATE professor SET usuario = '$new_user_prof', senha = '$new_password_prof', status = 'MONITORANDO' WHERE email = '$email'");
            $_SESSION['user_valid'] = "true";
            $_SESSION['user_type'] = "professor";
            $_SESSION['email_aluno'] = $email;
            $_SESSION['user'] = $new_user_prof;
            echo('<script> window.location.href = "./profile.php"; </script>');
        }
    }
?>