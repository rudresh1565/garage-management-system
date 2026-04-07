<?php
require_once "includes/auth_check.php";
require_once "config/db.php";
require_once "includes/helpers.php";

$pageTitle = "Dashboard | GarageFlow";

$customerCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM customers"));
$vehicleCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM vehicles"));
$serviceCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM services"));
$revenueData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(cost) AS total_revenue FROM services WHERE status = 'Completed'"));

$latestServices = mysqli_query(
    $conn,
    "SELECT services.id, services.service_type, services.status, services.cost, vehicles.vehicle_number, customers.name AS customer_name
     FROM services
     INNER JOIN vehicles ON services.vehicle_id = vehicles.id
     INNER JOIN customers ON vehicles.customer_id = customers.id
     ORDER BY services.id DESC
     LIMIT 5"
);

include "includes/header.php";
?>
<section class="hero-card p-4 p-lg-5 mb-4">
    <div class="row align-items-center g-4">
        <div class="col-lg-7">
            <span class="eyebrow mb-3">Workshop Dashboard</span>
            <h1 class="section-title mb-3">Welcome back, <?php echo htmlspecialchars($_SESSION["username"]); ?>.</h1>
            <p class="lead text-muted mb-4">Keep the service floor moving with one place for customers, vehicles, live jobs, and billing snapshots.</p>
            <div class="d-flex flex-wrap gap-3">
                <a href="customers/index.php" class="btn btn-primary">Add Customer</a>
                <a href="services/index.php" class="btn btn-outline-secondary">Manage Services</a>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="row g-3">
                <div class="col-6"><div class="metric-card"><div class="metric-label">Customers</div><div class="metric-value"><?php echo $customerCount["total"]; ?></div></div></div>
                <div class="col-6"><div class="metric-card"><div class="metric-label">Vehicles</div><div class="metric-value"><?php echo $vehicleCount["total"]; ?></div></div></div>
                <div class="col-6"><div class="metric-card"><div class="metric-label">Service Jobs</div><div class="metric-value"><?php echo $serviceCount["total"]; ?></div></div></div>
                <div class="col-6"><div class="metric-card"><div class="metric-label">Revenue</div><div class="metric-value">Rs. <?php echo number_format((float) $revenueData["total_revenue"], 0); ?></div></div></div>
            </div>
        </div>
    </div>
</section>

<section class="row g-4 mb-4">
    <div class="col-md-4"><a href="customers/index.php" class="quick-link"><div class="quick-link-card"><div class="fw-bold fs-5 mb-2">Customer Desk</div><p class="text-muted mb-0">Register new customers and browse the master list.</p></div></a></div>
    <div class="col-md-4"><a href="vehicles/index.php" class="quick-link"><div class="quick-link-card"><div class="fw-bold fs-5 mb-2">Vehicle Bay</div><p class="text-muted mb-0">Link vehicles to owners and track garage intake.</p></div></a></div>
    <div class="col-md-4"><a href="services/index.php" class="quick-link"><div class="quick-link-card"><div class="fw-bold fs-5 mb-2">Service Control</div><p class="text-muted mb-0">Add service records, update status, and generate bills.</p></div></a></div>
</section>

<section class="table-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="h4 mb-1">Recent Service Activity</h2>
            <p class="text-muted mb-0">Latest workshop updates at a glance</p>
        </div>
        <a href="api/service_records.php" target="_blank" class="btn btn-outline-secondary">View JSON API</a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Vehicle</th>
                    <th>Service</th>
                    <th>Status</th>
                    <th>Cost</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($latestServices && mysqli_num_rows($latestServices) > 0) { ?>
                    <?php while ($service = mysqli_fetch_assoc($latestServices)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($service["customer_name"]); ?></td>
                            <td><?php echo htmlspecialchars($service["vehicle_number"]); ?></td>
                            <td><?php echo htmlspecialchars($service["service_type"]); ?></td>
                            <td><span class="<?php echo status_badge_class($service["status"]); ?>"><?php echo $service["status"]; ?></span></td>
                            <td>Rs. <?php echo number_format((float) $service["cost"], 2); ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr><td colspan="5" class="text-center text-muted py-4">No service records yet.</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>
<?php include "includes/footer.php"; ?>
