
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    $msg = "";
    $erro = true;

    if (($_POST['h'] == '' || $_POST['h'] == null) && ($msg == "")) { $msg = "ERROR HASH!"; }
    
    if ($msg == "") {

        $hash = $_POST['h'];

        $query = "SELECT * FROM user WHERE hash LIKE '$hash'";
        if ((mysqli_num_rows(mysqli_query($conn, $query)) > 0) && ($msg == "")) {
            $row = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
            
            $id         = $row['id'];
            $time_stamp = time(); //Pega o timestamp
            $randomico  = rand(1, 9);
            $hash       = md5($id.$time_stamp.$randomico);
            $data       = date("Y-m-d H:i:s");
            $time15     = date("Y-m-d H:i:s",strtotime('+15 minutes', strtotime($data)));

            $query = "UPDATE user SET last_hash='$data', hash_expires='$time15', hash='$hash' WHERE id = $id";
            if (mysqli_query($conn, $query)) {
                $erro = false;
                $msg = "Withdraw an entire amount of respect to BUSD.<br>
                        Min 10 Respect";
                $msg = "Withdraw is unavailable"; //Manter esse botão para a versão beta 
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
                <?php if(!$erro) { ?>
                    <!-- Retirar apos lançar o jogo
                    <form action="https://kingrespectcrypto.com/controller/withdrawaction.php" method="post">
                        <input type="hidden" id="h" name="h" value="< ?php echo $hash ?>">
                        <div class="row m-top-12px">
                            <div class="col-12">
                                <input type="text" name="v" class="form-control" placeholder="Value">
                            </div>
                        </div>
                        <div class="row m-left-0px m-top-12px">
                            <div class="g-recaptcha" name="recaptcha" data-sitekey="< ?php echo $GLOBAL['site_recaptcha']; ?>"></div>
                        </div>
                        <div class="row m-top-12px">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block" name="submit"  onclick="return valida()">Send request withdraw</button>
                            </div>
                        </div>
                    </form>
                    <form action="https://kingrespectcrypto.com/home.php" method="post">
                        <input type="hidden" id="h" name="h" value="< ?php echo $hash ?>">
                        <div class="row m-top-12px">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block" name="submit">Back to house</button>
                            </div>
                        </div>
                    </form>
                <?php } else { ?>
                    <form action="https://kingrespectcrypto.com/login.php" method="post">
                        <input type="hidden" id="h" name="h" value="< ?php echo $hash ?>">
                        <div class="row m-top-12px">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block" name="submit">Back to login</button>
                            </div>
                        </div>
                    </form>
                <?php } ?>
                -->
                
                <!-- Manter esse botão para a versão beta -->
                <form action="https://kingrespectcrypto.com/home.php" method="post">
                    <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                    <div class="row m-top-12px">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block" name="submit">Back to house</button>
                        </div>
                    </div>
                </form>
                <!-- Manter esse botão para a versão beta -->

            </div>
        </div>
  </div>
</body>

<script type="text/javascript">
    function valida() {
        if (grecaptcha.getResponse() == "") {
            alert("Recaptcha not checked.");
            return false;
        } 
        return true;
    }
</script>