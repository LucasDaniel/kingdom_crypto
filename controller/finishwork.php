
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    $msg = "";
    $erro = true;

    if (($_POST['h'] == '' || $_POST['h'] == null) && ($msg == "")) { $msg = "ERROR HASH!"; }
    if (($_POST['c'] == '' || $_POST['c'] == null) && ($msg == "")) { $msg = "ERROR CAMA!"; }
    if (($_POST['ie'] == '' || $_POST['ie'] == null) && ($msg == "")) { $msg = "ERROR CHARACTER!"; }

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
                
                $query = "SELECT * FROM resources WHERE id_user = ".$rowUser['id'];
                $rowResources = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);

                $query = "SELECT * FROM `season` WHERE `season_end` LIKE (SELECT MIN(`season_end`) min FROM `season` WHERE `season_end` > '$data')";
                $rowSeason = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
                
                $query = "SELECT * FROM house WHERE id_user = ".$rowUser['id'];
                $rowHouse = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);

                $query = "SELECT * FROM servant WHERE id_user = ".$id." AND id = ".$idCharacter." AND work_at NOT LIKE 'nothing'";
                $rowCharacter = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);

                if (count($rowCharacter) > 0) {

                    $cama = $rowHouse[$c];
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
                    } else if ($work_at == 'fish') {echo "<br>";
                        if ($profissao == 'pescador') $bonus += 3;
                        else $bonus += 2;
                        $bonus *= $rowSeason['peixe'];
                        $recurso = "Fish";
                    } else if ($work_at == 'stoneiron') {echo "<br>";
                        if ($profissao == 'minerador') $bonus += 3;
                        else $bonus += 2;
                        $bonus *= $rowSeason['pedra'];
                        $recurso = "Stone";
                        $recurso2 = "Iron";
                    } else if ($work_at == 'huntmonsters') {echo "<br>";
                        if ($profissao == 'aventureiro') $bonus += 3;
                        else $bonus += 2;
                        $recurso = "Respect";
                    } 
                    
                    $min = 1+($equip*2);
                    $max = $bonus+$bonus+($cozinha*2);
                    if ($recurso != "Respect") {
                        $ganho = 1; //Modifica aqui para diminuir o ganho do jogador
                        $decimais = 2;
                    } else {
                        $ganho = 0.01; //Modifica aqui para diminuir o ganho do jogador
                        $decimais = 4;
                    }
                    $min = round($min*$ganho,$decimais);
                    $max = round($max*$ganho,$decimais);

                    if ($work_at != 'stoneiron') $msg = "Finish work and gain between $min and $max multiplied by $multiplier of $recurso.";
                    else $msg = "Finish work and gain between $min and $max multiplied by $multiplier of $recurso and half $recurso of $recurso2.";
                    $erro = false;

                } else {
                    $msg = "Servant dont find";
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
                    <form action="https://kingrespectcrypto.com/controller/finishworkaction.php" method="post">
                        <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                        <input type="hidden" id="c" name="c" value="<?php echo $cama ?>">
                        <input type="hidden" id="ie" name="ie" value="<?php echo $idCharacter ?>">
                        <div class="row m-left-0px">
                            <div class="g-recaptcha" name="recaptcha" data-sitekey="<?php echo $GLOBAL['site_recaptcha']; ?>"></div>
                        </div>
                        <div class="row m-top-12px">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block" name="submit" onclick="return valida()">Finish Work</button>
                            </div>
                        </div>
                    </form>
                    <script type="text/javascript">
                        function valida() {
                            if (grecaptcha.getResponse() == "") {
                                alert("Recaptcha not checked.");
                                return false;
                            } 
                            return true;
                        }
                    </script>
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
