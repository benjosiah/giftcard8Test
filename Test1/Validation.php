<?php
class Validation {
    private $errors = [];

    public function validateRequired($field, $value) {
        if (empty($value)) {
            $this->errors[] = "$field is required.";
        }
    }

    public function validateEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "A valid email is required.";
        }
    }

    public function validatePasswordMatch($password, $confirmPassword) {
        if ($password !== $confirmPassword) {
            $this->errors[] = "Passwords do not match.";
        }
    }

    public function getErrors() {
        return $this->errors;
    }

    public function hasErrors() {
        return !empty($this->errors);
    }
}
?>
