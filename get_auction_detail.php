<?php
$hostname = "localhost";
$username = "root";
$password = "Lava&08sql337";
$database = "dbms";

$mysqli = new mysqli($hostname, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

header('Content-Type: application/json');

$auction_id = $_GET['auction_id'];

$sql = "SELECT start_date, end_date FROM auction WHERE auction_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $auction_id);
$stmt->execute();
$result = $stmt->get_result();
$auction = $result->fetch_assoc();

echo json_encode($auction);

$stmt->close();
$mysqli->close();
?>