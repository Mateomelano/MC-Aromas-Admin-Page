function login() {
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    
    if (username === "merceriachela" && password === "pabloagos") {
        sessionStorage.setItem("loggedIn", "true");
        window.location.href = "index.php"; // Redirige al panel de administración
    } else {
        document.getElementById("error-message").style.display = "block";
    }
}

// Si ya está logueado, redirigir a index.php
if (sessionStorage.getItem("loggedIn") === "true") {
    window.location.href = "index.php";
}