<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>">

<div class="page-content" style="display: flex; flex-direction:column; max-width:95%; margin:auto; background:#fff; border-radius:20px; padding:0px 10px; box-shadow:0 4px 20px rgba(0,0,0,0.1); margin-top: 60px; margin-bottom: 30px;font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
<div style="display:flex; align-items:center; gap:15px; font-size:18px; font-weight:600; color:#333; margin-left:20px; padding:20px; position:relative;">
    <div style="display:flex; position:relative; width:120px; height:40px;">
        <img src="<?php echo $foto_cliente; ?>" style="width:40px; height:40px; border-radius:50%; object-fit:cover; border:2px solid white; position:absolute; left:0; top:0; box-shadow:0 2px 6px rgba(0,0,0,0.2); z-index:3;">
        <img src="<?php echo $foto_dj; ?>" style="width:40px; height:40px; border-radius:50%; object-fit:cover; border:2px solid white; position:absolute; left:40px; top:0; box-shadow:0 2px 6px rgba(0,0,0,0.2); z-index:2;">
        <img src="<?php echo $foto_coordinador; ?>" style="width:40px; height:40px; border-radius:50%; object-fit:cover; border:2px solid white; position:absolute; left:80px; top:0; box-shadow:0 2px 6px rgba(0,0,0,0.2); z-index:1;">
    </div>
    <div>
        Hablando con <?php echo $nombre_chat; ?>
    </div>
