<?php
    require_once("./control_conexao.php");
    require_once("./control_session.php");

    if (isset($_SESSION['user_valid'])) {
        $res = $pdo->prepare("SELECT * FROM aluno WHERE usuario = :usuario");

        $res->bindValue(":usuario", $_SESSION['user']);
        $res->execute();
    
        $dados = $res->fetchAll(PDO::FETCH_ASSOC);
    
        for ($i=0; $i < count($dados); $i++) { 
            $nivel = $dados[$i]['nivel'];
        }

        if ($_SESSION['user_valid'] == "true" && $nivel != "Default") {
            header("Location: ../view/profile.php");
        }
    }

    if (isset($_POST['submit_form_pag'])) {
        $user = $_POST['user_pack'];
        $name_pack = $_POST['name_pack'];
        $preco_pack = $_POST['preco_pack'];
        $data_sale = $_POST['date_sale'];      
        $cod_sale = $_POST['cod_sale'];
        $num_card = $_POST['num_card'];
        $name_card = $_POST['name_card'];
        $val_card = $_POST['validade_card'];
        $validade_card = sha1($val_card);
        $cvv_card = sha1($_POST['cvv_card']);

        $num_exp = explode(" ", $num_card);

        $name_card_cript = sha1($name_card);
        $num_card_cript = sha1($num_card);

        $res = $pdo->query("SELECT * FROM pagamento WHERE user_compra = '$user' AND nome_pack = '$name_pack'");

        $dados = $res->fetchAll(PDO::FETCH_ASSOC);
        $rows = count($dados);

        if ($rows == 0) {
            $pdo->query("INSERT INTO pagamento (cod_pagamento, data_compra, nome_pack, valor_pack, user_compra, num_card, name_card, validade_card, cvv_card) VALUES ('$cod_sale','$data_sale','$name_pack','$preco_pack','$user','$num_card_cript','$name_card_cript','$validade_card','$cvv_card');");
            $pdo->query("INSERT INTO cards (user_card, num_card, num_exibir, name_card, val_card, cvc_card) VALUES ('$user','$num_card_cript','$num_exp[0]/$num_exp[3]','$name_card','$val_card','$cvv_card');");

            $pdo->query("UPDATE aluno SET nivel = '$name_pack' WHERE usuario = '$user'");
        }else {
            header('Location: ../view/profile.php');
        }  
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>DEVLINE - Pagamento</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='stylesheet' type='text/css' media='screen' href='../src/css/styles_default.css'>
        <link rel='stylesheet' type='text/css' media='screen' href='../src/css/styles_pagamento.css'>
    </head>
    <body>
        <a href="../view/profile.php"><img id="logo" src="../src/img/LOGO_DV.png"></a>
        <section class="main_pagamento">
            <section class="sec_main_pag left">
                <img src="../src/img/COMPRA_APROVADA.png">
            </section>
            <section class="sec_main_pag right">
                <?php
                    echo('
                        <section class="card_pag">
                            <h2>SUA COMPRA FOI<br>APROVADA</h2>
                            <p class="title_camp">Dados da compra</p>
                            <span>PACOTE: <p class="span_p_dados">'.$name_pack.'</p> </span>
                            <span>PREÇO: <p class="span_p_dados">'.$preco_pack.'</p> </span>
                            <span>DATA: <p class="span_p_dados">'.$data_sale.'</p> </span>
                            <span>CODIGO: <p class="span_p_dados">'.$cod_sale.'</p> </span>
                            <p class="title_camp">Dados do cartão</p>
                            <span>TITULAR: <p class="span_p_dados">'.$name_card.'</p> </span>
                            <span>NUMERO: <p class="span_p_dados">xxxx xxxx xxxx '.$num_exp[3].'</p> </span>
                            <a href="../view/painel_pack.php"><section class="button medium transparent">VOLTAR</section></a>
                        </section>
                    ');

                    }
                ?>
            </section>
        </section>
    </body>
</html>