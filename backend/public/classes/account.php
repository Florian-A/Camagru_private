<?php
class Account
{
    public function register()
    {
        // Get JSON data
        $json = file_get_contents('php://input');
        $data = json_decode($json);

        // Hash the password
        $passwordHash = password_hash($data->password, PASSWORD_DEFAULT);

        // Generate an activation hash
        $activationHash = bin2hex(random_bytes(16));

        // Insert the user data into the database
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare('INSERT INTO User (username, email, passwordHash, activationHash) VALUES (:username, :email, :passwordHash, :activationHash)');

        try {
            $stmt->execute([
                'username' => $data->username,
                'email' => $data->email,
                'passwordHash' => $passwordHash,
                'activationHash' => $activationHash
            ]);
    
            // Return the ID of the newly inserted user
            $userId = $pdo->lastInsertId();
    
            if ($userId > 0) {
                return ["status" => "success", "message" => "Registration successful. Please check your email to activate your account."];
            } else {
                return ["status" => "error", "message" => "Failed to register user."];
            }
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                return ["status" => "error", "message" => "Email is already in use."];
            } else {
                return ["status" => "error", "message" => "Failed to register user."];
            }
        }
    }
}
