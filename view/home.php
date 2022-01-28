<?php

var_dump($rowHouse);
echo "<br><br>";
var_dump($rowsCharacters);
echo "<br><br>";
var_dump($rowResources);
echo "<br><br>";

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
      Profissão: <?php echo $rowsCharacters[$i]['profissao']; ?><br>
      Equipamento: <?php echo $rowsCharacters[$i]['equipamento']; ?>
    </div>
  <?php } 
  /*
  Parei aqui
  - mostrar os botões das ações que posso fazer com o personagem
  - Clicar em uma div que não tem personagem e mostrar botão para compra-lo
  */
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
