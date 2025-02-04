<style>
    .page {
        width: auto !important;
    }

    table.tablec {
        font-family: "Trebuchet MS", sans-serif;
        font-size: 16px;
        font-weight: bold;
        line-height: 1.4em;
        font-style: normal;
        border-collapse: separate;
        padding-bottom: 4%;
        margin: 0 auto;
    }

    .tablec thead tr td {
        padding: 15px;
        color: #fff;
        text-shadow: 1px 1px 1px #4C7335;
        border: 1px solid #74A34C;
        border-bottom: 3px solid #7EC756;
        background-color: #78BF4C;
        background: linear-gradient(to top, rgb(98, 158, 67), rgb(139, 198, 66));
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        height: 1.4em;
        font-size: 1.2em;
    }

    .tablec tbody td {
        padding: 10px;
        text-align: center;
        background-color: #F0F8E0;
        border: 2px solid #E0EFD0;
        border-radius: 2px;
        color: #444;
        text-shadow: 1px 1px 1px #fff;
    }

    .main {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
        gap: 10px 20px;
        width: 80%;
        margin: 40px auto 0 auto;
        align-items: start;
    }

    /* Nuevo diseño para los filtros */
    .filters-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background-color: #EAF5D6;
        border-radius: 10px;
        width: fit-content;
        margin: 20px auto;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .filters-container label {
        font-size: 14px;
        font-weight: bold;
        color: #333;
        margin-right: 5px;
    }

    .filters-container input[type="date"],
    .filters-container select {
        width: 140px;
        height: 32px;
        padding: 5px;
        background-color: #FFFFFF;
        border: 1px solid #74A34C;
        border-radius: 5px;
        font-size: 14px;
        transition: 0.3s ease-in-out;
    }

    .filters-container input[type="date"]:focus,
    .filters-container select:focus {
        border: 1px solid #568F23;
        box-shadow: 0px 0px 5px rgba(86, 143, 35, 0.5);
        outline: none;
    }

    .filters-container input[type="submit"] {
        width: 140px;
        height: 38px;
        font-size: 16px;
        font-weight: bold;
        color: white;
        background: linear-gradient(to top, #5A9E40, #8FD556);
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    .filters-container input[type="submit"]:hover {
        background: linear-gradient(to top, #4A8E34, #7EC746);
    }

    .clear-filter {
        font-size: 14px;
        font-weight: bold;
        color: #007BFF;
        text-decoration: none;
        margin-left: 10px;
    }

    .clear-filter:hover {
        text-decoration: underline;
    }
</style>

<h2 style="text-align:center;">Canciones más elegidas</h2>

<!-- Formulario de búsqueda -->
<form method="GET" class="filters-container">
    <div>
        <label for="fecha_desde">Desde:</label>
        <input type="date" id="fecha_desde" name="fecha_desde" value="<?php echo isset($_GET['fecha_desde']) ? $_GET['fecha_desde'] : ''; ?>" />
    </div>

    <div>
        <label for="fecha_hasta">Hasta:</label>
        <input type="date" id="fecha_hasta" name="fecha_hasta" value="<?php echo isset($_GET['fecha_hasta']) ? $_GET['fecha_hasta'] : ''; ?>" />
    </div>

    <div>
        <label for="momento">Momento:</label>
        <select id="momento" name="momento">
            <option value="">Todos</option>
            <?php foreach ($momentos as $momento) { ?>
                <option value="<?php echo htmlspecialchars($momento, ENT_QUOTES, 'UTF-8'); ?>"
                    <?php echo (isset($_GET['momento']) && $_GET['momento'] == $momento) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($momento, ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div style="display: flex; align-items: center;">
        <input type="submit" value="Buscar" />
        <a href="<?php echo base_url() ?>cliente/topSongs" class="clear-filter">Limpiar</a>
    </div>
</form>

<!-- Mostrar las tablas con los momentos y canciones -->
<div class="main">
    <?php
    $momentoActual = '';
    foreach ($topsongs as $data) {
        foreach ($data as $song) {
            if ($song['momento'] !== $momentoActual) {
                if ($momentoActual !== '') {
                    echo '</table></div>';
                } ?>
                <div style="overflow-x:auto;">
                    <table border="0" width="600px" class="tablec">
                        <thead>
                            <tr>
                                <td colspan="3" align="center" style="vertical-align:middle;"> <?php echo $song["momento"] ?></td>
                            </tr>
                            <tr>
                                <td align="center">Pos</td>
                                <td align="center">Canción</td>
                                <td align="center">Veces</td>
                            </tr>
                        </thead>
                    <?php
                    $momentoActual = $song['momento'];
                } ?>
                <tr>
                    <td align="center"><?php echo $song['orden'] ?>ª</td>
                    <td align="center"><?php echo $song['artista'] . ' - ' . $song['cancion'] ?></td>
                    <td align="center"><?php echo $song['cuantas'] ?></td>
                </tr>

            <?php
        }
    } ?>
</div>
<div class="clear"></div>
