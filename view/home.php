<?php

var_dump($rowHouse);
echo "<br><br>";
var_dump($rowsCharacters);
echo "<br><br>";
var_dump($rowResources);
echo "<br><br>";

//Parei aqui, fazer mostrar os dados dos personagens em divs
//mostrar a tela de ação, do que fazer com os personagens
//ao clicar em um personagem mostrar as ações disponiveis

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
</body>
