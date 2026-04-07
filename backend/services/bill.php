<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";
require_once "../includes/helpers.php";

$pageTitle = "Bill | GarageFlow";
$serviceId = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

$query = "SELECT services.id, services.service_type, services.cost, services.status, services.created_at,
                 vehicles.vehicle_number, vehicles.model,
                 customers.name AS customer_name, customers.phone
          FROM services
          INNER JOIN vehicles ON services.vehicle_id = vehicles.id
          INNER JOIN customers ON vehicles.customer_id = customers.id
          WHERE services.id = '$serviceId'
          LIMIT 1";

$result = mysqli_query($conn, $query);
$service = $result ? mysqli_fetch_assoc($result) : null;

$taxRate = 0.18;
$serviceCost = $service ? (float) $service["cost"] : 0;
$taxAmount = $serviceCost * $taxRate;
$totalAmount = $serviceCost + $taxAmount;

include "../includes/header.php";
?>
<?php if ($service) { ?>
    <section class="bill-sheet p-4 p-lg-5">
        <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
            <div>
                <span class="eyebrow mb-3">Service Bill</span>
                <h1 class="h2 mb-1">GarageFlow Invoice</h1>
                <p class="text-muted mb-0">Bill Number: BILL-<?php echo str_pad($service["id"], 4, "0", STR_PAD_LEFT); ?></p>
            </div>
            <div class="text-md-end">
                <div class="fw-semibold">Generated For</div>
                <div><?php echo htmlspecialchars($service["customer_name"]); ?></div>
                <div class="text-muted"><?php echo htmlspecialchars($service["phone"]); ?></div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4"><div class="quick-link-card"><div class="text-muted">Vehicle Number</div><div class="fw-bold"><?php echo htmlspecialchars($service["vehicle_number"]); ?></div></div></div>
            <div class="col-md-4"><div class="quick-link-card"><div class="text-muted">Vehicle Model</div><div class="fw-bold"><?php echo htmlspecialchars($service["model"]); ?></div></div></div>
            <div class="col-md-4"><div class="quick-link-card"><div class="text-muted">Service Status</div><div><span class="<?php echo status_badge_class($service["status"]); ?>"><?php echo $service["status"]; ?></span></div></div></div>
        </div>

        <div class="table-responsive mb-4">
            <table class="table align-middle">
                <thead>
                    <tr><th>Description</th><th class="text-end">Amount</th></tr>
                </thead>
                <tbody>
                    <tr class="bill-row"><td><?php echo htmlspecialchars($service["service_type"]); ?></td><td class="text-end"><?php echo format_currency($serviceCost); ?></td></tr>
                    <tr class="bill-row"><td>GST (18%)</td><td class="text-end"><?php echo format_currency($taxAmount); ?></td></tr>
                    <tr><td class="fw-bold">Total Bill Amount</td><td class="text-end fw-bold"><?php echo format_currency($totalAmount); ?></td></tr>
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-wrap gap-3">
            <button class="btn btn-primary" onclick="window.print()">Print Bill</button>
            <a href="index.php" class="btn btn-outline-secondary">Back to Services</a>
        </div>
    </section>
<?php } else { ?>
    <div class="alert alert-danger">Service record not found.</div>
<?php } ?>
<?php include "../includes/footer.php"; ?>
