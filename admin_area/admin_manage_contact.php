<?php
include('../includes/connect.php'); // Include database connection

// Fetch contact details
$query = "SELECT * FROM contact_details WHERE id=1"; // Assuming id=1 for default contact details
$result = mysqli_query($con, $query);
$contact = mysqli_fetch_assoc($result);

// Handle form submission to update contact details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $operating_hours = mysqli_real_escape_string($con, $_POST['operating_hours']);

    $update_query = "UPDATE contact_details SET 
                        address = '$address', 
                        phone = '$phone', 
                        email = '$email', 
                        operating_hours = '$operating_hours' 
                     WHERE id=1";

    if (mysqli_query($con, $update_query)) {
        echo "<script>alert('Contact details updated successfully!');</script>";
        exit;
    } else {
        echo "<script>alert('Error: Unable to update contact details. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Contact Details</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Manage Contact Details</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea class="form-control" id="address" name="address" rows="3" required><?php echo htmlspecialchars($contact['address']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($contact['phone']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($contact['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="operating_hours">Operating Hours:</label>
                <textarea class="form-control" id="operating_hours" name="operating_hours" rows="3" required><?php echo htmlspecialchars($contact['operating_hours']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Update Contact Details</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
