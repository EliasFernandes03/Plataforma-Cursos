<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <title>Dashboard</title>
</head>

<style>

</style>

<body>

    <div class="sidebar">
        <ul>
            <li><img class="avatarImage" src="https://cdn-icons-png.flaticon.com/512/3135/3135768.png" alt=""></li>
            <li><a href="#">Home</a></li>
            <li><a href="#">Cursos</a></li>
            <li><a href="#">Usuários</a></li>
            <li><a href="#">Configurações</a></li>
            <li><a href="#">Sair</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h2>Painel de Controle</h2>
            <span class="user">Olá, Usuário!</span>
        </div>

        <!-- Container para os cards de cursos -->
        <div id="courses-container" class="courses-container">
            <h3 id="cursosDisponiveis">Cursos Disponíveis</h3>
            <div id="courses" class="cards-container"></div>
        </div>
    </div>

    <script src="{{ asset('js/listarCursos.js') }}"></script>

</body>

</html>