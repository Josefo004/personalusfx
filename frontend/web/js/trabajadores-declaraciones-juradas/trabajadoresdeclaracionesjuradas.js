$(document).ready(function () {
    $(".entrada-tipos-principal").hide();
    $(".entrada-datos-complementaria").hide();
});

/*============================================================
CARGAR LA TABLA DINÁMICA DE TRABAJADORES DECLARACIONES JURADAS
============================================================*/
$(".tablaTrabajadoresDeclaracionesJuradas").DataTable({
    //"ajax": "index.php?r=trabajadores-declaraciones-juradas/listar-trabajadores-declaraciones-juradas-ajax",
    ajax: {
        method: "POST",
        dataType: 'json',
        cache: false,
        url: 'index.php?r=Contraloria/trabajadores-declaraciones-juradas/listar-trabajadores-declaraciones-juradas-ajax',
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
MOSTRAR CREAR DECLARACION JURADA TRABAJADOR
=============================================*/
$("#btnMostrarCrearTrabajadorDeclaracionJuada").click(function () {
    $(".modal-content .tablaTrabajadores").show();
    $(".modal-content .dataTables_info").show();
    $(".modal-content .dataTables_length").show();
    $(".modal-content .dataTables_filter").show();
    $(".modal-content .dataTables_paginate").show();
    $(".entrada-datos-principal").hide();
    $(".entrada-datos-complementaria").hide();

    $(".tablaTrabajadores").DataTable({
        //"ajax": "index.php?r=personas/listar-personas-ajax",
        ajax: {
            method: "POST",
            dataType: 'json',
            cache: false,
            url: 'index.php?r=Contraloria/trabajadores-declaraciones-juradas/listar-trabajadores-ajax',
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
    SELECCIONAR TRABAJADOR
    =============================================*/
    $(".tablaTrabajadores tbody").on("click", ".btnElegir", function () {
        let objectBtn = $(this);
        let idPersona = objectBtn.attr("idpersona");
        let codigoTrabajador = objectBtn.attr("codigo");
        let nombre = objectBtn.attr("nombre");

        let datos = new FormData();
        datos.append("codigotrabajador", codigoTrabajador);
        $.ajax({
            url: "index.php?r=Contraloria/trabajadores-declaraciones-juradas/listar-tipos-declaraciones-juradas-ajax",
            method: "POST",
            dataType: 'html',
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                $(".modal-content .tablaTrabajadores").hide();
                $(".modal-content .dataTables_info").hide();
                $(".modal-content .dataTables_length").hide();
                $(".modal-content .dataTables_filter").hide();
                $(".modal-content .dataTables_paginate").hide();
                $(".entrada-datos-principal").show();
                $(".entrada-datos-complementaria").hide();
                $("#idPersonaNew").val(idPersona);
                $("#codigoTrabajadorNew").val(codigoTrabajador);
                $("#nombreCompletoNew").val(nombre);
                $(".codigoTipoDeclaracionJurada").empty().append(respuesta);
            }
        });
    });
});
/*=============================================
SELECCIONAR TIPO DECLARACION JURADA
=============================================*/
$(".codigoTipoDeclaracionJurada").change(function () {
    let codigoTipoDeclaracionJurada = $(this).val();
    if (codigoTipoDeclaracionJurada != "") {
        $(".entrada-datos-complementaria").show();
    } else {
        $(".entrada-datos-complementaria").hide();
    }
    let codigoTrabajador = $("#codigoTrabajadorNew").val();
    let datos = new FormData();
    datos.append("codigotipodeclaracionjurada", codigoTipoDeclaracionJurada);
    datos.append("codigotrabajador", codigoTrabajador);
    $.ajax({
        url: "index.php?r=Contraloria/trabajadores-declaraciones-juradas/buscar-tipo-declaracion-jurada-trabajador-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            let fechaInicioRecordatorioFormato = respuesta["FechaInicioRecordatorio"].substr(8,2) + "/" + respuesta["FechaInicioRecordatorio"].substr(5,2) + "/" + respuesta["FechaInicioRecordatorio"].substr(0,4);
            let fechaFinRecordatorioFormato = respuesta["FechaFinRecordatorio"].substr(8,2) + "/" + respuesta["FechaFinRecordatorio"].substr(5,2) + "/" + respuesta["FechaFinRecordatorio"].substr(0,4);
            $("#fechaInicioRecordatorioNew").val(fechaInicioRecordatorioFormato);
            $("#fechaFinRecordatorioNew").val(fechaFinRecordatorioFormato);
        },
        error: function (respuesta) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "Ocurrio un error al cargar los datos de recordatorio de fechas. Comuniquese con el administrador del sistema.",
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Cerrar'
            }).then(function () {
                $('#modalCrearTrabajadorDeclaracionJurada').modal('hide');
            });
        }
    });
});
/*=============================================
CREAR DECLARACION JURADA TRABAJADOR
=============================================*/
$("#btnCrearTrabajadorDeclaracionJurada").click(function () {
    let codigoTrabajador = $("#codigoTrabajadorNew").val();
    let nombreCompleto = $("#nombreCompletoNew").val();
    let codigoTipoDeclaracionJurada = $("#codigoTipoDeclaracionJuradaNew").val();
    let codigoDeclaracionJurada = $("#codigoDeclaracionJuradaNew").val();
    let gestion = $("#gestionNew").val();
    let mes = $("#mesNew").val();
    let fechaInicioRecordatorio = $("#fechaInicioRecordatorioNew").val();
    let fechaFinRecordatorio = $("#fechaFinRecordatorioNew").val();
    let fechaNotificacion = $("#fechaNotificacionNew").val();
    let fechaRecepcion = $("#fechaRecepcionNew").val();
    let observacion = $("#observacionNew").val();
    let datos = new FormData();
    datos.append("codigodeclaracionjuradacrear", codigoDeclaracionJurada);
    datos.append("codigotrabajadorcrear", codigoTrabajador);
    datos.append("codigotipodeclaracionjuradacrear", codigoTipoDeclaracionJurada);
    datos.append("gestioncrear", gestion);
    datos.append("mescrear", mes);
    datos.append("fechainiciorecordatoriocrear", fechaInicioRecordatorio);
    datos.append("fechafinrecordatoriocrear", fechaFinRecordatorio);
    datos.append("fechanotificacioncrear", fechaNotificacion);
    datos.append("fecharecepcioncrear", fechaRecepcion);
    datos.append("observacioncrear", observacion);
    $.ajax({
        url: "index.php?r=Contraloria/trabajadores-declaraciones-juradas/crear-trabajador-declaracion-jurada-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            if (respuesta === "ok") {
                $("#modalCrearTrabajadorDeclaracionJurada").modal('hide');
                Swal.fire({
                    icon: "success",
                    title: "Creación Completada",
                    text: "La declaracion jurada con código " + codigoDeclaracionJurada + " del trabajador " + nombreCompleto + " ha sido guardado correctamente.",
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Cerrar"
                }).then(function () {
                    $(".tablaTrabajadoresDeclaracionesJuradas").DataTable().ajax.reload();
                });
            }
            else {
                let mensaje;
                if (respuesta === "existe") {
                    mensaje = "La declaracion jurada " + codigoDeclaracionJurada + " ya existe. Ingrese otro código.";
                } else {
                    if (respuesta === "error-completar") {
                        mensaje = "Debe llenar los siguientes datos: Codigo Contraloria, Fecha de Notificacion, Fecha de Recepcion.";
                    } else {
                        mensaje = "Ocurrio un error al registrar la declaracion jurada con código " + codigoDeclaracionJurada + ". Comuniquese con el administrador del sistema.";
                    }
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
EDITAR DECLARACION JURADA TRABAJADOR
=============================================*/
$(".tablaTrabajadoresDeclaracionesJuradas tbody").on("click", ".btnEditarTrabajadorDeclaracionJurada", function () {
    let codigo = $(this).attr("codigo");
    let datos = new FormData();
    datos.append("codigoeditar", codigo);
    $.ajax({
        url: "index.php?r=Contraloria/trabajadores-declaraciones-juradas/buscar-trabajador-declaracion-jurada-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            let fechaInicioRecordatorioFormato = respuesta["FechaInicioRecordatorio"].substr(8,2) + "/" + respuesta["FechaInicioRecordatorio"].substr(5,2) + "/" + respuesta["FechaInicioRecordatorio"].substr(0,4);
            let fechaFinRecordatorioFormato = respuesta["FechaFinRecordatorio"].substr(8,2) + "/" + respuesta["FechaFinRecordatorio"].substr(5,2) + "/" + respuesta["FechaFinRecordatorio"].substr(0,4);
            $("#codigoTrabajadorUpd").val(respuesta["CodigoTrabajador"]);
            $("#idPersonaUpd").val(respuesta["IdPersona"]);
            $("#nombreCompletoUpd").val(respuesta["NombreCompleto"]);
            $("#tipoDeclaracionJuradaUpd").val(respuesta["NombreTipoDeclaracionJurada"]);
            $("#codigoDeclaracionJuradaAnteriorUpd").val(respuesta["CodigoDeclaracionJurada"]);
            $("#codigoDeclaracionJuradaUpd").val(respuesta["CodigoDeclaracionJurada"]);
            $("#gestionUpd").val(respuesta["Gestion"]);
            $("#mesUpd").val(respuesta["Mes"]);
            $("#fechaInicioRecordatorioUpd").val(fechaInicioRecordatorioFormato);
            $("#fechaFinRecordatorioUpd").val(fechaFinRecordatorioFormato);
            $("#fechaNotificacionUpd").val(respuesta["FechaNotificacion"]);
            $("#fechaRecepcionUpd").val(respuesta["FechaRecepcion"]);
            $("#observacionUpd").val(respuesta["Observacion"]);
            $(".entrada-datos-principal").show();
            $(".entrada-datos-complementaria").show();
        },
        error: function (respuesta) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "Ocurrio un error al cargar los datos de la declaración jurada con código " + codigo + ". Comuniquese con el administrador del sistema.",
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Cerrar'
            }).then(function () {
                $('#modalActualizarDeclaracionJuradaTrabajador').modal('hide');
            });
        }
    });
});
/*=============================================
ACTUALIZAR DECLARACION JURADA TRABAJADOR
=============================================*/
$("#btnActualizarTrabajadorDeclaracionJurada").click(function () {
    let nombreCompleto = $("#nombreCompletoUpd").val();
    let codigoAnterior = $("#codigoDeclaracionJuradaAnteriorUpd").val();
    let codigo = $("#codigoDeclaracionJuradaUpd").val();
    let gestion = $("#gestionUpd").val();
    let mes = $("#mesUpd").val();
    let fechaNotificacion = $("#fechaNotificacionUpd").val();
    let fechaRecepcion = $("#fechaRecepcionUpd").val();
    let observacion = $("#observacionUpd").val();
    let datos = new FormData();
    datos.append("codigoanterior", codigoAnterior);
    datos.append("codigoactualizar", codigo);
    datos.append("gestionactualizar", gestion);
    datos.append("mesactualizar", mes);
    datos.append("fechanotificacionactualizar", fechaNotificacion);
    datos.append("fecharecepcionactualizar", fechaRecepcion);
    datos.append("observacionactualizar", observacion);
    $.ajax({
        url: "index.php?r=Contraloria/trabajadores-declaraciones-juradas/actualizar-trabajador-declaracion-jurada-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            if (respuesta === "ok") {
                $("#modalActualizarTrabajadorDeclaracionJurada").modal('hide');
                Swal.fire({
                    icon: "success",
                    title: "Actualización Completada",
                    text: "La declaracion jurada con código " + codigo + " del trabajador " + nombreCompleto + " ha sido guardado correctamente.",
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Cerrar"
                }).then(function () {
                    $(".tablaTrabajadoresDeclaracionesJuradas").DataTable().ajax.reload();
                });
            }
            else {
                let mensaje;
                if (respuesta === "existe") {
                    mensaje = "La declaracion jurada con código " + codigo + " ya existe. Ingrese otro código.";
                } else {
                    mensaje = "Ocurrio un error al actualizar los datos de la declaracion jurada con código " + codigo + ". Comuniquese con el administrador del sistema.";
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
ELIMINAR DECLARACION JURADA TRABAJADOR
=============================================*/
$(".tablaTrabajadoresDeclaracionesJuradas tbody").on("click", ".btnEliminarTrabajadorDeclaracionJurada", function () {
    let codigo = $(this).attr("codigo");
    let nombre = $(this).attr("nombre");
    let datos = new FormData();
    datos.append("codigoeliminar", codigo);
    Swal.fire({
        icon: "warning",
        title: "Confirmación eliminación",
        text: "¿Está seguro de borrar la declaración jurada con código " + codigo + "?",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        confirmButtonText: 'Borrar',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar'
    }).then(function (resultado) {
        if (resultado.value) {
            $.ajax({
                url: "index.php?r=Contraloria/trabajadores-declaraciones-juradas/eliminar-trabajador-declaracion-jurada-ajax",
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
                            text: "La declaración jurada con código " + codigo + " del trabajador " + nombre + " ha sido borrado correctamente.",
                            showCancelButton: false,
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Cerrar"
                        }).then(function () {
                            $(".tablaTrabajadoresDeclaracionesJuradas").DataTable().ajax.reload();
                        });
                    }
                    else {
                        let mensaje;
                        if (respuesta === "enUso") {
                            mensaje = "No se puede eliminar la declaración jurada con código " + codigo + " del trabajador " + nombre + ", ya que está en uso actualmente y no puede ser eliminada. Solo puede ser inhabilitada.";
                        } else {
                            mensaje = "Ocurrio un error al eliminar la declaración jurada con código " + codigo + " del trabajador " + nombre + ". Comuniquese con el administrador del sistema."
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
