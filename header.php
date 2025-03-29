<?php
session_start();
include 'db_connection.php';

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['id']);
$role = $isLoggedIn ? $_SESSION['role'] : null;

if ($isLoggedIn) {
    $id = $_SESSION['id'];

    // Fetch user details
    $sql = "SELECT name, photo FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
    } else {
        $user = ['name' => 'User', 'photo' => null];
    }
}
?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        background: blue;
        color: white;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
    }

    .navbar-left h2 {
        font-size: 22px;
    }

    .navbar-links {
        display: flex;
        align-items: center;
    }

    .navbar-links a {
        color: white;
        text-decoration: none;
        margin: 0 12px;
        font-weight: bold;
        padding: 8px 12px;
        border-radius: 5px;
    }

    .navbar-links a:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .navbar-right {
        display: flex;
        align-items: center;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 5px 12px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 8px;
    }

    .user-info img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid white;
    }
</style>

<header class="navbar">
    <div class="navbar-left">
        <h2>Internship Portal</h2>
    </div>
    
    <nav class="navbar-links">
        <a href="index.php">Home</a>

        <?php if ($isLoggedIn): ?>
            <?php if ($role === 'admin'): ?>
                <a href="admin_dashboard.php">Dashboard</a>
                <a href="post_internship.php">Post Internship</a>
                <a href="view_users.php">View Users</a>
                <a href="view_applicants.php">View Applicants</a>
                <a href="update_appLlication.php">Update Profile</a>
            <?php else: ?>
                <a href="internships.php">Available Internships</a>
                <a href="applied_internships.php">My Applications</a>
                <a href="update_appLlication.php">Update Profile</a>
            <?php endif; ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="internships.php">Internships</a>
            <a href="login.php">Login</a>
            <a href="signup.php">Signup</a>
        <?php endif; ?>
    </nav>

    <?php if ($isLoggedIn): ?>
        <div class="navbar-right">
            <div class="user-info">
                <span><?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($role) ?>)</span>
                <img src="<?= htmlspecialchars($user['photo'] ? 'uploads/' . $user['photo'] : 'profile.png') ?>" alt="Profile Picture">

            </div>
        </div>
    <?php endif; ?>
</header>

<!-- Add padding so content does not hide behind navbar -->
<div style="margin-top: 60px;"></div>
