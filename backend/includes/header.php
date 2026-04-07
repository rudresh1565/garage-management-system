<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$scriptName = str_replace("\\", "/", $_SERVER["SCRIPT_NAME"]);
$baseUrlParts = explode("/backend", $scriptName);
$baseUrl = $baseUrlParts[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : "Garage Management System"; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/frontend/assets/css/style.css">
</head>
<body class="app-shell">
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container py-2">
            <a class="navbar-brand d-flex align-items-center gap-3 fw-bold" href="<?php echo $baseUrl; ?>/backend/dashboard.php">
                <span class="brand-badge">GM</span>
                <span>
                    GarageFlow
                    <small class="d-block text-muted fw-normal">Service command center</small>
                </span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    <li class="nav-item"><a class="nav-link" href="<?php echo $baseUrl; ?>/backend/dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $baseUrl; ?>/backend/customers/index.php">Customers</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $baseUrl; ?>/backend/vehicles/index.php">Vehicles</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $baseUrl; ?>/backend/services/index.php">Services</a></li>
                    <li class="nav-item"><a class="btn btn-primary ms-lg-3" href="<?php echo $baseUrl; ?>/backend/auth/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container py-4 py-lg-5">
