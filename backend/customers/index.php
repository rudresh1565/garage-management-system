<?php
require_once "../includes/auth_check.php";
require_once "../config/db.php";
require_once "../includes/helpers.php";

$pageTitle = "Customers | GarageFlow";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = clean_input($_POST["name"]);
    $phone = clean_input($_POST["phone"]);

    if ($name !== "" && $phone !== "") {
        $query = "INSERT INTO customers (name, phone) VALUES ('$name', '$phone')";
        if (mysqli_query($conn, $query)) {
            $success = "Customer added successfully.";
        }
    }
}

$customers = mysqli_query($conn, "SELECT * FROM customers ORDER BY id DESC");

include "../includes/header.php";
?>
<section class="row g-4">
    <div class="col-lg-4">
        <div class="form-card p-4">
            <span class="eyebrow mb-3">Customer Intake</span>
            <h1 class="h3 mb-3">Add Customer</h1>
            <p class="text-muted">Create a simple customer profile with name and phone number.</p>
            <?php if ($success !== "") { ?><div class="alert alert-success"><?php echo $success; ?></div><?php } ?>
            <form action="" method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label class="form-label">Customer Name</label>
                    <input type="text" name="name" class="form-control" data-required="true" data-message="Customer name is required.">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control" data-required="true" data-type="phone" data-message="Phone number is required.">
                    <div class="invalid-feedback"></div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Save Customer</button>
            </form>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="table-card p-4">
            <h2 class="h4 mb-3">Customer List</h2>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr><th>ID</th><th>Name</th><th>Phone</th></tr>
                    </thead>
                    <tbody>
                        <?php if ($customers && mysqli_num_rows($customers) > 0) { ?>
                            <?php while ($customer = mysqli_fetch_assoc($customers)) { ?>
                                <tr>
                                    <td><?php echo $customer["id"]; ?></td>
                                    <td><?php echo htmlspecialchars($customer["name"]); ?></td>
                                    <td><?php echo htmlspecialchars($customer["phone"]); ?></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr><td colspan="3" class="text-center text-muted py-4">No customers added yet.</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php include "../includes/footer.php"; ?>
