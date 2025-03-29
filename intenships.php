
<?php
require_once 'db_connection.php';
require_once 'header.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch internships from the database
$sql = "SELECT * FROM internships ORDER BY posted_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internships - Internship Portal</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <button class="back-button" onclick="history.back()">⬅ Go Back</button>
        <h2>Available Internships</h2>
    </header>

    <div class="internship-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="internship-card">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p><strong>Company:</strong> <?php echo htmlspecialchars($row['company']); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
                    <p><strong>Duration:</strong> <?php echo htmlspecialchars($row['duration']); ?></p>
                    <p><strong>Stipend:</strong> <?php echo htmlspecialchars($row['stipend']); ?></p>
                    <p><strong>Posted on:</strong> <?php echo htmlspecialchars($row['posted_date']); ?></p>
                    <a href="apply.php?id=<?php echo $row['id']; ?>" class="apply-button">Apply Now</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No internships available at the moment.</p>
        <?php endif; ?>
    </div>
</body>
<style>

.internship-container {
    width: 80%;
    margin: 50px auto;
    display: flex;
    flex-direction: column;
    align-items: center;
}

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
    margin: 5px 0;
    font-size: 14px;
}

.apply-button {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 15px;
    background-color: #28a745;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.apply-button:hover {
    background-color: #218838;
}
</style>
</html>