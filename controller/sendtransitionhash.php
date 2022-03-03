<?php

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

    if (($_POST['h']  == '' || $_POST['h']  == null) && ($msg == "")) { $msg = "ERROR HASH!"; }
    if (($_POST['tx'] == '' || $_POST['tx'] == null) && ($msg == "")) { $msg = "ERROR TRANSITION HASH!"; }
    if (($_POST['v']  == '' || $_POST['v']  == null) && ($msg == "")) { $msg = "ERROR VALUE!"; }
    if (($_POST['s']  == '' || $_POST['s']  == null) && ($msg == "")) { $msg = "ERROR!"; }
    
    if ($msg == "") {

        $hash = $_POST['h'];
        $txhash = $_POST['tx'];
        $value = $_POST['v'];
        $security = $_POST['s'];

        $query = "SELECT * FROM `security` WHERE `security` = '$security'";
        if ((mysqli_num_rows(mysqli_query($conn, $query)) > 0)) {
            $rowSecuritySended = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
        } else {
            $rowSecuritySended['id'] = "critical";
        }

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

            if ($rowSecuritySended['id'] == "critical") {
                $status = "Most Critical ".$security;
            } else {
                if ((intval($rowSecurity['id'])+10) >= intval($rowSecuritySended['id'])) {
                    $status = "Under Analisys";
                } else {
                    if ((intval($rowSecurity['id'])+10) < 21) {
                        if (intval($rowSecuritySended['id']) > 86390) {
                            $status = "Under Analisys Critical 1";
                        } else {
                            $status = "Under Analisys Critical 2";
                        }
                    } else {
                        $status = "Under Analisys Critical 3";
                    }
                }
            }
            
            $query = "INSERT INTO `pedido_deposito`
                                        (`id_user`, `metamask`, `valor`, `status`, `transacao_hash`, `create_at`) 
                                VALUES  ($id,'$metamask',$value,'$status','$txhash','$data')";
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