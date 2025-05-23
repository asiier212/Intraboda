<script language="javascript">
  function del(id) {

    if (confirm("Esta seguro?")) {
      $("#elem").val(id);
      return true;
    } else {
      return false;
    }

  }

  function cancel(id) {
    $("#txt" + id).css('display', '');
    $("#edit" + id).css('display', 'none');
  }

  function edit(id) {
    $("#txt" + id).css('display', 'none');
    $("#edit" + id).css('display', '');
  }

  function save(id) {
    $("#id").val(id);
    $("#clave").val($("#clave" + id).val());
    $("#nombre").val($("#nombre" + id).val());
    $("#telefono").val($("#telefono" + id).val());
    $("#email").val($("#email" + id).val());
    $("#editform").submit();
  }
</script>

<style>
  body {
    font-family: Arial, sans-serif;
    background: #f8f8f8;
  }

  h2 {
    color: #333;
    margin-bottom: 15px;
  }

  .main.form {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px #ccc;
  }

  fieldset.datos {
    border: 1px solid #ccc;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 8px;
  }

  fieldset.datos legend {
    font-weight: bold;
    color: rgb(110, 179, 0);
    padding: 0 8px;
  }

  fieldset>fieldset {
    background: #f2f2f2;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
  }

  ul {
    list-style: none;
    padding: 0;
  }

  ul li {
    margin-bottom: 10px;
  }

  label {
    display: inline-block;
    width: 120px;
    font-weight: bold;
  }

  input[type="text"],
  input[type="password"],
  input[type="file"],
  select {
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }

  input[type="submit"],
  input[type="button"] {
    background-color: rgb(110, 179, 0);
    border: none;
    color: white;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    margin-right: 5px;
    transition: 300ms;
  }

  input[type="submit"]:hover,
  input[type="button"]:hover {
    background-color: rgb(81, 131, 0);
    transition: 300ms;
  }

  img {
    max-width: 200px;
    border-radius: 6px;
    margin-bottom: 10px;
  }

  .clear {
    clear: both;
  }

  .tabs {
    margin-bottom: 10px;
  }

  .tab-button {
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    padding: 8px 16px;
    cursor: pointer;
    margin-right: 5px;
    font-weight: bold;
    border-radius: 5px 5px 0 0;
    transition: 300ms;
  }

  .tab-button.active {
    background-color: #ffffff;
    border-bottom: none;
    color: rgb(110, 179, 0);
    transition: 300ms;
  }

  .tab-content {
    border: 1px solid #ccc;
    padding: 20px;
    border-radius: 0 5px 5px 5px;
    background: #ffffff;
  }

  .borrar {
    background-color: rgb(255, 9, 9) !important;
    transition: 300ms;
  }

  .borrar:hover {
    background-color: rgb(230, 3, 3) !important;
    transition: 300ms;
  }

  h2 {
    color: #93CE37;
    font-family: Arial, sans-serif;
    font-size: 48px;
    font-weight: bolder;
    padding: 10px 0;
    text-align: left;
    text-shadow: 2px -2px 3px #FFFFFF;
    margin-bottom: 30px;
  }
