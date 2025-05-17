<?php
require '../config/db.php';
require '../includes/session.php';

if (is_logged_in()) {
    $user_id = $_SESSION['user_id'];

    // Log the logout
    $log = $pdo->prepare("INSERT INTO user_logs (user_id, action_type, status) VALUES (?, 'logout', 'success')");
    $log->execute([$user_id]);
}

session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logging Out...</title>
    <meta http-equiv="refresh" content="3;url=login.php">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            background: linear-gradient(135deg, #1d2b64, #f8cdda);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Outfit', sans-serif;
            color: white;
        }

        .logout-container {
            text-align: center;
            animation: fadeIn 1.2s ease-in-out;
        }

        .logout-container h1 {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .logout-container p {
            font-size: 1em;
            opacity: 0.8;
        }

        .loader {
            margin: 30px auto;
            width: 60px;
            height: 60px;
            border: 5px solid rgba(255, 255, 255, 0.2);
            border-top: 5px solid #ffffff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <h1>Logging you out...</h1>
        <p>Thank you for visiting. See you again soon! 😊</p>
        <div class="loader"></div>
        <p>Redirecting to login page...</p>
    </div>
</body>
</html>
