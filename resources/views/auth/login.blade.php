<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>EcoNecta - Inicio de sesión</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    {{-- Enlazar el archivo CSS externo --}}
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

<div class="container">
    <div class="left-side">
        <header>
            <div class="logo">
                {{-- Usar la ruta de imagen con la función asset() de Laravel --}}
                <img src="{{ asset('img/Frame 1.png') }}" alt="EcoNecta">
                <span>EcoNecta</span>
            </div>
            <nav>
                <a href="#">Inicio</a>
                <a href="#">¿Cómo funciona?</a>
            </nav>
        </header>

        <main>
            <h1>Transforma tus<br>residuos en vida.</h1>
            <p>Únete a la red de hogares y negocios que reciclan desde sus baldes y GRATIS</p>
            <div class="buttons">
                <button class="btn-green">¡Conoce más!</button>
                <button class="btn-green">¡Suscríbete!</button>
            </div>
        </main>

        {{-- Usar la ruta de imagen con la función asset() de Laravel --}}
        <img src="{{ asset('img/ChatGPT Image Jul 31, 2025, 03_39_44 PM 1 (9).png') }}" alt="Ilustración" class="illustration">
    </div>

    <div class="right-side">
        <button class="close-btn" id="closeSide">X</button>

        {{-- ===== Panel LOGIN ===== --}}
        <section class="panel" id="panelLogin">
            <h2>Inicio de sesión</h2>
            {{-- Formulario ajustado para Laravel --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror

                <label for="email">Correo</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="econecta@gmail.com" required />

                <label for="password">Contraseña</label>
                <input id="password" type="password" name="password" placeholder="************" required />

                <a href="#" id="linkRecover">¿Olvidó su contraseña?</a>

                <button type="submit" class="btn-green">Ingresar</button>
            </form>
        </section>

        {{-- ===== Panel RECUPERACIÓN ===== --}}
        <section class="panel hidden" id="panelRecover" aria-hidden="true">
            <div class="recovery-title">
                <div class="big">Recuperacion</div>
                <div class="small">de contraseña</div>
            </div>
            <form id="recoverForm">
                <label for="recoverEmail">Correo</label>
                <input id="recoverEmail" type="email" placeholder="econecta@gmail.com" />
                <div class="hint">
                    Se le enviará un enlace al correo con el cual puede restablecer la contraseña
                </div>
                <button type="submit" class="btn-send">Enviar</button>
            </form>
        </section>
    </div>
</div>

{{-- Enlazar el archivo JavaScript externo --}}
<script src="{{ asset('js/login.js') }}" defer></script>
</body>
</html>
