<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - MC Aromas</title>
    <link rel="stylesheet" href="build/css/app.css">
</head>
<body class="login-body">
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <input class="input-login" type="text" id="username" placeholder="Usuario">
        <input class="input-login" type="password" id="password" placeholder="Contraseña">
        <button class="button-login" onclick="login()">Ingresar</button>
        <p id="error-message" style="color: red; display: none;">Usuario o contraseña incorrectos</p>
    </div>
    <script src="build/js/login.js"></script>
</body>
</html>
