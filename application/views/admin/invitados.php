<h2>Usuarios Invitados</h2>
<p style="margin-bottom: 20px;">Listado de invitados creados por los clientes. Puedes Desactivarlos o eliminarlos.</p>

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
        <?php $clave_encriptada= $inv['clave'] ;
        $clave_plana = $this->encrypt->decode($clave_encriptada);?>
        <?php $nombre_cliente = $inv['nombre_novio'] . " y " . $inv['nombre_novia'] ?>
        <tr>
            <td><a href="<?php echo base_url() . 'admin/clientes/view/' . $inv['id_cliente']; ?>"><?php echo $nombre_cliente; ?></a></td>
            <td><?php echo htmlspecialchars($inv['username']); ?></td>
            <td><?php echo htmlspecialchars($inv['email']); ?></td>
            <td><?php echo $clave_plana; ?></td>
            <td><?php echo date('d/m/Y', strtotime($inv['fecha_creacion'])); ?></td>
            <td>
                <?php echo $inv['fecha_expiracion'] ? date('d/m/Y', strtotime($inv['fecha_expiracion'])) : 'Sin fecha'; ?>
            </td>
            <td>
                <?php echo ($inv['valido']) ? '<span style="color:green">Activo</span>' : '<span style="color:red">Inactivo</span>'; ?>
            </td>
            <td>
                <a href="<?php echo base_url() . 'admin/accion/' . ($inv['valido'] ? 'desactivar' : 'activar') . '/' . $inv['id']; ?>">
                    <?php echo $inv['valido'] ? 'Desactivar' : 'Activar'; ?>
                </a> |
                <a href="<?php echo base_url() . 'admin/eliminar_invitado/' . $inv['id']; ?>" onclick="return confirm('¿Eliminar este invitado?')">
                    Eliminar
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php if (empty($invitados)) echo "<p style='text-align:center; color:gray;'>No hay invitados creados aún.</p>"; ?>