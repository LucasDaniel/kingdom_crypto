
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
            $success = 1;
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
