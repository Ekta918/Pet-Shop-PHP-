<?php
session_start();
include("razorpay_config.php");
require_once '../includes/razorpay-php-2.9.0/Razorpay.php';
include("../includes/connect.php");

use Razorpay\Api\Api;

$api = new Api($keyId, $keySecret);

// Read payment details from the incoming request
$data = json_decode(file_get_contents('php://input'), true);

// Log the received data to help debug any issues
error_log(print_r($data, true));  // Logs data to PHP error log

// Check if all required parameters are present
if (isset($data['razorpay_payment_id'], $data['razorpay_order_id'], $data['razorpay_signature'])) {
    $order_id = $data['razorpay_order_id'];
    $payment_id = $data['razorpay_payment_id'];
    $signature = $data['razorpay_signature'];

    try {
        // Verify Razorpay signature
        $attributes = [
            'razorpay_order_id' => $order_id,
            'razorpay_payment_id' => $payment_id,
            'razorpay_signature' => $signature
        ];
        $api->utility->verifyPaymentSignature($attributes);

        // Update the database with the payment status
        $query = "UPDATE orders SET payment_status='Paid' WHERE razorpay_order_id='$order_id'";

        if (mysqli_query($con, $query)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'failure', 'error' => 'Database update failed']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'failure', 'error' => 'Verification failed: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'failure', 'error' => 'Payment details missing']);
}
?>
