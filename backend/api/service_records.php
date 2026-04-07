<?php
require_once "../config/db.php";

header("Content-Type: application/json");

$services = [];
$query = "SELECT services.id, services.service_type, services.cost, services.status, services.created_at,
                 vehicles.vehicle_number, vehicles.model,
                 customers.name AS customer_name, customers.phone
          FROM services
          INNER JOIN vehicles ON services.vehicle_id = vehicles.id
          INNER JOIN customers ON vehicles.customer_id = customers.id
          ORDER BY services.id DESC";

$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $services[] = $row;
    }
}

echo json_encode(
    [
        "success" => true,
        "count" => count($services),
        "data" => $services
    ],
    JSON_PRETTY_PRINT
);
?>
