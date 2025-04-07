<?php
include '../config/database.php';



class InvoiceController {
    public $conn;

    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function getInvoiceById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM invoices WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    
    public function getInvoiceServices($invoiceId) {
        // Thực hiện JOIN với bảng users để lấy username của khách hàng và nhân viên
        $stmt = $this->conn->prepare("
            SELECT 
                d.service_id, 
                d.quantity, 
                s.name AS service_name,
                u.username AS customer_username,
                e.username AS employee_username
            FROM invoice_details d
            LEFT JOIN services s ON d.service_id = s.id
            LEFT JOIN invoices i ON d.invoice_id = i.id
            LEFT JOIN users u ON i.customer_id = u.id
            LEFT JOIN users e ON i.employee_id = e.id
            WHERE d.invoice_id = ?");
        $stmt->execute([$invoiceId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $services = [];
        foreach ($results as $row) {
            // Lưu service_id, quantity và usernames vào mảng
            $services[$row['service_id']] = [
                'quantity' => $row['quantity'],
                'service_name' => $row['service_name'],
                'customer_username' => $row['customer_username'],
                'employee_username' => $row['employee_username']
            ];
        }
        return $services;
    }
    
    
    

    public function createInvoice($customer_id, $employee_id, $pickup_date, $services) {
        $this->conn->beginTransaction();
        
        // Tạo hóa đơn với tổng tiền & trọng lượng ban đầu = 0
        $stmt = $this->conn->prepare("INSERT INTO invoices (customer_id, employee_id, total_amount, weight, pickup_date) VALUES (?, ?, 0, 0, ?)");
        $stmt->execute([$customer_id, $employee_id, $pickup_date]);
        $invoice_id = $this->conn->lastInsertId();

        $total_amount = 0;
        $total_weight = 0;

        foreach ($services as $service) {
            $stmt = $this->conn->prepare("SELECT price FROM services WHERE id = ?");
            $stmt->execute([$service['id']]);
            $price_per_kg = $stmt->fetchColumn();

            $weight = $service['weight']; // Lấy trọng lượng
            $subtotal = $price_per_kg * $weight;
            $total_amount += $subtotal;
            $total_weight += $weight;

            // Lưu vào bảng `invoice_details`
            $stmt = $this->conn->prepare("INSERT INTO invoice_details (invoice_id, service_id,quantity, price) VALUES (?, ?, ?,?)");
            $stmt->execute([$invoice_id, $service['id'],1, $subtotal]);
        }

        // Cập nhật tổng tiền và tổng trọng lượng vào `invoices`
        $stmt = $this->conn->prepare("UPDATE invoices SET total_amount = ?, weight = ? WHERE id = ?");
        $stmt->execute([$total_amount, $total_weight, $invoice_id]);

        $this->conn->commit();
        return true;
    }

    public function deleteInvoice($id) {
        $stmt = $this->conn->prepare("DELETE FROM invoices WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getAllInvoices() {
        $stmt = $this->conn->prepare("
            SELECT invoices.id,
                   invoices.customer_id,
                   c.username AS customer_name,
                   invoices.employee_id,
                   e.username AS employee_name,
                   invoices.total_amount,
                   invoices.weight,
                   invoices.pickup_date,
                   GROUP_CONCAT(s.name SEPARATOR ', ') AS service_details
            FROM invoices
            JOIN users c ON invoices.customer_id = c.id
            JOIN users e ON invoices.employee_id = e.id
            JOIN invoice_details d ON invoices.id = d.invoice_id
            JOIN services s ON d.service_id = s.id
            GROUP BY invoices.id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateInvoice($data) {
        $stmt = $this->conn->prepare("UPDATE invoices SET customer_id=?, employee_id=?, pickup_date=? WHERE id=?");
        $stmt->execute([
            $data['customer_id'],
            $data['employee_id'],
            $data['pickup_date'],
            $data['invoice_id']
        ]);
    
        // Xóa dịch vụ cũ
        $this->conn->prepare("DELETE FROM invoice_details WHERE invoice_id=?")->execute([$data['invoice_id']]);
    
        // Thêm lại dịch vụ mới
        $totalAmount = 0;
        foreach ($data['services'] as $service) {
            if (!empty($service['id']) && !empty($service['weight'])) {
                $stmt = $this->conn->prepare("SELECT price FROM services WHERE id = ?");
                $stmt->execute([$service['id']]);
                $price = $stmt->fetchColumn();
    
                $weight = $service['weight'];
                $subtotal = $price * $weight;
                $totalAmount += $subtotal;
    
                $insertDetail = $this->conn->prepare("INSERT INTO invoice_details (invoice_id, service_id, quantity, price) VALUES (?, ?,?,?)");
                $insertDetail->execute([$data['invoice_id'], $service['id'],1,$weight ]);
            }
        }
    
        $updateTotal = $this->conn->prepare("UPDATE invoices SET total_amount = ?, weight = ? WHERE id = ?");
        $updateTotal->execute([$totalAmount, array_sum(array_column($data['services'], 'weight')), $data['invoice_id']]);
    
        header("Location: ../views/manage_invoices.php?success=Cập nhật hóa đơn thành công");
        exit();
    }

    public function printInvoice($id) {
        $invoice = $this->getInvoiceById($id);
        $invoiceServices = $this->getInvoiceServices($id);
    
        ob_start(); // Bắt đầu buffer
        include '../views/invoice_print_view.php';
        $content = ob_get_clean(); // Lấy nội dung đã include
    
        echo $content;
        exit;
    }
    
    
}
$database = new Database();
$conn = $database->getConnection();
if (isset($_GET['action']) && $_GET['action'] === 'update') {
    $invoice = new InvoiceController($conn);
    $invoice->updateInvoice($_POST);
}

// Xử lý khi người dùng gửi form tạo hóa đơn
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_GET['action']) && $_GET['action'] === 'create') {
    include_once '../config/database.php';
    $database = new Database();
    $conn = $database->getConnection();
    $invoiceController = new InvoiceController($conn);

    $customer_id = $_POST['customer_id'] ?? null;
    $employee_id = $_POST['employee_id'] ?? null;
    $pickup_date = $_POST['pickup_date'] ?? null;
    $services_input = $_POST['services'] ?? [];

    // Chuẩn bị lại danh sách dịch vụ để gửi vào controller
    $services = [];
    foreach ($services_input as $service) {
        // Nếu checkbox được chọn và có trọng lượng
        if (isset($service['id']) && !empty($service['weight']) && $service['weight'] > 0) {
            $services[] = [
                'id' => $service['id'],
                'weight' => $service['weight']
            ];
        }
    }

    if ($customer_id && $employee_id && $pickup_date && count($services) > 0) {
        $success = $invoiceController->createInvoice($customer_id, $employee_id, $pickup_date, $services);

        if ($success) {
            header("Location: ../views/manage_invoices.php?success=" . urlencode("Tạo hóa đơn thành công"));
            exit;
        } else {
            header("Location: ../views/manage_invoices.php?error=" . urlencode("Lỗi khi tạo hóa đơn"));
            exit;
        }
    } else {
        header("Location: ../views/manage_invoices.php?error=" . urlencode("Vui lòng điền đầy đủ thông tin và chọn ít nhất 1 dịch vụ"));
        exit;
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'print') {
    $invoice = new InvoiceController($conn);
    $invoice->printInvoice($_GET['id']);
}

?>
