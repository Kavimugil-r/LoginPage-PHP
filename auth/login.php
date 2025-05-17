<?php
require '../config/db.php';
require '../includes/session.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT user_id, password_hash FROM users WHERE username = ? AND is_active = 1");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['user_id'];

        // Log the login action
        $log = $pdo->prepare("INSERT INTO user_logs (user_id, action_type, status) VALUES (?, 'login', 'success')");
        $log->execute([$user['user_id']]);

        header("Location: ../user/dashboard.php");
        exit;
    } else {
        $error = "Invalid credentials or inactive account.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Your App</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0; padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body, html {
            height: 100%;
            overflow: hidden;
        }
        video.bg-video {
            position: fixed;
            top: 0; left: 0;
            width: 100vw;
            height: 100vh;
            object-fit: cover;
            z-index: -1;
            filter: brightness(60%);
        }
        .login-container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            border-radius: 15px;
            padding: 40px 30px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
            width: 300px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }
        .login-box h2 {
            margin-bottom: 20px;
            color: #fff;
        }
        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            outline: none;
        }
        .login-box input[type="submit"] {
            width: 100%;
            background: #00aaff;
            color: white;
            padding: 10px;
            border: none;
            margin-top: 15px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .login-box input[type="submit"]:hover {
            background: #0077cc;
        }
        .login-box p {
            color: white;
            margin-top: 15px;
        }
        .login-box a {
            color: #00ffdd;
            text-decoration: none;
            transition: color 0.2s;
        }
        .login-box a:hover {
            color: #ffffff;
        }
        .error {
            color: #ff4444;
            margin-bottom: 10px;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        @media screen and (max-width: 400px) {
            .login-box {
                width: 90%;
            }
        }
    </style>
</head>
<body>

<video autoplay muted loop class="bg-video">
    <source src="https://www.w3schools.com/howto/rain.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>

<div class="login-container">
    <div class="login-box">
        <h2>Welcome Back 👋</h2>
        <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</div>

</body>
</html>
