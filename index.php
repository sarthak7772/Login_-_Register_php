<?php
session_start();

$name = $_SESSION['name'] ?? null;
$alerts = $_SESSION['alerts'] ?? [];
$active_form = $_SESSION['active_form'] ?? '';

// Clear alerts and active form after fetching
unset($_SESSION['alerts'], $_SESSION['active_form']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login/Register Modal</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Inline styles for alert visibility -->
    <style>
        .alerts-container {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 9999;
            max-width: 300px;
        }
        .alert {
            padding: 12px 18px;
            border-radius: 5px;
            margin-bottom: 10px;
            font-weight: bold;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .alert.success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>

<header>
    <a href="#" class="logo">logo</a>
    <nav>
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Collection</a>
        <a href="#">Contact</a>
    </nav>
    <div class="user-auth">
        <?php if ($name): ?>
            <div class="profile-box">
                <div class="avatar-circle"><?= strtoupper($name[0]); ?></div>
                <div class="dropdown">
                    <a href="#">My Account</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        <?php else: ?>
            <button type="button" class="login-btn-modal">Login</button>
        <?php endif; ?>
    </div>
</header>

<section>
    <h1>Hey <?= htmlspecialchars($name ?? 'User') ?>!<br>by SD</h1>
</section>

<!-- Display alerts -->
<?php if (!empty($alerts)): ?>
    <div class="alerts-container">
        <?php foreach ($alerts as $alert): ?>
            <div class="alert <?= htmlspecialchars($alert['type']) ?>">
                <?= htmlspecialchars($alert['message']) ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Modal -->
<div class="auth-modal <?= !empty($active_form) ? 'active show slide' : '' ?>">
    <button type="button" class="close-btn-modal"><i class="fa-solid fa-xmark"></i></button>

    <!-- Login Form -->
    <div class="form-box login <?= $active_form === 'login' || empty($active_form) ? 'active' : '' ?>">
        <h2>Login</h2>
        <form action="auth.php" method="POST">
            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required />
                <i class="fa-solid fa-envelope"></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required />
                <i class="fa-solid fa-lock"></i>
            </div>
            <button type="submit" name="login_btn" class="btn">Login</button>
            <p>Don't have an account? <a href="#" class="register-link">Register</a></p>
        </form>
    </div>

    <!-- Register Form -->
    <div class="form-box register <?= $active_form === 'register' ? 'active slide' : '' ?>">
        <h2>Register</h2>
        <form action="auth.php" method="POST">
            <div class="input-box">
                <input type="text" name="name" placeholder="Name" required />
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required />
                <i class="fa-solid fa-envelope"></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required />
                <i class="fa-solid fa-lock"></i>
            </div>
            <button type="submit" name="register_btn" class="btn">Register</button>
            <p>Already have an account? <a href="#" class="login-link">Login</a></p>
        </form>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>
