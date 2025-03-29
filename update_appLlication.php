<?php
session_start();
require_once 'db_connection.php';
require_once 'header.php'; // Include database connection

// Ensure user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $grad_year = $conn->real_escape_string($_POST['grad_year']);

    // Handle password update
    if (!empty($_POST['current_password']) && !empty($_POST['new_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        
        if (password_verify($current_password, $user['password'])) {
            $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
            $stmt->bind_param("si", $new_password, $user_id);
            $stmt->execute();
        } else {
            echo "<p class='error'>Current password is incorrect!</p>";
        }
    }

    // Handle profile picture upload
    if (!empty($_FILES['profile_pic']['name'])) {
        $profile_pic = "uploads/" . basename($_FILES['profile_pic']['name']);
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profile_pic);
        $stmt = $conn->prepare("UPDATE users SET profile_pic=? WHERE id=?");
        $stmt->bind_param("si", $profile_pic, $user_id);
        $stmt->execute();
    }

    
    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, dob=?, grad_year=? WHERE id=?");
    $stmt->bind_param("ssssi", $username, $email, $dob, $grad_year, $user_id);
    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='update_appLication.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error updating profile: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
   
</head>
<body>
    <div class="container">
        <h2>Update Profile</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Profile Picture:</label>
            <input type="file" name="profile_pic">

            <label>Username:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['name']); ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label>DOB:</label>
            <input type="date" name="dob" value="<?php echo htmlspecialchars($user['dob']); ?>" required>

            <label>Graduation Year:</label>
            <input type="number" name="grad_year" value="<?php echo htmlspecialchars($user['grad_year']); ?>" required>

            <label>Current Password:</label>
            <input type="password" name="current_password">

            <label>New Password:</label>
            <input type="password" name="new_password">

            <button type="submit">Update Profile</button>
        </form>
    </div>
</body>



<style>
    body {
    font-family: Arial, sans-serif;
    background:rgb(221, 178, 178);
    margin: 0;
    padding: 0;
}

.container {
    width: 50%;
    margin: 50px auto;
    padding: 20px;
    background: white;
    box-shadow: 0px 0px 10px 0px #aaa;
    border-radius: 5px;
}

h2 {
    text-align: center;
}

label {
    font-weight: bold;
}

input, textarea {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    width: 100%;
    padding: 10px;
    background: #007BFF;
    color: white;
    border: none;
    cursor: pointer;
}

button:hover {
    background: #0056b3;
}

.success {
    color: green;
    text-align: center;
}

    </style>

</html>
