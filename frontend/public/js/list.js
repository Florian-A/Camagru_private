if (typeof list === 'undefined') {


    const list = document.getElementById('listElement');

    // Fonction pour récupérer et stocker les données
    async function fetchData2() {
        try {
            const response = await fetch('./api/image/getall/');
            const data = await response.json(); // Convertir la réponse en JSON

            // Parcourir le tableau JSON et créer des éléments HTML pour chaque objet
            data.forEach(item => {
                const itemElement = document.createElement('div');
                itemElement.innerHTML = `
                    <p>Image Path: ${item.imagePath}</p>
                    <img src="${item.imagePath}" />
                    <p>Created At: ${item.createdAt}</p>
                `;
                list.appendChild(itemElement); // Ajouter l'élément à la liste
            });
        } catch (error) {
            console.error('Error:', error);
        }
    }

    // Appel initial de la fonction pour récupérer les données
    fetchData2();
}
