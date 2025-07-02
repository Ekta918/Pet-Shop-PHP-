<?php
// Include your database connection
include("../includes/connect.php");  

// Start session to store flash messages
session_start();

// Fetch admin profile information from the database
$query = "SELECT * FROM admin_table WHERE admin_id = 1";  // Assume admin_id = 1 for simplicity
$stmt = $pdo->prepare($query);
$stmt->execute();
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle profile update (if the form is submitted)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_name = $_POST['admin_name'];
    $admin_email = $_POST['admin_email'];

    // Update the profile details in the database
    $updateQuery = "UPDATE admin_table SET admin_name = ?, admin_email = ? WHERE admin_id = 1";
    $stmt = $pdo->prepare($updateQuery);
    $stmt->execute([$admin_name, $admin_email]);

    // Set a success message in the session
    $_SESSION['success_message'] = 'Profile updated successfully!';

    // Redirect to the same page to avoid re-submitting the form on page reload
    header("Location: admin_profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2 class="text-center">Admin Profile</h2>

        <!-- Display success message if set in session -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success_message']; ?>
            </div>
            <?php
            // Clear the success message from session after displaying it
            unset($_SESSION['success_message']);
            ?>
        <?php endif; ?>

        <form method="POST" action="admin_profile.php">
            <div class="mb-3">
                <label for="admin_name" class="form-label">Name</label>
                <input type="text" class="form-control" id="admin_name" name="admin_name" value="<?php echo htmlspecialchars($admin['admin_name']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="admin_email" class="form-label">Email</label>
                <input type="email" class="form-control" id="admin_email" name="admin_email" value="<?php echo htmlspecialchars($admin['admin_email']); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
