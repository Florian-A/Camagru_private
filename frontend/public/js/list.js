
async function displayComment(itemId) {
    let inputText = document.getElementById('imageId-' + itemId).value;

    try {
        const response = await fetchWithAuth('./api/comment/add/', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ itemId, inputText })
        });

        // Vérifier si la réponse est ok
        if (response.ok) {
            alert('Your comment: ' + inputText);
        } else {
            alert('Failed to submit comment.');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred while submitting your comment.');
    }
}

if (typeof list === 'undefined') {



    const list = document.getElementById('list-element');

    async function fetchImages() {
        try {
            const response = await fetch('./api/image/getall/');
            const data = await response.json();

            console.log(data);

            data.forEach(item => {
                const itemElement = document.createElement('div');
                itemElement.innerHTML = `
                    <div class="card" image-id="${item.id}">
                        <div class="card-image">
                            <img src="${item.imagePath}" class="img-responsive">
                        </div>
                        <div class="card-header">
                            <div class="card-subtitle text-gray">${item.createdAt}</div>
                        </div>
                        <div class="card-body">
                            <div class="panel">
                            <div class="panel-header">
                                <div class="panel-title h6">Comments</div>
                            </div>
                            <div class="panel-body">


                            </div>
                            <div class="panel-footer">
                                <div class="input-group">
                                    <input id="imageId-${item.id}" class="form-input" type="text" placeholder="Do you like ?">
                                    <button class="btn btn-primary input-group-btn" onclick="(async () => await displayComment(${item.id}))()">Send</button>
                                </div>
                            </div>
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
