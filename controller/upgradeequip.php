
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    $msg = "";
    $erro = true;
    $back = false;

    if (($_POST['h'] == '' || $_POST['h'] == null) && ($msg == "")) { $msg = "ERROR HASH!"; }
    if (($_POST['e'] == '' || $_POST['e'] == null) && ($msg == "")) { $msg = "ERROR EQUIP!"; }
    if (($_POST['ie'] == '' || $_POST['ie'] == null) && ($msg == "")) { $msg = "ERROR CHARACTER!"; }

    if ($msg == "") {

        $hash = $_POST['h'];
        $e = $_POST['e'];   //lv equip
        $ie = $_POST['ie']; //id servant

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

                $query = "SELECT * FROM resources WHERE id_user = ".$rowUser['id'];
                $rowResources = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
                
                //Valores para a logica
                $respeito = $rowResources['respeito'];
                $equip = $_POST['e'];
                $preco = 5 + ($equip*2);
                $erro = false;
                if ($equip < 10) {
                    if ($respeito >= $preco) {
                        $msg = "To improve the equip you need $preco of respect.";
                    } else {
                        $msg = "Bed could be improved. Do you have enough resources. ($preco respect)";
                        $back = true;
                    }
                } else {
                    $msg = "Improved equip to max level";
                    $back = true;
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
                        <form action="https://kingrespectcrypto.com/controller/upgradeequipaction.php" method="post">
                            <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                            <input type="hidden" id="e" name="e" value="<?php echo $e ?>">
                            <input type="hidden" id="ie" name="ie" value="<?php echo $ie ?>">
                            <div class="row m-left-0px">
                                <div class="g-recaptcha" name="recaptcha" data-sitekey="<?php echo $GLOBAL['site_recaptcha']; ?>"></div>
                            </div>
                            <div class="row m-top-12px">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block" name="submit" onclick="return valida()">Improve equipament</button>
                                </div>
                            </div>
                        </form>
                    <?php } ?>
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
