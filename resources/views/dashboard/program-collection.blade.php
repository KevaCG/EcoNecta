<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programar Recolección - EcoNecta</title>
    <link rel="stylesheet" href="{{ asset('assets/css/program-collection.css') }}">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="logo">
                <img src="{{ asset('assets/img/econeecta-logo.png') }}" alt="EcoNecta">
            </div>
            <div class="user-info">
                <img src="{{ $avatarUrl }}" alt="Avatar de perfil">
                <h4>¡Bienvenida {{ Auth::user()->name }}!</h4>
            </div>
            <nav class="nav-menu">
                <a href="#">Actualizar datos</a>
                <a href="{{ route('collections.create') }}">Programar</a>
                <a href="#">Puntos</a>
                <a href="#">Cancelar</a>
            </nav>
        </aside>

        <main class="main-content">
            <header class="dashboard-header">
                <h1 class="dashboard-title">Usuario - Programar</h1>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </header>

            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <section class="section">
                <h2 class="section-title">PROGRAMAR</h2>
                <div style="text-align: center;">
                    <button id="open-modal-btn" class="btn-primary" style="padding: 15px 30px; font-size: 1.2rem;">Programar una recolección</button>
                </div>
            </section>

            <section class="section">
                <h2 class="section-title">HISTORIAL</h2>
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Residuo</th>
                            <th>Puntos ganados</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
    @forelse($history as $record)
        <tr>
            <td>{{ $record->scheduled_date->format('d/m/Y') }}</td>
            <td>{{ ucfirst($record->waste_type) }}</td>
            <td>{{ $record->points ?? 0 }}</td>
            <td><span class="status-rescheduled">{{ ucfirst($record->status) }}</span></td>
        </tr>
    @empty
        <tr>
            <td colspan="4">No tienes recolecciones programadas.</td>
        </tr>
    @endforelse
</tbody>
                </table>
            </section>
        </main>
    </div>

    <div id="programar-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <div class="modal-header">
                <h2>Programar Recolección</h2>
            </div>
            <div class="modal-body">
                <form id="program-form" action="{{ route('collections.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="waste_type">Tipo de residuo</label>
                        <select name="waste_type" id="waste_type" required>
                            <option value="">Selecciona un tipo</option>
                            <option value="organicos">Orgánicos</option>
                            <option value="inorganicos">Inorgánicos</option>
                            <option value="peligrosos">Peligrosos</option>
                        </select>
                    </div>
                    <p>Se queda una recolección de [Tipo] disponible, elige la fecha</p>
                    <div id="calendar"></div>
                    <input type="hidden" id="selected_date" name="scheduled_date">
                    <div class="form-buttons">
                        <button type="button" class="btn-secondary">Reprogramar</button>
                        <button type="submit" id="btn-programar" class="btn-primary" disabled>Programar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. Lógica del Modal ---
        var modal = document.getElementById("programar-modal");
        var openModalBtn = document.getElementById("open-modal-btn");
        var closeModalBtn = document.getElementsByClassName("close-btn")[0];

        // Bandera para saber si el calendario ya fue renderizado
        var calendarRendered = false;

        // Cuando el usuario hace clic en el botón, abre el modal
        if (openModalBtn) {
            openModalBtn.onclick = function() {
                modal.style.display = "flex";
                // Llama a la función de renderizado del calendario solo si no se ha hecho antes
                if (!calendarRendered) {
                    renderCalendar();
                    calendarRendered = true;
                }
            }
        }

        // Cuando el usuario hace clic en (x), cierra el modal
        if (closeModalBtn) {
            closeModalBtn.onclick = function() {
                modal.style.display = "none";
            }
        }

        // Cuando el usuario hace clic en cualquier lugar fuera del modal, lo cierra
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    });

    // Función para inicializar y renderizar el calendario
    function renderCalendar() {
        var calendarEl = document.getElementById('calendar');
        var selectedDateInput = document.getElementById('selected_date');
        var programButton = document.getElementById('btn-programar');
        var wasteTypeSelect = document.getElementById('waste_type');

        // Función de validación para habilitar/deshabilitar el botón
        function validateForm() {
            var selectedDate = selectedDateInput.value;
            var selectedWasteType = wasteTypeSelect.value;

            if (selectedDate && selectedWasteType) {
                programButton.disabled = false;
            } else {
                programButton.disabled = true;
            }
        }

        if (calendarEl) {
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                selectable: true,
                select: function(info) {
                    selectedDateInput.value = info.startStr;
                    validateForm(); // Llama a la validación al seleccionar una fecha
                },
                unselect: function() {
                    selectedDateInput.value = '';
                    validateForm(); // Llama a la validación al deseleccionar
                }
            });
            calendar.render();
        }

        // Escucha cambios en el campo de selección del tipo de residuo
        if (wasteTypeSelect) {
            wasteTypeSelect.addEventListener('change', validateForm);
        }

        // Establece el estado inicial del botón
        validateForm();
    }
</script>
</body>
</html>
