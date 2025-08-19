<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>EcoNecta - Registro</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    {{-- Enlazar el archivo CSS externo --}}
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">

    <style>
    /* Estilos del botón de mostrar/ocultar contraseña */
    .field--password {
        position: relative;
    }
    .show-password-btn {
        position: absolute;
        right: 14px;
        top: 38px;
        background: transparent;
        border: 0;
        cursor: pointer;
        font-size: 16px;
        color: var(--muted);
    }
    .show-password-btn:focus-visible {
        outline: 2px solid var(--green-dark);
        outline-offset: 2px;
    }
</style>
</head>
<body>

{{-- ========= MODAL ========= --}}
<div class="overlay" id="overlay">
    <section class="dialog" role="dialog" aria-modal="true" aria-labelledby="dialogTitle">
        <header class="dialog__header">
            <h2 id="dialogTitle" class="dialog__title">FORMULARIO DE SUSCRIPCIÓN</h2>
            <button class="dialog__close" id="btnClose" aria-label="Cerrar">×</button>
        </header>

        <div class="dialog__body">
            {{-- Menú --}}
            <nav class="sidemenu" aria-label="Secciones del formulario" id="tablist" role="tablist">
                <button class="sidemenu__btn" role="tab" aria-selected="true" aria-controls="panel-personal" id="tab-personal">Datos<br/>Personales</button>
                <button class="sidemenu__btn" role="tab" aria-selected="false" aria-controls="panel-direccion" id="tab-direccion">Dirección</button>
                <button class="sidemenu__btn" role="tab" aria-selected="false" aria-controls="panel-residuos" id="tab-residuos">Tipos de<br/>Residuos</button>
            </nav>

            {{-- Contenido y formulario principal --}}
            <div>
                <form id="registerForm" method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Panel 1 --}}
                    <section class="panel is-active" id="panel-personal" role="tabpanel" aria-labelledby="tab-personal">
                        <div class="form-grid">
                            <div class="field">
                                <label for="name">Nombre completo</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Ingrese su nombre" autocomplete="name" required>
                                @error('name') <span class="error-message">{{ $message }}</span> @enderror
                            </div>
                            <div class="field">
                                <label for="email">Correo electrónico</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Ingrese su correo" autocomplete="email" required>
                                @error('email') <span class="error-message">{{ $message }}</span> @enderror
                            </div>
                            <div class="field">
                                <label for="phone_whatsapp">Número de contacto</label>
                                <input id="phone_whatsapp" type="tel" name="phone_whatsapp" value="{{ old('phone_whatsapp') }}" placeholder="Ingrese su celular" autocomplete="tel">
                            </div>
                            <div class="field field--password">
    <label for="password">Contraseña</label>
    <input id="password" type="password" name="password" placeholder="Ingrese su contraseña" autocomplete="new-password" required>
    <button type="button" class="show-password-btn" aria-label="Mostrar/ocultar contraseña" data-target="password">👁️</button>
    @error('password') <span class="error-message">{{ $message }}</span> @enderror
</div>
<div class="field field--password">
    <label for="password_confirmation">Confirma tu contraseña</label>
    <input id="password_confirmation" type="password" name="password_confirmation" placeholder="**************" autocomplete="new-password" required>
    <button type="button" class="show-password-btn" aria-label="Mostrar/ocultar contraseña" data-target="password_confirmation">👁️</button>
</div>
                            <div class="field field--check">
                                <div class="check">
                                    <input type="checkbox" name="receive_whatsapp" id="wa">
                                    <span>Acepta recibir información por WhatsApp</span>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Panel 2 --}}
                    <section class="panel" id="panel-direccion" role="tabpanel" aria-labelledby="tab-direccion">
                        <div class="form-grid">
                            <div class="field">
                                <label for="address">Dirección</label>
                                <input id="address" type="text" name="address" value="{{ old('address') }}" placeholder="Ingrese su dirección" autocomplete="address-line1" required>
                                @error('address') <span class="error-message">{{ $message }}</span> @enderror
                            </div>
                            <div class="field">
                                <label for="locality">Localidad</label>
                                <input id="locality" type="text" name="locality" value="{{ old('locality') }}" placeholder="Ingrese su localidad">
                                @error('locality') <span class="error-message">{{ $message }}</span> @enderror
                            </div>
                            <div class="field">
                                <label for="neighborhood">Barrio</label>
                                <input id="neighborhood" type="text" name="neighborhood" value="{{ old('neighborhood') }}" placeholder="Ingrese su barrio">
                                @error('neighborhood') <span class="error-message">{{ $message }}</span> @enderror
                            </div>
                            <div class="field">
                                <label for="postal_code">Código postal</label>
                                <input id="postal_code" type="text" name="postal_code" value="{{ old('postal_code') }}" placeholder="Ingrese su código postal" inputmode="numeric">
                                @error('postal_code') <span class="error-message">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </section>

                    {{-- Panel 3 --}}
                    <section class="panel" id="panel-residuos" role="tabpanel" aria-labelledby="tab-residuos">
                        <div class="residuos" id="residuos">
                            <article class="card" data-waste-id="organicos" tabindex="0">
                                <img src="{{ asset('img/residuos/organicos.png') }}" alt="Orgánicos">
                                <h4>ORGÁNICOS</h4>
                                <p>Material biodegradable de origen vegetal: restos de comida, cáscaras, hojas, residuos de jardín.</p>
                                <input type="checkbox" name="waste_types[]" value="organicos" hidden>
                            </article>
                            <article class="card" data-waste-id="inorganicos" tabindex="0">
                                <img src="{{ asset('img/residuos/inorganicos.png') }}" alt="Inorgánicos">
                                <h4>INORGÁNICOS</h4>
                                <p>Desechos no biodegradables que pueden ser reciclados o reutilizados: plásticos, cartón, vidrio, metales, telas.</p>
                                <input type="checkbox" name="waste_types[]" value="inorganicos" hidden>
                            </article>
                            <article class="card" data-waste-id="peligrosos" tabindex="0">
                                <img src="{{ asset('img/residuos/peligrosos.png') }}" alt="Peligrosos">
                                <h4>PELIGROSOS</h4>
                                <p>Riesgo para la salud o el medio ambiente: pilas, medicamentos vencidos, aceites.</p>
                                <input type="checkbox" name="waste_types[]" value="peligrosos" hidden>
                            </article>
                        </div>
                        <p class="muted" style="text-align:center;margin-top:10px">Puedes escoger más de uno</p>
                    </section>
                </form>
            </div>
        </div>

        <footer class="dialog__footer">
            <button class="btn btn--ghost" id="btnBack" type="button">Atrás</button>
            <button class="btn btn--primary" id="btnNext" type="button">Continuar</button>
        </footer>
    </section>
</div>

{{-- Enlazar el archivo JavaScript externo --}}
<script src="{{ asset('js/register.js') }}" defer></script>
</body>
</html>
