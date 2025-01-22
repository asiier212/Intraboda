var tarifas;
var idTarifa;
var deleteIcon = function (cell, formatterParams) { //plain text value
    return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">  <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/></svg>';
};
var saveIcon = function (cell, formatterParams) { //plain text value

    return '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M48 96V416c0 8.8 7.2 16 16 16H384c8.8 0 16-7.2 16-16V170.5c0-4.2-1.7-8.3-4.7-11.3l33.9-33.9c12 12 18.7 28.3 18.7 45.3V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96C0 60.7 28.7 32 64 32H309.5c17 0 33.3 6.7 45.3 18.7l74.5 74.5-33.9 33.9L320.8 84.7c-.3-.3-.5-.5-.8-.8V184c0 13.3-10.7 24-24 24H104c-13.3 0-24-10.7-24-24V80H64c-8.8 0-16 7.2-16 16zm80-16v80H272V80H128zm32 240a64 64 0 1 1 128 0 64 64 0 1 1 -128 0z"/></svg>';

                };
        var editIcon = function (cell, formatterParams) { //plain text value

        return '<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z"/></svg>';
                };
function borrarTarifa() {
    const data = {action: 'delete-tarifa', id: idTarifa};
    $.ajax({
        type: 'POST',
        url: '',
        data: data,
        dataType: 'json',
        success: function (resp) {
            console.log(resp);

            cambiaServicio();
            var toast = $("#tarifaborrada");
            /*toast.show();*/
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
            toastBootstrap.show();
        }
    });

                }
function guardarTarifa(idTarifa, idServicio, nombre, desde, hasta, desdeNumEventos, hastaNumEventos) {

    const data = {action: 'guardar-tarifa', id: idTarifa, idServicio: idServicio, nombre: nombre, desde: desde
        , hasta: hasta, desdeNumEventos: desdeNumEventos, hastaNumEventos: hastaNumEventos};
    $.ajax({
        type: 'POST',
        url: '',
        data: data,
        dataType: 'json',
        success: function (resp) {
            console.log("la respuesta");
            console.log(resp);
            let tratar = resp;
            console.log("El objeto");
            console.log(tratar);
            if (tratar.resultado != 'OK') {
                alert("Conflicto de Tarifas con " + tratar.DATOS[0].nombre);
            } else {
                alert("Tarifa guardada");
            }
        }
    });

}
function showTarif() {
    tableLines = new Tabulator("#tarifas",
            {
                selectable: 1,
                height: 400,
        width: "100%",
        data: tarifas,
        layout: "fitColumns",
                columns: [

                    {title: "id", field: "id", width: 150, visible: false},
        {title: "nombre", field: "nombre", width: 200, visible: true, headerFilter: "input", editor:"input"},
                    {title: "Desde", field: "desde", width: 120, visible: true, editor: "date"},
        {title: "Hasta", field: "hasta", width: 120, visible: true, editor: "date"},
                    {title: ">", field: "desde_numeventos", width: 65, visible: true, editor: "number", editorParams: {min: 0, max: 20, selectContents: true}},
                    {title: "<", field: "hasta_numeventos", width: 65, visible: true, editor: "number", editorParams: {min: 0, max: 20, selectContents: true}},
        {formatter: editIcon, width: 25, hozAlign: "center", cellClick: function (e, cell) {
        idTarifa = cell.getRow().getData().id;
                            //$("#borrartarifa").modal('show');
                            let row = cell.getRow();
                            let data = row.getData(); //get data object for row
                            console.log(data);
                            getDetalleTarifa(data.id);
                        }},
                    {formatter: saveIcon, width: 25, hozAlign: "center", cellClick: function (e, cell) {
                            let IdServicio = $("#tarifa").val();
                            let data = cell.getRow().getData();
                            console.log("Los datos de la fila");
                            console.log(data);

                            let idTarifa = data.id;
                            let nombre = data.nombre;
                            let desde = data.desde;
                            let hasta = data.hasta;
                            let desdeNumEventos = data.desde_numeventos;
                            let hastaNumEventos = data.hasta_numeventos;
                            //$("#borrartarifa").modal('show');
                            guardarTarifa(idTarifa, IdServicio, nombre, desde, hasta, desdeNumEventos, hastaNumEventos);
                        }},
                    {formatter: deleteIcon, width: 25, hozAlign: "center", cellClick: function (e, cell) {
                            idTarifa = cell.getRow().getData().id;
                            //$("#borrartarifa").modal('show');
                            $('#borrartarifa').appendTo("body").modal('show');
                        }}

        ]
            });
    tableLines.on("rowClick", function (e, row) {
        var data = row.getData(); //get data object for row
        console.log(data);
        getDetalleTarifa(data.id);
    });
        }
