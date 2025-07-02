<?php
include("../includes/connect.php");
include("../functions/common_function.php");

// Handle form submission for adding/updating offers
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_offer'])) {
        $code = $_POST['code'];
        $discount = $_POST['discount'];
        $expiry_date = $_POST['expiry_date'];
        $status = $_POST['status'];

        $sql = "INSERT INTO offers (code, discount, expiry_date, status) VALUES ('$code', $discount, '$expiry_date', '$status')";
        $con->query($sql);
    }
    if (isset($_POST['update_offer'])) {
        $id = $_POST['id'];
        $code = $_POST['code'];
        $discount = $_POST['discount'];
        $expiry_date = $_POST['expiry_date'];
        $status = $_POST['status'];

        $sql = "UPDATE offers SET code='$code', discount=$discount, expiry_date='$expiry_date', status='$status' WHERE id=$id";
        $con->query($sql);
    }
}

// Fetch offers
$result = $con->query("SELECT * FROM offers");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin - Manage Offers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        h1, h2 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        form input, form select, form button {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        form button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        form button:hover {
            background-color: #0056b3;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 10px 15px;
            border: 1px solid #ddd;
            text-align: center;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .actions form {
            display: inline-block;
        }

        .actions input, .actions select, .actions button {
            display: inline-block;
            width: auto;
            margin-right: 5px;
        }

        .actions button {
            background-color: #28a745;
            color: white;
        }

        .actions button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Manage Offers</h1>
    <form method="POST">
        <label>Code:</label>
        <input type="text" name="code" required>
        <label>Discount:</label>
        <input type="number" name="discount" required>
        <label>Expiry Date:</label>
        <input type="date" name="expiry_date" required>
        <label>Status:</label>
        <select name="status">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
        <button type="submit" name="add_offer">Add Offer</button>
    </form>

    <h2>Current Offers</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Discount</th>
                <th>Expiry Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['code'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= $row['discount'] ?>%</td>
                    <td><?= $row['expiry_date'] ?></td>
                    <td><?= ucfirst($row['status']) ?></td>
                    <td class="actions">
                        <form method="POST">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <input type="text" name="code" value="<?= htmlspecialchars($row['code'], ENT_QUOTES, 'UTF-8') ?>" required>
                            <input type="number" name="discount" value="<?= $row['discount'] ?>" required>
                            <input type="date" name="expiry_date" value="<?= $row['expiry_date'] ?>" required>
                            <select name="status">
                                <option value="active" <?= $row['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= $row['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                            <button type="submit" name="update_offer">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
