
<?php

    require_once("connect.php");

    //Para capturar o corpo JSON
    $json = json_decode(file_get_contents('php://input'), true);

    $email = $json['usuario'];
    $password = $json['password'];
    $page = "login";
    $msg = "";
    $hash = "0";
    $success = 0;
    $rowServants = [];
    $j = -1;

    $query = "SELECT * FROM user WHERE email LIKE '$email' AND password LIKE '$password' ";
    if ((mysqli_num_rows(mysqli_query($conn, $query)) > 0) && ($msg == "")) {
        $row = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
        
        $id         = $row['id'];
        $time_stamp = time(); //Pega o timestamp
        $randomico  = rand(1, 9);
        $hash       = md5($id.$time_stamp.$randomico);
        $data       = date("Y-m-d H:i:s");
        $time15     = date("Y-m-d H:i:s",strtotime('+15 minutes', strtotime($data)));

        $query = "UPDATE user SET last_login_app='$data', last_hash_app='$data', hash_expire_app='$time15', hash_app='$hash' WHERE id = $id";
        if (mysqli_query($conn, $query)) {
            $msg = "Successfully logged in";
            $query = "SELECT * FROM user_app_upgrade WHERE id_user = $id ";
            if (mysqli_num_rows(mysqli_query($conn, $query)) > 0) {
                $row = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
                $multiplier_upgrade = $row['multiplier'];
                $lives_upgrade      = $row['lives'];

                $query = "SELECT * 
                            FROM `servant` 
                            WHERE `id_user` = $id 
                              AND `work_finish` > NOW() 
                              AND `lives` > 0 
                              AND app_code != ''";
                $mysql = mysqli_query($conn, $query);
                $i = 0;
                if (mysqli_num_rows($mysql) > 0) {
                    while ($rowServant = mysqli_fetch_array($mysql, MYSQLI_ASSOC)) {
                        $rowServants[$i] = $rowServant;
                        $i++;
                    } 
                }
                $success = 1;
            } else {
                $msg = "ERROR USER UPGRADE";
            }
        } else {
            $msg = "ERROR";
        }
    } else {
        $msg = "Wrong email or password";
    }

    $url = $_SERVER["REQUEST_URI"];
    $query = "INSERT INTO log(id_user,msg,url) VALUES ($id,'$msg','$url')";
    mysqli_query($conn, $query);

    $obj->success = $success;
    $obj->page = $page;
    $obj->msg = $msg;
    $obj->multiplier_upgrade = $multiplier_upgrade;
    $obj->lives_upgrade = $lives_upgrade;
    $obj->hash = $hash;

    /*
        "id":"7",
         "id_user":"9",
         "profissao":"minerador",
         "equipamento":"2",
         "app_code":"676127",
         "multiplier":"1",
         "lives":"2",
         "work_at":"stoneiron",
         "recovery_energy":"0000-00-00 00:00:00",
         "work_init":"2022-03-13 08:22:17",
         "work_finish":"2022-03-13 16:52:17",
         "create_at":"2022-01-27 12:11:20",
         "last_update":"2022-02-01 06:56:26"
    */
    $j++;
    if ($i > 0) {
        $obj->servant1_id = $rowServants[$j]['id'];
        $obj->servant1_id_user = $rowServants[$j]['id_user'];
        $obj->servant1_profissao = $rowServants[$j]['profissao'];
        $obj->servant1_app_code = $rowServants[$j]['app_code'];
        $obj->servant1_multiplier = $rowServants[$j]['multiplier'];
        $obj->servant1_lives = $rowServants[$j]['lives'];
        $obj->servant1_work_at = $rowServants[$j]['work_at'];
    }

    $j++;
    if ($i > 1) {
        $obj->servant2_id = $rowServants[$j]['id'];
        $obj->servant2_id_user = $rowServants[$j]['id_user'];
        $obj->servant2_profissao = $rowServants[$j]['profissao'];
        $obj->servant2_app_code = $rowServants[$j]['app_code'];
        $obj->servant2_multiplier = $rowServants[$j]['multiplier'];
        $obj->servant2_lives = $rowServants[$j]['lives'];
        $obj->servant2_work_at = $rowServants[$j]['work_at'];
    }

    $j++;
    if ($i > 2) {
        $obj->servant3_id = $rowServants[$j]['id'];
        $obj->servant3_id_user = $rowServants[$j]['id_user'];
        $obj->servant3_profissao = $rowServants[$j]['profissao'];
        $obj->servant3_app_code = $rowServants[$j]['app_code'];
        $obj->servant3_multiplier = $rowServants[$j]['multiplier'];
        $obj->servant3_lives = $rowServants[$j]['lives'];
        $obj->servant3_work_at = $rowServants[$j]['work_at'];
    }

    $j++;
    if ($i > 3) {
        $obj->servant4_id = $rowServants[$j]['id'];
        $obj->servant4_id_user = $rowServants[$j]['id_user'];
        $obj->servant4_profissao = $rowServants[$j]['profissao'];
        $obj->servant4_app_code = $rowServants[$j]['app_code'];
        $obj->servant4_multiplier = $rowServants[$j]['multiplier'];
        $obj->servant4_lives = $rowServants[$j]['lives'];
        $obj->servant4_work_at = $rowServants[$j]['work_at'];
    }

    $j++;
    if ($i > 4) {
        $obj->servant5_id = $rowServants[$j]['id'];
        $obj->servant5_id_user = $rowServants[$j]['id_user'];
        $obj->servant5_profissao = $rowServants[$j]['profissao'];
        $obj->servant5_app_code = $rowServants[$j]['app_code'];
        $obj->servant5_multiplier = $rowServants[$j]['multiplier'];
        $obj->servant5_lives = $rowServants[$j]['lives'];
        $obj->servant5_work_at = $rowServants[$j]['work_at'];
    }

    $j++;
    if ($i > 5) {
        $obj->servant6_id = $rowServants[$j]['id'];
        $obj->servant6_id_user = $rowServants[$j]['id_user'];
        $obj->servant6_profissao = $rowServants[$j]['profissao'];
        $obj->servant6_app_code = $rowServants[$j]['app_code'];
        $obj->servant6_multiplier = $rowServants[$j]['multiplier'];
        $obj->servant6_lives = $rowServants[$j]['lives'];
        $obj->servant6_work_at = $rowServants[$j]['work_at'];
    }

    $j++;
    if ($i > 6) {
        $obj->servant7_id = $rowServants[$j]['id'];
        $obj->servant7_id_user = $rowServants[$j]['id_user'];
        $obj->servant7_profissao = $rowServants[$j]['profissao'];
        $obj->servant7_app_code = $rowServants[$j]['app_code'];
        $obj->servant7_multiplier = $rowServants[$j]['multiplier'];
        $obj->servant7_lives = $rowServants[$j]['lives'];
        $obj->servant7_work_at = $rowServants[$j]['work_at'];
    }

    $j++;
    if ($i > 7) {
        $obj->servant8_id = $rowServants[$j]['id'];
        $obj->servant8_id_user = $rowServants[$j]['id_user'];
        $obj->servant8_profissao = $rowServants[$j]['profissao'];
        $obj->servant8_app_code = $rowServants[$j]['app_code'];
        $obj->servant8_multiplier = $rowServants[$j]['multiplier'];
        $obj->servant8_lives = $rowServants[$j]['lives'];
        $obj->servant8_work_at = $rowServants[$j]['work_at'];
    }

    $j++;
    if ($i > 8) {
        $obj->servant9_id = $rowServants[$j]['id'];
        $obj->servant9_id_user = $rowServants[$j]['id_user'];
        $obj->servant9_profissao = $rowServants[$j]['profissao'];
        $obj->servant9_app_code = $rowServants[$j]['app_code'];
        $obj->servant9_multiplier = $rowServants[$j]['multiplier'];
        $obj->servant9_lives = $rowServants[$j]['lives'];
        $obj->servant9_work_at = $rowServants[$j]['work_at'];
    }

    $j++;
    if ($i > 9) {
        $obj->servant10_id = $rowServants[$j]['id'];
        $obj->servant10_id_user = $rowServants[$j]['id_user'];
        $obj->servant10_profissao = $rowServants[$j]['profissao'];
        $obj->servant10_app_code = $rowServants[$j]['app_code'];
        $obj->servant10_multiplier = $rowServants[$j]['multiplier'];
        $obj->servant10_lives = $rowServants[$j]['lives'];
        $obj->servant10_work_at = $rowServants[$j]['work_at'];
    }
    //Parei aqui, fazer uma função pra fazer as coisas mais rapido

    $obj->quant_servants = $i;

    echo json_encode($obj);

?>