function getDetalleTarifa(idtarifa) {
    let data = {action: 'get-detalle-tarifa', idtarifa: idtarifa};
    $.ajax({
        type: 'POST',
        url: '',
        data: data,
        dataType: 'html',
        success: function (resp) {
            console.log(resp);
            $('#detallestarifa').html(resp);
        }
    });
}
function cambiaServicio() {
    let value = $("#tarifa").val();
    let data = {action: 'change-service', idservice: value};
    $('#detallestarifa').html('');
    $.ajax({
        type: 'POST',
        url: '',
        data: data,
        dataType: "json",
        success: function (resp) {
            console.log("Esto es lo que recibimos");
            console.log(resp);
            tarifas = resp;
            showTarif();

        }
    });

}
function showModal()
{
    const idservicio = $("#tarifa").val();
    if (isNaN(idservicio))
    {
        alert("Tienes que elegir el servicio para el que quieres crear la tarifa primero");
        return;
    }
    // $("#nuevaTarifa").modal("show");
    $('#nuevaTarifa').appendTo("body").modal('show');
    $("#nombre").val('');
    $("#desfec").val('');
    $("#hasfec").val('');
}
function crearTarifa() {

    $('#detallestarifa').html('');
    let data = {action: 'create-tariff'
        , idservicio: $("#tarifa").val()
        , desfec: $("#desfec").val(), hasfec: $("#hasfec").val()
        , nombre: $("#nombre").val()
        , mineventos: $("#mineventos").val()
        , maxeventos: $("#maxeventos").val()};
    $.ajax({
        type: 'POST',
        url: '',
        data: data,
        dataType: "json",
        success: function (resp) {
            console.log("Hemos recibido una respuesta. Creamos una tarifa");
            cambiaServicio();
        }
    });
}
function saveDetailSliderTarifa(idformulario) {

    const valor = $("#value_" + idformulario).val();
    let data = {action: 'save-slider-tariff', id: idformulario, valor: valor};
    $.ajax({
        type: 'POST',
        url: '',
        data: data,
        dataType: "json",
        success: function (resp) {
            console.log("Hemos recibido una respuesta");
            var toast = $("#tarifaguardada");
            /*toast.show();*/
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
            toastBootstrap.show();
        }
    });

}
function saveDetailSwitchTarifa(idformulario) {
    let datos = $("#" + idformulario).serialize();
    console.log(datos);
    const valores = {value_off: $("#valueoff_" + idformulario).val(), value_on: $("#valueon_" + idformulario).val(), initial_value: 'off'};
    let data = {action: 'save-switch-tariff', id: idformulario, values: valores};
    $.ajax({
        type: 'POST',
        url: '',
        data: data,
        dataType: "json",
        success: function (resp) {
            console.log("Hemos recibido una respuesta");
            var toast = $("#tarifaguardada");
            /*toast.show();*/
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
            toastBootstrap.show();
        }
    });

}
function saveDetailSelectTarifa(idformulario) {
    let datos = $("#" + idformulario).serialize();
    console.log(datos);
    let titulos = $("#" + idformulario + " input[name='titulo']");
    let descs = $("#" + idformulario + " input[name='desc']");
    let values = $("#" + idformulario + " input[name='value']");
    const valores = [];
    titulos.each(function (key, val) {
        console.log(key);
        console.log(val);
        reg = {nombre: $(val).val(), precio: $(values[key]).val(), descripcion: $(descs[key]).val()};
        console.log("un registro por separado");
        valores.push(reg);
        console.log(reg);
        //console.log($(control).attr("name") + "      " + $(control).val());
    });
    console.log('Objetos a enviar ');
    console.log(valores);
    let data = {action: 'save-detail-tariff', id: idformulario, values: valores};
    $.ajax({
        type: 'POST',
        url: '',
        data: data,
        dataType: "json",
        success: function (resp) {
            console.log("Hemos recibido una respuesta");
            var toast = $("#tarifaguardada");
            /*toast.show();*/
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
            toastBootstrap.show();



        }
    });
}
$(document).ready(function () {


});