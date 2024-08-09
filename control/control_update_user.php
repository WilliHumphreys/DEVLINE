<?php
    require_once("./control_conexao.php");
    require_once("./control_session.php");

    if (isset($_POST['submit_username_password'])) {
        $senha = sha1($_POST['senha_up']);
        $username = $_SESSION['user'];

        $res = $pdo->prepare("SELECT * FROM aluno WHERE usuario = :usuario AND senha = :senha");

        $res->bindValue(":usuario", $_SESSION['user']);
        $res->bindValue(":senha", $senha);
        $res->execute();

        $dados = $res->fetchAll(PDO::FETCH_ASSOC);
        $rows = count($dados);

        if ($rows > 0) {
            $newUsername = $_SESSION['newUsername'];
            $pdo->query("UPDATE aluno SET usuario = '$newUsername' WHERE usuario = '$username'");
            $_SESSION['user'] = $newUsername;
            $_SESSION['password_valid'] = "true";
            header("Location: ../view/profile.php");
        }else{
            $_SESSION['password_valid'] = "false";
            header("Location: ../view/profile.php");
        }
    }
?>