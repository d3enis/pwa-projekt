<?php

$servername = 'localhost';
$username = 'root';
$password = 'root';
$basename = 'projekt';

$dbc = mysqli_connect($servername, $username, $password, $basename) or die('Error
connecting to MySQL server.'.mysqli_error());
mysqli_set_charset($dbc, 'utf8');

?>
