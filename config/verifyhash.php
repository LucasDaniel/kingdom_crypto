
<?php

$hash = $_POST['h'];

if (($_POST['tt'] != '' || $_POST['tt'] != null)) { $tt = $_POST['tt']; }
else { $tt = false; }

$erroHash = "";
$expirou = false;

$query = "SELECT * FROM user WHERE hash LIKE '$hash'";
//$query = "SELECT * FROM user WHERE id = 9";
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
            $query = "SELECT * FROM servant WHERE id_user = ".$rowUser['id'];
            $mysql = mysqli_query($conn, $query); 
            $i = 0;
            while ($row = mysqli_fetch_array($mysql, MYSQLI_ASSOC)) {
                $rowsCharacters[$i] = $row; 
                $work_at = $rowsCharacters[$i]['work_at'];
                if ($work_at == "nothing") $work_at = " --- ";
                else if ($work_at == "wood") $work_at = "Woodcutter... ";
                else if ($work_at == "fish") $work_at = "Fishing... ";
                else if ($work_at == "stoneiron") $work_at = "Mining... ";
                else if ($work_at == "huntmonsters") $work_at = "Hunting... ";
                $rowsCharacters[$i]['work_at'] = $work_at;
                $i++;
            }
            
            $query = "SELECT * FROM resources WHERE id_user = $id";
            $rowResources = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
            $query = "SELECT * FROM `season` WHERE `season_end` LIKE (SELECT MIN(`season_end`) min FROM `season` WHERE `season_end` > '$data')";
            $rowSeason = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
            $query = "SELECT * FROM user_config WHERE id_user = $id";
            $rowTutorial = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
            $tutorial = $rowTutorial['tutorial'];

            //Se eu tiver enviando um tt, significa que é pra modificar o tutorial pro valor do tt
            if ($tt) {
                //Se for 1 ele veio do botar o servant pra trabalhar
                //Vai verificar se o tutorial vindo do servidor é 0, se for 0, atualiza o servidor com 1
                if ($tt == 1 && $tutorial == 0) {
                    $query = "UPDATE user_config SET tutorial=1 WHERE id_user = $id";
                    $a = mysqli_query($conn, $query);
                    $tutorial = 1;
                }
            }

            
        } else {
            $msg = "ERROR CREATE HASH";
        }
    }
} else {
    $expirou = true;
}

if ($expirou) $erroHash = "Session expired";

?>

