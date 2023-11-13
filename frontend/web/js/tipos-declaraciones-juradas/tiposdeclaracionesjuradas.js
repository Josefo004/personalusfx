$(document).ready(function () {
    $(".entrada-datos").hide();

    /*=============================================
    CARGAR LA TABLA DINÁMICA DE TIPOS DECLARACIONES JURADAS
    =============================================*/
    $(".tablaTiposDeclaracionesJuradas").DataTable({
        //"ajax": "index.php?r=nacionalidades/listar-nacionalidades-ajax",
        ajax: {
            method: "POST",
            dataType: 'json',
            cache: false,
            url: 'index.php?r=Contraloria/tipos-declaraciones-juradas/listar-tipos-declaraciones-juradas-ajax',
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
    CREAR TIPO DECLARACION JURADA
    =============================================*/
    $("#btnCrearTipoDeclaracionJurada").click(function () {
        let nombreTipoDeclaracionJurada = $("#nombreTipoDeclaracionJuradaNew").val();
        let frecuencia = $("#frecuenciaNew").val();
        let datos = new FormData();
        datos.append("nombretipodeclaracionjurada", nombreTipoDeclaracionJurada);
        datos.append("frecuencia", frecuencia);
        $.ajax({
            url: "index.php?r=Contraloria/tipos-declaraciones-juradas/crear-tipo-declaracion-jurada-ajax",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                if (respuesta === "ok") {
                    $("#nombreTipoDeclaracionJuradaNew").val("");
                    $("#frecuenciaNew").val("");
                    $("#modalCrearTipoDeclaracionJurada").modal('hide');
                    Swal.fire({
                        icon: "success",
                        title: "Creación Completada",
                        text: "El tipo de declaracion jurada " + nombreTipoDeclaracionJurada + " ha sido guardado correctamente.",
                        showCancelButton: false,
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Cerrar"
                    }).then(function () {
                        $(".tablaTiposDeclaracionesJuradas").DataTable().ajax.reload();
                    });
                }
                else {
                    let mensaje;
                    if (respuesta === "existe") {
                        mensaje = "El tipo de declaración jurada " + nombreTipoDeclaracionJurada + " ya existe. Ingrese otro nombre.";
                    } else {
                        mensaje = "Ocurrio un error al crear el tipo de declaración jurada " + nombre + ". Comuniquese con el administrador del sistema.";
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
    ACTIVAR TIPO DECLARACION JURADA
    =============================================*/
    $(".tablaTiposDeclaracionesJuradas tbody").on("click", ".btnActivarTipoDeclaracionJurada", function () {
        let objectBtn = $(this);
        let codigoTipoDeclaracionJurada = objectBtn.attr("codigo");
        let codigoEstado = objectBtn.attr("estado");
        let datos = new FormData();
        datos.append("codigotipodeclaracionjurada", codigoTipoDeclaracionJurada);
        $.ajax({
            url: "index.php?r=Contraloria/tipos-declaraciones-juradas/activar-tipo-declaracion-jurada-ajax",
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
                        text: "Ocurrio un error al cambiar el estado del tipo de declaracion jurada con código " + codigoTipoDeclaracionJurada + ". Comuníquese con el administrador del sistema.",
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Cerrar'
                    });
                }
            }
        });
    });
    /*=============================================
    EDITAR TIPO DECLARACION JURADA
    =============================================*/
    $(".tablaTiposDeclaracionesJuradas tbody").on("click", ".btnEditarTipoDeclaracionJurada", function () {
        let codigoTipoDeclaracionJurada = $(this).attr("codigo");
        let datos = new FormData();
        datos.append("codigotipodeclaracionjurada", codigoTipoDeclaracionJurada);
        $.ajax({
            url: "index.php?r=Contraloria/tipos-declaraciones-juradas/buscar-tipo-declaracion-jurada-ajax",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (respuesta) {
                $("#codigoTipoDeclaracionJuradaUpd").val(respuesta["CodigoTipoDeclaracionJurada"]);
                $("#nombreTipoDeclaracionJuradaUpd").val(respuesta["NombreTipoDeclaracionJurada"]);
                $("#frecuenciaUpd").val(respuesta["Frecuencia"]);
            },
            error: function (respuesta) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "Ocurrio un error al cargar los datos del tipo de declaracion jurada con código " + codigoTipoDeclaracionJurada + ". Comuniquese con el administrador del sistema.",
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Cerrar'
                }).then(function () {
                    $('#modalActualizarTipoDeclaracionJurada').modal('hide');
                });
            }
        });
    });
    /*=============================================
    ACTUALIZAR TIPO DECLARACION JURADA
    =============================================*/
    $("#btnActualizarTipoDeclaracionJurada").click(function () {
        let codigoTipoDeclaracionJurada = $("#codigoTipoDeclaracionJuradaUpd").val();
        let nombreTipoDeclaracionJurada = $("#nombreTipoDeclaracionJuradaUpd").val();
        let frecuencia = $("#frecuenciaUpd").val();
        let datos = new FormData();
        datos.append("codigotipodeclaracionjurada", codigoTipoDeclaracionJurada);
        datos.append("nombretipodeclaracionjurada", nombreTipoDeclaracionJurada);
        datos.append("frecuencia", frecuencia);
        $.ajax({
            url: "index.php?r=Contraloria/tipos-declaraciones-juradas/actualizar-tipo-declaracion-jurada-ajax",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                if (respuesta === "ok") {
                    $("#modalActualizarTipoDeclaracionJurada").modal('hide');
                    Swal.fire({
                        icon: "success",
                        title: "Actualización Completada",
                        text: "El tipo de declaracion jurada " + nombreTipoDeclaracionJurada + " ha sido guardado correctamente con el código " + codigoTipoDeclaracionJurada + ".",
                        showCancelButton: false,
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Cerrar"
                    }).then(function () {
                        $(".tablaTiposDeclaracionesJuradas").DataTable().ajax.reload();
                    });
                }
                else {
                    let mensaje;
                    if (respuesta === "existe") {
                        mensaje = "El tipo de declaracion jurada " + nombreTipoDeclaracionJurada + " ya existe. Ingrese otro nombre.";
                    } else {
                        mensaje = "Ocurrio un error al actualizar los datos del tipo de declaracion jurada con código " + codigoTipoDeclaracionJurada + ". Comuniquese con el administrador del sistema.";
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
    ELIMINAR TIPO DECLARACION JURADA
    =============================================*/
    $(".tablaTiposDeclaracionesJuradas tbody").on("click", ".btnEliminarTipoDeclaracionJurada", function () {
        let codigoTipoDeclaracionJurada = $(this).attr("codigo");
        let nombreTipoDeclaracionJurada = $(this).attr("nombre");
        let datos = new FormData();
        datos.append("codigotipodeclaracionjurada", codigoTipoDeclaracionJurada);
        Swal.fire({
            icon: "warning",
            title: "Confirmación eliminación",
            text: "¿Está seguro de borrar el tipo de declaracion jurada " + nombreTipoDeclaracionJurada + "?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            confirmButtonText: 'Borrar',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar'
        }).then(function (resultado) {
            if (resultado.value) {
                $.ajax({
                    url: "index.php?r=Contraloria/tipos-declaraciones-juradas/eliminar-tipo-declaracion-jurada-ajax",
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
                                text: "El tipo de declaracion jurada " + nombreTipoDeclaracionJurada + "con el código " + codigoTipoDeclaracionJurada + " ha sido borrado correctamente.",
                                showCancelButton: false,
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Cerrar"
                            }).then(function () {
                                $(".tablaTiposDeclaracionesJuradas").DataTable().ajax.reload();
                            });
                        }
                        else {
                            let mensaje;
                            if (respuesta === "enUso") {
                                mensaje = "No se puede eliminar el tipo de declaracion jurada " + nombreTipoDeclaracionJurada + " con código " + codigoTipoDeclaracionJurada + ", ya que está en uso actualmente y no puede ser eliminado. Solo puede ser inhabilitado.";
                            } else {
                                mensaje = "Ocurrio un error al eliminar el tipo de declaracion jurada " + nombreTipoDeclaracionJurada + " con código " + codigoTipoDeclaracionJurada + ". Comuniquese con el administrador del sistema.";
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
    MOSTRAR TRABAJADORES DEL TIPO DE DECLARACION JURADA
    ==================================================*/
    $(".tablaTiposDeclaracionesJuradas tbody").on("click", ".btnTrabajadoresTipoDeclaracionJurada", function () {
        var codigoTipoDeclaracionJurada = $(this).attr("codigo");
        window.location = "index.php?r=Contraloria/tipos-declaraciones-juradas/ir-trabajadores&codigoTipoDeclaracionJurada=" + codigoTipoDeclaracionJurada;
    });
});