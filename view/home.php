<?php

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
  <div class="quartos">
    <div class="quarto cozinhanv<?php echo $rowHouse['cozinha']; ?>" onclick="cozinha()">
      <!-- Kitchen: < ?php echo $rowHouse['cozinha']; ?> -->
    </div>
    <div class="quarto armazem" onclick="geral()">
      <!-- Imagem de armazem aqui<br>
      Depositar, Retirar, Mensagem de bug -->
    </div>
    <div class="quarto adv1" onclick="popupAction(1)">
      <!-- Popup 1 -->
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
        // quartonv<?php echo $rowHouse['cama'.($i+1)]; ? >
      ?>
      <?php if ($i == 4) { ?>
        <div class="quarto adv3" onclick="popupAction(3)">
          <!-- Popup 3 -->
        </div>
      <?php } ?>
      <div class="quarto <?php echo $class; ?>" onclick="quarto('<?php echo $i; ?>')">
        <?php if ($rowsCharacters[$i]['work_at'] != ' --- ') { ?>
          <?php if (($rowsCharacters[$i]['work_finish'] >= date("Y-m-d H:i:s"))) /* acabou o trabalho */ { ?>
            <div class="personagem <?php echo $profissao; ?>"></div>
            <!-- Trabalhando com: < ?php echo $rowsCharacters[$i]['work_at']; ?><br> 
            Finaliza em: < ?php echo ($rowsCharacters[$i]['work_finish']); ?><br>
            Codigo do app: < ?php echo $rowsCharacters[$i]['app_code']; ?><br> -->
          <?php } else { ?>
            <div class="personagem <?php echo $profissao."dormindotrabalhando"; ?>"></div>
            <!-- Work finished.<br> -->
          <?php } ?>
            <!-- Multiplicador de ganhos: < ?php echo $rowsCharacters[$i]['multiplier']; ?>x -->
        <?php } else { ?>
          <?php if (($rowsCharacters[$i]['recovery_energy'] >= date("Y-m-d H:i:s"))) /* Dormindo... */ { ?>
            <div class="personagem <?php echo $rowsCharacters[$i]['profissao']."dormindo"; ?>"></div>
            <!-- Acorda em: < ?php echo ($rowsCharacters[$i]['recovery_energy']); ?><br> -->
          <?php } else { ?>
            <div class="personagem <?php echo $rowsCharacters[$i]['profissao']; ?>"></div>
          <?php } ?>
        <?php } ?>
      </div>
      <?php if ($i+1 == count($rowsCharacters) && $i+1 < 10) { ?> 
          <?php if ($rowHouse['cama'.($i+2)] < 1) { ?>
            <div class="quarto quartonovo" onclick="quarto('<?php echo $i+1; ?>')">
            <!-- Novo quarto -->
          <?php } else { ?>
            <div class="quarto quartonv1" onclick="quarto('<?php echo $i+1; ?>')">
            <!--Quarto vazio -->
          <?php } ?>
        </div>
        <?php } ?>
    <?php } ?>
    <div class="quarto adv2" onclick="popupAction(2)">
      <!-- Popup 2 -->
    </div>
  </div>
  <div class="tela-acao" id="acao-branco">
    <!-- Tela de ação -->
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
      <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
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
</script>
