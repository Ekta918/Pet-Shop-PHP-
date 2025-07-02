<?php
session_start();
include("razorpay_config.php");
require_once '../includes/razorpay-php-2.9.0/Razorpay.php';
include('../includes/connect.php');

use Razorpay\Api\Api;

$api = new Api($keyId, $keySecret);

// Fetch total price from POST
$total_price = isset($_POST['total_price']) ? $_POST['total_price'] : 0;

if ($total_price <= 0) {
    die("Invalid amount");
}

// Convert amount to paise for Razorpay
$amount = $total_price * 100;

// Create Razorpay order
$order = $api->order->create([
    'receipt' => uniqid(),
    'amount' => $amount,
    'currency' => 'INR',
    'payment_capture' => 1
]);

$orderId = $order['id'];
$_SESSION['razorpay_order_id'] = $orderId;

// Store the order in the database
$amount_in_inr = $amount / 100; // Convert back to INR
mysqli_query($con, "INSERT INTO orders (razorpay_order_id, amount, currency, payment_status) 
                    VALUES ('$orderId', '$amount_in_inr', 'INR', 'Pending')");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(to right,rgb(156, 182, 211),rgb(147, 155, 199));
            color: #fff;
        }
        .container {
            text-align: center;
            background: #4b5397;
            border-radius: 12px;
            padding: 20px;
            width: 400px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        button {
            background-color: #3399cc;
            color: #fff;
            font-size: 18px;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #1c6d99;
        }
        img {
            margin-bottom: 15px;
            width: 100px;
            height: auto;
        }
    </style>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <div class="container">
        <img src="http://localhost/PROJECT/images/l1.png" alt="Pet Paradise Logo">
        <h2>Proceed to Payment</h2>
        <button id="rzp-button">Pay Now</button>
    </div>

    <script>
        var options = {
            key: '<?php echo $keyId; ?>',
            amount: '<?php echo $amount; ?>',
            currency: 'INR',
            name: "Pet Paradise",
            description: "Test Transaction",
            image: 'http://localhost/PROJECT/images/l1.png',
            order_id: '<?php echo $orderId; ?>',
            handler: function (response) {
                console.log(response); // Log the response to check what data is being received

                // Send payment details to the server
                fetch('payment_success.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(response)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert('Payment Successful!');
                        window.location.href = 'thank_you_page.php';
                    } else {
                        alert('Payment failed: ' + data.error);
                    }
                })
                .catch(error => {
                    alert('Something went wrong!');
                    console.error(error);
                });
            },
            theme: {
                color: "#3399cc"
            }
        };

        var rzp1 = new Razorpay(options);
        document.getElementById('rzp-button').onclick = function(e) {
            rzp1.open();
            e.preventDefault();
        }
    </script>
</body>
</html>
