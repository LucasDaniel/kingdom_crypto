
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    $msg = "";
    $vaiTrabalhar = false;

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

            $query = "UPDATE user SET last_hash='$data', hash_expires='$time15', hash='$hash' WHERE id = $id";
            if (mysqli_query($conn, $query)) {
                $msg = "Would you like to put the servant to hunt monsters?";
                $vaiTrabalhar = true;
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
                <?php if (!$vaiTrabalhar) { ?>
                    <form action="https://kingrespectcrypto.com/home.php" method="post">
                        <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                        <div class="row m-top-12px">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block" name="submit">Voltar a tela principal</button>
                            </div>
                        </div>
                    </form>
                <?php } else { ?>
                    <form action="https://kingrespectcrypto.com/controller/huntmonstersaction.php" method="post">
                        <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                        <input type="hidden" id="ie" name="ie" value="<?php echo $idCharacter ?>">
                        <div class="row m-left-0px">
                            <div class="g-recaptcha" name="recaptcha" data-sitekey="<?php echo $GLOBAL['site_recaptcha']; ?>"></div>
                        </div>
                        <div class="row m-top-12px">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block" name="submit" onclick="return valida()">Hunt Monsters</button>
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
            </div>
        </div>
  </div>
</body>