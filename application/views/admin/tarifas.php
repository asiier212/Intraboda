<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

<link rel="stylesheet" href="<?php echo base_url() ?>js/jquery1.10.4/themes/smoothness/jquery-ui.css">
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-1.10.2.js"></script>
<script src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery-ui-1.10.4.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery1.10.4/js/jquery.jeditable.js"></script>
<script src="<?php echo base_url() ?>js/tabulator-master/dist/js/tabulator.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>js/tabulator-master/dist/css/tabulator_bootstrap4.css">

<script src="<?php echo base_url() ?>assets/js/tarifas.js"></script>
<link rel = "stylesheet" type = "text/css" 
      href = "<?php echo base_url(); ?>css/style.css">
<style>
    .tabulator-row.tabulator-selected{
        background-color:#BEFBD0!important;
    }
</style>
<h2>
     Tarifas
</h2>
<div class="row">
    <div class="col-3 col-m-3 col-md-3">


       <?php
          $html = ' <select id="tarifa" class="form-select" aria-label="Tarifa" onChange="cambiaServicio();">'
               . '<option selected>Selecciona tarifa</option>';
       // error_log("Los post son  " . var_export($posts, 1), 3, "./r");
foreach($posts as $post){
           $html .= '<option value=' . $post["ID"] . '>' . $post["post_title"] . '</option>';
       }
        $html .= "</select>";

        echo $html;
       ?>


    </div>
    <div class="col-2 col-m-2 col-md-2">
        <button type="button" class="btn btn-primary" onclick="showModal();">
            Nueva tarifa
        </button>
    </div>
</div> 
<div class="row">
    <div class="col-7 col-m-7 col-sm-7">
        <div id="tarifas">

        </div>
    </div>
    <div class="col-5 col-m-5 col-sm-5">
        <div id="detallestarifa">

        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="nuevaTarifa" tabindex="-1" role="dialog" aria-labelledby="nuevaTarifaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title font-weight-bold" id="exampleModalLabel" style="font-size:1.6em;font-weight: bold;">Crear Tarifa</span>

            </div>
            <div class="modal-body">
                <form class="form">
                    <div class="form-group col-m-12 col-md-12 col-12">
                        <label for="nombre" style="font-weight: bold;">Nombre</label>
                        <input type="text" class="form-control" id="nombre" aria-describedby="nombreHelp" >
                        <small id="nombreHelp" class="form-text text-muted">Nombre de la tarifa</small>
                    </div>
                    <div class="row">
                        <div class="form-group col-m-5 col-md-5 col-5">
                        <label for="desfec" style="font-weight: bold;">Desde Fecha</label>
                        <input type="date" class="form-control" id="desfec" aria-describedby="desfecHelp" >
                        <small id="hasfecHelp" class="form-text text-muted">Fecha de inicio validez </small>
                        </div>
                    <div class="form-group col-m-5 col-md-5 col-5">
                        <label for="hasfec" style="font-weight: bold;">Hasta Fecha</label>
                        <input type="date" class="form-control" id="hasfec" aria-describedby="hasfecHelp" >
                        <small id="desfecHelp" class="form-text text-muted">Fecha de fin validez</small>
                    </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-m-5 col-md-5 col-5">
                            <label for="mineventos" style="font-weight: bold;">Mínimo eventos</label>
                            <input type="number" class="form-control"  min="0" max="99" id="mineventos" aria-describedby="mineventoshelp" value="0" >
                            <small id="mineventoshelp" class="form-text text-muted">Desde eventos contratados</small>
                        </div>
                        <div class="form-group col-m-5 col-md-5 col-5">
                            <label for="maxeventos" style="font-weight: bold;">Máximo eventos</label>
                            <input type="number" class="form-control" min="0" max="99" id="maxeventos" aria-describedby="maxeventoshelp" value="99">
                            <small id="maxeventoshelp" class="form-text text-muted">Hasta eventos contratados</small>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary mb-2" onclick="crearTarifa();$('#nuevaTarifa').modal('hide');">Crear Tarifa</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  onclick="$('#nuevaTarifa').modal('hide');">Cancelar</button>

            </div>
        </div>
    </div>
</div>
<div class="toast-container  position-fixed top-0 end-0 p-3">
    <div id="tarifaguardada" class="toast text-bg-success" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">

            <strong class="me-auto">Exel Eventos</strong>
            <small>Guardar tarifa</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body text-center">
            <strong>Tarifa guardada</strong>
        </div>
    </div>
</div>
<div class="toast-container  position-fixed top-0 end-0 p-3">
    <div id="tarifaborrada" class="toast text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">

            <strong class="me-auto">Exel Eventos</strong>
            <small>Borrar tarifa</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body text-center">
            <strong>Tarifa Borrada</strong>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="borrartarifa">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Borrar Tarifa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de borrar la tarifa?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="borrarTarifa();$('#borrartarifa').modal('hide');">Borrar Tarifa </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#borrartarifa').modal('hide');">Cancelar</button>
            </div>
        </div>
    </div>
</div>
