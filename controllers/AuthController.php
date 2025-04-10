<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../config/database.php';


class AuthController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($username, $email, $phone, $password, $role) {
        try {
            $checkEmail = $this->conn->prepare("SELECT id FROM users WHERE email = ?");
            $checkEmail->execute([$email]);
            if ($checkEmail->rowCount() > 0) {
                return ["success" => false, "message" => "Email đã được sử dụng"];
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("INSERT INTO users (username, email, phone, password, role) VALUES (?, ?, ?, ?, ?)");
            $result = $stmt->execute([$username, $email, $phone, $hashedPassword, $role]);

            return $result ? ["success" => true, "message" => "Đăng ký thành công"] : ["success" => false, "message" => "Lỗi khi đăng ký"];
        } catch (PDOException $e) {
            error_log("Lỗi đăng ký: " . $e->getMessage());
            return ["success" => false, "message" => "Lỗi hệ thống"];
        }
    }

    public function login($email, $password) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                return ["success" => true, "message" => "Đăng nhập thành công"];
            } else {
                return ["success" => false, "message" => "Email hoặc mật khẩu không đúng"];
            }
        } catch (PDOException $e) {
            error_log("Lỗi đăng nhập: " . $e->getMessage());
            return ["success" => false, "message" => "Lỗi hệ thống"];
        }
    }
    public function getUsersByRole($role) {
        $stmt = $this->conn->prepare("SELECT id, username AS name, email, phone FROM users WHERE role = ?");
        $stmt->execute([$role]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createCustomer($username, $email, $phone, $password = '123456') {
        try {
            $checkEmail = $this->conn->prepare("SELECT id FROM users WHERE email = ?");
            $checkEmail->execute([$email]);
            if ($checkEmail->rowCount() > 0) {
                return ["success" => false, "message" => "Email đã tồn tại"];
            }
    
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("INSERT INTO users (username, email, phone, password, role) VALUES (?, ?, ?,?, 'customer')");
            $result = $stmt->execute([$username, $email, $phone, $hashedPassword]);
    
            return $result ? ["success" => true, "message" => "Tạo khách hàng thành công"] : ["success" => false, "message" => "Lỗi khi tạo khách hàng"];
        } catch (PDOException $e) {
            error_log("Lỗi tạo khách hàng: " . $e->getMessage());
            return ["success" => false, "message" => "Lỗi hệ thống"];
        }
    }

    public function updateCustomer($id, $username, $email, $phone) {
        try {
            $stmt = $this->conn->prepare("UPDATE users SET username = ?, email = ?, phone = ? WHERE id = ? AND role = 'customer'");
            $stmt->execute([$username, $email, $phone, $id]);
            return ["success" => true, "message" => "Cập nhật khách hàng thành công"];
        } catch (PDOException $e) {
            return ["success" => false, "message" => "Lỗi cập nhật khách hàng"];
        }
    }
    
    public function deleteCustomer($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ? AND role = 'customer'");
            $stmt->execute([$id]);
            return ["success" => true, "message" => "Xóa khách hàng thành công"];
        } catch (PDOException $e) {
            return ["success" => false, "message" => "Lỗi xóa khách hàng"];
        }
    }
}

// Khởi tạo kết nối nếu request đến từ form handler
if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    require_once '../config/database.php';
    $database = new Database();
    $db = $database->getConnection();
    $auth = new AuthController($db);
}



// Xử lý đăng nhập khi người dùng gửi form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $database = new Database();
    $db = $database->getConnection();
    $auth = new AuthController($db);

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $response = $auth->login($email, $password);

    if ($response["success"]) {
        header("Location: ../views/dashboard.php");
    } else {
        header("Location: ../views/registerLogin.php?error=" . urlencode($response["message"]));
    }
}

// Xử lý đăng ký khi người dùng gửi form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $database = new Database();
    $db = $database->getConnection();
    $auth = new AuthController($db);

    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'user';

    $response = $auth->register($username, $email, $phone, $password, $role);

    if ($response["success"]) {
        header("Location: ../views/registerLogin.php?success=" . urlencode($response["message"]));
    } else {
        header("Location: ../views/registerLogin.php?error=" . urlencode($response["message"]));
    }
}



// Xử lý tạo khách hàng
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_customer'])) {
    $database = new Database();
    $conn = $database->getConnection();
    $auth = new AuthController($conn);

    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $result = $auth->createCustomer($username, $email, $phone);

    if ($result['success']) {
        header("Location: ../views/manage_customers.php?success=" . urlencode($result['message']));
    } else {
        header("Location: ../views/create_customer.php?error=" . urlencode($result['message']));
    }
}

// Sửa khách hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update') {
    $id = $_POST['id'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $result = $auth->updateCustomer($id, $username, $email, $phone);

    header("Location: ../views/manage_customers.php?" . ($result['success'] ? "success" : "error") . "=" . urlencode($result['message']));
    exit;
}

// Xóa khách hàng
if ($_SERVER['REQUEST_METHOD'] === 'GET' && ($_GET['action'] ?? '') === 'delete') {
    $id = $_GET['id'] ?? '';
    $result = $auth->deleteCustomer($id);

    header("Location: ../views/manage_customers.php?" . ($result['success'] ? "success" : "error") . "=" . urlencode($result['message']));
    exit;
}

?>


