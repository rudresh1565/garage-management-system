<?php
function clean_input($value)
{
    return htmlspecialchars(trim($value));
}

function hash_password_value($password)
{
    // Simple SHA-256 hashing keeps the project beginner-friendly.
    return hash("sha256", $password);
}

function status_badge_class($status)
{
    if ($status === "Completed") {
        return "status-pill status-completed";
    }

    if ($status === "In Progress") {
        return "status-pill status-progress";
    }

    if ($status === "Cancelled") {
        return "status-pill status-cancelled";
    }

    return "status-pill status-pending";
}

function format_currency($amount)
{
    return "Rs. " . number_format((float) $amount, 2);
}
?>
