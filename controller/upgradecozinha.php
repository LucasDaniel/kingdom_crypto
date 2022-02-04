
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    $msg = "";
    $vaiEvoluir = false;

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
                $data = date("Y-m-d H:i:s");

                $query = "SELECT * FROM resources WHERE id_user = ".$rowUser['id'];
                $rowResources = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
                
                $query = "SELECT * FROM house WHERE id_user = ".$rowUser['id'];
                $rowHouse = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
                
                //Valores para a logica
                $respeito = $rowResources['respeito'];
                $cozinha = $rowHouse['cozinha'];
                $preco = 5 + ($cozinha*2);
                if ($cozinha < 10) {
                    if ($respeito >= $preco) {
                        $msg = "To improve the kitchen you need $preco of respect.";
                        $vaiEvoluir = true;
                    } else {
                        $msg = "Kitchen could be improved. Do you have enough resources. ($preco respect)";
                    }
                } else {
                    $msg = "Improved kitchen to max level";
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
                <?php if (!$vaiEvoluir) { ?>
                    <form action="https://kingrespectcrypto.com/home.php" method="post">
                        <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                        <div class="row m-top-12px">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block" name="submit">Voltar a tela principal</button>
                            </div>
                        </div>
                    </form>
                <?php } else { ?>
                    <form action="https://kingrespectcrypto.com/controller/upgradecozinhaaction.php" method="post">
                        <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                        <div class="row m-left-0px">
                            <div class="g-recaptcha" name="recaptcha" data-sitekey="<?php echo $GLOBAL['site_recaptcha']; ?>"></div>
                        </div>
                        <div class="row m-top-12px">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block" name="submit" onclick="return valida()">Improve Kitchen</button>
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