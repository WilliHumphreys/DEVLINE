<?php
    require_once("./control_conexao.php");
    require_once("./control_session.php");

    if (isset($_POST['submit_cad'])) {
        $nome = $_POST['nome'];
        $dt_nascimento = $_POST['dt_nascimento'];
        $usuario = $_POST['usuario'];
        $_SESSION['user'] = $usuario;
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];
        $senha = sha1($_POST['senha']);
        $nivel = 'Default'; 
        $ft_perfil = 'PROFILE_AVATAR_0'.rand(1,12).'.png';
        $rank = 0;
        $dvbucks = 0;

        $res_cpf = $pdo->query("SELECT * FROM aluno WHERE cpf = '$cpf'");
        $dados_cpf = $res_cpf->fetchAll(PDO::FETCH_ASSOC);
        $rows_cpf = count($dados_cpf);

        $res_user = $pdo->query("SELECT * FROM aluno WHERE usuario = '$usuario'");
        $dados_user = $res_user->fetchAll(PDO::FETCH_ASSOC);
        $rows_user = count($dados_user);

        $res_user_prof = $pdo->query("SELECT * FROM professor WHERE usuario = '$usuario'");
        $dados_user_prof = $res_user_prof->fetchAll(PDO::FETCH_ASSOC);
        $rows_user_prof = count($dados_user_prof);

        $res_email = $pdo->query("SELECT * FROM aluno WHERE email = '$email'");
        $dados_email = $res_email->fetchAll(PDO::FETCH_ASSOC);
        $rows_email = count($dados_email);

        if ($rows_cpf > 0) {
            header("Location: ../view/error_conta.php");
            $_SESSION['type_error'] = "CPF"; 

        } elseif ($rows_user > 0 || $rows_user_prof > 0){
            header("Location: ../view/error_conta.php");
            $_SESSION['type_error'] = "nome de usuario"; 

        } elseif ($rows_email > 0){
            header("Location: ../view/error_conta.php");
            $_SESSION['type_error'] = "email"; 

        }else{
            $pdo->query("INSERT INTO aluno (nome, dt_nascimento, usuario, email, cpf, senha, nivel, ft_perfil, rank, dvbucks) VALUES ('$nome','$dt_nascimento','$usuario','$email','$cpf','$senha','$nivel','$ft_perfil','$rank','$dvbucks')");
            header("Location: ../view/profile.php");
            $_SESSION['user_valid'] = "true";
            $_SESSION['email_aluno'] = $email;
            $_SESSION['username'] = $usuario;
            $_SESSION['user_type'] = "aluno";
        }
     }
?>