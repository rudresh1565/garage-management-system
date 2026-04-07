<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";
require_once "../includes/helpers.php";

$pageTitle = "Services | GarageFlow";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $vehicleId = (int) $_POST["vehicle_id"];
    $serviceType = clean_input($_POST["service_type"]);
    $cost = (float) $_POST["cost"];
    $status = clean_input($_POST["status"]);

    if ($vehicleId > 0 && $serviceType !== "" && $cost >= 0 && $status !== "") {
        $query = "INSERT INTO services (vehicle_id, service_type, cost, status) VALUES ('$vehicleId', '$serviceType', '$cost', '$status')";
        if (mysqli_query($conn, $query)) {
            $success = "Service record added successfully.";
        }
    }
}

$vehicles = mysqli_query(
    $conn,
    "SELECT vehicles.id, vehicles.vehicle_number, vehicles.model, customers.name AS customer_name
     FROM vehicles
     INNER JOIN customers ON vehicles.customer_id = customers.id
     ORDER BY vehicles.id DESC"
);

$services = mysqli_query(
    $conn,
    "SELECT services.id, services.service_type, services.cost, services.status, services.created_at,
            vehicles.vehicle_number, vehicles.model, customers.name AS customer_name
     FROM services
     INNER JOIN vehicles ON services.vehicle_id = vehicles.id
     INNER JOIN customers ON vehicles.customer_id = customers.id
     ORDER BY services.id DESC"
);

include "../includes/header.php";
?>
<section class="row g-4">
    <div class="col-xl-4">
        <div class="form-card p-4">
            <span class="eyebrow mb-3">Service Entry</span>
            <h1 class="h3 mb-3">Add Service Record</h1>
            <p class="text-muted">Capture vehicle work, amount, and live service status.</p>
            <?php if ($success !== "") { ?><div class="alert alert-success"><?php echo $success; ?></div><?php } ?>
            <form action="" method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label class="form-label">Vehicle</label>
                    <select name="vehicle_id" class="form-select" data-required="true" data-message="Please choose a vehicle.">
                        <option value="">Select vehicle</option>
                        <?php while ($vehicle = mysqli_fetch_assoc($vehicles)) { ?>
                            <option value="<?php echo $vehicle["id"]; ?>">
                                <?php echo htmlspecialchars($vehicle["vehicle_number"] . " - " . $vehicle["model"] . " (" . $vehicle["customer_name"] . ")"); ?>
                            </option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Service Type</label>
                    <input type="text" name="service_type" class="form-control" data-required="true" data-message="Service type is required.">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Cost</label>
                    <input type="number" step="0.01" name="cost" class="form-control" data-required="true" data-type="number" data-message="Cost is required.">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" data-required="true" data-message="Please select a status.">
                        <option value="">Select status</option>
                        <option value="Pending">Pending</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Save Service</button>
            </form>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="table-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h2 class="h4 mb-1">Service History</h2>
                    <p class="text-muted mb-0">Track all service records and open bills</p>
                </div>
                <a href="../api/service_records.php" target="_blank" class="btn btn-outline-secondary">API JSON</a>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr><th>ID</th><th>Customer</th><th>Vehicle</th><th>Service</th><th>Cost</th><th>Status</th><th>Bill</th></tr>
                    </thead>
                    <tbody>
                        <?php if ($services && mysqli_num_rows($services) > 0) { ?>
                            <?php while ($service = mysqli_fetch_assoc($services)) { ?>
                                <tr>
                                    <td><?php echo $service["id"]; ?></td>
                                    <td><?php echo htmlspecialchars($service["customer_name"]); ?></td>
                                    <td><strong><?php echo htmlspecialchars($service["vehicle_number"]); ?></strong><br><small class="text-muted"><?php echo htmlspecialchars($service["model"]); ?></small></td>
                                    <td><?php echo htmlspecialchars($service["service_type"]); ?></td>
                                    <td><?php echo format_currency($service["cost"]); ?></td>
                                    <td><span class="<?php echo status_badge_class($service["status"]); ?>"><?php echo $service["status"]; ?></span></td>
                                    <td><a href="bill.php?id=<?php echo $service["id"]; ?>" class="btn btn-sm btn-primary">Generate Bill</a></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr><td colspan="7" class="text-center text-muted py-4">No service records found.</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php include "../includes/footer.php"; ?>
