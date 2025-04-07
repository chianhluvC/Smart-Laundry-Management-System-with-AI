<?php
require_once '../config/database.php';
require_once '../controllers/ServiceController.php';
require_once 'header.php';

$database = new Database();
$conn = $database->getConnection();
$serviceController = new ServiceController($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];

    if ($serviceController->addService($name, $price)) {
        header("Location: manage_services.php?success=1");
        exit();
    } else {
        $error = "Thêm dịch vụ thất bại!";
    }
}
?>

<!-- Thêm CSS -->
<style>
    .service-form-container {
        max-width: 600px;
        margin: 0 auto;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }
    
    .page-title {
        color: #2c3e50;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #3498db;
        position: relative;
        font-weight: 600;
    }
    
    .page-title:before {
        content: '';
        position: absolute;
        width: 50px;
        height: 3px;
        background-color: #2ecc71;
        bottom: -2px;
        left: 0;
    }
    
    .form-group {
        margin-bottom: 25px;
    }
    
    .form-label {
        font-weight: 600;
        color: #34495e;
        margin-bottom: 8px;
        display: block;
    }
    
    .form-control {
        height: auto;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        transition: all 0.3s;
        font-size: 15px;
    }
    
    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 8px rgba(52, 152, 219, 0.3);
    }
    
    .input-icon-wrapper {
        position: relative;
    }
    
    .input-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #7f8c8d;
    }
    
    .input-with-icon {
        padding-left: 40px;
    }
    
    .btn {
        padding: 12px 24px;
        border-radius: 5px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s;
    }
    
    .btn-success {
        background-color: #2ecc71;
        border: none;
    }
    
    .btn-success:hover, .btn-success:focus {
        background-color: #27ae60;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
    }
    
    .btn-secondary {
        background-color: #95a5a6;
        border: none;
    }
    
    .btn-secondary:hover, .btn-secondary:focus {
        background-color: #7f8c8d;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(127, 140, 141, 0.3);
    }
    
    .btn-icon {
        margin-right: 8px;
    }
    
    .form-buttons {
        display: flex;
        gap: 10px;
        margin-top: 30px;
    }
    
    .alert {
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }
    
    .alert-danger {
        background-color: #ffebee;
        color: #c62828;
        border-left: 4px solid #c62828;
    }
    
    .alert-icon {
        margin-right: 10px;
        font-size: 20px;
    }
    
    /* Chỉnh sửa form giá */
    .price-group {
        position: relative;
    }
    
    .price-group .currency-label {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #7f8c8d;
        font-weight: 600;
    }
    
    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-in {
        animation: fadeIn 0.5s ease-out forwards;
    }
</style>

<!-- Thêm Font Awesome nếu chưa có trong header -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<div class="container mt-5 animate-in">
    <div class="service-form-container">
        <h2 class="page-title">
            <i class="fas fa-plus-circle mr-2" style="color: #3498db;"></i>
            Thêm Dịch Vụ Mới
        </h2>
        
        <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle alert-icon"></i>
            <span><?php echo $error; ?></span>
        </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-tag mr-1" style="color: #3498db;"></i>
                    Tên Dịch Vụ
                </label>
                <div class="input-icon-wrapper">
                    <input type="text" name="name" class="form-control input-with-icon" 
                           required placeholder="Nhập tên dịch vụ (ví dụ: Giặt ủi cao cấp)">
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-money-bill-wave mr-1" style="color: #3498db;"></i>
                    Giá Dịch Vụ
                </label>
                <div class="price-group">
                    <div class="input-icon-wrapper">
                        <input type="number" name="price" class="form-control input-with-icon" 
                               required placeholder="Nhập giá dịch vụ" min="0" step="1000">
                        <span class="currency-label">VNĐ</span>
                    </div>
                </div>
                <small class="text-muted mt-2 d-block">Giá dịch vụ tính theo đơn vị VNĐ/kg.</small>
            </div>
            
            <div class="form-buttons">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save btn-icon"></i>Thêm Dịch Vụ
                </button>
                <a href="manage_services.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left btn-icon"></i>Quay Lại
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Định dạng số tiền khi người dùng nhập
    document.querySelector('input[name="price"]').addEventListener('input', function(e) {
        // Loại bỏ tất cả ký tự không phải số
        let value = this.value.replace(/\D/g, '');
        
        // Đảm bảo giá trị hợp lệ
        if (value === '') {
            this.value = '';
            return;
        }
        
        // Chuyển về số để tránh các số 0 ở đầu
        let numValue = parseInt(value, 10);
        this.value = numValue;
    });
</script>

<?php include 'footer.php'; ?>