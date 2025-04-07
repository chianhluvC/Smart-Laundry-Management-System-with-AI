<?php
include '../config/database.php';
include '../controllers/AIController.php';
include '../controllers/InvoiceController.php'; 

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$query = $input['query'] ?? '';

if (!$query) {
    echo json_encode(['reply' => 'Vui lòng nhập câu hỏi.']);
    exit;
}

$database = new Database();
$conn = $database->getConnection();

$ai = new AIController($conn);
$response = $ai->processQuery($query);

echo json_encode(['reply' => $response]);
