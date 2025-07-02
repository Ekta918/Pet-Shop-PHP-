<?php
include("../includes/connect.php"); // Include database connection

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $heading = mysqli_real_escape_string($con, $_POST['heading']);
    $content = mysqli_real_escape_string($con, $_POST['content']);
    $team_members = mysqli_real_escape_string($con, $_POST['team_members']);

    $query = "UPDATE about_us SET heading='$heading', content='$content', team_members='$team_members' WHERE id=1";
    if (mysqli_query($con, $query)) {
        echo "<script>alert('About Us page updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating About Us page.');</script>";
    }
}

// Fetch existing content
$query = "SELECT * FROM about_us WHERE id=1";
$result = mysqli_query($con, $query);
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin - Edit About Us</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit About Us Page</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="heading" class="form-label">Heading</label>
                <input type="text" class="form-control" id="heading" name="heading" value="<?php echo htmlspecialchars($data['heading']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="5" required><?php echo htmlspecialchars($data['content']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="team_members" class="form-label">Team Members (JSON Format)</label>
                <textarea class="form-control" id="team_members" name="team_members" rows="5" required><?php echo htmlspecialchars($data['team_members']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
