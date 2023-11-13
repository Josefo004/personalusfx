$(document).ready(function () {
    $("#vistaFuncionarios").hide();
    $("#vistaCrearAdministrativoPestañas").hide();
    //$(".entrada-datos").hide();

    $("#btnCancelar").click(function () {
        $("#vistaAdministrativos").show(300);
        $("#vistaFuncionarios").hide(300);
        $("#vistaCrearAdministrativoPestañas").hide(300);
    });
});
/*=============================================
CARGAR LA TABLA DINÁMICA DE ADMINISTRATIVOS
=============================================*/
$(".tablaAdministrativos").DataTable({
    //"ajax": "index.php?r=trabajadores/listar-trabajadores-ajax",
    ajax: {
        method: "POST",
        dataType: 'json',
        cache: false,
        url: 'index.php?r=Filiacion/administrativos/listar-administrativos',
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
CARGAR LA TABLA DINÁMICA DE FUNCIONARIOS
=============================================*/
$(".tablaFuncionarios").DataTable({
    //"ajax": "index.php?r=trabajadores/listar-trabajadores-ajax",
    ajax: {
        method: "POST",
        dataType: 'json',
        cache: false,
        url: 'index.php?r=Filiacion/administrativos/listar-funcionarios',
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
ACTIVAR ADMINISTRATIVO
=============================================*/
$(".tablaAdministrativos tbody").on("click", ".btnActivar", function () {
    let objectBtn = $(this);
    let codigo = objectBtn.attr("codigo");
    let estado = objectBtn.attr("estado");
    let iditem = objectBtn.attr("iditem");
    let fechaingreso = objectBtn.attr("fechaingreso");
    let datos = new FormData();
    datos.append("codigoactivar", codigo);
    datos.append("estadoactivar", estado);
    datos.append("iditemactivar", iditem);
    datos.append("fechaingresoactivar", fechaingreso);
    $.ajax({
        url: "index.php?r=Filiacion/administrativos/activar-administrativo-ajax",
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
                    objectBtn.html('CADUCADO');
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
                    text: "Ocurrio un error al cambiar el estado del trabajador  con código " + codigo + ". Comuniquese con el administrador del sistema.",
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Cerrar'
                });
            }
        }
    });
});
/*=============================================
MOSTRAR CREAR ADMINISTRATIVO
=============================================*/
$("#btnMostrarCrearAdministrativo").click(function () {
    $("#vistaAdministrativos").hide(300);
    $("#vistaFuncionarios").show(300);
    $("#vistaCrearAdministrativoPestañas").hide(300);
});
/*=============================================
SELECCIONAR FUNCIONARIO
=============================================*/
$("#tablaFuncionarios tbody").on("click", ".btnElegir", function () {
    let objectBtn = $(this);
    let idFuncionario = objectBtn.attr("codigo");
    let idPersona = objectBtn.attr("idpersona");
    let nombre = objectBtn.attr("nombre");
    let sectortrabajo = objectBtn.attr("sectortrabajo");
    $("#vistaAdministrativos").hide(300);
    $("#vistaFuncionarios").hide(300);
    $("#vistaCrearAdministrativoPestañas").show(300);
    $("#idFuncionarioNew").val(idFuncionario);
    $("#idPersonaNew").val(idPersona);
    $("#nombreCompletoNew").val(nombre);
    $("#codigoSectorTrabajoNew").val(sectortrabajo);
    let datos = new FormData();
    datos.append("idfuncionario", idFuncionario);
});
/*=============================================
SELECCIONAR SECTOR TRABAJO
=============================================*/
$(".codigoSectorTrabajo").change(function () {
    let sector = $(this).val();
    if (sector != "") {
        let datos = new FormData();
        datos.append("codigosectortrabajo", sector);
        $.ajax({
            url: "index.php?r=Filiacion/administrativos/listar-condiciones-laborales-ajax",
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
                $("#codigoNivelSalarialNew").empty().append("<option value=''>Selecionar Nivel Salarial</option>");
                $("#codigoNivelSalarialNew").select2({});
                $("#codigoCargoNew").empty().append("<option value=''>Selecionar Cargo</option>");
                $("#codigoCargoNew").select2({});
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
        $.ajax({
            url: "index.php?r=Filiacion/administrativos/listar-niveles-salariales-ajax",
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
    if (sector != "") {
        let datos = new FormData();
        datos.append("codigosectortrabajo", sector);
        $.ajax({
            url: "index.php?r=Filiacion/administrativos/listar-cargos-ajax",
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
});
/*=============================================
SELECCIONAR CONDICION LABORAL
=============================================*/
$(".codigoCondicionLaboral").change(function () {
    let codigoCondicionLaboral = $("#codigoSectorTrabajoNew").val();//$(this).val();
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
SELECCIONAR CARGO
=============================================*/
$(".codigoCargo").change(function () {
    let codigoCargo = $(this).val();
    //let codigUnidad = $("#codigoUnidadNew").val();
    if (codigoCargo != "" || codigUnidad != "") {
        let datos = new FormData();
        datos.append("codigoCargo", codigoCargo);
        //datos.append("codigoUnidad", codigUnidad);
        $.ajax({
            url: "index.php?r=Filiacion/administrativos/listar-items-ajax",
            method: "POST",
            dataType: 'html',
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $(".nroItem").empty().append(respuesta);
                $(".nroItem").prop("disabled", false);
                //$(".entrada-datos3").show();
                $(".entrada-datos4").show();
                $(".entrada-datos5").show();
            }
        });
    } else {
        $(".nroItem").empty().append("<option value=''>Selecionar Cargo</option>");
        $(".nroItem").prop("disabled", false);
        $(".entrada-datos4").show();
        $(".entrada-datos5").show();
    }
});
/*=============================================
CREAR ADMINISTRATIVO
=============================================*/
$("#btnCrearAdministrativo").click(function () {
    let idFuncionario = $("#idFuncionarioNew").val();
    let nombreCompleto = $("#nombreCompletoNew").val();
    let idItem = $("#idItemNew").val();
    let fechaIngreso = $("#fechaIngresoNew").val();
    let codigoNivelsalarial = $("#codigoNivelSalarialNew").val();
    let codigoCondicionLaboral = $("#codigoCondicionLaboralNew").val();
    let fechaSalida = $("#fechaSalidaNew").val();
    let nroMemorando = $("#nroMemorandoNew").val();
    let codigoTiempoTrabajo = $("#codigoTiempoTrabajoNew").val();
    let observaciones = $("#observacionesNew").val();
    let datos = new FormData();
    datos.append("idfuncionariocrear", idFuncionario);
    datos.append("iditemcrear", idItem);
    datos.append("fechaingresocrear", fechaIngreso);
    datos.append("codigonivelsalarialcrear", codigoNivelsalarial);
    datos.append("codigocondicionlaboralcrear", codigoCondicionLaboral);
    datos.append("fechasalidacrear", fechaSalida);
    datos.append("nromemorandocrear", nroMemorando);
    datos.append("codigotiempotrabajocrear", codigoTiempoTrabajo);
    datos.append("observacionescrear", observaciones);
    $.ajax({
        url: "index.php?r=Filiacion/administrativos/crear-administrativo-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            if (respuesta === "ok") {
                $("#vistaAdministrativos").show(300);
                $("#vistaFuncionarios").hide(300);
                $("#vistaCrearAdministrativoPestañas").hide(300);
                Swal.fire({
                    icon: "success",
                    title: "Creación Completada",
                    text: "Los datos de trabajador de la persona " + nombreCompleto + " con IfFuncionario " + idFuncionario + "ha sido guardado correctamente.",
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Cerrar"
                }).then(function () {
                    $("#tablaAdministrativos").DataTable().ajax.reload();
                });
            }
            else {
                let mensaje;
                if (respuesta === "existe") {
                    mensaje = "El funcionario con IdFuncionario " + idFuncionario + " ya existe o la persona ya tiene un código de trabajador asignado. Ingrese otro código.";
                } else {
                    mensaje = "Ocurrio un error al crear los datos de trabajador de la persona " + nombreCompleto + ". Comuniquese con el administrador del sistema.";
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
EDITAR ADMINISTRATIVO
=============================================*/
$(".tablaAdministrativos tbody").on("click", ".btnEditarAdministrativo", function () {
    let codigo = $(this).attr("codigo");
    let idpersona = $(this).attr("idpersona");
    let nombrecompleto = $(this).attr("nombrecompleto");
    let iditem = $(this).attr("iditem");
    let fechaingreso = $(this).attr("fechaingreso");
    //let codigosectortrabajo = $(this).attr("sectortrabajo");
    let datos = new FormData();
    datos.append("codigoeditar", codigo);
    datos.append("idpersonaeditar", idpersona);
    datos.append("nombrecompletoeditar", nombrecompleto);
    datos.append("iditemeditar", iditem);
    datos.append("fechaingresoeditar", fechaingreso);
    //datos.append("sectortrabajoeditar", codigosectortrabajo);
    $.ajax({
        url: "index.php?r=Filiacion/administrativos/buscar-administrativo-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            if (respuesta != "error") {
                $(".entrada-datos").show();
                $("#idFuncionarioUpd").val(respuesta["IdFuncionario"]);
                $("#idPersonaUpd").val(respuesta["IdPersona"]);
                $("#nombreCompletoUpd").val(respuesta["NombreCompleto"]);
                $("#codigoSectorTrabajoUpd").val(respuesta["CodigoSectorTrabajo"]);
                let codigoCondicionLaboral = respuesta["CodigoCondicionLaboral"];
                datos.append("codigosectortrabajo", respuesta["CodigoSectorTrabajo"]);
                $.ajax({
                    url: "index.php?r=Filiacion/administrativos/listar-condiciones-laborales-ajax",
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
                $.ajax({
                    url: "index.php?r=Filiacion/administrativos/listar-cargos-ajax",
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
                    url: "index.php?r=Filiacion/administrativos/listar-niveles-salariales-ajax",
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
                $("#codigoCargoUpd").val(respuesta["CodigoCargo"]);
                let idItem = respuesta["IdItem"];
                datos = new FormData();
                //datos.append("codigoUnidad", respuesta["CodigoUnidad"]);
                datos.append("codigoCargo", respuesta["CodigoCargo"]);
                $.ajax({
                    url: "index.php?r=Filiacion/administrativos/listar-items-ajax",
                    method: "POST",
                    dataType: 'html',
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (respuesta) {
                        $("#idItemUpd").select2({
                            tags: true
                        });
                        $("#idItemUpd").empty().append(respuesta);
                        $("#idItemUpd").val(idItem);
                    }
                });
                //$("#idItemUpd").val(respuesta["IdItem"]);
                $("#fechaIngresoUpd").val(respuesta["FechaIngreso"]);
                //$("#codigoCondicionLaboralUpd").val(respuesta["CodigoCondicionLaboral"]);
                $("#fechaSalidaUpd").val(respuesta["FechaSalida"]);
                $("#nroMemorandoUpd").val(respuesta["NroMemorando"]);
                $("#codigoTiempoTrabajoUpd").val(respuesta["CodigoTiempoTrabajo"]);
                $("#observacionesUpd").val(respuesta["Observaciones"]);

            }
            else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "Ocurrio un error al cargar los datos del Admiistrativo con C.I." + idpersona + "  . Comuniquese con el administrador del sistema.",
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Cerrar'
                }).then(function () {
                    $('#modalActualizarAdministrativo').modal('hide');
                });
            }
        }
    });
});
/*=============================================
ACTUALIZAR TRABAJADOR
=============================================*/
$("#btnActualizarAdministrativo").click(function () {
    let idFuncionario = $("#idFuncionarioUpd").val();
    let nombreCompleto = $("#nombreCompletoUpd").val();
    let idItem = $("#idItemUpd").val();
    let fechaIngreso = $("#fechaIngresoUpd").val();
    let codigoNivelsalarial = $("#codigoNivelSalarialUpd").val();
    let codigoCondicionLaboral = $("#codigoCondicionLaboralUpd").val();
    let fechaSalida = $("#fechaSalidaUpd").val();
    let nroMemorando = $("#nroMemorandoUpd").val();
    let codigoTiempoTrabajo = $("#codigoTiempoTrabajoUpd").val();
    let observaciones = $("#observacionesUpd").val();
    let datos = new FormData();
    datos.append("idfuncionarioactualizar", idFuncionario);
    datos.append("iditemactualizar", idItem);
    datos.append("fechaingresoactualizar", fechaIngreso);
    datos.append("codigonivelsalarialactualizar", codigoNivelsalarial);
    datos.append("codigocondicionlaboralactualizar", codigoCondicionLaboral);
    datos.append("fechasalidaactualizar", fechaSalida);
    datos.append("nromemorandocrear", nroMemorando);
    datos.append("codigotiempotrabajoactualizar", codigoTiempoTrabajo);
    datos.append("observacionesactualizar", observaciones);
    $.ajax({
        url: "index.php?r=Filiacion/administrativos/actualizar-administrativo-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            if (respuesta === "ok") {
                $("#modalActualizarAdministrativo").modal('hide');
                Swal.fire({
                    icon: "success",
                    title: "Actualización Completada",
                    text: "Los datos de trabajador de la persona " + nombreCompleto + " ha sido guardado correctamente .",
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Cerrar"
                }).then(function () {
                    $("#tablaAdministrativos").DataTable().ajax.reload(null, false);
                });
            }
            else {
                let mensaje;
                if (respuesta === "existe") {
                    mensaje = "El trabajador con código " + idFuncionario + " ya existe o la persona ya tiene un código de trabajador asignado. Ingrese otro código.";
                } else {
                    mensaje = "Ocurrio un error al actualizar los datos de trabajador de la persona " + nombreCompleto + ". Comuniquese con el administrador del sistema.";
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
ELIMINAR ADMINISTRATIVO
=============================================
$(".tablaAdministrativos tbody").on("click", ".btnEliminarAdministrativo", function () {
    let codigo = $(this).attr("codigo");
    let nombre = $(this).attr("nombre");
    let datos = new FormData();
    datos.append("codigoeliminar", codigo);
    Swal.fire({
        icon: "warning",
        title: "Confirmación eliminación",
        text: "¿Está seguro de borrar el registro del trabajador " + nombre + "?",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        confirmButtonText: 'Borrar',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar'
    }).then(function(resultado){
        if (resultado.value) {
            $.ajax({
                url: "index.php?r=Filiacion/administrativos/eliminar-administrativo-ajax",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    if (respuesta === "ok"){
                        Swal.fire({
                            icon: "success",
                            title: "Eliminación Completada",
                            text: "El registro del trabajador " + nombre + "con código " + codigo + " ha sido borrado correctamente.",
                            showCancelButton: false,
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Cerrar"
                        }).then(function(){
                            $(".tablaAdministrativos").DataTable().ajax.reload();
                        });
                    }
                    else{
                        let mensaje;
                        if(respuesta === "enUso"){
                            mensaje = "No se puede eliminar al trabajador  " + nombre + " con código " + codigo + ", ya que está en uso actualmente y no puede ser eliminado. Solo puede ser inhabilitado.";
                        }else{
                            mensaje = "Ocurrio un error al eliminar el registro del trabajador con código " + codigo + ". Comuniquese con el administrador del sistema."
                        }
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: mensaje,
                            showCancelButton: false,
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Cerrar"
                        }).then(function(){
                            //acciones
                        });
                    }
                }
            });
        }
    });
});*/