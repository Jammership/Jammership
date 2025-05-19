<?php
// Database.php

class Database {
    private $host = 'localhost';
    private $db_name = 'your_database';
    private $username = 'your_username';
    private $password = 'your_password';
    private $conn;
    private static $instance = null;

    // Private constructor to prevent direct instantiation
    private function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    // Singleton pattern to ensure only one instance exists
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Get the PDO connection
    public function getConnection() {
        return $this->conn;
    }

    // Helper method to prepare and execute queries
    public function query($sql, $params = []) {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    // Fetch a single row
    public function fetch($sql, $params = []) {
        return $this->query($sql, $params)->fetch();
    }

    // Fetch all rows
    public function fetchAll($sql, $params = []) {
        return $this->query($sql, $params)->fetchAll();
    }

    // Get last inserted ID
    public function lastInsertId() {
        return $this->conn->lastInsertId();
    }
}