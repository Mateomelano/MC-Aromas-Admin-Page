$(document).ready(function () {
    // Agregar producto
    $("#add-product-btn").click(function () {
        let nombre = prompt("Ingrese el nombre del producto:");
        let categoria = prompt("Ingrese la categoría:");
        let marca = prompt("Ingrese la marca:");
        let precio = prompt("Ingrese el precio:");
        let habilitado = confirm("¿Está habilitado?") ? 1 : 0;

        $.post("src/php/agregar_producto.php", {
            nombre: nombre,
            categoria: categoria,
            marca: marca,
            precio: precio,
            habilitado: habilitado
        }, function (data) {
            location.reload();
        });
    });

    // Eliminar producto
    $(".delete-btn").click(function () {
        let id = $(this).data("id");
        if (confirm("¿Seguro que deseas eliminar este producto?")) {
            $.post("src/php/eliminar_producto.php", { id: id }, function (data) {
                location.reload();
            });
        }
    });

    // Editar producto
    $(".edit-btn").click(function () {
        let id = $(this).data("id");
        let nombre = prompt("Nuevo nombre:");
        let categoria = prompt("Nueva categoría:");
        let marca = prompt("Nueva marca:");
        let precio = prompt("Nuevo precio:");
        let habilitado = confirm("¿Está habilitado?") ? 1 : 0;

        $.post("src/php/editar_producto.php", {
            id: id,
            nombre: nombre,
            categoria: categoria,
            marca: marca,
            precio: precio,
            habilitado: habilitado
        }, function (data) {
            location.reload();
        });
    });
});
