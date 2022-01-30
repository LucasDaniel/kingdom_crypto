<?php

?>
<body class="background_index">
  <div class="logo f-left">logo</div>
  <div class="material f-left"><?php echo $rowResources['madeira']  ?></div>
  <div class="material f-left"><?php echo $rowResources['peixe']    ?></div>
  <div class="material f-left"><?php echo $rowResources['pedra']    ?></div>
  <div class="material f-left"><?php echo $rowResources['ferro']    ?></div>
  <div class="material f-left"><?php echo $rowResources['respeito'] ?></div>
  <div class="config f-left"></div>
  <div class="deslogar f-left"></div>

  <div class="quartos">
    <?php for($i=0; $i < count($rowsCharacters); $i++) { ?>
      <div class="quarto" onclick="quarto('<?php echo $i; ?>')">
        Servo: <?php echo $i; ?><br> 
        Cama: <?php echo $rowHouse['cama'.($i+1)]; ?><br>
        Profissão: <?php echo $rowsCharacters[$i]['profissao']; ?><br>
        Equipamento: <?php echo $rowsCharacters[$i]['equipamento']; ?>
      </div>
    <?php } ?>
  </div>

  <div class="tela-acao" id="acao-branco">
    Tela de ação
  </div>
  <?php for($i=0; $i < 10; $i++) { ?>
    <div class="tela-acao display-none" id="acao<?php echo $i; ?>" onclick="quarto('<?php echo $i; ?>')">
      Servo: <?php echo $i; ?><br> 
      Cama: <?php echo $rowHouse['cama'.($i+1)]; ?><br>
      Profissão: <?php echo $rowsCharacters[$i]['profissao']; ?><br>
      Equipamento: <?php echo $rowsCharacters[$i]['equipamento']; ?>
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
        <div class="row m-top-12px">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block" name="submit">Equip Upgrade</button>
          </div>
        </div>
      </form>
      <form action="https://kingrespectcrypto.com/controller/cutwood.php" method="post">
        <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
        <input type="hidden" id="e" name="e" value="<?php echo $rowsCharacters[$i]['profissao'] ?>">
        <div class="row m-top-12px">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block" name="submit">Cut Wood</button>
          </div>
        </div>
      </form>
      <form action="https://kingrespectcrypto.com/controller/catchfish.php" method="post">
        <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
        <input type="hidden" id="e" name="e" value="<?php echo $rowsCharacters[$i]['profissao'] ?>">
        <div class="row m-top-12px">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block" name="submit">Catch Fish</button>
          </div>
        </div>
      </form>
      <form action="https://kingrespectcrypto.com/controller/minestoneiron.php" method="post">
        <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
        <input type="hidden" id="e" name="e" value="<?php echo $rowsCharacters[$i]['profissao'] ?>">
        <div class="row m-top-12px">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block" name="submit">Mine stone and iron</button>
          </div>
        </div>
      </form>
      <form action="https://kingrespectcrypto.com/controller/huntmonsters.php" method="post">
        <input type="hidden" id="h" name="h" value="<?php echo $hash ?>">
        <input type="hidden" id="e" name="e" value="<?php echo $rowsCharacters[$i]['profissao'] ?>">
        <div class="row m-top-12px">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block" name="submit">Hunt Monsters</button>
          </div>
        </div>
      </form>
    </div>
  <?php } 
  ?>

</body>

<script>
function quarto(i) {
  document.getElementById("acao-branco").style.display = "none";
  for(j = 0; j < 10; j++) {
    document.getElementById("acao"+j).style.display = "none";
  }
  document.getElementById("acao"+i).style.display = "block";
}
</script>
