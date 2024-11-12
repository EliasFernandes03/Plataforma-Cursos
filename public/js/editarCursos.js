document.addEventListener('DOMContentLoaded', async () => {
    const urlParams = new URLSearchParams(window.location.search);
    const courseId = urlParams.get('id');

    if (!courseId) {
        alert('ID do curso não encontrado!');
        return;
    }

    try {
        const response = await fetch(`http://localhost:8000/api/course/${courseId}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });

        if (response.ok) {
            const course = await response.json();
            
            // Confirmação de dados recebidos
            console.log("Dados do curso:", course);
            
            // Preenche os campos do formulário com os dados do curso
            document.getElementById('title').value = course.title;
            document.getElementById('status').value = course.status;
            document.getElementById('description').value = course.description;
            document.getElementById('category').value = course.category;
            document.getElementById('price').value = course.price;
            document.getElementById('image_url').value = course.image_url;
        } else {
            console.error('Erro ao buscar dados do curso:', response.status);
        }
    } catch (error) {
        console.error('Erro de conexão:', error);
    }
});
