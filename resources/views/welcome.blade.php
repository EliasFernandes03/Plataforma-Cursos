<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <title>Document</title>
</head>

<body>
    <div class="containerLogo">
        <img class="logoHome"
            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRgepSXZUGD3MOVbjYeTgX_00ecGjkPFqu1sg&s" alt="">
    </div>

    <div class="containerForm">
        <div class="form">
            <div class="titles">
                <h1>Acesse sua conta</h1>
                <p>Novo cliente? Então registre-se <a href="createAccount.blade.php">aqui</a></p>
            </div>
            <div class="inputsLogin">
                <label for="">Login *</label>
                <input type="text" name="" id="email" placeholder="Insira seu login">
                <label for="">Password *</label>
                <input type="password" name="" id="password" placeholder="Insira sua senha">
                <a href="">Esqueci minha senha</a>
                <button id="loginButton" >Acessar Conta</button>
            </div>
            <div class="accessAccount">

                <p>Ou faca login com</p> <img
                    src="https://play-lh.googleusercontent.com/KSuaRLiI_FlDP8cM4MzJ23ml3og5Hxb9AapaGTMZ2GgR103mvJ3AAnoOFz1yheeQBBI"
                    alt="" class="logoGmail">
            </div>
        </div>

    </div>

    <script src="{{ asset('js/login.js') }}"></script>
</body>

</html>