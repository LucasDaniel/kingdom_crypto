<?php 

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
                $data = date("Y-m-d H:i:s");
                $erro = false;
                $msg = "To report a bug, send email to contato@kingrespectcrypto.com<br>
                        Put images and explain the bug for better compression.<br>
                        Don't forget to say your metamask wallet.<br>";
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
            <form action="https://kingrespectcrypto.com/home.php" method="post">
                <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                <div class="row m-top-12px">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block" name="submit">Back to house</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
  </div>
  <?php require_once("redes_sociais.php"); ?>
</body>
