<h2>Usuarios Invitados</h2>
<fieldset>
    <legend>Usuarios Invitados</legend>
    <div id="popupInvitado" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:1000;">

        <div style="background:white; width:400px; padding:20px; border-radius:10px; position:absolute; top:50%; left:50%; transform:translate(-50%, -50%);">
            <h3>Crear Cuenta Invitado</h3><br>

            <form method="post" action="">
                <p><label>Usuario:</label><br>
                    <input type="text" name="nuevo_username" required />
                </p>
                <p><label>Contraseña:</label><br>
                    <input type="text" name="nuevo_clave" required />
                </p>
                <p><label>Email:</label><br>
                    <input type="email" name="nuevo_email" required />
                </p>
                <p><label>Fecha de expiración:</label><br>
                    <input type="date" name="nuevo_expiracion" />
                </p>
                <?php
                $msg_invitado = $this->session->flashdata('msg_invitado');
                if (!empty($msg_invitado)) {
                    echo '<div style="color:red; font-weight:bold; margin-bottom:10px; text-align:center;">' . $msg_invitado . '</div>';
                }
                ?>
                <p style="text-align:center">
                    <input type="submit" name="crear_invitado" value="Crear Invitado" />
                </p>
            </form>

            <?php if (!empty($msg_invitado)): ?>
                <script type="text/javascript">
                    window.onload = function() {
                        document.getElementById('popupInvitado').style.display = 'block';
                    };
                </script>
            <?php endif; ?>


            <a onclick="cerrarPopupInvitado()" style="position:absolute; top:10px; right:15px; cursor:pointer; font-size:16px; color:#999">✖</a>
        </div>
    </div>

    <script type="text/javascript">
        function abrirPopupInvitado() {
            document.getElementById('popupInvitado').style.display = 'block';
        }

        function cerrarPopupInvitado() {
            document.getElementById('popupInvitado').style.display = 'none';
        }
    </script>

    <p style="text-align:right;"><a style="text-decoration:underline; cursor:pointer;" onclick="abrirPopupInvitado()">Crear Cuenta Invitado</a></p>

    <p style="font-style:italic; color: gray">Listado de invitados creados por los clientes. Puedes Desactivarlos o eliminarlos.</p>
    <form method="get" style="margin-bottom: 20px; display: flex; gap: 10px; align-items: center;">
        <label for="filtro_campo">Buscar por:</label>
        <select name="filtro_campo" id="filtro_campo">
            <option value="cliente" <?= (isset($_GET['filtro_campo']) && $_GET['filtro_campo'] == 'cliente') ? 'selected' : '' ?>>Nombre Cliente</option>
            <option value="usuario" <?= (isset($_GET['filtro_campo']) && $_GET['filtro_campo'] == 'usuario') ? 'selected' : '' ?>>Usuario Invitado</option>
            <option value="email" <?= (isset($_GET['filtro_campo']) && $_GET['filtro_campo'] == 'email') ? 'selected' : '' ?>>Email Invitado</option>
            <option value="fecha" <?= (isset($_GET['filtro_campo']) && $_GET['filtro_campo'] == 'fecha') ? 'selected' : '' ?>>Fecha creación (dd/mm/yyyy)</option>
        </select>

        <input type="text" name="filtro_valor" placeholder="Buscar..." value="<?= isset($_GET['filtro_valor']) ? htmlspecialchars($_GET['filtro_valor']) : '' ?>" />

        <label>
            <input type="checkbox" name="solo_activos" value="1" <?= isset($_GET['solo_activos']) ? 'checked' : '' ?> />
            Solo Activos
        </label>

        <button type="submit">Filtrar</button>
    </form>

    <table class="tabledata">
        <tr>
            <th>Cliente</th>
            <th>Usuario</th>
            <th>Email</th>
            <th>Clave</th>
            <th>Fecha creación</th>
            <th>Expira</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($invitados as $inv): ?>
            <?php
            $clave_encriptada = $inv['clave'];
            $clave_plana = $this->encrypt->decode($clave_encriptada);
            $nombre_cliente = $inv['nombre_novio'] . " y " . $inv['nombre_novia'];
            ?>
            <tr>
                <td><?php echo $nombre_cliente; ?></td>
                <td><span class="edit_box" id="username_<?php echo $inv['id']; ?>"><?php echo htmlspecialchars($inv['username']); ?></span></td>
                <td><span class="edit_box" id="email_<?php echo $inv['id']; ?>"><?php echo htmlspecialchars($inv['email']); ?></span></td>
                <td><span class="edit_box" id="clave_<?php echo $inv['id']; ?>"><?php echo htmlspecialchars($clave_plana); ?></span></td>
                <td><?php echo date('d/m/Y', strtotime($inv['fecha_creacion'])); ?></td>
                <td>
                    <span class="edit_box" id="expira_<?php echo $inv['id']; ?>">
                        <?php echo $inv['fecha_expiracion'] ? date('d/m/Y', strtotime($inv['fecha_expiracion'])) : 'Sin fecha'; ?>
                    </span>
                </td>
                <td>
                    <?php echo ($inv['valido']) ? '<span style="color:green">Activo</span>' : '<span style="color:red">Inactivo</span>'; ?>
                </td>
                <td>
                    <?php
                    $expirada = false;
                    if (!empty($inv['fecha_expiracion'])) {
                        $expirada = strtotime($inv['fecha_expiracion']) < strtotime(date('Y-m-d'));
                    }
                    ?>

                    <?php if ($expirada): ?>
                        <span style="color:gray;">Expirado</span>
                    <?php else: ?>
                        <a href="<?php echo base_url() . 'cliente/accion/' . ($inv['valido'] ? 'desactivar' : 'activar') . '/' . $inv['id']; ?>">
                            <?php echo $inv['valido'] ? 'Desactivar' : 'Activar'; ?>
                        </a>
                    <?php endif; ?>
                    |
                    <a href="<?php echo base_url() . 'cliente/eliminar_invitado/' . $inv['id']; ?>" onclick="return confirm('¿Eliminar este invitado?')">
                        Eliminar
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php if (empty($invitados)) echo "<p style='text-align:center; color:gray;'>No hay invitados creados aún.</p>"; ?>

