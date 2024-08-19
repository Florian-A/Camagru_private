<?php

require_once 'account.php';

class Comment
{
    // Upload image and merge with stickers
    public function add($token)
    {
        $account = new Account();
        $userId = $account->getUser($token);

        if ($userId < 1) {
            return ["status" => "error", "message" => "You must be logged."];
        }

        // Get JSON data
        $json = file_get_contents('php://input');
        $data = json_decode($json);
        print_r($data);


        // WIP WIP WIP WIP <<<
        // // Add comment in database
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare('INSERT INTO Image (imageId, userId, content, createdAt) VALUES (:imageId, :userId, :content, :createdAt)');

        try {
            $stmt->execute([
                'imageId' => $data->imageId,
                'userId' => $userId,
                'content' => $data->content,
                'createdAt' => date('Y-m-d H:i:s')
            ]);
    
            // Return the ID of the newly inserted user
            $commentId = $pdo->lastInsertId();
    
            if ($commentId > 0) {
                return ["status" => "success", "contentId" => $commentId];
            } else {
                return ["status" => "error", "message" => "Failed to send content."];
            }
        } catch (PDOException $e) {
            if ($e->errorInfo[1]) {
                return ["status" => "error", "message" => "Unknow error."];
            }
        }
    }

}
