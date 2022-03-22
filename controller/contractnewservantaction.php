
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    $msg = "";
    $erro = true;

    if (($_POST['h']         == '' || $_POST['h']         == null) && ($msg == "")) { $msg = "ERROR HASH!"; }
    if (($_POST['profissao'] == '' || $_POST['profissao'] == null) && ($msg == "")) { $msg = "ERROR HIRE!"; }
    
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
        $select = $_POST['profissao'];

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

                $query = "SELECT count(id) quant FROM servant WHERE id_user = ".$rowUser['id'];
                $rowQuant = (int)mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC)['quant'];

                $query = "SELECT count(id) quant FROM servant WHERE id_user = ".$rowUser['id']." AND profissao LIKE 'aventureiro'";
                $rowQuantAventureiro = (int)mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC)['quant'];
                
                if ($rowQuant < 19) {
                    $precoRandom = 10*($rowQuant-($rowQuantAventureiro+1));
                    $precoOutros = 12*($rowQuant-($rowQuantAventureiro+1));
                    $precoAventureiro = 15*($rowQuantAventureiro+1);

                    $query = "SELECT * FROM resources WHERE id_user = ".$rowUser['id'];
                    $respeito = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC)['respeito'];

                    $msgRandom = "";
                    $msgOutros = "";
                    $msgAventureiro = "";
                    
                    if ($respeito >= $precoRandom || 
                        $respeito >= $precoOutros || 
                        $respeito >= $precoAventureiro) {

                        $random          = strpos($select, "random");
                        $submitlumber    = strpos($select, "lumberman");
                        $submitfish      = strpos($select, "fisherman");
                        $submitminer     = strpos($select, "miner");
                        $submitadventure = strpos($select, "adventure");

                             if ($random)          { $profissao = rand(1,4); $preco = $precoRandom; }
                        else if ($submitlumber)    { $profissao = 1;         $preco = $precoOutros; }
                        else if ($submitfish)      { $profissao = 2;         $preco = $precoOutros; }
                        else if ($submitminer)     { $profissao = 3;         $preco = $precoOutros; }
                        else if ($submitadventure) { $profissao = 4;         $preco = $precoAventureiro; }

                             if ($profissao == 1 || $profissao == '1') $profissao = "lenhador";
                        else if ($profissao == 2 || $profissao == '2') $profissao = "pescador";
                        else if ($profissao == 3 || $profissao == '3') $profissao = "minerador";
                        else $profissao = "aventureiro";

                        $query = "INSERT INTO `servant`(`id_user`, `profissao`, `equipamento`, `app_code`, 
                                                        `multiplier`, `lives`, `work_at`, `recovery_energy`, 
                                                        `work_init`, `work_finish`, `create_at`, `last_update`) 
                                                    VALUES ($id,'$profissao',0,'',
                                                                1,2,'nothing' ,'',
                                                                '','','$data','$data')";
                        
                        if (!mysqli_query($conn, $query)) {
                            $msg = "ERROR WHEN CREATE SERVANT!";
                        } else {
                            $query = "UPDATE resources SET respeito = respeito-$preco WHERE id_user = $id";
                            if (mysqli_query($conn, $query)) {
                                if ($profissao == 'lenhador') $profissao = 'Lumberjack';
                                else if ($profissao == 'pescador') $profissao = 'Fisherman';
                                else if ($profissao == 'minerador') $profissao = 'Miner';
                                else $profissao = 'Hunter';
                                $msg = "You contract a new ".$profissao;
                                $erro = false;
                            } else {
                                $msg = "Resource respect update error"; 
                            }
                        }

                    } else {
                        $msg = "You don't have respect to hire";
                        $erro = false;
                    }

                } else {
                    $msg = "Maximum number of servants (Full House)";
                    $erro = false;
                }
            } else {
                $msg = "Session expired";
            }
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
