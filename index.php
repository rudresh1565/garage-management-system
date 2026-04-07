<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: backend/dashboard.php");
    exit();
}

header("Location: backend/auth/login.php");
exit();
