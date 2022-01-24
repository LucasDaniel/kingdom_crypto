
<?php

$GLOBAL['user_recaptcha'] = '6LdZKjIeAAAAALKQ-g4bTbw_ZgZKt7MtgdALyDsd';
$GLOBAL['site_recaptcha'] = '6LdZKjIeAAAAABzVnz-81jwCVzvY8kWHqv8tNs-W';

$DATABASE['localhost'] = 'localhost';
$DATABASE['root'] = 'kingre90_lucasgs';
$DATABASE['password'] = '!Hqiwnvfa1';
$DATABASE['db'] = 'kingre90_bd';

$conn = mysqli_connect($DATABASE['localhost'],$DATABASE['root'],$DATABASE['password'],$DATABASE['db']);

if (!$conn) die("Connection failed: " . mysqli_connect_error());

?>