<?php

session_start();
require_once 'db_connection.php';
require_once 'header.php';


// Check if the user is an admin
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch all applications with user and internship details
$sql = "SELECT applications.id, users.name AS applicant_name, users.email, internships.name AS internship_name, internships.company 
        FROM applications
        JOIN users ON applications.user_id = users.id
        JOIN internships ON applications.internship_id = internships.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Applicants</title>
    
</head>
<body>

        
       
  
    <div class="container">
    <h2>Applicants List</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Applicant Name</th>
                <th>Email</th>
                <th>Internship</th>
                <th>Company</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['applicant_name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['internship_name'] ?></td>
                <td><?= $row['company'] ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
<style>table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: white;
}

.container h2 {
    color: blue;
    text-align: center;
    margin-bottom: 20px;
}
th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

th {
    background: #007BFF;
    color: white;
}
body{
    background:rgb(221, 178, 178);
}

tr:nth-child(even) {
    background:rgb(250, 247, 247);
}

.back-button {
    background: #007BFF;
    color: white;
    padding: 10px;
    border: none;
    cursor: pointer;
    margin-bottom: 10px;
}
.back-button:hover {
    background: #0056b3;
}

    </style>
</html>
