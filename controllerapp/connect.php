
<?php

$DATABASE['localhost'] = 'localhost';
$DATABASE['root'] = 'kingre90_lucasgs';
$DATABASE['password'] = '!Hqiwnvfa1';
$DATABASE['db'] = 'kingre90_bd';

$conn = mysqli_connect($DATABASE['localhost'],$DATABASE['root'],$DATABASE['password'],$DATABASE['db']);

if (!$conn) die("Connection failed: " . mysqli_connect_error());

?>