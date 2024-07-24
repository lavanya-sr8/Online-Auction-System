<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BidBay | Where Bids Meet Destiny</title>
    <style>
        /* CSS for styling */

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4; /* Background color for the whole page */
        }
        .container {
            max-width: 1440px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffe8d5; /* Background color for the main content area */
            border-radius: 10px; /* Add some rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
        }
        header {
            background-color: #349dff;
            color: #fff;
            padding: 20px 0; /* Increase top and bottom padding */
            /* text-align: center; */
            border-radius: 10px 10px 0 0; /* Rounded corners, excluding bottom */
        }
        .logo {
            width: 100px; /* Adjust logo size */
            border-radius: 50%; /* Make the logo round */
            margin-left: 5%;
        }
        .login-section {
            text-align: right;
            padding-right: 20px; /* Add some padding on the right side */
        }
        .login-section a {
            color: #fff;
            text-decoration: none; /* Remove underline */
            transition: color 0.3s; /* Smooth color transition */
        }
        .login-section a:hover {
            color: #ccc; /* Lighten link color on hover */
        }

        .about-section {
            align-content: center;
            /* text-align: 10%; */
            /* font-size: 2.5rem; */
            padding-left: 5%;
            width: 75%;
            height: 20em;
        }

        .about-section h2{
            font-size: 2.5rem;
        }

        .about-section p {
            line-height: 1.6; /* Increase line height for better readability */
            text-align: justify;
        }

        .sell-product {
            display: flex;
            flex-direction: row;
            /* align-content: right; */
            /* text-align: 10%; */
            /* font-size: 2.5rem; */
            /* padding-left: 5%; */
            /* margin-left: 40%; */
            /* width: 55%; */
            height: 20em;
            
        }

        .sell-product .text{
            padding-left: 5%;
        }

        .sell-product h2{
            font-size: 2.5rem;
        }

        .sell-product p {
            line-height: 1.6; /* Increase line height for better readability */
            text-align: justify;
        }

        .buy-product {
            display: flex;
            flex-direction: row;
            align-content: center;
            /* text-align: 10%; */
            /* font-size: 2.5rem; */
            
            height: 20em;
        
        }

        .buy-product .text{
            padding-left: 5%;
            width: 75%;
        }

        .buy-product h2{
            font-size: 2.5rem;
        }

        .buy-product p {
            line-height: 1.6; /* Increase line height for better readability */
            /* text-align: justify; */
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            color: #333;
            border: 2px solid #888888;
            border-radius: 50px;
            transition: background-color 0.3s, color 0.3s;
            text-decoration: none;
        }
        
        .button:hover {
            background-color: #7fc1ff;
            color: #000;
            box-shadow: 2px 2px 8px rgba(0,0,0,0.2);
            cursor:pointer;
        }
        
        .image img{
            height: 200px;
            width: 400px;
        }

        footer{
            background-color: #349dff;
            color: black;
            /* height: 5rem; */
            /* align-content: center; */
            text-align: center;
            padding: 8px 0;
        }

        
    </style>
</head>
<body>
    <header>
        <!-- Logo -->
        <img src="bidbay.jpeg" alt="Logo" class="logo">
        <!-- Login Section -->
        <div class="login-section">
            <!-- You can replace the links with your login/signup pages -->
            <a href="user_account.php">My Account</a> | <a href="login.php">Login</a> | <a href="registration.php">Sign Up</a>
        </div>
    </header>
    <div class="container">
        <!-- Website Description -->
            <section class="about-section">
                <!-- <h2>About Our Website</h2> -->
                <h2>Welcome to BidBay!</h2>
                <p>BidBay is your premier online auction platform, where buyers and sellers converge to bid on a wide range of items. From rare collectibles to everyday essentials, our dynamic marketplace offers thrilling auctions, secure transactions, and unbeatable deals. Join the bidding frenzy and discover treasures at BidBay!</p>
            </section>
        
        <!-- User Actions Section -->
        <section class="sell-product">
            <div class="image">
                <img src="auctionsale.jpeg" alt="Sale">
            </div>
            <div class="text">
                <h2>Sell Your Treasures!</h2>
                <p>Unlock the potential of your valuable items! Register your products on our platform and let eager bidders compete for them. From rare collectibles to everyday essentials, our auction site provides a global stage for your merchandise. Start your auction journey today!</p>
                <a href="product.php" class="button">Sell Your Item</a>
            </div>
        </section>
        
        
        <section class="buy-product">
            <div class="text">
                <h2>Bid, Win, Repeat!</h2>
                <p>Discover a world of possibilities! Dive into our thrilling auctions where you can bid on a wide range of products. From exquisite art to cutting-edge gadgets, our dynamic marketplace offers something for everyone. Join the excitement and snag incredible deals!</p>
                <a href="buyerhtml.php" class="button">Explore Auctions</a>
            </div>
            <div class="image">
                <img src="bidding.jpg" alt="Bidding">
            </div>
        </section>
    </div>
    <footer>
        <p>&copy; Copyright 2024 BidBay</p>
    </footer>
 </body>
</html>