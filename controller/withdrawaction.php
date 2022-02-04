
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    $msg = "";
    $erro = true;

    if (($_POST['h']  == '' || $_POST['h']  == null) && ($msg == "")) { $msg = "ERROR HASH!"; }
    if (($_POST['v']  == '' || $_POST['v']  == null) && ($msg == "")) { $msg = "ERROR VALUE!"; }
    
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

        $hash = $_POST['h'];
        $value = $_POST['v'];
        if ($_POST['th'] == '' || $_POST['th'] == null) $transation_hash = $_POST['th'];
        else $transation_hash = '';

        $query = "SELECT * FROM user WHERE hash LIKE '$hash'";
        if ((mysqli_num_rows(mysqli_query($conn, $query)) > 0) && ($msg == "")) {
            $row = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
            
            $id         = $row['id'];
            $time_stamp = time(); //Pega o timestamp
            $randomico  = rand(1, 9);
            $hash       = md5($id.$time_stamp.$randomico);
            $data       = date("Y-m-d H:i:s");
            $time15     = date("Y-m-d H:i:s",strtotime('+15 minutes', strtotime($data)));

            $query = "UPDATE user SET last_hash='$data', hash_expires='$time15', hash='$hash' WHERE id = $id";
            if (mysqli_query($conn, $query)) {
                $data = date("Y-m-d H:i:s");
                
                $query = "INSERT INTO `pedido_retirada`(`id_user`, `valor`, `status`) 
                                                VALUES ($id,$value,'Under Analysis')";
                if (!mysqli_query($conn, $query)) {
                    $msg = "ERROR WHEN CREATE WITHDRAW REQUEST!";
                } else {
                    $msg = "Order placed successfully!";
                }
                
            } else {
                $msg = "Sessão expirou 1";
            }
        } else {
            $msg = "Sessão expirou";
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
                <form action="https://kingrespectcrypto.com/home.php" method="post">
                    <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                    <div class="row m-top-12px">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block" name="submit">Back to house</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
  </div>
</body>
