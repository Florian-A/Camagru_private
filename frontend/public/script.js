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
        })
        .catch(error => {
            console.error('Error loading the page:', error);
            document.getElementById('content').innerHTML = '<p>Erreur lors du chargement de la page.</p>';
        });
}

window.onpopstate = function() {
    const path = window.location.pathname.split('/')[1];
    loadContent(path);
};

// Charger le contenu initial en fonction de l'URL actuelle
document.addEventListener('DOMContentLoaded', () => {
    const initialPage = window.location.pathname.split('/')[1] || 'page1';
    loadContent(initialPage);
});
