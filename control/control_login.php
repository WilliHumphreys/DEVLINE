<?php
    require_once("./control_conexao.php");
    require_once("./control_session.php");

    if (isset($_POST['submit_log'])) {
        $usuario = $_POST['usuario_log'];
        $senha = sha1($_POST['senha_log']);

        $res = $pdo->prepare("SELECT * FROM aluno WHERE usuario = :usuarioAluno AND senha = :senhaAluno");

        $res->bindValue(":usuarioAluno", $usuario);
        $res->bindValue(":senhaAluno", $senha);
        $res->execute();

        $resProf = $pdo->prepare("SELECT * FROM professor WHERE usuario = :usuarioProf AND senha = :senhaProf");
        
        $resProf->bindValue(":usuarioProf", $usuario);
        $resProf->bindValue(":senhaProf", $senha);
        $resProf->execute();
        
        $resAdm = $pdo->prepare("SELECT * FROM adm WHERE usuario = :usuarioAdm AND senha = :senhaAdm");

        $resAdm->bindValue(":usuarioAdm", $usuario);
        $resAdm->bindValue(":senhaAdm", $senha);
        $resAdm->execute();

        $dados = $res->fetchAll(PDO::FETCH_ASSOC);
        $dadosProf = $resProf->fetchAll(PDO::FETCH_ASSOC);
        $dadosAdm = $resAdm->fetchAll(PDO::FETCH_ASSOC);
        $rows = count($dados);
        $rowsProf = count($dadosProf);
        $rowsAdm = count($dadosAdm);

        for ($i=0; $i < count($dados); $i++) { 
            $email = $dados[$i]['email'];
        }

        $_SESSION['user'] = $usuario;
        $_SESSION['email_aluno'] = $email;

        if ($rows > 0) {
            header("Location: ../view/profile.php");
            $_SESSION['user_valid'] = "true";
            $_SESSION['user_type'] = "aluno";
       }elseif ($rowsProf > 0) {
            header("Location: ../view/profile.php");
            $_SESSION['user_valid'] = "true";
            $_SESSION['user_type'] = "professor";
        }elseif ($rowsAdm > 0) {
            header("Location: ../view/admin/home_admin.php");
            $_SESSION['user_valid'] = "true";
            $_SESSION['user_type'] = "adm";
        }else{
            header("Location: ../view/login.php");
            $_SESSION['user_valid'] = "false";
        }
     }
?>