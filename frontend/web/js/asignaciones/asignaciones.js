$(document).ready(function(){
    $("#vistaTrabajadores").hide();
    $("#vistaCrearAsignacionTrabajador").hide();
    //$(".entrada-datos").hide();

    $("#btnCancelar").click(function () {
        $("#vistaAsignaciones").show(300);
        $("#vistaTrabajadores").hide(300);
        $("#vistaCrearAsignacionTrabajador").hide(300);
    });
});

function formatRepo(repo) {
    if (repo.loading) {
        return repo.text;
    }
    var $container = $(
        "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__meta'>" +
        "<div class='select2-result-repository__title'></div>" +
        "<div class='select2-result-repository__description font-weight-bold font-italic'></div>" +
        "</div>" +
        "</div>"
    );
    $container.find(".select2-result-repository__title").text(repo.text);
    $container.find(".select2-result-repository__description").text(repo.padre);
    return $container;
}

function formatRepoSelection(repo) {
    if (repo.padre != undefined) {
        return repo.text + " / " + repo.padre;
    }
    else {
        return repo.text;
    }
}

/*=============================================
CARGAR LA TABLA DINÁMICA DE TRABAJADORES
=============================================*/
$(".tablaAsignaciones").DataTable({
    //"ajax": "index.php?r=trabajadores/listar-trabajadores-ajax",
    ajax: {
        method: "POST",
        dataType: 'json',
        cache: false,
        url: 'index.php?r=Filiacion/asignaciones/listar-asignaciones-ajax',
        data: {}
    },
    "responsive": true,
    "retrieve": true,
    "processing": true,
    "deferRender": false,
    "language": {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }
});

/*=============================================
CARGAR LA TABLA DINÁMICA DE TRABAJADORES
=============================================*/
$(".tablaTrabajadores").DataTable({
    //"ajax": "index.php?r=trabajadores/listar-trabajadores-ajax",
    ajax: {
        method: "POST",
        dataType: 'json',
        cache: false,
        url: 'index.php?r=Filiacion/asignaciones/listar-trabajadores-ajax',
        data: {}
    },
    "responsive": true,
    "retrieve": true,
    "processing": true,
    "deferRender": false,
    "language": {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }
});

/*=============================================
ACTIVAR ASIGNACION
=============================================*/
$(".tablaAsignaciones tbody").on("click", ".btnActivar", function () {
    let objectBtn = $(this);
    let codigo = objectBtn.attr("codigo");
    let estado = objectBtn.attr("estado");
    let datos = new FormData();
    datos.append("codigoactivar", codigo);
    datos.append("estadoactivar", estado);
    $.ajax({
        url: "index.php?r=Filiacion/asignaciones/activar-asignacion-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            if (respuesta === "ok") {
                if (estado == "V") {
                    objectBtn.removeClass('btn-success');
                    objectBtn.addClass('btn-danger');
                    objectBtn.html('NO VIGENTE');
                    objectBtn.attr('estado', 'C');
                } else {
                    objectBtn.addClass('btn-success');
                    objectBtn.removeClass('btn-danger');
                    objectBtn.html('VIGENTE');
                    objectBtn.attr('estado', 'V');
                }
            }
            else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "Ocurrio un error al cambiar el estado del cargo con código " + codigo + ". Comuniquese con el administrador del sistema.",
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Cerrar'
                });
            }
        }
    });
});

/*=============================================
MOSTRAR CREAR ASIGNACION
=============================================*/
$("#btnMostrarCrearAsignacion").click(function () {
    $("#vistaAsignaciones").hide(300);
    $("#vistaTrabajadores").show(300);
    $("#vistaCrearAsignacionTrabajador").hide(300);
    /*$(".modal-content .entrada-datos-sector").hide();
    $(".modal-content .tablaTrabajadores").show();
    $(".modal-content .dataTables_info").show();
    $(".modal-content .dataTables_length").show();
    $(".modal-content .dataTables_filter").show();
    $(".modal-content .dataTables_paginate").show();
    $(".modal-content tablaTrabajadores").DataTable().ajax.reload();
    $(".entrada-datos").hide();
    $(".entrada-datos1").hide();
    $(".entrada-datos2").hide();
    $(".entrada-datos3").hide();
    $(".entrada-datos4").hide();
    $(".entrada-datos5").hide();*/
});

