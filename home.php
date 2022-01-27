<?php

require_once("config/verifyhash.php");
require_once("config/imports.php");
require_once("database/connect.php");

?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title><?php echo $GLOBAL['title'] ?></title>
    <meta charset="utf-8">
  </head>
  <?php require_once("view/home.php"); ?>
  <?php require_once("config/importsjs.html"); ?>
</html>