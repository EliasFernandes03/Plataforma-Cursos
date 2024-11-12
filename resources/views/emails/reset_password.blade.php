<!DOCTYPE html>
<html>

<head>
    <title>Redefinição de Senha</title>
</head>

<body>
    <p>Olá,</p>
    <p>Você solicitou uma redefinição de senha. Clique no link abaixo para redefinir sua senha:</p>
    <p><a href="{{ url('/reset-password?token=' . $token) }}">Redefinir Senha</a></p>
    <p>Se você não solicitou a redefinição, ignore este e-mail.</p>
</body>

</html>