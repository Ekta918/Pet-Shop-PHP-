<?php
include('includes/connect.php'); // Include database connection

// Fetch contact details
$query = "SELECT * FROM contact_details WHERE id=1"; // Assuming id=1 for default contact details
$result = mysqli_query($con, $query);
$contact = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = mysqli_real_escape_string($con, $_POST['user_name']);
    $user_email = mysqli_real_escape_string($con, $_POST['user_email']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    // Insert data into database
    $query = "INSERT INTO contact_messages (user_name, user_email, message) VALUES ('$user_name', '$user_email', '$message')";
    if (mysqli_query($con, $query)) {
        echo "<script>alert('Your message has been sent successfully!')</script>";
    } else {
        echo "<script>alert('Error: Unable to send your message. Please try again.')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Pet Shop</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('images/42.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: white;
        }
        .contact-section {
            padding: 60px 0;
        }
        .contact-form {
            background: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 8px;
        }
        .contact-details {
            background: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .contact-details h4 {
            font-size: 1.5rem;
        }
        .contact-details p, .contact-details li {
            font-size: 1rem;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container contact-section">
        <h2 class="text-center text-light mb-4">Contact Us</h2>
        <div class="row">
            <!-- Contact Form -->
            <div class="col-md-6">
                <div class="contact-form">
                    <h4>Send Us a Message</h4>
                    <form action="" method="post" onsubmit="return validateForm()">
                        <div class="form-group">
                            <label for="user_name">Name</label>
                            <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <label for="user_email">Email</label>
                            <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Your Email" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Your Message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-submit btn-primary btn-block">Send Message</button>
                    </form>
                </div>
            </div>

            <!-- Contact Details -->
            <div class="col-md-6">
                <div class="contact-details">
                    <h4>Our Address</h4>
                    <p><?php echo htmlspecialchars($contact['address']); ?></p>
                    
                    <h4>Contact Information</h4>
                    <ul>
                        <li><strong>Phone:</strong> <?php echo htmlspecialchars($contact['phone']); ?></li>
                        <li><strong>Email:</strong> <?php echo htmlspecialchars($contact['email']); ?></li>
                    </ul>
                    
                    <h4>Operating Hours</h4>
                    <p><?php echo htmlspecialchars($contact['operating_hours']); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
