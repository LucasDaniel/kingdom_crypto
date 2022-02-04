<?php

require_once("config/imports.php");
require_once("database/connect.php");

?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title><?php echo $GLOBAL['title'] ?></title>
    <meta charset="utf-8">
  </head>
  <?php require_once("view/reportarbug.php"); ?>
  <?php require_once("config/importsjs.html"); ?>
</html>