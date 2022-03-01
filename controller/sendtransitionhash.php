<?php

    require_once("../database/connect.php");

    $msg = "";
    $erro = true;

    if (($_POST['h']  == '' || $_POST['h']  == null) && ($msg == "")) { $msg = "ERROR HASH!"; }
    if (($_POST['tx'] == '' || $_POST['tx'] == null) && ($msg == "")) { $msg = "ERROR TRANSITION HASH!"; }
    if (($_POST['v']  == '' || $_POST['v']  == null) && ($msg == "")) { $msg = "ERROR VALUE!"; }
    
    if ($msg == "") {

        $hash = $_POST['h'];
        $txhash = $_POST['tx'];
        $value = $_POST['v'];

        if ($value == "one") $value = 10;
        else if ($value == "two") $value = 50;
        else if ($value == "three") $value = 100;
        else $value = 0;

        $query = "SELECT * FROM user WHERE hash LIKE '$hash'";
        if ((mysqli_num_rows(mysqli_query($conn, $query)) > 0) && ($msg == "")) {
            $row = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
            
            $id       = $row['id'];
            $metamask = $row['metamask'];
            $data       = date("Y-m-d H:i:s");
            
            $query = "INSERT INTO `pedido_deposito`
                                        (`id_user`, `metamask`, `valor`, `status`, `transacao_hash`, `create_at`) 
                                VALUES  ($id,'$metamask',$value,'Under Analisys','$txhash','$data')";
            if (!mysqli_query($conn, $query)) {
                $msg = "ERROR CREATE DEPOSIT";
            } else {
                $msg = "Success";
            }
            
        } else {
            $msg = "Error Metamask";
        }
    }

    echo $msg;

?>