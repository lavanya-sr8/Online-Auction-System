<?php
$conn = new mysqli("localhost", "root", "Lava&08sql337", "dbms");
date_default_timezone_set('Asia/Kolkata');
$currentDate = date('Y-m-d H:i:s');
$query = "SELECT  DISTINCT a.*, p.p_name, p.p_image, p.p_desc
          FROM auction AS a 
          INNER JOIN product AS p ON a.p_id = p.p_id
          WHERE a.end_date <= '$currentDate'";
$result = $conn->query($query);

    echo "No cancelled auctions.";
$conn->close();
?>
