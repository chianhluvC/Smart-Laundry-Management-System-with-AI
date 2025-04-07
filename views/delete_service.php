<?php
require_once '../config/database.php';
require_once '../controllers/ServiceController.php';

$database = new Database();
$conn = $database->getConnection();
$serviceController = new ServiceController($conn);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($serviceController->deleteService($id)) {
        header("Location: service_list.php?success=1");
        exit();
    } else {
        header("Location: service_list.php?error=Xóa thất bại");
        exit();
    }
} else {
    header("Location: service_list.php?error=Không tìm thấy dịch vụ");
    exit();
}
?>
