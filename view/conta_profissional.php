<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>DEVLINE - Junte-se a nós</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel="icon" type="image/jpg" href="../src/img/flavicon.png" />
        <link rel='stylesheet' type='text/css' media='screen' href='../src/css/styles_default.css'>
        <link rel='stylesheet' type='text/css' media='screen' href='../src/css/styles_professor.css'>
        <link rel='stylesheet' type='text/css' media='screen' href='../src/css/styles_modal.css'>
        <noscript><meta http-equiv="refresh" content="0; URL='./error_js_disable.html '"/></noscript>
    </head>
    <body>
        <form class="form_prof" action="../control/control_conta_profissional.php" method="POST">
            <section class="prof_main">
                <section class="modalBg">
                    <section class="modal">
                        <section class="modal_content">
                            <h2 class="title_modal_prof">Atenção</h2>
                            <p class="text_modal_prof">Sua conta será analisada e você receberá uma resposta em até 3 dias</p>
                            <input type="submit" name="submit_card_prof" id="submit_card_prof">
                            <label for="submit_card_prof"><section class="button medium"><p>Entendi</p></section></label>
                        </section>
                    </section>
                </section>
                <a href="./profile.php"><img id="logo" src="../src/img/LOGO_DV.png"></a>
                <section class="prof_left">
                    <h2 class="title_prof">Desperte o seu potencial<br>na DEVLINE!</h2>
                </section>
                <section class="prof_right">
                    <section class="card_form">
                        <h2 class="title_prof_card">conte-nos mais sobre você</h2>
                        <section class="form_prof">
                            <section class="sec_prof_form">
                                <label class="label_prof">Qual sua principal especialidade?</label>
                                <select class="input_prof" name="especialidade" required>
                                    <option class="option_prof" value="" disabled selected>ESPECIALIDADE</option>
                                    <option class="option_prof" value="DEV FRONT-END">DEV FRONT-END</option>
                                    <option class="option_prof" value="DEV BACK-END">DEV BACK-END</option>
                                    <option class="option_prof" value="DEV FULLL-STACK">DEV FULLL-STACK</option>
                                    <option class="option_prof" value="DEV DE JOGOS">DEV DE JOGOS</option>
                                    <option class="option_prof" value="BANCO DE DADOS">BANCO DE DADOS</option>
                                    <option class="option_prof" value="REDES">REDES</option>
                                    <option class="option_prof" value="WEB DESIGNER">WEB DESIGNER</option>
                                    <option class="option_prof" value="UX DESIGNER">UX DESIGNER</option>
                                </select>
                            </section>
                            <section class="sec_prof_form">
                                <label class="label_prof">Por que quer ser um profissional DV?</label>
                                <select class="input_prof" name="motivo" required>
                                    <option class="option_prof" value="" disabled selected>MOTIVO</option>
                                    <option class="option_prof" value="Paixão pela tecnologia e inovação.">Paixão pela tecnologia e inovação.</option>
                                    <option class="option_prof" value="Contribuir para avanços tecnológicos.">Contribuir para avanços tecnológicos.</option>
                                    <option class="option_prof" value="Impactar positivamente o mundo">Impactar positivamente o mundo</option>
                                    <option class="option_prof" value="Desenvolver meu potencial ao máximo.">Desenvolver meu potencial ao máximo.</option>
                                    <option class="option_prof" value="Realizar meu sonho profissional.">Realizar meu sonho profissional.</option>
                                    <option class="option_prof" value="Trabalhar em projetos relevantes.">Trabalhar em projetos relevantes.</option>
                                </select>
                            </section>
                            <section class="button medium btn_prof" onclick="exibirModal(0)"><p>Enviar</p></section>
                        </section>
                    </section>
                </section>
            </section>
        </form>
        <script>
            const modal = document.querySelectorAll(".modal");
            const modalBg = document.querySelectorAll(".modalBg");

            function exibirModal(e) {
                modal[e].style.display = 'flex'
                modalBg[0].style.display = 'flex'
            }

            function fecharModal(e) {
                modal[e].style.display = 'none'
                modalBg[0].style.display = 'none'
            }
        </script>
    </body>
</html>