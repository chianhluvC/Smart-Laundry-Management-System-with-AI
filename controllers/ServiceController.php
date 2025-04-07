<?php
require_once '../config/database.php';
class ServiceController {
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }
    public function addService($name, $price) {
        $stmt = $this->conn->prepare("INSERT INTO services (name, price) VALUES (?, ?)");
        return $stmt->execute([$name, $price]);
    }
    public function deleteService($id) {
        $stmt = $this->conn->prepare("DELETE FROM services WHERE id = ?");
        return $stmt->execute([$id]);
    }
    public function updateService($id, $name, $price) {
        $stmt = $this->conn->prepare("UPDATE services SET name = ?, price = ? WHERE id = ?");
        return $stmt->execute([$name, $price, $id]);
    }
    public function getAllServices() {
        $stmt = $this->conn->prepare("SELECT * FROM services");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
    
    if(!isset($conn)) {
        $database = new Database();
        $conn = $database->getConnection();
    }
?>
