if (typeof loginForm === 'undefined') {

    const loginForm = document.getElementById('login');
    const messageElement = document.getElementById('message');

    console.log('test');

    loginForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        const response = await fetch('/api/account/login/', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email, password })
        });

        const data = await response.json();
        messageElement.textContent = data.message;
        messageElement.classList.remove('text-success', 'text-error');
        messageElement.classList.add(data.status === 'success' ? 'text-success' : 'text-error');
    });

}