/*=============================================
SELECCIONAR TRABAJADOR
=============================================*/
$(".tablaTrabajadores tbody").on("click", ".btnElegir", function () {
    let objectBtn = $(this);
    let codigoTrabajador = objectBtn.attr("codigotrabajador");
    let idPersona = objectBtn.attr("idPersona");
    let nombre = objectBtn.attr("nombre");
    let sectorTrabajo = $("#codigoSectorTrabajoShow").val();
    let condicionLaboral = $("#codigoCondicionLaboralShow").val();
    $("#vistaAsignaciones").hide(300);
    $("#vistaTrabajadores").hide(300);
    $("#vistaCrearAsignacionTrabajador").show(300);
    let datos = new FormData();
    datos.append("codigo", codigoTrabajador);
    datos.append("sector", sectorTrabajo);
    datos.append("condicion", condicionLaboral);
    $.ajax({
        url: "index.php?r=Filiacion/trabajadores/listar-trabajadores-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            if (respuesta != "error") {
                /*$(".modal-content .tablaTrabajadores").hide();
                $(".modal-content .dataTables_info").hide();
                $(".modal-content .dataTables_length").hide();
                $(".modal-content .dataTables_filter").hide();
                $(".modal-content .dataTables_paginate").hide();
                $(".entrada-datos").show();
                $(".entrada-datos1").show();
                $(".entrada-datos2").show();
                $(".entrada-datos3").show();
                $(".entrada-datos4").show();
                $(".entrada-datos5").show();*/
                $("#codigoTrabajadorNew").val(codigoTrabajador);
                $("#idPersonaNew").val(idPersona);
                $("#nombreCompletoNew").val(nombre);
            }
            else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "El Trabajador ya tiene una Asignacion como Administrativo.",
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Cerrar"
                }).then(function () {
                    $('#modalCrearAsignacionAsignacion').modal('hide');
                });
            }
        }
    });

});

/*=============================================
SELECCIONAR SECTOR TRABAJO
=============================================*/
$(".codigoSectorTrabajo").change(function () {
    let sector = $(this).val();
    let codigoUnidad = $("#codigoUnidadNew").val();
    if (sector != "") {
        let datos = new FormData();
        datos.append("codigosectortrabajo", sector);
        //datos.append("codigounidad", codigoUnidad);
        $.ajax({
            url: "index.php?r=Filiacion/asignaciones/listar-condiciones-laborales-ajax",
            method: "POST",
            dataType: 'html',
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $(".entrada-datos1").show();
                $(".entrada-datos-sector").hide();
                $(".modal-content .tablaTrabajadores").hide();
                $(".entrada-datos2").show();
                $(".entrada-datos3").show();
                $(".entrada-datos4").show();
                $(".codigoCondicionLaboral").empty().append(respuesta);
                $(".codigoCondicionLaboral").prop("disabled", false);
                $("#codigoSectorTrabajoShow").val(sector);
                $("#nombreSectorTrabajoShow").val($(".codigoSectorTrabajo option:selected").html());
                datos.append("codigosectortrabajo", sector);
            }
        });
    } else {
        $(".codigoCondicionLaboral").empty().append("<option value=''>Selecionar Condicion Laboral</option>");
        $(".codigoCondicionLaboral").prop("disabled", true);
        $(".entrada-datos").show();
        $(".entrada-datos1").show();
        $(".entrada-datos2").show();
        $(".entrada-datos3").show();
        $(".entrada-datos4").show();
    }
    if (sector != "") {
        let datos = new FormData();
        datos.append("codigosectortrabajo", sector);
        datos.append("codigounidad", codigoUnidad);
        $.ajax({
            url: "index.php?r=Filiacion/asignaciones/listar-cargos-ajax",
            method: "POST",
            dataType: 'html',
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $(".codigoCargo").empty().append(respuesta);
                $(".codigoCargo").prop("disabled", false);
                $("#codigoSectorTrabajoShow").val(sector);
                $("#nombreSectorTrabajoShow").val($(".codigoSectorTrabajo option:selected").html());
                datos.append("codigosectortrabajo", sector);
            }
        });
    } else {
        $(".codigoCargo").empty().append("<option value=''>Selecionar Cargo</option>");
        $(".codigoCargo").prop("disabled", true);
    }
    if (sector != "") {
        let datos = new FormData();
        datos.append("codigosectortrabajo", sector);
        $.ajax({
            url: "index.php?r=Filiacion/asignaciones/listar-niveles-salariales-ajax",
            method: "POST",
            dataType: 'html',
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $(".codigoNivelSalarial").empty().append(respuesta);
                $(".codigoNivelSalarial").prop("disabled", false);
                $("#codigoSectorTrabajoShow").val(sector);
                $("#nombreSectorTrabajoShow").val($(".codigoSectorTrabajo option:selected").html());
                datos.append("codigosectortrabajo", sector);
            }
        });
    } else {
        $(".codigoNivelSalarial").empty().append("<option value=''>Selecionar Nivel Salarial</option>");
        $(".codigoNivelSalarial").prop("disabled", true);
    }
});
/*=============================================
SELECCIONAR CONDICION LABORAL
=============================================*/
$(".codigoCondicionLaboral").change(function () {
    let codigoCondicionLaboral = $(this).val();
    let codigoUnidad = $("#codigoUnidadNew");
    let codigoCargo = $("#codigoCargoNew");
    if (codigoCondicionLaboral != "" || codigoUnidad != "" || codigoCargo != "") {
        let datos = new FormData();
        $(".modal-content .tablaTrabajadores").hide();
        $(".entrada-datos2").show();
        $(".entrada-datos3").show();
        $(".entrada-datos4").show();
        $(".entrada-datos5").show();
        $("#codigoCondicionLaboralUpd").val(codigoCondicionLaboral);
        $("#nombreCondicionLaboralUpd").val($(".codigoCondicionLaboral option:selected").html());
        datos.append("codigocondicionlaboral", codigoCondicionLaboral);
        datos.append("codigounidad", codigoUnidad);
        datos.append("codigocargo", codigoCargo);
    } else {
        $(".codigoNivelSalarial").empty().append("<option value=''>Selecionar Condicion Laboral</option>");
        $(".codigoNivelSalarial").prop("disabled", true);
        $(".entrada-datos2").show();
        $(".entrada-datos3").show();
        $(".entrada-datos4").show();
        $(".entrada-datos5").show();
    }
});

