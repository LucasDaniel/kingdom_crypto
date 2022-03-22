<?php
  $url = $_SERVER["REQUEST_URI"];
  $recursos = "".round($rowResources['madeira'],2)." - ".round($rowResources['peixe'],2)." - ".round($rowResources['pedra'],2)." - ".round($rowResources['ferro'],2)." - ".round($rowResources['respeito'],2)."";
  $query = "INSERT INTO log(id_user,msg,url) VALUES ($id,'$recursos','$url')";
  mysqli_query($conn, $query);
?>
<body class="background_index">
  <div style="width: 9%;" class="material f-left"><div class="logo f-left"></div></div>
  <div class="material f-left"><img src="../resources/images/madeira.png" width="48" height="48"><?php echo round($rowResources['madeira'],2)."<br>Production: ".$rowSeason['madeira']."x" ?></div>
  <div class="material f-left"><img src="../resources/images/peixe.png" width="48" height="48"><?php echo round($rowResources['peixe'],2)."<br>Production: ".$rowSeason['peixe']."x" ?></div>
  <div class="material f-left"><img src="../resources/images/pedra.png" width="48" height="48"><?php echo round($rowResources['pedra'],2)."<br>Production: ".$rowSeason['pedra']."x" ?></div>
  <div class="material f-left"><img src="../resources/images/aco.png" width="48" height="48"><?php echo round($rowResources['ferro'],2)."<br>Production: ".$rowSeason['ferro']."x" ?></div>
  <div class="material f-left"><img src="../resources/images/medalha.png" width="27" height="48"><?php echo round($rowResources['respeito'],2)."<br>Change: ".$rowSeason['season_end'] ?></div>
  <div class="config f-left"> 
    <form action="https://kingrespectcrypto.com/controller/changepassword.php" method="post">
      <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
      <div class="row m-top-9px">
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-block" name="submit">Change Password</button>
        </div>
      </div>
    </form>
  </div>
  <div class="deslogar f-left">
    <form action="https://kingrespectcrypto.com/controller/logout.php" method="post">
      <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
      <div class="row m-top-9px">
        <div class="col-12">
          <button type="submit" class="log-out-height btn btn-primary btn-block" name="submit">Log out</button>
        </div>
      </div>
    </form>
  </div>
  <div class="menu_app_aviso">
    <div id="msgMetamask">Loading metamask...</div>
  </div>
  <div class="quartos">
    <div class="quarto cozinhanv<?php echo $rowHouse['cozinha']; ?>" onclick="cozinha()">
    </div>
    <div class="quarto armazem" onclick="geral()">
    </div>
    <div class="quarto adv1" onclick="popupAction(1)">
    </div>
    <?php for($i=0; $i < count($rowsCharacters); $i++) { ?>
      <?php 

        if ($rowsCharacters[$i]['profissao'] != 'pescador') {
          $profissao = $rowsCharacters[$i]['profissao'];
        }

        if ($rowsCharacters[$i]['work_at'] == 'Woodcutter... ') {  
          $class = "cortarmadeira";
        } else if ($rowsCharacters[$i]['work_at'] == 'Fishing... ') {  
          $class = "pescar";
          if ($rowsCharacters[$i]['profissao'] == 'pescador') {
            $profissao = "pescadorpescando";
          }
        } else if ($rowsCharacters[$i]['work_at'] == 'Mining... ') {  
          $class = "mineirar";
        } else if ($rowsCharacters[$i]['work_at'] == 'Hunting... ') {  
          $class = "cacarmonstros";
        } else {
          $class = "quartonv".$rowHouse['cama'.($i+1)];
        }
      ?>
      <?php if ($i == 4) { ?>
        <div class="quarto adv3" onclick="popupAction(3)">
        </div>
      <?php } ?>
      <div class="quarto <?php echo $class; ?>" onclick="quarto('<?php echo $i; ?>')">
        <?php if ($rowsCharacters[$i]['work_at'] != ' --- ') { ?>
          <?php if (($rowsCharacters[$i]['work_finish'] >= date("Y-m-d H:i:s"))) /* acabou o trabalho */ { ?>
            <div class="personagem <?php echo $profissao; ?>"></div>
          <?php } else { ?>
            <div class="personagem <?php echo $profissao."dormindotrabalhando"; ?>"></div>
          <?php } ?>
        <?php } else { ?>
          <?php if (($rowsCharacters[$i]['recovery_energy'] >= date("Y-m-d H:i:s"))) /* Dormindo... */ { ?>
            <div class="personagem <?php echo $rowsCharacters[$i]['profissao']."dormindo"; ?>"></div>
          <?php } else { ?>
            <div class="personagem <?php echo $rowsCharacters[$i]['profissao']; ?>"></div>
          <?php } ?>
        <?php } ?>
      </div>
      <?php if ($i+1 == count($rowsCharacters) && $i+1 < 10) { ?> 
          <?php if ($rowHouse['cama'.($i+2)] < 1) { ?>
            <div class="quarto quartonovo" onclick="quarto('<?php echo $i+1; ?>')">
          <?php } else { ?>
            <div class="quarto quartonv1" onclick="quarto('<?php echo $i+1; ?>')">
          <?php } ?>
        </div>
        <?php } ?>
    <?php } ?>
    <div class="quarto adv2" onclick="popupAction(2)">
    </div>
  </div>
  <div class="tela-acao" id="acao-branco">
  </div>
  <?php for($i=0; $i < 10; $i++) { ?>
    <div class="tela-acao display-none" id="acao<?php echo $i; ?>" onclick="quarto('<?php echo $i; ?>')">
      <?php if ($rowHouse['cama'.($i+1)] == 0) { ?>
        Build new room
        <form action="https://kingrespectcrypto.com/controller/opennewbed.php" method="post">
          <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
          <div class="row m-top-12px">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block" name="submit">Build new room</button>
            </div>
          </div>
        </form>
      <?php } else { ?>
        <?php if ($rowHouse['cama'.($i+1)] > 0 && count($rowsCharacters) < ($i+1)) { ?>
          Empty room
          <form action="https://kingrespectcrypto.com/controller/contractnewservant.php" method="post">
            <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
            <div class="row m-top-12px">
              <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block" name="submit">Contract new servant</button>
              </div>
            </div>
          </form>
        <?php } else { ?>
          <?php 
            if ($rowsCharacters[$i]['profissao'] == 'lenhador') $profissaoEng = 'Lumberjack';
            else if ($rowsCharacters[$i]['profissao'] == 'pescador') $profissaoEng = 'Fisherman';
            else if ($rowsCharacters[$i]['profissao'] == 'minerador') $profissaoEng = 'Miner';
            else $profissaoEng = 'Hunter';  
          ?>
          Servant: <?php echo $i; ?><br> 
          Room: <?php echo $rowHouse['cama'.($i+1)]; ?><br>
          Profession: <?php echo $profissaoEng; ?><br>
          Equipment: <?php echo $rowsCharacters[$i]['equipamento']; ?><br>
          <?php if ($rowsCharacters[$i]['work_init'] != "0000-00-00 00:00:00") { ?>
            Working with: <?php echo $rowsCharacters[$i]['work_at']; ?><br>
            <?php if (($rowsCharacters[$i]['work_finish'] < date("Y-m-d H:i:s"))) /* acabou o trabalho */ { ?>
              <form action="https://kingrespectcrypto.com/controller/finishwork.php" method="post">
                <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                <input type="hidden" id="c" name="c" value="<?php echo 'cama'.($i+1) ?>">
                <input type="hidden" id="ie" name="ie" value="<?php echo $rowsCharacters[$i]['id'] ?>">
                <div class="row m-top-12px">
                  <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block" name="submit">Finish work</button>
                  </div>
                </div>
              </form>
            <?php } else { ?>
              Finish work at: <?php echo ($rowsCharacters[$i]['work_finish']); ?>
            <?php } ?>
            Multiplier: <?php echo $rowsCharacters[$i]['multiplier']; ?>x
          <?php } else { ?>
            <?php if (($rowsCharacters[$i]['recovery_energy'] >= date("Y-m-d H:i:s"))) /* dormindo... */ { ?>
                Wake up at: <?php echo ($rowsCharacters[$i]['recovery_energy']); ?><br>
              <?php } else { ?>
                <?php if ($rowHouse['cama'.($i+1)] < 10) { ?>
                  <form action="https://kingrespectcrypto.com/controller/upgradecama.php" method="post">
                    <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                    <input type="hidden" id="c" name="c" value="<?php echo 'cama'.($i+1) ?>">
                    <div class="row m-top-12px">
                      <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block" name="submit">Bed Upgrade</button>
                      </div>
                    </div>
                  </form>
                <?php } else { ?>
                  <div class="row m-top-12px">
                    <div class="col-12">
                      <button type="submit" class="btn btn-primary btn-disabled" disabled>Bed MAX level</button>
                    </div>
                  </div>
                <?php } ?>
                  <form action="https://kingrespectcrypto.com/controller/upgradeequip.php" method="post">
                    <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                    <input type="hidden" id="e" name="e" value="<?php echo $rowsCharacters[$i]['equipamento'] ?>">
                    <input type="hidden" id="ie" name="ie" value="<?php echo $rowsCharacters[$i]['id'] ?>">
                    <div class="row m-top-12px">
                      <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block" name="submit">Equip Upgrade</button>
                      </div>
                    </div>
                  </form>
                  <form action="https://kingrespectcrypto.com/controller/workwood.php" method="post">
                    <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                    <input type="hidden" id="ie" name="ie" value="<?php echo $rowsCharacters[$i]['id'] ?>">
                    <div class="row m-top-12px">
                      <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block" name="submit">Cut Wood</button>
                      </div>
                    </div>
                  </form>
                  <form action="https://kingrespectcrypto.com/controller/catchfish.php" method="post">
                    <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                    <input type="hidden" id="ie" name="ie" value="<?php echo $rowsCharacters[$i]['id'] ?>">
                    <div class="row m-top-12px">
                      <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block" name="submit">Catch Fish</button>
                      </div>
                    </div>
                  </form>
                  <form action="https://kingrespectcrypto.com/controller/minestoneiron.php" method="post">
                    <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                    <input type="hidden" id="ie" name="ie" value="<?php echo $rowsCharacters[$i]['id'] ?>">
                    <div class="row m-top-12px">
                      <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block" name="submit">Mine stone and iron</button>
                      </div>
                    </div>
                  </form>
                  <form action="https://kingrespectcrypto.com/controller/huntmonsters.php" method="post">
                    <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
                    <input type="hidden" id="ie" name="ie" value="<?php echo $rowsCharacters[$i]['id'] ?>">
                    <div class="row m-top-12px">
                      <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block" name="submit">Hunt Monsters</button>
                      </div>
                    </div>
                  </form>
              <?php } ?>
          <?php } ?>
        <?php } ?>
      <?php } ?>
    </div>
  <?php } ?>
  <div class="tela-acao display-none" id="cozinha" onclick="cozinha()">
    Kitchen: <?php echo $rowHouse['cozinha']; ?><br>
    <form action="https://kingrespectcrypto.com/controller/upgradecozinha.php" method="post">
      <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
      <div class="row m-top-12px">
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-block" name="submit">Upgrade Kitchen</button>
        </div>
      </div>
    </form>
  </div>
  <div class="tela-acao display-none" id="geral" onclick="geral()">
    General actions
    <form action="https://kingrespectcrypto.com/controller/woodtorespect.php" method="post">
      <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
      <div class="row m-top-12px">
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-block" name="submit">Convert Wood to Respect</button>
        </div>
      </div>
    </form>
    <form action="https://kingrespectcrypto.com/controller/fishtorespect.php" method="post">
      <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
      <div class="row m-top-12px">
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-block" name="submit">Convert Fish to Respect</button>
        </div>
      </div>
    </form>
    <form action="https://kingrespectcrypto.com/controller/stonetorespect.php" method="post">
      <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
      <div class="row m-top-12px">
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-block" name="submit">Convert Stone to Respect</button>
        </div>
      </div>
    </form>
    <form action="https://kingrespectcrypto.com/controller/irontorespect.php" method="post">
      <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
      <div class="row m-top-12px">
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-block" name="submit">Convert Iron to Respect</button>
        </div>
      </div>
    </form>
    <!--
    <form action="https://kingrespectcrypto.com/controller/cadastrarmetamask.php" method="post">
      <input type="hidden" id="h" name="h" value="< ?php echo $hash ?>">
      <div class="row m-top-12px">
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-block" name="submit">Register Metamask Wallet</button>
        </div>
      </div>
    </form>
    -->
    <form action="https://kingrespectcrypto.com/controller/appupgrade.php" method="post">
      <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
      <div class="row m-top-12px">
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-block" name="submit">Upgrade App</button>
        </div>
      </div>
    </form>
    <form action="https://kingrespectcrypto.com/controller/deposit.php" method="post">
      <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
      <div class="row m-top-12px">
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-block" name="submit">Deposit</button>
        </div>
      </div>
    </form>
    <form action="https://kingrespectcrypto.com/controller/withdraw.php" method="post">
      <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
      <div class="row m-top-12px">
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-block" name="submit">Withdraw</button>
        </div>
      </div>
    </form>
    <form action="https://kingrespectcrypto.com/reportarbug.php" method="post">
      <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
      <div class="row m-top-12px">
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-block" name="submit">Bug Report</button>
        </div>
      </div>
    </form>
  </div>
  <div class="tutorial back_tutorial0" id="back_tutorial">
    <div class="bt_tutorial" id="finish">
      <button type="submit" class="btn btn-primary btn-block" name="submit" id="bt_finish" onclick="finish()">Finish Tutorial</button>
    </div>
    <div class="bt_tutorial" id="next">
      <button type="submit" class="btn btn-primary btn-block" name="submit" id="bt_next" onclick="next()">Next Tutorial</button>
    </div>
  </div>
  <div class="tutorial_click1" id="back_tutorial1">
  </div>
  <div class="tutorial_click2" id="back_tutorial2">
  </div>
