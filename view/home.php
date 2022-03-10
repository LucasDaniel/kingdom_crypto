<?php

?>
<body class="background_index">
  <div style="width: 9%;" class="material f-left"><div class="logo f-left"></div></div>
  <div class="material f-left"><img src="../resources/images/madeira.png" width="48" height="48"><?php echo round($rowResources['madeira'],2)."<br>Production: ".$rowSeason['madeira']."x" ?></div>
  <div class="material f-left"><img src="../resources/images/peixe.png" width="48" height="48"><?php echo round($rowResources['peixe'],2)."<br>Production: ".$rowSeason['peixe']."x" ?></div>
  <div class="material f-left"><img src="../resources/images/pedra.png" width="48" height="48"><?php echo round($rowResources['pedra'],2)."<br>Production: ".$rowSeason['pedra']."x" ?></div>
  <div class="material f-left"><img src="../resources/images/aco.png" width="48" height="48"><?php echo round($rowResources['ferro'],2)."<br>Production: ".$rowSeason['ferro']."x" ?></div>
  <div class="material f-left"><img src="../resources/images/medalha.png" width="27" height="48"><?php echo round($rowResources['respeito'],2)."<br>Season ends in: <br>".$rowSeason['season_end'] ?></div>
  <div class="config f-left"> 
    <form action="https://kingrespectcrypto.com/controller/changepassword.php" method="post">
      <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
      <div class="row m-top-12px">
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-block" name="submit">Change Password</button>
        </div>
      </div>
    </form>
  </div>
  <div class="deslogar f-left">
    <form action="https://kingrespectcrypto.com/controller/logout.php" method="post">
      <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
      <div class="row m-top-12px">
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-block" name="submit">Log out</button>
        </div>
      </div>
    </form>
  </div>
  <div class="quartos">
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
      <div class="quarto <?php echo $class; ?>" onclick="quarto('<?php echo $i; ?>')">
        <?php if ($rowsCharacters[$i]['work_at'] != ' --- ') { ?>
          <div class="personagem <?php echo $profissao; ?>"></div>
          <?php if (($rowsCharacters[$i]['work_finish'] >= date("Y-m-d H:i:s"))) /* acabou o trabalho */ { ?>
            <!-- Trabalhando com: < ?php echo $rowsCharacters[$i]['work_at']; ?><br> 
            Finaliza em: < ?php echo ($rowsCharacters[$i]['work_finish']); ?><br>
            Codigo do app: < ?php echo $rowsCharacters[$i]['app_code']; ?><br> -->
          <?php } else { ?>
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
        <div class="quarto quartonovo" onclick="quarto('<?php echo $i+1; ?>')">
          <?php if ($rowHouse['cama'.($i+2)] < 1) { ?>
            Novo quarto
          <?php } else { ?>
            Quarto vazio
          <?php } ?>
        </div>
        <?php } ?>
    <?php } ?>
    <div class="quarto cozinhanv<?php echo $rowHouse['cozinha']; ?>" onclick="cozinha()">
      Cozinha: <?php echo $rowHouse['cozinha']; ?>
    </div>
    <div class="quarto" onclick="popupAction(1)">
      Popup 1
    </div>
    <div class="quarto" onclick="popupAction(2)">
      Popup 2
    </div>
    <div class="quarto armazem" onclick="geral()">
      Imagem de armazem aqui<br>
      Depositar, Retirar, Mensagem de bug
    </div>
  </div>
  
  <div class="tela-acao" id="acao-branco">
    Tela de ação
  </div>
  <?php for($i=0; $i < 10; $i++) { ?>
    <div class="tela-acao display-none" id="acao<?php echo $i; ?>" onclick="quarto('<?php echo $i; ?>')">
      <?php if ($rowHouse['cama'.($i+1)] == 0) { ?>
        Construa um novo quarto
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
          Servo: <?php echo $i; ?><br> 
          Cama: <?php echo $rowHouse['cama'.($i+1)]; ?><br>
          Profissão: <?php echo $rowsCharacters[$i]['profissao']; ?><br>
          Equipamento: <?php echo $rowsCharacters[$i]['equipamento']; ?><br>
          <?php if ($rowsCharacters[$i]['work_init'] != "0000-00-00 00:00:00") { ?>
            Trabalhando com: <?php echo $rowsCharacters[$i]['work_at']; ?><br>
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
              Finaliza em: <?php echo ($rowsCharacters[$i]['work_finish']); ?><br>
              Codigo do app: <?php echo $rowsCharacters[$i]['app_code']; ?><br>
            <?php } ?>
            Multiplicador de ganhos: <?php echo $rowsCharacters[$i]['multiplier']; ?>x
          <?php } else { ?>
            <?php if (($rowsCharacters[$i]['recovery_energy'] >= date("Y-m-d H:i:s"))) /* dormindo... */ { ?>
                Acorda em: <?php echo ($rowsCharacters[$i]['recovery_energy']); ?><br>
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
    Cozinha: <?php echo $rowHouse['cozinha']; ?><br>
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
    Depositar, Retirar, reportar um bug, cadastrar uma carteira
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
  <!-- PAREI AQUI - Adicionar botão para comprar os upgrades do aplicativo -->
</body>

<script>
function quarto(i) {
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
