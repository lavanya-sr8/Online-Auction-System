

<?php
$conn = new mysqli("localhost", "root", "Lava&08sql337", "dbms");
date_default_timezone_set('Asia/Kolkata');
$currentDate = date('Y-m-d H:i:s');
$query = "SELECT  DISTINCT a.*, p.p_name, p.p_image, p.p_desc
          FROM auction AS a 
          INNER JOIN product AS p ON a.p_id = p.p_id
          WHERE a.end_date <= '$currentDate'";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div style='text-align: center;'>";
        echo "<p>Start Date: " . $row['start_date'] . "</p>";
        echo "<p>End Date: " . $row['end_date'] . "</p>";
        echo "<p>Max Price: " . $row['max_price'] . "</p>";
        echo "<p>Product Name: " . $row['p_name'] . "</p>";
        echo "<p>Product Image: <img src='" . $row['p_image'] . "'></p>";
        echo "<p>Product Description: " . $row['p_desc'] . "</p>";
        //echo "<form action='bid.html' method='post'>";
        //echo "<button style='background-color: #007bff; color: #fff; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;' type='submit'>Participate</button>";
        //echo "</form>";
        echo "</div>";
    }
} else {
    echo "No expired auctions.";
}
$conn->close();
?>
