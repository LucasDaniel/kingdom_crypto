
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    $msg = "";

    if (!isset($_POST['submit'])) { $msg = "ERROR SUBMIT!"; }
    if (($_POST['email'] == '' || $_POST['email'] == null) && ($msg == "")) { $msg = "ERROR EMAIL!"; }
    if (($_POST['password'] == '' || $_POST['password'] == null) && ($msg == "")) { $msg = "ERROR PASSWORD!"; }
    if ((empty($_POST['g-recaptcha-response'])) && ($msg == "")) { 
        $msg = "ERROR CAPTCHA 2!";
    } else {

        $url = "https://www.google.com/recaptcha/api/siteverify";
        $secret = $GLOBAL['user_recaptcha'];
        $response = $_POST['g-recaptcha-response'];
        $variaveis = "secret=".$secret."&response=".$response;
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$variaveis);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $resposta = curl_exec($ch);
        $result = json_decode($resposta);

        if (($result->success == 1) && ($msg == "")) {

            $email = $_POST['email'];
            $email = $_POST['PASSWORD'];

            $query = "SELECT * FROM user WHERE email LIKE '$email' AND password LIKE '$password' ";
            if ((mysqli_num_rows(mysqli_query($conn, $query)) > 0) && ($msg == "")) {
                header('Location: http://www.google.com.br');
                //parei aqui - fazer o login do jogador e iniciar o jogo
            } else {
                $msg = "ERROR EMAIL AND/OR PASSWORD!";
            }

        } else {
            if ($msg == "") $msg = "ERROR CAPTCHA 1!";
        }
    }

?>

<body class="hold-transition login-page background_index">
    <div class="login-box">
        <div class="login-logo t_white">
            <?php echo $GLOBAL['title'] ?>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <div class="row">
                    <p class="login-box-msg"><?php echo $msg ?></p>
                </div>
                <div class="row">
                <p class="login-box-msg"><a href="https://kingrespectcrypto.com/login.php">Back to login</a></p>
                </div>
            </div>
        </div>
  </div>
</body>
