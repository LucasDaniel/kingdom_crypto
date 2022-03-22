
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    $msg = "";

    if (!isset($_POST['submit'])) { $msg = "ERROR SUBMIT!"; }
    if (($_POST['email'] == '' || $_POST['email'] == null) && ($msg == "")) { $msg = "ERROR EMAIL!"; }
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

            $query = "SELECT * FROM beta_users WHERE email LIKE '$email'";
            if ((mysqli_num_rows(mysqli_query($conn, $query)) > 0) && ($msg == "")) {
                $msg = "E-MAIL ALREADY REGISTERED!";
            }

            $query = "INSERT INTO beta_users(email) VALUES ('$email')";
            if ((!mysqli_query($conn, $query))&& ($msg == "")) {
                $msg = "ERROR WHEN REGISTERING EMAIL!";
            }

            $mensagem = "Your email has been successfully registered. Wait for news about King Respect Crypto";
            $data_envio = date('d/m/Y');
            $hora_envio = date('H:i:s');

            // emails para quem será enviado o formulário
            $emailenviar = "contato@kingrespectcrypto.com";
            $destino = $email;
            $assunto = "Beta registration King Respect Crypto";

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
                if ($msg == "") $msg = "Email registered successfully.";
            } else {
                if ($msg == "") $msg = "ERROR SENDING REGISTRATION CONFIRMATION EMAIL!";
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
                <p class="login-box-msg"><a href="https://kingrespectcrypto.com">Back</a></p>
                </div>
            </div>
            
        </div>
  </div>
</body>
