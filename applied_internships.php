<?php

require_once 'header.php';
require_once 'db_connection.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

// Fetch applied internships with full details
$sql = "SELECT internships.title, internships.company, internships.location, 
               internships.duration, internships.stipend, internships.posted_date, 
               internships.description, applications.applied_date 
        FROM applications 
        JOIN internships ON applications.internship_id = internships.id 
        WHERE applications.user_id = ?";


$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Applications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background:rgb(221, 178, 178);
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #007BFF;
            color: white;
            text-align: center;
            padding: 15px 0;
            font-size: 24px;
        }

        .internship-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }

        .internship-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        h3 {
            color: #007BFF;
            margin-bottom: 10px;
        }

        p {
            margin: 5px 0;
            color: #333;
        }

        strong {
            color: #555;
        }
    </style>
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
                    <p><strong>Applied on:</strong> <?= htmlspecialchars($row['applied_date']); ?></p>
                    <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($row['description'])); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>You haven't applied for any internships yet.</p>
        <?php endif; ?>
    </main>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
