<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    die("User is not logged in.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buyer Page</title>
  <style>
    header {
    background-color: #349dff;
    color: #fff;
    /* padding: 20px 0;  */
    /* text-align: center; */
    /* border-radius: 10px 10px 0 0;  */
}
.logo {
    width: 100px; /* Adjust logo size */
    border-radius: 50%; /* Make the logo round */
    margin-left: 5%;
}
  </style>
  <link rel="stylesheet" href="buyer.css">
</head>
<body>
<header>
        <img src="bidbay.jpeg" alt="Logo" class="logo">
    </header>
  <div class="header">
    <h1>Buyer Page</h1>
    <hr>
    <div class="search-box">
      <form action="auction_search.php" method="GET">
        <input type="text" name="search" id="searchInput" placeholder="Search by Product name...">
        <input type="submit" value="Search">
      </form>
    </div>
  </div>

  <div class="options">
    <div class="option">
      <button onclick="loadAuctions('current')">Currently Running Auctions</button>
      <div id="currentAuctions" class="dropdown-content">
        <?php include 'load_current_auctions.php'; ?>
      </div>
    </div>
    <div class="option">
      <button onclick="loadAuctions('upcoming')">Upcoming Auctions</button>
      <div id="upcomingAuctions" class="dropdown-content">
        <?php include 'load_upcoming_auctions.php'; ?>
      </div>
    </div>
    <div class="option">
      <button onclick="loadAuctions('cancelled')">Cancelled Auctions</button>
      <div id="cancelledAuctions" class="dropdown-content">
        <?php include 'load_cancelled_auctions.php'; ?>
      </div>
    </div>
    <div class="option">
      <button onclick="loadAuctions('expired')">Expired Auctions</button>
      <div id="expiredAuctions" class="dropdown-content">
        <?php include 'load_expired_auctions.php'; ?>
      </div>
    </div>
  </div>
</body>
</html>
