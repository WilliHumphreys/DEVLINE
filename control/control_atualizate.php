<?php
    require_once("./control_conexao.php");
    require_once("./control_session.php");

    if (isset($_POST['submit_avatar'])) {
        $arqName = $_FILES['avatar_custom']['name'];
        $arqType = $_FILES['avatar_custom']['type'];
        $arqSize = $_FILES['avatar_custom']['size'];
        $arqTemp = $_FILES['avatar_custom']['tmp_name'];
        $arqError = $_FILES['avatar_custom']['error'];
        $default = $_POST['avatar_profile'];
        $local = "PROFILE_AVATAR_0".$default.".png";
        $usuario = $_SESSION['user'];
        $email = $_SESSION['email_aluno'];
        $defaultProfiles = [
        'PROFILE_AVATAR_01.png',
        'PROFILE_AVATAR_02.png',
        'PROFILE_AVATAR_03.png',
        'PROFILE_AVATAR_04.png',
        'PROFILE_AVATAR_05.png',
        'PROFILE_AVATAR_06.png',
        'PROFILE_AVATAR_07.png',
        'PROFILE_AVATAR_08.png',
        'PROFILE_AVATAR_09.png',
        'PROFILE_AVATAR_010.png',
        'PROFILE_AVATAR_011.png',
        'PROFILE_AVATAR_012.png',
        'PROFILE_AVATAR_013.png',
        'PROFILE_AVATAR_014.png',
        'PROFILE_AVATAR_015.png'];
        $defaultProfilesValidate = 0;

        if ($arqName != "") {
            $tiposPermitidos= array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png');
            $tamanhoPermitido = 1024 * 1024; 

            if ($arqError == 0) {
                if (array_search($arqType, $tiposPermitidos) === false) {
                echo("<script> alert('O tipo de arquivo enviado é inválido!'); </script>");
                header("Location: ../view/profile.php");
                } else if ($arqSize > $tamanhoPermitido) {
                echo("<script> alert('O tamanho do arquivo enviado é maior que o limite!'); </script>");
                header("Location: ../view/profile.php");
                } else {

                    $res = $pdo->prepare("SELECT * FROM aluno WHERE email = :email");

                    $res->bindValue(":email", $_SESSION['email_aluno']);
                    $res->execute();
                
                    $dados = $res->fetchAll(PDO::FETCH_ASSOC);
                
                    for ($i=0; $i < count($dados); $i++) { 
                        $ft_perfil = $dados[$i]['ft_perfil'];
                    }

                    for ($i=0; $i < count($defaultProfiles); $i++) { 
                        if ($ft_perfil == $defaultProfiles[$i]) {
                            $defaultProfilesValidate = 1;
                        }
                    }

                    if ($defaultProfilesValidate == 0) {
                        $file_pointer = "../src/img/PROFILES/";
                        unlink($file_pointer.$ft_perfil);
                    }

                    $pasta = '../src/img/PROFILES/';
                    $extensao = strtolower(end(explode('.', $arqName)));
                    $nome = time() . '.' . $extensao;

                    $upload = move_uploaded_file($arqTemp, $pasta . $nome);

                    $pdo->query("UPDATE aluno SET ft_perfil = '$nome' WHERE email = '$email'");
                    header("Location: ../view/profile.php");

                }
            }
        }else{
            $res = $pdo->prepare("SELECT * FROM aluno WHERE email = :email");

            $res->bindValue(":email", $email);
            $res->execute();
                
            $dados = $res->fetchAll(PDO::FETCH_ASSOC);
                
            for ($i=0; $i < count($dados); $i++) { 
                $ft_perfil = $dados[$i]['ft_perfil'];
            }
            
            for ($i=0; $i < count($defaultProfiles); $i++) { 
                if ($ft_perfil == $defaultProfiles[$i]) {
                    $defaultProfilesValidate = 1;
                }
            }

            if ($defaultProfilesValidate == 0) {
                $file_pointer = "../src/img/PROFILES/";
                unlink($file_pointer.$ft_perfil);
            }

            $pdo->query("UPDATE aluno SET ft_perfil = '$local' WHERE email = '$email'");
    
            header("Location: ../view/profile.php");
        }
    }
?>