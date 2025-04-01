<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - MC Aromas</title>
    
    <!-- Fuente Lexend -->
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="build/css/app.css?v=<?php echo time(); ?>">
</head>
<body class="login-body">
    <div class="login-container">
        <!-- Logo -->
        <img src="https://res.cloudinary.com/dzfzqzdcu/image/upload/v1743269642/wxzatw5ku2y5tnyb4nlf.jpg" class="logo" alt="MC Aromas Logo">
        
        <h2>Iniciar Sesión</h2>
        <p>Ingresa tus credenciales</p>
        
        <!-- Línea decorativa -->
        <div class="divider"><span>-</span></div>

        <input class="input-login" type="text" id="username" placeholder="Ingresar Usuario">
        <input class="input-login" type="password" id="password" placeholder="Ingresar Contraseña">
        <button class="button-login" onclick="login()">Login</button>
        
        <p id="error-message">Usuario o contraseña incorrectos</p>
    </div>
    
    <script src="build/js/login.js"></script>
</body>
</html