</style>
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
  .denegar {
    background-color: rgb(255, 25, 25) !important;
    color: white !important;
    box-shadow: 0 3px 8px rgba(191, 62, 62, 0.25) !important;
  }

  #btnEliminar:hover,
  #btnEliminar:focus,
  .denegar:hover,
  .denegar:focus {
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


<h2>
  DJs
</h2>

<div class="tabs">
  <button id="btn-tab1" class="tab-button active" onclick="showTab('tab1')">Gestión</button>
  <button id="btn-tab2" class="tab-button" onclick="showTab('tab2')">No Disponibilidad</button>
</div>


<div id="tab1" class="tab-content">
  <div class="main form">
    <form method="post" enctype="multipart/form-data">
      <fieldset class="datos">
        <legend>Nuevo DJ</legend>
        <ul>
          <li><label>Nombre:</label><input type="text" name="nombre" style="width:200px" /> </li>
          <li><label>Tel&eacute;fono:</label><input type="text" name="telefono" style="width:200px" /> </li>
          <li><label>Email:</label><input type="text" name="email" style="width:200px" /> </li>
          <li><label>Clave:</label><input type="password" name="clave" style="width:200px" /> </li>
          <li><label>Foto (max 200px de ancho):</label><input type="file" name="foto" /> </li>
          <li><label>&nbsp;</label><input type="submit" value="A&ntilde;adir" name="add" style="width:100px" /> </li>
        </ul>
        <?php if (isset($msg)) echo $msg; ?>
      </fieldset>

      <div class="datos" style="border: 1px solid #ccc; border-radius: 8px; padding: 15px; margin-bottom: 20px;">
        <legend style="font-weight:bold; color: rgb(110, 179, 0); margin-bottom:10px;">Listado DJs</legend>
        <div style="display: flex; flex-wrap: wrap; gap: 20px;">
          <?php if ($djs) {
            foreach ($djs as $p) { ?>
              <div style="width: 48%; background: #f2f2f2; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                <strong><a href="<?php echo base_url() ?>admin/djs/view/<?php echo $p['id'] ?>"><?php echo $p['nombre'] ?></a></strong>
                <div id="txt<?php echo $p['id'] ?>">
                  <?php if ($p['foto'] != '') { ?>
                    <img src="<?php echo base_url() ?>uploads/djs/<?php echo $p['foto'] ?>" />
                  <?php } ?>
                  <p>Teléfono: <?php echo $p['telefono'] ?></p>
                  <p>Email: <span style="color:#00C; font-weight:bold"><?php echo $p['email'] ?></span></p>
                  <p>Contraseña: <span style="color:#F00; font-weight:bold"><?php echo $p['clave'] ?></span></p>
                  <input style="width:60px;" type="submit" class="borrar" value="Borrar" name="delete" onclick="return del(<?php echo $p['id'] ?>)" />
                  <input style="width:60px;" type="button" value="Editar" onclick="edit(<?php echo $p['id'] ?>)" />
                </div>

                <div id="edit<?php echo $p['id'] ?>" style="display:none;">
                  <?php if ($p['foto'] != '') { ?>
                    <img src="<?php echo base_url() ?>uploads/djs/<?php echo $p['foto'] ?>" />
                  <?php } ?>
                  <input type="text" id="nombre<?php echo $p['id'] ?>" value="<?php echo $p['nombre'] ?>" />
                  <input type="text" id="telefono<?php echo $p['id'] ?>" value="<?php echo $p['telefono'] ?>" style="width:80px" />
                  <input type="text" id="email<?php echo $p['id'] ?>" value="<?php echo $p['email'] ?>" style="width:120px" />
                  <input type="text" id="clave<?php echo $p['id'] ?>" value="<?php echo $p['clave'] ?>" style="width:120px" />
                  <br />
                  <input style="width:80px;" type="button" value="Cancelar" onclick="cancel(<?php echo $p['id'] ?>)" />
                  <input style="width:60px;" type="button" value="Guardar" onclick="save(<?php echo $p['id'] ?>)" />
                </div>
              </div>
          <?php }
          } ?>
        </div>

        <br />
        <input type="hidden" name="elem" id="elem" />
        <?php if ($djs) { ?>
          <div style="clear:both; margin-top:20px;">
            Cambiar foto:<br />
            <input type="file" name="foto_edit" style="width:250px" />
            <select name="foto_id">
              <?php foreach ($djs as $p) { ?>
                <option value="<?php echo $p['id'] ?>"><?php echo $p['nombre'] ?></option>
              <?php } ?>
            </select>
            <input type="submit" name="change_foto" value="Cambiar" style="width:100px" />
          </div>
        <?php } ?>
      </div>

      <form method="post" id="editform">
        <input type="hidden" id="id" name="id" />
        <input type="hidden" id="nombre" name="nombre" />
        <input type="hidden" id="telefono" name="telefono" />
        <input type="hidden" id="email" name="email" />
        <input type="hidden" id="clave" name="clave" />
        <input type="hidden" name="edit" value="1" />
      </form>


  </div>
</div>

<div id="tab2" class="tab-content">
  <div id="leyenda-calendario" style="margin-bottom: 10px;">
    <span style="display:inline-block; width:12px; height:12px; background-color:#28a745; margin-right:5px;"></span>
    <span style="margin-right:15px;">Validado</span>
    <span style="display:inline-block; width:12px; height:12px; background-color:rgb(255, 210, 64); margin-right:5px;"></span>
    <span style="margin-right:15px;">Pendiente</span>
    <span style="display:inline-block; width:12px; height:12px; background-color:rgb(255, 64, 64); margin-right:5px;"></span>
    <span>Denegado</span>
  </div>


  <div id="calendario"></div>

  <div id="modalOverlay"></div>
  <div id="modalDisponibilidad">
    <div id="modalContenido"></div>
  </div>
</div>


<script type="text/javascript">
  function showTab(tabId) {
    var tabs = document.getElementsByClassName('tab-content');
    var buttons = document.getElementsByClassName('tab-button');

    for (var i = 0; i < tabs.length; i++) {
      tabs[i].style.display = 'none';
      buttons[i].classList.remove('active');
    }

    document.getElementById(tabId).style.display = 'block';
    document.getElementById('btn-' + tabId).classList.add('active');

    // 🔧 Si es el calendario, forzar resize para que se muestre bien
    if (tabId === 'tab1' && typeof calendar !== 'undefined') {
      setTimeout(function() {
        calendar.updateSize();
      }, 50);
    }
  }
</script>


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
      events: '<?= base_url() . "admin/calendarioDisp?load=1" ?>',

      eventDidMount: function(info) {
        var innerTextEl = info.el.querySelector('.fc-event-title');
        if (innerTextEl) {
          var validacion = info.event.extendedProps.validacion;
          if (validacion == 1) {
            innerTextEl.style.color = 'orange';
          } else if (validacion == 2) {
            innerTextEl.style.color = 'green';
          } else if (validacion == 3) {
            innerTextEl.style.color = 'red';
          }
        }
      },

      dateClick: function(info) {
        var dateStr = info.dateStr;
        var events = calendar.getEvents().filter(function(ev) {
          return ev.startStr.substr(0, 10) === dateStr;
        });
        mostrarListaDisponibilidades(events, dateStr);
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
        let nombre = ev.extendedProps.nombre;

        let bgColor = '';
        if (ev.extendedProps.validacion == '3') {
          bgColor = 'background-color: #ff6e4f; color: white;';
        } else if (ev.extendedProps.validacion == '2') {
          bgColor = 'background-color: #51a25f; color: white;';
        } else if (ev.extendedProps.validacion == '1') {
          bgColor = 'background-color:rgb(255, 180, 67); color: white;';
        }

        html += `<li style="font-size:15px; margin-bottom:10px; ${bgColor}">
                DJ ${nombre} de ${start} a ${end}
                        <button class="aceptar" data-id="${ev.id}">✔</button>
                        <button class="denegar" data-id="${ev.id}">✖</button>
                     </li>`;
      });
      html += '</ul>';
      html += `<div style="text-align:center;">
                    <button id="btnCanc" onclick="hideModal()">Cerrar</button>
                 </div>`;
      $('#modalContenido').html(html);
      showModal();

      $('.aceptar').off().on('click', function() {
        let id = $(this).data('id');
        if (confirm("¿Estás seguro que quieres aceptar esta disponibilidad?")) {
          $.post('<?= base_url() . "admin/calendarioDisp" ?>', {
            id: id,
            validacion: 2 // 2 = aceptado
          }, function(response) {
            calendar.refetchEvents();
            hideModal();
          });
        }
      });

      $('.denegar').off().on('click', function() {
        let id = $(this).data('id');
        if (confirm("¿Estás seguro que quieres denegar esta disponibilidad?")) {
          $.post('<?= base_url() . "admin/calendarioDisp" ?>', {
            id: id,
            validacion: 3 // 3 = denegado
          }, function(response) {
            calendar.refetchEvents();
            hideModal();
          });
        }
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