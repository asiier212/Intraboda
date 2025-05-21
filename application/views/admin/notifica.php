<div id="filtros-notificaciones">
    <div class="contenedor-filtros-wrapper">
        <div id="botones-filtro">
            <button data-filtro="todas" class="btn-filtro active">Todos <span class="contador">0</span></button>
            <button data-filtro="no_leidas" class="btn-filtro">No leídos <span class="contador">0</span></button>
            <button data-filtro="leidas" class="btn-filtro">Leídos <span class="contador">0</span></button>
        </div>
    </div>

    <!-- botón fuera del wrapper flex -->
    <div class="contenedor-bt" style="margin-top: 30px;">
        <button id="btn-borrar-todo" title="Borrar todas las notificaciones" aria-label="Borrar todas las notificaciones">
            <svg xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle;" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2" viewBox="0 0 24 24">
                <polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                <path d="M10 11v6"></path>
                <path d="M14 11v6"></path>
                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"></path>
            </svg>
            <span style="margin-left:6px;">Borrar todo</span>
        </button>
    </div>
</div>



<div id="notificaciones-lista">
    <ul id="lista-notificaciones"></ul>
</div>

<script>
    let filtroActual = 'todas';

    function cargarNotificaciones(filtro) {
        fetch(`<?= base_url() . 'admin/notificaciones_ajax' ?>/${filtro}`)
            .then(res => res.json())
            .then(data => {
                const lista = document.getElementById('lista-notificaciones');
                lista.innerHTML = '';

                const btnBorrarTodo = document.getElementById('btn-borrar-todo');
                btnBorrarTodo.style.display = (filtro === 'todas' && data.length > 0) ? 'flex' : 'none';

                if (data.length === 0) {
                    lista.innerHTML = `
                    <li class="no-notificaciones">
                        <div>
                            <p class="mensaje-vacia">📭 No hay notificaciones para mostrar</p>
                        </div>
                    </li>`;
                } else {
                    data.forEach(notif => {
                        const li = document.createElement('li');
                        li.className = 'notificacion' + (notif.leido == 1 ? ' leido' : '');
                        li.setAttribute('data-id', notif.id);
                        li.innerHTML = `
                        <div class="notificacion-content">
                            <p class="mensaje">${notif.mensaje}</p>
                            <p class="fecha">${notif.fecha}</p>
                        </div>
                        <a href="javascript:void(0);" class="borrar-notificacion" data-id="${notif.id}">
                            <img class="papelera" src="<?= base_url() ?>/img/papelera.png" />
                        </a>
                    `;
                        lista.appendChild(li);
                    });
                }

                // Siempre actualizar contadores después
                fetch('<?= base_url() ?>admin/contadores_notificaciones')
                    .then(res => res.json())
                    .then(contadores => {
                        document.querySelector('[data-filtro="todas"] .contador').textContent = contadores.todas;
                        document.querySelector('[data-filtro="no_leidas"] .contador').textContent = contadores.no_leidas;
                        document.querySelector('[data-filtro="leidas"] .contador').textContent = contadores.leidas;
                    });
            });
    }

    cargarNotificaciones(filtroActual);

    setInterval(() => {
        cargarNotificaciones(filtroActual);
    }, 5000);

    document.querySelectorAll('.btn-filtro').forEach(btn => {
        btn.addEventListener('click', () => {
            filtroActual = btn.getAttribute('data-filtro');
            document.querySelectorAll('.btn-filtro').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            cargarNotificaciones(filtroActual);
        });
    });

    // Delegación para marcar leída y borrar
    document.getElementById('lista-notificaciones').addEventListener('click', function(e) {
        let target = e.target;
        let li = target.closest('li.notificacion');
        if (!li) return;

        // Marcar como leída
        if (!target.classList.contains('papelera') && !target.closest('.borrar-notificacion')) {
            let id = li.getAttribute('data-id');
            fetch(`<?= base_url() ?>admin/marcar_leida`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        'id': id
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        li.classList.add('leido');
                        cargarNotificaciones(filtroActual); // Actualizar contadores
                    }
                });
        }

        // Borrar una notificación
        if (target.classList.contains('papelera') || target.closest('.borrar-notificacion')) {
            const idNotificacion = target.closest('a.borrar-notificacion').getAttribute('data-id');
            fetch(`<?= base_url() . 'admin/borrar_notificacion' ?>`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        'id_notificacion': idNotificacion
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        li.classList.add('anim-borrar');
                        setTimeout(() => {
                            li.remove();
                            cargarNotificaciones(filtroActual); // Actualizar contadores
                        }, 400);
                    } else {
                        alert('Error al borrar la notificación.');
                    }
                });
        }
    });

    // Borrar todas
    document.getElementById('btn-borrar-todo').addEventListener('click', () => {
        if (!confirm("¿Estás seguro de que quieres borrar todas las notificaciones?")) return;

        fetch(`<?= base_url() ?>admin/borrar_todas_notificaciones`, {
                method: 'POST'
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const lista = document.getElementById('lista-notificaciones');
                    lista.querySelectorAll('li.notificacion').forEach(li => {
                        li.classList.add('anim-borrar');
                        setTimeout(() => li.remove(), 400);
                    });
                    cargarNotificaciones(filtroActual); // Actualizar contadores
                } else {
                    alert('Error al borrar todas las notificaciones.');
                }
            });
    });
