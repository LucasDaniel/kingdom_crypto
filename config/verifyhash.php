
<?php

$hash = $_POST['h'];

/*
Buscar no banco o hash correspondido
se não achar, leva para a pagina de erro falando que a sessão expirou
se achar, verifica se o tempo que esse hash foi criado passou 15 minutos
se passou, vai levar pra pagina de erro falando que a sessão expirou
se não passou, cria um novo hash e salva na variavel

Parei aqui
*/

echo "Verificando hash<br><br>";

die("hash: ".$hash);

?>