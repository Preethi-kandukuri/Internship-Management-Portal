<?php
session_start();
require_once 'db_connection.php';

// Check if user is an admin
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Check if user ID is set
if (isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);

    // Delete user from database
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        // Redirect with success message
        echo "<script>
                alert('User deleted successfully!');
                window.location.href = 'view_users.php';
              </script>";
    } else {
        // Redirect with error message
        echo "<script>
                alert('Error deleting user. Please try again.');
                window.location.href = 'view_users.php';
              </script>";
    }

    $stmt->close();
}
$conn->close();
?>
