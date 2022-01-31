
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    $msg = "";
    $vaiEvoluir = false;

    if (($_POST['h'] == '' || $_POST['h'] == null) && ($msg == "")) { $msg = "ERROR HASH!"; }
    if (($_POST['ie'] == '' || $_POST['ie'] == null) && ($msg == "")) { $msg = "ERROR CHARACTER!"; }
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
        $idCharacter = $_POST['ie']; //id servant

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

                $query = "SELECT * FROM servant 
                                  WHERE id_user = ".$id." AND id = ".$idCharacter." 
                                    AND work_at LIKE 'nothing'
                                    AND work_init LIKE '0000-00-00 00:00:00'
                                    AND work_finish LIKE '0000-00-00 00:00:00'";
                $rowCharacter = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
                if (count($rowCharacter) > 0) {
                    $query = "SELECT * FROM house WHERE id_user = ".$id;
                    $rowHouse = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);

                    $cozinha = $rowHouse['cozinha'];
                    $timeWork = (8*60)+(30*$cozinha);

                    //calculo de quanto tempo vai ficar trabalhando
                    $endWork = date("Y-m-d H:i:s",strtotime('+'.$timeWork.' minutes', strtotime($data)));
                    $app_code = rand(100000, 999999);
                    $query = "UPDATE servant SET app_code='$app_code', lives=2, multiplier='1.0', work_at='fish', recovery_energy='0000-00-00 00:00:00', work_init='$data', work_finish='$endWork' WHERE id_user = ".$id." AND id = ".$idCharacter."";
                    if (mysqli_query($conn, $query)) {
                        $msg = "Servant working..."; 
                    } else {
                        $msg = "Error Work!"; 
                    }
                } else {
                    $msg = "Servant don't find"; 
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
                            <button type="submit" class="btn btn-primary btn-block" name="submit">Voltar a tela principal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
  </div>
</body>
