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

$result = $mysqli->query("SELECT u.username, b.bid_amount, b.timestamp FROM bid b JOIN user u ON b.user_id = u.user_id WHERE b.auction_id = $auction_id ORDER BY b.timestamp DESC LIMIT 10");
$bids = [];
while ($row = $result->fetch_assoc()) {
    $bids[] = $row;
}
echo json_encode($bids);

$mysqli->close();
?>