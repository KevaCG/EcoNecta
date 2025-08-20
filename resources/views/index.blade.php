<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoNecta - Transforma tus residuos en vida</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f7;
            margin: 0;
            padding: 0;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar .logo {
            display: flex;
            align-items: center;
        }

        .navbar .logo img {
            height: 40px;
            margin-right: 10px;
        }

        .navbar .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2b7a2b;
        }

        .navbar .nav-links a {
            margin-left: 30px;
            text-decoration: none;
            color: #555;
            font-weight: 600;
        }

        .navbar .nav-links a.btn {
            padding: 10px 20px;
            border-radius: 5px;
            color: #fff;
            background-color: #4caf50;
        }

        .hero-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 60px 80px;
        }

        .hero-content {
            max-width: 50%;
        }

        .hero-content h1 {
            font-size: 3rem;
            font-weight: 800;
            color: #333;
            margin-bottom: 20px;
        }

        .hero-content p {
            font-size: 1.2rem;
            line-height: 1.6;
            color: #666;
            margin-bottom: 30px;
        }

        .hero-buttons .btn {
            padding: 15px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 700;
            transition: background-color 0.3s;
        }

        .hero-buttons .btn--green {
            background-color: #4caf50;
            color: #fff;
            margin-right: 20px;
        }

        .hero-buttons .btn--green:hover {
            background-color: #43a047;
        }

        .hero-buttons .btn--outline {
            border: 2px solid #4caf50;
            color: #4caf50;
            background: none;
        }

        .hero-buttons .btn--outline:hover {
            background-color: #e8f5e9;
        }

        .hero-image img {
            width: 600px;
            height: 600px;
        }

        /* Estilos para el panel lateral de login */
        .login-sidebar {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 100;
            top: 0;
            right: 0;
            background-color: #f0f4f7;
            overflow-x: hidden;
            transition: 0.5s;
            box-shadow: -4px 0 10px rgba(0, 0, 0, 0.1);
        }

        .login-sidebar.open {
            width: 350px; /* Ancho del panel cuando está abierto */
        }

        .login-sidebar .sidebar-content {
            padding: 20px;
            padding-top: 80px;
        }

        .login-sidebar .close-btn {
            position: absolute;
            top: 20px;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
            border: none;
            background: none;
            cursor: pointer;
        }

        /* Estilos del formulario dentro del panel */
        .form-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-header__title {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .form-field {
            margin-bottom: 20px;
        }

        .form-field label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .form-field input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box; /* Asegura que el padding no afecte el ancho */
        }

        .form-submit {
            text-align: center;
        }

        .btn--primary {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <img src="{{ asset('assets/img/econeecta-logo.png') }}" alt="EcoNecta Logo">
        </div>
        <div class="nav-links">
            <a href="#">Inicio</a>
            <a href="#">¿Cómo funciona?</a>
            <a href="#">Empresas</a>
            <a href="#" class="btn" onclick="toggleLoginSidebar()">Ingresa</a>
        </div>
    </nav>

    <section class="hero-section">
        <div class="hero-content">
            <h1>Transforma tus<br>residuos en vida.</h1>
            <p>Únete a la red de hogares y negocios que reciclan desde sus baldes y GRATIS</p>
            <div class="hero-buttons">
                <a href="#" class="btn btn--green">Conoce más!</a>
                <a href="{{ route('register') }}" class="btn btn--outline">¡Suscríbete!</a>
            </div>
        </div>
        <div class="hero-image">
            <img src="{{ asset('assets/img/ilustracion-index.png') }}" alt="Ilustración de reciclaje">
        </div>
    </section>

    <div id="login-sidebar" class="login-sidebar">
        <div class="sidebar-content">
            <button class="close-btn" onclick="toggleLoginSidebar()">&times;</button>
            <div class="form-container">
                <header class="form-header">
                    <h2 class="form-header__title">INICIAR SESIÓN</h2>
                </header>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-field">
                        <label for="email">Correo electrónico</label>
                        <input id="email" type="email" name="email" required autocomplete="email">
                    </div>
                    <div class="form-field">
                        <label for="password">Contraseña</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password">
                    </div>
                    <div class="form-submit">
                        <button type="submit" class="btn btn--primary">Ingresar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleLoginSidebar() {
            const sidebar = document.getElementById("login-sidebar");
            sidebar.classList.toggle('open');
        }
    </script>
</body>
</html>
