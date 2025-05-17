<?php
require '../includes/session.php';
if (!is_logged_in()) {
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
            color: white;
            overflow: hidden;
        }

        .video-bg {
            position: fixed;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            object-fit: cover;
            z-index: -1;
        }

        .dashboard-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            background: rgba(0, 0, 0, 0.6);
        }

        .dashboard-box {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 40px 30px;
            width: 90%;
            max-width: 500px;
            text-align: center;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        }

        h1 {
            margin-bottom: 30px;
            font-size: 2rem;
        }

        .btn-link {
            display: block;
            background-color: rgba(255, 255, 255, 0.15);
            color: #fff;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 10px;
            margin: 10px 0;
            font-weight: bold;
            transition: background 0.3s, transform 0.2s;
        }

        .btn-link:hover {
            background-color: rgba(255, 255, 255, 0.3);
            transform: scale(1.02);
        }

        @media (max-width: 600px) {
            .dashboard-box {
                padding: 30px 20px;
            }

            h1 {
                font-size: 1.5rem;
            }

            .btn-link {
                font-size: 0.95rem;
                padding: 10px 16px;
            }
        }
    </style>
</head>
<body>

    <!-- Background Video -->
    <video autoplay muted loop class="video-bg">
        <source src="../assets/luffy_bg.webm" type="video/webm">
        Your browser does not support the video tag.
    </video>

    <!-- Dashboard Content -->
    <div class="dashboard-container">
        <div class="dashboard-box">
            <h1>Welcome to your Dashboard!</h1>
            <a class="btn-link" href="../user/update_profile.php">Update Profile</a>
            <a class="btn-link" href="../user/update_password.php">Change Password</a>
            <a class="btn-link" href="../status/activity.php">View Activity</a>
            <a class="btn-link" href="../auth/logout.php">Logout</a>
        </div>
    </div>

</body>
</html>
