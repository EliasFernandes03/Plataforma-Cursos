async function handleLogin(event) {

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    try {
        const response = await fetch('http://localhost:8000/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email, password })
        });

        if (response.ok) {
            const data = await response.json();
            window.location.href = "/dashboard"
        } else {
            const errorData = await response.json();
            errorMessage.textContent = errorData.message || 'Credenciais incorretas';
            errorMessage.style.display = 'block';
        }
    } catch (error) {
        errorMessage.textContent = errorData.message || 'Credenciais incorretas';
        errorMessage.style.display = 'block';
    }
}

document.getElementById('loginButton').addEventListener('click', handleLogin);