/*=============================================
SELECCIONAR UNIDAD
=============================================*/
$(".codigoUnidadPadre").change(function () {
    let unidadPadre = $(this).val();
    if (unidadPadre != "") {
        let datos = new FormData();
        datos.append("codigoUnidadPadre", unidadPadre);
        $.ajax({
            url: "index.php?r=items/listar-unidades-ajax",
            method: "POST",
            dataType: 'html',
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $(".codigoUnidad").empty().append(respuesta);
                $(".codigoUnidad").prop("disabled", false);
            }
        });
    } else {
        $(".codigoUnidad").empty().append("<option value=''>Selecionar Unidad</option>");
        $(".codigoUnidad").prop("disabled", true);
    }
});

$("#codigoUnidadNew").change(function () {
    let codigoUnidad = $(this).val();
    let codigoCargo = $("#codigoCargoNew").val();
    if (codigoUnidad != "") {
        let datos = new FormData();
        datos.append("codigoUnidad", codigoUnidad);
        datos.append("codigoCargo", codigoCargo);
        $.ajax({
            url: "index.php?r=Filiacion/asignaciones/listar-items-ajax",
            method: "POST",
            dataType: 'html',
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $("#nroItemNew").empty().append(respuesta);
                $("#nroItemNew").prop("disabled", false);
                $(".entrada-datos3").show();
                $(".entrada-datos4").show();
                $(".entrada-datos5").show();
            }
        });
    } else {
        $("#nroItemNew").empty().append("<option value=''>Selecionar Cargo</option>");
        $("#nroItemNew").prop("disabled", false);
        $(".entrada-datos3").show();
        $(".entrada-datos4").show();
        $(".entrada-datos5").show();
    }
});

$("#codigoUnidadUpd").change(function () {
    let codigoUnidad = $(this).val();
    let codigoCargo = $("#codigoCargoUpd").val();
    if (codigoUnidad != "") {
        let datos = new FormData();
        datos.append("codigoUnidad", codigoUnidad);
        datos.append("codigoCargo", codigoCargo);
        $.ajax({
            url: "index.php?r=Filiacion/asignaciones/listar-items-ajax",
            method: "POST",
            dataType: 'html',
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $("#nroItemUpd").empty().append(respuesta);
                $("#nroItemUpd").prop("disabled", false);
            }
        });
    } else {
        $("#nroItemUpd").empty().append("<option value=''>Selecionar Cargo</option>");
        $("#nroItemUpd").prop("disabled", false);
    }
});

/*=============================================
SELECCIONAR CARGO
=============================================*/
$("#codigoCargoNew").change(function () {
    let codigoCargo = $(this).val();
    let codigUnidad = $("#codigoUnidadNew").val();
    if (codigoCargo != "" || codigUnidad != "") {
        let datos = new FormData();
        datos.append("codigoCargo", codigoCargo);
        datos.append("codigoUnidad", codigUnidad);
        $.ajax({
            url: "index.php?r=Filiacion/asignaciones/listar-items-ajax",
            method: "POST",
            dataType: 'html',
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $("#nroItemNew").empty().append(respuesta);
                $("#nroItemNew").prop("disabled", false);
                //$(".entrada-datos3").show();
                $(".entrada-datos4").show();
                $(".entrada-datos5").show();
            }
        });
    } else {
        $("#nroItemNew").empty().append("<option value=''>Selecionar Cargo</option>");
        $("#nroItemUpd").prop("disabled", false);
        $(".entrada-datos4").show();
        $(".entrada-datos5").show();
    }
});

$("#codigoCargoUpd").change(function () {
    let codigoCargo = $(this).val();
    let codigUnidad = $("#codigoUnidadUpd").val();
    if (codigoCargo != "" || codigUnidad != "") {
        let datos = new FormData();
        datos.append("codigoCargo", codigoCargo);
        datos.append("codigoUnidad", codigUnidad);
        $.ajax({
            url: "index.php?r=Filiacion/asignaciones/listar-items-ajax",
            method: "POST",
            dataType: 'html',
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $("#nroItemUpd").empty().append(respuesta);
                $("#nroItemUpd").prop("disabled", false);
            }
        });
    } else {
        $("#nroItemUpd").empty().append("<option value=''>Selecionar Cargo</option>");
        $("#nroItemUpd").prop("disabled", false);
    }
});

