<?php
session_start();
include 'db.php';

$message = '';
$token_link = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    $sql    = "SELECT * FROM users WHERE email='".mysqli_real_escape_string($conn, $email)."'";
    $result = mysqli_query($conn, $sql);
    $user   = mysqli_fetch_assoc($result);

    if ($user) {
        $token = bin2hex(random_bytes(16));
        
        // Save token directly to database
        mysqli_query($conn, "UPDATE users SET reset_token='$token' WHERE email='".mysqli_real_escape_string($conn, $email)."'");

        $token_link = "reset_password.php?token=$token&email=".urlencode($email);
        $message = "Reset link generated! Click the link below:";
    } else {
        $message = "No account found with that email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password — Lost & Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="max-width: 450px;">
    <h2 class="mb-4 text-center">Forgot Password</h2>

    <?php if ($message): ?>
        <div class="alert alert-info">
            <?= htmlspecialchars($message) ?>
            <?php if ($token_link): ?>
                <br><br>
                <a href="<?= $token_link ?>">👉 Click here to reset your password</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="forgot_password.php">
        <div class="mb-3">
            <label>Your Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-warning w-100">Send Reset Link</button>
    </form>
    <p class="mt-3 text-center"><a href="login.php">Back to Login</a></p>
</div>
</body>
</html>