</div>



    <div class="contenedor_chat" style="display:flex; flex-direction:column; justify-content:end; gap:0px; margin:0px auto; padding: 5px 20px; min-height:70vh; margin-bottom: 20px">
        <!-- Contenedor scroll solo para los mensajes -->
        <div id="mensajesScroll" style="max-height: 80vh; overflow-y: auto;padding-right: 5px;">

            <?php if ($mensajes_contacto): ?>
                <?php
                $ultimo_dia = '';
                foreach ($mensajes_contacto as $m):
                    $usuario = $m['usuario'];
                    $es_admin = $usuario === 'administrador';
                    $lado_mensaje = $es_admin ? 'flex-end' : 'flex-start';

                    // Día del mensaje
                    $dia_mensaje = date('d/m/Y', strtotime($m['fecha']));
                    if ($dia_mensaje !== $ultimo_dia):
                        $ultimo_dia = $dia_mensaje;
                ?>
                        <!-- Fecha -->
                        <div style="text-align:center; margin-bottom: 25px;margin-top: 10px; font-size:12px; color:#888;">
                            <?php echo $dia_mensaje; ?>
                        </div>
                    <?php endif;

                    $nombre = '';
                    switch ($usuario) {
                        case 'cliente':
                            $nombre = $m['nombre_completo'];
                            break;
                        case 'dj':
                            $nombre = 'DJ ' . $m['nombre_dj'];
                            break;
                        case 'administrador':
                        default:
                            $nombre = 'Coordinador'; // Solo si necesitas mostrarlo en otros contextos
                            break;
                    }


                    switch ($usuario) {
                        case 'cliente':
                            $bg_color = '#dcf8c6';
                            $text_color = '#1c1c1c';
                            $border = 'none';
                            break;
                        case 'dj':
                            $bg_color = '#e6ccff';
                            $text_color = '#6a1b9a';
                            $border = '1px solid #d1b3ff';
                            break;
                        case 'administrador':
                        default:
                            $bg_color = '#d2e3ff';
                            $text_color = '#0b5394';
                            $border = '1px solid #b0c4de';
                            break;
                    }

                    $text_align = $es_admin ? 'right' : 'left';
                    $align_avatar = $es_admin ? 'margin-left:10px;' : 'margin-right:10px;';
                    $piquito_align = $es_admin ? 'right:-6px; border-left-color:' . $bg_color . ';' : 'left:-6px; border-right-color:' . $bg_color . ';';

                    // Ruta imagen (solo si no es cliente)
                    if ($usuario == 'dj') {
                        $avatar_url = base_url() . "uploads/djs/" . $m['foto'];
                    } elseif ($usuario == 'administrador') {
                        $avatar_url = base_url() . "img/logo.jpg";
                    } elseif ($usuario == 'cliente') {
                        $avatar_url = base_url() . "uploads/foto_perfil/" . $m['foto'];
                    }
                    ?>
                    <div style="display:flex; justify-content:<?php echo $lado_mensaje; ?>; align-items:flex-start;">
                        <?php if (!$es_admin): ?>
                            <img src="<?php echo $avatar_url; ?>" style="width:32px; height:32px; border-radius:50%; object-fit:cover; <?php echo $align_avatar; ?> margin-top: 4px;">
                        <?php endif; ?>

                        <div style="position:relative; max-width:67%; margin-<?php echo $es_admin ? 'right' : 'left'; ?>: 6px; margin-bottom:20px">
                            <div style="position: relative;padding: 12px 18px 20px 18px; border-radius: 18px;background-color: <?php echo $bg_color; ?>;color: <?php echo $text_color; ?>;border: 1px solid <?php echo $bg_color; ?>;font-size: 15px;line-height: 1.4;box-shadow: 0 2px 4px rgba(0,0,0,0.1);text-align: <?php echo $text_align; ?>;min-width: 100px;">
                                <div style="position: absolute;top: 10px;<?php if ($es_admin): ?>right: -8px;border-top: 10px solid <?php echo $bg_color; ?>;border-right: 10px solid transparent;<?php else: ?>left: -8px;border-top: 10px solid <?php echo $bg_color; ?>;border-left: 10px solid transparent;<?php endif; ?>width: 0;height: 0;"></div>
                                <?php if (!$es_admin): ?>
                                    <strong style="display:block; font-weight:600; margin-bottom:5px;"><?php echo $nombre; ?>:</strong>
                                <?php endif; ?>

                                <p style="margin:0;"><?php echo $m['mensaje']; ?></p>
                                <small style="position:absolute;bottom: 5px;right: 10px;font-size: 12px;color: #888;">
                                    <?php echo date("H:i", strtotime($m['fecha'])); ?>
                                </small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            <?php else: ?>
                <div style="display:flex; justify-content:flex-start;">
                    <div style="max-width:75%; padding:12px 18px; border-radius:18px; background-color:#ffffff; border:1px solid #dfe3e8; font-size:15px; line-height:1.4; color:#333; box-shadow:0 2px 4px rgba(0,0,0,0.1); margin-bottom: 25px">
                        <p><strong style="display:block; font-weight:600;">¡Hola! 👋</strong></p>
                        <p style="margin:0;">Este es el chat donde podrás comunicarte con tu coordinador o DJ. ¡Escríbenos cualquier duda!</p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Formulario fijo abajo -->
            <div style="position: sticky; bottom: 0; background: #f1f1f1; padding-top: 10px; z-index: 10; border-top: 1px solid #ccc">
                <form method="post" enctype="multipart/form-data" class="text-content" style="padding-top: 5px;">
                    <div style="display: flex; align-items: center; gap: 15px; width: 100%;">

                        <!-- Botones B / I -->
                        <div style="display: flex; gap: 10px;">
                            <button id="btnBold" type="button" class="btn-format" onclick="tinymce.activeEditor.execCommand('Bold');"><b>B</b></button>
                            <button id="btnItalic" type="button" class="btn-format" onclick="tinymce.activeEditor.execCommand('Italic');"><em>I</em></button>
                        </div>

                        <!-- Área de texto -->
                        <div style="flex: 1;">
                            <textarea name="mensaje" class="whatsapp-textarea" placeholder="Escribe un mensaje..."></textarea>
                        </div>

                        <!-- Botón enviar -->
                        <button type="submit" class="whatsapp-submit" style="background-color: #25d366;color: white;border: none;border-radius: 50%;width: 44px;height: 44px;font-size: 20px;cursor: pointer;display: flex;align-items: center;justify-content: center;box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);">
                            ➤
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sección Info -->
        <div class="chat" style="margin-top:5px; display:flex; flex-direction:column; align-items:center; margin-bottom: 10px;">
            <div id="infoTop" style="display:flex; align-items:center; gap:5px; background: none; padding: 0;">
                <h3 style="margin:0; color:#444;">💬 ¿Cómo funciona el chat? 💬</h3>
                <a id="toggleInfo" class="btn-info" style="color:#007bff; cursor:pointer; text-decoration:underline; font-weight:500;">Más Info</a>
            </div>

            <!-- Sección Info -->
            <div id="infoPopup" style="display: none;position: fixed;top: 50%;left: 50%;transform: translate(-50%, -50%);width: 90%;max-width: 480px;background: white;padding: 20px;border-radius: 16px;box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);z-index: 9999;font-size: 14px;color: #555;transition: opacity 0.3s ease;">
                <h3 style="margin-top: 0; color: #444;">💬 ¿Cómo funciona el chat? 💬</h3>
                <p>Fácil, rápido y sin rodeos. Escribid cualquier duda que tengáis y vuestro coordinador o DJ (si ya está asignado) os responderá lo antes posible.</p>
                <h3>📩 ¿Y cómo sabéis que os hemos contestado?</h3>
                <p>Sencillo: en cuanto le echemos un ojo a vuestro mensaje y os respondamos, recibiréis una notificación en vuestro email.</p>
                <h3>📜 ¿Y qué pasa con la conversación?</h3>
                <p>Tranquilos, queda todo registrado para que nada se pierda y forme parte de la coordinación de vuestro gran día. <br><br>Así que escribid sin miedo. Que aquí estamos para hacer que la música y la fiesta sean perfectas. 🎶✨</p>
                <div style="text-align: right; margin-top: 20px;">
                    <button onclick="toggleInfoPopup()" style="padding: 6px 12px; background: #25d366; color: white; border: none; border-radius: 8px; cursor: pointer;">Cerrar</button>
                </div>
            </div>
            <div id="overlayPopup" style="display: none;position: fixed;top: 0;left: 0;width: 100vw;height: 100vh;background: rgba(0, 0, 0, 0.3);z-index: 9998;"></div>
        </div>
    </div>

    <script>
        function toggleInfoPopup() {
            const popup = document.getElementById("infoPopup");
            const overlay = document.getElementById("overlayPopup");

            const visible = popup.style.display === "block";
            popup.style.display = visible ? "none" : "block";
            overlay.style.display = visible ? "none" : "block";
        }

        // Cerrar al hacer clic fuera
        document.getElementById("overlayPopup").addEventListener("click", toggleInfoPopup);

        // Evento botón "Más Info"
        document.getElementById("toggleInfo").addEventListener("click", toggleInfoPopup);


        document.addEventListener("DOMContentLoaded", function() {
            const mensajesScroll = document.getElementById('mensajesScroll');
            if (mensajesScroll) {
                mensajesScroll.scrollTop = mensajesScroll.scrollHeight;
            }
        });
    </script>

    <script src="<?php echo base_url() . "js/tinymce/tinymce.min.js" ?>"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            tinymce.init({
                selector: 'textarea.whatsapp-textarea',
                menubar: false,
                toolbar: false,
                statusbar: false,
                branding: false,
                height: 55, // <- altura deseada del iframe
                resize: false,
                content_style: `
				body {
					line-height: 1 !important;
					font-size: 18px !important;
				}
			`,
                setup: function(editor) {
                    const btnBold = document.getElementById("btnBold");
                    const btnItalic = document.getElementById("btnItalic");

                    editor.on('init', function() {
                        // Ajuste final del contenedor del editor
                        editor.getContainer().style.minHeight = '55px';
                        editor.getContainer().style.height = '55px';
                    });

                    editor.on('NodeChange', function() {
                        btnBold.classList.toggle('activo', editor.formatter.match('bold'));
                        btnItalic.classList.toggle('activo', editor.formatter.match('italic'));
                    });
                }
            });
        });
    </script>

    <style>
        .btn-format {
            padding: 8px 12px;
            width: 40px;
            height: 40px;
            font-size: 16px;
            border-radius: 8px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            cursor: pointer;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            transition: background 0.2s;
        }

        .btn-format.activo {
            background-color: #d0f0d0;
            border-color: #25d366;
        }

        @media (max-width: 768px) {

            .contenedor_chat {
                height: 150vh;
            }
        }
    </style>