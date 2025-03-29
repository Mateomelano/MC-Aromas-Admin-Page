<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>MC Aromas Admin Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Estilos -->
    <link rel="stylesheet" href="build/css/app.css?v=<?php echo time(); ?>">
    <!-- JS -->
    <script src="build/js/banners.js?v=<?php echo time(); ?>" defer></script>
    <!-- FUENTE LEXEND-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet"/>
  </head>
  <body>
    <aside class="sidebar">
      <nav>
        <img src="https://res.cloudinary.com/dzfzqzdcu/image/upload/v1743269642/wxzatw5ku2y5tnyb4nlf.jpg" class="logo" alt="">
        <ul>
          <li><a href="index.php">Información</a></li>
          <li><a href="productos.php">Productos</a></li>
          <li><a href="banners.php">Banners</a></li>
        </ul>
      </nav>
    </aside>
        <main class="content">
        <h2>Gestión de Banners</h2>
        <label for="uploadBanner" id="uploadLabel">Agregar Imagen</label>
        <input type="file" id="uploadBanner" accept="image/*">
        <div id="bannerContainer"></div>
        </main>
  </body>
</html>
