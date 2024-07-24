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

// Ensure the necessary session variables are set
if (isset($_SESSION["auction_id"]) && isset($_SESSION["p_id"])) {
    $auction_id = $_SESSION["auction_id"];
    $p_id = $_SESSION["p_id"];

    // Fetch product details
    $product_query = $mysqli->prepare("SELECT p.p_name, p.p_desc, p.p_image, p.p_price,u.full_name AS seller_name FROM product p JOIN user u ON p.user_id = u.user_id WHERE p.p_id = ?");
    if ($product_query) {
        $product_query->bind_param("i", $p_id);
        $product_query->execute();
        $product_result = $product_query->get_result();
        $product = $product_result->fetch_assoc();
        $product_query->close();
    } else {
        echo json_encode(['error' => 'Failed to prepare product query.']);
        $mysqli->close();
        exit;
    }

    // Fetch bids
    $bid_query = $mysqli->prepare("SELECT u.full_name, b.bid_amount, b.time_stamp FROM bids b JOIN user u ON b.user_id = u.user_id WHERE b.auction_id = ? ORDER BY b.time_stamp DESC");
    if ($bid_query) {
        $bid_query->bind_param("i", $auction_id);
        $bid_query->execute();
        $bid_result = $bid_query->get_result();
        $bids = [];
        while ($row = $bid_result->fetch_assoc()) {
            $bids[] = $row;
        }
        $bid_query->close();
    } else {
        echo json_encode(['error' => 'Failed to prepare bid query.']);
        $mysqli->close();
        exit;
    }
    // Output the JSON response
    echo json_encode(['product' => $product, 'bids' => $bids]);
} else {
    echo json_encode(['error' => 'Required session variables not set.']);
}

// Close the database connection
$mysqli->close();
?>
