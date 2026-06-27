<?php
// login.php — Secure Login with lockout

session_start();
include 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // Fetch the user by email
    $sql    = "SELECT * FROM users WHERE email='".mysqli_real_escape_string($conn, $email)."'";
    $result = mysqli_query($conn, $sql);
    $user   = mysqli_fetch_assoc($result);

    if ($user) {
        // --- Check if account is locked ---
        if ($user['failed_attempts'] >= 3 && !empty($user['lockout_time'])) {
            $lockout_until = strtotime($user['lockout_time']) + (15 * 60); // 15 minutes
            if (time() < $lockout_until) {
                $remaining = ceil(($lockout_until - time()) / 60);
                $error = "Account locked. Try again in $remaining minute(s).";
            } else {
                // Lockout expired — reset the counter
                mysqli_query($conn, "UPDATE users SET failed_attempts=0, lockout_time=NULL WHERE id=".$user['id']);
                $user['failed_attempts'] = 0;
            }
        }

        if (empty($error)) {
            // --- Check the password ---
            if (password_verify($password, $user['password'])) {
                // ✅ Correct — reset failed attempts and start session
                mysqli_query($conn, "UPDATE users SET failed_attempts=0, lockout_time=NULL WHERE id=".$user['id']);

                $_SESSION['user_id']   = $user['id'];
                $_SESSION['username']  = $user['username'];
                $_SESSION['email']     = $user['email'];

                header('Location: dashboard.php');
                exit();
            } else {
                // ❌ Wrong password — increment failed attempts
                $new_attempts = $user['failed_attempts'] + 1;

                if ($new_attempts >= 3) {
                    // Lock the account for 15 minutes
                    $lockout_time = date('Y-m-d H:i:s');
                    mysqli_query($conn, "UPDATE users SET failed_attempts=$new_attempts, lockout_time='$lockout_time' WHERE id=".$user['id']);
                    $error = "Too many failed attempts. Account locked for 15 minutes.";
                } else {
                    mysqli_query($conn, "UPDATE users SET failed_attempts=$new_attempts WHERE id=".$user['id']);
                    $left  = 3 - $new_attempts;
                    $error = "Wrong password. $left attempt(s) remaining before lockout.";
                }
            }
        }
    } else {
        $error = "No account found with that email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login — Lost & Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="max-width: 450px;">
    <h2 class="mb-4 text-center">Login</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    <p class="mt-3 text-center">
        <a href="forgot_password.php">Forgot Password?</a> &nbsp;|&nbsp;
        <a href="register.php">Create Account</a>
    </p>
</div>
</body>
</html>