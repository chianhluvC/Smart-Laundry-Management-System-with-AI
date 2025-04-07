<?php
include 'header.php';
require_once '../config/database.php';
require_once '../controllers/AuthController.php';

$database = new Database();
$conn = $database->getConnection();
$auth = new AuthController($conn);
$customers = $auth->getUsersByRole('customer');
?>

<div class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Quản lý Khách Hàng</h4>
            <a href="create_customer.php" class="btn btn-light">
                <i class="fas fa-plus-circle me-1"></i> Thêm Khách Hàng
            </a>
        </div>
        
        <div class="card-body">
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($_GET['success']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i><?= htmlspecialchars($_GET['error']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">#ID</th>
                            <th>Tên Khách Hàng</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th class="text-center">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($customers) > 0): ?>
                            <?php foreach ($customers as $customer): ?>
                                <tr>
                                    <td class="text-center"><?= $customer['id'] ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-light rounded-circle text-center me-2" style="width: 36px; height: 36px; line-height: 36px;">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <div><?= htmlspecialchars($customer['name']) ?></div>
                                        </div>
                                    </td>
                                    <td>
                                        <i class="fas fa-envelope text-muted me-1"></i>
                                        <?= htmlspecialchars($customer['email']) ?>
                                    </td>
                                    <td>
                                        <i class="fas fa-phone text-muted me-1"></i>
                                        <?= htmlspecialchars($customer['phone']) ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="view_customer.php?id=<?= $customer['id'] ?>" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="edit_customer.php?id=<?= $customer['id'] ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="../controllers/AuthController.php?action=delete&id=<?= $customer['id'] ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Bạn có chắc muốn xóa khách hàng này?');">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-users fa-3x mb-3"></i>
                                        <p>Không có khách hàng nào trong hệ thống.</p>
                                        <a href="create_customer.php" class="btn btn-sm btn-primary">
                                            <i class="fas fa-plus-circle me-1"></i> Thêm khách hàng ngay
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">Hiển thị <?= count($customers) ?> khách hàng</small>
                </div>
                <div>
                    <a href="export_customers.php" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-download me-1"></i> Xuất Excel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>