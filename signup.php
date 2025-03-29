<?php
require_once 'db_connection.php';
require_once 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $degree = $_POST['degree'];
    $grad_year = $_POST['grad_year'];
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if the email already exists
    $check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $check_email->store_result();

    if ($check_email->num_rows > 0) {
        echo "<script>alert('Email already exists! Use a different email.'); window.location.href = 'signup.php';</script>";
        exit();
    }
    $check_email->close();

    // File upload handling
    $photo = $_FILES['photo']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($photo);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $valid_extensions = array("jpg", "jpeg", "png", "gif");

    if (!in_array($imageFileType, $valid_extensions)) {
        echo "<script>alert('Invalid image format! Upload JPG, JPEG, PNG, or GIF.'); window.location.href = 'signup.php';</script>";
        exit();
    }

    if ($_FILES["photo"]["size"] > 500000) { // 500KB limit
        echo "<script>alert('File size too large! Max 500KB allowed.'); window.location.href = 'signup.php';</script>";
        exit();
    }

    move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);

    // Insert new user
    $sql = "INSERT INTO users (name, email, dob, gender, degree, grad_year, photo, password, role) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $name, $email, $dob, $gender, $degree, $grad_year, $photo, $password, $role);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! Please login.'); window.location.href = 'login.php';</script>";
    } else {
        echo "<script>alert('Something went wrong. Try again later.'); window.location.href = 'signup.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Internship Portal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background:rgb(221, 178, 178);
            background-size: cover;
            background-position: center;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            justify-content: center;
            padding-top: 50px;
        }

        .signup-container {
            width: 90%;
            max-width: 400px;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-top: 20px;
        }

        .signup-container h2 {
            color: blue;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="signup-container">
    <h2>Signup</h2>
    <form method="post" action="signup.php" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Date of Birth:</label>
        <input type="date" name="dob" required>

        <label>Gender:</label>
        <select name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>

        <label>Degree:</label>
        <select name="degree" required>
            <option value="BTech">BTech</option>
            <option value="MTech">MTech</option>
            <option value="PG">PG</option>
        </select>

        <label>Graduation Year:</label>
        <select name="grad_year" required>
            <?php for ($year = 2010; $year <= 2030; $year++) echo "<option value='$year'>$year</option>"; ?>
        </select>

        <label>Upload Profile Photo:</label>
        <input type="file" name="photo" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <label>Signup as:</label>
        <select name="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>

        <input type="submit" value="Signup">
    </form>
</div>

</body>
</html>
