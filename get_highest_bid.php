<?php
session_start();

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

// Set the response content type to JSON
header('Content-Type: application/json');

// Ensure the auction_id is set in the session
if (isset($_SESSION["auction_id"])) {
    $auction_id = $_SESSION["auction_id"];

    // Prepare the SQL query to get the highest bid for the given auction_id
    $sql = "SELECT MAX(bid_amount) AS highest_bid FROM bids WHERE auction_id = ?";
    $stmt = $mysqli->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $auction_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Fetch the result and send it as a JSON response
        if ($result->num_rows > 0) {
            $bid = $result->fetch_assoc();
            echo json_encode(['highestBid' => $bid['highest_bid']]);
        } else {
            echo json_encode(['error' => 'No bids found for this auction.']);
        }
        
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Failed to prepare SQL statement.']);
    }
} else {
    echo json_encode(['error' => 'Auction ID not set in session.']);
}

// Close the database connection
$mysqli->close();
?>