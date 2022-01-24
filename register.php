<?php

require_once("config/imports.php");
require_once("database/connect.php");

//parei aqui - Fazendo o register.php

?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title><?php echo $GLOBAL['title'] ?></title>
    <meta charset="utf-8">
  </head>
  <?php require_once("view/login.php"); ?>
  <?php require_once("config/importsjs.html"); ?>
</html>