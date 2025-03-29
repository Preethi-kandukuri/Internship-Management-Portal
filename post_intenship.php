<?php
include 'db_connection.php';

 
session_start();
// Check if the user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
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

    $sql = "INSERT INTO internships (name, company, stipend, end_date, description) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $company, $stipend, $end_date, $description);

    if ($stmt->execute()) {
        echo "<p>Internship posted successfully!</p>";
    } else {
        echo "<p>Error posting internship: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Internship</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <button class="back-button" onclick="history.back()">⬅ Go Back</button>
        <h2>Post a New Internship</h2>
    </header>
    <div class="container">
        <form method="POST">
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

            <input type="submit" value="Post Internship">
        </form>
    </div>
</body>
<style>

form {
    width: 50%;
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

    </style>
</html>
