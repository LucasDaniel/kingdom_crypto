
<?php

    require_once("connect.php");

    //Para capturar o corpo JSON
    $json = json_decode(file_get_contents('php://input'), true);

    $gamecode = $json['gamecode'];
    $hash = $json['hash'];
    $passwordcode = $json['passwordgamecode'];
    $page = "gamecode";
    $msg = "";
    $success = 0;
    $obj->gamecodesend = $gamecode;
    $obj->pagesend = $page;
    $obj->hashsend = $hash;
    $obj->passwordcodesend = $passwordcode;
    $obj->aqui = "eee";
    $query = "SELECT * FROM user WHERE hash_app LIKE '$hash'";
    if ((mysqli_num_rows(mysqli_query($conn, $query)) > 0) && ($msg == "")) {
        $row = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
        
        $password = $row['password'];
        $obj->password = $password;
        $obj->aqui = "ddd";
        if ($password == $passwordcode) {

            $id         = $row['id'];
            $obj->id = $id;
            $time_stamp = time(); //Pega o timestamp
            $randomico  = rand(1, 9);
            $hash       = md5($id.$time_stamp.$randomico);
            $data       = date("Y-m-d H:i:s");
            $time15     = date("Y-m-d H:i:s",strtotime('+15 minutes', strtotime($data)));
            $obj->aqui = "ccc";
            $query = "UPDATE user SET last_login_app='$data', last_hash_app='$data', hash_expire_app='$time15', hash_app='$hash' WHERE id = $id";
            if (mysqli_query($conn, $query)) {
                $obj->aqui = "aaa";
                $query = "SELECT * FROM servant WHERE id_user = $id AND app_code LIKE '$gamecode'";
                if ((mysqli_num_rows(mysqli_query($conn, $query)) > 0) && ($msg == "")) {
                    $row = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
                    $obj->aqui = "bbb";
                    $profissao   = $row['profissao'];
                    $equipamento = $row['equipamento'];
                    $multiplier = $row['multiplier'];
                    $lives = $row['lives'];
                    $work_at = $row['work_at'];

                    if ($lives > 0) {
                        $success = 1;
                        $msg = "Collect ";
                        if ($work_at == "wood") $msg .= "wood";
                        else if ($work_at == "fish") $msg .= "fish";
                        else if ($work_at == "stoneiron") $msg .= "stone and iron";
                        else if ($work_at == "huntmonsters") $msg = "Hunt monters";
                        else $msg = "no work?";
                    } else {
                        $msg = "No more lives";
                    }
                } else {
                    $msg = "Wrong game code";
                }
            } else {
                $msg = "ERROR";
            }
        } else {
            $msg = "Wrong password";
        }
    } else {
        $msg = "Hash incorrect, login again";
        $page = "login";
        $hash = "0";
    }

    $obj->success = $success;
    $obj->page = $page;
    $obj->msg = $msg;
    $obj->hash = $hash;
    if ($success == 1) {
        $obj->profissao = $profissao; 
        $obj->equipamento = $equipamento;
        $obj->multiplier = $multiplier;
        $obj->lives = $lives;
        $obj->work_at = $work_at;
    }

    echo json_encode($obj);

?>
