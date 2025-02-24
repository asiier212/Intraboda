<h2>Emails Enviados</h2>

<p style="font-style: italic; color: gray;">Haz click en el email para ver mas información.</p>

<table class="tabledata">
    <tr>
        <th style="width:100px"><a style="color:#FFF; text-decoration:underline">Email</th>
        <th style="width:100px"><a style="color:#FFF; text-decoration:underline">Solicitante</th>
        <th style="width:100px"><a style="color:#FFF; text-decoration:underline">Comercial</th>
        <th style="width:100px"><a style="color:#FFF; text-decoration:underline">Fecha de Envío</th>
    </tr>

    <tbody>
        <?php if (!empty($emails_enviados)): ?>
            <?php foreach ($emails_enviados as $email): ?>
                <tr>
                    <td>
                        <a href="<?= base_url() ?>comercial/emails/edit/<?= $email->id_email ?>" style="color: inherit; text-decoration: none;">
                            <?= $email->asunto_email ?>
                        </a>
                    </td>
                    <td>
                        <?= ($email->nombre_solicitante && $email->apellido_solicitante) ? $email->nombre_solicitante . ' ' . $email->apellido_solicitante : 'Se ha usado un email de prueba' ?>
                    </td>
                    <td><?= $email->nombre_comercial ?></td>
                    <td><?= $email->fecha_envio ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No hay emails enviados registrados.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>