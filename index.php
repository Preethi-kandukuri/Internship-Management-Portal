<?php
// This PHP project includes user registration, login (admin/user), internship posting, and application tracking.
// Technologies: PHP, MySQL, HTML, CSS, Bootstrap.

// Database Connection
require_once 'db_connection.php';
require_once 'header.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "internship_portal";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create tables if not exist
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    dob DATE,
    gender ENUM('Male', 'Female', 'Other'),
    degree VARCHAR(50),
    grad_year INT CHECK (grad_year BETWEEN 2010 AND 2030),
    photo LONGBLOB,
    password VARCHAR(255),
    role ENUM('user', 'admin') DEFAULT 'user'
)";
$conn->query($sql_users);

$sql_internships = "CREATE TABLE IF NOT EXISTS internships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    stipend VARCHAR(50),
    company VARCHAR(255),
    end_date DATE,
    description TEXT
)";
$conn->query($sql_internships);

$sql_applications = "CREATE TABLE IF NOT EXISTS applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    internship_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (internship_id) REFERENCES internships(id)
)";
$conn->query($sql_applications);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internship Portal</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <main>
        <h1>Welcome to the Internship Portal</h1>
        <p>Find and apply for the best internships.</p>
    </main>
</body>
<style>
    /* Index Page Background */
body {
    margin: 0;
    padding: 0;
    background-image: url('intern.webp');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    font-family: Arial, sans-serif;
    color: white;
    text-align: center;
    position: relative;
}

/* Overlay for better readability */
body::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(186, 82, 82, 0.5); /* Dark overlay */
    z-index: -1;
}

/* Heading Styles */
h1 {
    font-size: 40px;
    font-weight: bold;
    margin-top: 50px;
}

/* Subheading */
p {
    font-size: 18px;
    margin-top: 10px;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
}

/* Button */
.button {
    display: inline-block;
    margin-top: 20px;
    padding: 12px 20px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    font-size: 18px;
    border-radius: 5px;
    transition: 0.3s ease-in-out;
}

.button:hover {
    background-color: #0056b3;
}
</style>
</html>
