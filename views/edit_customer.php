<?php
include 'header.php';
include '../config/database.php';
include '../controllers/AuthController.php';

$database = new Database();
$conn = $database->getConnection();
$auth = new AuthController($conn);

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: manage_customers.php?error=Thiếu ID khách hàng");
    exit;
}

$customers = $auth->getUsersByRole('customer');
$customer = array_filter($customers, fn($c) => $c['id'] == $id);
$customer = reset($customer);
?>


<div class="customer-edit-section">
    <div class="container mt-5">
        <h2>Chỉnh sửa Khách Hàng</h2>
        <form action="../controllers/AuthController.php" method="POST">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
        <div class="mb-3">
            <label for="username" class="form-label">Tên khách hàng</label>
            <input type="text" name="username" class="form-control" required value="<?= htmlspecialchars($customer['name'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email khách hàng</label>
            <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($customer['email'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại khách hàng</label>
            <input type="text" name="phone" class="form-control" required value="<?= htmlspecialchars($customer['phone'] ?? '') ?>">
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="manage_customers.php" class="btn btn-secondary">Quay lại</a>
    </form>
    </div>
</div>
<?php include 'footer.php'; ?>
<link rel="stylesheet" href="../assets/laundryservice/editcustomer.css">