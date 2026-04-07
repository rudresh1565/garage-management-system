<?php
session_start();
require_once "../config/db.php";
require_once "../includes/helpers.php";

$scriptName = str_replace("\\", "/", $_SERVER["SCRIPT_NAME"]);
$baseUrlParts = explode("/backend", $scriptName);
$baseUrl = $baseUrlParts[0];

if (isset($_SESSION["user_id"])) {
    header("Location: ../dashboard.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = clean_input($_POST["username"]);
    $password = clean_input($_POST["password"]);
    $passwordHash = hash_password_value($password);

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$passwordHash' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];

        header("Location: ../dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | GarageFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/frontend/assets/css/style.css">
</head>
<body>
    <div class="container-fluid login-layout px-0">
        <div class="row g-0 min-vh-100">
            <div class="col-lg-7 login-showcase d-flex align-items-end align-items-lg-center">
                <div class="login-copy p-4 p-md-5">
                    <span class="eyebrow mb-3">Garage Intelligence</span>
                    <h1 class="display-5 fw-bold mb-3">Run your workshop like a premium service desk.</h1>
                    <p class="lead mb-4">Track customers, vehicles, services, and quick bills from one crisp dashboard made for a college-ready garage system.</p>
                    <div class="row g-3">
                        <div class="col-sm-4">
                            <div class="glass-card p-3 h-100">
                                <div class="fw-bold fs-4">01</div>
                                <div>Fast customer intake</div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="glass-card p-3 h-100">
                                <div class="fw-bold fs-4">02</div>
                                <div>Service tracking with status</div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="glass-card p-3 h-100">
                                <div class="fw-bold fs-4">03</div>
                                <div>Instant bill preview</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-flex align-items-center justify-content-center p-4 p-lg-5">
                <div class="login-card form-card p-4 p-lg-5">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="brand-badge">GM</span>
                        <div>
                            <h2 class="h3 mb-0">GarageFlow</h2>
                            <p class="text-muted mb-0">Sign in to continue</p>
                        </div>
                    </div>

                    <?php if ($error !== "") { ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php } ?>

                    <form action="" method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" data-required="true" data-message="Username is required.">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" data-required="true" data-message="Password is required.">
                            <div class="invalid-feedback"></div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>

                    <div class="mt-4 p-3 rounded-4" style="background: rgba(187, 90, 42, 0.08);">
                        <div class="fw-semibold">Demo Login</div>
                        <small class="text-muted">Username: <strong>admin</strong> | Password: <strong>admin123</strong></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo $baseUrl; ?>/frontend/assets/js/validation.js"></script>
</body>
</html>
