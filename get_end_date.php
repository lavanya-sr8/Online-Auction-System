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

// Ensure the necessary session variable is set
if (isset($_SESSION["auction_id"])) {
    $auction_id = $_SESSION["auction_id"];

    // Fetch the end_date from the auction table
    $end_date_query = $mysqli->prepare("SELECT end_date FROM auction WHERE auction_id = ?");
    if ($end_date_query) {
        $end_date_query->bind_param("i", $auction_id);
        $end_date_query->execute();
        $end_date_result = $end_date_query->get_result();
        if ($end_date_result->num_rows > 0) {
            $end_date_row = $end_date_result->fetch_assoc();
            $end_date = $end_date_row['end_date'];
        } else {
            echo json_encode(['error' => 'End date not found for the specified auction ID.']);
            $mysqli->close();
            exit;
        }
        $end_date_query->close();
    } else {
        echo json_encode(['error' => 'Failed to prepare end date query: ' . $mysqli->error]);
        $mysqli->close();
        exit;
    }

    // Output the JSON response
    echo json_encode(['end_date' => $end_date]);
} else {
    echo json_encode(['error' => 'Required session variable "auction_id" not set.']);
}

// Close the database connection
$mysqli->close();
?>
