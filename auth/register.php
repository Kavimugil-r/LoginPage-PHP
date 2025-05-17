<?php
require '../config/db.php';
require '../includes/session.php';
require '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitize_input($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = sanitize_input($_POST['email']);
    $full_name = sanitize_input($_POST['full_name']);

    $stmt = $pdo->prepare("INSERT INTO users (username, password_hash, email, full_name) VALUES (?, ?, ?, ?)");
    try {
        $stmt->execute([$username, $password, $email, $full_name]);
        echo "<script>alert('Registration successful! Redirecting to login...'); window.location.href = 'login.php';</script>";
        exit;
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | MyApp</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            overflow: hidden;
        }

        video.bg-video {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            object-fit: cover;
            z-index: -1;
            filter: brightness(0.5);
        }

        .form-wrapper {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 40px;
            width: 350px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
            color: #fff;
            animation: fadeIn 1.2s ease-in-out;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 10px 12px;
            font-size: 1em;
            border: none;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .form-group input::placeholder {
            color: #ddd;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-container input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #00c6ff;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 1em;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .form-container input[type="submit"]:hover {
            background-color: #0072ff;
        }

        .form-container p {
            text-align: center;
            margin-top: 15px;
            color: #eee;
        }

        .form-container a {
            color: #00c6ff;
            text-decoration: none;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media screen and (max-width: 420px) {
            .form-container {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <video class="bg-video" autoplay muted loop>
        <source src="../assets/luffy_bg.webm" type="video/webm">
        Your browser does not support the video tag.
    </video>

    <div class="form-wrapper">
        <form class="form-container" method="post">
            <h2>Create Account</h2>

            <?php if (!empty($error)) echo "<p style='color: #ff8c8c;'>$error</p>"; ?>

            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" name="full_name" id="full_name" required placeholder="Your full name">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required placeholder="example@domain.com">
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required placeholder="Choose a username">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required placeholder="********">
            </div>

            <input type="submit" value="Register">

            <p>Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>
</body>
</html>
