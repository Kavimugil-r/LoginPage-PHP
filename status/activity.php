<?php
require '../config/db.php';
require '../includes/session.php';

if (!is_logged_in()) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT action_type, status, timestamp FROM user_logs WHERE user_id = ? ORDER BY timestamp DESC LIMIT 20");
$stmt->execute([$user_id]);
$logs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recent Activity Logs</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            height: 100%;
            overflow-x: hidden;
        }

        /* Video background */
        .video-bg {
            position: fixed;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            object-fit: cover;
            z-index: -1;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: start;
            min-height: 100vh;
            padding-top: 60px;
            background: rgba(0, 0, 0, 0.6);
        }

        .glass-box {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 30px;
            width: 90%;
            max-width: 900px;
            color: #fff;
            box-shadow: 0 8px 32px 0 rgba(0,0,0,0.37);
            backdrop-filter: blur(10px);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 2rem;
            color: #f2f2f2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px 16px;
            text-align: left;
        }

        th {
            background-color: rgba(255, 255, 255, 0.15);
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.05);
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }

        a.back-link {
            color: #00c2ff;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            font-weight: bold;
            transition: color 0.3s;
        }

        a.back-link:hover {
            color: #66e0ff;
        }

        @media (max-width: 600px) {
            .glass-box {
                padding: 20px;
            }

            table, th, td {
                font-size: 14px;
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

    <!-- Main Content -->
    <div class="container">
        <div class="glass-box">
            <h2>Recent Activity Logs</h2>
            <table>
                <tr><th>Action</th><th>Status</th><th>Time</th></tr>
                <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?= htmlspecialchars($log['action_type']) ?></td>
                    <td><?= htmlspecialchars($log['status']) ?></td>
                    <td><?= htmlspecialchars($log['timestamp']) ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <a class="back-link" href="../user/dashboard.php">← Back to Dashboard</a>
        </div>
    </div>

</body>
</html>
