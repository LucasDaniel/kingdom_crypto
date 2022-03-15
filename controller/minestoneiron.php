
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    $msg = "";
    $erro = true;

    if (($_POST['h'] == '' || $_POST['h'] == null) && ($msg == "")) { $msg = "ERROR HASH!"; }
    if (($_POST['ie'] == '' || $_POST['ie'] == null) && ($msg == "")) { $msg = "ERROR CHARACTER!"; }

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

            $query = "SELECT * FROM user_config WHERE id_user = $id";
            $rowTutorial = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
            $tutorial = $rowTutorial['tutorial'];

            $query = "UPDATE user SET last_hash='$data', hash_expires='$time15', hash='$hash' WHERE id = $id";
            if (mysqli_query($conn, $query)) {
                $msg = "Would you like to put the servant to mine stone and iron?";
                $erro = false;
            } else {
                $msg = "Sessão expirou 1";
            }
        } else {
            $msg = "Sessão expirou";
        }
    }
?>

<body class="hold-transition login-page background_index">
    <div class="tutorial_click3" id="back_tutorial3">
    </div>
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
                    <form action="https://kingrespectcrypto.com/controller/minestoneironaction.php" method="post">
                        <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                        <input type="hidden" id="ie" name="ie" value="<?php echo $idCharacter ?>">
                        <div class="row m-left-0px">
                            <div class="g-recaptcha" name="recaptcha" data-sitekey="<?php echo $GLOBAL['site_recaptcha']; ?>"></div>
                        </div>
                        <div class="row m-top-12px">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block" name="submit" onclick="return valida()">Mine stone and iron</button>
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

<script type="text/javascript">
    var tutorial = 0;

    var tutorialNv = <?php echo $tutorial; ?>;
    if (tutorialNv == 1) {
        removeTutorialPrincipal();
    }

    function removeTutorialPrincipal() {
        document.getElementById("back_tutorial3").style.display = "none";
    }
</script>