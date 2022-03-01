
<?php

    require_once("../database/connect.php");

    $msg = "";
    $metamask = "";
    $erro = true;

    if (($_POST['h'] == '' || $_POST['h'] == null) && ($msg == "")) { $msg = "ERROR HASH!"; }
    
    if ($msg == "") {

        $hash = $_POST['h'];

        $query = "SELECT * FROM user WHERE hash LIKE '$hash'";
        if ((mysqli_num_rows(mysqli_query($conn, $query)) > 0) && ($msg == "")) {
            $row = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
            
            $id       = $row['id'];
            $metamask = $row['metamask'];
            $erro     = false;
            $msg      = "Metamask recupered";
            
        } else {
            $msg      = "Error Metamask";
        }
    }

    $obj->success = !$erro;
    $obj->metamask = $metamask;
    $obj->msg = $msg;
    echo $metamask;

?>