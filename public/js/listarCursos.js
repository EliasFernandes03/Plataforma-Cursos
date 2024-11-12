async function fetchCourses() {
    try {
        const response = await fetch('http://localhost:8000/api/course', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });

        if (response.ok) {
            const courses = await response.json();
            renderCourses(courses);
        } else {
            console.error('Erro ao buscar cursos:', response.status);
        }
    } catch (error) {
        console.error('Erro de conexão:', error);
    }
}

function renderCourses(courses) {
    const coursesContainer = document.getElementById('courses');
    coursesContainer.innerHTML = '';

    const isAdmin = localStorage.getItem('role') === 'admin';

    courses.forEach(course => {
        const card = document.createElement('div');
        card.classList.add('card');

        card.innerHTML = `
            <img src="${course.image_url}" width="70vw" height="50vh" alt="">
            <h4>${course.title}</h4>
            <strong><p>${course.status}</p></strong>
            <p>${course.description}</p>
            <p>${course.category}</p>
            <button onclick="enrollCourse(${course.id})">Inscrever-se R$ ${course.price}</button>
        `;

        if (isAdmin) {
            const adminButtons = document.createElement('div');
            adminButtons.classList.add('admin-buttons');
            adminButtons.innerHTML = `
                <button id="editarButton" onclick="editCourse(${course.id})">Editar</button>
                <button id="excluirButton" onclick="deleteCourse(${course.id})">Excluir</button>
            `;
            adminButtons.style.display = 'none';
            card.appendChild(adminButtons);

            card.addEventListener('mouseover', () => {
                adminButtons.style.display = 'block';
            });

            card.addEventListener('mouseout', () => {
                adminButtons.style.display = 'none';
            });
        }

        coursesContainer.appendChild(card);
    });
}

function editCourse(courseId) {
    alert(`Editar curso ${courseId}`);
    // Lógica para editar o curso
}

function deleteCourse(courseId) {
    alert(`Excluir curso ${courseId}`);
    // Lógica para excluir o curso
}


function enrollCourse(courseId) {
    alert(`Curso ${courseId} selecionado!`);
}


fetchCourses();