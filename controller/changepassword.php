
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    $msg = "";
    $erro = true;

    if (($_POST['h'] == '' || $_POST['h'] == null) && ($msg == "")) { $msg = "ERROR HASH!"; }
    
    if  ($msg == "") {

        $hash = $_POST['h'];

        $query = "SELECT * FROM user WHERE hash LIKE '$hash' ";
        if ((mysqli_num_rows(mysqli_query($conn, $query)) > 0) && ($msg == "")) {
            $row = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
            
            $id         = $row['id'];
            $time_stamp = time(); //Pega o timestamp
            $randomico  = rand(1, 9);
            $hash       = md5($id.$time_stamp.$randomico);
            $data       = date("Y-m-d H:i:s");
            $time15     = date("Y-m-d H:i:s",strtotime('+15 minutes', strtotime($data)));

            $query = "UPDATE user SET last_login='$data', last_hash='$data', hash_expires='$time15', hash='$hash' WHERE id = $id";
            if (mysqli_query($conn, $query)) {
                
                $msg = "Change your password!";
                $erro = false;
                
            } else {
                $msg = "ERROR CREATE HASH";
            }
        } else {
            $msg = "ERROR EMAIL AND/OR PASSWORD!";
        }
    } else {
        $msg = "ERROR HASH!";
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
                    <form action="https://kingrespectcrypto.com/controller/changepasswordaction.php" method="post">
                        <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                        <div class="row m-top-12px">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>New Password (more than 5 characters) </label>
                                    <input type="password" id="np" name="np" class="form-control" placeholder="***">
                                </div>
                            </div>
                        </div>
                        <div class="row m-top-12px">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Re New Password </label>
                                    <input type="password" id="rnp" name="rnp" class="form-control" placeholder="***">
                                </div>
                            </div>
                        </div>
                        <div class="row m-top-12px">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Current Password </label>
                                    <input type="password" id="cp" name="cp" class="form-control" placeholder="***">
                                </div>
                            </div>
                        </div>
                        <div class="row m-left-0px">
                            <div class="g-recaptcha" name="recaptcha" data-sitekey="<?php echo $GLOBAL['site_recaptcha']; ?>"></div>
                        </div>
                        <div class="row m-top-12px">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block" name="submit">Change password</button>
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
    function valida() {
        if (grecaptcha.getResponse() == "") {
            alert("Recaptcha not checked.");
            return false;
        } 
        return true;
    }
</script>