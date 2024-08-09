<?php
    require_once("../../control/control_conexao.php");
    require_once("../../control/control_session.php");
?>
<!DOCTYPE html>
<html lang="pt_br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DEVLINE - Contas profissionais</title>
        <link rel="stylesheet" href="../../src/css/styles_default.css">
        <link rel="stylesheet" href="../../src/css/styles_admin_cont_prof.css">
    </head>
    <body>
        <a href="./home_admin.php"><img id="logo" src="../../src/img/LOGO_DV_ADM.png"></a>
        <section class="main_contas_profissionais">
            <section class="main_cont_prof_sec left">
                <h2>Painel de contas profissionais</h2>
                <p>Aceite ou recuse as contas. Ao aceitar a conta deverá ser monitorada pelo prazo de uma semana</p>
            </section>
            <section class="main_cont_prof_sec right">
                <?php
                    $res = $pdo->query("SELECT * FROM professor WHERE status = 'EM ANALISE'");
                    
                    $dados = $res->fetchAll(PDO::FETCH_ASSOC);
                    
                    for ($i=0; $i < count($dados); $i++) { 
                            $dt_nascimento = $dados[$i]['dt_nascimento'];
                            $idade_exp = explode("/",$dt_nascimento);
                            $data = date('Y');
                            $idade =  $data - $idade_exp[2];
                            echo("
                                <section class='card_cont_prof'>
                                    <span><p><strong>Nome </strong>".$dados[$i]['nome']."</p></span>
                                    <span><p><strong>Idade </strong>".$idade."</p></span>
                                    <span><p><strong>Email </strong>".$dados[$i]['email']."</p></span>
                                    <span><p><strong>Especialidade </strong>".$dados[$i]['especialidade']."</p></span>
                                    <section class='align_btns'>
                                        <a href='./contas_profissionais.php?acept=".$dados[$i]['id_professor']."'><section class='button small btn_aceitar'>Aceitar</section></a>
                                        <a href='./contas_profissionais.php?regex=".$dados[$i]['id_professor']."'><section class='button small btn_recusar'>Recusar</section></a>
                                    </section>
                                </section>
                            ");
                    }
                ?>
            </section> 
        </section>
        <?php
            if (isset($_GET['acept'])) {
                $acept_id = $_GET['acept'];

                $pdo->query("UPDATE professor SET status = 'CRIANDO' WHERE id_professor = '$acept_id'");

                header("Location: ./contas_profissionais.php");
            }

            if (isset($_GET['regex'])) {
                $regex_id = $_GET['regex'];

                $pdo->query("UPDATE professor SET status = 'NEGADO' WHERE id_professor = '$regex_id'");

                header("Location: ./contas_profissionais.php");
            }
        ?>
    </body>
</html>