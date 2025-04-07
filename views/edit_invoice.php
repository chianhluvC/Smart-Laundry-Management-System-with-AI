<?php
include 'header.php';
require_once '../config/database.php';
require_once '../controllers/ServiceController.php';
require_once '../controllers/AuthController.php';
require_once '../controllers/InvoiceController.php';

$database = new Database();
$conn = $database->getConnection();

$invoiceController = new InvoiceController($conn);
$serviceController = new ServiceController($conn);
$authController = new AuthController($conn);

$services = $serviceController->getAllServices();
$customers = $authController->getUsersByRole('customer');
$employees = $authController->getUsersByRole('employee');

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Thiếu ID hóa đơn");
}
$invoice = $invoiceController->getInvoiceById($id);
$invoiceServices = $invoiceController->getInvoiceServices($id);
?>

<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0"><i class="fas fa-edit me-2"></i>Chỉnh Sửa Hóa Đơn #<?= $invoice['id'] ?></h3>
        </div>
        <div class="card-body">
            <form action="../controllers/InvoiceController.php?action=update" method="POST">
                <input type="hidden" name="invoice_id" value="<?= $invoice['id'] ?>">
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label class="form-label fw-bold"><i class="fas fa-user me-1"></i>Khách Hàng</label>
                            <select name="customer_id" class="form-select" required>
                                <option value="">-- Chọn khách hàng --</option>
                                <?php foreach ($customers as $customer): ?>
                                    <option value="<?= $customer['id'] ?>" <?= $customer['id'] == $invoice['customer_id'] ? 'selected' : '' ?>>
                                        <?= $customer['name'] ?> (ID: <?= $customer['id'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label class="form-label fw-bold"><i class="fas fa-user-tie me-1"></i>Nhân Viên</label>
                            <select name="employee_id" class="form-select" required>
                                <option value="">-- Chọn nhân viên --</option>
                                <?php foreach ($employees as $employee): ?>
                                    <option value="<?= $employee['id'] ?>" <?= $employee['id'] == $invoice['employee_id'] ? 'selected' : '' ?>>
                                        <?= $employee['name'] ?> (ID: <?= $employee['id'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold"><i class="fas fa-calendar me-1"></i>Ngày Nhận</label>
                    <input type="date" name="pickup_date" class="form-control"
                        value="<?= date('Y-m-d', strtotime($invoice['pickup_date'])) ?>" required>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-list-check me-1"></i>Dịch Vụ</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">Chọn</th>
                                        <th width="40%">Tên Dịch Vụ</th>
                                        <th width="25%">Giá (VND/kg)</th>
                                        <th width="30%">Khối Lượng (kg)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($services as $service):
                                        $checked = isset($invoiceServices[$service['id']]);
                                        $weight = $checked ? $invoiceServices[$service['id']] : '';
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input service-checkbox" type="checkbox" 
                                                    name="services[<?= $service['id'] ?>][id]" 
                                                    value="<?= $service['id'] ?>" 
                                                    id="service<?= $service['id'] ?>"
                                                    <?= $checked ? 'checked' : '' ?>>
                                            </div>
                                        </td>
                                        <td>
                                            <label class="form-check-label" for="service<?= $service['id'] ?>">
                                                <?= $service['name'] ?>
                                            </label>
                                        </td>
                                        <td class="text-end"><?= number_format($service['price'], 0) ?></td>
                                        <td>
                                            <div class="input-group">
                                                <input type="number" 
                                                    name="services[<?= $service['id'] ?>][weight]" 
                                                    class="form-control weight-input" 
                                                    placeholder="Nhập kg"
                                                    min="0.1" step="0.1" 
                                                    value="<?= $weight ?>"
                                                    <?= !$checked ? 'disabled' : '' ?>>
                                                <span class="input-group-text">kg</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="manage_invoices.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Quay Lại
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Cập Nhật Hóa Đơn
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enable/disable weight inputs based on checkbox status
    const serviceCheckboxes = document.querySelectorAll('.service-checkbox');
    
    serviceCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const weightInput = this.closest('tr').querySelector('.weight-input');
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