<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    die("User is not logged in.");
}

$hostname = "localhost";
$username = "root";
$password = "Lava&08sql337";
$database = "dbms";

$mysqli = new mysqli($hostname, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $p_name = $_POST['p_name'];
    $p_desc = $_POST['p_desc'];
    $p_price = $_POST['p_price'];
    $p_category = isset($_POST['p_category']) ? $_POST['p_category'] : null;

    if (isset($_FILES['p_image']) && $_FILES['p_image']['error'] === 0) {
        $image = $_FILES['p_image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));
    } else {
        $imgContent = null;
    }

    $stmt = $mysqli->prepare("INSERT INTO product (p_name, p_desc, p_price, p_category, p_image, reg_date, user_id) VALUES (?, ?, ?, ?, ?, CURDATE(), ?)");
    
    if ($stmt) {
        $stmt->bind_param("ssdsbi", $p_name, $p_desc, $p_price, $p_category, $imgContent, $user_id);
        
        if ($stmt->execute()) {
            echo "<script>alert('Product registered successfully')</script>";
            $p_id = $stmt->insert_id;
            header("Location: auction.php?p_id=" . $p_id);
            exit();
        } else {
           echo "Error: " . $stmt->error;
        }
        $stmt->close();

    } else {
        echo "Error: " . $mysqli->error;
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Your Product </title>
    <link rel="stylesheet" href="style_pdtreg.css">
</head>
<body>
    <header>
        <img src="bidbay.jpeg" alt="Logo" class="logo">
    </header>
    <div class="container">
        <h2>Register your product here</h2>
        <form action="product.php" method="post" enctype="multipart/form-data">
            <div class="form-grp">
                <label>Product name: </label>
                <input type="text" name="p_name" id="p_name" placeholder="Enter product name" maxlength="100">
            </div>
            <div class="form-grp">
                <label>Description: </label>
                <textarea name="p_desc" id="p_desc" cols="30" rows="10" placeholder="Briefly describe your product"></textarea>
            </div>
            <div class="form-grp">
                <label>Base price: </label>
                <input type="number" name="p_price" id="p_price" placeholder="Enter base price">
            </div>
            <div class="form-grp">
                <label>Category: </label>
                <select name="p_category" id="p_category">
                    <option value="none" selected disabled hidden>Select a Category</option>
                    <option value="antique">Antiques/Artifacts</option>
                    <option value="art">Art</option>
                    <option value="books">Books</option>
                    <option value="household">Household Articles</option>
                    <option value="jewel">Jewellery</option>
                    <option value="electronics">Electronics</option>
                </select>
            </div>

            <div class="form-grp">
                <label>Image: </label>
                <input type="file" name="p_image" id="p_image" onchange="upload()" accept="image/*">
            </div>

            <button class="button" type="submit">Register Your Auction Here</button>
        </form>
    </div>
    <footer>
        © Copyright 2024
    </footer>
</body>
</html>