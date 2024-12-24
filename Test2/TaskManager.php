<?php
class TaskManager {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function fetchTasks($id = null) {
        if ($id) {
            $stmt = $this->pdo->prepare("SELECT * FROM tasks WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $stmt = $this->pdo->query("SELECT * FROM tasks ORDER BY created_at DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function addTask($data) {
        $stmt = $this->pdo->prepare("INSERT INTO tasks (name, description) VALUES (:name, :description)");
        $stmt->execute([':name' => $data['name'], ':description' => $data['description']]);
        return $this->pdo->lastInsertId();
    }

    public function updateTask($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE tasks SET name = COALESCE(:name, name), description = COALESCE(:description, description) WHERE id = :id");
        $stmt->execute([':name' => $data['name'], ':description' => $data['description'], ':id' => $id]);
        return $stmt->rowCount();
    }

    public function deleteTask($id) {
        $stmt = $this->pdo->prepare("DELETE FROM tasks WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount();
    }
}
