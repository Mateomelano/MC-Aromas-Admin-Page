<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>MC Aromas Admin Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/jpeg"
        href="https://res.cloudinary.com/dzfzqzdcu/image/upload/v1743554383/ari6vwivcy0ndoeqpmmw.jpg">
    <!-- Estilos -->
    <link rel="stylesheet" href="build/css/app.css?v=<?php echo time(); ?>">
    <!-- JS -->
    <script src="build/js/ventas.js?v=<?php echo time(); ?>" defer></script>
    <!-- FUENTE LEXEND-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet" />
    <!-- PDF-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.plugin.standard_fonts.min.js"></script>

</head>

<body>


    <aside class="sidebar">
        <nav>
            <img src="https://res.cloudinary.com/dzfzqzdcu/image/upload/v1743554383/ari6vwivcy0ndoeqpmmw.jpg"
                class="logo" alt="">
            <ul>
                <li><a href="index.php">Información</a></li>
                <li><a href="productos.php">Productos</a></li>
                <li><a href="banners.php">Banners</a></li>
                <li><a href="pedidos.php">Pedidos</a></li>
                <li><a href="ventas.php">Ventas</a></li>
                <button id="logout-button">Cerrar Sesión</button>
            </ul>
        </nav>
    </aside>

    <div class="content">

        <section class="tabla-ventas">
            <h2>🧾 Ventas realizadas</h2>
            <table id="tabla-ventas" style="width:100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Productos</th>
                        <th>Total</th>
                        <th>Total Mayorista</th>
                        <th>Entregado</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

        </section>
    </div>



</body>

</html>
<script>
    if (!sessionStorage.getItem("loggedIn")) {
        window.location.href = "login.php"; // Si no está logueado, redirigir a login
    }
    document.getElementById("logout-button").addEventListener("click", function () {
        sessionStorage.removeItem("loggedIn"); // Elimina la sesión
        window.location.href = "login.php"; // Redirige al login
    });
</script>