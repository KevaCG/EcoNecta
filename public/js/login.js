// Referencias
const panelLogin = document.getElementById("panelLogin");
const panelRecover = document.getElementById("panelRecover");
const linkRecover = document.getElementById("linkRecover");
const closeSide = document.getElementById("closeSide");
const recoverForm = document.getElementById("recoverForm");

// Abrir recuperación
linkRecover.addEventListener("click", (e) => {
    e.preventDefault();
    panelLogin.classList.add("hidden");
    panelRecover.classList.remove("hidden");
    panelRecover.setAttribute("aria-hidden", "false");
    document.getElementById("recoverEmail").focus();
});

// Cerrar / volver a login (botón X)
closeSide.addEventListener("click", () => {
    // Si estamos en recuperación, regresar al login
    if (!panelRecover.classList.contains("hidden")) {
        panelRecover.classList.add("hidden");
        panelLogin.classList.remove("hidden");
        panelRecover.setAttribute("aria-hidden", "true");
    } else {
        // Si ya estamos en login, puedes ocultar la columna o hacer otra acción;
        // por ahora hacemos un blur visual (opcional) o no hacemos nada:
        // alert('Cerrar panel');
    }
});

// Enviar recuperación (demo)
recoverForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const email = document.getElementById("recoverEmail").value.trim();
    if (!email) {
        alert("Ingresa tu correo");
        return;
    }
    alert("Hemos enviado un enlace a " + email);
    // Vuelve al login
    panelRecover.classList.add("hidden");
    panelLogin.classList.remove("hidden");
    panelRecover.setAttribute("aria-hidden", "true");
});
