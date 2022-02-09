
<?php

    require_once("connect.php");

    //Para capturar o corpo JSON
    $json = json_decode(file_get_contents('php://input'), true);

    $hash = $json['hash'];
    $gamecode = $json['gamecode'];
    $multiplier = $json['multiplier'];
    $page = "multiplier";
    $msg = "";
    $success = 0;

    $query = "SELECT * FROM user WHERE hash_app LIKE '$hash' ";
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

            $query = "UPDATE servant SET multiplier = '$multiplier', lives=0 WHERE app_code LIKE '$gamecode' AND id_user = $id AND recovery_energy = '0000-00-00 00:00:00'";
            if (mysqli_query($conn, $query)) {
                $msg = "Multiplier saved!";
                $success = 1;
            } else {
                $msg = "Update error. Critcal!";
            }
        } else {
            $msg = "ERROR";
        }
    } else {
        $msg = "Wrong email or password";
    }

    $obj->success = $success;
    $obj->page = $page;
    $obj->msg = $msg;
    $obj->hash = $hash;

    echo json_encode($obj);

?>
