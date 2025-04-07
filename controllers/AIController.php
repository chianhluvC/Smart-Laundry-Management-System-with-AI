<?php
include '../config/database.php';
include '../config/openrouter_api.php';

class AIController
{
    private $conn;
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function processQuery($query)
    {
        $queryLower = mb_strtolower($query, 'UTF-8');


        if (strpos($queryLower, 'doanh thu') !== false || strpos($queryLower, 'thu nhập') !== false || strpos($queryLower, 'dự đoán') !== false) {
            $summary = "Dữ liệu hóa đơn hiện tại:\n";


            $invoiceCtrl = new InvoiceController($this->conn);
            $invoices = $invoiceCtrl->getAllInvoices();
            foreach ($invoices as $inv) {
                $summary .= "- Khách: {$inv['customer_name']}, Tổng tiền: {$inv['total_amount']} VNĐ, Ngày: {$inv['pickup_date']}\n";
            }

            $prompt = <<<EOT
            Bạn là trợ lý AI của một tiệm giặt sấy. Hãy giúp chủ tiệm phân tích hoạt động kinh doanh dựa trên dữ liệu sau:
            
            $summary
            
            Yêu cầu:
            - Nếu người dùng hỏi về doanh thu: hãy đưa tổng doanh thu cho số liệu cụ thể và phân tích xu hướng tăng/giảm và dự đoán doanh thu ước tính doanh thu cụ thể, giải thích tại sao.
            - Nếu người dùng hỏi về quản lý: hãy đề xuất cách giao việc cho nhân viên, theo dõi hiệu suất, chia ca trực.
            - Nếu người dùng hỏi về vận hành: hãy gợi ý cải thiện dịch vụ, tối ưu quy trình, chăm sóc khách hàng.
            Hãy trả lời ngắn gọn, người dùng hỏi gì trả lời đó không hiện thị nếu người dùng không hỏi, thực tế và thân thiện bằng tiếng Việt.
            EOT;
        } else {

            $prompt = <<<EOT
            Bạn là trợ lý AI thông minh trong hệ thống quản lý giặt sấy. 
            Người dùng hỏi: "$query"
            
            Hãy trả lời thân thiện, rõ ràng, đưa ra gợi ý liên quan đến:
            - Dự đoán doanh thu 
            - Quản lý nhân viên (chia ca, chấm công)
            - Giao việc, hiệu suất làm việc
            - Tối ưu dịch vụ, chăm sóc khách hàng
            
            Trả lời ngắn gọn, bằng tiếng Việt.
            EOT;
        }

        return queryDeepSeek($prompt);
    }
}
