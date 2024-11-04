<?php
$host = 'localhost';
$dbname = 'kama';
$username = 'root';
$password = '123';

$link = mysqli_connect($host, $username, $password, $dbname);


mysqli_set_charset($link, "utf8");

?>
