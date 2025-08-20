<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paso 2: Dirección</title>
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
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <aside class="form-sidebar">
                <nav>
                    <a href="#" class="form-sidebar__nav-item">Datos Personales</a>
                    <a href="#" class="form-sidebar__nav-item active">Dirección</a>
                    <a href="#" class="form-sidebar__nav-item">Tipos de Residuos</a>
                </nav>
            </aside>
            <div class="form-content">
                <header class="form-header">
                    <h2 class="form-header__title">FORMULARIO DE SUSCRIPCIÓN</h2>
                    <button class="form-header__close" aria-label="Cerrar">×</button>
                </header>
                <form method="POST" action="{{ route('register.step3') }}">
                    @csrf
                    <div class="form-section">
                        <h3>Dirección</h3>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="address">Dirección</label>
                                <input id="address" type="text" name="address" value="{{ old('address') }}" required placeholder="Ingrese su dirección">
                            </div>
                            <div class="form-field">
                                <label for="locality">Localidad</label>
                                <input id="locality" type="text" name="locality" value="{{ old('locality') }}" required placeholder="Ingrese su localidad">
                            </div>
                            <div class="form-field">
                                <label for="neighborhood">Barrio</label>
                                <input id="neighborhood" type="text" name="neighborhood" value="{{ old('neighborhood') }}" required placeholder="Ingrese su barrio">
                            </div>
                            <div class="form-field">
                                <label for="postal_code">Código postal</label>
                                <input id="postal_code" type="text" name="postal_code" value="{{ old('postal_code') }}" placeholder="Ingrese su código postal" inputmode="numeric">
                            </div>
                            <div class="form-field full-width">
                                <label for="especificaciones">Especificaciones</label>
                                <input id="especificaciones" type="text" name="especificaciones" placeholder="casa, apto, torre, etc">
                            </div>
                        </div>
                    </div>
                    <div class="form-submit">
                        <button type="submit" class="btn btn--primary">Continuar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
