<?php
    require_once("./control_conexao.php");
    require_once("./control_session.php");

    if (isset($_POST['submit_criar_curso_prof_final'])) {
        $name_curso = $_POST['nome_curso_pass'];

        $res_name_rec = $pdo->query("SELECT * FROM cursos WHERE nome = '$name_curso'");

        $dados_name_rec = $res_name_rec->fetchAll(PDO::FETCH_ASSOC);
        $rows_name_rec = count($dados_name_rec);

        for ($i=0; $i < count($dados_name_rec); $i++) { 
            $id_curso = $dados_name_rec[$i]['id_cursos'];
            $quant_modulos = $dados_name_rec[$i]['modulos'];
            $nomeCapaMod = $dados_name_rec[$i]['ft_banner'];
        }

        if ($rows_name_rec > 0) {

            for ($i=0; $i < $quant_modulos; $i++) { 
                $name_mod = $_POST['name_mod_'.$i.''];
                $desc_mod = $_POST['desc_mod_'.$i.''];
                $file_aula = $_POST['file_aula_'.$i.''];
                $cod_modulo = $id_curso.'M'.$i+1;

                $pdo->query("INSERT INTO modulos (cod_modulo, nome, descricao, capa, aula, chat) VALUES ('$cod_modulo','$name_mod','$desc_mod','$nomeCapaMod','$file_aula','INDEFINIDO')");
            }
        }
    }
?>