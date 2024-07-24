<?php
session_start();

if (!isset($_GET["auction_id"]) || !isset($_SESSION["user_id"])) {
    echo json_encode(['error' => 'Required parameters are not set.']);
    exit;
}

$auction_id = $_GET['auction_id'];
$user_id = $_SESSION['user_id'];

// Database connection parameters
$hostname = "localhost";
$username = "root";
$password = "Lava&08sql337";
$database = "dbms";

// Create a new mysqli connection
$mysqli = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch the winner of the auction
$winner_query = $mysqli->prepare("SELECT u.full_name AS winner_name, b.bid_amount AS highest_bid_amount FROM bids b JOIN user u ON b.user_id = u.user_id WHERE b.auction_id = ? AND b.bid_amount = (SELECT MAX(bid_amount) FROM bids WHERE auction_id = ?)");
if ($winner_query) {
    $winner_query->bind_param("ii", $auction_id, $auction_id);
    $winner_query->execute();
    $winner_result = $winner_query->get_result();
    if ($winner_result->num_rows > 0) {
        $winner = $winner_result->fetch_assoc();
        echo json_encode(['winner_name' => $winner['winner_name'], 'highest_bid_amount' => $winner['highest_bid_amount']]);
    } else {
        echo json_encode(['error' => 'No winner found.']);
    }
    $winner_query->close();
} else {
    echo json_encode(['error' => 'Failed to prepare winner query: ' . $mysqli->error]);
}

// Update the max_price in the auction table with the highest bid amount
$update_query = $mysqli->prepare("UPDATE auction SET max_price = (SELECT MAX(bid_amount) FROM bids WHERE auction_id = ?) WHERE auction_id = ?");
if ($update_query) {
    $update_query->bind_param("ii", $auction_id, $auction_id);
    $update_query->execute();
    $update_query->close();
} else {
    echo json_encode(['error' => 'Failed to update max_price: ' . $mysqli->error]);
}

// Close the database connection
$mysqli->close();
?>
