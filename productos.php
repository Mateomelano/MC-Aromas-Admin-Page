<?php include 'src/php/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>MC Aromas - Productos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Importar jQuery -->
    <script src="src/js/app.js"></script>
    <link rel="stylesheet" href="build/css/app.css?v=<?php echo time(); ?>">

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
            <input type="text" id="search-input" placeholder="Buscar...">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Categoría</th>
                        <th>Marca</th>
                        <th>Precio 
                            <span id="ordenar-precio" class="orden-icon" data-order="null">🔼🔽🎲</span>
                        </th>
                        <th>Habilitado 
                            <input type="checkbox" id="filter-habilitado" data-state="null">
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

    <script>
        $(document).ready(function () {
            function cargarProductos(query = '', habilitadoFiltro = null) {
                let data = { q: query };
                if (habilitadoFiltro !== null) {
                    data.habilitado = habilitadoFiltro;
                }

                $.ajax({
                    url: 'src/php/get_productos.php',
                    type: 'GET',
                    data: data,
                    dataType: 'json',
                    success: function (data) {
                        let tableBody = $('#product-table-body');
                        tableBody.empty();

                        if (data.length > 0) {
                            data.forEach(function (producto) {
                                let checked = producto.habilitado == 1 ? 'checked' : '';
                                let row = `<tr>
                                            <td>${producto.id}</td>
                                            <td>${producto.nombre}</td>
                                            <td>${producto.descripcion}</td>
                                            <td>${producto.categoria}</td>
                                            <td>${producto.marca}</td>
                                            <td>$${parseFloat(producto.precio).toFixed(2)}</td>
                                            <td>
                                                <input type="checkbox" class="toggle-habilitado" data-id="${producto.id}" ${checked}>
                                            </td>
                                            <td>
                                                <img src="${producto.imagen}" alt="Imagen del producto" width="50" height="50" onerror="this.onerror=null;this.src='default.jpg';">
                                            </td>
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
                    error: function () {
                        $('#product-table-body').append("<tr><td colspan='7'>Error al cargar los productos</td></tr>");
                    }
                });
            }

            // 🟢 Estado inicial: intermedio (todos los productos)
            let filtroHabilitado = null;
            let filtroCheckbox = $('#filter-habilitado');
            filtroCheckbox.data('state', filtroHabilitado);
            filtroCheckbox.prop('indeterminate', true);

            // Cargar todos los productos al inicio
            cargarProductos();

            // Filtrar productos en tiempo real (input de búsqueda)
            $('#search-input').on('input', function () {
                let query = $(this).val();
                cargarProductos(query, filtroCheckbox.data('state'));
            });

            // 🛠️ Control del ciclo de estados del checkbox
            filtroCheckbox.on('click', function () {
                let currentState = $(this).data('state');

                if (currentState === null) {
                    $(this).data('state', 1).prop('checked', true).prop('indeterminate', false); // Solo habilitados
                } else if (currentState === 1) {
                    $(this).data('state', 0).prop('checked', false).prop('indeterminate', false); // Solo no habilitados
                } else {
                    $(this).data('state', null).prop('checked', false).prop('indeterminate', true); // Todos (estado inicial)
                }

                let query = $('#search-input').val();
                cargarProductos(query, $(this).data('state'));
            });

            // Delegación de eventos para cambiar el estado del checkbox individualmente
            $(document).on('change', '.toggle-habilitado', function () {
                let productId = $(this).data('id');
                let nuevoEstado = $(this).is(':checked') ? 1 : 0;

                $.post('src/php/editar_producto.php', {
                    id: productId,
                    habilitado: nuevoEstado
                }, function (data) {
                    console.log('Estado actualizado');
                }).fail(function () {
                    alert('Error al actualizar el estado');
                });
            });
        });
    </script>
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
            <input type="text" id="marcaAgregar" name="marca" required>

            <label>Precio:</label>
            <input type="number" id="precioAgregar" name="precio" required>

            <label>Imagen:</label>
            <input type="file" id="imagenAgregar" name="imagen" accept="image/*" required>

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
        <h2>Editar Producto</h2>
        <form id="formEditar" enctype="multipart/form-data">
            <input type="hidden" id="idEditar" name="id">

            <label>Nombre:</label>
            <input type="text" id="nombreEditar" name="nombre" required>

            <label>Descripción:</label>
            <input type="text" id="descripcionEditar" name="descripcion" required>
            
            <label>Categoría:</label>
            <input type="text" id="categoriaEditar" name="categoria" required>

            <label>Marca:</label>
            <input type="text" id="marcaEditar" name="marca" required>

            <label>Precio:</label>
            <input type="number" id="precioEditar" name="precio" required>

            <label>Imagen:</label>
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