</body>

<script>
  var tutorial = 0;

  var tutorialNv = <?php echo $tutorial; ?>;
  if (tutorialNv == 1) {
    removeTutorialPrincipal();
  }

  function removeTutorialPrincipal() {
    document.getElementById("back_tutorial").classList.remove("back_tutorial0");
    document.getElementById("back_tutorial").classList.remove("back_tutorial4");
    document.getElementById("back_tutorial").classList.remove("tutorial");
    document.getElementById("next").style.display = "none";
    document.getElementById("finish").style.display = "none";
    document.getElementById("bt_next").style.display = "none";
    document.getElementById("bt_finish").style.display = "none";
  }

  function next() {
    tutorial++;
    if (tutorial == 1) {
      document.getElementById("back_tutorial").classList.remove("back_tutorial0");
      document.getElementById("back_tutorial").classList.add("back_tutorial1");
    } else if (tutorial == 2) {
      document.getElementById("back_tutorial").classList.remove("back_tutorial1");
      document.getElementById("back_tutorial").classList.add("back_tutorial1_5");
    } else if (tutorial == 3) {
      document.getElementById("back_tutorial").classList.remove("back_tutorial1_5");
      document.getElementById("back_tutorial").classList.add("back_tutorial2");
    } else if (tutorial == 4) {
      document.getElementById("back_tutorial").classList.remove("back_tutorial2");
      document.getElementById("back_tutorial").classList.add("back_tutorial3");
    } else if (tutorial == 5) {
      document.getElementById("back_tutorial").classList.remove("back_tutorial3");
      document.getElementById("back_tutorial").classList.add("back_tutorial4");
    }
    if (tutorial == 5) {
      document.getElementById("next").style.display = "none";
      document.getElementById("finish").style.display = "block";
      document.getElementById("bt_next").style.display = "none";
      document.getElementById("bt_finish").style.display = "block";
    }
  }
  function finish() {
    removeTutorialPrincipal();
    document.getElementById("back_tutorial1").style.display = "block";
  }
  function quarto(i) {
    if (tutorial == 5 && i == 0) {
      document.getElementById("back_tutorial1").style.display = "none";
      document.getElementById("back_tutorial2").style.display = "block";
    }
    document.getElementById("acao-branco").style.display = "none";
    document.getElementById("cozinha").style.display = "none";
    document.getElementById("geral").style.display = "none";
    for(j = 0; j < 10; j++) {
      document.getElementById("acao"+j).style.display = "none";
    }
    document.getElementById("acao"+i).style.display = "block";
  }
  function cozinha() {
    document.getElementById("acao-branco").style.display = "none";
    document.getElementById("geral").style.display = "none";
    for(j = 0; j < 10; j++) {
      document.getElementById("acao"+j).style.display = "none";
    }
    document.getElementById("cozinha").style.display = "block";
  }
  function popupAction(i) {
    alert("popupaction "+i);
  }
  function geral() {
    document.getElementById("acao-branco").style.display = "none";
    document.getElementById("cozinha").style.display = "none";
    for(j = 0; j < 10; j++) {
      document.getElementById("acao"+j).style.display = "none";
    }
    document.getElementById("geral").style.display = "block";
  }

  const provider = new ethers.providers.Web3Provider(window.ethereum);
  var signer = null;
  var dogezilla = "0x7A565284572d03EC50c35396F7d6001252eb43B6";
  var contractABI = [{"inputs":[],"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"owner","type":"address"},{"indexed":true,"internalType":"address","name":"spender","type":"address"},{"indexed":false,"internalType":"uint256","name":"value","type":"uint256"}],"name":"Approval","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"internalType":"uint256","name":"minTokensBeforeSwap","type":"uint256"}],"name":"MinTokensBeforeSwapUpdated","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"previousOwner","type":"address"},{"indexed":true,"internalType":"address","name":"newOwner","type":"address"}],"name":"OwnershipTransferred","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"internalType":"uint256","name":"tokensSwapped","type":"uint256"},{"indexed":false,"internalType":"uint256","name":"ethReceived","type":"uint256"},{"indexed":false,"internalType":"uint256","name":"tokensIntoLiqudity","type":"uint256"}],"name":"SwapAndLiquify","type":"event"},{"anonymous":false,"inputs":[{"indexed":false,"internalType":"bool","name":"enabled","type":"bool"}],"name":"SwapAndLiquifyEnabledUpdated","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"from","type":"address"},{"indexed":true,"internalType":"address","name":"to","type":"address"},{"indexed":false,"internalType":"uint256","name":"value","type":"uint256"}],"name":"Transfer","type":"event"},{"inputs":[],"name":"_liquidityFee","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"_maxTxAmount","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"_taxFee","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"owner","type":"address"},{"internalType":"address","name":"spender","type":"address"}],"name":"allowance","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"approve","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"account","type":"address"}],"name":"balanceOf","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"decimals","outputs":[{"internalType":"uint8","name":"","type":"uint8"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"subtractedValue","type":"uint256"}],"name":"decreaseAllowance","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"uint256","name":"tAmount","type":"uint256"}],"name":"deliver","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"account","type":"address"}],"name":"excludeFromFee","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"account","type":"address"}],"name":"excludeFromReward","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[],"name":"geUnlockTime","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"account","type":"address"}],"name":"includeInFee","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"account","type":"address"}],"name":"includeInReward","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"addedValue","type":"uint256"}],"name":"increaseAllowance","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"account","type":"address"}],"name":"isExcludedFromFee","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"account","type":"address"}],"name":"isExcludedFromReward","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"uint256","name":"time","type":"uint256"}],"name":"lock","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[],"name":"name","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"owner","outputs":[{"internalType":"address","name":"","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"uint256","name":"tAmount","type":"uint256"},{"internalType":"bool","name":"deductTransferFee","type":"bool"}],"name":"reflectionFromToken","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"renounceOwnership","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"uint256","name":"liquidityFee","type":"uint256"}],"name":"setLiquidityFeePercent","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"uint256","name":"maxTxPercent","type":"uint256"}],"name":"setMaxTxPercent","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"bool","name":"_enabled","type":"bool"}],"name":"setSwapAndLiquifyEnabled","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"uint256","name":"taxFee","type":"uint256"}],"name":"setTaxFeePercent","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[],"name":"swapAndLiquifyEnabled","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"symbol","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"uint256","name":"rAmount","type":"uint256"}],"name":"tokenFromReflection","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"totalFees","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"totalSupply","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"recipient","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"transfer","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"sender","type":"address"},{"internalType":"address","name":"recipient","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"transferFrom","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"newOwner","type":"address"}],"name":"transferOwnership","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[],"name":"uniswapV2Pair","outputs":[{"internalType":"address","name":"","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"uniswapV2Router","outputs":[{"internalType":"contract IUniswapV2Router02","name":"","type":"address"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"unlock","outputs":[],"stateMutability":"nonpayable","type":"function"},{"stateMutability":"payable","type":"receive"}];
  var accounts = getAccount(); //Manter esse botão para a versão beta

  async function getAccount() {
      accounts = await provider.send("eth_requestAccounts", []);
      setTimeout(() => {
        mostraConta()
      }, 2000);
  
  }

  function mostraConta() {
    document.getElementById("msgMetamask").innerHTML = "Metamask: "+accounts[0]+" Loading amount Dogezilla...";
    daiContract = new ethers.Contract(dogezilla, contractABI, provider);
    balance = daiBalance();
    balance.then((result) => {
        var hex = result._hex;
        var valor = parseInt(hex, 16).toString();
        var quant = (valor.split('e+')[0]).replace('.','').length;
        var valor = (valor.split('e+')[0]).replace('.','');
        mostraDogezilla(valor,quant);
    }).catch((error) => {
        console.log(error);
    });

  }

  function mostraDogezilla(valor,quant) {
    document.getElementById("msgMetamask").innerHTML = "Metamask: "+accounts[0]+" - Dogezilla: "+valor;
    console.log(valor);
    console.log(quant);
  }

  async function daiName() {
        await daiContract.name()
    }

    async function daiSymbol() {
        await daiContract.symbol()
    }

    async function daiBalance() {
        return await daiContract.balanceOf(accounts[0]);
    }

    async function get_blockNumber() {
        return await provider.getBlockNumber();
    }

    async function getSigners() {
        return await provider.getSigners();
    }

    async function getBalance() {
        return await provider.getBalance(dogezilla);
    }
</script>
