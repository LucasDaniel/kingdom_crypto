
<?php

    require_once("../config/imports.php");
    require_once("../database/connect.php");

    $msg = "";
    $erro = true;

    if (($_POST['h'] == '' || $_POST['h'] == null) && ($msg == "")) { $msg = "ERROR HASH!"; }
    
    if ($msg == "") {

        $hash = $_POST['h'];

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
                $erro = false;
                $msg = "Choice amount of BNB to transform in king respect";
            } else {
                $msg = "Sessão expirou 1";
            }
        } else {
            $msg = "Sessão expirou";
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
                <?php if(!$erro) { ?>
                    <form action="https://kingrespectcrypto.com/controller/depositvalueone.php" method="post">
                        <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                        <div class="row m-top-12px">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block" name="submit" >Deposit 0.03 BNB to 10 respect</button>
                            </div>
                        </div>
                    </form>
                    <form action="https://kingrespectcrypto.com/controller/depositvaluetwo.php" method="post">
                        <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                        <div class="row m-top-12px">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block" name="submit" >Deposit 0.12 BNB to 50 respect</button>
                            </div>
                        </div>
                    </form>
                    <form action="https://kingrespectcrypto.com/controller/depositvaluethree.php" method="post">
                        <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                        <div class="row m-top-12px">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block" name="submit" >Deposit 0.22 BNB to 100 respect</button>
                            </div>
                        </div>
                    </form>
                    <!-- 
                         Parei aqui 

                         Criar as três telas de depositar a quantidade de BNB corretas
                         Ao entrar na tela, vai mostrar o botão de fazer o pedido de deposito
                         Depois do recaptcha do google, clica em submit e vai pro controller
                         pra fazer o deposito da metamask

                         Na tela de deposito vai executar rapidamente o javascript
                         vai mostrar somente como esta a transição de deposito
                         Vai mostrar imagens de como precisa estar a metamask na smart chain.
                         Depois que coneguir fazer a transação, vai mostrar o numero da transação
                         vou salvar o numero da transação e a carteira que depositou
                         
                         Vai ter uma tela que o jogador poderá colocar o numero da transição
                         faço uma requisição pro bscan, ai se retornar ok, deposito o respeito da quantidade

                        <script type="text/javascript">
                            const ethereumButton = document.querySelector('.enableEthereumButton');
                            const sendEthButton = document.querySelector('.sendEthButton');

                            let accounts = [];
                            //Sending Ethereum to an address
                            sendEthButton.addEventListener('click', () => {
                            ethereum
                                .request({
                                    method: 'eth_sendTransaction',
                                    params: [
                                        {
                                            from: accounts[0],
                                            to: '0x5Abe441997FD4f747f37A95E171b802F8E1393e2',
                                            value: '0x6a94d74f430000',
                                            //gasPrice: '0x09184e72a000',
                                            //gas: '0x2710',
                                        },
                                    ],
                                })
                                .then((txHash) => {
                                    
                                    console.log(txHash);
                                })
                                .catch((error) => console.error);
                            });

                            ethereumButton.addEventListener('click', () => {
                                getAccount();
                            });

                            async function getAccount() {
                                accounts = await ethereum.request({ method: 'eth_requestAccounts' });
                            }
                        </script>

                    -->
                    <form action="https://kingrespectcrypto.com/home.php" method="post">
                        <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                        <div class="row m-top-12px">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block" name="submit">Back to house</button>
                            </div>
                        </div>
                    </form>
                <?php } else { ?>
                    <form action="https://kingrespectcrypto.com/login.php" method="post">
                        <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                        <div class="row m-top-12px">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block" name="submit">Back to login</button>
                            </div>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
  </div>
</body>

<script type="text/javascript">
    function valida() {
        if (grecaptcha.getResponse() == "") {
            alert("Recaptcha not checked.");
            return false;
        } 
        return true;
    }
</script>