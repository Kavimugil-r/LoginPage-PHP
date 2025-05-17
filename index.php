<?php
require 'includes/session.php';
if (is_logged_in()) {
    header("Location: user/dashboard.php");
} else {
    header("Location: auth/login.php");
}
exit;
?>