<?php
    require_once("./control_conexao.php");
    require_once("./control_session.php");

    if (isset($_POST['submit_card_prof'])) {
        $especialidade = $_POST['especialidade'];
        $motivo = $_POST['motivo'];

        if ($especialidade != "" && $motivo != "") {
            $res = $pdo->prepare("SELECT * FROM aluno WHERE usuario = :usuario");

            $res->bindValue(":usuario", $_SESSION['username']);
            $res->execute();
        
            $dados = $res->fetchAll(PDO::FETCH_ASSOC);
        
            for ($i=0; $i < count($dados); $i++) { 
                $nome = $dados[$i]['nome'];
                $dt_nascimento = $dados[$i]['dt_nascimento'];
                $email = $dados[$i]['email'];
                $cpf = $dados[$i]['cpf'];
            }

            $usuario = sha1(rand(1,100));
            $senha = sha1(rand(1,100));

            $status = "EM ANALISE";
    
            $pdo->query("INSERT INTO professor (nome, dt_nascimento, usuario, email, cpf, senha, especialidade, status) VALUES ('$nome','$dt_nascimento','$usuario','$email','$cpf','$senha','$especialidade','$status')");
            header("Location: ../view/profile.php");
        }else{
            header("Location: ../view/professor.php");
        }
     }
?>