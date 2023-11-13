/*=============================================
CARGAR LA TABLA DINÁMICA DE TIPOS DECLARACIONES JURADAS
=============================================*/
$(".tablaTransferenciaAdministrativo").DataTable({
    //"ajax": "index.php?r=nacionalidades/listar-nacionalidades-ajax",
    ajax: {
        method: "POST",
        dataType: 'json',
        cache: false,
        url: 'index.php?r=Filiacion/transferencia-administrativo/listar-transferencias-administrativos-ajax',
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
CREAR TRANSFERENCIA ADMINISTRATIVO
=============================================*/
$("#btnCrearTransferenciaAdministrativo").click(function () {
    let motivo = $("#motivoNew").val();
    let fechaInicioTransferencia = $("#fechaInicioTransferenciaNew").val();
    let fechaFinAsignacion = $("#fechaFinAsignacionNew").val();
    let datos = new FormData();
    datos.append("motivo", motivo);
    datos.append("fechainiciotransferencia", fechaInicioTransferencia);
    datos.append("fechafinasignacion", fechaFinAsignacion);
    $.ajax({
        url: 'index.php?r=Filiacion/transferencia-administrativo/crear-transferencia-administrativo-ajax',
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            if (respuesta === "ok") {
                $("#motivoNew").val("");
                $("#fechaInicioTransferenciaNew").val("");
                $("#fechaFinAsignacionNew").val("");
                $("#modalCrearTransferenciaAdministrativo").modal('hide');
                Swal.fire({
                    icon: "success",
                    title: "Creación Completada",
                    text: "La transferencia " + motivo + " ha sido guardado correctamente.",
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Cerrar"
                }).then(function () {
                    $(".tablaTransferenciaAdministrativo").DataTable().ajax.reload();
                });
            }
            else {
                let mensaje;
                if (respuesta === "existe") {
                    mensaje = "La transferencia " + motivo + " ya existe. Ingrese otro nombre.";
                } else {
                    mensaje = "Ocurrio un error al crear la transferencia " + motivo + ". Comuniquese con el administrador del sistema.";
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
EDITAR TRANSFERENCIA ADMINISTRATIVO
=============================================*/
$(".tablaTransferenciaAdministrativo tbody").on("click", ".btnEditarTransferenciaAdministrativo", function () {
    let codigoTransferencia = $(this).attr("codigo");
    let motivo = $(this).attr("motivo");
    let datos = new FormData();
    datos.append("codigotransferencia", codigoTransferencia);
    datos.append("motivo", motivo);
    $.ajax({
        url: 'index.php?r=Filiacion/transferencia-administrativo/buscar-transferencia-administrativo-ajax',
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            $("#codigoTransferenciaUpd").val(respuesta["CodigoTransferencia"]);
            $("#motivoUpd").val(respuesta["Motivo"]);
            $("#fechaInicioTransferenciaUpd").val(respuesta["FechaInicioTransferencia"]);
            $("#fechaFinAsignacionUpd").val(respuesta["FechaFinAsignacion"]);
        },
        error: function (respuesta) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "Ocurrio un error al cargar los datos de la transferencia " + motivo + ". Comuniquese con el administrador del sistema.",
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Cerrar'
            }).then(function () {
                $('#modalActualizarTransferenciaAdministrativo').modal('hide');
            });
        }
    });
});
/*=============================================
ACTUALIZAR TIPO DECLARACION JURADA
=============================================*/
$("#btnActualizarTransferenciaAdministrativo").click(function () {
    let codigoTransferencia = $("#codigoTransferenciaUpd").val();
    let motivo = $("#motivoUpd").val();
    let fechaInicioTransferencia = $("#fechaInicioTransferenciaUpd").val();
    let fechaFinAsignacion = $("#fechaFinAsignacionUpd").val();
    let datos = new FormData();
    datos.append("codigotransferencia", codigoTransferencia);
    datos.append("motivo", motivo);
    datos.append("fechainiciotransferencia", fechaInicioTransferencia);
    datos.append("fechafinasignacion", fechaFinAsignacion);
    $.ajax({
        url: 'index.php?r=Filiacion/transferencia-administrativo/actualizar-transferencia-administrativo-ajax',
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            if (respuesta === "ok") {
                $("#modalActualizarTransferenciaAdministrativo").modal('hide');
                Swal.fire({
                    icon: "success",
                    title: "Actualización Completada",
                    text: "La transferencia " + motivo + " ha sido guardado correctamente con el código " + codigoTransferencia + ".",
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Cerrar"
                }).then(function () {
                    $(".tablaTransferenciaAdministrativo").DataTable().ajax.reload();
                });
            }
            else {
                let mensaje;
                if (respuesta === "existe") {
                    mensaje = "La transferencia " + motivo + " ya existe. Ingrese otro nombre.";
                } else {
                    mensaje = "Ocurrio un error al actualizar los datos de la transferencia " + motivo + ". Comuniquese con el administrador del sistema.";
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
ELIMINAR TRANSFERENCIA ADMINISTRATIVO
=============================================*/
$(".tablaTransferenciaAdministrativo tbody").on("click", ".btnEliminarTransferenciaAdministrativo", function () {
    let codigoTransferencia = $(this).attr("codigo");
    let motivo = $(this).attr("motivo");
    let datos = new FormData();
    datos.append("codigotransferencia", codigoTransferencia);
    Swal.fire({
        icon: "warning",
        title: "Confirmación eliminación",
        text: "¿Está seguro de borrar la transferencia " + motivo + "?",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        confirmButtonText: 'Borrar',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar'
    }).then(function (resultado) {
        if (resultado.value) {
            $.ajax({
                url: 'index.php?r=Filiacion/transferencia-administrativo/eliminar-transferencia-administrativo-ajax',
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
                            text: "La transferencia " + motivo + "con el código " + codigoTransferencia + " ha sido borrado correctamente.",
                            showCancelButton: false,
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Cerrar"
                        }).then(function () {
                            $(".tablaTransferenciaAdministrativo").DataTable().ajax.reload();
                        });
                    }
                    else {
                        let mensaje;
                        if (respuesta === "enUso") {
                            mensaje = "No se puede eliminar la transferencia " + motivo + " con código " + codigoTransferencia + ", ya que está en uso actualmente y no puede ser eliminado. Solo puede ser inhabilitado.";
                        } else {
                            mensaje = "Ocurrio un error al eliminar el tipo de declaracion jurada " + motivo + " con código " + codigoTransferencia + ". Comuniquese con el administrador del sistema.";
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
/*=================================================
IR TRANSFERENCIA DETALLE ADMINISTRATIVO
==================================================*/
$(".tablaTransferenciaAdministrativo tbody").on("click", ".btnTransferenciasDetalleAdministrativos", function () {
    var codigoTransferencia = $(this).attr("codigo");
    window.location = 'index.php?r=Filiacion/transferencia-administrativo/ir-detalle&codigoTransferencia=' + codigoTransferencia;
});