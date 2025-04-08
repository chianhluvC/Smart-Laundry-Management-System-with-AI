<?php if (isset($invoice)): ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn giặt sấy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #1abc9c;
            --light-gray: #f8f9fa;
            --border-color: #e9ecef;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            padding: 40px 20px;
        }
        
        .page-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .invoice-box {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
            padding: 40px;
            position: relative;
        }
        
        .invoice-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .company-info {
            display: flex;
            align-items: center;
        }
        
        .logo {
            width: 60px;
            height: 60px;
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-right: 15px;
        }
        
        .logo i {
            font-size: 30px;
            color: white;
        }
        
        .company-name {
            font-size: 24px;
            font-weight: 700;
            color: var(--secondary-color);
            line-height: 1.2;
        }
        
        .company-tagline {
            color: #777;
            font-size: 14px;
        }
        
        .invoice-title {
            text-align: right;
        }
        
        .invoice-title h1 {
            font-size: 28px;
            color: var(--secondary-color);
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .invoice-id {
            color: var(--primary-color);
            font-size: 16px;
            font-weight: 600;
        }
        
        .invoice-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .detail-group h3 {
            font-size: 16px;
            color: #777;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        .detail-item {
            margin-bottom: 5px;
            display: flex;
        }
        
        .detail-item i {
            width: 20px;
            color: var(--primary-color);
            margin-right: 8px;
        }
        
        .detail-data {
            font-weight: 600;
            color: var(--secondary-color);
        }
        
        .services-table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }
        
        .services-table th {
            background-color: var(--light-gray);
            color: var(--secondary-color);
            font-weight: 600;
            text-align: left;
            padding: 15px;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }
        
        .services-table td {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .services-table tr:hover {
            background-color: rgba(52, 152, 219, 0.05);
        }
        
        .services-table .text-right {
            text-align: right;
        }
        
        .services-table .service-name {
            font-weight: 600;
            color: var(--secondary-color);
        }
        
        .services-table .quantity {
            color: #666;
        }
        
        .total-row td {
            padding-top: 20px;
            font-weight: 700;
            color: var(--secondary-color);
            font-size: 18px;
        }
        
        .grand-total {
            background-color: var(--light-gray);
            border-radius: 5px;
            padding: 20px;
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .grand-total-label {
            font-size: 18px;
            font-weight: 700;
            color: var(--secondary-color);
        }
        
        .grand-total-amount {
            font-size: 22px;
            font-weight: 700;
            color: var(--accent-color);
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #777;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }
        
        .thank-you {
            font-size: 20px;
            font-weight: 600;
            color: var(--accent-color);
            margin-bottom: 10px;
        }
        
        .footer-note {
            font-size: 14px;
        }
        
        .footer-contact {
            margin-top: 10px;
            font-size: 14px;
        }
        
        .invoice-stamp {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-20deg);
            font-size: 100px;
            color: rgba(26, 188, 156, 0.07);
            pointer-events: none;
            font-weight: 900;
            z-index: 1;
            white-space: nowrap;
        }
        
        @media print {
            body {
                padding: 0;
                background-color: white;
            }
            
            .invoice-box {
                box-shadow: none;
                padding: 20px;
            }
            
            .page-container {
                max-width: 100%;
            }
        }
        
        @media (max-width: 768px) {
            .invoice-details {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .invoice-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .invoice-title {
                text-align: left;
                margin-top: 20px;
            }
            
            .services-table th, .services-table td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="page-container">
        <div class="invoice-box">
            <div class="invoice-stamp">ĐÃ THANH TOÁN</div>
            
            <div class="invoice-header">
                <div class="company-info">
                    <div class="logo">
                        <i class="fas fa-tshirt"></i>
                    </div>
                    <div>
                        <div class="company-name">Dịch Vụ Giặt Sấy</div>
                        <div class="company-tagline">Sạch sẽ, nhanh chóng, chuyên nghiệp</div>
                    </div>
                </div>
                
                <div class="invoice-title">
                    <h1>HÓA ĐƠN</h1>
                    <div class="invoice-id">#<?= $invoice['id'] ?></div>
                </div>
            </div>
            
            <div class="invoice-details">
                <div class="detail-group">
                    <h3>THÔNG TIN HÓA ĐƠN</h3>
                    <div class="detail-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span class="detail-label">Ngày nhận:</span>
                        <span class="detail-data"><?= date('d/m/Y', strtotime($invoice['pickup_date'])) ?></span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-calendar-check"></i>
                        <span class="detail-label">Ngày xuất hóa đơn:</span>
                        <span class="detail-data"><?= date('d/m/Y') ?></span>
                    </div>
                </div>
                
                <div class="detail-group">
                    <h3>THÔNG TIN KHÁCH HÀNG</h3>
                    <div class="detail-item">
                        <i class="fas fa-user"></i>
                        <span class="detail-data"><?= $invoiceServices[array_key_first($invoiceServices)]['customer_username'] ?? 'Khách hàng' ?></span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-user-tie"></i>
                        <span class="detail-label">Nhân viên phụ trách:</span>
                        <span class="detail-data"><?= $invoiceServices[array_key_first($invoiceServices)]['employee_username'] ?? '---' ?></span>
                    </div>
                </div>
            </div>
            
            <table class="services-table">
                <thead>
                    <tr>
                        <th style="width: 40%;">Dịch vụ</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th class="text-right">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    foreach ($invoiceServices as $serviceId => $detail):
                        $stmt = $this->conn->prepare("SELECT price FROM services WHERE id = ?");
                        $stmt->execute([$serviceId]);
                        $price = $stmt->fetchColumn();
                        $subtotal = $price * $detail['quantity'];
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td class="service-name"><?= $detail['service_name'] ?></td>
                        <td class="quantity"><?= $detail['quantity'] ?> kg</td>
                        <td><?= number_format($price, 0, ',', '.') ?> VND</td>
                        <td class="text-right"><?= number_format($subtotal, 0, ',', '.') ?> VND</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div class="grand-total">
                <div class="grand-total-label">TỔNG THANH TOÁN</div>
                <div class="grand-total-amount"><?= number_format($total, 0, ',', '.') ?> VND</div>
            </div>
            
            <div class="footer">
                <div class="thank-you">Cảm ơn quý khách đã sử dụng dịch vụ!</div>
                <div class="footer-note">Vui lòng giữ hóa đơn này để đối chiếu khi nhận hàng.</div>
                <div class="footer-contact">
                    <i class="fas fa-phone"></i> Hotline: 0123 456 789 |
                    <i class="fas fa-envelope"></i> Email: contact@dichvugiatsay.com
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php else: ?>
    <div style="text-align: center; padding: 50px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
        <i class="fas fa-exclamation-triangle" style="font-size: 48px; color: #e74c3c; margin-bottom: 20px;"></i>
        <h2>Không tìm thấy hóa đơn</h2>
        <p>Vui lòng kiểm tra lại mã hóa đơn hoặc liên hệ với nhân viên hỗ trợ.</p>
        <a href="javascript:history.back()" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #3498db; color: white; text-decoration: none; border-radius: 5px;">Quay lại</a>
    </div>
<?php endif; ?>