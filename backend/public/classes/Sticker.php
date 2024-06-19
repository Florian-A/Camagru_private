<?php
class Sticker
{
    public function all()
    {
        try {
            $pdo = Database::getPDO();
            $stmt = $pdo->query('SELECT * FROM sticker');
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result !== false) {
                foreach ($result as &$sticker) {
                    if (isset($sticker['imagePath'])) {
                        $sticker['imagePath'] = './static/' . $sticker['imagePath'];
                    }
                }
                return ["status" => "success", "data" => $result];
            } else {
                return ["status" => "error", "message" => "No stickers found"];
            }
        } catch (PDOException $e) {
            return ["status" => "error", "message" => "Database query error: " . $e->getMessage()];
        }
    }
}
