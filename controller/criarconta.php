
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    $msg = "";
    $erro = true;

    if (($_POST['h'] == '' || $_POST['h'] == null) && ($msg == "")) { $msg = "ERROR HASH!"; }
    if (($_POST['p'] == '' || $_POST['p'] == null) && ($msg == "")) { $msg = "ERROR PROFISSÃO!"; }
    if ($msg == "") {

        $hash = $_POST['h'];
        $profissao = $_POST['p'];

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
                $query = "INSERT INTO house(id_user,cama1,create_at,last_update) 
                                VALUES ($id,1,'$data','$data')";
                if (!mysqli_query($conn, $query)) {
                    $msg = "ERROR WHEN CREATE HOUSE!";
                } else {
                    if ($profissao == 1 || $profissao == '1') $profissao = "lenhador";
                    else if ($profissao == 2 || $profissao == '2') $profissao = "pescador";
                    else if ($profissao == 3 || $profissao == '3') $profissao = "minerador";
                    else $profissao = "lenhador";
                    $query = "INSERT INTO servant(  `id_user`, `profissao`, `equipamento`,
                                                    `multiplier`, `lives`, `work_at`, `recovery_energy`, 
                                                    `work_init`, `work_finish`, `create_at`, `last_update`) 
                                            VALUES ($id,'$profissao',0,
                                                    1,2,'nothing' ,'',
                                                    '','','$data','$data')";
                    if (!mysqli_query($conn, $query)) {
                        $msg = "ERROR WHEN CREATE SERVANT!";
                    } else {
                        $respeito = 0;
                        $query = "INSERT INTO `resources`(`id_user`, `respeito`, `create_at`, `last_update`) 
                                   VALUES ($id,$respeito,'$data','$data')";
                        if (!mysqli_query($conn, $query)) {
                            $msg = "ERROR WHEN CREATE RESOURCES!";
                        } else {
                            $msg = "Primeiro servo criado com sucesso";
                            $erro = false;
                        }
                    }
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
                <?php if(!$erro) { ?>
                    <form action="https://kingrespectcrypto.com/home.php" method="post">
                        <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                        <div class="row m-top-12px">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block" name="submit"><?php echo $DICIONARIO['play'] ?></button>
                            </div>
                        </div>
                    </form>
                <?php } else { ?>
                    <div class="row">
                        <p class="login-box-msg"><a href="https://kingrespectcrypto.com/login.php">Back to login</a></p>
                    </div>
                <?php } ?>
            </div>
        </div>
  </div>
</body>