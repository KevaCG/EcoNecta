<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paso 1: Datos Personales</title>
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
                    <a href="#" class="form-sidebar__nav-item active">Datos Personales</a>
                    <a href="#" class="form-sidebar__nav-item">Dirección</a>
                    <a href="#" class="form-sidebar__nav-item">Tipos de Residuos</a>
                </nav>
            </aside>
            <div class="form-content">
                <header class="form-header">
                    <h2 class="form-header__title">FORMULARIO DE SUSCRIPCIÓN</h2>
                    <button class="form-header__close" aria-label="Cerrar">×</button>
                </header>
                <form method="POST" action="{{ route('register.step2') }}">
                    @csrf
                    <div class="form-section">
                        <h3>Datos Personales</h3>
                        <div class="form-grid">
                            <div class="form-field">
                                <label for="name">Nombre completo</label>
                                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus>
                            </div>
                            <div class="form-field">
                                <label for="document_id">Cédula</label>
                                <input id="document_id" name="document_id" type="text" value="{{ old('document_id') }}" required>
                            </div>
                            <div class="form-field">
                                <label for="phone_whatsapp">Número de contacto</label>
                                <input id="phone_whatsapp" name="phone_whatsapp" type="text" value="{{ old('phone_whatsapp') }}">
                            </div>
                            <div class="form-field">
                                <label for="email">Correo electrónico</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required>
                            </div>
                            <div class="form-field">
                                <label for="password">Contraseña</label>
                                <input id="password" name="password" type="password" required>
                            </div>
                            <div class="form-field">
                                <label for="password_confirmation">Confirma tu contraseña</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" required>
                            </div>
                        </div>
                        <div class="form-checkbox">
                            <input type="checkbox" id="receive_whatsapp" name="receive_whatsapp" value="1">
                            <label for="receive_whatsapp">Acepta recibir información por WhatsApp</label>
                        </div>
                    </div>
                    <div class="form-submit">
                        <button type="submit" class="btn btn--primary">Siguiente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
