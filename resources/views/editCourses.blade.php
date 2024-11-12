<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/editarCursos.css') }}">
    <title>Editar Curso</title>
</head>

<body>
    <div class="form-container">
        <h2>Editar Curso</h2>
        <form onsubmit="event.preventDefault(); updateCourse();">
            <input type="hidden" id="courseId" name="courseId">

            <label for="title">Título:</label>
            <input type="text" id="title" required>

            <label for="status">Status:</label>
            <input type="text" id="status" required>

            <label for="description">Descrição:</label>
            <textarea id="description" rows="4" required></textarea>

            <label for="category">Categoria:</label>
            <input type="text" id="category" required>

            <label for="price">Preço:</label>
            <input type="number" id="price" required>

            <label for="image_url">URL da Imagem:</label>
            <input type="text" id="image_url" required>

            <button type="submit">Salvar Alterações</button>
        </form>
    </div>
    <script src="{{ asset('js/editarCursos.js') }}"></script>
</body>

</html>