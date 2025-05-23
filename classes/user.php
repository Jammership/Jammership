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

    public function logout(): bool {
        // Clear all session data
        $_SESSION = [];

        // If a session cookie is used, clear that too
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destroy the session
        return session_destroy();
    }

    // Add these methods to your User class in includes/User.php

    /**
     * Update user's email
     * @param int $userId
     * @param string $email
     * @return bool
     */
    public function updateEmail($userId, $email) {
        $query = "UPDATE users SET email = :email WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Verify if provided password matches the user's current password
     * @param int $userId
     * @param string $password
     * @return bool
     */
    public function verifyPassword($userId, $password) {
        $query = "SELECT password FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return password_verify($password, $row['password']);
        }

        return false;
    }

    /**
     * Update user's password
     * @param int $userId
     * @param string $newPassword
     * @return bool
     */
    public function updatePassword($userId, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $query = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Delete a user account
     * @param int $userId
     * @return bool
     */
    public function deleteAccount($userId) {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}