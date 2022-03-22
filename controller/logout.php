
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    $msg = "";
    $erro = false;
    if (($_POST['h'] == '' || $_POST['h'] == null) && ($msg == "")) { $msg = "ERROR HASH!"; }

    if ($msg == "") { 
        $hash  = $_POST['h'];
        $query = "SELECT * FROM user WHERE hash LIKE '$hash'";
        if ((mysqli_num_rows(mysqli_query($conn, $query)) > 0)) {
            $rowUser = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
            $id         = $rowUser['id'];
            $data       = date("Y-m-d H:i:s");
            $query = "UPDATE user SET hash_expires='$data', hash='' WHERE id = $id";
            if (mysqli_query($conn, $query)) {
                $erro = false;
            } else {
                $erro = true;
            }
        } else {
            $erro = true;
        }
    } else {
        $erro = true;
    }
    $url = $_SERVER["REQUEST_URI"];
    $query = "INSERT INTO log(id_user,msg,url) VALUES ($id,'$msg','$url')";
    mysqli_query($conn, $query);
?>

<?php if(!$erro) { ?>
<script type="text/javascript">
    window.location.href = 'https://kingrespectcrypto.com/login.php';
</script>
<?php } else { ?>
<script type="text/javascript">
    window.location.href = 'https://kingrespectcrypto.com/home.php';
</script>
<?php } ?>
