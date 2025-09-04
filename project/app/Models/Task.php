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

    public function findByUserIdPaginated($user_id, $page = 1, $perPage = 5) {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT * FROM " . $this->table . " WHERE user_id = :user_id ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $countSql = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE user_id = :user_id";
        $countStmt = $this->db->prepare($countSql);
        $countStmt->bindParam(':user_id', $user_id);
        $countStmt->execute();
        $total = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        return [
            'tasks' => $tasks,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => ceil($total / $perPage)
        ];
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