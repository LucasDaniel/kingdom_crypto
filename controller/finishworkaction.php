
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    $msg = "";
    $erro = true;

    if (($_POST['h'] == '' || $_POST['h'] == null) && ($msg == "")) { $msg = "ERROR HASH!"; }
    if (($_POST['c'] == '' || $_POST['c'] == null) && ($msg == "")) { $msg = "ERROR CAMA!"; }
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
        $c = $_POST['c'];

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

                $query = "SELECT * FROM servant WHERE id_user = ".$id." AND id = ".$idCharacter." AND work_at NOT LIKE 'nothing'";
                $rowCharacter = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
                if (count($rowCharacter) > 0) {
                    
                    $query = "SELECT * FROM resources WHERE id_user = ".$rowUser['id'];
                    $rowResources = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
                    
                    $query = "SELECT * FROM `season` WHERE `season_end` LIKE (SELECT MIN(`season_end`) min FROM `season` WHERE `season_end` > '$data')";
                    $rowSeason = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
                
                    $query = "SELECT * FROM house WHERE id_user = ".$rowUser['id'];
                    $rowHouse = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);

                    $cama = $c;
                    $cozinha = $rowHouse['cozinha'];
                    $equip = $rowCharacter['equipamento'];
                    $work_at = $rowCharacter['work_at'];
                    $profissao = $rowCharacter['profissao'];
                    $multiplier = $rowCharacter['multiplier'];
                    $bonus = 0;

                    if ($work_at == 'wood') {
                        if ($profissao == 'lenhador') $bonus += 3;
                        else $bonus += 2;
                        $bonus *= $rowSeason['madeira'];
                        $recurso = "Wood";
                    } else if ($work_at == 'fish') {
                        if ($profissao == 'pescador') $bonus += 3;
                        else $bonus += 2;
                        $bonus *= $rowSeason['peixe'];
                        $recurso = "Fish";
                    } else if ($work_at == 'stoneiron') {
                        if ($profissao == 'minerador') $bonus += 3;
                        else $bonus += 2;
                        $bonus *= $rowSeason['pedra'];
                        $recurso = "Stone";
                        $recurso2 = "Iron";
                    } else if ($work_at == 'huntmonsters') {
                        if ($profissao == 'aventureiro') $bonus += 3;
                        else $bonus += 2;
                        $recurso = "Respect";
                    } 

                    $min = rand(1,$bonus)+($equip*2);
                    $max = rand($min+1,$bonus+$bonus)+($equip*2);
                    $bonus = rand($min,$max);
                    if ($recurso != "Respect") {
                        $ganho = 0.01; //A cada 1 = 0,01 cents de dolar (Por enquanto esta assim)
                        $decimais = 2;
                    } else {
                        $ganho = 0.0001; //A cada 1 = 0,01 cents de dolar (Por enquanto esta assim)
                        $decimais = 4;
                    }
                    $ganho *= $bonus*$multiplier;
                    if ($recurso != "Respect") $ganho = round($ganho,$decimais);
                    else $ganho = round($ganho,$decimais);
                    if ($work_at == 'stoneiron') $ganho2 = round($ganho/2,$decimais);

                    $timeSleep = (8*60)-(30*$cama);
                    $recovery_energy = date("Y-m-d H:i:s",strtotime('+'.$timeSleep.' minutes', strtotime($data)));

                    $query = "UPDATE servant SET app_code='', 
                                                 multiplier='1.0', 
                                                 lives=2, 
                                                 work_at='nothing', 
                                                 recovery_energy='$recovery_energy',
                                                 work_init='0000-00-00 00:00:00', 
                                                 work_finish='0000-00-00 00:00:00' 
                                           WHERE id_user = ".$id." 
                                             AND id = ".$idCharacter;
                    if (mysqli_query($conn, $query)) {
                        if ($work_at == 'wood') { //Vai ganhar madeira
                            $query = "UPDATE resources SET madeira = madeira+$ganho WHERE id_user = $id";
                            if (!mysqli_query($conn, $query)) $msg = "Resource wood update error"; 
                        } else if ($work_at == 'fish') { //Vai ganhar peixe
                            $query = "UPDATE resources SET peixe = peixe+$ganho WHERE id_user = $id";
                            if (!mysqli_query($conn, $query)) $msg = "Resource fish update error"; 
                        } else if ($work_at == 'stoneiron') { //Vai ganhar pedra e ferro
                            $query = "UPDATE resources SET pedra = pedra+$ganho, ferro = ferro+$ganho2 WHERE id_user = $id";
                            if (!mysqli_query($conn, $query)) $msg = "Resource stone/iron update error"; 
                        } else if ($work_at == 'huntmonsters') { //Vai ganhar respeito
                            $query = "UPDATE resources SET respeito = respeito+$ganho WHERE id_user = $id";
                            if (!mysqli_query($conn, $query)) $msg = "Resource respect update error"; 
                        } 
                        if ($msg == "") {
                            if ($work_at == 'stoneiron') $msg = "Work finished. You gain $ganho $recurso and $ganho2 $recurso2.";
                            else $msg = "Work finished. You gain $ganho $recurso.";
                            $erro = false;
                        }
                    } else {
                        $msg = "Servant update error"; 
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
