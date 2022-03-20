<?php

$GLOBAL['title'] = 'King Respect Crypto';
$GLOBAL['site_recaptcha'] = '6LdZKjIeAAAAABzVnz-81jwCVzvY8kWHqv8tNs-W';
$GLOBAL['user_recaptcha'] = '6LdZKjIeAAAAALKQ-g4bTbw_ZgZKt7MtgdALyDsd';

$DICIONARIO['forgot_password'] = 'I forgot my password';
$DICIONARIO['make_login'] = 'Sign in to start your session';
$DICIONARIO['beta_register'] = 'Sign up for the beta to receive rewards when the game launches';
$DICIONARIO['new_account'] = 'New Account';
$DICIONARIO['sign_in'] = 'Sign In';
$DICIONARIO['email'] = 'Email';
$DICIONARIO['password'] = 'Password';
$DICIONARIO['remember_me'] = 'Remember Me';
$DICIONARIO['discovery_project'] = 'Watch the video below to learn more about the project';
$DICIONARIO['presetation_video'] = 'Presentation Vídeo';
$DICIONARIO['register'] = 'Register';
$DICIONARIO['resend'] = "Resend password";
$DICIONARIO['play'] = "Play";

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- css proprio -->
        <link rel="stylesheet" href="css/style.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="css/all.min.css">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="css/icheck-bootstrap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="css/adminlte.min.css">
        <!-- Recaptcha google -->
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <!-- Jquery javascript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>

        <title><?php echo $GLOBAL['title'] ?></title>
        <meta charset="utf-8">
    </head>
    <?php  ?>
    <body class="hold-transition login-page background_index">
        <div class="menu_principal">
            <div class="bt_menu m-left-0">
                Play Game
            </div>
            <div class="bt_menu">
                <a href="https://lucas-daniel-beltrame.gitbook.io/king-respect-crypto/" target="_blank">
                    Whitepaper
                </a>
            </div>
            <div class="bt_menu">
                Pre sale
            </div>
            <div class="bt_menu">
                <a href="https://lucasgamestudio.com.br/" target="_blank">
                    Created By (Dev)
                </a>
            </div>
            <div class="bt_menu">
                Contact
            </div>
        </div>

        <!-- Inicio slideshow -->
        <!-- Slideshow container -->
        <div class="slideshow-container">

            <!-- Full-width images with number and caption text -->
            <div class="mySlides fade">
                <img src="resources/images/back1.png" style="width:1043px">
                <div class="text">1 / 3</div>
            </div>

            <div class="mySlides fade">
                <img src="resources/images/back2.png" style="width:1043px">
                <div class="text">2 / 3</div>
            </div>

            <div class="mySlides fade">
                <img src="resources/images/back3.png" style="width:1043px">
                <div class="text">3 / 3</div>
            </div>
        </div>
        <br>

        <!-- The dots/circles -->
        <div style="text-align:center; display:none;">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
        </div>

        <!-- Fim slideshow -->

        <div class="beta_test row">
            <div class="col-12">
                <div class="login-logo t_white">
                    Game Play
                </div>
                <img src="resources/images/all_game.png" style="width:1000px">
            </div>
        </div>
        <div class="beta_test row">
            <div class="col-12">
                <div class="login-box">
                    <div class="login-logo t_white">
                        Sign up for the beta test
                    </div>
                    <div class="card">
                        <div class="card-body login-card-body">
                        <p class="login-box-msg"><?php echo $DICIONARIO['discovery_project'] ?></p>
                            <p class="login-box-msg"><?php echo $DICIONARIO['beta_register'] ?></p>
                            <form action="https://kingrespectcrypto.com/controller/envio_email.php" method="post">
                                <div class="input-group mb-3">
                                    <input type="email" name="email" class="form-control" placeholder="<?php echo $DICIONARIO['email'] ?>">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-envelope"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-left-0px">
                                    <div class="g-recaptcha" name="recaptcha" data-sitekey="<?php echo $GLOBAL['site_recaptcha']; ?>"></div>
                                </div>
                                <div class="row m-top-12px">
                                    <div class="col-8">
                                    </div>
                                    <div class="col-4">
                                        <button type="submit" class="btn btn-primary btn-block" name="submit" onclick="return valida()"><?php echo $DICIONARIO['sign_in'] ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-top-1em">
            <div class="col-12">
                <div class="login-logo t_white">
                    <?php echo $DICIONARIO['presetation_video'] ?>
                </div>
                <video width="700" controls autoplay>
                    <source src="https://kingrespectcrypto.com/resources/video/apresentacao.mp4" type="video/mp4">
                    Your browser does not support HTML video.
                </video>
            </div>
        </div>
    </body>

    <script type="text/javascript">
        function valida() {
            if (grecaptcha.getResponse() == "") {
            alert("Recaptcha not checked");
            return false;
            } else return true;
        }
        var slideIndex = 0;
        showSlides(slideIndex);

        // Next/previous controls
        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        // Thumbnail image controls
        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {

            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("dot");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";  
            }
            slideIndex++;
            if (slideIndex > slides.length) {slideIndex = 1}    
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";  
            dots[slideIndex-1].className += " active";
            setTimeout(showSlides, 5000); // Change image every 2 seconds
        }
    </script>

    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="js/adminlte.min.js"></script>
</html>