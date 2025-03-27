$(document).ready(function () {
  // Mostrar el modal al hacer clic en "Agregar Producto"
  $("#add-product-btn").click(function () {
    abrirModal("modalAgregar");
  });

  // Función para abrir el modal
  function abrirModal(id) {
    $("#" + id).css("display", "flex");
  }

  // Función para cerrar el modal
  function cerrarModal(id) {
    $("#" + id).css("display", "none");
  }

  // Cierra el modal si se hace clic fuera de él
  $(window).click(function (event) {
    $(".modal").each(function () {
      if (event.target == this) {
        $(this).css("display", "none");
      }
    });
  });
  // Agregar Producto
  $("#formAgregar").submit(function (e) {
    e.preventDefault();
    debugger;

    let form = document.getElementById("formAgregar");
    let formData = new FormData(form); // ✅ Captura todos los datos automáticamente

    console.log("📤 Datos del formulario:", formData);

    $.ajax({
      url: "src/php/agregar_producto.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
    })
      .done(function (data) {
        console.log("✅ Respuesta del servidor:", data);
        alert("Producto agregado correctamente");
        location.reload();
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        console.error(
          "❌ Error en la solicitud AJAX:",
          textStatus,
          errorThrown
        );
        console.error("📜 Respuesta del servidor:", jqXHR.responseText);
        alert("Error al agregar producto: " + textStatus);
      });
  });

  // Abrir modal de edición con datos del producto
  $(document).on("click", ".edit-btn", function () {
    let row = $(this).closest("tr");

    console.log("Fila seleccionada:", row.html()); // Ver qué HTML tiene la fila seleccionada

    $("#idEditar").val(row.find("td:eq(0)").text().trim()); // ID
    $("#nombreEditar").val(row.find("td:eq(1)").text().trim()); // Nombre

    let descripcion = row.find("td:eq(2)").text().trim();
    console.log("Descripción extraída:", descripcion); // Verificar si viene vacía
    $("#descripcionEditar").val(descripcion);

    let categoria = row.find("td:eq(3)").text().trim();
    console.log("Categoría extraída:", categoria);
    $("#categoriaEditar").val(categoria);

    let marca = row.find("td:eq(4)").text().trim();
    console.log("Marca extraída:", marca);
    $("#marcaEditar").val(marca);

    let precio = row.find("td:eq(5)").text().replace("$", "").trim();
    console.log("Precio extraído:", precio);
    $("#precioEditar").val(precio);

    let habilitado = row.find("td:eq(6) input[type='checkbox']").is(":checked")
      ? "1"
      : "0";
    console.log("Habilitado extraído:", habilitado);
    $("#habilitadoEditar").val(habilitado);

    abrirModal("modalEditar");
  });

  // Editar producto
  $("#formEditar").submit(function (e) {
    e.preventDefault();
    let formData = new FormData();
    formData.append("id", $("#idEditar").val());
    formData.append("nombre", $("#nombreEditar").val());
    formData.append("descripcion", $("#descripcionEditar").val());
    formData.append("categoria", $("#categoriaEditar").val());
    formData.append("marca", $("#marcaEditar").val());
    formData.append("precio", $("#precioEditar").val());
    formData.append("habilitado", $("#habilitadoEditar").val());
    if ($("#imagenEditar")[0].files.length > 0) {
      formData.append("imagen", $("#imagenEditar")[0].files[0]);
    }

    $.ajax({
      url: "src/php/editar_producto.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
    }).done(function (data) {
      location.reload();
    });
  });

  // Abrir modal de confirmación de eliminación
  $(document).on("click", ".delete-btn", function () {
    let id = $(this).data("id");
    $("#confirmarEliminar").data("id", id);
    abrirModal("modalEliminar");
  });

  // Confirmar eliminación
  $("#confirmarEliminar").click(function () {
    let id = $(this).data("id");
    $.post("src/php/eliminar_producto.php", { id: id }, function (data) {
      location.reload();
    });
  });

  // Botones para cerrar los modales
  $(".close").click(function () {
    $(this).closest(".modal").css("display", "none");
  });

  // filtro precio
  let ordenPrecio = null; // Estado inicial (sin orden)
  // ✅ Actualiza el estado de ordenPrecio antes de la llamada AJAX
    ordenPrecio = $(this).data("order");
  $("#ordenar-precio").click(function () {
    debugger
    let ordenActual = $(this).data("order");
  
    if (ordenActual === "null") {
      ordenPrecio = "asc"; // 🔼 Orden Ascendente
      $(this).data("order", "asc").text("🔽");
    } else if (ordenActual === "asc") {
      ordenPrecio = "desc"; // 🔽 Orden Descendente
      $(this).data("order", "desc").text("🔼");
    } else {
      ordenPrecio = null; // Sin orden, se muestran todos los productos sin filtrar
      $(this).data("order", "null").text("🔼🔽");
    }
  
    // ✅ Actualiza el estado de ordenPrecio antes de la llamada AJAX
    ordenPrecio = $(this).data("order");
  
    let query = $("#search-input").val();
    let habilitado = $("#filter-habilitado").data("state");
  
    cargarProductos(query, habilitado, ordenPrecio);
  });
  

  function cargarProductos(query = "", habilitadoFiltro = null, orden = null) {
    let data = { q: query };
    if (habilitadoFiltro !== null) {
      data.habilitado = habilitadoFiltro;
    }
    if (orden) {
      data.orden = orden;
    }

    $.ajax({
      url: "src/php/get_productos.php",
      type: "GET",
      data: data,
      dataType: "json",
      success: function (data) {
        let tableBody = $("#product-table-body");
        tableBody.empty();

        if (data.length > 0) {
          data.forEach(function (producto) {
            let checked = producto.habilitado == 1 ? "checked" : "";
            let row = `<tr>
                                <td>${producto.id}</td>
                                <td>${producto.nombre}</td>
                                <td>${producto.descripcion}</td>
                                <td>${producto.categoria}</td>
                                <td>${producto.marca}</td>
                                <td>$${parseFloat(producto.precio).toFixed(
                                  2
                                )}</td>
                                <td>
                                    <input type="checkbox" class="toggle-habilitado" data-id="${
                                      producto.id
                                    }" ${checked}>
                                </td>
                                <td>
                                    <img src="${
                                      producto.imagen
                                    }" alt="Imagen del producto" width="50" height="50" onerror="this.onerror=null;this.src='default.jpg';">
                                </td>
                                <td>
                                    <button class='edit-btn' data-id='${
                                      producto.id
                                    }'>✏️</button>
                                    <button class='delete-btn' data-id='${
                                      producto.id
                                    }'>🗑️</button>
                                </td>
                            </tr>`;

            tableBody.append(row);
          });
        } else {
          tableBody.append(
            "<tr><td colspan='9'>No hay productos disponibles</td></tr>"
          );
        }
      },
      error: function () {
        $("#product-table-body").append(
          "<tr><td colspan='9'>Error al cargar los productos</td></tr>"
        );
      },
    });
  }

  // 🟢 Estado inicial: intermedio (todos los productos)
  let filtroHabilitado = null;
  let filtroCheckbox = $("#filter-habilitado");
  filtroCheckbox.data("state", filtroHabilitado);
  filtroCheckbox.prop("indeterminate", true);

  // Cargar todos los productos al inicio
  cargarProductos();

  // 🔍 Filtrar productos en tiempo real (input de búsqueda)
  $("#search-input").on("input", function () {
    let query = $(this).val();
    cargarProductos(query, filtroCheckbox.data("state"));
  });

  // 🛠️ Control del ciclo de estados del checkbox de filtro
  filtroCheckbox.on("click", function () {
    let currentState = $(this).data("state");

    if (currentState === null) {
      $(this)
        .data("state", 1)
        .prop("checked", true)
        .prop("indeterminate", false); // Solo habilitados
    } else if (currentState === 1) {
      $(this)
        .data("state", 0)
        .prop("checked", false)
        .prop("indeterminate", false); // Solo no habilitados
    } else {
      $(this)
        .data("state", null)
        .prop("checked", false)
        .prop("indeterminate", true); // Todos (estado inicial)
    }

    let query = $("#search-input").val();
    cargarProductos(query, $(this).data("state"));
  });

  // ✅ Delegación de eventos para cambiar el estado del checkbox individualmente
  $(document).on("change", ".toggle-habilitado", function () {
    let productId = $(this).data("id");
    let nuevoEstado = $(this).is(":checked") ? 1 : 0;

    $.post(
      "src/php/editar_producto.php",
      {
        id: productId,
        habilitado: nuevoEstado,
      },
      function () {
        console.log("Estado actualizado");
      }
    ).fail(function () {
      alert("Error al actualizar el estado");
    });
  });

  //Funcion Exportar Excel

    // Evento al hacer clic en el botón Excel
    $("#export-excel-btn").on("click", function () {
      exportToExcel();
    });

    function exportToExcel() {
      debugger;
      let table = $("#product-table-body");
      let rows = table.find("tr");
      let data = [];

      // Agregar encabezados (sin imagen)
      let headers = [
        "ID",
        "Nombre",
        "Descripción",
        "Categoría",
        "Marca",
        "Precio",
        "Habilitado",
      ];
      data.push(headers);

      // Recorrer las filas de la tabla
      rows.each(function () {
        let cells = $(this).find("td");
        if (cells.length > 0) {
          let habilitadoIcon = cells
            .eq(6)
            .find("input[type='checkbox']")
            .is(":checked")
            ? "✅ Sí"
            : "❌ No";

          let rowData = [
            cells.eq(0).text().trim(), // ID
            cells.eq(1).text().trim(), // Nombre
            cells.eq(2).text().trim(), // Descripción
            cells.eq(3).text().trim(), // Categoría
            cells.eq(4).text().trim(), // Marca
            cells.eq(5).text().trim(), // Precio
            habilitadoIcon, // Habilitado con ícono de texto
          ];
          data.push(rowData);
        }
      });

      // Crear la hoja de Excel
      let ws = XLSX.utils.aoa_to_sheet(data);
      let wb = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(wb, ws, "Productos");

      // Descargar el archivo
      XLSX.writeFile(wb, "productos.xlsx");
    }
  });


