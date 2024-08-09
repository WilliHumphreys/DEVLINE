<?php
    require_once("../control/control_conexao.php");
    require_once("../control/control_session.php");

    $res = $pdo->prepare("SELECT * FROM pagamento WHERE user_compra = :usuario");

    $res->bindValue(":usuario", $_SESSION['user']);
    $res->execute();

    $dados = $res->fetchAll(PDO::FETCH_ASSOC);
    $rows = count($dados);

    if ($rows > 0) {
        for ($i=0; $i < count($dados); $i++) { 
            $data_compra = $dados[$i]['data_compra'];
            $name_pack = $dados[$i]['nome_pack'];
        }
    
        $data_compra_space = explode(" ", $data_compra);
        $data_compra_exp = explode("/", $data_compra_space[0]);
    
        if ($data_compra_exp[1] == 12) {
            $next_m = "01";
            $next_y = $data_compra_exp[2] + 1;
        }else{
            $next_m = $data_compra_exp[1] + 1;
            $next_y = $data_compra_exp[2];
        }

        if ($name_pack == "DV Pro") {
            echo('
                <style>
                    .card_painel_packs {
                        background: rgb(56,255,20,0.5);
                        background: linear-gradient(45deg, rgb(56,255,20,0.15) 0%,rgba(2,0,20,0.3) 100%);
                        border: 1px solid #39FF14;
                        box-shadow: #37ff1490 0px 0px 25px;
                    }
                </style>
            ');
        }elseif ($name_pack == "DV Elite") {
            echo('
                <style>
                    .card_painel_packs {
                        background: rgba(255,215,0,0.5);
                        background: linear-gradient(315deg, rgba(255,215,0,0.15) 0%, rgba(2,0,20,0.3) 100%);
                        border: 1px solid #FFD700;
                        box-shadow: #ffd900a1 0px 0px 25px;
                    }
                </style>
            ');
        }
    }else{
        header("Location: ./profile.php");
    }

    if (isset($_SESSION['user_valid'])) {
        if ($_SESSION['user_valid'] != "true") {
            header("Location: ./error_session_invalid.html");
        }elseif ($name_pack == "Default") {
            header("Location: ./seja_dv.php");
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>DEVLINE - <?php echo($name_pack); ?></title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='stylesheet' type='text/css' media='screen' href='../src/css/styles_default.css'>
        <link rel='stylesheet' type='text/css' media='screen' href='../src/css/styles_painel_packs.css'>
        <noscript><meta http-equiv="refresh" content="0; URL='./error_js_disable.html '"/></noscript>
    </head>
    <body>
        <header>
            <?php
                include_once("./header.php");
            ?>
        </header>
        <section class="main_painel_packs">
            <section class="sec_painel_packs left">
                <h2 class="title_left_packs">JUNTOS MOLDAMOS<br>O SEU FUTURO</h2>
                <section class="card_painel_packs">
                    <h2><?php echo($name_pack); ?></h2>
                    <p>Proxima mensalidade</p>
                    <span><?php echo($data_compra_exp[0].'/'.$next_m.'/'.$next_y); ?></span>
                </section>
            </section>
            <section class="sec_painel_packs right">
                <img src="../src/img/PAINEL_PACKS.png">
            </section>
        </section>
        <footer>
            <?php
                include_once("./footer.php");
            ?>
        </footer>
    </body>
</html>