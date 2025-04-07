document.addEventListener("DOMContentLoaded", function () {
    cargarBanners();
    
    document.getElementById("uploadBanner").addEventListener("change", function (event) {
        debugger
      const file = event.target.files[0];
      const formData = new FormData();
      formData.append("imagen", file);
  
      fetch("src/php/subir_banner.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            cargarBanners();
          } else {
            alert(data.message);
          }
        });
    });
  });
  
  function cargarBanners() {
    debugger
    fetch("src/php/get_banners.php")
      .then((response) => response.json())

      .then((data) => {
        debugger
        console.log(data);
        const bannerContainer = document.getElementById("bannerContainer");
        bannerContainer.innerHTML = "";
  
        data.forEach((banner) => {
          const bannerDiv = document.createElement("div");
          bannerDiv.className = "banner-item";
          bannerDiv.innerHTML = `
            <img src="${banner.url}" alt="Banner" width="300">
            <button onclick="eliminarBanner(${banner.id}, '${banner.url}')">Eliminar</button>
          `;
          bannerContainer.appendChild(bannerDiv);
        });
      });
  }
  
  function eliminarBanner(id, url) {
    debugger
    if (!confirm("¿Estás seguro de que deseas eliminar este banner?")) return;
  
    fetch("src/php/eliminar_banner.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `id=${id}&url=${encodeURIComponent(url)}`
    })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        cargarBanners();
      } else {
        alert("Error al eliminar el banner.");
      }
    });
  }
