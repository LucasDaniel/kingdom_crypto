
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    $msg = "";
    $erro = true;

    if (($_POST['h'] == '' || $_POST['h'] == null) && ($msg == "")) { $msg = "ERROR HASH!"; }
    if (($_POST['amounttorespect'] == '' || $_POST['amounttorespect'] == null) && ($msg == "")) { $msg = "ERROR VALUE TO RESPECT!"; }
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
        $amounttorespect = $_POST['amounttorespect']; //id servant

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

                $resourcediminuir = "";
                if (strpos($amounttorespect,"wood")) {
                    $amount = substr($amounttorespect, 0, -4);
                    $resourcediminuir = "madeira";
                    $resourceIngles = "wood";
                } else if (strpos($amounttorespect,"fish")) {
                    $amount = substr($amounttorespect, 0, -4);
                    $resourcediminuir = "peixe";
                    $resourceIngles = "fish";
                } else if (strpos($amounttorespect,"stone")) {
                    $amount = substr($amounttorespect, 0, -5);
                    $resourcediminuir = "pedra";
                    $resourceIngles = "stone";
                } else if (strpos($amounttorespect,"iron")) {
                    $amount = substr($amounttorespect, 0, -4);
                    $resourcediminuir = "ferro";
                    $resourceIngles = "iron";
                } 

                     if ($amount ==  "1000") $giveRespect =  1;
                else if ($amount ==  "2000") $giveRespect =  2;
                else if ($amount ==  "5000") $giveRespect =  5;
                else if ($amount == "10000") $giveRespect = 10;
                else if ($amount == "20000") $giveRespect = 20;

                $amount = (int)$amount;

                $query = "SELECT * FROM resources WHERE id_user = ".$id." AND $resourcediminuir >= $amount";
                if (mysqli_num_rows(mysqli_query($conn, $query)) > 0) {
                    
                    $query = "UPDATE resources SET $resourcediminuir=$resourcediminuir-$amount, respeito=respeito+$giveRespect, last_update='$data' WHERE id_user = ".$id;
                    
                    if (mysqli_query($conn, $query)) {
                        $msg = "You change $amount $resourceIngles to $giveRespect respect"; 
                        $erro = false;
                    } else {
                        $msg = "Error Work!"; 
                    }

                } else {
                    $msg = "Error Amount Resource";
                    $erro = false;
                }

            } else {
                $msg = "Session expired 1";
            }
        } else {
            $msg = "Session expired";
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
                <?php if (!$erro) { ?>
                    <form action="https://kingrespectcrypto.com/home.php" method="post">
                        <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                        <div class="row m-top-12px">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block" name="submit">Back to house</button>
                            </div>
                        </div>
                    </form>
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
