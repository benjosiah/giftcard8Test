<?php
class Register {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function registerUser($name, $email, $password) {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        try {
            $stmt = $this->db->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':password' => $hashedPassword
            ]);
            return true;
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') { // Duplicate email error
                return "Email already exists.";
            }
            return "Error: " . $e->getMessage();
        }
    }
}
?>