/*=============================================
SELECCIONAR ITEM
=============================================*/
$(".nroItem").change(function () {
    let nroItem = $(this).val();
    if (nroItem != "") {
        let datos = new FormData();
        $(".entrada-datos5").show();
        datos.append("nroItem", nroItem);
    } else {
        $(".entrada-datos5").show();
    }
});

/*=============================================
CREAR NUEVO ITEM
==============================================*/
$("#btnCrearItemNew").click(function () {
    window.location = "index.php?r=items/index";
});


$("#btnCrearItemUpd").click(function () {
    window.location = "index.php?r=items/index";
});

/*=============================================
CREAR ASIGNACION
=============================================*/
$("#btnMostrarCrearAsignacion").click(function () {
    $("#codigoUnidadNew").select2({
        ajax: {
            url: 'index.php?r=Administracion/items/listar-unidades-ajax',
            type: "POST",
            dataType: 'json',
            data: function (parametros) {
                return {
                    search: parametros.term
                };
            },
            processResults: function (data) {
                return {
                    results: data,
                };
            },
            cache: true,
        },
        placeholder: 'Seleccionar Unidad',
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });
    $("#codigoSectorTrabajoNew").val("");
    $("#codigoCondicionLaboralNew").val("");
    $("#codigoCargoNew").empty().append("<option value=''>Selecionar Cargo</option>");
    $("#codigoCargoNew").select2({});
    $("#nroItemNew").empty().append("<option value=''>Selecionar Item</option>");
    $("#nroItemNew").select2({});
    $("#codigoNivelSalarialNew").empty().append("<option value=''>Selecionar Nivel Salarial</option>");
    $("#codigoNivelSalarialNew").select2({});
    $("#fechaInicioNew").val("");
    $("#fechaFinNew").val("");
    $("#jefaturaNew").val("");
    $("#nroDocumentoNew").val("");
    $("#fechaDocumentoNew").val("");
    $("#tipoDocumentoNew").val("");
    $("#interinatoNew").val("");
    $("#codigoTiempoTrabajoNew").val("")
});
$("#btnAgregarAsignacion").click(function () {
    let codigoTrabajador = $("#codigoTrabajadorNew").val();
    let nombreCompleto = $("#nombreCompletoNew").val();
    //let codigoUnidad = $("#codigoUnidadNew").val();
    let codigoSector = $("#codigoSectorTrabajoNew").val();
    let codigoCondicion = $("#codigoCondicionLaboralNew").val();
    //let codigoCargo = $("#codigoCargoNew").val();
    let nroItem = $("#nroItemNew").val();
    let nivel = $("#codigoNivelSalarialNew").val();
    let fechaInicio = $("#fechaInicioNew").val();
    let fechaFin = $("#fechaFinNew").val();
    let jefatura = $("#jefaturaNew").val();
    let nroDocumento = $("#nroDocumentoNew").val();
    let fechaDocumento = $("#fechaDocumentoNew").val();
    let tipoDocumento = $("#tipoDocumentoNew").val();
    let interinato = $("#interinatoNew").val();
    let codigoTiempoTrabajo = $("#codigoTiempoTrabajoNew").val();
    let datos = new FormData();
    datos.append("codigotrabajador", codigoTrabajador);
    datos.append("nombre", nombreCompleto);
    //datos.append("codigounidad", codigoUnidad);
    datos.append("codigosector", codigoSector);
    datos.append("codigocondicionlaboral", codigoCondicion);
    //datos.append("codigocargo", codigoCargo);
    datos.append("nroitem", nroItem);
    datos.append("codigonivelsalarial", nivel);
    datos.append("fechainicio", fechaInicio);
    datos.append("fechafin", fechaFin);
    datos.append("jefatura", jefatura);
    datos.append("nrodocumento", nroDocumento);
    datos.append("fechadocumento", fechaDocumento);
    datos.append("codigotipodocumento", tipoDocumento);
    datos.append("interinato", interinato);
    datos.append("codigotiempotrabajo", codigoTiempoTrabajo);
    $.ajax({
        url: "index.php?r=Filiacion/asignaciones/crear-asignacion-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            if (respuesta === "ok") {
                //$("#modalCrearAsignacion").modal('hide');
                $("#vistaAsignaciones").show(300);
                $("#vistaTrabajadores").hide(300);
                $("#vistaCrearAsignacionTrabajador").hide(300);
                Swal.fire({
                    icon: "success",
                    title: "Creación Completada",
                    //text: "Se ha registrado la Asignación del trabajador " + nombreCompleto + " en el item " + nroItem + " con el cargo de " + codigoCargo + " en la unidad de " + codigoUnidad + ".",
                    text: "Se ha registrado la Asignación del trabajador " + nombreCompleto + " en el item " + nroItem + ".",
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Cerrar"
                }).then(function () {
                    $(".tablaAsignaciones").DataTable().ajax.reload();
                });
            }
            else {
                let mensaje;
                if (respuesta === "existe") {
                    mensaje = "La Asignacion del trabajador con código " + codigoTrabajador + " ya existe o la persona ya tiene un código de trabajador asignado. Ingrese otro código.";
                } else if (respuesta === "error") {
                    mensaje = "Ocurrio un error la asignacion. Comuniquese con el administrador del sistema.";
                } else if (respuesta === "errorCondicionLaboral") {
                    mensaje = "Error: Debe ingresar la condicion laboral.";
                } else if (respuesta === "errorUnidad") {
                    mensaje = "Error: Debe seleccionar la unidad.";
                } else if (respuesta === "errorCargo") {
                    mensaje = "Error: Debe seleccionar el cargo.";
                } else if (respuesta === "errorItem") {
                    mensaje = "Error: Debe seleccionar el Item.";
                } else if (respuesta === "errorNivel") {
                    mensaje = "Error: Debe seleccionar el nivel salarial.";
                } else if (respuesta === "errorFechaInicio") {
                    mensaje = "Error: Debe seleccionar la fecha de inicio.";
                } else if (respuesta === "errorFechaInicio") {
                    mensaje = "Error: Debe seleccionar la fecha de inicio.";
                } else if (respuesta === "errorFechaFin") {
                    mensaje = "Error: La fecha fin no debe ser menor a la fecha inicio.";
                } else if (respuesta === "errorJefatura") {
                    mensaje = "Error: Debe seleccionar la jefatura.";
                } else if (respuesta === "errorNroDocumento") {
                    mensaje = "Error: Debe llenar el nro de documento.";
                } else if (respuesta === "errorTipoDocumento") {
                    mensaje = "Error: Debe seleccionar el tipo de documento.";
                }
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: mensaje,
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Cerrar"
                }).then(function () {
                    //acciones
                });
            }
        }
    });
});

