function navigate(event, page) {
    event.preventDefault();
    history.pushState(null, '', `/${page}`);
    loadContent(page);
}

function loadContent(page) {
    fetch(`${page}.html`)
        .then(response => response.text())
        .then(data => {
            document.getElementById('content').innerHTML = data;
            if (page === 'home') {
                const script = document.createElement('script');
                script.src = '/js/webcam.js';
                document.body.appendChild(script);
            }
        })
        .catch(error => {
            console.error('Error loading the page:', error);
            document.getElementById('content').innerHTML = '<p>Loading page error !</p>';
        });
}

window.onpopstate = function () {
    const path = window.location.pathname.split('/')[1];
    loadContent(path);
};

document.addEventListener('DOMContentLoaded', () => {
    const initialPage = window.location.pathname.split('/')[1] || 'home';
    loadContent(initialPage);
});
