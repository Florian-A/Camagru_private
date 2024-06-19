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

            // Convertir les données base64 en binaire (si nécessaire)
            $imageBinary = base64_decode($imageData);

            // Chemin où sauvegarder l'image (assurez-vous que le répertoire est accessible en écriture)
            $filePath = './'; // Adapter le chemin selon votre configuration

            // Nom de fichier pour l'image (peut être généré de manière unique si nécessaire)
            $fileName = 'image_' . uniqid() . '.jpg'; // Adapter l'extension selon le type MIME de l'image

            // Chemin complet du fichier
            $fullPath = $filePath . $fileName;

            // Écrire les données de l'image dans le fichier
            $bytesWritten = file_put_contents($fullPath, $imageBinary);

            if ($bytesWritten !== false) {
                echo "L'image a été sauvegardée avec succès : $fullPath";
            } else {
                echo "Erreur lors de la sauvegarde de l'image.";
            }
        } else {
            echo "Erreur : Données d'image non trouvées dans la requête.";
        }
    }
}
