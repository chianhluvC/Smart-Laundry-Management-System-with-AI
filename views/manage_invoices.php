<?php
include 'header.php';
require_once '../controllers/InvoiceController.php';
$database = new Database();
$conn = $database->getConnection();
$invoiceController = new InvoiceController($conn);
$invoices = $invoiceController->getAllInvoices();

// Calculate summary statistics
$totalInvoices = count($invoices);
$totalAmount = 0;
$thisMonth = 0;
$pendingInvoices = 0;

$currentMonth = date('m');
$currentYear = date('Y');

foreach ($invoices as $invoice) {
    $totalAmount += $invoice['total_amount'];
    
    $invoiceDate = new DateTime($invoice['pickup_date']);
    if ($invoiceDate->format('m') == $currentMonth && $invoiceDate->format('Y') == $currentYear) {
        $thisMonth += $invoice['total_amount'];
    }
    
    // Assume an invoice is pending if pickup date is in the future
    if (strtotime($invoice['pickup_date']) > time()) {
        $pendingInvoices++;
    }
}
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="invoice-styles.css">

<div class="container mt-5">
    <div class="dashboard-header">
        <h2>Quản lý Hóa Đơn</h2>
        <a href="create_invoice.php" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Thêm Hóa Đơn Mới
        </a>
    </div>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?= htmlspecialchars($_GET['success']) ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>
    
    <div class="summary-cards">
        <div class="summary-card blue">
            <div class="summary-title">Tổng Số Hóa Đơn</div>
            <div class="summary-value"><?= $totalInvoices ?></div>
        </div>
        
        <div class="summary-card green">
            <div class="summary-title">Tổng Doanh Thu</div>
            <div class="summary-value"><?= number_format($totalAmount, 0, ',', '.') ?> ₫</div>
        </div>
        
        <div class="summary-card orange">
            <div class="summary-title">Doanh Thu Tháng Này</div>
            <div class="summary-value"><?= number_format($thisMonth, 0, ',', '.') ?> ₫</div>
        </div>
        
        <div class="summary-card red">
            <div class="summary-title">Đơn Chờ Xử Lý</div>
            <div class="summary-value"><?= $pendingInvoices ?></div>
        </div>
    </div>
    
    <div class="filter-row">
        <div class="search-box">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="searchInput" class="search-input" placeholder="Tìm kiếm hóa đơn..." onkeyup="searchTable()">
        </div>
    </div>
    
    <div class="invoice-container">
        <div class="table-responsive">
            <table class="table" id="invoiceTable">
                <thead>
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 20%;">Khách Hàng</th>
                        <th style="width: 20%;">Nhân Viên</th>
                        <th style="width: 15%;">Tổng Tiền</th>
                        <th style="width: 15%;">Ngày Hẹn</th>
                        <th style="width: 25%;">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($invoices)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 30px;">
                                <i class="fas fa-receipt" style="font-size: 48px; color: #cbd5e1; display: block; margin-bottom: 15px;"></i>
                                Không có hóa đơn nào
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($invoices as $invoice): 
                            $formattedAmount = number_format($invoice['total_amount'], 0, ',', '.') . ' ₫';
                            $formattedDate = date('d/m/Y', strtotime($invoice['pickup_date']));
                            
                            // Determine status based on pickup date
                            $pickupDate = new DateTime($invoice['pickup_date']);
                            $today = new DateTime();
                            $status = '';
                            $statusClass = '';
                            
                            if ($pickupDate > $today) {
                                $status = 'Chờ xử lý';
                                $statusClass = 'status-pending';
                            } elseif ($pickupDate < $today) {
                                $status = 'Đã hoàn thành';
                                $statusClass = 'status-paid';
                            } else {
                                $status = 'Hôm nay';
                                $statusClass = 'status-paid';
                            }
                        ?>
                            <tr>
                                <td><?= $invoice['id'] ?></td>
                                <td><?= htmlspecialchars($invoice['customer_name']) ?></td>
                                <td><?= htmlspecialchars($invoice['employee_name']) ?></td>
                                <td><?= $formattedAmount ?></td>
                                <td>
                                    <?= $formattedDate ?>
                                    <span class="status-badge <?= $statusClass ?>"><?= $status ?></span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="edit_invoice.php?id=<?= $invoice['id'] ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                        <a href="delete_invoice.php?id=<?= $invoice['id'] ?>" class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Bạn có chắc chắn muốn xóa hóa đơn này?');">
                                            <i class="fas fa-trash"></i> Xóa
                                        </a>
                                        <a href="../controllers/InvoiceController.php?action=print&id=<?= $invoice['id'] ?>" 
                                           class="btn btn-secondary btn-sm" target="_blank">
                                            <i class="fas fa-print"></i> In
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Basic pagination for demonstration -->
        <?php if (count($invoices) > 10): ?>
        <ul class="pagination">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
            </li>
        </ul>
        <?php endif; ?>
    </div>
</div>

<script>
function searchTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toUpperCase();
    const table = document.getElementById('invoiceTable');
    const rows = table.getElementsByTagName('tr');
    
    for (let i = 1; i < rows.length; i++) {
        let display = false;
        const cells = rows[i].getElementsByTagName('td');
        
        for (let j = 0; j < cells.length; j++) {
            const cell = cells[j];
            if (cell) {
                const txtValue = cell.textContent || cell.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    display = true;
                    break;
                }
            }
        }
        
        rows[i].style.display = display ? '' : 'none';
    }
}
</script>

<?php include 'footer.php'; ?>

<link rel="stylesheet" href="../assets/laundryservice/invoice.css">