</script>


<style>
    #filtros-notificaciones {
        margin-bottom: 25px;
        text-align: center;
        margin-top: 50px;
    }

    .btn-filtro {
        background: #f0f0f0;
        border: 1px solid #ccc;
        padding: 10px 24px;
        margin: 0 6px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 15px;
        color: #333;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        transition: all 0.25s ease-in-out;
    }

    .btn-filtro:hover {
        background-color: #e0e0e0;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
    }

    .btn-filtro.active {
        background-color: #93CE37;
        color: white;
        border-color: #93CE37;
    }

    #lista-notificaciones {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .notificacion {
        width: 90%;
        max-width: 800px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #ffffff;
        padding: 16px;
        margin-bottom: 12px;
        border-left: 5px solid #93CE37;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        transition: background 0.3s ease, border-left-color 0.3s ease, opacity 0.3s ease;
        cursor: pointer;
    }

    .notificacion.leido {
        background: #f5f5f5;
        border-left-color: #ccc;
        font-style: italic;
        opacity: 0.6;
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }

        to {
            opacity: 0;
        }
    }

    .anim-borrar {
        animation: fadeOut 0.4s forwards;
    }

    .borrar-notificacion img.papelera {
        width: 20px;
        height: auto;
        transition: 350ms;
    }

    .borrar-notificacion img.papelera:hover {
        content: url('<?= base_url() ?>img/papeleraH.png');
        width: 25px;
        height: auto;
        transition: 350ms;
    }

    .no-notificaciones {
        width: 90%;
        max-width: 600px;
        background: #f9f9f9;
        color: #666;
        text-align: center;
        padding: 40px 20px;
        border-radius: 8px;
        font-style: italic;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
    }

    .mensaje-vacia {
        font-size: 1.1em;
        margin: 0;
    }

    .contenedor-filtros-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        max-width: 900px;
        margin: 0 auto;
        position: relative;
    }


    .contenedor-bt {
        display: flex;
        justify-content: center;
    }

    #btn-borrar-todo {
        background-color: rgb(238, 46, 32);
        color: #fff;
        border: none;
        padding: 10px 18px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: 300ms;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }


    #botones-filtro {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex: 1;
    }

    #btn-borrar-todo:hover {
        background-color: rgb(216, 35, 25);
        box-shadow: 0 2px 4px rgba(179, 36, 29, 0.5);
        transform: translateY(0%) scale(1.03);
        transition: 300ms;
    }


    #notificaciones-lista {
        background-color: #f9f9f9;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 0px 6px rgba(0, 0, 0, 0.06);
    }
</style>