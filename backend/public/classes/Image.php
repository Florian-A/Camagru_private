<?php
class Image
{
    public function upload()
    {
        $json = file_get_contents('php://input');
    
        // Décoder le JSON
        $data = json_decode($json);
    
        if ($data && isset($data->image)) {
            // Récupérer les données de l'image
            $imageData = $data->image;
            $stickersId = $data->stickersId;
    
            // Supprimer le schéma de données de l'URL (si présent)
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = str_replace(' ', '+', $imageData);
    
            // Convertir les données base64 en binaire
            $imageBinary = base64_decode($imageData);
    
            // Chemin où sauvegarder l'image (assurez-vous que le répertoire est accessible en écriture)
            $filePath = './static/'; // Adapter le chemin selon votre configuration
    
            // Nom de fichier pour l'image (peut être généré de manière unique si nécessaire)
            $fileName = 'image_' . uniqid() . '.png'; // Adapter l'extension selon le type MIME de l'image
    
            // Chemin complet du fichier
            $fullPath = $filePath . $fileName;
    
            // Écrire les données de l'image dans le fichier
            $bytesWritten = file_put_contents($fullPath, $imageBinary);
    
            if ($bytesWritten !== false) {
                echo "imageData : $fullPath";
                echo "stickerId : ";
                echo implode(',', $stickersId);
            } else {
                echo "Erreur lors de la sauvegarde de l'image.";
            }
        } else {
            echo "Erreur : Données d'image non trouvées dans la requête.";
        }
    }
    
}
