<?php
session_start();
require_once 'header.php';
require_once 'db_connection.php';

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Get internship ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid request!'); window.history.back();</script>";
    exit();
}

$internship_id = $_GET['id'];
$user_id = $_SESSION['id'];

// Check if the user has already applied
$check_sql = "SELECT * FROM applications WHERE user_id = ? AND internship_id = ?";
$stmt = $conn->prepare($check_sql);
$stmt->bind_param("ii", $user_id, $internship_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('You have already applied for this internship.'); window.history.back();</script>";
    exit();
}

// Apply for the internship
$sql = "INSERT INTO applications (user_id, internship_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $internship_id);

if ($stmt->execute()) {
    echo "<script>alert('Application submitted successfully!'); window.location.href='internships.php';</script>";
} else {
    echo "<script>alert('Error submitting application: " . $conn->error . "'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
