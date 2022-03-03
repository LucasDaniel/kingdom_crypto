
<?php

    require_once("../database/connect.php");

    $msg = "";
    $metamask = "";
    $erro = true;

    if (($_POST['h'] == '' || $_POST['h'] == null) && ($msg == "")) { $msg = "ERROR HASH!"; }
    if (($_POST['m'] == '' || $_POST['m'] == null) && ($msg == "")) { $msg = "ERROR METAMASK!"; }
    
    if ($msg == "") {

        $hash = $_POST['h'];
        $metamask = $_POST['m'];

        $query = "SELECT * FROM user WHERE hash LIKE '$hash'";
        if ((mysqli_num_rows(mysqli_query($conn, $query)) > 0) && ($msg == "")) {
            $row = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
            
            $id       = $row['id'];

            $query = "UPDATE user SET metamask='$metamask' WHERE id = $id";
            if (mysqli_query($conn, $query)) {
                $erro = false;
                $msg = "Success";
            } else {
                $msg = "Error update metamask";
            }
        } else {
            $msg      = "Error Metamask";
        }
    }

    echo $msg;

?>