/*=============================================
EDITAR ASIGNACION
=============================================*/
$(".tablaAsignaciones tbody").on("click", ".btnEditarAsignacion", function () {
    let codigo = $(this).attr("codigo");
    let datos = new FormData();
    datos.append("codigoeditar", codigo);
    $.ajax({
        url: "index.php?r=Filiacion/asignaciones/buscar-asignacion-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            if (respuesta != "error") {
                $("#codigoAsignacionUpd").val(respuesta["CodigoAsignacion"]);
                $("#idPersonaUpd").val(respuesta["IdPersona"]);
                $("#nombreCompletoUpd").val(respuesta["NombreCompleto"]);
                $("#codigoTrabajadorUpd").val(respuesta["CodigoTrabajador"]);
                $("#codigoSectorTrabajoUpd").val(respuesta["CodigoSectorTrabajo"]);
                let codigoCondicionLaboral = respuesta["CodigoCondicionLaboral"];
                let tipoDocumento = respuesta["NombreTipoDocumento"];
                let trabajador =  respuesta["CodigoTrabajador"];
                let nroDocumento = respuesta["NroDocumento"];
                datos = new FormData();
                datos.append("codigosectortrabajo", respuesta["CodigoSectorTrabajo"]);
                $.ajax({
                    url: "index.php?r=Filiacion/asignaciones/listar-condiciones-laborales-ajax",
                    method: "POST",
                    dataType: 'html',
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (respuesta) {
                        $("#codigoCondicionLaboralUpd").select2({
                            tags: true
                        });
                        $("#codigoCondicionLaboralUpd").empty().append(respuesta);
                        $("#codigoCondicionLaboralUpd").val(codigoCondicionLaboral);
                    }
                });
                $("#codigoSectorTrabajoUpd").val(respuesta["CodigoSectorTrabajo"]);
                let codigoCargo = respuesta["CodigoCargo"];
                datos = new FormData();
                datos.append("codigosectortrabajo", respuesta["CodigoSectorTrabajo"]);
                datos.append("codigounidad", respuesta["CodigoUnidad"]);
                $.ajax({
                    url: "index.php?r=Filiacion/asignaciones/listar-cargos-ajax",
                    method: "POST",
                    dataType: 'html',
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (respuesta) {
                        $("#codigoCargoUpd").select2({
                            tags: true
                        });
                        $("#codigoCargoUpd").empty().append(respuesta);
                        $("#codigoCargoUpd").val(codigoCargo);
                    }
                });
                $("#codigoSectorTrabajoUpd").val(respuesta["CodigoSectorTrabajo"]);
                let codigoNivelSalarial = respuesta["CodigoNivelSalarial"];
                datos = new FormData();
                datos.append("codigosectortrabajo", respuesta["CodigoSectorTrabajo"]);
                $.ajax({
                    url: "index.php?r=Filiacion/asignaciones/listar-niveles-salariales-ajax",
                    method: "POST",
                    dataType: 'html',
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (respuesta) {
                        $("#codigoNivelSalarialUpd").select2({
                            tags: true
                        });
                        $("#codigoNivelSalarialUpd").empty().append(respuesta);
                        $("#codigoNivelSalarialUpd").val(codigoNivelSalarial);
                    }
                });
                $("#nombreUnidadUpd").val(respuesta["NombreUnidad"] + "/" +respuesta["NombreUnidadPadre"]);
                $("#codigoUnidadUpd").select2({
                    tags: true,
                    ajax: {
                        url: 'index.php?r=Filiacion/asignaciones/listar-unidades-ajax',
                        type: "POST",
                        dataType: 'json',
                        data: function (parametros) {
                            return {
                                search: parametros.term
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data,
                            };
                        },
                        cache: true,
                    },
                    placeholder: 'Seleccionar Unidad',
                    templateResult: formatRepo,
                    templateSelection: formatRepoSelection
                });
                $("#codigoUnidadUpd").val(respuesta["CodigoUnidad"]);
                let nroItem = respuesta["NroItem"];
                datos = new FormData();
                datos.append("codigoUnidad", respuesta["CodigoUnidad"]);
                datos.append("codigoCargo", respuesta["CodigoCargo"]);
                $.ajax({
                    url: "index.php?r=Filiacion/asignaciones/listar-items-ajax",
                    method: "POST",
                    dataType: 'html',
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (respuesta) {
                        $("#nroItemUpd").select2({
                            tags: true
                        });
                        $("#nroItemUpd").empty().append(respuesta);
                        $("#nroItemUpd").val(nroItem);
                    }
                });
                $("#fechaInicioUpd").val(respuesta["FechaInicio"]);
                $("#fechaFinUpd").val(respuesta["FechaFin"]);
                $("#jefaturaUpd").val(respuesta["Jefatura"]);
                $("#nroDocumentoUpd").val(respuesta["NroDocumento"]);
                $("#fechaDocumentoUpd").val(respuesta["FechaDocumento"]);
                $("#tipoDocumentoUpd").val(respuesta["CodigoTipoDocumento"]);
                $("#nombreTipoDocumentoUpd").val(respuesta["NombreTipoDocumento"]);
                $("#interinatoUpd").val(respuesta["Interinato"]);
                $("#codigoTiempoTrabajoUpd").val(respuesta["CodigoTiempoTrabajo"]);
                let nombreImagen =  tipoDocumento.replace(/ /g,"")  + "_" + trabajador.replace(/ /g,"") + "_" + codigoCondicionLaboral + "_" +  nroDocumento.replace('/','-') + "." + "jpeg";
                $("#imagenAsignacionUpd").attr("src","/urrhhsoft/backend/web/img/asignaciones/" + nombreImagen );
            }
            else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "Ocurrio un error al cargar los datos de la asignacion con código " + codigo + ". Comuniquese con el administrador del sistema.",
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Cerrar'
                }).then(function () {
                    $('#modalActualizarAsignacion').modal('hide');
                });
            }
        }
    });
});
/*=============================================
ACTUALIZAR ASIGNACION
=============================================*/
$("#btnActualizarAsignacion").click(function () {
    let codigo = $("#codigoAsignacionUpd").val();
    let trabajador = $("#codigoTrabajadorUpd").val();
    let unidad = $("#codigoUnidadUpd").val();
    let condicionLaboral = $("#codigoCondicionLaboralUpd").val();
    let cargo = $("#codigoCargoUpd").val();
    let item = $("#nroItemUpd").val();
    let nivelSalarial = $("#codigoNivelSalarialUpd").val();
    let fechaInicio = $("#fechaInicioUpd").val();
    let fechaFin = $("#fechaFinUpd").val();
    let jefatura = $("#jefaturaUpd").val();
    let nroDocumneto = $("#nroDocumentoUpd").val();
    let fechaDocumento = $("#fechaDocumentoUpd").val();
    let tipoDocumento = $("#tipoDocumentoUpd").val();
    let interinato = $("#interinatoUpd").val();
    let codigoTiempoTrabajo = $("#codigoTiempoTrabajoUpd").val();
    let datos = new FormData();
    datos.append("codigoasignacion", codigo);
    datos.append("codigotrabajador", trabajador);
    datos.append("codigounidad", unidad);
    datos.append("codigocondicionlaboral", condicionLaboral);
    datos.append("codigocargo", cargo);
    datos.append("nroitem", item);
    datos.append("codigonivelsalarial", nivelSalarial);
    datos.append("fechainicio", fechaInicio);
    datos.append("fechafin", fechaFin);
    datos.append("jefatura", jefatura);
    datos.append("nrodocumento", nroDocumneto);
    datos.append("fechadocumento", fechaDocumento);
    datos.append("codigotipodocumento", tipoDocumento);
    datos.append("interinato", interinato);
    datos.append("codigotiempotrabajo", codigoTiempoTrabajo);
    $.ajax({
        url: "index.php?r=Filiacion/asignaciones/actualizar-asignacion-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            if (respuesta === "ok") {
                $("#modalActualizarAsignacion").modal('hide');
                Swal.fire({
                    icon: "success",
                    title: "Actualización Completada",
                    text: "Los datos de la asignacion de la persona  ha sido guardado correctamente con el código .",
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Cerrar"
                }).then(function () {
                    $(".tablaAsignaciones").DataTable().ajax.reload(null, false);
                });
            }
            else {
                let mensaje;
                if (respuesta === "existe") {
                    mensaje = "El trabajador con código de asignacion " + codigo + " ya existe o la persona ya tiene un código de trabajador asignado. Ingrese otro código.";
                } else if (respuesta === "error") {
                    mensaje = "Ocurrio un error la asignacion. Comuniquese con el administrador del sistema.";
                } else if (respuesta === "errorCondicionLaboral") {
                    mensaje = "Error: Debe ingresar la condicion laboral.";
                } else if (respuesta === "errorUnidad") {
                    mensaje = "Error: Debe seleccionar la unidad.";
                } else if (respuesta === "errorCargo") {
                    mensaje = "Error: Debe seleccionar el cargo.";
                } else if (respuesta === "errorItem") {
                    mensaje = "Error: Debe seleccionar el Item.";
                } else if (respuesta === "errorNivel") {
                    mensaje = "Error: Debe seleccionar el nivel salarial.";
                } else if (respuesta === "errorFechaInicio") {
                    mensaje = "Error: Debe seleccionar la fecha de inicio.";
                } else if (respuesta === "errorFechaInicio") {
                    mensaje = "Error: Debe seleccionar la fecha de inicio.";
                } else if (respuesta === "errorFechaFin") {
                    mensaje = "Error: La fecha fin no debe ser menor a la fecha inicio.";
                } else if (respuesta === "errorJefatura") {
                    mensaje = "Error: Debe seleccionar la jefatura.";
                } else if (respuesta === "errorNroDocumento") {
                    mensaje = "Error: Debe llenar el nro de documento.";
                } else if (respuesta === "errorTipoDocumento") {
                    mensaje = "Error: Debe seleccionar el tipo de documento.";
                }
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: mensaje,
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Cerrar"
                }).then(function () {
                    //acciones
                });
            }
        }
    });
});
/*=============================================
ELIMINAR ASIGNACION
=============================================*/
$(".tablaAsignaciones tbody").on("click", ".btnEliminarAsignacion", function () {
    let codigo = $(this).attr("codigo");
    let nombre = $(this).attr("nombre");
    let datos = new FormData();
    datos.append("codigoeliminar", codigo);
    Swal.fire({
        icon: "warning",
        title: "Confirmación eliminación",
        text: "¿Está seguro de borrar el registro de la asignacion del trabajador ?",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        confirmButtonText: 'Borrar',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar'
    }).then(function (resultado) {
        if (resultado.value) {
            $.ajax({
                url: "index.php?r=Filiacion/asignaciones/eliminar-asignacion-ajax",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    if (respuesta === "ok") {
                        Swal.fire({
                            icon: "success",
                            title: "Eliminación Completada",
                            text: "El registro del trabajador " + nombre + "con la asignacion " + codigo + " ha sido borrado correctamente.",
                            showCancelButton: false,
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Cerrar"
                        }).then(function () {
                            $(".tablaAsignaciones").DataTable().ajax.reload();
                        });
                    }
                    else {
                        let mensaje;
                        if (respuesta === "enUso") {
                            mensaje = "No se puede eliminar la asignacion al trabajador  " + nombre + " con código " + codigo + ", ya que está en uso actualmente y no puede ser eliminado. Solo puede ser inhabilitado.";
                        } else {
                            mensaje = "Ocurrio un error al eliminar el registro de la asignacion del trabajador con código " + codigo + ". Comuniquese con el administrador del sistema."
                        }
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: mensaje,
                            showCancelButton: false,
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Cerrar"
                        }).then(function () {
                            //acciones
                        });
                    }
                }
            });
        }
    });
});

