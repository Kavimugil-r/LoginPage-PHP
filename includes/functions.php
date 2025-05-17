<?php
// --- File: includes/functions.php ---
function sanitize_input($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function log_action($pdo, $user_id, $type, $status, $details = []) {
    $stmt = $pdo->prepare("INSERT INTO user_logs (user_id, action_type, status, action_details) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $type, $status, json_encode($details)]);
}
?>
