
<?php

$hash = 1;//$_POST['h'];
$erroHash = "";
$expirou = false;

$query = "SELECT * FROM user WHERE hash LIKE '$hash'";
$query = "SELECT * FROM user WHERE id = 9";
if (mysqli_num_rows(mysqli_query($conn, $query)) > 0) {
    $rowUser = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
    $hashExpires = strtotime($rowUser['hash_expires']);
    $now = strtotime(date("Y-m-d H:i:s"));
    $tempoParaExpirar = ($hashExpires - $now);
    if ($tempoParaExpirar < 0) {
        $expirou = true;
    } else {
        $id = $rowUser['id'];
        $time_stamp = time(); //Pega o timestamp
        $randomico = rand(1, 9);
        $hash = md5($id.$time_stamp.$randomico);
        $data = date("Y-m-d H:i:s");
        $time15 = date("Y-m-d H:i:s",strtotime('+15 minutes', strtotime($data)));

        //Atualiza o hash
        $query = "UPDATE user SET last_login='$data', last_hash='$data', hash_expires='$time15', hash='$hash' WHERE id = $id";
        if (mysqli_query($conn, $query)) {
            $erroHash = "";
            $expirou = false;
            $query = "SELECT * FROM house WHERE id_user = ".$rowUser['id'];
            $rowHouse = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
            $query = "SELECT * FROM `character` WHERE `id_user` = ".$rowUser['id'];
            $mysql = mysqli_query($conn, $query); 
            $i = 0;
            while ($row = mysqli_fetch_array($mysql, MYSQLI_ASSOC)) {
                $rowsCharacters[$i] = $row; 
                $i++;
            }
            //$rowCharacters = mysqli_fetch_array(, MYSQLI_);
            $query = "SELECT * FROM resources WHERE id_user = ".$rowUser['id'];
            $rowResources = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
        } else {
            $msg = "ERROR CREATE HASH";
        }
    }
} else {
    $expirou = true;
}

if ($expirou) $erroHash = "sessão expirou";

?>

