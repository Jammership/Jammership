<?php
class user {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function register($email, $password, $role) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
        return $stmt->execute([$email, $hashed, $role]);
    }

    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            return true;
        }
        return false;
    }
}