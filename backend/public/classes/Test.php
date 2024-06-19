<?php
class Test {

    // a simple method that returns a message
    public function helloWorld() {
        return ["status" => "success", "message" => "Hello World!"];
    }

    // a method that tests the database connection
    public function database()
    {
        try {
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
}
