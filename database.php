<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "Lava&08sql337";
$dbName = "dbms";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}
?>