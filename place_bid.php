<?php
session_start();

// Check if required parameters are set
if (!isset($_GET["auction_id"]) || !isset($_POST["bidAmount"]) || !isset($_GET["p_id"]) || !isset($_SESSION["user_id"])) {
    echo json_encode(['error' => 'Required parameters are not set.']);
    exit;
}

// Retrieve parameters
$auction_id = $_GET['auction_id'];
$user_id = $_SESSION['user_id'];
$p_id = $_GET['p_id'];
$bidAmount = $_POST['bidAmount'];

// Database connection details
$hostname = "localhost";
$username = "root";
$password = "Lava&08sql337";
$database = "dbms";

// Create connection
$mysqli = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($mysqli->connect_error) {
    echo json_encode(['error' => 'Connection failed: ' . $mysqli->connect_error]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check auction end date
    $sql = "SELECT end_date FROM auction WHERE auction_id = ?";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        echo json_encode(['error' => 'Failed to prepare statement: ' . $mysqli->error]);
        exit;
    }
    $stmt->bind_param("i", $auction_id);
    if (!$stmt->execute()) {
        echo json_encode(['error' => 'Failed to execute statement: ' . $stmt->error]);
        exit;
    }
    $result = $stmt->get_result();
    if (!$result) {
        echo json_encode(['error' => 'Failed to get result: ' . $stmt->error]);
        exit;
    }
    $auc = $result->fetch_assoc();
    $stmt->close();
    date_default_timezone_set('Asia/Kolkata');
    // Check if auction has ended
    $currentDate = date('Y-m-d H:i:s');
    $endDate = $auc['end_date'];
    if ($currentDate >= $endDate) {
        echo json_encode(['error' => 'Auction has ended. You cannot place a bid.']);
        exit;
    }
    

    // Retrieve the current highest bid
    $sql = "SELECT MAX(bid_amount) AS highest_bid FROM bids WHERE auction_id = ?";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        echo json_encode(['error' => 'Failed to prepare statement: ' . $mysqli->error]);
        exit;
    }
    $stmt->bind_param("i", $auction_id);
    if (!$stmt->execute()) {
        echo json_encode(['error' => 'Failed to execute statement: ' . $stmt->error]);
        exit;
    }
    $result = $stmt->get_result();
    if (!$result) {
        echo json_encode(['error' => 'Failed to get result: ' . $stmt->error]);
        exit;
    }
    $highestBidRow = $result->fetch_assoc();
    $stmt->close();

    $currentHighestBid = $highestBidRow['highest_bid'] ?? 0; // Default to 0 if no bids found

    // Check if the bid amount is greater than the current highest bid
    if ($bidAmount <= $currentHighestBid) {
        echo json_encode(['error' => 'Bid amount must be greater than the current highest bid.']);
        exit;
    }

    // Insert the new bid
    $sql = "INSERT INTO bids (auction_id, user_id, bid_amount) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        echo json_encode(['error' => 'Failed to prepare statement: ' . $mysqli->error]);
        exit;
    }
    $stmt->bind_param("iid", $auction_id, $user_id, $bidAmount);
    if (!$stmt->execute()) {
        echo json_encode(['error' => 'Failed to execute statement: ' . $stmt->error]);
        exit;
    }
    $stmt->close();

    // Retrieve all bids for the given auction_id, ordered by bid_amount in descending order
    $sql = "SELECT * FROM bids WHERE auction_id = ? ORDER BY bid_amount DESC";
    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        echo json_encode(['error' => 'Failed to prepare statement: ' . $mysqli->error]);
        exit;
    }
    $stmt->bind_param("i", $auction_id);
    if (!$stmt->execute()) {
        echo json_encode(['error' => 'Failed to execute statement: ' . $stmt->error]);
        exit;
    }
    $result = $stmt->get_result();
    if (!$result) {
        echo json_encode(['error' => 'Failed to get result: ' . $stmt->error]);
        exit;
    }
    $bids = [];
    while ($row = $result->fetch_assoc()) {
        $bids[] = $row;
    }
    $stmt->close();

    echo json_encode(['success' => true, 'bids' => $bids]);
} else {
    echo json_encode(['error' => 'Invalid request method.']);
    exit;
}
?>
