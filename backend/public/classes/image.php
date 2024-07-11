<?php
class Image
{
    // Upload image and merge with stickers
    public function upload()
    {
        // Get JSON data
        $json = file_get_contents('php://input');
        $data = json_decode($json);

        if ($data && isset($data->image)) {

            // Get image data
            $imageData = $data->image;
            $stickersId = $data->stickersId;

            // Remove data URL scheme part
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = str_replace(' ', '+', $imageData);

            // Decode base64 image data
            $imageBinary = base64_decode($imageData);

            // Save image to file
            $filePath = './static/'; 
            $fileName = 'image_' . uniqid() . '.png';
            $fullPath = $filePath . $fileName;
            $bytesWritten = file_put_contents($fullPath, $imageBinary);

            if ($bytesWritten !== false) {
                
                // Load webcam image
                $webcamImage = imagecreatefrompng($fullPath);
                $stickerPaths = $this->getStickerPaths($stickersId);

                // Merge webcam image with stickers
                foreach ($stickerPaths as $stickerPath) {
                    $stickerImage = imagecreatefrompng($stickerPath);
                    imagecopy($webcamImage, $stickerImage, 0, 0, 0, 0, imagesx($stickerImage), imagesy($stickerImage));
                    imagedestroy($stickerImage);
                }

                // Save merged image
                imagepng($webcamImage, $fullPath);
                imagedestroy($webcamImage);

                return ["status" => "success", "imagePath" => $fullPath];
            } else {
                return ["status" => "error", "message" => "Failed to save image to file."];
            }
        } else {
            return ["status" => "error", "message" => "Invalid image data."];
        }
    }

    // Get sticker paths from database
    private function getStickerPaths($stickersId)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare('SELECT imagePath FROM Sticker WHERE id IN (' . implode(',', $stickersId) . ')');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $stickerPaths = [];
        foreach ($result as $imagePath) {
            $stickerPaths[] = './static/' . $imagePath;
        }

        return $stickerPaths;
    }
}
