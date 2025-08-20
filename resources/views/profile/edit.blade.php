<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualización de Datos</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f0f4f7; }
        .container { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background-color: #e5f0e5; padding: 20px; box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); }
        .sidebar__profile { text-align: center; padding-bottom: 20px; border-bottom: 1px solid #c7d1c7; }
        .sidebar__profile-img { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; }
        .sidebar__profile-name { margin-top: 10px; font-size: 1.2rem; font-weight: 600; }
        .sidebar__nav { margin-top: 20px; }
        .sidebar__nav-item { display: block; padding: 10px 15px; color: #555; text-decoration: none; border-radius: 8px; margin-bottom: 5px; }
        .sidebar__nav-item.active { background-color: #d1e2d1; font-weight: 700; }
        .content { flex-grow: 1; padding: 40px; display: flex; justify-content: center; align-items: flex-start; }
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
        <aside class="sidebar">
            <div class="sidebar__profile">
                <h4>¡Bienvenida {{ Auth::user()->name }}!</h4>
            </div>
            <nav class="sidebar__nav">
                <a href="{{ route('profile.edit') }}" class="sidebar__nav-item active">Actualizar datos</a>
                <a href="#" class="sidebar__nav-item">Programar</a>
                <a href="#" class="sidebar__nav-item">Puntos</a>
            </nav>
        </aside>

        <main class="content">
            <div class="form-container">
                <aside class="form-sidebar">
                    <nav>
                        <a href="#personal-data" class="form-sidebar__nav-item active">Datos Personales</a>
                    </nav>
                </aside>

                <div class="form-content">
                    <header class="form-header">
                        <h2 class="form-header__title">ACTUALIZACIÓN DE DATOS</h2>
                        <button class="form-header__close" aria-label="Cerrar">×</button>
                    </header>
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        {{-- Sección de Datos Personales --}}
                        <div class="form-section" id="personal-data">
                            <h3>Datos Personales</h3>
                            <div class="form-grid">
                                <div class="form-field">
                                    <label for="name">Nombre completo</label>
                                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required>
                                </div>
                                <div class="form-field">
                                    <label for="cedula">Cédula</label>
                                    <input id="cedula" name="cedula" type="text" value="{{ $user->document_id }}" disabled>
                                </div>
                                <div class="form-field">
                                    <label for="phone_whatsapp">Número de contacto</label>
                                    <input id="phone_whatsapp" name="phone_whatsapp" type="text" value="{{ old('phone_whatsapp', $user->phone_whatsapp) }}">
                                </div>
                                <div class="form-field">
                                    <label for="email">Correo electrónico</label>
                                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
                                </div>
                                <div class="form-field">
                                    <label for="password">Contraseña</label>
                                    <input id="password" name="password" type="password">
                                </div>
                                <div class="form-field">
                                    <label for="password_confirmation">Confirma tu contraseña</label>
                                    <input id="password_confirmation" name="password_confirmation" type="password">
                                </div>
                            </div>
                            <div class="form-checkbox">
                                <input type="checkbox" id="receive_whatsapp" name="receive_whatsapp" value="1" {{ old('receive_whatsapp', $user->receive_whatsapp) ? 'checked' : '' }}>
                                <label for="receive_whatsapp">Acepta recibir información por WhatsApp</label>
                            </div>
                        </div>

                        {{-- Sección de Dirección --}}
                        <div class="form-section" id="address-data">
                            <h3>Dirección</h3>
                            <div class="form-grid">
                                <div class="form-field">
                                    <label for="address">Dirección</label>
                                    <input id="address" type="text" name="address" value="{{ old('address', $user->address) }}" placeholder="Ingrese su dirección" autocomplete="address-line1">
                                </div>
                                <div class="form-field">
                                    <label for="locality">Localidad</label>
                                    <input id="locality" type="text" name="locality" value="{{ old('locality', $user->locality) }}" placeholder="Ingrese su localidad">
                                </div>
                                <div class="form-field">
                                    <label for="neighborhood">Barrio</label>
                                    <input id="neighborhood" type="text" name="neighborhood" value="{{ old('neighborhood', $user->neighborhood) }}" placeholder="Ingrese su barrio">
                                </div>
                                <div class="form-field">
                                    <label for="postal_code">Código postal</label>
                                    <input id="postal_code" type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" placeholder="Ingrese su código postal" inputmode="numeric">
                                </div>
                            </div>
                        </div>

                        {{-- Sección de Tipos de Residuos --}}
                        <div class="form-section" id="waste-types">
                            <h3>Tipos de Residuos</h3>
                            <div class="residuos">
                                @foreach ($allWasteTypes as $wasteType)
                                    @php
                                        $isSelected = $user->wasteTypes->contains('id', $wasteType->id);
                                    @endphp
                                    <article class="card {{ $isSelected ? 'is-selected' : '' }}" data-waste-id="{{ $wasteType->name }}" tabindex="0">
                                        <img src="{{ asset('img/residuos/' . $wasteType->name . '.png') }}" alt="{{ $wasteType->name }}">
                                        <h4>{{ strtoupper($wasteType->name) }}</h4>
                                        <p>{{ $wasteType->description }}</p>
                                        <input type="checkbox" name="waste_types[]" value="{{ $wasteType->name }}" {{ $isSelected ? 'checked' : '' }} hidden>
                                    </article>
                                @endforeach
                            </div>
                        </div>

                        <div class="form-submit">
                            <button type="submit" class="btn btn--primary">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    {{-- Lógica para la selección de cards --}}
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
