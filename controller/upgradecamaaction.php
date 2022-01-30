
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    $msg = "";
    $vaiEvoluir = false;

    if (($_POST['h'] == '' || $_POST['h'] == null) && ($msg == "")) { $msg = "ERROR HASH!"; }
    if (($_POST['c'] == '' || $_POST['c'] == null) && ($msg == "")) { $msg = "ERROR CAMA!"; }
    if ((empty($_POST['g-recaptcha-response'])) && ($msg == "")) { 
        $msg = "ERROR CAPTCHA 2!";
    } else {
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $secret = $GLOBAL['user_recaptcha'];
        $response = $_POST['g-recaptcha-response'];
        $variaveis = "secret=".$secret."&response=".$response;
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$variaveis);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $resposta = curl_exec($ch);
        $result = json_decode($resposta);

        if (($result->success == 1) && ($msg == "")) {
        } else {
            if ($msg == "") $msg = "ERROR CAPTCHA 1!";
        }
    }

    if ($msg == "") {

        $hash = $_POST['h'];
        $c = $_POST['c'];

        $query = "SELECT * FROM user WHERE hash LIKE '$hash'";
        if ((mysqli_num_rows(mysqli_query($conn, $query)) > 0) && ($msg == "")) {
            $rowUser = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
            
            $id         = $rowUser['id'];
            $time_stamp = time(); //Pega o timestamp
            $randomico  = rand(1, 9);
            $hash       = md5($id.$time_stamp.$randomico);
            $data       = date("Y-m-d H:i:s");
            $time15     = date("Y-m-d H:i:s",strtotime('+15 minutes', strtotime($data)));

            $query = "UPDATE user SET last_hash='$data', hash_expires='$time15', hash='$hash' WHERE id = $id";
            if (mysqli_query($conn, $query)) {
                $data = date("Y-m-d H:i:s");

                $query = "SELECT * FROM resources WHERE id_user = ".$rowUser['id'];
                $rowResources = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
                
                $query = "SELECT * FROM house WHERE id_user = ".$rowUser['id'];
                $rowHouse = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
                
                //Valores para a logica
                $respeito = $rowResources['respeito'];
                $c = $_POST['c'];
                $cama = $rowHouse[$c];
                $preco = 5 + ($cama*2);
                $dif = $respeito-$preco;

                $query = "UPDATE resources SET respeito=$dif, last_update='$data' WHERE id = $id";
                //parei aqui, fazendo a modificação no banco quando fizer upgrade
                if (mysqli_query($conn, $query)) {
                
                    if ($cama < 10) {
                        if ($respeito >= $preco) {
                            $msg = "To improve the bed you need $preco of respect.";
                            $vaiEvoluir = true;
                        } else {
                            $msg = "Improved bed to max level";
                        }
                    } else {
                        $msg = "Bed could be improved. Do you have enough resources. ($preco respect)";
                    }

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
    }
?>

<body class="hold-transition login-page background_index">
    <div class="login-box">
        <div class="login-logo t_white">
            <?php echo $GLOBAL['title'] ?>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <div class="row">
                    <p class="login-box-msg"><?php echo $msg ?></p>
                </div>
                <form action="https://kingrespectcrypto.com/home.php" method="post">
                    <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                    <div class="row m-top-12px">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block" name="submit">Voltar a tela principal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
  </div>
</body>