<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lost & Found — Riara University</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1a1a2e, #16213e, #0f3460);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .card-box {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 60px 50px;
            text-align: center;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }

        .icon {
            font-size: 70px;
            margin-bottom: 10px;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        h1 {
            font-size: 2.2rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 5px;
        }

        .subtitle {
            color: #a0aec0;
            font-size: 0.95rem;
            margin-bottom: 15px;
        }

        .divider {
            border: none;
            height: 2px;
            background: linear-gradient(to right, transparent, #0d6efd, transparent);
            margin: 20px 0;
        }

        .tagline {
            color: #cbd5e0;
            font-size: 1rem;
            margin-bottom: 35px;
            line-height: 1.6;
        }

        .btn-login {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            border: none;
            color: white;
            padding: 12px 40px;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            margin: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(13, 110, 253, 0.4);
            color: white;
        }

        .btn-register {
            background: transparent;
            border: 2px solid #0d6efd;
            color: #0d6efd;
            padding: 12px 40px;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            margin: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-register:hover {
            background: #0d6efd;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(13, 110, 253, 0.4);
        }

        .footer-text {
            margin-top: 30px;
            color: #718096;
            font-size: 0.8rem;
        }

        .stats {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 20px 0;
        }

        .stat {
            color: #a0aec0;
            font-size: 0.85rem;
        }

        .stat span {
            display: block;
            color: #ffffff;
            font-size: 1.4rem;
            font-weight: 700;
        }
    </style>
</head>
<body>

<div class="card-box">
    <div class="icon">🔍</div>
    <h1>Lost & Found</h1>
    <p class="subtitle">Riara University Students</p>

    <hr class="divider">

    <p class="tagline">
        Lost something on campus? Found something that isn't yours?<br>
        <strong style="color:#fff;">We've got you covered.</strong>
    </p>

    <div class="stats">
        <div class="stat"><span>📦</span>Lost Items</div>
        <div class="stat"><span>✅</span>Found Items</div>
        <div class="stat"><span>🤝</span>Reunited</div>
    </div>

    <hr class="divider">

    <a href="login.php" class="btn-login">🔐 Login</a>
    <a href="register.php" class="btn-register"> Register</a>

    <p class="footer-text">SAD Group Project &copy; 2026  Riara University</p>
</div>

</body>
</html>