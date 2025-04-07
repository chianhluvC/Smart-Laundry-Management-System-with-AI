<?php
require_once '../config/database.php';
require_once '../controllers/ServiceController.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: unauthorized.php');
    exit();
}

require_once 'header.php';
$serviceController = new ServiceController($conn);
$services = $serviceController->getAllServices();

// Calculate some statistics
$totalServices = count($services);
$totalValue = 0;
$highestPrice = 0;
$highestPriceService = '';

foreach ($services as $service) {
    $totalValue += $service['price'];
    if ($service['price'] > $highestPrice) {
        $highestPrice = $service['price'];
        $highestPriceService = $service['name'];
    }
}

$averagePrice = $totalServices > 0 ? $totalValue / $totalServices : 0;
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="admin-styles.css">

<div class="container mt-5">
    <div class="page-header">
        <h2>Quản lý Dịch Vụ</h2>
        <a href="add_service.php" class="add-service-btn">
            <i class="fas fa-plus-circle"></i> Thêm dịch vụ mới
        </a>
    </div>
    
    <div class="stats-container">
        <div class="stat-card blue">
            <div class="stat-title">Tổng số dịch vụ</div>
            <div class="stat-value"><?= $totalServices ?></div>
        </div>
        <div class="stat-card green">
            <div class="stat-title">Giá trung bình</div>
            <div class="stat-value"><?= number_format($averagePrice, 0, ',', '.') ?> ₫</div>
        </div>
        <div class="stat-card orange">
            <div class="stat-title">Dịch vụ cao nhất</div>
            <div class="stat-value"><?= number_format($highestPrice, 0, ',', '.') ?> ₫</div>
            <div style="font-size: 0.85rem; color: #718096; margin-top: 5px;"><?= htmlspecialchars($highestPriceService) ?></div>
        </div>
    </div>
    
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 10%;">ID</th>
                    <th style="width: 50%;">Tên Dịch Vụ</th>
                    <th style="width: 20%;">Giá</th>
                    <th style="width: 20%;" class="action-column">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($services)): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 30px;">Không có dịch vụ nào</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($services as $service): ?>
                        <tr>
                            <td><?= $service['id'] ?></td>
                            <td><?= htmlspecialchars($service['name']) ?></td>
                            <td class="price-cell"><?= number_format($service['price'], 0, ',', '.') ?> ₫</td>
                            <td class="action-column">
                                <a href="edit_service.php?id=<?= $service['id'] ?>" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <a href="delete_service.php?id=<?= $service['id'] ?>" class="btn btn-danger" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa dịch vụ này?');">
                                    <i class="fas fa-trash"></i> Xóa
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>

<link rel="stylesheet" href="../assets/laundryservice/service.css">
