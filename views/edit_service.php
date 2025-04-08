<?php
require_once '../config/database.php';
require_once '../controllers/ServiceController.php';


$database = new Database();
$conn = $database->getConnection();
$serviceController = new ServiceController($conn);

if (!isset($_GET['id'])) {
    die("Không tìm thấy ID dịch vụ.");
}

$id = $_GET['id'];
$service = $conn->prepare("SELECT * FROM services WHERE id = ?");
$service->execute([$id]);
$service = $service->fetch(PDO::FETCH_ASSOC);

if (!$service) {
    die("Dịch vụ không tồn tại.");
}

// Format price for display
$formattedPrice = number_format($service['price'], 0, ',', '.');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    // Remove formatting from price input
    $price = str_replace('.', '', $_POST['price']);

    if ($serviceController->updateService($id, $name, $price)) {
        header("Location: manage_services.php?success=1");
        exit();
    } else {
        $error = "Cập nhật thất bại!";
    }
}
?>
<?php require_once 'header.php'; ?>
<!-- Improved UI with better styling and price formatting -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="fas fa-edit me-2"></i>Chỉnh Sửa Dịch Vụ</h3>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i><?= $error ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-4">
                            <label for="serviceName" class="form-label fw-bold">Tên Dịch Vụ</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                <input type="text" id="serviceName" name="name" class="form-control form-control-lg" 
                                       value="<?= htmlspecialchars($service['name']) ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="servicePrice" class="form-label fw-bold">Giá (VNĐ)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-money-bill"></i></span>
                                <input type="text" id="servicePrice" name="price" class="form-control form-control-lg" 
                                       value="<?= $formattedPrice ?>" required>
                                <span class="input-group-text">VNĐ</span>
                            </div>
                            <div class="form-text text-muted">Giá sẽ được hiển thị dạng: 1.000.000</div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="service_list.php" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary px-5">
                                <i class="fas fa-save me-2"></i>Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add JavaScript for auto-formatting price input -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const priceInput = document.getElementById('servicePrice');
    
    // Format on blur
    priceInput.addEventListener('blur', function() {
        formatPrice(this);
    });
    
    // Clear formatting on focus
    priceInput.addEventListener('focus', function() {
        // Keep the cursor position reasonable when focusing
        const value = this.value.replace(/\./g, '');
        this.value = value;
    });
    
    // Handle keypress - only allow numbers
    priceInput.addEventListener('keypress', function(e) {
        if (!/^\d$/.test(e.key) && e.key !== 'Backspace' && e.key !== 'Delete' && e.key !== 'ArrowLeft' && e.key !== 'ArrowRight') {
            e.preventDefault();
        }
    });
    
    // Format as user types
    priceInput.addEventListener('input', function() {
        // Remove any non-numeric characters
        let value = this.value.replace(/\D/g, '');
        formatPrice(this);
    });
    
    function formatPrice(input) {
        // Remove existing dots
        let value = input.value.replace(/\./g, '');
        
        // Format with dots for thousands
        if (value !== '') {
            value = parseInt(value, 10);
            input.value = value.toLocaleString('vi-VN');
        }
    }
});
</script>

<?php include 'footer.php'; ?>