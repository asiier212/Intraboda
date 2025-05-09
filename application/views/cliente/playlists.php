<style>
    .formElegir {
        margin-top: 20px;
    }

    .tabledata {
        width: 100%;
        border-collapse: collapse;
        margin-top: 40px;
    }

    .tabledata th,
    .tabledata td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: center;
    }

    .tabledata th {
        background-color: rgb(104, 216, 60);
        font-weight: bold;
    }

    .tabledata img {
        width: 80px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .tabledata a {
        color: #1DB954;
        text-decoration: none;
        font-weight: bold;
    }

    .tabledata a:hover {
        text-decoration: underline;
    }
</style>

<table class="tabledata">
    <thead>
        <tr>
            <th colspan="3">Mis PlayLists</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($enlaces)): ?>
            <?php foreach ($enlaces as $playlist): ?>
                <tr>
                    <td><img src="<?= htmlspecialchars($playlist->portada) ?>"></td>
                    <td><a href="<?= htmlspecialchars($playlist->enlace) ?>" target="_blank"><?= htmlspecialchars($playlist->titulo) ?></a></td>
                    <td>x</td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No tienes playlists guardadas.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>