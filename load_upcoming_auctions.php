<?php
//session_start();
if (isset($_POST['auction_id'])) {
    $_SESSION['auction_id'] = $_POST['auction_id'];
    $_SESSION['p_id'] = $_POST['p_id']; // Set the product ID as a session variable
    $auction_id = $_POST['auction_id'];
    $p_id = $_POST['p_id'];
    header("Location: bid.php?auction_id=" . $auction_id . "&p_id=" . $p_id);
    exit();
}

?>

<?php
$conn = new mysqli("localhost", "root", "Lava&08sql337", "dbms");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

date_default_timezone_set('Asia/Kolkata'); // Replace 'Your/Timezone' with your actual timezone, e.g., 'America/New_York'

$currentDate = date('Y-m-d H:i:s'); // Get current date and time in the correct format

// Prepare the SQL query
$query = $conn->prepare("SELECT DISTINCT a.*, p.p_name, p.p_image, p.p_desc
                         FROM auction AS a 
                         INNER JOIN product AS p ON a.p_id = p.p_id
                         WHERE a.start_date > ?");

$query->bind_param("s", $currentDate);

$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div style='text-align: center;'>";
        echo "<p>Start Date: " . $row['start_date'] . "</p>";
        echo "<p>End Date: " . $row['end_date'] . "</p>";
        echo "<p>Max Price: " . $row['max_price'] . "</p>";
        echo "<p>Product Name: " . $row['p_name'] . "</p>";
        echo "<p>Product Image: <img src='" . $row['p_image'] . "' alt='Product Image' style='width:100px;height:100px;'></p>";
        echo "<p>Product Description: " . $row['p_desc'] . "</p>";
        //echo "<form action='' method='post'>";
        //echo "<input type='hidden' name='auction_id' value='" . $row['auction_id'] . "'>";
        //echo "<input type='hidden' name='p_id' value='" . $row['p_id'] . "'>";
        echo "<button style='background-color: #007bff; color: #fff; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;' type='submit'>Auction will start soon</button>";
        //echo "</form>";
        echo "</div>";
    }
} else {
    echo "No upcoming auctions.";
}

$query->close();
$conn->close();
?>
