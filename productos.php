<?php include 'src/php/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>MC Aromas - Productos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Importar jQuery -->
    <script src="build/js/app.js"></script>
    <link rel="stylesheet" href="build/css/app.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet" />
</head>
<body>
    
    <aside class="sidebar">
        <nav>
            <ul>
                <li><a href="index.php">Información</a></li>
                <li><a href="productos.php">Productos</a></li>
            </ul>
        </nav>
    </aside>

    <main class="content">
        <section id="productos" class="productos-section">
            <h2>Lista de Productos</h2>
            <button id="add-product-btn" class="btn">➕ Agregar Producto</button>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Marca</th>
                        <th>Precio</th>
                        <th>Habilitado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="product-table-body">
                    <!-- Aquí se cargarán los productos con AJAX -->
                </tbody>
            </table>
        </section>
    </main>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'src/php/get_productos.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    let tableBody = $('#product-table-body');
                    tableBody.empty();

                    if (data.length > 0) {
                        data.forEach(function(producto) {
                            let row = `<tr>
                                <td>${producto.id}</td>
                                <td>${producto.nombre}</td>
                                <td>${producto.categoria}</td>
                                <td>${producto.marca}</td>
                                <td>$${parseFloat(producto.precio).toFixed(2)}</td>
                                <td>${producto.habilitado == 1 ? 'Sí' : 'No'}</td>
                                <td>
                                    <button class='edit-btn' data-id='${producto.id}'>✏️</button>
                                    <button class='delete-btn' data-id='${producto.id}'>🗑️</button>
                                </td>
                            </tr>`;
                            tableBody.append(row);
                        });
                    } else {
                        tableBody.append("<tr><td colspan='7'>No hay productos disponibles</td></tr>");
                    }
                },
                error: function() {
                    $('#product-table-body').append("<tr><td colspan='7'>Error al cargar los productos</td></tr>");
                }
            });
        });
    </script>
<!-- Modal Agregar Producto -->
<div id="modalAgregar" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal('modalAgregar')">&times;</span>
        <h2>Agregar Producto</h2>
        <form id="formAgregar">
            <label>Nombre:</label>
            <input type="text" id="nombreAgregar" required>
            
            <label>Categoría:</label>
            <input type="text" id="categoriaAgregar" required>

            <label>Marca:</label>
            <input type="text" id="marcaAgregar" required>

            <label>Precio:</label>
            <input type="number" id="precioAgregar" required>

            <label>Habilitado:</label>
            <select id="habilitadoAgregar">
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
        <h2>Editar Producto</h2>
        <form id="formEditar">
            <input type="hidden" id="idEditar">

            <label>Nombre:</label>
            <input type="text" id="nombreEditar" required>
            
            <label>Categoría:</label>
            <input type="text" id="categoriaEditar" required>

            <label>Marca:</label>
            <input type="text" id="marcaEditar" required>

            <label>Precio:</label>
            <input type="number" id="precioEditar" required>

            <label>Habilitado:</label>
            <select id="habilitadoEditar">
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
