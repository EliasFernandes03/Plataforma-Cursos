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

async function updateCourse() {
    const urlParams = new URLSearchParams(window.location.search);
    const courseId = urlParams.get('id');

    const updatedCourse = {
        title: document.getElementById('title').value,
        status: document.getElementById('status').value,
        description: document.getElementById('description').value,
        category: document.getElementById('category').value,
        price: document.getElementById('price').value,
        image_url: document.getElementById('image_url').value,
    };

    try {
        const response = await fetch(`http://localhost:8000/api/course/update/${courseId}`, {
            method: 'PUT',
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(updatedCourse)
        });

        if (response.ok) {

            window.location.href = '/dashboard';
        } else {
            console.error('Erro ao atualizar o curso:', response.status);
        }
    } catch (error) {
        console.error('Erro de conexão:', error);
    }
}
