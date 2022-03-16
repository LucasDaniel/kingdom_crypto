
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    $msg = "";

    if (!isset($_POST['submit'])) { $msg = "ERROR SUBMIT!"; }
    if (($_POST['email'] == '' || $_POST['email'] == null) && ($msg == "")) { $msg = "ERROR EMAIL!"; }
    if (($_POST['password'] == '' || $_POST['password'] == null) && ($msg == "")) { $msg = "ERROR PASSWORD!"; }
    if ((empty($_POST['g-recaptcha-response'])) && ($msg == "")) { 
        $msg = "ERROR CAPTCHA 2!";
    } else {
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $secret = $GLOBAL['user_recaptcha'];
        $response = $_POST['g-recaptcha-response'];
        $variaveis = "secret=".$secret."&response=".$response;
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$variaveis);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $resposta = curl_exec($ch);
        $result = json_decode($resposta);

        if (($result->success == 1) && ($msg == "")) {

            $email = $_POST['email'];
            $password = $_POST['password'];

            $query = "SELECT * FROM user WHERE email LIKE '$email' AND password LIKE '$password' ";
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
                    $query = "SELECT * FROM house WHERE id_user = $id";
                    if (mysqli_num_rows(mysqli_query($conn, $query)) > 0) { //se tiver criado uma casa, nao precisa criar uma casa
                        $row = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
                        $msg = "Sessão inciada com sucesso";
                    } else {
                        $msg = "Primeira vez aqui";
                    }
                } else {
                    $msg = "ERROR CREATE HASH";
                }
            } else {
                $msg = "ERROR EMAIL AND/OR PASSWORD!";
            }
        } else {
            if ($msg == "") $msg = "ERROR CAPTCHA 1!";
        }
    }

?>

<?php if ($msg != "Primeira vez aqui") { ?>
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
                <?php if ($msg == "Sessão inciada com sucesso") { ?>
                <form action="https://kingrespectcrypto.com/home.php" method="post">
                    <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                    <div class="row m-top-12px">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block" name="submit"><?php echo $DICIONARIO['play'] ?></button>
                        </div>
                    </div>
                </form>
                <?php } ?>
                <div class="row">
                    <p class="login-box-msg"><a href="https://kingrespectcrypto.com/login.php">Back to login</a></p>
                </div>
            </div>
        </div>
  </div>
</body>
<?php } else { //Vai mostrar as profissões para iniciar ?>
<body class="hold-transition login-page background_index">
    <div class="login-box">
        <div class="login-logo t_white">
            <?php echo $GLOBAL['title'] ?>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <div class="row">
                    <p class="login-box-msg">Escolha a profissão do seu primeiro servo</p>
                </div>
                <form action="https://kingrespectcrypto.com/controller/criarconta.php" method="post">
                    <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                    <?php // 1=lenhador, 2=pescador, 3=minerador, 4=aventureiro ?>
                    <input type="hidden" id="p" name="p" value="1">
                    <div class="row m-top-12px">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block" name="submit">Lumberjack</button>
                        </div>
                    </div>
                </form>
                <form action="https://kingrespectcrypto.com/controller/criarconta.php" method="post">
                    <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                    <?php // 1=lenhador, 2=pescador, 3=minerador, 4=aventureiro ?>
                    <input type="hidden" id="p" name="p" value="2">
                    <div class="row m-top-12px">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block" name="submit">Fisherman</button>
                        </div>
                    </div>
                </form>
                <form action="https://kingrespectcrypto.com/controller/criarconta.php" method="post">
                    <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                    <?php // 1=lenhador, 2=pescador, 3=minerador, 4=aventureiro ?>
                    <input type="hidden" id="p" name="p" value="3">
                    <div class="row m-top-12px">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block" name="submit">Miner</button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <p class="login-box-msg"><a href="https://kingrespectcrypto.com/login.php">Back to login</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
<?php } ?>