
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

                $query = "SELECT count(id) quant FROM servant WHERE id_user = ".$rowUser['id'];
                $rowQuant = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC)['quant'];

                $query = "SELECT count(id) quant FROM servant WHERE id_user = ".$rowUser['id']." AND profissao LIKE 'aventureiro'";
                $rowQuantAventureiro = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC)['quant'];
                
                if ($rowQuant < 19) {
                    $precoRandom = 10+(((int)$rowQuant)-(((int)$rowQuantAventureiro)+1));
                    $precoOutros = 12+(((int)$rowQuant)-(((int)$rowQuantAventureiro)+1));
                    $precoAventureiro = 15+(((int)$rowQuantAventureiro)+1);

                    $query = "SELECT * FROM resources WHERE id_user = ".$rowUser['id'];
                    $respeito = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC)['respeito'];

                    $msgRandom = "";
                    $msgOutros = "";
                    $msgAventureiro = "";

                    if ($respeito >= $precoRandom || 
                        $respeito >= $precoOutros || 
                        $respeito >= $precoAventureiro) {
                        
                        if ($respeito >= $precoRandom) $msgRandom = $precoRandom." of respect to hire a random servant";
                        else $msgRandom = "You don't have respect to hire a random servant.";
                        if ($respeito >= $precoOutros) $msgOutros = $precoOutros." of respect to hire "; //Adiciono no botão o tipo de servo
                        else $msgOutros = "You don't have respect to choice hire a ";
                        if ($respeito >= $precoAventureiro) $msgAventureiro = $precoAventureiro." of respect to hire a adventure";
                        else $msgAventureiro = "You don't have respect to hire a adventure.";
                        
                        $msg = "Which servant will you hire?";
                        $erro = false;
                    } else {
                        $msg = "You dont have respect to hire";
                        $back = true;
                    }
                    
                } else {
                    $msg = "Maximum number of servants (Full House)";
                    $erro = false;
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
                        <form action="https://kingrespectcrypto.com/controller/contractnewservantaction.php" method="post">
                            <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                            <div class="row m-left-0px">
                                <div class="g-recaptcha" name="recaptcha" data-sitekey="<?php echo $GLOBAL['site_recaptcha']; ?>"></div>
                            </div>
                            <div class="row m-top-12px">
                                <div class="col-12">
                                    <select name="profissao">
                                        <option><?php echo $msgRandom; ?></option>
                                        <option><?php echo $msgOutros."lumberman"; ?></option>
                                        <option><?php echo $msgOutros."fisherman"; ?></option>
                                        <option><?php echo $msgOutros."miner"; ?></option>
                                        <option><?php echo $msgAventureiro; ?></option>
                                    </select>
                                </div>
                            </div>                        
                            <div class="row m-top-12px">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block" name="submit" onclick="return valida()">Hire servant</button>
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
                                <button type="submit" class="btn btn-primary btn-block" name="submit">Back to home</button>
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
