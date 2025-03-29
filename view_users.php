<?php
session_start();
require_once 'db_connection.php';
require_once 'header.php';

// Check if user is an admin
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch only non-admin users
$sql = "SELECT id, name, email, dob, gender, degree, grad_year, role FROM users WHERE role != 'admin'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
</head>
<body>
    
    <div class="container">
        <h2>Registered Users</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>DOB</th>
                <th>Gender</th>
                <th>Degree</th>
                <th>Grad Year</th>
                <th>Role</th>
                <th>Action</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['dob']) ?></td>
                <td><?= htmlspecialchars($row['gender']) ?></td>
                <td><?= htmlspecialchars($row['degree']) ?></td>
                <td><?= htmlspecialchars($row['grad_year']) ?></td>
                <td><?= htmlspecialchars($row['role']) ?></td>
                <td>
                    <form action="delete_user.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                        <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                        <button type="submit" class="delete-btn">Delete</button>
                    </form>
                </td>
            </tr>
            <?php } ?>

        </table>
    </div>
</body>

<style>
    body {
        font-family: Arial, sans-serif;
        background:rgb(221, 178, 178);
    }
    .container {
        width: 90%;
        margin: auto;
        overflow: hidden;
    }
    .container h2 {
        color: blue;
        text-align: center;
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: white;
        border-radius: 8px;
        overflow: hidden;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
    }
    th {
        background: #007BFF;
        color: white;
    }
    tr:nth-child(even) {
        background: #f2f2f2;
    }
    .delete-btn {
        background: red;
        color: white;
        border: none;
        padding: 7px 10px;
        cursor: pointer;
        border-radius: 5px;
    }
    .delete-btn:hover {
        background: darkred;
    }
</style>
</html>
