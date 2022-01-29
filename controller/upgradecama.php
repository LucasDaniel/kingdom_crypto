
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    $msg = "";

    if (($_POST['h'] == '' || $_POST['h'] == null) && ($msg == "")) { $msg = "ERROR HASH!"; }
    if ($msg == "") {

        $hash = $_POST['h'];
        $profissao = $_POST['p'];

        $query = "SELECT * FROM user WHERE hash LIKE '$hash'";
        if ((mysqli_num_rows(mysqli_query($conn, $query)) > 0) && ($msg == "")) {
            $row = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
            
            $id         = $row['id'];
            $time_stamp = time(); //Pega o timestamp
            $randomico  = rand(1, 9);
            $hash       = md5($id.$time_stamp.$randomico);
            $data       = date("Y-m-d H:i:s");
            $time15     = date("Y-m-d H:i:s",strtotime('+15 minutes', strtotime($data)));

            $query = "UPDATE user SET last_hash='$data', hash_expires='$time15', hash='$hash' WHERE id = $id";
            if (mysqli_query($conn, $query)) {
                $data = date("Y-m-d H:i:s");

                //pegou o usuario e atualizou o hash, vai pegar os valores que precisa pra atualizar a cama
                //select nos resources
                //caso não tenha o que precisa, mostra um aviso e um botão pra voltar pra tela de home, utilizando o hash
                //caso tenha, pergunta se deseja fazer esse upgrade pagando x e y e mostra o recaptcha do google.
                //ao selecionar o recaptcha, envia pra outra tela de confirmação de compra
                //na tela de confirmação de compra, verifica de novo se possui
                //faz os updates e mostra um botão de concluido e um botão pra voltar pra tela home com o hash
                
            } else {
                $msg = "Sessão expirou 1";
            }
        } else {
            $msg = "Sessão expirou";
        }
    }

?>
