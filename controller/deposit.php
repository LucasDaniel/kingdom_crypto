
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
            $metamask   = $row['metamask'];
            $time_stamp = time(); //Pega o timestamp
            $randomico  = rand(1, 9);
            $hash       = md5($id.$time_stamp.$randomico);
            $data       = date("Y-m-d H:i:s");
            $time15     = date("Y-m-d H:i:s",strtotime('+15 minutes', strtotime($data)));

            $query = "UPDATE user SET last_hash='$data', hash_expires='$time15', hash='$hash' WHERE id = $id";
            if (mysqli_query($conn, $query)) {
                $erro = false;

                $query = "SELECT * FROM deposit_values";
                $row = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);

                $msg = "Loading metamask wallet";
                $msg = "Deposit is unavailable"; //Manter esse botão para a versão beta 
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
                    <p id="msgDeposit" class="login-box-msg"><?php echo $msg ?></p>
                </div>
                <?php if(!$erro) { ?>
                    <div id="btsDeposit">
                        <form action="https://kingrespectcrypto.com/controller/depositvalueone.php" method="post">
                            <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                            <div class="row m-top-12px">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block" name="submit" >Deposit <?php echo $row['zero_respect']; ?> BNB to 10 respect</button>
                                </div>
                            </div>
                        </form>
                        <form action="https://kingrespectcrypto.com/controller/depositvaluetwo.php" method="post">
                            <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                            <div class="row m-top-12px">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block" name="submit" >Deposit <?php echo $row['um_respect']; ?> BNB to 50 respect</button>
                                </div>
                            </div>
                        </form>
                        <form action="https://kingrespectcrypto.com/controller/depositvaluethree.php" method="post">
                            <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                            <div class="row m-top-12px">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block" name="submit" >Deposit <?php echo $row['dois_respect']; ?> BNB to 100 respect</button>
                                </div>
                            </div>
                        </form>
                        <form action="https://kingrespectcrypto.com/home.php" method="post">
                            <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                            <div class="row m-top-12px">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block" name="submit">Back to house</button>
                                </div>
                            </div>
                        </form>
                    </div>
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
    var msgDeposit = "Choice amount of BNB to transform in king respect";
    <?php if($metamask != "") { ?>
        var metamask = <?php echo $metamask; ?>;
    <?php } else { ?>
        var metamask = "";
    <?php } ?>
    var hash = "<?php echo $hash; ?>";
    //document.getElementById("msgDeposit").innerHTML = msgDeposit; //Manter esse botão para a versão beta
    document.getElementById("btsDeposit").style.display = "none"; //Manter esse botão para a versão beta
    var accounts = 0;//getAccount(); //Manter esse botão para a versão beta
    async function getAccount() {
        accounts = await ethereum.request({ method: 'eth_requestAccounts' });
        setTimeout(() => {
            verifyAccounts()
        }, 1000);
    }
    function verifyAccounts() {
        if (!accounts) {
            setTimeout(() => {
                verifyAccounts()
            }, 1000);
        } else {
            if (metamask == "") {
                $.ajax({
                    type: "POST",
                    url: "https://kingrespectcrypto.com/controller/setmetamask.php",
                    data: {h:hash,m:accounts[0]},
                    success: function (msg) {
                        document.getElementById("msgDeposit").innerHTML = msgDeposit;
                        document.getElementById("btsDeposit").style.display = "block";
                    },
                    error: function (request, status, error) {
                        document.getElementById("msgerror").innerHTML = error;
                    },
                    complete: function(data) {
                    }
                });
            }
        }
    }
</script>