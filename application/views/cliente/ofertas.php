<h2>Ofertas Destacadas</h2>

<style>
    ul.ofertas {
        display: flex;
        flex-wrap: wrap;
        list-style: none;
        padding: 0;
        gap: 20px;
        justify-content: center;
    }

    ul.ofertas li {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 12px;

        width: 320px;
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 12px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        position: relative;
    }

    ul.ofertas li:hover {
        transform: scale(1.02);
        transition: transform 0.2s ease-in-out;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    .img-wrapper {
        width: 90px;
        height: 90px;
        border-radius: 10px;
        overflow: hidden;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        background-color: #fff;
    }

    .servicio-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .contenido-servicio {
        display: flex;
        flex-direction: column;
        justify-content: center;
        flex: 1;
    }

    .nombre-servicio {
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 6px;
        color: #333;
        width: 90%;
    }

    .precio-original {
        font-size: 18px;
        color: red;
        text-decoration: line-through;
        text-align: left;
    }

    .precio-final {
        font-size: 18px;
        font-weight: bold;
        color: #222;
        text-align: left;
    }

    .oferta-label {
        position: absolute;
        top: -10px;
        left: -10px;
        background: red;
        color: #fff;
        font-weight: bold;
        font-size: 13px;
        padding: 6px 12px;
        border-radius: 10px 0 10px 0;
        z-index: 10;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-family: 'Arial Black', sans-serif;
    }

    .checkbox-container {
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .checkbox-container input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .carrito {
        margin-top: 30px;
        font-weight: bold;
        font-size: 16px;
    }

    .carrito input[type="submit"] {
        margin-left: 20px;
        padding: 6px 14px;
        font-weight: bold;
        background-color: #93ce37;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        color: white;
        font-size: 15px;
    }

    .carrito input[type="submit"]:hover {
        background-color: #7db92e;
    }
</style>

<script type="text/javascript">
    function updateCardStyle(checkbox) {
        const card = checkbox.closest("li"); // Asegúrate de que es el <li> de la tarjeta

        if (!card) return;

        if (checkbox.checked) {
            card.style.backgroundColor = "#f0fbe3"; // fondo verde claro
            card.style.borderColor = "#93ce37"; // borde verde principal
            card.style.borderWidth = "2px";
            card.style.borderStyle = "solid";
            card.style.boxShadow = "4px 7px 10px rgba(147, 206, 55, 0.5)";
            card.classList.add("active-card");


        } else {
            card.style.backgroundColor = "#fff";
            card.style.borderColor = "#ddd";
            card.style.boxShadow = "0 0 4px rgba(0, 0, 0, 0.1)";
            card.classList.remove("active-card");
        }
    }

    // Al cargar la página
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".servicio").forEach(function(checkbox) {
            updateCardStyle(checkbox);
            checkbox.addEventListener("change", function() {
                updateCardStyle(this);

                // Recalcular el total al marcar/desmarcar
                let total = 0;
                document.querySelectorAll(".servicio:checked").forEach(function(c) {
                    total += parseInt(c.getAttribute("alt"));
                });
                document.getElementById("total").innerHTML = total + " €";
            });
        });
    });

    function confirmar() {
        return confirm("¿Seguro que deseas añadir el servicio a los servicios ya contratados?\nEl servicio se añadirá a los pagos pendientes.");
    }
</script>


<div class="main">
    <fieldset>
        <legend>Servicios disponibles</legend>
        <form method="post" onsubmit="return confirmar()">
            <ul class="ofertas">
                <?php
                if (!empty($servicios)) {
                    $hay_ofertas = false;

                    foreach ($servicios as $s) {
                        if (!isset($s['mostrar']) || $s['mostrar'] != 1) continue;

                        $hay_ofertas = true;
                        $is_oferta = (!empty($s['precio_oferta']) && $s['precio_oferta'] != 0);
                        $imagen = !empty($s['imagen']) ? $s['imagen'] : 'servicio_default.png';
                ?>
                        <li>
                            <?php if ($is_oferta): ?>
                                <div class="oferta-label">OFERTA</div>
                            <?php endif; ?>

                            <div class="checkbox-container">
                                <input class="servicio" type="checkbox"
                                    value="<?php echo htmlspecialchars($s['id']); ?>"
                                    alt="<?php echo htmlspecialchars($is_oferta ? $s['precio_oferta'] : $s['precio']); ?>"
                                    id="s_<?php echo htmlspecialchars($s['id']); ?>"
                                    name="servicios[]" />
                            </div>

                            <div class="img-wrapper">
                                <img src="<?php echo base_url() . 'uploads/servicios/' . $imagen; ?>" alt="Servicio" class="servicio-img" />
                            </div>

                            <div class="contenido-servicio">
                                <div class="nombre-servicio">
                                    <?php echo htmlspecialchars($s['nombre']); ?>
                                </div>

                                <?php if ($is_oferta): ?>
                                    <div style="display: flex; gap: 4px;">
                                        <div class=" precio-original">
                                            <?php echo htmlspecialchars($s['precio']); ?> €
                                        </div>
                                        <div class="precio-final">
                                            <?php echo htmlspecialchars($s['precio_oferta']); ?> €
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="precio-final">
                                        <?php echo htmlspecialchars($s['precio']); ?> €
                                    </div>
                                <?php endif; ?>
                            </div>
                        </li>
                <?php
                    }

                    if (!$hay_ofertas) {
                        echo "<p>No hay ofertas disponibles en este momento.</p>";
                    }
                } else {
                    echo "<p>No hay ofertas disponibles en este momento.</p>";
                }
                ?>
            </ul>

            <div class="carrito">
                <span id="tota_titulo">Total Servicios Añadidos:</span>
                <span id="total">0</span>
                <input type="submit" name="submit" value="Añadir" />
            </div>

            <div style="clear:both; text-align:center">
                <?php if (isset($msg)) echo '<p style="padding:5px">' . htmlspecialchars($msg) . '</p>'; ?>
            </div>
        </form>
    </fieldset>
</div>

<div class="clear"></div>