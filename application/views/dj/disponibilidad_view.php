<style>
    body {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        background: #eaf4dc;
        /* verde muy claro */
        margin: 0;
        padding: 20px;
        color: #2e3a21;
        /* verde oscuro suave */
        line-height: 1.5;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    #calendario {
        max-width: 900px;
        margin: 0 auto 30px;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(147, 206, 55, 0.3);
        /* sombra verde */
        padding: 15px 20px;
        border: 2px solid #93CE37;
    }

    /* Overlay del modal */
    #modalOverlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.25);
        /* verde semitransparente */
        z-index: 999;
        transition: opacity 0.3s ease;
    }

    /* Caja modal */
    #modalDisponibilidad {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #f9fff1;
        /* verde muy suave */
        padding: 30px 35px;
        border-radius: 14px;
        box-shadow: 0 6px 20px rgba(51, 94, 0, 0.3);
        width: 340px;
        max-width: 95%;
        z-index: 1000;
        transition: opacity 0.3s ease, transform 0.3s ease;
        border: 2px solid #93CE37;
    }

    /* Título modal */
    #modalDisponibilidad h4 {
        margin-top: 0;
        margin-bottom: 20px;
        font-weight: 700;
        color: #61892f;
        text-align: center;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        font-family: "Segoe UI Semibold", Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Etiquetas */
    #formDisponibilidad label {
        font-weight: 600;
        font-size: 0.95em;
        display: block;
        margin-bottom: 8px;
        color: #4a5a20;
    }

    /* Inputs tiempo */
    #formDisponibilidad input[type="time"] {
        width: 100%;
        padding: 9px 12px;
        border-radius: 6px;
        border: 1.5px solid #a8d158;
        font-size: 1em;
        margin-bottom: 18px;
        box-sizing: border-box;
        transition: border-color 0.3s ease;
        background-color: #f0f7d4;
        color: #37500a;
    }

    #formDisponibilidad input[type="time"]:focus {
        border-color: #61892f;
        outline: none;
        background-color: #e5f1a6;
    }

    /* Botones comunes */
    #formDisponibilidad button {
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-weight: 700;
        cursor: pointer;
        margin-right: 10px;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 3px 8px rgba(81, 130, 0, 0.25);
        color: #fff;
        font-size: 1em;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Botón guardar */
    #formDisponibilidad button[type="submit"] {
        background-color: #93CE37;
    }

    #formDisponibilidad button[type="submit"]:hover,
    #formDisponibilidad button[type="submit"]:focus {
        background-color: #75a92c;
        box-shadow: 0 5px 14px rgba(117, 169, 44, 0.7);
    }

    /* Botón cancelar */
    #btnCancelar,
    #formDisponibilidad button[type="button"] {
        background-color: #5a6a4f;
        color: white;
        box-shadow: 0 3px 8px rgba(90, 106, 79, 0.25);
    }

    #btnCancelar:hover,
    #btnCancelar:focus,
    #formDisponibilidad button[type="button"]:hover,
    #formDisponibilidad button[type="button"]:focus {
        background-color: #46543c;
        box-shadow: 0 5px 14px rgba(70, 84, 60, 0.7);
    }

    /* Botones FullCalendar */
    #calendario .fc-button {
        background-color: #61892f;
        color: #f4f9e9;
        border: 1px solid #93CE37;
        border-radius: 6px;
        padding: 9px 18px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        box-shadow: 0 3px 8px rgba(81, 130, 0, 0.3);
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    #calendario .fc-button:hover,
    #calendario .fc-button:focus {
        background-color: #75a92c;
        box-shadow: 0 5px 14px rgba(117, 169, 44, 0.6);
        outline: none;
    }

    #calendario .fc-button:active {
        background-color: #48601e;
        box-shadow: inset 0 3px 8px rgba(0, 0, 0, 0.25);
    }

    #calendario .fc-day-today {
        background-color: rgba(147, 206, 55, 0.5) !important;
        color: #2e3a21 !important;
        font-weight: 700;
        box-shadow: 0 0 12px 0px rgba(147, 206, 55, 0.6);
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .fc-event {
        cursor: default !important;
        text-decoration: none !important;
        color: inherit !important;
        background-color: inherit !important;
    }

    .fc-event:hover {
        background-color: inherit !important;
        box-shadow: none !important;
    }

    #calendario .fc-daygrid-day {
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    #calendario .fc-daygrid-day:hover {
        background-color: #d8e8a1;
        box-shadow: inset 0 0 8px rgba(81, 130, 0, 0.25);
    }

    #modalContenido h4 {
        font-weight: 700;
        color: #61892f;
        margin-bottom: 22px;
        text-align: center;
        font-size: 1.6em;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        font-family: "Segoe UI Semibold", Tahoma, Geneva, Verdana, sans-serif;
        border-bottom: 3px solid #93CE37;
        padding-bottom: 8px;
    }

    #modalContenido ul {
        list-style: none;
        padding-left: 0;
        margin-bottom: 28px;
        color: #37500a;
        font-size: 1.15em;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    #modalContenido ul li {
        background: #ecf4b6;
        margin-bottom: 14px;
        padding: 12px 18px;
        border-radius: 10px;
        box-shadow: 0 3px 8px rgba(105, 140, 33, 0.3);
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: background-color 0.3s ease;
        cursor: default;
    }

    #modalContenido ul li button {
        margin-left: 10px;
        background-color: #93CE37;
        border: none;
        color: white;
        padding: 7px 16px;
        font-size: 1em;
        border-radius: 7px;
        cursor: pointer;
        font-weight: 700;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    #modalContenido ul li button:hover {
        background-color: rgb(152, 189, 93);
        color: white;
        box-shadow: 0 3px 8px rgba(140, 163, 59, 0.25);
    }

    #btnEliminar,
    .eliminarDisp {
        background-color: rgb(255, 25, 25) !important;
        color: white !important;
        box-shadow: 0 3px 8px rgba(191, 62, 62, 0.25) !important;
    }

    #btnEliminar:hover,
    #btnEliminar:focus,
    .eliminarDisp:hover,
    .eliminarDisp:focus {
        background-color: rgb(194, 47, 47) !important;
        box-shadow: 0 5px 14px rgba(140, 42, 42, 0.7) !important;
    }

    #modalContenido ul li button:hover {
        cursor: pointer;
        background-color: ;
        box-shadow: 0 4px 12px rgba(117, 169, 44, 0.7);
    }

    /* Botones generales fuera del formulario */
    #btnNuevaDisp,
    #btnCanc,
    #modalContenido>button {
        background-color: #93CE37;
        border: none;
        color: #fff;
        padding: 12px 24px;
        font-weight: 700;
        border-radius: 8px;
        cursor: pointer;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        font-size: 1.1em;
        margin: 10px 7px 0 0;
        box-shadow: 0 4px 10px rgba(81, 130, 0, 0.45);
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    #btnNuevaDisp:hover,
    #modalContenido>button:hover {
        background-color: #75a92c;
        box-shadow: 0 5px 14px rgba(117, 169, 44, 0.7);
    }

    #btnCanc {
        background-color: #5a6a4f;
        color: white;
        box-shadow: 0 3px 8px rgba(90, 106, 79, 0.25);
        border: none;
        padding: 12px 24px;
        font-weight: 700;
        border-radius: 8px;
        cursor: pointer;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        font-size: 1.1em;
        margin: 10px 7px 0 0;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    #btnCanc:hover {
        background-color: #46543c;
        box-shadow: 0 5px 14px rgba(70, 84, 60, 0.7);
    }

    .fc-event-time {
        display: none;
    }

    .fc-daygrid-event-dot {
        background-color: transparent !important;
        border-color: rgb(0, 143, 43) !important;
        /* si es un borde */
        color: rgb(0, 143, 43) !important;
        /* si es texto o símbolo */
        fill: rgb(0, 143, 43) !important;
        /* para SVG */
    }
