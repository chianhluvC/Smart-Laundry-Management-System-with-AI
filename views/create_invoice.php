<?php
include 'header.php';
require_once '../config/database.php';
require_once '../controllers/ServiceController.php';
require_once '../controllers/AuthController.php';
$database = new Database();
$conn = $database->getConnection();
$serviceController = new ServiceController($conn);
$services = $serviceController->getAllServices();


$userController = new AuthController($conn);
$customers = $userController->getUsersByRole('customer');
$employees = $userController->getUsersByRole('employee');

// Lấy ngày hiện tại cho trường ngày nhận
$today = date('Y-m-d');
?>

<!-- Bootstrap & Font Awesome CDN nếu chưa có trong header -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    .invoice-form {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin-bottom: 40px;
    }
    
    .page-title {
        color: #2c3e50;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 2px solid #3498db;
        font-weight: 600;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        font-weight: 600;
        color: #34495e;
        margin-bottom: 8px;
        display: block;
    }
    
    .form-control {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px 15px;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 8px rgba(52, 152, 219, 0.3);
    }
    
    select.form-control {
        height: auto;
        padding: 10px 15px;
    }
    
    .section-title {
        color: #2c3e50;
        margin: 30px 0 20px;
        font-weight: 600;
        display: flex;
        align-items: center;
    }
    
    .section-title i {
        margin-right: 10px;
        color: #3498db;
    }
    
    .service-list {
        border: 1px solid #e6e6e6;
        border-radius: 8px;
        padding: 20px;
        background-color: #f9f9f9;
        margin-bottom: 25px;
    }
    
    .service-item {
        margin-bottom: 15px;
        padding: 15px;
        background-color: white;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        transition: all 0.3s;
    }
    
    .service-item:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .service-checkbox {
        margin-right: 15px;
        transform: scale(1.2);
    }
    
    .service-details {
        flex-grow: 1;
    }
    
    .service-name {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 5px;
    }
    
    .service-price {
        color: #7f8c8d;
        font-size: 0.9rem;
    }
    
    .weight-input {
        width: 150px;
        margin-left: 15px;
    }
    
    .btn-create {
        background-color: #2ecc71;
        border: none;
        padding: 12px 25px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s;
        margin-top: 10px;
    }
    
    .btn-create:hover {
        background-color: #27ae60;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
    }
    
    .btn-create i {
        margin-right: 8px;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .service-item {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .weight-input {
            width: 100%;
            margin-left: 0;
            margin-top: 10px;
        }
    }
</style>

<div class="container mt-5">
    <div class="invoice-form">
        <h2 class="page-title"><i class="fas fa-file-invoice"></i> Thêm Hóa Đơn Mới</h2>
        
        <form action="../controllers/InvoiceController.php?action=create" method="POST">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><i class="fas fa-user"></i> Khách Hàng</label>
                        <select name="customer_id" class="form-control" required>
                            <option value="">-- Chọn Khách Hàng --</option>
                            <?php foreach ($customers as $customer): ?>
                                <option value="<?= $customer['id'] ?>"><?= $customer['name'] ?> (ID: <?= $customer['id'] ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label><i class="fas fa-user-tie"></i> Nhân Viên</label>
                        <select name="employee_id" class="form-control" required>
                            <option value="">-- Chọn Nhân Viên --</option>
                            <?php foreach ($employees as $employee): ?>
                                <option value="<?= $employee['id'] ?>"><?= $employee['name'] ?> (ID: <?= $employee['id'] ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><i class="fas fa-calendar-alt"></i> Ngày Nhận</label>
                        <input type="date" name="pickup_date" class="form-control" value="<?= $today ?>" required>
                    </div>
                </div>
            </div>
            
            <h4 class="section-title"><i class="fas fa-list-alt"></i> Chọn Dịch Vụ</h4>
            <div class="service-list" id="service-list">
                <?php foreach ($services as $service): ?>
                    <div class="service-item">
                        <input type="checkbox" name="services[<?= $service['id'] ?>][id]" value="<?= $service['id'] ?>" class="service-checkbox">
                        <div class="service-details">
                            <div class="service-name"><?= $service['name'] ?></div>
                            <div class="service-price"><?= number_format($service['price'], 0, ',', '.') ?> VND/kg</div>
                        </div>
                        <input type="number" name="services[<?= $service['id'] ?>][weight]" class="form-control weight-input" placeholder="Nhập kg" min="0.1" step="0.1">
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="submit" class="btn btn-success btn-create btn-block">
                <i class="fas fa-plus-circle"></i> Tạo Hóa Đơn
            </button>
        </form>
    </div>
</div>

<script>
    // Script để chỉ cho phép nhập trọng lượng khi checkbox được chọn
    document.addEventListener('DOMContentLoaded', function() {
        const serviceItems = document.querySelectorAll('.service-item');
        
        serviceItems.forEach(function(item) {
            const checkbox = item.querySelector('input[type="checkbox"]');
            const weightInput = item.querySelector('input[type="number"]');
            
            // Vô hiệu hóa trường nhập trọng lượng ban đầu
            weightInput.disabled = true;
            
            // Thêm sự kiện cho checkbox
            checkbox.addEventListener('change', function() {
                weightInput.disabled = !this.checked;
                
                if (this.checked) {
                    weightInput.focus();
                } else {
                    weightInput.value = '';
                }
            });
        });
    });
</script>

<?php include 'footer.php'; ?>