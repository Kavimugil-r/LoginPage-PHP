<?php
require '../config/db.php';
require '../includes/session.php';
require '../includes/functions.php';

if (!is_logged_in()) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$message = '';
$alertClass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize_input($_POST['email']);
    $full_name = sanitize_input($_POST['full_name']);

    $stmt = $pdo->prepare("UPDATE users SET email = ?, full_name = ? WHERE user_id = ?");
    $stmt->execute([$email, $full_name, $user_id]);
    log_action($pdo, $user_id, 'account_update', 'success');

    $message = '✅ Profile updated successfully.';
    $alertClass = 'success';
}

$stmt = $pdo->prepare("SELECT full_name, email FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Update Profile</title>
    <style>
        body, html {
            margin: 0; padding: 0;
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
            overflow: hidden;
        }
        .video-bg {
            position: fixed;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            object-fit: cover;
            z-index: -1;
            filter: brightness(0.6);
        }
        .form-container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .form-box {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 15px;
            padding: 40px 30px;
            backdrop-filter: blur(12px);
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            max-width: 400px;
            width: 100%;
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
        }
        input[type="text"],
        input[type="email"],
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            box-sizing: border-box;
        }
        input[type="text"],
        input[type="email"] {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
        input[type="submit"] {
            background-color: #00aaff;
            color: white;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #007acc;
        }
        .alert {
            margin-top: 15px;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
        }
        .success {
            background-color: rgba(0, 200, 100, 0.3);
            color: #8affc1;
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

<video autoplay muted loop class="video-bg">
    <source src="../assets/luffy_bg.webm" type="video/webm">
    Your browser does not support the video tag.
</video>

<div class="form-container">
    <div class="form-box">
        <h2>Update Profile</h2>

        <?php if (!empty($message)): ?>
            <div class="alert <?= $alertClass ?>"><?= $message ?></div>
        <?php endif; ?>

        <form method="post" novalidate>
            <input type="text" name="full_name" placeholder="Full Name" value="<?= htmlspecialchars($user['full_name']) ?>" required>
            <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($user['email']) ?>" required>
            <input type="submit" value="Update Profile">
        </form>

        <a href="dashboard.php" class="back-link">⬅ Back to Dashboard</a>
    </div>
</div>

</body>
</html>
