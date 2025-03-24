$(document).ready(function () {
    console.log("JavaScript cargado");

    // Mostrar el modal al hacer clic en "Agregar Producto"
    $("#add-product-btn").click(function () {
        abrirModal('modalAgregar');
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
    $(window).click(function(event) {
        $(".modal").each(function() {
            if (event.target == this) {
                $(this).css("display", "none");
            }
        });
    });

    // Agregar Producto
    $("#formAgregar").submit(function (e) {
        e.preventDefault();
        $.post("src/php/agregar_producto.php", {
            nombre: $("#nombreAgregar").val(),
            categoria: $("#categoriaAgregar").val(),
            marca: $("#marcaAgregar").val(),
            precio: $("#precioAgregar").val(),
            habilitado: $("#habilitadoAgregar").val()
        }, function (data) {
            location.reload();
        });
    });

    // Abrir modal de edición con datos del producto
    $(document).on("click", ".edit-btn", function () {
        let row = $(this).closest("tr");
        $("#idEditar").val(row.find("td:eq(0)").text());
        $("#nombreEditar").val(row.find("td:eq(1)").text());
        $("#categoriaEditar").val(row.find("td:eq(2)").text());
        $("#marcaEditar").val(row.find("td:eq(3)").text());
        $("#precioEditar").val(row.find("td:eq(4)").text().replace("$", ""));
        $("#habilitadoEditar").val(row.find("td:eq(5)").text() === "Sí" ? "1" : "0");
        abrirModal('modalEditar');
    });

    // Editar producto
    $("#formEditar").submit(function (e) {
        e.preventDefault();
        $.post("src/php/editar_producto.php", {
            id: $("#idEditar").val(),
            nombre: $("#nombreEditar").val(),
            categoria: $("#categoriaEditar").val(),
            marca: $("#marcaEditar").val(),
            precio: $("#precioEditar").val(),
            habilitado: $("#habilitadoEditar").val()
        }, function (data) {
            location.reload();
        });
    });

    // Abrir modal de confirmación de eliminación
    $(document).on("click", ".delete-btn", function () {
        let id = $(this).data("id");
        $("#confirmarEliminar").data("id", id);
        abrirModal('modalEliminar');
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
