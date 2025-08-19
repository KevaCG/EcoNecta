// Referencias a elementos del DOM
const overlay = document.getElementById('overlay');
const btnClose = document.getElementById('btnClose');
const btnBack = document.getElementById('btnBack');
const btnNext = document.getElementById('btnNext');
const registerForm = document.getElementById('registerForm');

// Configuración de los paneles del formulario
const tabs = [
    {tab: 'tab-personal', panel:'panel-personal', cta:'Continuar'},
    {tab: 'tab-direccion', panel:'panel-direccion', cta:'Continuar'},
    {tab: 'tab-residuos', panel:'panel-residuos', cta:'Suscribirse'}
];
let currentIndex = 0;

// Inicializar la interfaz al cargar
updateStepUI();

// ====== Lógica de validación por paso ======
function validateCurrentStep() {
    let isValid = true;
    const currentPanel = document.getElementById(tabs[currentIndex].panel);

    // Validar el paso 1 (Datos Personales)
    if (currentIndex === 0) {
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password_confirmation').value;

        // Validación de campos vacíos
        if (!name || !email || !password || !passwordConfirm) {
            alert('Por favor, completa todos los campos del primer paso.');
            isValid = false;
        }

        // Validación de contraseñas
        if (password !== passwordConfirm) {
            alert('Las contraseñas no coinciden.');
            isValid = false;
        }

        // Validación de complejidad de contraseña (opcional)
        // Por ejemplo: mínimo 8 caracteres, 1 mayúscula, 1 minúscula, 1 número
        // const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
        // if (!passwordRegex.test(password)) {
        //     alert('La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula y un número.');
        //     isValid = false;
        // }
    }

    // Validar el paso 2 (Dirección)
    if (currentIndex === 1) {
        const address = document.getElementById('address').value.trim();
        const locality = document.getElementById('locality').value.trim();
        const neighborhood = document.getElementById('neighborhood').value.trim();
        const postalCode = document.getElementById('postal_code').value.trim();

        if (!address || !locality || !neighborhood || !postalCode) {
            alert('Por favor, completa todos los campos de dirección.');
            isValid = false;
        }
    }

    // Validar el paso 3 (Residuos)
    if (currentIndex === 2) {
        const selectedResidues = registerForm.querySelectorAll('input[name="waste_types[]"]:checked');
        if (selectedResidues.length === 0) {
            alert('Por favor, selecciona al menos un tipo de residuo.');
            isValid = false;
        }
    }

    return isValid;
}


// ====== Funciones de navegación ======
function goTo(index) {
    if (index >= 0 && index < tabs.length) {
        currentIndex = index;
        updateStepUI();
    }
}

function updateStepUI() {
    tabs.forEach((t, i) => {
        const selected = i === currentIndex;
        document.getElementById(t.tab).setAttribute('aria-selected', selected);
        document.getElementById(t.panel).classList.toggle('is-active', selected);
    });
    btnBack.style.visibility = currentIndex === 0 ? 'hidden' : 'visible';
    btnNext.textContent = tabs[currentIndex].cta;
}

// ====== Eventos de navegación ======
tabs.forEach((t, i) => {
    document.getElementById(t.tab).addEventListener('click', () => {
        if (validateCurrentStep()) {
            goTo(i);
        }
    });
});

btnBack.addEventListener('click', () => {
    goTo(currentIndex - 1);
});

btnNext.addEventListener('click', () => {
    if (validateCurrentStep()) {
        if (currentIndex < tabs.length - 1) {
            goTo(currentIndex + 1);
        } else {
            // Lógica final de envío del formulario
            registerForm.submit();
        }
    }
});

btnClose.addEventListener('click', () => {
    overlay.hidden = true;
});

document.addEventListener('keydown', (e) => {
    if (!overlay.hidden && e.key === 'Escape') {
        overlay.hidden = true;
    }
});

// ====== Lógica para mostrar/ocultar contraseña ======
const showPasswordButtons = document.querySelectorAll('.show-password-btn');

showPasswordButtons.forEach(button => {
    button.addEventListener('click', () => {
        const targetId = button.dataset.target;
        const targetInput = document.getElementById(targetId);
        if (targetInput.type === 'password') {
            targetInput.type = 'text';
            button.textContent = '🙈'; // Cambia el icono
        } else {
            targetInput.type = 'password';
            button.textContent = '👁️'; // Cambia el icono
        }
    });
});

// ====== Lógica para la selección de residuos (multi) ======
const residuosContainer = document.getElementById('residuos');

if (residuosContainer) {
    residuosContainer.addEventListener('click', (e) => {
        const card = e.target.closest('.card');
        if (card) {
            toggleCard(card);
        }
    });

    residuosContainer.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
            const card = e.target.closest('.card');
            if (card) {
                e.preventDefault();
                toggleCard(card);
            }
        }
    });
}

function toggleCard(card) {
    const val = card.dataset.wasteId;
    const checkbox = card.querySelector('input[type="checkbox"]');

    if (checkbox.checked) {
        checkbox.checked = false;
        card.classList.remove('is-selected');
    } else {
        checkbox.checked = true;
        card.classList.add('is-selected');
    }
}
