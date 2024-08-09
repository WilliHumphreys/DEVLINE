<?php
    require_once("./control_conexao.php");
    require_once("./control_session.php");

    if (isset($_GET['id_curso'])) {
        $id_curso = $_GET['id_curso'];

        $res_aluno_saved = $pdo->prepare("SELECT * FROM aluno WHERE usuario = :usuario");

        $res_aluno_saved->bindValue(":usuario", $_SESSION['user']);
        $res_aluno_saved->execute();
        
        $dados_aluno_saved = $res_aluno_saved->fetchAll(PDO::FETCH_ASSOC);
    
        for ($i=0; $i < count($dados_aluno_saved); $i++) { 
            $nivel = $dados_aluno_saved[$i]['nivel'];
            $cursos_ativos = $dados_aluno_saved[$i]['cursos_ativos'];
            $cod_cursos_ativos = $dados_aluno_saved[$i]['cod_cursos_ativos'];
        }

        $user_up = $_SESSION['user'];
        $cursos_ativos = $cursos_ativos + 1;
        $cod_cursos_ativos = $cod_cursos_ativos.$id_curso.'A';

        $pdo->query("UPDATE aluno SET cursos_ativos = '$cursos_ativos', cod_cursos_ativos = '$cod_cursos_ativos' WHERE usuario = '$user_up'");

        header('Location: ../view/meus_cursos.php');
    }else{
        header('Location: ../view/cursos.php');
    }
?>