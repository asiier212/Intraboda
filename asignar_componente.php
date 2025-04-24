<?php
session_start();

if (isset($_GET['check_login']) && $_GET['check_login'] == '1') {
    echo isset($_SESSION['login_asignar_componente']) && $_SESSION['login_asignar_componente'] ? '1' : '0';
    exit;
}

$mensaje = null;

// Conexión base de datos
$mysqli = new mysqli("db536033527.db.1and1.com", "dbo536033527", "Deejay2012", "db536033527");
$mysqli->set_charset("utf8");

if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

function base_url($path = '')
{
    return rtrim((isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']), '/') . '/' . $path;
}

function insertar_reparacion($id_componente, $descripcion)
{
    global $mysqli;
    $stmt = $mysqli->prepare("INSERT INTO reparaciones_componentes (id_componente, reparacion, fecha_reparacion) VALUES (?, ?, NOW())");
    $stmt->bind_param("is", $id_componente, $descripcion);
    return $stmt->execute();
}
function modificar_componente($id_componente, $n_registro, $nombre, $descripcion, $urls_json)
{
    global $mysqli;
    $stmt = $mysqli->prepare("UPDATE componentes SET n_registro = ?, nombre_componente = ?, descripcion_componente = ?, urls = ? WHERE id_componente = ?");
    $stmt->bind_param("ssssi", $n_registro, $nombre, $descripcion, $urls_json, $id_componente);
    return $stmt->execute();
}




function get_componente($id)
{
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT * FROM componentes WHERE id_componente = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function get_equipos()
{
    global $mysqli;
    $result = $mysqli->query("SELECT * FROM grupos_equipos WHERE borrado = 0 ORDER BY nombre_grupo ASC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function get_equipo_nombre($id_grupo)
{
    global $mysqli;
    $stmt = $mysqli->prepare("SELECT * FROM grupos_equipos WHERE id_grupo = ?");
    $stmt->bind_param("i", $id_grupo);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function asignar_componente($id_componente, $id_grupo)
{
    global $mysqli;

    // Primero desasociar el grupo anterior si existe (cerrar historial previo)
    $stmt = $mysqli->prepare("UPDATE historial_componentes_grupos SET fecha_desasignacion = NOW() WHERE id_componente = ? AND fecha_desasignacion IS NULL");
    $stmt->bind_param("i", $id_componente);
    $stmt->execute();

    // Actualizar la tabla componentes (estado actual)
    $stmt = $mysqli->prepare("UPDATE componentes SET id_grupo = ? WHERE id_componente = ?");
    $stmt->bind_param("ii", $id_grupo, $id_componente);
    $stmt->execute();

    // Insertar nuevo registro de historial
    $stmt = $mysqli->prepare("INSERT INTO historial_componentes_grupos (id_componente, id_grupo, fecha_asignacion) VALUES (?, ?, NOW())");
    $stmt->bind_param("ii", $id_componente, $id_grupo);
    return $stmt->execute();
}


function eliminar_asociacion($id_componente)
{
    global $mysqli;

    // Desvincular en tabla principal
    $stmt = $mysqli->prepare("UPDATE componentes SET id_grupo = NULL WHERE id_componente = ?");
    $stmt->bind_param("i", $id_componente);
    $stmt->execute();

    // Cerrar último historial si existe
    $stmt = $mysqli->prepare("UPDATE historial_componentes_grupos SET fecha_desasignacion = NOW() WHERE id_componente = ? AND fecha_desasignacion IS NULL");
    $stmt->bind_param("i", $id_componente);
    return $stmt->execute();
}


function formatear_fecha($fecha)
{
    $meses = ['01' => 'enero', '02' => 'febrero', '03' => 'marzo', '04' => 'abril', '05' => 'mayo', '06' => 'junio', '07' => 'julio', '08' => 'agosto', '09' => 'septiembre', '10' => 'octubre', '11' => 'noviembre', '12' => 'diciembre'];
    $timestamp = strtotime($fecha);
    return date('d', $timestamp) . " de " . $meses[date('m', $timestamp)] . " de " . date('Y', $timestamp) . " a las " . date('H:i', $timestamp);
}

// Validación de componente
$id_componente = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id_componente) die("❌ Componente no especificado.");

$componente = get_componente($id_componente);
if (!$componente) die("❌ Componente no encontrado.");

$equipos = get_equipos();
$equipo_actual = !empty($componente['id_grupo']) ? get_equipo_nombre($componente['id_grupo']) : null;

// Redirección automática según si tiene equipo asignado o no
if (!isset($_GET['accion'])) {
    if (!empty($componente['id_grupo'])) {
        header("Location: ?id=$id_componente&accion=asignar");
        exit;
    }
}

if (isset($_POST['componente_login'])) {
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
    $clave = isset($_POST['clave']) ? $_POST['clave'] : '';
    $accion_protegida = isset($_POST['accion_protegida']) ? $_POST['accion_protegida'] : '';

    if ($usuario === 'admin' && $clave === '49999327Bdj%ExEv') {
        $_SESSION['login_asignar_componente'] = true;

        // Si viene de AJAX, responder con señal de éxito
        if (!empty($accion_protegida)) {
            echo 'LOGIN_OK_CONTINUE';
            exit;
        }

        // Si no es AJAX, redirigir
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit;
    } else {
        // Si viene de AJAX
        if (!empty($accion_protegida)) {
            echo "❌ Usuario o contraseña incorrectos.";
            exit;
        }

        $mensaje = "❌ Usuario o contraseña incorrectos.";
    }
}



if (isset($_SESSION['login_asignar_componente']) && $_SESSION['login_asignar_componente']) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['id_grupo'])) {
            $id_grupo = (int)$_POST['id_grupo'];
            $ok = asignar_componente($id_componente, $id_grupo);
            $mensaje = $ok ? "✅ Componente asignado correctamente." : "❌ Error al asignar.";
        }
        if (isset($_POST['eliminar_asociacion'])) {
            $ok = eliminar_asociacion($id_componente);
            $mensaje = $ok ? "✅ Asociación eliminada." : "❌ Error al eliminar.";
        }
        if (isset($_POST['anadir_reparacion'])) {
            $descripcion = trim($_POST['descripcion_reparacion']);
            if (!empty($descripcion)) {
                $ok = insertar_reparacion($id_componente, $descripcion);
                $_SESSION['mensaje'] = $ok ? "✅ Reparación añadida correctamente." : "❌ Error al guardar la reparación.";
            } else {
                $_SESSION['mensaje'] = "❌ La descripción de reparación está vacía.";
            }

            echo "<script>window.location.href = '" . $_SERVER['REQUEST_URI'] . "';</script>";
            exit;
        }
        if (isset($_POST['editar_n_registro'], $_POST['editar_nombre_componente'], $_POST['editar_descripcion_componente'])) {
            $n_registro = trim($_POST['editar_n_registro']);
            $nombre = trim($_POST['editar_nombre_componente']);
            $descripcion = trim($_POST['editar_descripcion_componente']);
            $urls_array = isset($_POST['urls']) && is_array($_POST['urls']) ? array_filter($_POST['urls']) : [];
            $urls_json = json_encode(array_values($urls_array));


            if ($n_registro && $nombre && $descripcion) {
                $ok = modificar_componente($id_componente, $n_registro, $nombre, $descripcion, $urls_json);
                $_SESSION['mensaje'] = $ok ? "✅ Componente modificado correctamente." : "❌ Error al modificar el componente.";
            } else {
                $_SESSION['mensaje'] = "❌ Todos los campos son obligatorios.";
            }

            echo "<script>window.location.href = '" . $_SERVER['REQUEST_URI'] . "';</script>";
            exit;
        }



        echo "<script>window.location.href = '" . $_SERVER['REQUEST_URI'] . "';</script>";
        exit;
    }
}

$logueado = isset($_SESSION['login_asignar_componente']) && $_SESSION['login_asignar_componente'];


if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Componentes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= base_url('img/favicon.png') ?>">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <script src="<?= base_url('js/jquery/js/jquery-1.7.2.min.js') ?>"></script>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f4f4;
            padding: 20px;
            margin: 0;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 22px;
        }

        label {
            font-weight: bold;
            margin-top: 14px;
            display: block;
        }

        input,
        select,
        textarea,
        button {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 15px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
        }

        button {
            cursor: pointer;
            font-weight: bold;
        }

        .success {
            background: #e6ffe6;
            border: 1px solid #b6ffb6;
            color: green;
            padding: 12px;
            border-radius: 6px;
            margin-top: 15px;
            text-align: center;
        }

        .error {
            background: #ffeaea;
            border: 1px solid #ffbbbb;
            color: red;
            padding: 12px;
            border-radius: 6px;
            margin-top: 15px;
            text-align: center;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-green {
            background: #28a745;
            color: white;
        }

        .btn-yellow {
            background: #ffc107;
            color: black;
        }

        .btn-orange {
            background: #fd7e14;
            color: white;
        }

        .acciones {
            display: flex;
            gap: 10px;
            margin-top: 12px;
            justify-content: space-between;
        }

        .acciones button {
            flex: 1;
        }

        @media (max-width: 480px) {
            .card {
                padding: 16px;
            }

            h2 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>

    <script>
        var eliminarYaConfirmado = false;

        function confirmarYLogin(accion, formId) {
            if (!eliminarYaConfirmado) {
                if (!confirm('¿Seguro que deseas eliminar esta asociación?')) return;
                eliminarYaConfirmado = true;
            }
            solicitarLogin(accion, formId);
        }

        function solicitarLogin(accion, formId) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '?check_login=1', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    if (xhr.responseText == '1') {
                        var form = document.getElementById(formId);
                        if (form) {
                            eliminarYaConfirmado = false; // <- reseteamos aquí
                            form.submit();
                        }
                    } else {
                        document.getElementById('accion_protegida').value = accion;
                        document.getElementById('form_target_id').value = formId;
                        document.getElementById('loginModal').style.display = 'flex';
                    }
                }
            };
            xhr.send(null);
        }


        // Enviar login y continuar con acción si es correcto
        window.onload = function() {
            document.getElementById('loginProtectedForm').onsubmit = function(e) {
                e = e || window.event;
                if (e.preventDefault) e.preventDefault();

                var xhr = new XMLHttpRequest();
                xhr.open('POST', '', true);

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4) {
                        var res = xhr.responseText;

                        // Si respuesta contiene la señal de éxito
                        if (res.indexOf('LOGIN_OK_CONTINUE') !== -1) {
                            document.getElementById('loginModal').style.display = 'none';
                            var targetFormId = document.getElementById('form_target_id').value;
                            var targetForm = document.getElementById(targetFormId);
                            if (targetForm) {
                                targetForm.submit();
                            }
                        } else {
                            // Mostrar error
                            document.getElementById('login_error').style.display = 'block';
                            document.getElementById('login_error').innerHTML = res;
                        }
                    }
                };

                var form = document.getElementById('loginProtectedForm');
                var formData = [];
                for (var i = 0; i < form.elements.length; i++) {
                    var el = form.elements[i];
                    if (!el.name) continue;
                    formData.push(encodeURIComponent(el.name) + '=' + encodeURIComponent(el.value));
                }

                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send(formData.join('&'));
                return false;
            };
        };
    </script>



    <div id="loginModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:9999; justify-content:center; align-items:center;">
        <div class="card" style="max-width:400px;">
            <form method="post" id="loginProtectedForm">
                <h2>🔒 Login requerido</h2>
                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario" required>
                <label for="clave">Contraseña:</label>
                <input type="password" name="clave" required>
                <input type="hidden" name="componente_login" value="1" />
                <input type="hidden" name="accion_protegida" id="accion_protegida" value="" />
                <input type="hidden" name="form_target_id" id="form_target_id" value="" />
                <div id="login_error" class="error" style="display:none; margin-top:10px;"></div>
                <button type="submit" class="btn-green" style="margin-top: 15px;">Entrar &raquo;</button>
            </form>
        </div>
    </div>



    <?php if (!isset($_GET['accion'])): ?>
        <div class="card">
            <h2>Gestión del Componente<?php echo " " . $componente['nombre_componente'] ?></h2>
            <p><strong>Nº Registro:</strong> <?= $componente['n_registro'] ?></p>
            <p><strong>Nombre:</strong> <?= $componente['nombre_componente'] ?></p>
            <p><strong>Descripción:</strong> <?= $componente['descripcion_componente'] ?></p>
            <?php
            $urls = json_decode($componente['urls'], true);

            if (!empty($urls) && is_array($urls)):
            ?>
                <div style="margin-top: 12px;">
                    <strong>Enlaces relacionados:</strong>
                    <ul>
                        <?php foreach ($urls as $url): ?>
                            <li><a href="<?= htmlspecialchars($url) ?>" target="_blank"><?= htmlspecialchars($url) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="btn-group">
                <a href="?id=<?= $id_componente ?>&accion=asignar"><button class="btn-green">Asignar Componente</button></a>
                <a href="?id=<?= $id_componente ?>&accion=modificar"><button class="btn-yellow">Modificar Componente</button></a>
                <a href="?id=<?= $id_componente ?>&accion=reparacion"><button class="btn-orange">Añadir Reparación</button></a>
            </div>
        </div>

    <?php elseif ($_GET['accion'] === 'asignar'): ?>
        <div class="card">
            <h2>Gestionar componente</h2>
            <p><strong>Nº Registro:</strong> <?= $componente['n_registro'] ?></p>
            <p><strong>Nombre:</strong> <?= $componente['nombre_componente'] ?></p>
            <p><strong>Descripción:</strong> <?= $componente['descripcion_componente'] ?></p>
                <?php
                $urls = json_decode($componente['urls'], true);

                if (!empty($urls) && is_array($urls)):
                ?>
                    <p style="margin-top: 12px;">
                    <ul>
                        <strong>Enlaces relacionados:</strong>
                        <?php foreach ($urls as $url): ?>
                            <li><a href="<?= htmlspecialchars($url) ?>" target="_blank"><?= htmlspecialchars($url) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    </p>
                <?php endif; ?>

            <?php if ($equipo_actual): ?>
                <p><strong>Equipo asignado:</strong> <?= $equipo_actual['nombre_grupo'] ?></p>
                <?php
                // Obtener la última asignación activa desde el historial
                $stmt = $mysqli->prepare("SELECT fecha_asignacion FROM historial_componentes_grupos WHERE id_componente = ? AND fecha_desasignacion IS NULL ORDER BY fecha_asignacion DESC LIMIT 1");
                $stmt->bind_param("i", $componente['id_componente']);
                $stmt->execute();
                $stmt->bind_result($fecha_asignacion_actual);
                $stmt->fetch();
                $stmt->close();

                if (!empty($fecha_asignacion_actual)):
                ?>
                    <p><strong>Fecha de asignación:</strong> <?= formatear_fecha($fecha_asignacion_actual) ?></p>
                <?php endif; ?>

            <?php else: ?>
                <p style="color: red"><em>Este componente no está asignado a ningún equipo.</em></p>
            <?php endif; ?>
            <form method="post" id="asignarForm">
                <label for="id_grupo">Selecciona un equipo</label>
                <select name="id_grupo" required>
                    <option value="">-- Selecciona equipo --</option>
                    <?php foreach ($equipos as $eq): ?>
                        <option value="<?= $eq['id_grupo'] ?>"><?= htmlspecialchars($eq['nombre_grupo']) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="button" onclick="solicitarLogin('asignar','asignarForm')" class="btn-green">Asignar Componente</button>
            </form>

            <?php if ($equipo_actual): ?>
                <form method="post" onsubmit="return false;" id="eliminarForm">
                    <input type="hidden" name="eliminar_asociacion" value="1" />
                    <button type="button" style="background:#dc3545; color:white; margin-top:10px;" onclick="confirmarYLogin('eliminar','eliminarForm')">Eliminar asociación</button>
                </form>

            <?php endif; ?>
            <?php if (empty($componente['id_grupo'])): ?>
                <a href="?id=<?= $id_componente ?>" style="display:block; text-align:center; margin-top:15px; color:#007bff; font-weight:bold; font-size: 16px">⬅️ Volver al menú</a>
            <?php endif; ?>
        </div>

    <?php elseif ($_GET['accion'] === 'modificar'): ?>
        <div class="card">
            <h2>Modificar Componente</h2>

            <?php if ($mensaje): ?>
                <div class="<?= strpos($mensaje, '✅') === 0 ? 'success' : 'error' ?>">
                    <?= $mensaje ?>
                </div>
            <?php endif; ?>


            <form method="post" id="modificarForm">
                <label>Nº Registro:</label>
                <input type="text" value="<?= $componente['n_registro'] ?>" name="editar_n_registro" required>
                <label>Nombre:</label>
                <input type="text" value="<?= $componente['nombre_componente'] ?>" name="editar_nombre_componente" required>
                <label>Descripción:</label>
                <textarea name="editar_descripcion_componente" rows="4" required><?= $componente['descripcion_componente'] ?></textarea>
                <?php
                $urls = json_decode($componente['urls'], true);

                if (!empty($urls) && is_array($urls)):
                ?>
                    <div id="url-list" style="margin-top: 12px;">
                        <strong>Enlaces relacionados:</strong>
                        <?php foreach ($urls as $url): ?>
                            <span style="display:flex; gap:2%;">
                                <input type="url" name="urls[]" value="<?= htmlspecialchars($url) ?>" style="width: 90%; padding:8px; border-radius: 6px;" />
                                <button type="button" onclick="this.parentNode.remove()" style="width: 8%; text-align: center;background-color: #ccc; boder: none; boder-radius: 6px; padding: 5px 5px; cursor: pointer;">❌</button>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <button type="button" class="btn-orange" style="margin-top:10px;" onclick="addUrlField()">➕ Añadir URL</button>

                <button class="btn-yellow" type="button" onclick="solicitarLogin('modificar','modificarForm')">Guardar Cambios</button>
            </form>
            <a href="?id=<?= $id_componente ?>" style="display:block; text-align:center; margin-top:15px; color:#007bff; font-weight:bold; font-size: 16px">⬅️ Volver al menú</a>
        </div>

    <?php elseif ($_GET['accion'] === 'reparacion'): ?>
        <div class="card">
            <h2>Añadir Reparación</h2>

            <?php if ($mensaje): ?>
                <div class="<?= strpos($mensaje, '✅') === 0 ? 'success' : 'error' ?>">
                    <?= $mensaje ?>
                </div>
            <?php endif; ?>

            <form style="margin-top: 20px" method="post" id="reparacionForm">
                <p><strong>Nº Registro:</strong> <?= $componente['n_registro'] ?></p>
                <p><strong>Nombre:</strong> <?= $componente['nombre_componente'] ?></p>
                <input type="hidden" name="anadir_reparacion" value="1" />
                <label for="descripcion_reparacion">Descripción Reparación:</label>
                <textarea name="descripcion_reparacion" required rows="5"></textarea>
                <button class="btn-orange" type="button" onclick="solicitarLogin('reparacion','reparacionForm')">Añadir Reparación</button>
            </form>

            <a href="?id=<?= $id_componente ?>" style="display:block; text-align:center; margin-top:15px; color:#007bff; font-weight:bold; font-size: 16px">⬅️ Volver al menú</a>
        </div>
    <?php endif; ?>

    <script>
        function addUrlField() {
            const container = document.getElementById('url-list');
            const div = document.createElement('div');
            div.className = 'url-item';
            div.innerHTML = `
                            <span style="display:flex; gap:2%;">
                                <input type="url" name="urls[]" placeholder="https://ejemplo.com" style="width: 90%; padding:8px; border-radius: 6px;"/>
                                <button type="button" onclick="this.parentNode.remove()" style="width: 8%; text-align: center;background-color: #ccc; boder: none; boder-radius: 6px; padding: 5px 5px; cursor: pointer;">❌</button>
                            </span>
    `;
            container.appendChild(div);
        }
    </script>



</body>

</html>