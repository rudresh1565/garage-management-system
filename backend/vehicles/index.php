<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";
require_once "../includes/helpers.php";

$pageTitle = "Vehicles | GarageFlow";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $customerId = (int) $_POST["customer_id"];
    $vehicleNumber = clean_input($_POST["vehicle_number"]);
    $model = clean_input($_POST["model"]);

    if ($customerId > 0 && $vehicleNumber !== "" && $model !== "") {
        $query = "INSERT INTO vehicles (customer_id, vehicle_number, model) VALUES ('$customerId', '$vehicleNumber', '$model')";
        if (mysqli_query($conn, $query)) {
            $success = "Vehicle added successfully.";
        }
    }
}

$customers = mysqli_query($conn, "SELECT id, name FROM customers ORDER BY name ASC");
$vehicles = mysqli_query(
    $conn,
    "SELECT vehicles.id, vehicles.vehicle_number, vehicles.model, customers.name AS customer_name
     FROM vehicles
     INNER JOIN customers ON vehicles.customer_id = customers.id
     ORDER BY vehicles.id DESC"
);

include "../includes/header.php";
?>
<section class="row g-4">
    <div class="col-lg-4">
        <div class="form-card p-4">
            <span class="eyebrow mb-3">Vehicle Registry</span>
            <h1 class="h3 mb-3">Add Vehicle</h1>
            <p class="text-muted">Link each vehicle to a customer for clean service tracking.</p>
            <?php if ($success !== "") { ?><div class="alert alert-success"><?php echo $success; ?></div><?php } ?>
            <form action="" method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label class="form-label">Customer</label>
                    <select name="customer_id" class="form-select" data-required="true" data-message="Please choose a customer.">
                        <option value="">Select customer</option>
                        <?php while ($customer = mysqli_fetch_assoc($customers)) { ?>
                            <option value="<?php echo $customer["id"]; ?>"><?php echo htmlspecialchars($customer["name"]); ?></option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Vehicle Number</label>
                    <input type="text" name="vehicle_number" class="form-control" data-required="true" data-message="Vehicle number is required.">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Vehicle Model</label>
                    <input type="text" name="model" class="form-control" data-required="true" data-message="Vehicle model is required.">
                    <div class="invalid-feedback"></div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Save Vehicle</button>
            </form>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="table-card p-4">
            <h2 class="h4 mb-3">Vehicle List</h2>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr><th>ID</th><th>Customer</th><th>Vehicle Number</th><th>Model</th></tr>
                    </thead>
                    <tbody>
                        <?php if ($vehicles && mysqli_num_rows($vehicles) > 0) { ?>
                            <?php while ($vehicle = mysqli_fetch_assoc($vehicles)) { ?>
                                <tr>
                                    <td><?php echo $vehicle["id"]; ?></td>
                                    <td><?php echo htmlspecialchars($vehicle["customer_name"]); ?></td>
                                    <td><?php echo htmlspecialchars($vehicle["vehicle_number"]); ?></td>
                                    <td><?php echo htmlspecialchars($vehicle["model"]); ?></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr><td colspan="4" class="text-center text-muted py-4">No vehicles added yet.</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php include "../includes/footer.php"; ?>
