if (typeof list === 'undefined') {


    const list = document.getElementById('listElement');

    async function fetchImages() {
        try {
            const response = await fetch('./api/image/getall/');
            const data = await response.json();

            data.forEach(item => {
                const itemElement = document.createElement('div');
                itemElement.innerHTML = `
                    <div class="card">
                        <div class="card-image">
                            <img src="${item.imagePath}" class="img-responsive">
                        </div>
                        <div class="card-header">
                            <div class="card-subtitle text-gray">${item.createdAt}</div>
                        </div>
                        <div class="card-body">
                            ...
                        </div>
                    </div>

                `;
                list.appendChild(itemElement);
            });
        } catch (error) {
            console.error('Error:', error);
        }
    }

    fetchImages();
}
