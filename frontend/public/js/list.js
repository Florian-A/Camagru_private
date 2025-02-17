async function displayComment(imageId) {
    const content = document.getElementById('imageId-' + imageId).value;

    try {
        const response = await fetchWithAuth('./api/comment/add/', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ imageId, content })
        });

        // Check if response is ok
        if (response.status === "success") {
            alert('Your comment: ' + content);
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
    
            console.log('Fetched images:', data);
    
            if (!Array.isArray(data)) {
                console.error('Expected an array but got:', data);
                return;
            }
    
            data.forEach(image => {
                const itemElement = document.createElement('div');
                itemElement.innerHTML = `
                    <div class="card" image-id="${image.id}">
                        <div class="card-image">
                            <img src="${image.imagePath}" class="img-responsive">
                        </div>
                        <div class="card-header">
                            <div class="card-subtitle text-gray">${image.createdAt}</div>
                        </div>
                        <div class="card-body">
                            <div class="panel">
                                <div class="panel-header">
                                    <div class="panel-title h6">Comments</div>
                                </div>
                                <div class="panel-body" id="comments-${image.id}">
                                    <!-- Comments will be inserted here -->
                                </div>
                                <div class="panel-footer">
                                    <div class="input-group">
                                        <input id="imageId-${image.id}" class="form-input" type="text" placeholder="Do you like ?">
                                        <button class="btn btn-primary input-group-btn" onclick="displayComment(${image.id})">Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                list.appendChild(itemElement);
    
                fetchComments(image.id);
            });
        } catch (error) {
            console.error('Error fetching images:', error);
        }
    }
    
    async function fetchComments(imageId) {
        try {
            const response = await fetch(`./api/comment/get/${imageId}`);
            const data = await response.json();
            
            console.log(`Fetched comments for image ${imageId}:`, data);
    
            const commentsContainer = document.getElementById(`comments-${imageId}`);
    
            if (!commentsContainer) {
                console.error(`Element with id comments-${imageId} not found.`);
                return;
            }
    
            commentsContainer.innerHTML = ''; // Clear existing comments
    
            if (data && Array.isArray(data.comments)) {
                data.comments.forEach(comment => {
                    const commentElement = document.createElement('div');
                    commentElement.classList.add('comment');
                    commentElement.innerHTML = `
                        <div class="comment-content">${comment.content}</div>
                        <div class="comment-date text-gray">${comment.createdAt}</div>
                    `;
                    commentsContainer.appendChild(commentElement);
                });
            } else {
                console.error('Invalid response format for comments:', data);
            }
        } catch (error) {
            console.error('Error fetching comments:', error);
        }
    }
    
    fetchImages();
}
