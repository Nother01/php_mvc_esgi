<?php

require_once __DIR__ . '/../../config/database.php';

class Task {
    private $db;
    private $table = 'tasks';

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function create($title, $description, $user_id, $status = 'todo') {
        $sql = "INSERT INTO " . $this->table . " (title, description, status, user_id) VALUES (:title, :description, :status, :user_id)";
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':user_id', $user_id);
        
        return $stmt->execute();
    }

    public function findByUserId($user_id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id, $user_id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id AND user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $title, $description, $status, $user_id) {
        $sql = "UPDATE " . $this->table . " SET title = :title, description = :description, status = :status WHERE id = :id AND user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $user_id);
        
        return $stmt->execute();
    }

    public function delete($id, $user_id) {
        $sql = "DELETE FROM " . $this->table . " WHERE id = :id AND user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_id', $user_id);
        
        return $stmt->execute();
    }
}