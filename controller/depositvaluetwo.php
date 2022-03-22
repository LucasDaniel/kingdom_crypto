
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    $msg = "";
    $erro = true;

    $hora = date("H");
    $min  = date("m");
    $seg  = date("s");
    $concat = "lucas".$hora.$min.$seg;
    $horaMd5 = md5($concat);

    $query = "SELECT * FROM `security` WHERE `security` = '$horaMd5'";
    $rowSecurity = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
    $s = $rowSecurity['security'];

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

<style>
    .login-box-msg {
        padding: 0 5px 20px;
    }
</style>

<body class="hold-transition login-page background_index">
    <div class="login-box">
        <div class="login-logo t_white">
            <?php echo $GLOBAL['title'] ?>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <div class="row">
                    <p class="login-box-msg">Do not close this page. Take a print screen if necessary</p>
                    <p id="msg1" class="login-box-msg"></p>
                    <p id="msg2" class="login-box-msg"></p>
                    <p id="msg3" class="login-box-msg"></p>
                    <p id="msg4" class="login-box-msg"></p>
                    <p id="msgerror" class="login-box-msg"></p>
                </div>
                <?php if(!$erro) { ?>
                    <form action="https://kingrespectcrypto.com/home.php" method="post">
                        <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                        <div class="row m-top-12px">
                            <div class="col-12">
                                <button style="display:none" type="submit" id="btBack" class="btn btn-primary btn-block" name="submit">Back to house</button>
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
    document.getElementById("btBack").style.display = "none";
    var hash = "<?php echo $hash; ?>";
    var accounts = getAccount();
    async function getAccount() {
        accounts = await ethereum.request({ method: 'eth_requestAccounts' });
    }
    //document.getElementById("msg1").innerHTML = "I have changed!";
    $.ajax({
        type: "POST",
        url: "https://kingrespectcrypto.com/controller/getmetamask.php",
        data: {h:hash} ,
        success: function (msg) {
            chamaMetamask(accounts[0]);
            document.getElementById("msg1").innerHTML = "Metamask connected: "+accounts[0];
        },
        error: function (request, status, error) {
            document.getElementById("msgerror").innerHTML = error;
        },
        complete: function(data) {
        }
    });

    function chamaMetamask(metamask) {
        console.log("chamaMetamask");
        console.log(metamask);
        document.getElementById("msg2").innerHTML = "Calling transation!";
        ethereum.request({
            method: 'eth_sendTransaction',
            params: [
                {
                    from: metamask,
                    to: '0x5Abe441997FD4f747f37A95E171b802F8E1393e2', 
                    value: '0x1cdda4faccd0000',
                },
            ],
        }).then((txHash) => {
            document.getElementById("msg3").innerHTML = "Sending transation hash to server!";
            sendTransitionHash(txHash);
        }).catch((error) => {
            if (error.code == 4001) document.getElementById("msgerror").innerHTML = "Transação negada";
            else document.getElementById("msgerror").innerHTML = error;
            document.getElementById("btBack").style.display = "block";
        });
    }

    function sendTransitionHash(txHash) {
        var str = "";
        $.ajax({
            type: "POST",
            url: "https://kingrespectcrypto.com/controller/sendtransitionhash.php",
            data: {h:hash, tx:txHash, v:"two", s:"<?php echo $s; ?>"} ,
            success: function (msg) {
                if (msg.indexOf("Success") != -1) str = "Transaction sent successfully";
                else str = "Error saving transaction";
                document.getElementById("msg4").innerHTML = str;
                document.getElementById("btBack").style.display = "block";
            },
            error: function (request, status, error) {
                document.getElementById("msgerror").innerHTML = error;
            },
            complete: function(data) {
            }
        });
    }
</script>