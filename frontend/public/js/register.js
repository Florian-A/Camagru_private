const form = document.getElementById('registerForm');
const messageElement = document.getElementById('message');

form.addEventListener('submit', async (event) => {
    event.preventDefault();

    const email = document.getElementById('email').value;
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    const response = await fetch('./api/account/register/', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ email, username, password })
    });

    const data = await response.json();
    messageElement.textContent = data.message;
    messageElement.classList.remove('text-success', 'text-error');
    messageElement.classList.add(data.status === 'success' ? 'text-success' : 'text-error');
});
