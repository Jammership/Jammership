<?php
class user {
    private PDO $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function register($email, $password, $role, $username): bool{
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (email, password, role, username) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$email, $hashed, $role, $username]);
    }

    public function login($username, $password): bool {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if($user && password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['username'] = $user['username'];
            return true;
        }
        return false;
    }
}