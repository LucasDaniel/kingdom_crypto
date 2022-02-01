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
        Equipamento: <?php echo $rowsCharacters[$i]['equipamento']; ?><br>
        <?php if ($rowsCharacters[$i]['work_at'] != ' --- ') { ?>
          Trabalhando com: <?php echo $rowsCharacters[$i]['work_at']; ?><br>
          <?php if (($rowsCharacters[$i]['work_finish'] >= date("Y-m-d H:i:s"))) /* acabou o trabalho */ { ?>
            Finaliza em: <?php echo ($rowsCharacters[$i]['work_finish']); ?><br>
            Codigo do app: <?php echo $rowsCharacters[$i]['app_code']; ?><br>
          <?php } ?>
          Multiplicador de ganhos: <?php echo $rowsCharacters[$i]['multiplier']; ?>x
        <?php } else { ?>
          <?php if (($rowsCharacters[$i]['recovery_energy'] >= date("Y-m-d H:i:s"))) /* Dormindo... */ { ?>
            Acorda em: <?php echo ($rowsCharacters[$i]['recovery_energy']); ?><br>
          <?php } ?>
        <?php } ?>
      </div>
      <?php if ($i+1 == count($rowsCharacters) && $i+1 < 10) { ?> 
        <div class="quarto" onclick="quarto('<?php echo $i+1; ?>','a')">
          <?php if ($rowHouse['cama'.($i+1)] < 1) { ?>
            Novo quarto
          <?php } else { ?>
            Quarto vazio
          <?php } ?>
        </div>
        <?php } ?>
    <?php } ?>
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
        <?php 
        /*
          <?php if ($rowHouse['cama'.($i+1)] < 1) { ?>
            Novo quarto
          <?php } else { ?>
            Quarto vazio
          <?php } ?>
          parei aqui - Verifica se a quantidade de personagens já passou, se sim, mostra o botão de contratar um novo servo
        */
        ?>
        <!-- Coloca aqui para mostrar o novo botão de contratar novo servo -->
        <?php // } else { ?>
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
            <?php } else { // parei aqui - retirando os botões quando o servo estiver descansando ?>
              Finaliza em: <?php echo ($rowsCharacters[$i]['work_finish']); ?><br>
              Codigo do app: <?php echo $rowsCharacters[$i]['app_code']; ?><br>
            <?php } ?>
            Multiplicador de ganhos: <?php echo $rowsCharacters[$i]['multiplier']; ?>x
          <?php } else { //parei aqui - mostrar quarto vazio, colocar pra comprar novo servo ?>
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
        <?php //} fim do if de contratar um novo servo ?>
      <?php } ?>
    </div>
  <?php } 
  ?>

</body>

<script>
function quarto(i,a = '') {
  document.getElementById("acao-branco").style.display = "none";
  for(j = 0; j < 10; j++) {
    document.getElementById("acao"+j).style.display = "none";
  }
  document.getElementById("acao"+i).style.display = "block";
}
</script>
