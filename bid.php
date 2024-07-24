<?php
session_start();
if (!isset($_GET["auction_id"]) || !isset($_GET["p_id"]) || !isset($_SESSION["user_id"])) {
    echo json_encode(['error' => 'Required parameters are not set.']);
    exit;
} else {
    $auction_id = $_GET['auction_id'];
    $user_id = $_SESSION['user_id'];
    $p_id = $_GET['p_id'];
    //$bidAmount = $_POST['bidAmount'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Online Auction System - Auction Ongoing</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
        }
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
        .auction-item {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }
        .Highest-Bid {
            background-color: blue;
            padding: 10px;
            text-align: center;
        }
        .bid-form input[type="text"] {
            width: 100px;
            padding: 5px;
            margin-right: 10px;
        }
        .bidder-info {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <header>
        <img src="bidbay.jpeg" alt="Logo" class="logo">
    </header>
    <div class="auction-item">
        <h2 id="productName"></h2>
        <img id="productImage" src="" alt="Product Image" style="max-width: 200px;">
        <p id="productDescription"></p>
        <p id="sellerName"></p>
        <p id="Price"></p>
        <p id="countdown"></p>
    </div>

    <div class="Highest-Bid">
        <p id="currentHighestBid" style="color: #fff; font-size: 30px;"><strong>Current Highest Bid: Rs.0</strong></p>
    </div>

    <div class="bid-form">
        <h3>Place Bid</h3>
        <form id="bidForm">
            <input type="text" name="bidAmount" placeholder="Bid Amount" required />
            <button type="submit">Place Bid</button>
            <p id="bidError" style="color:red;"></p>
        </form>
    </div>

    <div class="bidder-info">
        <h3>Bidders</h3>
        <table>
            <thead>
                <tr>
                    <th>Bidder Name</th>
                    <th>Price</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody id="bidTableBody">
                <!-- Rows will be populated by JavaScript -->
            </tbody>
        </table>
    </div>

</body>
<script>

function updateCountdown(endTime) {
    var now = new Date().getTime();
    var timeLeft = endTime - now;
    if (timeLeft <= 0) {
        document.getElementById('countdown').textContent = 'Auction Ended';
    } else {
        var days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
        var hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
        document.getElementById('countdown').textContent = `Time Left: ${days}days ${hours}hours ${minutes}min ${seconds}sec`;
    }
}

function fetchEndDate() {
    fetch('get_end_date.php?auction_id=<?php echo htmlspecialchars($auction_id); ?>')
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            console.error('Error:', data.error);
        } else {
            var endTime = new Date(data.end_date).getTime();

            // Initial call to display countdown immediately
            updateCountdown(endTime);

            // Update the countdown every second
            var countdownInterval = setInterval(() => {
                updateCountdown(endTime);
                if (new Date().getTime() >= endTime) {
                    clearInterval(countdownInterval); // Stop the countdown
                    fetchWinner(); // Fetch the winner's information
                }
            }, 1000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function fetchWinner() {
    fetch('get_winner.php?auction_id=<?php echo htmlspecialchars($auction_id); ?>')
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            console.error('Error:', data.error);
        } else {
            var winnerName = data.winner_name;
            var highestBidAmount = data.highest_bid_amount;
            document.getElementById('countdown').textContent = `Winner: ${winnerName} (Bid Amount: Rs.${highestBidAmount})`;
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Call fetchEndDate function to start fetching and updating the countdown
fetchEndDate();


    function updateCurrentHighestBid() {
        fetch('get_highest_bid.php?auction_id=<?php echo htmlspecialchars($auction_id); ?>&p_id=<?php echo htmlspecialchars($p_id); ?>')
        .then(response => response.json())
        .then(data => {
            document.getElementById('currentHighestBid').innerHTML = `<strong>Current Highest Bid: ${data.highestBid}</strong>`;
        })
        .catch(error => {
            console.error('Error updating highest bid:', error);
        });
    }

    function updateBidTable(bids) {
        const bidTableBody = document.getElementById('bidTableBody');
        bidTableBody.innerHTML = ''; // Clear the table body first
        bids.forEach(bid => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${bid.full_name}</td>
                <td>${bid.bid_amount}</td>
                <td>${bid.time_stamp}</td>
            `;
            bidTableBody.appendChild(row);
        });
    }

    document.getElementById('bidForm').addEventListener('submit', function(event) {
        event.preventDefault();

        var bidAmountInput = document.querySelector('.bid-form input[name="bidAmount"]');
        var bidAmount = bidAmountInput.value;
        var bidError = document.getElementById('bidError');

        fetch('place_bid.php?auction_id=<?php echo htmlspecialchars($auction_id); ?>&p_id=<?php echo htmlspecialchars($p_id); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'bidAmount=' + encodeURIComponent(bidAmount),
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                bidError.textContent =data.error; // Show an error message
            } else {
                alert('Bid placed successfully!'); // Show a success message
                bidAmountInput.value = ''; // Clear the input box
                updateCurrentHighestBid(); // Update the current highest bid immediately
                fetchBidsAndProductDetails(); // Update the bids table
                bidError.textContent = ''; // Clear any previous error message
            }
        })
        .catch(error => {
            console.error(error);
            bidError.textContent = 'Error placing bid. Please try again.';
        });
    });

    function fetchBidsAndProductDetails() {
    fetch('get_product_and_bids.php?auction_id=<?php echo htmlspecialchars($auction_id); ?>&p_id=<?php echo htmlspecialchars($p_id); ?>')
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            console.error(data.error);
        } else {
            document.getElementById('productName').textContent = data.product.p_name;
            document.getElementById('productImage').src = data.product.p_image;
            document.getElementById('productDescription').textContent = "Description: " + data.product.p_desc;
            document.getElementById('sellerName').textContent = "Seller: " + data.product.seller_name;
            document.getElementById('Price').textContent = "Price:" + data.product.p_price;
            updateBidTable(data.bids);

            // Calculate and display the countdown
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
    }   


    fetchBidsAndProductDetails(); // Load bids and product details on page load
    updateCurrentHighestBid(); // Load current highest bid on page load
    fetchEndDate(); // Fetch the end date
</script>
</html>
