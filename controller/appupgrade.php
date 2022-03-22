
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    $msg = "";
    $erro = true;
    $back = false;

    if (($_POST['h'] == '' || $_POST['h'] == null) && ($msg == "")) { $msg = "ERROR HASH!"; }

    if ($msg == "") {

        $hash = $_POST['h'];

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
                
                $query = "SELECT * FROM user_app_upgrade WHERE id_user = $id ";
                if (mysqli_num_rows(mysqli_query($conn, $query)) > 0) {
                
                    $row = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
                    $multiplier = $row['multiplier'];
                    
                    if ($multiplier == 1) {
                        $msg = "App Upgraded!";
                        $erro = false;
                        $back = true;
                    } else {
                        $query = "SELECT * FROM resources WHERE id_user = ".$rowUser['id'];
                        $rowResources = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);

                        if ($rowResources['respeito'] >= 5) {
                            $msg = "To upgrade app need 5 of respect.";
                            $erro = false;
                        } else {
                            $msg = "You dont have 5 of respect!";
                            $back = true;
                        }
                    }
                } else {
                    $msg = "UPGRADE APP ERROR"; 
                }

            } else {
                $msg = "Session expired 1";
            }
        } else {
            $msg = "Session expired";
        }
    }

    $url = $_SERVER["REQUEST_URI"];
    $query = "UPDATE log SET id_user=$id, msg='$msg', url='$url'";
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
                        <form action="https://kingrespectcrypto.com/controller/appupgradeaction.php" method="post">
                            <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                            <div class="row m-left-0px">
                                <div class="g-recaptcha" name="recaptcha" data-sitekey="<?php echo $GLOBAL['site_recaptcha']; ?>"></div>
                            </div>
                            <div class="row m-top-12px">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block" name="submit" onclick="return valida()">Upgrade App</button>
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
