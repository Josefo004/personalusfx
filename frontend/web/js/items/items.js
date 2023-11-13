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
CARGAR LA TABLA DINÁMICA DE ITEMS
=============================================*/
$(".tablaItems").DataTable({
    ajax: {
        type: "POST",
        dataType: 'json',
        cache: false,
        url: 'index.php?r=Administracion/items/listar-items-ajax',
        data: {}
    },
    "deferRender": true,
    "retrieve": true,
    "processing": true,
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
ACTIVAR ITEM
=============================================*/
$(".tablaItems tbody").on("click", ".btnActivarItem", function () {
    let objectBtn = $(this);
    let nroItem = objectBtn.attr("nroitem");
    let codigoEstado = objectBtn.attr("estado");
    let datos = new FormData();
    datos.append("nroitem", nroItem);
    $.ajax({
        url: "index.php?r=Administracion/items/activar-item-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            if (respuesta === "ok") {
                if (codigoEstado == "V") {
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
                    text: "Ocurrio un error al cambiar el estado del item con nro " + nroItem + ". Comuniquese con el administrador del sistema.",
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Cerrar'
                });
            }
        }
    });
});

/*=============================================
SELECCIONAR SECTOR DE TRABAJO
=============================================*/
$("#codigoSectorTrabajoNew").change(function () {
    let codigoSectorTrabajo = $(this).val();
    let codigoUnidad = $("#codigoUnidadNew").val();
    let datos = new FormData();
    datos.append("codigosectortrabajo", codigoSectorTrabajo);
    datos.append("codigounidad", codigoUnidad);
    $.ajax({
        url: "index.php?r=Administracion/items/listar-cargos-ajax",
        method: "POST",
        dataType: 'html',
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            $("#codigoCargoNew").select2({
                tags: true
            });
            $("#codigoCargoNew").empty().append(respuesta);
            $("#codigoCargoDependenciaNew").select2({
                tags: true
            });
            $("#codigoCargoDependenciaNew").empty().append(respuesta);
        }
    });
});

