@extends('template')

@section('title', 'Calendario')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Calendario</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Calendario</li>
    </ol>

    <div class="card shadow">
        <div class="card-body">
            <!-- Controles de navegación, hoy, mes y año -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <!-- Botones de navegación y hoy -->
                <div class="d-flex align-items-center">
                    <button class="btn btn-outline-primary btn-sm" id="prevButton">&lt;</button>
                    <button class="btn btn-outline-primary btn-sm ml-1" id="nextButton">&gt;</button>
                    <button class="btn btn-secondary btn-sm ml-2" id="todayButton">Hoy</button>
                </div>

                <!-- Título del mes actual -->
                <h2 id="calendarTitle" class="mb-0 text-center flex-grow-1" style="font-size: 1.5rem; text-align: center;">Noviembre de 2024</h2>

                <!-- Selectores de mes y año -->
                <div class="d-flex align-items-center">
                    <select id="monthSelector" class="form-control mr-2" style="width: 150px;">
                        @foreach(['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] as $index => $month)
                            <option value="{{ $index + 1 }}" {{ $index + 1 == now()->month ? 'selected' : '' }}>{{ $month }}</option>
                        @endforeach
                    </select>

                    <select id="yearSelector" class="form-control" style="width: 100px; max-height: 200px; overflow-y: auto;">
                        @foreach(range(date('Y') - 50, date('Y') + 50) as $year)
                            <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Div donde se renderiza el calendario -->
            <div id="calendar"></div>
        </div>
    </div>
</div>
@endsection

@push('css')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.css" rel="stylesheet">
<style>
    #calendar {
        max-width: 100%;
        margin: 0 auto;
        font-size: 1em;
    }

    .fc-toolbar-title {
        display: none; /* Ocultar el título original de FullCalendar */
    }

    /* Estilo para el scroll del selector de años */
    #yearSelector {
        overflow-y: auto;
        max-height: 200px;
    }

    #yearSelector option {
        display: block;
        height: 1.8em;
    }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/locales-all.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');
        const titleEl = document.getElementById('calendarTitle');
        const todayButton = document.getElementById('todayButton');
        const prevButton = document.getElementById('prevButton');
        const nextButton = document.getElementById('nextButton');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            headerToolbar: {
                left: '', // Sin botones a la izquierda
                center: '', // Sin título
                right: '' // Sin controles adicionales
            },
            events: @json($events), // Cargar eventos dinámicos desde el controlador
            datesSet: function(info) {
                // Actualizar el título del mes
                titleEl.textContent = info.view.title;
            }
        });

        // Botón Hoy
        todayButton.addEventListener('click', function () {
            calendar.today();
        });

        // Navegación entre meses
        prevButton.addEventListener('click', function () {
            calendar.prev();
        });

        nextButton.addEventListener('click', function () {
            calendar.next();
        });

        // Cambiar fecha con selectores de mes y año
        const updateCalendarDate = () => {
            const year = document.getElementById('yearSelector').value;
            const month = document.getElementById('monthSelector').value - 1; // Meses en JS son 0-based
            calendar.gotoDate(new Date(year, month));
        };

        document.getElementById('monthSelector').addEventListener('change', updateCalendarDate);
        document.getElementById('yearSelector').addEventListener('change', updateCalendarDate);

        calendar.render();
    });
</script>
@endpush
