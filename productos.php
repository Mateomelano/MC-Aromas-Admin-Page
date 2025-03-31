
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>MC Aromas - Productos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Importar jQuery -->
    <!-- Estilos -->
    <link rel="stylesheet" href="build/css/app.css?v=<?php echo time(); ?>">
    <!-- JS -->
    <script src="build/js/app.js?v=<?php echo time(); ?>"></script>
    <!-- Excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <!-- Fuente Lexend -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet" />
</head>
<body>
    
    <aside class="sidebar">
        <nav>
            <img src="https://res.cloudinary.com/dzfzqzdcu/image/upload/v1743269642/wxzatw5ku2y5tnyb4nlf.jpg" class="logo"  alt="">
            <ul>
                <li><a href="index.php">Información</a></li>
                <li><a href="productos.php">Productos</a></li>
                <li><a href="banners.php">Banners</a></li>
                <li><a href="pedidos.php">Pedidos</a></li>
            </ul>
        </nav>
    </aside>

    <main class="content">
        <section id="productos" class="productos-section">
            <h2>Lista de Productos</h2>
            <div class = "filter-container">
                <button id="add-product-btn" class="btn">➕ Agregar Producto</button>
                <input type="text" id="search-input" placeholder="Buscar...🔍">
                <button id="export-excel-btn" class="btn-excel">📊 Exportar Excel</button>

            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Categoría</th>
                        <th>Marca</th>
                        <th>Precio 
                            <span id="ordenar-precio" class="orden-icon" data-order="null">🔼🔽</span>
                        </th>
                        <th>Precio Mayorista 
                            <span id="ordenar-preciomayorista" class="orden-icon" data-order="null">🔼🔽</span>
                        </th>
                        <th>Habilitado 
                            <label class="checkbox-container">
                                <input type="checkbox" id="filter-habilitado" data-state="null"> <!-- Asegúrate de agregar data-state -->
                            </label>
                        </th>
                        </th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="product-table-body">
                    <!-- Aquí se cargarán los productos con AJAX -->
                </tbody>
            </table>
        </section>
    </main>

<!-- Modal Agregar Producto -->
<div id="modalAgregar" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal('modalAgregar')">&times;</span>
        <h2>Agregar Producto</h2>
        <form id="formAgregar" enctype="multipart/form-data">
            <label>Nombre:</label>
            <input type="text" id="nombreAgregar" name="nombre" required>

            <label>Descripción:</label>
            <input type="text" id="descripcionAgregar" name="descripcion" required>
            
            <label>Categoría:</label>
            <input type="text" id="categoriaAgregar" name="categoria" required>

            <label>Marca:</label>
            <select id="marcaAgregar" name="marcaSelect">
                <option value="" disabled selected>Seleccionar marca existente</option>
                <!-- Aquí se van a cargar las marcas desde la base de datos -->
            </select>
            <input type="text" id="nuevaMarcaAgregar" name="nuevaMarca" placeholder="O escribe una nueva marca (Opcional)">

            <label>Precio:</label>
            <input type="number" id="precioAgregar" name="precio" required>

            <label>Precio Mayorista:</label>
            <input type="number" id="precioMayoristaAgregar" name="precioMayorista" required>

            <label>Imagen:</label>
            <input type="file" id="imagenAgregar" name="imagen" accept="image/*">

            <label>Habilitado:</label>
            <select id="habilitadoAgregar" name="habilitado">
                <option value="1">Sí</option>
                <option value="0">No</option>
            </select>

            <button type="submit">Agregar</button>
        </form>
    </div>
</div>

<!-- Modal Editar Producto -->

<div id="modalEditar" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal('modalEditar')">&times;</span>
        <form id="formEditar" enctype="multipart/form-data">
            <input type="hidden" id="idEditar" name="id">

            <label>Nombre:</label>
            <input type="text" id="nombreEditar" name="nombre" required>

            <label>Descripción:</label>
            <input type="text" id="descripcionEditar" name="descripcion" required>

            <label>Categoría:</label>
            <input type="text" id="categoriaEditar" name="categoria" required>

            <label>Marca:</label>
            <select id="marcaEditar" name="marca" required>
                <option value="" disabled selected>Seleccionar o agregar nueva marca</option>
            </select>
            <input type="text" id="nuevaMarcaEditar" placeholder="Nueva Marca (Opcional)">
            <br>

            <label>Precio:</label>
            <input type="number" id="precioEditar" name="precio" required>

            <label>Precio Mayorista:</label>
            <input type="number" id="preciomayoristaEditar" name="precioMayorista" required>

            <label>Imagen Actual:</label>
            <div>
                <img id="imagenActual" src="" alt="Imagen Actual" style="width: 150px;">
            </div>

            <!-- Input oculto para la URL actual -->
            <input type="hidden" id="imagenUrlActual" name="imagenUrlActual">

            <label>Subir Nueva Imagen (Opcional):</label>
            <input type="file" id="imagenEditar" name="imagen" accept="image/*">

            <label>Habilitado:</label>
            <select id="habilitadoEditar" name="habilitado">
                <option value="1">Sí</option>
                <option value="0">No</option>
            </select>

            <button type="submit">Guardar Cambios</button>
        </form>
    </div>
</div>


<!-- Modal Confirmar Eliminación -->
<div id="modalEliminar" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal('modalEliminar')">&times;</span>
        <h2>¿Estás seguro?</h2>
        <p>¿Quieres eliminar este producto?</p>
        <button id="confirmarEliminar">Eliminar</button>
        <button onclick="cerrarModal('modalEliminar')">Cancelar</button>
    </div>
</div>

    


</body>
</html>
