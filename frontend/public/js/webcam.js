if (typeof video === 'undefined') {

    const video = document.getElementById('videoElement');
    const canvas = document.getElementById('canvasElement');
    const context = canvas.getContext('2d');
    const deselectButton = document.getElementById('deselectImage');
    const uploadButton = document.getElementById('uploadImage');
    let overlayStickers = [];

    // Request access to the webcam
    navigator.mediaDevices.getUserMedia({ video: true })
        .then((stream) => {
            video.srcObject = stream;
        })
        .catch((error) => {
            console.error('Webcam access error:', error);
        });

    // Deselect the currently overlaid image
    deselectButton.addEventListener('click', () => {
        overlayStickers = [];
    });

    // Function to load an image from a specified source and overlay or remove it from the canvas
    function toggleImage(source, id) {
        const img = new Image();
        img.id = id;
        img.onload = () => {
            const index = overlayStickers.findIndex(image => image.src === img.src);
            if (index !== -1) {
                overlayStickers.splice(index, 1);
            } else {
                overlayStickers.push(img);
            }
        };
        img.src = source;
    }

    // Function to capture the current image from the canvas and send it via POST
    async function uploadImage() {
        try {
            // Create a copy of the canvas without the stickers
            const tempCanvas = document.createElement('canvas');
            tempCanvas.width = canvas.width;
            tempCanvas.height = canvas.height;
            const tempContext = tempCanvas.getContext('2d');
            tempContext.drawImage(video, 0, 0, tempCanvas.width, tempCanvas.height);

            // Capture the image from the temporary canvas in base64 format
            const imageData = tempCanvas.toDataURL('image/png');

            // Get the IDs of the selected stickers
            const selectedStickersIds = overlayStickers.map(img => img.id);

            // Send the image and the IDs of the selected stickers via a POST request
            const response = await fetchWithAuth('./api/image/upload/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ image: imageData, stickersId: selectedStickersIds })
            });

            if (response.status !== "success") {
                throw new Error();
            }
            alert('Image uploaded successfully!');
        } catch (error) {
            console.error('Image upload error:', error);
            alert('Image upload error. Please try again.');
        }
    }

    async function stickerInjector() {
        const divStiker = document.getElementById('sticker');

        try {
            const response = await fetch(`./api/sticker/all/`);
            const data = await response.json();

            if (data.status === 'success') {
                data.data.forEach(sticker => {
                    const img = document.createElement('img');
                    img.src = sticker.imagePath;
                    img.classList.add('sticker-image');
                    img.addEventListener('click', () => {
                        toggleImage(sticker.imagePath, sticker.id);
                    });
                    divStiker.appendChild(img);
                });
            } else {
                console.error('Error:', data);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    // Draw the video stream and the overlaid images on the canvas
    video.addEventListener('play', () => {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        const draw = () => {
            if (video.paused || video.ended) return;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            overlayStickers.forEach(img => {
                context.drawImage(img, 0, 0, canvas.width, canvas.height);
            });
            requestAnimationFrame(draw);
        };
        draw();
    });
    // Listen for the upload button click
    uploadButton.addEventListener('click', uploadImage);

    // Load the stickers when the page loads
    window.onload = stickerInjector();


    let data1;
    // Fonction pour récupérer et stocker les données
    async function fetchData1() {
        try {
            data1 = await fetchWithAuth('./api/account/check/');
            console.log(data1); // Utilisez la variable `data` comme vous le souhaitez
        } catch (error) {
            console.error('Error:', error);
        }
    }

    // Appel initial de la fonction pour récupérer les données
    fetchData1();
    console.log(data1);

    let data2;
    // Fonction pour récupérer et stocker les données
    async function fetchData2() {
        try {
            data1 = await fetch('./api/image/getall/');
            console.log(data2); // Utilisez la variable `data` comme vous le souhaitez
        } catch (error) {
            console.error('Error:', error);
        }
    }

    // Appel initial de la fonction pour récupérer les données
    fetchData2();
    console.log(data2);

}