</fieldset>

<!-- Estilos y scripts para jQuery UI datepicker -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery/development-bundle/ui/jquery.jeditable.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).ajaxError(function(event, jqxhr, settings, thrownError) {
            if (settings.url.indexOf("updateinvitado") !== -1) {
                if (jqxhr.status === 409) {
                    alert(jqxhr.responseText);
                } else if (jqxhr.status === 400 || jqxhr.status === 500) {
                    alert("Error: " + jqxhr.responseText);
                } else {
                    alert("Error desconocido al guardar el campo.");
                }

                // Recargar para que se vea todo en estado correcto
                window.location.reload();
            }
        });


        $('.edit_box').each(function() {
            var id = $(this).attr('id');
            var options = {
                type: 'text',
                submit: '<img src="<?php echo base_url() ?>img/save.gif" style="cursor:pointer;" />',
                tooltip: 'Haz clic para editar...',
                indicator: 'Guardando...',
                cssclass: 'editable-form',
                onblur: 'ignore', // no cerrar si se hace clic fuera
                event: 'click',
                onsubmit: function(settings, original) {
                    const input = $('input', this);
                    if (input.val().trim() === '') {
                        alert('El campo no puede estar vacío');
                        return false;
                    }
                },
                submitdata: function(value, settings) {
                    return {
                        id: this.id
                    };
                },
                callback: function(value, settings) {
                    $(this).html(value);

                    // Si es el campo fecha de expiración, actualizar columna de acciones
                    if (this.id.startsWith('expira_')) {
                        const id = this.id.split('_')[1];

                        // Parsear fecha dd/mm/yyyy a objeto Date
                        const parts = value.split('/');
                        const nuevaFecha = new Date(parts[2], parts[1] - 1, parts[0]);
                        const hoy = new Date();
                        hoy.setHours(0, 0, 0, 0);

                        const tdAcciones = $(this).closest('tr').find('td:last');

                        if (nuevaFecha < hoy) {
                            tdAcciones.html('<span style="color:gray;">Expirado</span> | ' +
                                tdAcciones.find('a:contains("Eliminar")')[0].outerHTML);
                        } else {
                            const estaActivo = $(this).closest('tr').find('td:eq(6)').text().trim() === 'Activo';
                            const accion = estaActivo ? 'desactivar' : 'activar';
                            const texto = estaActivo ? 'Desactivar' : 'Activar';
                            const idCliente = this.id.split('_')[1];

                            const baseUrl = '<?php echo base_url(); ?>';
                            const enlaceAccion = `<a href="${baseUrl}cliente/accion/${accion}/${idCliente}">${texto}</a>`;
                            const enlaceEliminar = tdAcciones.find('a:contains("Eliminar")')[0].outerHTML;

                            tdAcciones.html(`${enlaceAccion} | ${enlaceEliminar}`);
                        }
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 409) {
                        alert(xhr.responseText); // Email duplicado
                    } else if (xhr.status === 400 || xhr.status === 500) {
                        alert("Error: " + xhr.responseText);
                    } else {
                        alert("Ocurrió un error inesperado.");
                    }

                    $(this).html(this.revert); // Revertir si falla
                }
            };


            if (id.startsWith('expira_')) {
                options.onedit = function() {
                    setTimeout(function() {
                        $('.editable-form input')
                            .datepicker({
                                dateFormat: 'dd/mm/yy',
                                changeMonth: true,
                                changeYear: true,
                                onSelect: function() {
                                    // enviar automáticamente al seleccionar fecha
                                    $('.editable-form').submit();
                                }
                            })
                            .datepicker("show")
                            .on('keydown', function(e) {
                                if (e.key === 'Enter') {
                                    e.preventDefault();
                                    $('.editable-form').submit();
                                }
                            });
                    }, 100);
                };
            } else {
                options.onedit = function() {
                    setTimeout(function() {
                        $('.editable-form input').on('keydown', function(e) {
                            if (e.key === 'Enter') {
                                e.preventDefault();
                                $('.editable-form').submit();
                            }
                        });
                    }, 100);
                };
            }
            $(this).on('click', function() {
                window.lastEditedElement = this;
                $(this).attr('data-original', $(this).html());
            });

            $(this).editable('<?php echo base_url() ?>index.php/ajax/updateinvitado', options);
        });
    });
</script>