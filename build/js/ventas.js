document.addEventListener("DOMContentLoaded", () => {
  fetch("src/php/get_ventas.php")
    .then(res => res.json())
    .then(data => {
      const tbody = document.querySelector("#tabla-ventas tbody");
      tbody.innerHTML = "";

      const contadorProductos = {};
      const ventasPorFecha = {};
      let totalVendido = 0;
      let totalProductosVendidos = 0;

      data.forEach(venta => {
        const fila = document.createElement("tr");

        const productos = JSON.parse(venta.productos).map(p => {
          const key = `${p.nombre}`;
          contadorProductos[key] = (contadorProductos[key] || 0) + p.cantidad;
          totalProductosVendidos += p.cantidad;
          return `ID ${p.id} - ${p.nombre} x${p.cantidad} - $${(p.precio * p.cantidad).toFixed(2)}`;
        }).join("<br>");

        const fecha = venta.fecha.split(" ")[0];
        ventasPorFecha[fecha] = (ventasPorFecha[fecha] || 0) + parseFloat(venta.total);

        totalVendido += parseFloat(venta.total);

        fila.innerHTML = `
          <td>${venta.fecha}</td>
          <td>${productos}</td>
          <td>$${venta.total}</td>
          <td>$${venta.total_mayorista}</td>
          <td style="text-align:center;">
            <input type="checkbox" class="checkbox-entregado" data-id="${venta.id}" ${venta.entregado == 1 ? "checked" : ""}>
          </td>
          <td style="text-align:center;">
            <button class="btn-eliminar" data-id="${venta.id}" style="background-color: #e74c3c; color: white; border: none; padding: 6px 12px; cursor: pointer; border-radius: 5px;">Eliminar</button>
          </td>
        `;

        tbody.appendChild(fila);
      });

      // Mostrar KPIs
      actualizarKPIs(totalVendido, totalProductosVendidos, contadorProductos);

      // Crear gráficos
      generarGraficoProductos(contadorProductos);
      generarGraficoEvolucion(ventasPorFecha);

      // Agregar eventos a los botones eliminar
      agregarEventosEliminar();
    });
});

function agregarEventosEliminar() {
  const botonesEliminar = document.querySelectorAll(".btn-eliminar");

  botonesEliminar.forEach(boton => {
    boton.addEventListener("click", () => {
      const id = boton.getAttribute("data-id");

      if (confirm("¿Seguro que quieres eliminar esta venta? Esta acción no se puede deshacer.")) {
        fetch("src/php/eliminar_ventas.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body: `id=${id}`
        })
        .then(res => res.json())
        .then(response => {
          if (response.success) {
            alert("Venta eliminada correctamente.");
            location.reload();
          } else {
            alert("Error al eliminar la venta.");
            console.error(response.error);
          }
        });
      }
    });
  });
}

// (las funciones de KPIs y Gráficos ya las tienes cargadas aquí también)


// Función para actualizar tarjetas KPI
function actualizarKPIs(totalVendido, totalProductosVendidos, contadorProductos) {
  document.querySelector("#kpi-total-vendido p").textContent = `$${totalVendido.toFixed(2)}`;
  document.querySelector("#kpi-total-productos p").textContent = totalProductosVendidos;

  let productoTop = "-";
  let maxCantidad = 0;
  for (const [producto, cantidad] of Object.entries(contadorProductos)) {
    if (cantidad > maxCantidad) {
      productoTop = producto;
      maxCantidad = cantidad;
    }
  }
  document.querySelector("#kpi-producto-top p").textContent = productoTop;
}

// Función para generar gráfico de productos vendidos
function generarGraficoProductos(contadorProductos) {
  const ctx = document.getElementById('grafico-productos').getContext('2d');

  const labels = Object.keys(contadorProductos);
  const data = Object.values(contadorProductos);

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Cantidad vendida',
        data: data,
        backgroundColor: '#ff6384',
        borderColor: '#e60039',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
}

// Función para generar gráfico de evolución de ventas
function generarGraficoEvolucion(ventasPorFecha) {
  const ctx = document.getElementById('grafico-evolucion').getContext('2d');

  const labels = Object.keys(ventasPorFecha).sort();
  const data = labels.map(fecha => ventasPorFecha[fecha]);

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
        label: 'Total Vendido',
        data: data,
        borderColor: '#36a2eb',
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        fill: true,
        tension: 0.3
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: 'top' }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
}
