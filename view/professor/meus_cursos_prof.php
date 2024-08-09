<?php
    require_once("../../control/control_conexao.php");
    require_once("../../control/control_session.php");

    $res = $pdo->prepare("SELECT * FROM professor WHERE usuario = :usuario");

    $res->bindValue(":usuario", $_SESSION['user']);
    $res->execute();

    $dados = $res->fetchAll(PDO::FETCH_ASSOC);

    for ($i=0; $i < count($dados); $i++) { 
        $nome_prof = strtoupper($dados[$i]['nome']);
    }

    $res_prof_aluno = $pdo->query("SELECT * FROM cursos WHERE professor = '$nome_prof'");

    $dados_prof_aluno = $res_prof_aluno->fetchAll(PDO::FETCH_ASSOC);

    for ($i=0; $i < count($dados_prof_aluno); $i++) { 
        $curso = $dados_prof_aluno[$i]['nome'];
        echo($curso.'<br>');
    }
?>