<?php
header('Content-Type: text/html; charset=utf-8');
$servername = "localhost";
$username = "root";
$password = "";
$basename = "projekt_pwa";

$dbc = mysqli_connect($servername, $username, $password, $basename) or die('Greška: ' . mysqli_connect_error());
mysqli_set_charset($dbc, "utf8");

?>