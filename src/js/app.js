
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
        console.error("❌ Error en la solicitud AJAX:", textStatus, errorThrown);
        console.error("📜 Respuesta del servidor:", jqXHR.responseText);
        alert("Error al agregar producto: " + textStatus);
    });
});


  // Abrir modal de edición con datos del producto
  $(document).on("click", ".edit-btn", function () {
    let row = $(this).closest("tr");
  
    console.log("Fila seleccionada:", row.html()); // Ver qué HTML tiene la fila seleccionada
  
    $("#idEditar").val(row.find("td:eq(0)").text().trim());  // ID
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
  
    let habilitado = row.find("td:eq(6) input[type='checkbox']").is(":checked") ? "1" : "0";
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
    if($("#imagenEditar")[0].files.length > 0) {
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
});
