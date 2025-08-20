<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paso 3: Tipos de Residuos</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f0f4f7; }
        .container { display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .form-container { background-color: #fff; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); width: 100%; max-width: 800px; display: flex; overflow: hidden; }
        .form-sidebar { width: 200px; background-color: #e5f0e5; padding: 20px; }
        .form-sidebar__nav-item { display: block; padding: 10px; color: #555; text-decoration: none; margin-bottom: 10px; }
        .form-sidebar__nav-item.active { font-weight: 600; color: #2b7a2b; border-left: 3px solid #4caf50; }
        .form-content { flex-grow: 1; padding: 40px; }
        .form-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #ccc; padding-bottom: 20px; margin-bottom: 20px; }
        .form-header__title { font-size: 1.5rem; font-weight: 700; }
        .form-header__close { background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #aaa; }
        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        .form-field { display: flex; flex-direction: column; }
        .form-field label { font-size: 0.9rem; color: #555; margin-bottom: 5px; }
        .form-field input, .form-field select { padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .form-checkbox { display: flex; align-items: center; gap: 10px; margin-top: 20px; }
        .form-submit { text-align: right; margin-top: 40px; }
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: 600; }
        .btn--primary { background-color: #4caf50; color: #fff; }
        .form-section { margin-bottom: 40px; }
        .form-section h3 { margin-bottom: 15px; border-bottom: 1px solid #ccc; padding-bottom: 5px; }
        .residuos { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; }
        .card { border: 2px solid transparent; border-radius: 10px; padding: 15px; text-align: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .card:hover { transform: translateY(-3px); box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
        .card.is-selected { border-color: #4caf50; background-color: #e8f5e9; box-shadow: 0 0 10px #4caf50; }
        .card img { max-width: 80px; height: auto; margin-bottom: 10px; }
        .card h4 { font-size: 1.1rem; margin: 0 0 5px; }
        .card p { font-size: 0.8rem; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <aside class="form-sidebar">
                <nav>
                    <a href="#" class="form-sidebar__nav-item">Datos Personales</a>
                    <a href="#" class="form-sidebar__nav-item">Dirección</a>
                    <a href="#" class="form-sidebar__nav-item active">Tipos de Residuos</a>
                </nav>
            </aside>
            <div class="form-content">
                <header class="form-header">
                    <h2 class="form-header__title">FORMULARIO DE SUSCRIPCIÓN</h2>
                    <button class="form-header__close" aria-label="Cerrar">×</button>
                </header>
                <form method="POST" action="{{ route('register.complete') }}">
                    @csrf
                    <div class="form-section">
                        <h3>Tipos de Residuos</h3>
                        <div class="residuos">
                            <article class="card" data-waste-id="organicos" tabindex="0">
                                <img src="{{ asset('assets/img/image-5.png') }}" alt="Orgánicos">
                                <h4>ORGÁNICOS</h4>
                                <p>Material biodegradable de origen vegetal: Restos de comida, cáscaras, hojas, residuos de jardín.</p>
                                <input type="checkbox" name="waste_types[]" value="organicos" hidden>
                            </article>
                            <article class="card" data-waste-id="inorganicos" tabindex="0">
                                <img src="{{ asset('assets/img/image-8.png') }}" alt="Inorgánicos">
                                <h4>INORGÁNICOS</h4>
                                <p>Desechos no biodegradables que pueden ser reciclados o reutilizados: Plásticos, cartón, vidrio, metales, telas.</p>
                                <input type="checkbox" name="waste_types[]" value="inorganicos" hidden>
                            </article>
                            <article class="card" data-waste-id="peligrosos" tabindex="0">
                                <img src="{{ asset('assets/img/image-7.png') }}" alt="Peligrosos">
                                <h4>PELIGROSOS</h4>
                                <p>Desechos que representan un riesgo para la salud o el medio ambiente: Pilas, medicamentos vencidos, aceites.</p>
                                <input type="checkbox" name="waste_types[]" value="peligrosos" hidden>
                            </article>
                        </div>
                    </div>
                    <div class="form-submit">
                        <button type="submit" class="btn btn--primary">Suscribirse</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const residuosContainer = document.querySelector('.residuos');
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
        function toggleCard(card) {
            const checkbox = card.querySelector('input[type="checkbox"]');
            if (checkbox) {
                checkbox.checked = !checkbox.checked;
                card.classList.toggle('is-selected', checkbox.checked);
            }
        }
    </script>
</body>
</html>