/*=============================================
SUBIR IMAGEN
=============================================*/
$("#uploadNew").on('click', function () {
    let datos = new FormData();
    let codigoTrabajador = $("#codigoTrabajadorNew").val();
    let documento = $("#nroDocumentoNew").val();
    let tipoDocumento = $("#tipoDocumentoNew option:selected").text();
    let codigoCondicionLaboral = $("#codigoCondicionLaboralNew").val();
    let files = $('#imagenNew')[0].files[0];
    datos.append('file', files);
    datos.append("codigoTrabajador", codigoTrabajador);
    datos.append("documento", documento);
    datos.append("tipoDocumento", tipoDocumento);
    datos.append("codigoCondicionLaboral", codigoCondicionLaboral);
    $.ajax({
        url: 'index.php?r=Filiacion/asignaciones/subir-archivos-ajax',
        type: 'post',
        data: datos,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response != 'errorFormato') {
                $(".card-img-top").attr("src", response);
                if (response != 'errorTamaño') {
                    $(".card-img-top").attr("src", response);
                } else {
                    alert('Tamaño de imagen incorrecto.');
                }
            } else {
                alert('Formato de imagen incorrecto.');
            }
        }
    });
    return false;
});

$("#uploadUpd").on('click', function () {
    let datos = new FormData();
    let codigoTrabajador = $("#codigoTrabajadorUpd").val();
    let documento = $("#nroDocumentoUpd").val();
    let tipoDocumento = $("#tipoDocumentoUpd option:selected").text();
    let codigoCondicionLaboral = $("#codigoCondicionLaboralUpd").val();
    let files = $('#imagenUpd')[0].files[0];
    datos.append('file', files);
    datos.append("codigoTrabajador", codigoTrabajador);
    datos.append("documento", documento);
    datos.append("tipoDocumento", tipoDocumento);
    datos.append("codigoCondicionLaboral", codigoCondicionLaboral);
    $.ajax({
        url: 'index.php?r=Filiacion/asignaciones/subir-archivos-ajax',
        type: 'post',
        data: datos,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response != 'errorFormato') {
                $(".card-img-top").attr("src", response);
                if (response != 'errorTamaño') {
                    $(".card-img-top").attr("src", response);
                } else {
                    alert('Tamaño de imagen incorrecto.');
                }
            } else {
                alert('Formato de imagen incorrecto.');
            }
        }
    });
    return false;
});

