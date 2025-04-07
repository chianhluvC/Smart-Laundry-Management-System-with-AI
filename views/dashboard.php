<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$firstLetter = strtoupper(substr($_SESSION['username'], 0, 1));
?>

<?php include 'header.php'; ?>

<div class="container">
    <div class="dashboard-card">
        <div class="welcome-header">
            <div class="avatar"><?php echo $firstLetter; ?></div>
            <div class="welcome-text">
                <h2>Chào mừng, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
                <span class="role-badge role-<?php echo strtolower($_SESSION['role']); ?>"><?php echo htmlspecialchars($_SESSION['role']); ?></span>
            </div>
        </div>
        
        <div class="info-section">
            <h3 class="info-title">Tổng quan về bảng điều khiển</h3>
            
            <div class="stat-grid">
                <div class="stat-card">
                    <h3>Đăng nhập lần cuối</h3>
                    <p><?php echo date('d M Y, h:i A'); ?></p>
                </div>
                
                <div class="stat-card">
                    <h3>Trạng thái tài khoản</h3>
                    <p>đang hoạt động</p>
                </div>
                
                <div class="stat-card">
                    <h3>phiên đã hết hạn</h3>
                    <p>30 phút</p>
                </div>
            </div>
        </div>
        
        <div class="action-buttons">
            <a href="dashboard.php" class="btn btn-primary">Bảng điều khiển</a>
            <a href="profile.php" class="btn btn-primary">Chỉnh sửa hồ sơ</a>
            <a href="logout.php" class="btn btn-danger">Đăng xuất</a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/laundryservice/dashboard.css">