<?php
// Include database connection
require_once 'db_connection.php';
require_once 'header.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $application_id = $_POST['application_id'];
    $status = $_POST['status'];

    // Update application status
    $sql = "UPDATE applications SET status='$status' WHERE id=$application_id";
    if ($conn->query($sql) === TRUE) {
        echo "Application updated successfully!";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Fetch applications
$sql = "SELECT applications.id, users.name AS applicant, internships.name AS internship, applications.status 
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
    <title>Update Applications</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <button class="back-button" onclick="window.history.back();">Go Back</button>
        <h2>Update Application Status</h2>
    </header>
    <div class="container">
        <table>
            <tr>
                <th>Applicant</th>
                <th>Internship</th>
                <th>Status</th>
                <th>Update</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['applicant']; ?></td>
                <td><?php echo $row['internship']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <form method="POST" action="update_application.php">
                        <input type="hidden" name="application_id" value="<?php echo $row['id']; ?>">
                        <select name="status">
                            <option value="Pending" <?php if ($row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                            <option value="Approved" <?php if ($row['status'] == 'Approved') echo 'selected'; ?>>Approved</option>
                            <option value="Rejected" <?php if ($row['status'] == 'Rejected') echo 'selected'; ?>>Rejected</option>
                        </select>
                        <button type="submit">Update</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>


<style>
    /* General styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

/* Header */
header {
    background-color: #007bff;
    color: white;
    padding: 15px;
    text-align: center;
    position: relative;
}

/* Back button */
.back-button {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    background-color: white;
    color: #007bff;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    border-radius: 5px;
    font-weight: bold;
}

.back-button:hover {
    background-color: #e0e0e0;
}

/* Container */
.container {
    width: 90%;
    max-width: 800px;
    margin: 30px auto;
    background: white;
    padding: 20px;
    box-shadow: 0 0 10px rgba(12, 12, 12, 0.1);
    border-radius: 5px;
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
}

th {
    background-color: #007bff;
    color: white;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Form inside the table */
form {
    display: flex;
    justify-content: center;
    align-items: center;
}

select {
    padding: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

/* Update button */
button {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 6px 10px;
    margin-left: 8px;
    cursor: pointer;
    border-radius: 5px;
}

button:hover {
    background-color: #218838;
}

    </style>
</html>
