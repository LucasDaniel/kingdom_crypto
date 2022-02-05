
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    if (($_POST['h']   == '' || $_POST['h']   == null)) { 

        $hash   = $_POST['h'];

        $query = "SELECT * FROM user WHERE hash LIKE '$hash'";

        if ((mysqli_num_rows(mysqli_query($conn, $query)) > 0)) {
            $rowUser = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
            
            $id         = $rowUser['id'];
            $data       = date("Y-m-d H:i:s");

            $query = "UPDATE user SET hash_expires='$data', hash='' WHERE id = $id";
            mysqli_query($conn, $query);
        }
    }

    header('Location: http://www.kingrespectcrypto.com/login.php');

?>
