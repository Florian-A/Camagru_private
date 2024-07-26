function storeToken(token) {
    localStorage.setItem('authToken', token);
}

function getToken() {
    return localStorage.getItem('authToken');
}

async function fetchWithAuth(url, options = {}) {
    const token = getToken();

    if (token) {
        options.headers = {
            ...options.headers,
            'Authorization': `Bearer ${token}`
        };
    }
    const response = await fetch(url, options);
    return response.json();
}

// One page navigation block
function navigate(event, page) {
    event.preventDefault();
    history.pushState(null, '', `/${page}`);
    loadContent(page);
}

window.onpopstate = function () {
    const path = window.location.pathname.split('/')[1];
    loadContent(path);
};

document.addEventListener('DOMContentLoaded', () => {
    const initialPage = window.location.pathname.split('/')[1] || 'home';
    loadContent(initialPage);
});

function loadContent(page) {
    fetch(`${page}.html`)
        .then(response => response.text())
        .then(data => {
            document.getElementById('content').innerHTML = data;
            if (page === 'home') {
                const script = document.createElement('script');
                script.src = '/js/webcam.js';
                document.body.appendChild(script);
            } else if (page === 'register') {
                const script = document.createElement('script');
                script.src = '/js/register.js';
                document.body.appendChild(script);
            } else if (page === 'login') {
                const script = document.createElement('script');
                script.src = '/js/login.js';
                document.body.appendChild(script);
            }
        })
        .catch(error => {
            console.error('Error loading the page:', error);
            document.getElementById('content').innerHTML = '<p>Loading page error !</p>';
        });
}