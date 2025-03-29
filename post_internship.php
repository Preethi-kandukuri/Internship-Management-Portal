<?php
require_once 'db_connection.php';
require_once 'header.php';

// Check if the user is an admin
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $company = $_POST['company'];
    $stipend = $_POST['stipend'];
    $end_date = $_POST['end_date'];
    $description = $_POST['description'];
    $title = $_POST['title'];
    $location = $_POST['location'];
    $duration = $_POST['duration'];
    $posted_date = date('Y-m-d H:i:s'); // Current timestamp

    $sql = "INSERT INTO internships (name, company, stipend, end_date, description, posted_date, title, location, duration) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $name, $company, $stipend, $end_date, $description, $posted_date, $title, $location, $duration);

    if ($stmt->execute()) {
        echo "<script>
                alert('Internship posted successfully!');
                window.location.href = 'post_internship.php'; // Redirect after alert
              </script>";
        exit();
    } else {
        echo "<script>alert('Error posting internship: " . addslashes($conn->error) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Internship</title>
</head>
<body>
    <div class="container">
        <form method="POST">
            <h2>Post Internship</h2>
            <label>Internship Name:</label>
            <input type="text" name="name" required><br>

            <label>Company:</label>
            <input type="text" name="company" required><br>

            <label>Stipend:</label>
            <input type="text" name="stipend" required><br>

            <label>Application Deadline:</label>
            <input type="date" name="end_date" required><br>

            <label>Description:</label>
            <textarea name="description" required></textarea><br>

            <label>Title:</label>
            <input type="text" name="title" required><br>

            <label>Location:</label>
            <input type="text" name="location" required><br>

            <label>Duration:</label>
            <input type="text" name="duration" required><br>

            <input type="submit" value="Post Internship">
        </form>
    </div>
</body>
<style>
form {
    width: 50%;
    margin-top:20px;
    margin: auto;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
    font-weight: bold;
    display: block;
    margin-top: 10px;
}

input, textarea {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
body{
    background:rgb(221, 178, 178);
}
input[type="submit"] {
    margin-top: 15px;
    background: #007BFF;
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background: #0056b3;
}

.container h2 {
    color: blue;
    text-align: center;
    margin-bottom: 20px;
}
</style>
</html>
