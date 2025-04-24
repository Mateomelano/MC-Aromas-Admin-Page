document.addEventListener("DOMContentLoaded", () => {
    fetch("src/php/get_ventas.php")
      .then(res => res.json())
      .then(data => {
        const tbody = document.querySelector("#tabla-ventas tbody");
        tbody.innerHTML = "";
  
        data.forEach(venta => {
          debugger
          const fila = document.createElement("tr");
  
          const productos = JSON.parse(venta.productos).map(p =>
            `ID ${p.id} - ${p.nombre} x${p.cantidad} - $${(p.precio * p.cantidad).toFixed(2)}`
          ).join("<br>");
          
  
          fila.innerHTML = `
          <td>${venta.fecha}</td>
          <td>${productos}</td>
          <td>$${venta.total}</td>
          <td>$${venta.total_mayorista}</td>
          <td style="text-align:center;">
            <input type="checkbox" class="checkbox-entregado" data-id="${venta.id}" ${venta.entregado == 1 ? "checked" : ""}>
          </td>
        `;
        
  
          tbody.appendChild(fila);
        });
      });
  });
  