<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Asignar componente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?= base_url() ?>img/favicon.png">
    <link href="<?= base_url() ?>css/style.css" rel="stylesheet" type="text/css" />
    <script src="<?= base_url() ?>js/jquery/js/jquery-1.7.2.min.js"></script>
    <style>
        * { box-sizing: border-box; }

        body {
            font-family: sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 24px;
            margin: auto;
            max-width: 500px;
        }

        h2 {
            text-align: center;
            margin-top: 0;
            font-size: 24px;
            color: #333;
        }

        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        select,
        button {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        button {
            cursor: pointer;
        }

        .success {
            background: #e6ffe6;
            border: 1px solid #b6ffb6;
            color: green;
            padding: 12px;
            margin-top: 15px;
            text-align: center;
            border-radius: 6px;
        }

        .error {
            color: red;
            background: #ffeaea;
            padding: 12px;
            border: 1px solid #ffbbbb;
            margin-top: 15px;
            text-align: center;
            border-radius: 6px;
        }

        .acciones {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .card {
                padding: 20px;
            }

            label, input, select, button {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>

<?php if (!$logueado): ?>
    <div class="card">
        <h2><img src="<?= base_url() ?>img/logo_intranet.png" alt="Logo" style="max-width: 100%; height: auto;"></h2>
        <form method="post">
            <fieldset style="border: none; padding: 0;">
                <h2>Login Administrador</h2>

                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario" required>

                <label for="clave">Contraseña:</label>
                <input type="password" name="clave" required>

                <input type="hidden" name="componente_login" value="1" />
                <button type="submit" style="margin-top: 15px; background: #007bff; color: white;">Entrar &raquo;</button>

                <?php if (!empty($mensaje)): ?>
                    <div class="error"><?= $mensaje ?></div>
                <?php endif; ?>

                <div style="text-align:center; padding-top:8px; font-size:13px; color:#666;">Versión <?= version ?></div>
            </fieldset>
        </form>
    </div>

<?php else: ?>
    <div class="card">
        <h2>Asignar componente</h2>

        <?php if (!empty($mensaje)): ?>
            <div class="success"><?= $mensaje ?></div>
            <script>
                setTimeout(function () {
                    window.location.reload();
                }, 1500);
            </script>
        <?php endif; ?>

        <p><strong>Nº Registro:</strong> <?= $componente['n_registro'] ?></p>
        <p><strong>Nombre:</strong> <?= $componente['nombre_componente'] ?></p>

        <?php if ($equipo_actual): ?>
            <p><strong>Equipo asignado:</strong> <?= $equipo_actual['nombre_grupo'] ?></p>

            <?php if (!empty($componente['fecha_asignacion'])):
                $timestamp = strtotime($componente['fecha_asignacion']);
                $meses = ['01'=>'enero','02'=>'febrero','03'=>'marzo','04'=>'abril','05'=>'mayo','06'=>'junio','07'=>'julio','08'=>'agosto','09'=>'septiembre','10'=>'octubre','11'=>'noviembre','12'=>'diciembre'];
                $dia = date('d', $timestamp);
                $mes = $meses[date('m', $timestamp)];
                $anio = date('Y', $timestamp);
                $hora = date('H:i', $timestamp);
                ?>
                <p><strong>Fecha de asignación:</strong> <?= "$dia de $mes de $anio a las $hora" ?></p>
            <?php endif; ?>

            <button id="btn-cambiar" type="button" onclick="document.getElementById('form-cambio').style.display='block'; this.style.display='none';"
                style="background:#007bff; color:white; margin-top:15px;">Cambiar equipo</button>

            <form method="post" id="form-cambio" style="display:none; margin-top:15px;">
                <label for="id_grupo">Selecciona un equipo</label>
                <select name="id_grupo" id="id_grupo" required>
                    <option value="">-- Selecciona equipo --</option>
                    <?php foreach ($equipos as $eq): ?>
                        <option value="<?= $eq['id_grupo'] ?>"><?= htmlspecialchars($eq['nombre_grupo']) ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="acciones">
                    <button type="submit" style="background:#28a745; color:white;">Confirmar cambio</button>
                    <button type="button" onclick="document.getElementById('form-cambio').style.display='none'; document.getElementById('btn-cambiar').style.display='inline-block';" style="width: 20%;background:#ccc;">
                        <img src="<?= base_url() ?>img/delete.gif" alt="Cancelar" style="width: 20px; height: 20px;">
                    </button>
                </div>
            </form>

            <form method="post" style="margin-top:15px;" onsubmit="return confirm('¿Seguro que deseas eliminar esta asociación?')">
                <input type="hidden" name="eliminar_asociacion" value="1" />
                <button type="submit" style="background:#dc3545; color:white;">Eliminar asociación</button>
            </form>

        <?php else: ?>
            <p><em>Este componente no está asignado a ningún equipo.</em></p>
            <form method="post" style="margin-top:15px;">
                <label for="id_grupo">Selecciona un equipo</label>
                <select name="id_grupo" id="id_grupo" required>
                    <option value="">-- Selecciona equipo --</option>
                    <?php foreach ($equipos as $eq): ?>
                        <option value="<?= $eq['id_grupo'] ?>"><?= htmlspecialchars($eq['nombre_grupo']) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" style="margin-top:10px; background:#28a745; color:white;">Asignar componente</button>
            </form>
        <?php endif; ?>
    </div>
<?php endif; ?>

</body>
</html>
