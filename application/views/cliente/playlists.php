<style>
    .formElegir {
        margin-top: 20px;
    }

    .tabledata_spoty {
        width: 100%;
        border-collapse: collapse;
        margin-top: 40px;
    }

    .tabledata_spoty th,
    .tabledata_spoty td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: center;
    }

    .tabledata_spoty th {
        background-color: rgb(104, 216, 60);
        font-weight: bold;
    }

    .tabledata_spoty img {
        width: 60px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .tabledata_spoty a {
        color: #1DB954;
        text-decoration: none;
        font-weight: bold;
    }

    .tabledata_spoty a:hover {
        text-decoration: underline;
    }
</style>
<div id="result"></div>
<table class="tabledata_spoty">
    <thead>
        <tr>
            <th colspan="3" style="font-size: 15px; color: white;">Mis PlayLists</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($enlaces)): ?>
            <?php foreach ($enlaces as $playlist): ?>
                <tr id="playlist_<?= $playlist->id ?>">
                    <td><a href="<?= htmlspecialchars($playlist->enlace) ?>" target="_blank"><img src="<?= htmlspecialchars($playlist->portada) ?>"></a></td>
                    <td><a href="<?= htmlspecialchars($playlist->enlace) ?>" target="_blank"><?= htmlspecialchars($playlist->titulo) ?></a></td>
                    <td>
                        <a href="#"
                            data-id="<?= $playlist->id ?>"
                            onclick="return delete_playlist(this)"
                            style="color:red; text-decoration: none; font-size: 20px">✖</a>
                    </td>
                </tr>
            <?php endforeach; ?>

        <?php else: ?>
            <tr>
                <td colspan="6">No tienes playlists guardadas.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>