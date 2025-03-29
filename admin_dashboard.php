<?php
//session_start();
require_once 'db_connection.php';
require_once 'header.php'; // Include navbar

// Check if user is logged in as admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // Redirect to login if not admin
    exit();
}

$admin_id = $_SESSION['id']; // Fetch admin ID from session

// Fetch admin details from the database
$sql = "SELECT name, photo FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

$name = $admin['name'] ?? 'Admin'; // Default name if not found
$photo = $admin['photo'] ?? 'profile.png'; // Default profile pic
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background:rgb(221, 178, 178);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .admin-container {
            text-align: center;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            width: 40%;
        }

        .admin-profile {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .admin-profile img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid #007bff;
            object-fit: cover;
            margin-bottom: 15px;
        }

        .admin-profile h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 5px;
        }

        .admin-profile p {
            font-size: 16px;
            color: gray;
        }
    </style>
</head>
<body>

    <div class="admin-container">
        <div class="admin-profile">
            <img src="uploads/<?php echo htmlspecialchars($photo); ?>" alt="Admin Profile">
            <h2>Welcome, <?php echo htmlspecialchars($name); ?>!</h2>
            <p>Admin Dashboard</p>
        </div>
    </div>

</body>
</html>
