
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
    <script src="build/js/index.js?v=<?php echo time(); ?>"></script>
    <!-- FUENTE LEXEND-->

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <aside class="sidebar">

      <nav>
      <img src="https://res.cloudinary.com/dzfzqzdcu/image/upload/v1743269642/wxzatw5ku2y5tnyb4nlf.jpg" class="logo"  alt="">
        <ul>
          <li><a href="index.php">Información</a></li>
          <li><a href="productos.php">Productos</a></li>
        </ul>
      </nav>
    </aside>
    <main class="content">
    <?php
      include 'src/php/db.php'; // Conexión a la base de datos

      // Consultar la cantidad total de productos
      $totalProductos = $conn->query("SELECT COUNT(*) AS total FROM productos")->fetch_assoc()['total'];

      // Consultar la cantidad de productos habilitados
      $totalHabilitados = $conn->query("SELECT COUNT(*) AS total FROM productos WHERE habilitado = 1")->fetch_assoc()['total'];

      // Consultar la cantidad de productos deshabilitados
      $totalDeshabilitados = $conn->query("SELECT COUNT(*) AS total FROM productos WHERE habilitado = 0")->fetch_assoc()['total'];

      // Consultar el producto más caro
      $productoMasCaro = $conn->query("SELECT nombre, precio FROM productos ORDER BY precio DESC LIMIT 1")->fetch_assoc();

      // Consultar el producto más barato
      $productoMasBarato = $conn->query("SELECT nombre, precio FROM productos ORDER BY precio ASC LIMIT 1")->fetch_assoc();

      ?>
    <section id="informacion" class="informacion-section">
        <h2>Información General</h2>
        <div class="info-cards">
            <div class="info-card">
                <h3>Total de Productos</h3>
                <p><?php echo $totalProductos; ?></p>
            </div>
            <div class="info-card">
                <h3>Productos Habilitados</h3>
                <p><?php echo $totalHabilitados; ?></p>
            </div>
            <div class="info-card">
                <h3>Productos Deshabilitados</h3>
                <p><?php echo $totalDeshabilitados; ?></p>
            </div>
            <div class="info-card">
                <h3>Producto Más Caro</h3>
                <p><?php echo $productoMasCaro['nombre']; ?> ($<?php echo number_format($productoMasCaro['precio'], 2); ?>)</p>
            </div>
            <div class="info-card">
                <h3>Producto Más Barato</h3>
                <p><?php echo $productoMasBarato['nombre']; ?> ($<?php echo number_format($productoMasBarato['precio'], 2); ?>)</p>
            </div>
        </div>
      </section>
  </main>
  </body>
</html>
