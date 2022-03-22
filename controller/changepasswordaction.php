
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    $msg = "";
    $erro = true;
    $back = false;

    if (($_POST['h']   == '' || $_POST['h']   == null) && ($msg == "")) { $msg = "ERROR HASH!"; }
    if (($_POST['np']  == '' || $_POST['np']  == null) && ($msg == "")) { $msg = "ERROR NEW PASSWORD!"; }
    if (($_POST['rnp'] == '' || $_POST['rnp'] == null) && ($msg == "")) { $msg = "ERROR RE NEW PASSWORD!"; }
    if (($_POST['cp']  == '' || $_POST['cp']  == null) && ($msg == "")) { $msg = "ERROR CURRENT PASSWORD!"; }
    
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
            
        } else {
            if ($msg == "") $msg = "ERROR CAPTCHA 1!";
        }
    }

    if ($msg == "") {

        $hash   = $_POST['h'];
        $currentPassword = $_POST['cp'];
        $newPassword = $_POST['np'];
        $reNewPassword = $_POST['rnp'];

        $query = "SELECT * FROM user WHERE hash LIKE '$hash'";

        if ((mysqli_num_rows(mysqli_query($conn, $query)) > 0) && ($msg == "")) {
            $rowUser = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
            
            $id         = $rowUser['id'];
            $time_stamp = time(); //Pega o timestamp
            $randomico  = rand(1, 9);
            $hash       = md5($id.$time_stamp.$randomico);
            $data       = date("Y-m-d H:i:s");
            $time15     = date("Y-m-d H:i:s",strtotime('+15 minutes', strtotime($data)));

            $query = "UPDATE user SET last_hash='$data', hash_expires='$time15', hash='$hash' WHERE id = $id";
            if (mysqli_query($conn, $query)) {
                $data = date("Y-m-d H:i:s");

                $query = "SELECT * FROM user WHERE password LIKE '$currentPassword'";
                if ((mysqli_num_rows(mysqli_query($conn, $query)) > 0) && ($msg == "")) {

                    if ($newPassword == $reNewPassword) {

                        $query = "UPDATE user SET password='$newPassword' WHERE id = $id";
                        if (mysqli_query($conn, $query)) {

                            $erro = false;

                            $mensagem = "Your password has been successfully changed.";
                            $data_envio = date('d/m/Y');
                            $hora_envio = date('H:i:s');

                            // emails para quem será enviado o formulário
                            $emailenviar = "contato@kingrespectcrypto.com";
                            $destino = "lucasd.beltrame@gmail.com";//$email;
                            $assunto = "Password changed";

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
                                            <td width='320'>New password is '<b>$newPassword</b>'</td>
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
                                if ($msg == "") $msg = "Password changed successfully. We send a confirmation in your email ".$destino;
                            } else {
                                if ($msg == "") $msg = "ERROR SENDING PASSWORD CHANGED EMAIL!";
                            }
                            $back = true;

                        } else {
                            $msg = "ERROR IN CHANGE PASSWORD";
                        }
                    } else {
                        $erro = false;
                        $msg = "New password and Retype password don't match";
                    }

                } else {
                    $msg = "Current password incorrect. Log in again.";
                }

            } else {
                $msg = "Session expired 1";
            }
        } else {
            $msg = "Session expired";
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
                <?php if (!$erro) { ?>
                    <?php if (!$back) { ?>
                        <form action="https://kingrespectcrypto.com/controller/changepassword.php" method="post">
                            <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                            <div class="row m-top-12px">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block" name="submit">Back to change password</button>
                                </div>
                            </div>
                        </form>
                    <?php } else {?>
                        <form action="https://kingrespectcrypto.com/home.php" method="post">
                            <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                            <div class="row m-top-12px">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block" name="submit">Back to house</button>
                                </div>
                            </div>
                        </form>
                    <?php } ?>
                <?php } else { ?>
                    <form action="https://kingrespectcrypto.com/login.php" method="post">
                        <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                        <div class="row m-top-12px">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block" name="submit">Back to login</button>
                            </div>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
  </div>
</body>
