<?php

require_once("config/imports.php");
require_once("database/connect.php");

//Vai verificar se enviou um hash
//Vai no login que tem esse hash e apaga seu hash
if (($_POST['h'] == '' || $_POST['h'] == null)) {
  $hash = $_POST['h'];
  $query = "UPDATE user SET hash='' WHERE hash LIKE '$hash'";
  mysqli_query($conn, $query);
}

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