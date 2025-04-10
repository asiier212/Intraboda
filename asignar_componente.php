<?php
// Configuración de base de datos en IONOS
$host = 'db536033527.db.1and1.com';
$user = 'dbo536033527';
$pass = 'Deejay2012';
$db   = 'db536033527';

$conn = mysql_connect($host, $user, $pass);
mysql_select_db($db, $conn);
mysql_query("SET NAMES 'utf8'");

if (!isset($_GET['componente_id'])) {
    die("Componente no especificado.");
}

$id_componente = (int) $_GET['componente_id'];
$mensaje = '';

// Acciones de formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_grupo'])) {
        $id_grupo = (int) $_POST['id_grupo'];
        $fecha_asignacion = date('Y-m-d H:i:s');
        $sql = "UPDATE componentes SET id_grupo = $id_grupo, fecha_asignacion = '$fecha_asignacion' WHERE id_componente = $id_componente";
        $mensaje = mysql_query($sql) ? "✅ Componente asignado correctamente." : "❌ Error al asignar el componente.";
    }


    if (isset($_POST['eliminar_asociacion'])) {
        $sql = "UPDATE componentes SET id_grupo = NULL WHERE id_componente = $id_componente";
        $mensaje = mysql_query($sql) ? "✅ Asociación eliminada." : "❌ Error al eliminar la asociación.";
    }
}

// Cargar componente
$res_com = mysql_query("SELECT * FROM componentes WHERE id_componente = $id_componente");
$componente = mysql_fetch_assoc($res_com);

// Cargar lista de equipos
$equipos = array();
$res_eq = mysql_query("SELECT * FROM grupos_equipos ORDER BY nombre_grupo ASC");
while ($row = mysql_fetch_assoc($res_eq)) {
    $equipos[] = $row;
}

// Obtener nombre del equipo actual
$equipo_actual = null;
if ($componente['id_grupo'] != '' && $componente['id_grupo'] != null) {
    $res_eq_name = mysql_query("SELECT nombre_grupo FROM grupos_equipos WHERE id_grupo = " . (int)$componente['id_grupo']);
    if ($res_eq_name && mysql_num_rows($res_eq_name) > 0) {
        $equipo_actual = mysql_fetch_assoc($res_eq_name);
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Asignar componente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
            background: #f4f4f4;
        }

        .card {
            max-width: 500px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        select,
        button {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .mensaje {
            margin-top: 15px;
            padding: 10px;
            background: #e6ffe6;
            border: 1px solid #b6ffb6;
            color: green;
            text-align: center;
        }

        .advertencia {
            padding: 10px;
            background: #fff3cd;
            border: 1px solid #ffeeba;
            margin-top: 15px;
            text-align: center;
        }

        .acciones {
            margin-top: 10px;
            text-align: center;
        }

        .acciones form {
            display: inline-block;
            margin-top: 5px;
        }

        .acciones button {
            background-color: #dc3545;
            color: white;
            border: none;
        }
    </style>
</head>

<body>
    <div class="card">
        <h2>Asignar componente</h2>
        <p><strong>Nº Registro:</strong> <?php echo $componente['n_registro']; ?></p>
        <p><strong>Nombre:</strong> <?php echo $componente['nombre_componente']; ?></p>

        <?php if ($mensaje): ?>
            <div class="mensaje"><?php echo $mensaje; ?></div>
        <?php endif; ?>

        <?php if ($equipo_actual): ?>
            <div class="advertencia">
                Este componente ya está asignado al equipo: <strong><?php echo $equipo_actual['nombre_grupo']; ?></strong><br>

                <?php
                if (!empty($componente['fecha_asignacion'])) {
                    // Convertir fecha a formato bonito
                    $timestamp = strtotime($componente['fecha_asignacion']);
                    $meses = array(
                        '01' => 'enero',
                        '02' => 'febrero',
                        '03' => 'marzo',
                        '04' => 'abril',
                        '05' => 'mayo',
                        '06' => 'junio',
                        '07' => 'julio',
                        '08' => 'agosto',
                        '09' => 'septiembre',
                        '10' => 'octubre',
                        '11' => 'noviembre',
                        '12' => 'diciembre'
                    );

                    $dia = date('d', $timestamp);
                    $mes = $meses[date('m', $timestamp)];
                    $anio = date('Y', $timestamp);
                    $hora = date('H:i', $timestamp);

                    echo "Este componente se asignó el <strong>$dia de $mes de $anio</strong> a las <strong>$hora</strong>";
                }
                ?>
            </div>
        <?php else: ?>

            <div class="advertencia">
                Este componente no está asignado a ningún equipo.
            </div>
        <?php endif; ?>

        <!-- Formulario de asignación o cambio -->
        <form method="post">
            <label for="id_grupo">Selecciona un equipo:</label>
            <select name="id_grupo" id="id_grupo" required>
                <option value="">-- Selecciona equipo --</option>
                <?php foreach ($equipos as $eq): ?>
                    <option value="<?php echo $eq['id_grupo']; ?>">
                        <?php echo htmlspecialchars($eq['nombre_grupo']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit"><?php echo $equipo_actual ? 'Cambiar equipo' : 'Asignar componente'; ?></button>
        </form>

        <!-- Opción de eliminar asociación si ya existe -->
        <?php if ($equipo_actual): ?>
            <div class="acciones">
                <form method="post">
                    <input type="hidden" name="eliminar_asociacion" value="1">
                    <button type="submit">Eliminar asociación</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>