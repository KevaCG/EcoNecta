document.addEventListener('DOMContentLoaded', function() {
    // Lógica para el panel de inicio de sesión
    const loginButton = document.getElementById('btn-login');
    const loginPanel = document.getElementById('login-panel');
    const closeLoginButton = document.getElementById('close-login');

    if (loginButton && loginPanel && closeLoginButton) {
        loginButton.addEventListener('click', function(e) {
            e.preventDefault();
            loginPanel.classList.add('open');
        });

        closeLoginButton.addEventListener('click', function() {
            loginPanel.classList.remove('open');
        });
    }

    // Lógica para el formulario de suscripción
    const sidebarButtons = document.querySelectorAll('.sidebar a');
    const formSections = document.querySelectorAll('.form-section');
    const continueButtons = document.querySelectorAll('.continue-btn');
    const modalOverlay = document.getElementById('modal-overlay');
    const closeModalButton = document.getElementById('close-modal');

    // Puedes agregar un botón para abrir el modal si lo necesitas, por ejemplo
    // const openModalButton = document.getElementById('btn-empresas');
    // openModalButton.addEventListener('click', function() {
    //     modalOverlay.classList.add('open');
    // });

    if (closeModalButton) {
        closeModalButton.addEventListener('click', function() {
            modalOverlay.classList.remove('open');
        });
    }

    function showSection(sectionId) {
        formSections.forEach(section => {
            section.classList.remove('active-section');
        });
        document.getElementById(sectionId).classList.add('active-section');
    }

    function setActiveSidebarButton(buttonId) {
        sidebarButtons.forEach(btn => {
            btn.classList.remove('active');
        });
        document.getElementById(buttonId).classList.add('active');
    }

    sidebarButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const targetId = this.id.replace('btn-', 'section-');
            showSection(targetId);
            setActiveSidebarButton(this.id);
        });
    });

    continueButtons.forEach(button => {
        button.addEventListener('click', function() {
            const nextSectionId = this.getAttribute('data-target');
            if (nextSectionId) {
                showSection(nextSectionId);
                const nextButtonId = nextSectionId.replace('section-', 'btn-');
                setActiveSidebarButton(nextButtonId);
            } else {
                alert('¡Formulario finalizado! Los datos han sido enviados.');
                // Aquí podrías cerrar el modal después de finalizar
                // modalOverlay.classList.remove('open');
            }
        });
    });

    // Activa la primera sección del formulario al cargar la página por defecto
    showSection('section-personales');
    setActiveSidebarButton('btn-personales');
});
