
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    $msg = "";
    $erroCriarConta = false;

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
            //vai fazer o registro
            $email = $_POST['email'];
            $password = $_POST['password'];

            $query = "SELECT * FROM user WHERE email LIKE '$email'";
            if ((mysqli_num_rows(mysqli_query($conn, $query)) > 0) && ($msg == "")) {
                $msg = "E-MAIL ALREADY REGISTERED! Use another email.";
                $erroCriarConta = true;
            } else {
                if (!$erroCriarConta) {
                    $randomico = rand(1000, 9999);
                    $data = date("Y-m-d H:i:s");
                    $query = "INSERT INTO user(email,password,enabled) 
                                    VALUES ('$email','$password','$randomico')";
                    if ((!mysqli_query($conn, $query)) && ($msg == "")) {
                        $msg = "ERROR WHEN REGISTERING EMAIL!";
                        $erroCriarConta = true;
                    } else {
                        $query = "SELECT * FROM user WHERE email LIKE '$email' AND password LIKE '$password' ";
                        if (mysqli_num_rows(mysqli_query($conn, $query)) > 0) {
                            $row = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
                            $id = $row['id'];
                            $query = "INSERT INTO user_app_upgrade(id_user) 
                                        VALUES ($id)";
                            if ((!mysqli_query($conn, $query)) && ($msg == "")) {
                                $msg = "ERROR WHEN REGISTERING USER UPGRADE!";
                                $erroCriarConta = true;
                            }
                            $query = "INSERT INTO user_config(id_user) 
                                        VALUES ($id)";
                            if ((!mysqli_query($conn, $query)) && ($msg == "")) {
                                $msg = "ERROR WHEN REGISTERING USER TUTORIAL!";
                                $erroCriarConta = true;
                            }
                        }
                    }
                }
            }

            if (!$erroCriarConta) {

                $mensagem = "Your email has been successfully registered. Activate your email to play.";
                $data_envio = date('d/m/Y');
                $hora_envio = date('H:i:s');

                // emails para quem será enviado o formulário
                $emailenviar = "contato@kingrespectcrypto.com";
                $destino = $email;
                $assunto = "Activate account King Respect Crypto";

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
                                <td width='320'>Use the code '<b>$randomico</b>' to activate your account</td>
                            </tr>
                            <tr>
                                <td width='320'><a href='https://kingrespectcrypto.com/activateaccount.php'>Click here to activate your account</a></td>
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
                    if ($msg == "") $msg = "Email registered successfully. Go to email to activate your account.";
                } else {
                    if ($msg == "") $msg = "ERROR SENDING REGISTRATION CONFIRMATION EMAIL!";
                }
            }
        } else {
            if ($msg == "") $msg = "ERROR CAPTCHA 1!";
        }
    }
    $url = $_SERVER["REQUEST_URI"];
    $query = "INSERT INTO log(id_user,msg,url) VALUES ($id,'$msg','$url')";
    mysqli_query($conn, $query);
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
                    <?php if (($msg == "Email registered successfully. Go to email to activate your account.")) { ?> 
                        <p class="login-box-msg"><a href="https://kingrespectcrypto.com/activateaccount.php">Go to activate account</a></p>
                    <?php } else { ?>
                        <p class="login-box-msg"><a href="https://kingrespectcrypto.com/register.php">Back to register account</a></p>
                    <?php } ?>
                </div>
            </div>
            
        </div>
  </div>
</body>
