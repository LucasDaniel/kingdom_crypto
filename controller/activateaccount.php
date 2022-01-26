
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    $msg = "";
    $erroCriarConta = false;

    if (!isset($_POST['submit'])) { $msg = "ERROR SUBMIT!"; }
    if (($_POST['email'] == '' || $_POST['email'] == null) && ($msg == "")) { $msg = "ERROR EMAIL!"; }
    if (($_POST['activatepassword'] == '' || $_POST['activatepassword'] == null) && ($msg == "")) { $msg = "ERROR PASSWORD!"; }
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
            //vai fazer o registro
            $email = $_POST['email'];
            $activatepassword = $_POST['activatepassword'];

            $query = "SELECT * FROM user WHERE email LIKE '$email'";
            if ((mysqli_num_rows(mysqli_query($conn, $query)) > 0) && ($msg == "")) {
                $row = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
                if ($row['enabled'] != $activatepassword) {
                    $msg = "INCORRECT ACTIVATION NUMBER!";
                    $erroCriarConta = true;
                } else {
                    if ($row['enabled'] != 0) {
                        $query = "UPDATE user SET enabled='0' WHERE email LIKE '$email'";
                        if (mysqli_query($conn, $query)) {
                            $msg = "";
                        } else {
                            $msg = "ERROR ACTIVATING EMAIL";
                            $erroCriarConta = true;
                        }
                    } else {
                        $msg = "Email already activated. You could already play ;D";
                        $erroCriarConta = true;
                    }
                }
            } else {
                $msg = "E-MAIL NOT EXIST!";
                $erroCriarConta = true;
            }
            
            if (!$erroCriarConta) {

                $mensagem = "Email activated successfully. You can now start playing.";
                $data_envio = date('d/m/Y');
                $hora_envio = date('H:i:s');

                // emails para quem será enviado o formulário
                $emailenviar = "contato@kingrespectcrypto.com";
                $destino = $email;
                $assunto = "Email activated successfully King Respect Crypto";

                // É necessário indicar que o formato do e-mail é html
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $headers .= 'From: King Respect Crypto <'.$emailenviar.'>';
                //$headers .= "Bcc: $EmailPadrao\r\n";

                // Compo E-mail
                $arquivo = "
                    <style type='text/css'>
                        body {
                            margin:0px;
                            font-family:Verdane;
                            font-size:12px;
                            color: #666666;
                        }
                        a {
                            color: #666666;
                            text-decoration: none;
                        }
                        a:hover {
                            color: #FF0000;
                            text-decoration: none;
                        }
                    </style>
                    <html>
                        <table width='510' border='1' cellpadding='1' cellspacing='1' bgcolor='#CCCCCC'>
                            <tr>
                                <td width='320'>$mensagem</td>
                            </tr>
                            <tr>
                                <td width='320'><a href='https://kingrespectcrypto.com/login.php'>Click here to login and play</a></td>
                            </tr>
                            <tr>
                                <td>This email was sent in <b>$data_envio</b> at <b>$hora_envio</b></td>
                            </tr>
                            <tr>
                                <td>Created By: lucasgamestudio.com.br</td>
                            </tr>
                        </table>
                    </html>
                ";
                $enviaremail = false;
                if ($msg == "") $enviaremail = mail($destino, $assunto, $arquivo, $headers);
                if($enviaremail){
                    if ($msg == "") $msg = "Email activated successfully. You can play now :D";
                } else {
                    if ($msg == "") $msg = "ERROR SENDING REGISTRATION CONFIRMATION EMAIL!";
                }
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
                    <?php if ($msg == "Email activated successfully. You can play now :D") { ?> 
                        <p class="login-box-msg"><a href="https://kingrespectcrypto.com/login.php">Go to login</a></p>
                    <?php } else { ?>
                        <p class="login-box-msg"><a href="https://kingrespectcrypto.com/activateaccount.php">Back to activate account</a></p>
                    <?php } ?>
                </div>
            </div>
            
        </div>
  </div>
</body>