</style>

<div id="leyenda-calendario" style="margin-bottom: 10px;">
    <span style="display:inline-block; width:12px; height:12px; background-color:#28a745; margin-right:5px;"></span>
    <span style="margin-right:15px;">Validado</span>
    <span style="display:inline-block; width:12px; height:12px; background-color:rgb(255, 221, 72); margin-right:5px;"></span>
    <span>Pendiente</span>
</div>


<div id="calendario"></div>

<div id="modalOverlay"></div>
<div id="modalDisponibilidad">
    <div id="modalContenido"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendario');
        var modal = document.getElementById('modalDisponibilidad');
        var overlay = document.getElementById('modalOverlay');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            selectable: true,
            editable: true,
            firstDay: 1,
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'today'
            },
            buttonText: {
                today: 'Hoy'
            },
            events: '<?= base_url() . "dj/disponibilidad?load=1" ?>',

            eventDidMount: function(info) {
                var innerTextEl = info.el.querySelector('.fc-event-title');
                if (innerTextEl) {
                    var validacion = info.event.extendedProps.validacion;
                    if (validacion == 1) {
                        innerTextEl.style.color = 'orange';
                    } else if (validacion == 2) {
                        innerTextEl.style.color = 'green';
                    }
                }
            },

            dateClick: function(info) {
                var dateStr = info.dateStr;
                var events = calendar.getEvents().filter(function(ev) {
                    return ev.startStr.substr(0, 10) === dateStr;
                });

                if (events.length === 0) {
                    abrirFormularioNueva(dateStr);
                } else {
                    mostrarListaDisponibilidades(events, dateStr);
                }
            },

            eventClick: function(info) {
                var dateStr = info.event.startStr.substr(0, 10);
                var events = calendar.getEvents().filter(function(ev) {
                    return ev.startStr.substr(0, 10) === dateStr;
                });
                mostrarListaDisponibilidades(events, dateStr);
            },
        });
        calendar.on('datesSet', function(info) {
            let titulo = info.view.title;
            // Capitalizar la primera letra
            let tituloCapitalizado = titulo.charAt(0).toUpperCase() + titulo.slice(1);
            document.querySelector('.fc-toolbar-title').textContent = tituloCapitalizado;
        });

        calendar.render();

        function mostrarListaDisponibilidades(events, fecha) {
            let html = '<h4>No Disponibilidades para ' + fecha + '</h4><ul style="list-style:none; padding:0;">';
            events.forEach(function(ev) {
                let start = ev.startStr.substr(11, 5);
                let end = ev.endStr.substr(11, 5);

                let bgColor = '';
                if (ev.extendedProps.validacion == '1') {
                    bgColor = 'background-color:rgb(255, 214, 79); color: white;';
                } else if (ev.extendedProps.validacion == '2') {
                    bgColor = 'background-color: #51a25f; color: white;';
                }

                html += `<li style="margin-bottom:10px; ${bgColor}">
                        De <strong>${start}</strong> a <strong>${end}</strong>
                        <button class="editarDisp" data-id="${ev.id}">Editar</button>
                        <button class="eliminarDisp" data-id="${ev.id}">Eliminar</button>
                     </li>`;
            });
            html += '</ul>';
            html += `<div style="text-align:center;">
                    <button id="btnNuevaDisp">Nueva  no disponibilidad</button>
                    <button id="btnCanc" onclick="hideModal()">Cerrar</button>
                 </div>`;
            $('#modalContenido').html(html);
            showModal();

            $('.editarDisp').off().on('click', function() {
                let id = $(this).data('id');
                let ev = calendar.getEventById(id);
                if (ev) abrirFormularioEdicion(ev);
            });

            $('.eliminarDisp').off().on('click', function() {
                let id = $(this).data('id');
                if (confirm("¿Estás seguro que quieres eliminar esta disponibilidad?")) {
                    $.post('<?= base_url() . "dj/disponibilidad" ?>', {
                        eliminar: 1,
                        id: id
                    }, function() {
                        calendar.refetchEvents();
                        hideModal();
                    });
                }
            });

            $('#btnNuevaDisp').off().on('click', function() {
                abrirFormularioNueva(fecha);
            });
        }

        function abrirFormularioNueva(fecha) {
            $('#modalContenido').html(`
            <h4>Nueva No Disponibilidad</h4>
            <form id="formDisponibilidad">
                <input type="hidden" name="id" id="eventoId" value="">
                <input type="hidden" name="fecha" id="fechaSeleccionada" value="${fecha}">
                <label for="horaInicio">Hora inicio:</label>
                <input type="time" name="hora_inicio" id="horaInicio" required>
                <label for="horaFin">Hora fin:</label>
                <input type="time" name="hora_fin" id="horaFin" required>
                <div style="text-align: center; margin-top:10px;">
                    <button type="submit">Guardar</button>
                    <button type="button" onclick="hideModal()">Cancelar</button>
                </div>
            </form>
        `);
            showModal();
            activarSubmitHandler();
        }

        function abrirFormularioEdicion(ev) {
            let fecha = ev.startStr.substr(0, 10);
            $('#modalContenido').html(`
        <h4>Editar No Disponibilidad</h4>
        <form id="formDisponibilidad">
            <input type="hidden" name="id" id="eventoId" value="${ev.id}">
            <input type="hidden" name="fecha" id="fechaSeleccionada" value="${fecha}">
            <label for="horaInicio">Hora inicio:</label>
            <input type="time" name="hora_inicio" id="horaInicio" value="${ev.startStr.substr(11,5)}" required>
            <label for="horaFin">Hora fin:</label>
            <input type="time" name="hora_fin" id="horaFin" value="${ev.endStr.substr(11,5)}" required>
            <div style="text-align: center; margin-top:10px;">
                <button type="submit">Guardar</button>
                <button type="button" id="btnEliminar">Eliminar</button>
                <button type="button" id="btnCancelar" onclick="hideModal()">Cancelar</button>
            </div>
        </form>
    `);
            showModal();
            activarSubmitHandler();
            $('#btnEliminar').on('click', function() {
                if (confirm("¿Eliminar disponibilidad?")) {
                    $.post('<?= base_url() . "dj/disponibilidad" ?>', {
                        eliminar: 1,
                        id: ev.id
                    }, function() {
                        calendar.refetchEvents();
                        hideModal();
                    });
                }
            });
        }

        function activarSubmitHandler() {
            $('#formDisponibilidad').off().on('submit', function(e) {
                e.preventDefault();
                let hora_inicio = $('#horaInicio').val();
                let hora_fin = $('#horaFin').val();
                if (hora_inicio >= hora_fin) {
                    alert("La hora de inicio debe ser menor que la de fin");
                    return;
                }

                $.post('<?= base_url() . "dj/disponibilidad" ?>', {
                    guardar: 1,
                    id: $('#eventoId').val(),
                    fecha: $('#fechaSeleccionada').val(),
                    hora_inicio: hora_inicio,
                    hora_fin: hora_fin
                }, function(res) {
                    try {
                        let data = JSON.parse(res);
                        if (data.status === 'error') {
                            alert(data.msg);
                            return;
                        }
                        calendar.refetchEvents();
                        hideModal();
                    } catch (err) {
                        alert("Error del servidor");
                    }
                });
            });
        }

        function showModal() {
            modal.style.display = 'block';
            overlay.style.display = 'block';
        }

        window.hideModal = function() {
            modal.style.display = 'none';
            overlay.style.display = 'none';
        };

        overlay.addEventListener('click', hideModal);
    });
</script>