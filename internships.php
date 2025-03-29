<?php

include 'db_connection.php'; 
require_once 'header.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT id, title, company, location, duration, stipend, posted_date, description FROM internships ORDER BY posted_date DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Internships</title>
    
</head>
<body>



<main class="internship-container">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="internship-card">
                <h3><?= htmlspecialchars($row['title']); ?></h3>
                <p><strong>Company:</strong> <?= htmlspecialchars($row['company']); ?></p>
                <p><strong>Location:</strong> <?= htmlspecialchars($row['location']); ?></p>
                <p><strong>Duration:</strong> <?= htmlspecialchars($row['duration']); ?></p>
                <p><strong>Stipend:</strong> <?= htmlspecialchars($row['stipend']); ?></p>
                <p><strong>Posted on:</strong> <?= htmlspecialchars($row['posted_date']); ?></p>
                <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($row['description'])); ?></p>
                <a href="apply.php?id=<?= $row['id']; ?>" class="apply-btn">Apply Now</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No internships available at the moment.</p>
    <?php endif; ?>
</main>

</body>

<style>
/* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-image: url('intern3.jpg');
    background:rgb(221, 178, 178);

/* Header */
header {
    background-color: #007bff;
    color: white;
    padding: 15px;
    text-align: center;
}

header h2 {
    margin: 0;
}

/* Back Button */
.back-button {
    background-color: #6c757d;
    color: white;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    border-radius: 5px;
    margin-bottom: 10px;
}

.back-button:hover {
    background-color: #5a6268;
}

/* Internship Container */
.internship-container {
    width: 80%;
    margin: 20px auto;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* Internship Card */
.internship-card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 600px;
    margin-bottom: 20px;
}

.internship-card h3 {
    margin-bottom: 10px;
    color: #007bff;
}

.internship-card p {
    margin: 5px 0; /* Fixed missing semicolon */
    font-size: 14px;
}

/* Apply Button */
.apply-btn {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 15px;
    background-color: #28a745;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.apply-btn:hover {
    background-color: #218838;
}
</style>

</html>
