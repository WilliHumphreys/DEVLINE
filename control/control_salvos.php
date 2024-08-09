<?php
    require_once("./control_conexao.php");
    require_once("./control_session.php");

    if (isset($_POST['submit_saved'])) {
        $id_curso = $_POST['id_curso'];

        $res_aluno_saved = $pdo->prepare("SELECT * FROM aluno WHERE usuario = :usuario");

        $res_aluno_saved->bindValue(":usuario", $_SESSION['user']);
        $res_aluno_saved->execute();
    
        $dados_aluno_saved = $res_aluno_saved->fetchAll(PDO::FETCH_ASSOC);
    
        for ($i=0; $i < count($dados_aluno_saved); $i++) { 
            $salvos_brut = $dados_aluno_saved[$i]['salvos'];
        }

        $salvos_checked = 0;
        
        if ($salvos_brut > 0) {
            $salvos = explode("S", $salvos_brut);

            for ($i=0; $i < count($salvos); $i++) { 
                if ($salvos[$i] == $id_curso) {
                    $salvos_checked = "true";
                }
            }
        }

        $user_set = $_SESSION['user'];
        if ($salvos_checked == 'true') {
            $new_salvo_exp = explode('S', $salvos_brut);

            for ($i=0; $i < count($new_salvo_exp); $i++) { 
                if ($new_salvo_exp[$i] == $id_curso) {
                    $new_salvo_exp[$i] = "";
                }

                if ($new_salvo_exp[$i] != "") {
                    $new_salvo_up = $new_salvo_up.$new_salvo_exp[$i]."S";
                }
            }

            $pdo->query("UPDATE aluno SET salvos = '$new_salvo_up' WHERE usuario = '$user_set'");
            header("Location: ../view/pagina_curso.php?id_curso=".$id_curso."");
        }else{
            $new_salvo_rm = $salvos_brut.$id_curso.'S';
            $pdo->query("UPDATE aluno SET salvos = '$new_salvo_rm' WHERE usuario = '$user_set'");
            header("Location: ../view/pagina_curso.php?id_curso=".$id_curso."");
        }
    }
?>