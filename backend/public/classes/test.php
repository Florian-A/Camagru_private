<?php
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

        $headers = getallheaders();

        if (isset($headers['Authorization']) && preg_match('/Bearer\s(\S+)/', $headers['Authorization'], $matches)) {
            $token = $matches[1];
        }

        return ["status" => "test", "message" => "test", "token" => $token];
    }
}
