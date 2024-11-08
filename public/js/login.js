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
            alert(errorData.message || 'Erro ao fazer login');
        }
    } catch (error) {
        console.error('Erro na requisição:', error);
    }
}

document.getElementById('loginButton').addEventListener('click', handleLogin);
