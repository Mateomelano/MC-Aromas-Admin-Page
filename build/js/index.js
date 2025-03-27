function actualizarInformacion() {
    fetch(("src/php/get_info.php")) 
      .then((response) => response.json())
      .then((data) => {
        document.querySelector(".info-card:nth-child(1) p").textContent =
          data.totalProductos;
        document.querySelector(".info-card:nth-child(2) p").textContent =
          data.totalHabilitados;
        document.querySelector(".info-card:nth-child(3) p").textContent =
          data.totalDeshabilitados;
        document.querySelector(
          ".info-card:nth-child(4) p"
        ).textContent = `${data.productoMasCaro.nombre} ($${data.productoMasCaro.precio})`;
        document.querySelector(
          ".info-card:nth-child(5) p"
        ).textContent = `${data.productoMasBarato.nombre} ($${data.productoMasBarato.precio})`;
      })
      .catch((error) => console.error("Error al obtener la información:", error));
  }
  
  setInterval(actualizarInformacion, 5000);