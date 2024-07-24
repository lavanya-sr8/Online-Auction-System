<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auction Search Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .auction-info {
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .auction-info p {
            margin: 5px 0;
        }
        .auction-info button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        .auction-info button:hover {
            background-color: #0056b3;
        }
        .no-result {
            text-align: center;
            color: #555;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        $currentDate = date('Y-m-d H:i:s');
        if (isset($_GET['search'])) {
            $searchedProductName = $_GET['search'];
            $conn = new mysqli("localhost", "root", "Lava&08sql337", "dbms");
            $query = "SELECT DISTINCT a.*, p.p_name, p.p_image, p.p_desc
                      FROM auction AS a 
                      INNER JOIN product AS p ON a.p_id = p.p_id
                      WHERE p.p_name LIKE '%$searchedProductName%' AND a.start_date<='$currentDate' AND a.end_date>'$currentDate'";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='auction-info'>";
                    echo "<p>Start Date: " . $row['start_date'] . "</p>";
                    echo "<p>End Date: " . $row['end_date'] . "</p>";
                    echo "<p>Max Price: " . $row['max_price'] . "</p>";
                    echo "<p>Product Name: " . $row['p_name'] . "</p>";
                    echo "<p>Product Image: <img src='" . $row['p_image'] . "'></p>";
                    echo "<p>Product Description: " . $row['p_desc'] . "</p>";
                    echo "<button onclick=\"window.location.href='bid.php'\">Participate</button>";
                    echo "</div>";
                }
            } else {
                echo "<p class='no-result'>No auction found.</p>";
            }
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
