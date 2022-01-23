
<?php

    require_once("../database/connect.php");

    if ($_POST['email'] == '' || $_POST['email'] == null) { header('Location:../index.php'); die; }
    $email = $_POST['email'];

    $query = "SELECT * FROM beta_users WHERE email LIKE '$email'";
    if (mysqli_num_rows(mysqli_query($conn, $query)) > 0) {
        $msg = "EMAIL JÁ CADASTRADO!";
        echo $msg." <meta http-equiv='refresh' content='3;URL=../index.php'>";
        die;
    }

    $query = "INSERT INTO beta_users(email) VALUES ('$email')";
    if (!mysqli_query($conn, $query)) {
        $msg = "ERRO AO CADASTRAR EMAIL!";
        echo $msg." <meta http-equiv='refresh' content='3;URL=../index.php'>";
        die;
    }

    $mensagem = "Seu email foi cadastrado com sucesso. Aguarde para novidades sobre o Kingdom Crypto";
    $data_envio = date('d/m/Y');
    $hora_envio = date('H:i:s');

    // emails para quem será enviado o formulário
    $emailenviar = "contato@kingdomcrypto.com";
    $destino = $email;
    $assunto = "Cadastro no beta";

    // É necessário indicar que o formato do e-mail é html
    $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: Kingdom Crypto <'.$emailenviar.'>';
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
                    <td>
                        <tr>
                            <td width='320'>$mensagem</td>
                        </tr>
                    </td>
                </tr>
                <tr>
                    <td>Este e-mail foi enviado em <b>$data_envio</b> às <b>$hora_envio</b></td>
                </tr>
            </table>
        </html>
    ";

    $enviaremail = true;//mail($destino, $assunto, $arquivo, $headers);
    if($enviaremail){
        $msg = "Email cadastrado com sucesso.<br>Aguarde alguns segundos para voltar pra pagina anterior.";
        echo $msg." <meta http-equiv='refresh' content='3;URL=../index.php'>";
    } else {
        $msg = "ERRO AO ENVIAR EMAIL DE CONFIRMAÇÃO DE CADASTRO!";
        echo $msg." <meta http-equiv='refresh' content='3;URL=../index.php'>";
    }

?>
