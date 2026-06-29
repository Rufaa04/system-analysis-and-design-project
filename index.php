<?php
// index.php — Home/Landing Page
session_start();

// If already logged in, send them straight to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lost & Found System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .hero {
            text-align: center;
            padding: 100px 20px;
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
            color: #0d6efd;
        }
        .hero p {
            font-size: 1.2rem;
            color: #6c757d;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>

<div class="container hero">
    <h1>🔍 Lost & Found System</h1>
    <p>Have you lost something? Or found something? <br> Report it here and help your fellow students!</p>

    <a href="login.php" class="btn btn-primary btn-lg me-3">Login</a>
    <a href="register.php" class="btn btn-outline-primary btn-lg">Register</a>
</div>

</body>
</html>