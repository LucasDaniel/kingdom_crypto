<?php

require_once("config/imports.php");
require_once("database/connect.php");
require_once("config/verifyhash.php");

?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title><?php echo $GLOBAL['title'] ?></title>
    <meta charset="utf-8">
  </head>
  <?php 
    if (!$expirou) require_once("view/home.php"); 
    else require_once("view/hashexpires.php"); 
  ?>
  <?php require_once("config/importsjs.html"); ?>
</html>