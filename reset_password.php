<?php
include 'db.php';

$error   = '';
$success = '';

// Get token and email from URL
$token = $_GET['token'] ?? '';
$email = $_GET['email'] ?? '';

if (empty($token) || empty($email)) {
    die("Invalid reset link. <a href='forgot_password.php'>Try again</a>");
}

// Check token matches in database
$sql    = "SELECT * FROM users WHERE email='".mysqli_real_escape_string($conn, $email)."' AND reset_token='".mysqli_real_escape_string($conn, $token)."'";
$result = mysqli_query($conn, $sql);
$user   = mysqli_fetch_assoc($result);

if (!$user) {
    die("Invalid or expired reset link. <a href='forgot_password.php'>Try again</a>");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password     = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (strlen($new_password) < 6) {
        $error = "Password must be at least 6 characters.";
    } elseif ($new_password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE users SET password='$hashed', failed_attempts=0, lockout_time=NULL, reset_token=NULL WHERE email='".mysqli_real_escape_string($conn, $email)."'");
        $success = "Password updated! You can now login.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password — Lost & Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="max-width: 450px;">
    <h2 class="mb-4 text-center">Reset Password</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success">
            <?= $success ?> <a href="login.php">Login here</a>
        </div>
    <?php else: ?>
    <form method="POST" action="reset_password.php?token=<?= htmlspecialchars($token) ?>&email=<?= urlencode($email) ?>">
        <div class="mb-3">
            <label>New Password</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Confirm New Password</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Update Password</button>
    </form>
    <?php endif; ?>

    <p class="mt-3 text-center"><a href="forgot_password.php">Back</a></p>
</div>
</body>
</html>