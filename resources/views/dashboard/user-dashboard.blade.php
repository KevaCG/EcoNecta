<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Usuario</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

    <style>
        :root{
            --green:#2b7a2b; --green-100:#e8f5e9; --blue-100:#e3f2fd; --red-100:#ffebee;
        }
        *{box-sizing:border-box}
        body{font-family:'Inter',sans-serif;background:#f0f4f7;margin:0;display:flex}
        .sidebar{width:250px;background:#e5f0e5;padding:20px;color:#333;height:100vh;position:fixed;display:flex;flex-direction:column;align-items:center}
        .sidebar .logo{margin-bottom:30px}
        .sidebar .logo img{width:120px}
        .sidebar .user-info{text-align:center;margin-bottom:30px}
        .sidebar .user-info img{width:80px;height:80px;border-radius:50%;object-fit:cover;margin-bottom:10px}
        .sidebar .user-info h4{margin:0;font-size:1rem}
        .sidebar .nav-menu{width:100%}
        .sidebar .nav-menu a{display:block;padding:12px 14px;text-decoration:none;color:#555;font-weight:600;border-radius:8px;transition:.2s}
        .sidebar .nav-menu a:hover{background:#dbe4db}
        .main{margin-left:250px;padding:32px;flex-grow:1}
        .header{display:flex;justify-content:space-between;align-items:center;margin-bottom:24px}
        .header h1{font-size:1.6rem;color:var(--green);margin:0}
        .header a{color:#555;text-decoration:none}
        .section{background:#fff;padding:24px;border-radius:14px;box-shadow:0 4px 10px rgba(0,0,0,.06);margin-bottom:24px}
        .section-title{font-size:1.2rem;margin:0 0 16px 0;color:#2e4a3d}
        .calendar{border:1px solid #e5e7eb;border-radius:10px;padding:10px}
        .summary-cards{display:flex;gap:16px;flex-wrap:wrap}
        .summary-card{flex:1;min-width:220px;text-align:center;padding:18px;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,.05)}
        .summary-card.organicos{background:var(--green-100)}
        .summary-card.inorganicos{background:var(--blue-100)}
        .summary-card.peligrosos{background:var(--red-100)}
        .summary-card h4{margin:0 0 6px 0}

        .history-table{width:100%;border-collapse:collapse;background:#fff;border-radius:12px;overflow:hidden}
        .history-table th{background:#4a7856;color:#fff;padding:12px;text-align:left}
        .history-table td{padding:12px;border-bottom:1px solid #eee}
        .status-received{color:#2e7d32;font-weight:700}
        .status-pending{color:#d17d00;font-weight:700}
        .status-reprogramada{color:#1f78d1;font-weight:700}

        .btn{padding:10px 14px;border:none;border-radius:10px;cursor:pointer;font-weight:700}
        .btn-primary{background:var(--green);color:#fff}
        .btn-primary:hover{background:#256b25}
        .btn-secondary{background:#e5e7eb;color:#111}
        .btn-secondary:hover{background:#d1d5db}
        .btn-warning{background:#f59e0b;color:#111}
        .btn-link{background:transparent;border:none;color:var(--green);cursor:pointer}

        /* Modal base */
        .modal{display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);justify-content:center;align-items:center;z-index:1000}
        .modal-content{background:#fff;padding:22px;border-radius:16px;width:420px;max-width:92%;box-shadow:0 10px 30px rgba(0,0,0,.25);animation:fadeIn .18s ease}
        .modal-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:10px}
        .modal-header h3{margin:0;color:var(--green);font-size:1.05rem}
        .modal-close{cursor:pointer;font-size:22px;font-weight:800;color:#777}
        .modal-close:hover{color:#000}
        .form label{display:block;margin:10px 0 6px;font-weight:700;color:#333}
        .form input,.form select{width:100%;padding:10px;border:1px solid #ddd;border-radius:10px;font-size:.95rem}
        .modal-actions{display:flex;gap:10px;justify-content:flex-end;margin-top:14px}
        @keyframes fadeIn{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:none}}

        .alert{padding:12px 14px;border-radius:10px;margin-bottom:14px}
        .alert-success{background:#ecfdf5;color:#065f46;border:1px solid #a7f3d0}
        .alert-error{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="logo">
            <img src="{{ asset('assets/img/econeecta-logo.png') }}" alt="EcoNecta Logo">
        </div>
        <div class="user-info">
            <img src="{{ $avatarUrl }}" alt="Avatar de perfil">
            <h4>¡Bienvenida {{ Auth::user()->name }}!</h4>
        </div>
        <nav class="nav-menu">
            <a href="#" id="openCreateFromSidebar">➕ Programar recolección</a>
            <a href="{{ route('profile.edit') }}">Actualizar datos</a>
            <a href="#">Puntos</a>
        </nav>
    </aside>

    <main class="main">
        <header class="header">
            <h1>Dashboard - Usuario</h1>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">@csrf</form>
        </header>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin:0;padding-left:18px">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <section class="section">
            <h2 class="section-title">Recolecciones programadas</h2>
            <div id="calendar" class="calendar"></div>
        </section>

        <section class="section">
            <h2 class="section-title">Resumen</h2>
            <div class="summary-cards">
                <div class="summary-card organicos">
                    <h4>Orgánicos</h4>
                    <p>Total de horas de recolección</p>
                </div>
                <div class="summary-card inorganicos">
                    <h4>Inorgánicos</h4>
                    <p>Te queda 1 recolección disponible</p>
                </div>
                <div class="summary-card peligrosos">
                    <h4>Peligrosos</h4>
                    <p>Te queda 1 recolección disponible</p>
                </div>
            </div>
        </section>

        <section class="section">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px">
                <h2 class="section-title" style="margin:0">Historial</h2>
                <div style="display:flex;gap:8px;flex-wrap:wrap">
                    <button id="btnOpenCreate" class="btn btn-primary">➕ Programar recolección</button>
                    <a class="btn btn-secondary" href="{{ route('collections.export.excel') }}">📊 Exportar Excel</a>
                    <a class="btn btn-secondary" href="{{ route('collections.export.pdf') }}">📄 Exportar PDF</a>
                </div>
            </div>

            <table class="history-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Residuo</th>
                        <th>Kg / Puntos</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history as $item)
                        <tr>
                            <td>{{ \Illuminate\Support\Carbon::parse($item->scheduled_date)->format('Y-m-d') }}</td>
                            <td>{{ $item->waste_type }}</td>
                            <td>{{ $item->kilos }}kg / {{ $item->points }} puntos</td>
                            <td class="status-{{ strtolower($item->status) }}">{{ ucfirst($item->status) }}</td>
                            <td>
                                <button
                                    class="btn btn-warning btn-reprogram"
                                    data-id="{{ $item->id }}"
                                    data-date="{{ \Illuminate\Support\Carbon::parse($item->scheduled_date)->format('Y-m-d') }}"
                                >✏️ Reprogramar</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">Aún no tienes recolecciones.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </main>

    {{-- Modal: Crear recolección --}}
    <div id="createModal" class="modal" aria-hidden="true">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Programar nueva recolección</h3>
                <span class="modal-close" data-close-create>&times;</span>
            </div>
            <form class="form" action="{{ route('collections.store') }}" method="POST">
                @csrf
                <label for="waste_type">Tipo de residuo</label>
                <select name="waste_type" id="waste_type" required>
                    <option value="">Selecciona…</option>
                    <option value="Orgánico">Orgánico</option>
                    <option value="Inorgánico">Inorgánico</option>
                    <option value="Peligroso">Peligroso</option>
                </select>

                <label for="scheduled_date">Fecha</label>
                <input type="date" name="scheduled_date" id="scheduled_date" required>

                <label for="kilos">Cantidad (kg)</label>
                <input type="number" name="kilos" id="kilos" min="1" required>

                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" data-close-create>Cancelar</button>
                    <button type="submit" class="btn btn-primary">💾 Guardar</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal: Reprogramar --}}
    <div id="reprogramModal" class="modal" aria-hidden="true">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Reprogramar recolección</h3>
                <span class="modal-close" data-close-reprogram>&times;</span>
            </div>
            <form class="form" id="reprogramForm" method="POST">
                @csrf
                <label for="new_date">Nueva fecha</label>
                <input type="date" name="scheduled_date" id="new_date" required>
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" data-close-reprogram>Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // ---------- Calendario ----------
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                height: 'auto',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: @json($calendarEvents)
            });
            calendar.render();
        });

        // ---------- Crear recolección ----------
        const createModal = document.getElementById('createModal');
        const openCreateButtons = [
            document.getElementById('btnOpenCreate'),
            document.getElementById('openCreateFromSidebar')
        ].filter(Boolean);

        function openCreate() { createModal.style.display = 'flex'; }
        function closeCreate() { createModal.style.display = 'none'; }

        openCreateButtons.forEach(btn => btn.addEventListener('click', e => { e.preventDefault(); openCreate(); }));
        document.querySelectorAll('[data-close-create]').forEach(el => el.addEventListener('click', closeCreate));
        window.addEventListener('click', (e)=>{ if(e.target===createModal) closeCreate(); });

        // ---------- Reprogramar ----------
        const reprogramModal = document.getElementById('reprogramModal');
        const reprogramForm  = document.getElementById('reprogramForm');
        const newDateInput   = document.getElementById('new_date');

        function openReprogram(id, date){
            reprogramForm.action = `{{ url('/collections/reprogram') }}/${id}`; // POST /collections/reprogram/{id}
            newDateInput.value = date;
            reprogramModal.style.display = 'flex';
        }
        function closeReprogram(){ reprogramModal.style.display = 'none'; }

        document.querySelectorAll('.btn-reprogram').forEach(btn=>{
            btn.addEventListener('click', function(){
                openReprogram(this.dataset.id, this.dataset.date);
            });
        });
        document.querySelectorAll('[data-close-reprogram]').forEach(el => el.addEventListener('click', closeReprogram));
        window.addEventListener('click', (e)=>{ if(e.target===reprogramModal) closeReprogram(); });
    </script>
</body>
</html>
