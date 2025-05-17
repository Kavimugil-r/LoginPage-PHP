<?php
require '../config/db.php';
require '../includes/session.php';
require '../includes/functions.php';

if (!is_logged_in()) {
    header("Location: ../auth/login.php");
    exit;
}

$message = '';
$alertClass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = $_POST['current'];
    $new = password_hash($_POST['new'], PASSWORD_BCRYPT);
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $stored = $stmt->fetch();

    if ($stored && password_verify($current, $stored['password_hash'])) {
        $pdo->prepare("UPDATE users SET password_hash = ? WHERE user_id = ?")->execute([$new, $user_id]);
        $pdo->prepare("INSERT INTO password_history (user_id, password_hash) VALUES (?, ?)")->execute([$user_id, $new]);
        log_action($pdo, $user_id, 'password_change', 'success');
        $message = '✅ Password updated successfully.';
        $alertClass = 'success';
    } else {
        $message = '❌ Incorrect current password.';
        $alertClass = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            height: 100vh;
            overflow: hidden;
            color: white;
        }

        .video-bg {
            position: fixed;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            object-fit: cover;
            z-index: -1;
        }

        .form-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .form-box {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 15px;
            padding: 40px 30px;
            backdrop-filter: blur(12px);
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            max-width: 400px;
            width: 90%;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        input[type="password"], input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
        }

        input[type="password"] {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        input[type="submit"] {
            background-color: #00aaff;
            color: white;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #007acc;
        }

        .alert {
            margin-top: 15px;
            padding: 10px;
            text-align: center;
            border-radius: 8px;
        }

        .success {
            background-color: rgba(0, 200, 100, 0.3);
            color: #8affc1;
        }

        .error {
            background-color: rgba(255, 0, 0, 0.2);
            color: #ff9999;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #aeefff;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Background Video -->
    <video autoplay muted loop class="video-bg">
        <source src="../assets/luffy_bg.webm" type="video/webm">
        Your browser does not support the video tag.
    </video>

    <div class="form-container">
        <div class="form-box">
            <h2>Change Password</h2>

            <?php if (!empty($message)): ?>
                <div class="alert <?= $alertClass ?>"><?= $message ?></div>
            <?php endif; ?>

            <form method="post">
                <input type="password" name="current" placeholder="Current Password" required>
                <input type="password" name="new" placeholder="New Password" required>
                <input type="submit" value="Change Password">
            </form>

            <a class="back-link" href="dashboard.php">⬅ Back to Dashboard</a>
        </div>
    </div>

</body>
</html>
