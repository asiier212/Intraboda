<h2>Listado de Canciones</h2>

<fieldset class="datos">
    <legend>Momentos Especiales</legend>
    <ul class="momentos" id="l_<?php echo $this->session->userdata('user_id') ?>">
        <?php foreach ($events as $eu): ?>
            <?php if ($eu['nombre'] !== 'Fiesta'): ?>
                <li id="mom_<?php echo $eu['id'] ?>" style="display: flex; justify-content: space-between; align-items: center;">
                    <span>
                        <img src="<?php echo base_url() ?>img/<?php echo ($eu['num_canciones'] == 0) ? 'admiracion' : 'check' ?>.png" width="15"
                            onMouseOver="Tip('<?php echo ($eu['num_canciones'] == 0) ? 'No hay ninguna canción asignada para este momento especial' : 'Existen canciones asignadas para este momento especial' ?>')"
                            onMouseOut="UnTip()" />

                        <?php echo $eu['orden'] . '.- ' . $eu['nombre'] ?>
                    </span>

                    <span style="display: flex; align-items: center; gap: 8px;">
                        <input type="time" name="hora_<?php echo $eu['id'] ?>"
                            value="<?php echo substr($eu['hora'], 0, 5) ?>"
                            style="width:70px; margin-right:20px" disabled />
                    </span>
                </li>

            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</fieldset>

<fieldset class="datos">
    <legend>Mis Listas de canciones</legend>
    <?php if ($events_user != false): ?>

        <?php foreach ($events_user as $eu): ?>
            <div class="momentos" style="margin-bottom: 30px; border: 1px solid #ccc; padding: 10px; ">
                <h3 style="margin-bottom: 10px;">
                    <?php echo $eu['orden'] . '.- ' . $eu['nombre']; ?>
                    <?php if (!empty($eu['hora'])): ?>
                        <small style="color: #777; font-size: 13px;">(<?php echo substr($eu['hora'], 0, 5); ?>)</small>
                    <?php endif; ?>
                </h3>

                <ul class="canciones" id="m_<?php echo $eu['momento_id'] ?>">
                    <?php foreach ($canciones_user as $c): ?>
                        <?php if ($eu['momento_id'] == $c['momento_id']): ?>
                            <li id="c_<?php echo $c['id'] ?>" style="margin-bottom: 8px;">
                                <?php echo $c['artista'] ?> - <?php echo $c['cancion'] ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>

    <?php else: ?>
        <p>No hay canciones</p>
    <?php endif; ?>
</fieldset>

<fieldset>
    <legend>Observaciones</legend>
    <ul style="list-style:none">
        <?php
        if (!$canciones_observaciones_general && !$canciones_observaciones_momesp)
            echo "No hay Observaciones";

        if ($canciones_observaciones_general) {
            foreach ($canciones_observaciones_general as $c) {
        ?>
                <li style="border-bottom:#CCC 1px solid" id="obs_<?php echo $c['id'] ?>"><span style="font-size:16px" class="edit_box" id="<?php echo $c['id'] ?>"><?php echo $c['comentario'] ?></span> <span style="font-size:11px"><br>(escrito el <?php echo $c['fecha'] ?>)</span>
                </li>
        <?php
            }
        }
        ?>
    </ul>
    <?php

    if ($canciones_observaciones_momesp) {

        $momentos_ids = array();
        foreach ($canciones_observaciones_momesp as $c) {
            $momentos_ids[] = $c['momento_id'];
        }

        foreach ($events as $e) {

            if (in_array($e['id'], $momentos_ids, true)) {
    ?>
                <div class="observaciones">
                    <h3><?php echo $e['nombre']; ?></h3>
                    <ul id="m_<?php echo $e['id'] ?>">
                        <?php
                    }
                    foreach ($canciones_observaciones_momesp as $c) {
                        if ($e['id'] == $c['momento_id']) {
                        ?>
                            <li style="border-bottom:#CCC 1px solid" id="obs_<?php echo $c['id'] ?>"><span style="font-size:16px" class="edit_box" id="<?php echo $c['id'] ?>"><?php echo $c['comentario'] ?></span> <span style="font-size:11px"><br>(escrito el <?php echo $c['fecha'] ?>)</span>
                            </li>

                    <?php
                        }
                    }

                    ?>

            <?php
            if (in_array($e['id'], $momentos_ids, true)) echo "</ul></div>";
        }
    } ?>
</fieldset>