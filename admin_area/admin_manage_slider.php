<?php
include("../includes/connect.php");
include("../functions/common_function.php");
session_start();

// Handle image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['slider_image']) && !isset($_POST['update_id'])) {
    $upload_dir = 'uploads/slider/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true); // Create directory if not exists
    }

    $image_name = basename($_FILES['slider_image']['name']);
    $target_file = $upload_dir . $image_name;

    if (move_uploaded_file($_FILES['slider_image']['tmp_name'], $target_file)) {
        $query = "INSERT INTO slider_images (image_path) VALUES ('$target_file')";
        if (mysqli_query($con, $query)) {
            $_SESSION['message'] = "Image uploaded successfully.";
        } else {
            $_SESSION['error'] = "Database error: Could not upload image.";
        }
    } else {
        $_SESSION['error'] = "Failed to upload image.";
    }
}

// Handle image deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $query = "SELECT image_path FROM slider_images WHERE id = $delete_id";
    $result = mysqli_query($con, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $image_path = $row['image_path'];
        if (file_exists($image_path)) {
            unlink($image_path); // Delete the file from the server
        }

        $delete_query = "DELETE FROM slider_images WHERE id = $delete_id";
        if (mysqli_query($con, $delete_query)) {
            $_SESSION['message'] = "Image deleted successfully.";
        } else {
            $_SESSION['error'] = "Failed to delete image from database.";
        }
    }
}

// Handle image update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['slider_image']) && isset($_POST['update_id'])) {
    $update_id = intval($_POST['update_id']);
    $upload_dir = 'uploads/slider/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true); // Create directory if not exists
    }

    $image_name = basename($_FILES['slider_image']['name']);
    $target_file = $upload_dir . $image_name;

    // Fetch existing image path for deletion
    $query = "SELECT image_path FROM slider_images WHERE id = $update_id";
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        $old_image_path = $row['image_path'];
        if (file_exists($old_image_path)) {
            unlink($old_image_path); // Delete old image from the server
        }
    }

    if (move_uploaded_file($_FILES['slider_image']['tmp_name'], $target_file)) {
        $update_query = "UPDATE slider_images SET image_path = '$target_file' WHERE id = $update_id";
        if (mysqli_query($con, $update_query)) {
            $_SESSION['message'] = "Image updated successfully.";
        } else {
            $_SESSION['error'] = "Database error: Could not update image.";
        }
    } else {
        $_SESSION['error'] = "Failed to upload new image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Slider Images</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Manage Slider Images</h2>

    <!-- Display Messages -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <!-- Upload Form -->
    <form action="" method="POST" enctype="multipart/form-data" class="mb-4">
        <div class="form-group mb-3">
            <label for="slider_image">Upload New Slider Image:</label>
            <input type="file" name="slider_image" id="slider_image" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>

    <!-- Display Uploaded Images -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Uploaded At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM slider_images ORDER BY uploaded_at DESC";
            $result = mysqli_query($con, $query);
            while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><img src="<?= $row['image_path']; ?>" alt="Slider Image" width="100"></td>
                    <td><?= $row['uploaded_at']; ?></td>
                    <td>
                        <a href="?delete_id=<?= $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        <!-- Update button triggers form -->
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal<?= $row['id']; ?>">Update</button>

                        <!-- Update Modal -->
                        <div class="modal fade" id="updateModal<?= $row['id']; ?>" tabindex="-1" aria-labelledby="updateModalLabel<?= $row['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateModalLabel<?= $row['id']; ?>">Update Slider Image</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="update_id" value="<?= $row['id']; ?>">
                                            <div class="form-group mb-3">
                                                <label for="slider_image">Select New Image:</label>
                                                <input type="file" name="slider_image" id="slider_image" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-warning">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End of Modal -->
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
