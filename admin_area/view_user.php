<?php
include('../includes/connect.php');

// Check if the view_user parameter is set
if (isset($_GET['view_user'])) {
    $user_id = intval($_GET['view_user']); // Get the user ID from the URL

    // Fetch user details
    $get_user = "SELECT * FROM user_table WHERE user_id = $user_id";
    $result = mysqli_query($con, $get_user);

    // Check if user was found
    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result); // Fetch user data
    } else {
        echo "<h2>User not found!</h2>";
        exit;
    }
} else {
    echo "<h2>Invalid user ID!</h2>";
    exit;
}
?>
<head>
<style>
    body {
        font-family: Arial, sans-serif; /* Use a clean font */
        background-color: #f8f9fa; /* Light background color */
        color: #333; /* Dark text color */
        margin: 0;
        padding: 20px;
    }

    h3 {
        text-align: center;
        color: #28a745; /* Green color for headings */
        margin-bottom: 20px; /* Space below the heading */
    }

    table {
        width: 100%; /* Full width */
        border-collapse: collapse; /* Remove space between borders */
        margin: 0 auto; /* Center the table */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        background-color: #fff; /* White background for table */
    }

    th, td {
        padding: 15px; /* Padding inside cells */
        text-align: left; /* Left-align text */
        border-bottom: 1px solid #ddd; /* Light border */
    }

    tr:hover {
        background-color: #f1f1f1; /* Light gray background on hover */
    }

    img.user-image {
        max-width: 150px; /* Limit image width */
        max-height: 150px; /* Limit image height */
        width: auto; /* Maintain aspect ratio */
        height: auto; /* Maintain aspect ratio */
        border-radius: 8px; /* Rounded corners */
    }

    .btn {
        display: inline-block; /* Make buttons inline */
        padding: 10px 15px; /* Padding for buttons */
        margin-top: 10px; /* Space above buttons */
        text-decoration: none; /* Remove underline */
        color: #fff; /* White text */
        background-color: #007bff; /* Bootstrap primary color */
        border-radius: 5px; /* Rounded corners */
        transition: background-color 0.3s ease; /* Smooth transition */
    }

    .btn:hover {
        background-color: #0056b3; /* Darker color on hover */
    }

    @media (max-width: 600px) {
        table {
            width: 100%; /* Responsive full width */
        }
        
        img.user-image {
            max-width: 100px; /* Smaller image on mobile */
            max-height: 100px; /* Smaller image on mobile */
        }
    }
</style>

</head>
<h3>User Details</h3>
<table class="table">
    <tr>
        <td>User ID:</td>
        <td><?php echo $user_data['user_id']; ?></td>
    </tr>
    <tr>
        <td>Username:</td>
        <td><?php echo $user_data['username']; ?></td>
    </tr>
    <tr>
        <td>User Email:</td>
        <td><?php echo $user_data['user_email']; ?></td>
    </tr>
    <tr>
        <td>User Image:</td>
        <td><img src="../users_area/user_images/<?php echo $user_data['user_image']; ?>" alt="User Image" class="user-image" /></td>
    </tr>
    <tr>
        <td>User Address:</td>
        <td><?php echo $user_data['user_address']; ?></td>
    </tr>
    <tr>
        <td>User Mobile:</td>
        <td><?php echo $user_data['user_mobile']; ?></td>
    </tr>
    <tr>
        <td>Status:</td>
        <td><?php echo $user_data['status']; ?></td>
    </tr>
</table>

<a href="index.php?list_users" class="btn btn-secondary">Back to User List</a>
