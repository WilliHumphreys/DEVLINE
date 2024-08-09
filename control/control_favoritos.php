<?php
    require_once("./control_conexao.php");
    require_once("./control_session.php");

    if (isset($_GET['fav_verif'])) {
        $user_set = $_SESSION['user'];
        $fav_verif = $_GET['fav_verif'];
        $cod_modulo = $_GET['cod_modulo'];
        $id_curso = $_GET['id_curso'];

        $res_aluno_fav = $pdo->prepare("SELECT * FROM aluno WHERE usuario = :usuario");
                
        $res_aluno_fav->bindValue(":usuario", $_SESSION['user']);
        $res_aluno_fav->execute();
    
        $dados_aluno_fav = $res_aluno_fav->fetchAll(PDO::FETCH_ASSOC);
    
        for ($i=0; $i < count($dados_aluno_fav); $i++) { 
            $fav_brut = $dados_aluno_fav[$i]['favoritos'];
        }

        if ($fav_verif == "true") {
            $new_fav_exp = explode($cod_modulo.'F', $fav_brut);
            if (count($new_fav_exp) > 1) {
                $new_fav_up = $new_fav_exp[0].$new_fav_exp[1];
            }else{
                $new_fav_up = $new_fav_exp[0];
            }

            $pdo->query("UPDATE aluno SET favoritos = '$new_fav_up' WHERE usuario = '$user_set'");

            header("Location: ../view/player_video.php?id_curso=".$id_curso."&cod_modulo=".$cod_modulo."");
        }elseif ($fav_verif == "false") {
            $new_fav_rm = $fav_brut.$cod_modulo.'F';

            echo($new_fav_rm);

            $pdo->query("UPDATE aluno SET favoritos = '$new_fav_rm' WHERE usuario = '$user_set'");
            
            header("Location: ../view/player_video.php?id_curso=".$id_curso."&cod_modulo=".$cod_modulo."");
        }
    }
?>