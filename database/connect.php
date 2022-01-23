
<?php

$DATABASE['localhost'] = 'localhost';
$DATABASE['root'] = 'root';
$DATABASE['password'] = '';
$DATABASE['db'] = 'kingdom_crypto';

$conn = mysqli_connect($DATABASE['localhost'],$DATABASE['root'],$DATABASE['password'],$DATABASE['db']);

if (!$conn) die("Connection failed: " . mysqli_connect_error());

?>