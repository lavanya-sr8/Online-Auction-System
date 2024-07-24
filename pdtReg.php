
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
        <!-- Logo -->
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

            <button class="button" type="submit"><a href="auction.php">Register Your Auction Here</a></button>
        </form>
    </div>
    <footer>
        © Copyright 2024
    </footer>
</body>
</html>