<?php

require_once 'jwt.php';

class Test {

    // Simple method that returns a message
    public function helloWorld() {
        return ["status" => "success", "message" => "Hello World!"];
    }

    // Method that tests the database connection
    public function database()
    {
        try {
            // Test database connection
            $pdo = Database::getPDO();
            $stmt = $pdo->query('SELECT 1');
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result !== false) {
                return ["status" => "success", "message" => "Database connection is working"];
            } else {
                return ["status" => "error", "message" => "Database connection test failed"];
            }
        } catch (PDOException $e) {
            return ["status" => "error", "message" => "Database connection error: " . $e->getMessage()];
        }
    }

    public function secureAccess($token) {

        $jwt = new JWT(1);
        $userId = $jwt->getUserId($token);
        if ($userId > 0) {
            return ["status" => "ok", "userId" => $userId];
        } else {
            return ["status" => "fail"];
        }
    }
}
