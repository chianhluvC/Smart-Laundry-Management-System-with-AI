<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: registerLogin.php");
    exit();
}
include 'header.php';
?>

<div class="container mt-5">
    <h2 class="mb-4">Thống Kê Giặt Sấy (Demo)</h2>

    <div class="row text-center mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <h4 class="text-primary">Tổng khách hàng</h4>
                <h2>120</h2>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <h4 class="text-success">Tổng hóa đơn</h4>
                <h2>342</h2>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Doanh thu -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm p-3">
                <h5 class="text-center mb-3">Doanh thu theo tháng</h5>
                <canvas id="revenueChart" height="200"></canvas>
            </div>
        </div>

        <!-- Dịch vụ sử dụng -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm p-3">
                <h5 class="text-center mb-3">Tỷ lệ sử dụng dịch vụ</h5>
                <canvas id="serviceChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Biểu đồ doanh thu
    const revenueCtx = document.getElementById('revenueChart');
    new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5'],
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: [12000000, 9500000, 14000000, 11000000, 17000000],
                backgroundColor: '#3498db',
                borderRadius: 5
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });

    // Biểu đồ tỷ lệ dịch vụ
    const serviceCtx = document.getElementById('serviceChart');
    new Chart(serviceCtx, {
        type: 'doughnut',
        data: {
            labels: ['Giặt thường', 'Sấy khô', 'Ủi đồ', 'Giao tận nơi'],
            datasets: [{
                data: [120, 90, 60, 40],
                backgroundColor: ['#1abc9c', '#f39c12', '#e74c3c', '#8e44ad'],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>

<?php include 'footer.php'; ?>
