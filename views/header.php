<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundry Management</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #1abc9c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --danger-color: #e74c3c;
            --sidebar-width: 250px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        /* Navbar Styling */
        .navbar {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color)) !important;
            padding: 12px 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: none;
            z-index: 1030;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 24px;
            color: white !important;
            display: flex;
            align-items: center;
        }

        .navbar-brand i {
            margin-right: 10px;
            color: var(--accent-color);
        }

        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 8px 15px;
            border-radius: 4px;
        }

        .navbar-nav .nav-link:hover {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .navbar-nav .nav-link.active {
            color: white !important;
            background-color: var(--accent-color);
        }

        /* Sidebar styling */
        #sidebar {
            position: fixed;
            width: var(--sidebar-width);
            height: 100%;
            background: var(--secondary-color);
            color: white;
            transition: all 0.3s;
            z-index: 1020;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.1);
            left: 0;
            top: 0;
            padding-top: 80px;
        }

        #sidebar.active {
            left: -var(--sidebar-width);
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background: rgba(0, 0, 0, 0.2);
        }

        #sidebar ul.components {
            padding: 20px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        #sidebar ul li a {
            padding: 15px 20px;
            font-size: 1.1em;
            display: block;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        #sidebar ul li a:hover {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            border-left: 3px solid var(--accent-color);
        }

        #sidebar ul li a.active {
            color: white;
            background: rgba(0, 0, 0, 0.2);
            border-left: 3px solid var(--accent-color);
        }

        #sidebar ul li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Content styling */
        #content {
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            transition: all 0.3s;
            position: absolute;
            top: 0;
            right: 0;
            padding-top: 76px;
        }

        #content.active {
            width: 100%;
        }

        /* Button styling */
        .btn-custom {
            background-color: var(--accent-color);
            color: white;
            border: none;
            transition: all 0.3s;
        }

        .btn-custom:hover {
            background-color: #16a085;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-outline-custom {
            color: white;
            border-color: white;
            transition: all 0.3s;
        }

        .btn-outline-custom:hover {
            background-color: white;
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        /* User profile in sidebar */
        .user-profile {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-profile img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid var(--accent-color);
            padding: 3px;
            background-color: white;
        }

        .user-profile h5 {
            margin-top: 15px;
            font-weight: 600;
        }

        .user-profile p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9em;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            #sidebar {
                left: -var(--sidebar-width);
            }
            #sidebar.active {
                left: 0;
            }
            #content {
                width: 100%;
            }
            #content.active {
                width: calc(100% - var(--sidebar-width));
            }
            #sidebarCollapse span {
                display: none;
            }
        }

        /* Custom toggle button for sidebar */
        #sidebarCollapse {
            position: fixed;
            bottom: 20px;
            left: 20px;
            z-index: 1030;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            background: var(--primary-color);
            color: white;
            border: none;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        #sidebarCollapse:hover {
            background: var(--accent-color);
            transform: scale(1.1);
        }

        /* Notification badge */
        .badge-notification {
            position: absolute;
            top: -5px;
            right: -5px;
            padding: 5px 8px;
            border-radius: 50%;
            background: var(--danger-color);
            color: white;
            font-size: 0.7em;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="user-profile">
                <?php if (isset($_SESSION['username'])): ?>
                    <img src="../assets/images/admin-avartar.jpg" alt="User Profile">
                    <h5><?= htmlspecialchars($_SESSION['username']) ?></h5>
                    <p><?= htmlspecialchars($_SESSION['role']) ?></p>
                <?php else: ?>
                    <img src="../assets/images/default-avatar.png" alt="Guest">
                    <h5>Guest</h5>
                    <p>Not logged in</p>
                <?php endif; ?>
            </div>
            
            <ul class="list-unstyled components">
                <li>
                    <a href="dashboard.php" class="active">
                        <i class="fas fa-tachometer-alt"></i> Bảng điều khiển
                    </a>
                </li>
                <li>
                    <a href="manage_services.php">
                        <i class="fas fa-shirt"></i> Dịch vụ
                    </a>
                </li>
                <li>
                    <a href="manage_invoices.php">
                        <i class="fas fa-file-invoice-dollar"></i> Hóa đơn
                        <span class="badge-notification">3</span>
                    </a>
                </li>
                <li>
                    <a href="manage_customers.php">
                        <i class="fas fa-users"></i> Khách hàng
                    </a>
                </li>
            </ul>
            
            <div class="px-4 pb-4 text-center">
                <?php if (isset($_SESSION['username'])): ?>
                    <a href="logout.php" class="btn btn-danger w-100">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </a>
                <?php else: ?>
                    <a href="registerLogin.php" class="btn btn-custom w-100">
                        <i class="fas fa-sign-in-alt"></i> Đăng nhập
                    </a>
                <?php endif; ?>
            </div>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg fixed-top">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <i class="fas fa-washer"></i> Hệ Thống Quản Lý Giặt Ủi
                    </a>
                    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <?php if (isset($_SESSION['username'])): ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-user-circle"></i>
                                        <?= htmlspecialchars($_SESSION['username']) ?>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown"
                                        style="background-color: white; color: black;">
                                        <li>
                                            <a class="dropdown-item" href="profile.php">
                                                <i class="fas fa-id-card me-2"></i> Hồ sơ
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="settings.php">
                                                <i class="fas fa-cog me-2"></i> Cài đặt
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="logout.php">
                                                <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <?php else: ?>
                                <li class="nav-item">
                                    <a class="btn btn-outline-custom" href="registerLogin.php">
                                        <i class="fas fa-sign-in-alt"></i> Đăng nhập
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Main Content (Empty) -->
            <div class="container-fluid py-4">
                <!-- This is the empty body content area -->
            