/*=============================================
MOSTRAR IMAGEN
=============================================*/
$(".tablaAsignaciones tbody").on("click", ".btnVerImagen", function () {
    let objectBtn = $(this);
    let codigoTrabajador = objectBtn.attr("codigoTrabajador");
    let documento = objectBtn.attr("documento");
    let tipoDocumento = objectBtn.attr("tipoDocumento");
    let sectorTrabajo = objectBtn.attr("sectorTrabajo");
    let datos = new FormData();
    datos.append("codigoTrabajador", codigoTrabajador);
    datos.append("documento", documento);
    datos.append("tipoDocumento", tipoDocumento);
    datos.append("codigoCondicionLaboral", sectorTrabajo);
    $.ajax({
        url: 'index.php?r=Filiacion/asignaciones/mostrar-archivos-ajax',
        type: 'post',
        data: datos,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response != 'errorNombre') {
                $("#mostrarMemo").attr("src", response);
            } else {
                $("#mostrarMemo").attr("src", src);
            }
        }
    });
});

$("#btnVerImagen").click(function (){
    let codigoTrabajador = $("#codigoTrabajadorUpd").val();
    let documento = $("#nroDocumentoUpd").val();
    let tipoDocumento = $("#nombreTipoDocumentoUpd").val();
    let sectorTrabajo = $("#codigoCondicionLaboralUpd").val(    );
    let datos = new FormData();
    datos.append("codigoTrabajador", codigoTrabajador);
    datos.append("documento", documento);
    datos.append("nombreTipoDocumento", tipoDocumento);
    datos.append("tipoDocumento", tipoDocumento);
    datos.append("codigoCondicionLaboral", sectorTrabajo);
    $.ajax({
        url: 'index.php?r=Filiacion/asignaciones/mostrar-archivos-ajax',
        type: 'post',
        data: datos,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response != 'errorNombre') {
                $("#mostrarMemoUpd").attr("src", response);
            } else {
                $("#mostrarMemoUpd").attr("src", src);
            }
        }
    });
});

/*=============================================
ELIMINAR IMAGEN
=============================================*/
$("#btnEliminarImagen").click(function () {
    let codigoTrabajador = $("#codigoTrabajadorUpd").val();
    let documento = $("#nroDocumentoUpd").val();
    let tipoDocumento = $("#nombreTipoDocumentoUpd").val();
    let sectorTrabajo = $("#codigoCondicionLaboralUpd").val(    );
    let datos = new FormData();
    datos.append("codigoTrabajador", codigoTrabajador);
    datos.append("documento", documento);
    datos.append("nombreTipoDocumento", tipoDocumento);
    datos.append("tipoDocumento", tipoDocumento);
    datos.append("codigoCondicionLaboral", sectorTrabajo);
    $.ajax({
        url: 'index.php?r=Filiacion/asignaciones/eliminar-imagen-ajax',
        type: 'post',
        data: datos,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response != 'errorNoEliminado') {
                $("#mostrarMemoUpd").attr("src", src);
            } else {
                $("#mostrarMemoUpd").attr("src", response);
            }
        }
    });
});