/*=============================================
CREAR ITEM
=============================================*/
$("#btnMostrarCrearItem").click(function () {
    $("#codigoSectorTrabajoNew").val("");
    //$("#codigoUnidadNew").val("");
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
    $("#nroItemPlanillasNew").val("");
    $("#nroItemRrhhNew").val("");
});
$("#btnCrearItem").click(function () {
    let nroItemPlanillas = $("#nroItemPlanillasNew").val();
    let nroItemRrhh = $("#nroItemRrhhNew").val();
    let codigoSectorTrabajo = $("#codigoSectorTrabajoNew").val();
    let codigoCargo = $("#codigoCargoNew").val();
    let codigoCargoDependencia = $("#codigoCargoDependenciaNew").val();
    let codigoUnidad = $("#codigoUnidadNew").val();
    let datos = new FormData();
    datos.append("nroitemplanillas", nroItemPlanillas);
    datos.append("nroitemrrhh", nroItemRrhh);
    datos.append("codigosectortrabajo", codigoSectorTrabajo);
    datos.append("codigocargo", codigoCargo);
    datos.append("codigocargodependencia", codigoCargoDependencia);
    datos.append("codigounidad", codigoUnidad);
    $.ajax({
        url: "index.php?r=Administracion/items/crear-item-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            if (respuesta === "ok") {
                $("#modalCrearItem").modal('hide');
                Swal.fire({
                    icon: "success",
                    title: "Creación Completada",
                    text: "El item correspondiente al cargo" + codigoCargo + " en la unidad " + codigoUnidad + " ha sido guardado correctamente.",
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Cerrar"
                }).then(function () {
                    $(".tablaItems").DataTable().ajax.reload();
                });
            }
            else {
                let mensaje;
                if (respuesta === "existe") {
                    mensaje = "El item correspondiente con nro item planillas " + nroItemPlanillas + " y/o nro item RRHH " + nroItemRrhh + " ya existe. Ingrese otro nombre.";
                } else if (respuesta === "error") {
                    mensaje = "Ocurrio un error al crear el item con nro item planillas " + nroItemPlanillas + " y/o nro item RRHH " + nroItemRrhh + ". Comuniquese con el administrador del sistema."
                } else if (respuesta === "errorSectorTrabajo") {
                    mensaje = "Error: Debe seleccionar el sector de trabajo.";
                } else if (respuesta === "errorCargo") {
                    mensaje = "Error: Debe seleccionar el cargo.";
                } else if (respuesta === "errorCargoDependencia") {
                    mensaje = "Error: Debe seleccionar la dependencia del cargo.";
                } else if (respuesta === "errorUnidad") {
                    mensaje = "Error: Debe seleccionar la unidad.";
                } else if (respuesta === "errorNroItemPlanillas") {
                    mensaje = "Error: Debe ingresar el nro item de planillas.";
                } else if (respuesta === "errorNroItemRrhh") {
                    mensaje = "Error: Debe ingresar el nro item de RRHH.";
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
EDITAR ITEM
=============================================*/
$(".tablaItems tbody").on("click", ".btnEditarItem", function () {
    let nroItem = $(this).attr("nroitem");
    let datos = new FormData();
    datos.append("nroitem", nroItem);
    $.ajax({
        url: "index.php?r=Administracion/items/buscar-item-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            $("#nroItemUpd").val(respuesta["NroItem"]);
            $("#nombreSectorTrabajoUpd").val(respuesta["NombreSectorTrabajo"]);
            //$("#nombreUnidadUpd").val(respuesta["NombreUnidad"]);
            $("#nombreUnidadUpd").val(respuesta["NombreUnidad"] + "/" +respuesta["NombreUnidadPadre"]);
            $("#codigoUnidadUpd").select2({
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
                templateSelection: formatRepoSelection,
            });
            datos = new FormData();
            datos.append("codigosectortrabajo", respuesta["CodigoSectorTrabajo"]);
            datos.append("codigounidad", respuesta["CodigoUnidad"]);
            $.ajax({
                url: "index.php?r=Administracion/items/listar-cargos-ajax",
                method: "POST",
                dataType: 'html',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuestaCargos) {
                    $("#codigoCargoUpd").select2({
                        tags: true
                    });
                    $("#codigoCargoUpd").empty().append(respuestaCargos);
                    $("#codigoCargoUpd").val(respuesta["CodigoCargo"]);
                    $("#codigoCargoDependenciaUpd").select2({
                        tags: true
                    });
                    $("#codigoCargoDependenciaUpd").empty().append(respuestaCargos);
                    $("#codigoCargoDependenciaUpd").val(respuesta["CodigoCargoDependencia"]);
                }

            });
            $("#codigoUnidadUpd").select2({
                tags: true,
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
            $("#codigoUnidadUpd").val(respuesta["CodigoUnidad"]);
            $("#nroItemPlanillasUpd").val(respuesta["NroItemPlanillas"]);
            $("#nroItemRrhhUpd").val(respuesta["NroItemRrhh"]);
        },
        error: function (respuesta) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "Ocurrio un error al cargar los datos del item con número " + codigo + ". Comuniquese con el administrador del sistema.",
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Cerrar'
            }).then(function () {
                $('#modalEditarItem').modal('hide');
            });

        }
    });
});
/*=============================================
ACTUALIZAR ITEM
=============================================*/
$("#btnActualizarItem").click(function () {
    let nroItem = $("#nroItemUpd").val();
    let codigoCargo = $("#codigoCargoUpd").val();
    let codigoCargoDependencia = $("#codigoCargoDependenciaUpd").val();
    let codigoUnidad = $("#codigoUnidadUpd").val();
    let nroItemPlanillas = $("#nroItemPlanillasUpd").val();
    let nroItemRrhh = $("#nroItemRrhhUpd").val();
    let datos = new FormData();
    datos.append("nroitem", nroItem);
    datos.append("codigocargo", codigoCargo);
    datos.append("codigocargodependencia", codigoCargoDependencia);
    datos.append("codigounidad", codigoUnidad);
    datos.append("nroitemplanillas", nroItemPlanillas);
    datos.append("nroitemrrhh", nroItemRrhh);
    $.ajax({
        url: "index.php?r=Administracion/items/actualizar-item-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            if (respuesta === "ok") {
                $("#modalActualizarItem").modal('hide');
                Swal.fire({
                    icon: "success",
                    title: "Actualización Completada",
                    text: "El item " + nroItemRrhh + "/" + nroItemPlanillas + " ha sido guardado correctamente con el código " + nroItem + ".",
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Cerrar"
                }).then(function () {
                    $(".tablaItems").DataTable().ajax.reload(null, false);
                });
            }
            else {
                let mensaje;
                if (respuesta === "existe") {
                    mensaje = "El item correspondiente con nro item planillas " + nroItemPlanillas + " y/o nro item RRHH " + nroItemRrhh + " ya existe. Ingrese otro nombre.";
                } else if (respuesta === "error") {
                    mensaje = "Ocurrio un error al actualizar los datos del item con nro item planillas " + nroItemPlanillas + " y/o nro item RRHH " + nroItemRrhh + ". Comuniquese con el administrador del sistema."
                } else if (respuesta === "errorSectorTrabajo") {
                    mensaje = "Error: Debe seleccionar el sector de trabajo.";
                } else if (respuesta === "errorCargo") {
                    mensaje = "Error: Debe seleccionar el cargo.";
                } else if (respuesta === "errorCargoDependencia") {
                    mensaje = "Error: Debe seleccionar la dependencia del cargo.";
                } else if (respuesta === "errorUnidad") {
                    mensaje = "Error: Debe seleccionar la unidad.";
                } else if (respuesta === "errorNroItemPlanillas") {
                    mensaje = "Error: Debe ingresar el nro item de planillas.";
                } else if (respuesta === "errorNroItemRrhh") {
                    mensaje = "Error: Debe ingresar el nro item de RRHH.";
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
ELIMINAR ITEM
=============================================*/
$(".tablaItems tbody").on("click", ".btnEliminarItem", function () {
    let nroItem = $(this).attr("nroitem");
    let datos = new FormData();
    datos.append("nroitem", nroItem);
    Swal.fire({
        icon: "warning",
        title: "Confirmación eliminación",
        text: "¿Está seguro de borrar el item " + nroItem + "?",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        confirmButtonText: 'Borrar',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar'
    }).then(function (resultado) {
        if (resultado.value) {
            $.ajax({
                url: "index.php?r=Administracion/items/eliminar-item-ajax",
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
                            text: "El item " + nroItem + " ha sido borrado correctamente.",
                            showCancelButton: false,
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Cerrar"
                        }).then(function () {
                            $(".tablaItems").DataTable().ajax.reload();
                        });
                    }
                    else {
                        let mensaje;
                        if (respuesta === "enUso") {
                            mensaje = "No se puede eliminar el item " + nroItem + ", ya que está en uso actualmente y no puede ser eliminado. Solo puede ser inhabilitado.";
                        } else {
                            mensaje = "Ocurrio un error al eliminar el item " + nroItem + ". Comuniquese con el administrador del sistema.";
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
