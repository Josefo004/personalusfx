$(document).ready(function () {
    /*=============================================
    CARGAR LA TABLA DINÁMICA DE TRABAJADORES
    =============================================*/
    $(".tablaTrabajadoresTipoDeclaracionJurada").DataTable({
        ajax: {
            method: "POST",
            dataType: 'json',
            cache: false,
            url: 'index.php?r=Contraloria/tipo-declaracion-jurada-trabajadores/listar-trabajadores-tipo-declaracion-jurada-ajax',
            data: {
                "codigotipodeclaracionjurada": $("#codigoTipoDeclaracionJuradaSearch").text()
            }
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
    MOSTRAR AGREGAR TIPO DECLARACION JURADA TRABAJADOR
    =============================================*/
    $("#btnMostrarAgregarTipoDeclaracionJuradaTrabajador").click(function () {
        let codigoTipoDeclaracionJurada = $("#codigoTipoDeclaracionJuradaSearch").text();
        $(".modal-content .tablaTrabajadores").show();
        $(".modal-content .dataTables_info").show();
        $(".modal-content .dataTables_length").show();
        $(".modal-content .dataTables_filter").show();
        $(".modal-content .dataTables_paginate").show();
        $(".entrada-datos").hide();
        $(".tablaTrabajadores").DataTable({
            ajax: {
                method: "POST",
                dataType: 'json',
                cache: false,
                url: 'index.php?r=Contraloria/tipo-declaracion-jurada-trabajadores/listar-trabajadores-ajax',
                data: {
                    "codigotipodeclaracionjurada": $("#codigoTipoDeclaracionJuradaSearch").text()
                }
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
        $(".tablaTrabajadores tbody").on("click", ".btnElegirTrabajador", function () {
            let idPersona = $(this).attr("idpersona");
            let codigoTrabajador = $(this).attr("codigo");
            let nombreTrabajador = $(this).attr("nombre");
            let fechaNacimiento = $(this).attr("fechanacimiento");
            let datos = new FormData();
            datos.append("codigotrabajador", codigoTrabajador);
            datos.append("codigotipodeclaracionjurada", codigoTipoDeclaracionJurada);
            $.ajax({
                url: "index.php?r=Contraloria/tipo-declaracion-jurada-trabajadores/existe-tipo-declaracion-jurada-trabajador-ajax",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    if (respuesta === "no") {
                        $(".modal-content .tablaTrabajadores").hide();
                        $(".modal-content .dataTables_info").hide();
                        $(".modal-content .dataTables_length").hide();
                        $(".modal-content .dataTables_filter").hide();
                        $(".modal-content .dataTables_paginate").hide();
                        $(".entrada-datos").show();
                        $("#idPersonaNew").val(idPersona);
                        $("#codigoTrabajadorNew").val(codigoTrabajador);
                        $("#nombreCompletoNew").val(nombreTrabajador);
                        $('#fechaNacimientoNew').val(fechaNacimiento);

                        let fechaActual = new Date();
                        let anio = fechaActual.getFullYear();

                        //El mes se resta -1, porque Date recibe meses de 0 a 11
                        let dateFechaInicioRecordatorio = new Date(anio, fechaNacimiento.substring(3, 5) - 1, 1);
                        //d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
                        strFechaInicioRecordatorio = dateFechaInicioRecordatorio.toJSON().slice(0, 10);
                        $('#fechaInicioRecordatorioNew').val(strFechaInicioRecordatorio);

                        //El mes siguiente se obtiene con el mes de nacimiento, porque Date recibe meses de 0 a 11
                        //Si deseamos el ultimo mes de Octubre enviamos (Mes 10 = Noviembre), el cero resta un dia. Y se obtiene 31/10/xxxx
                        let ultimoDia = new Date(anio, fechaNacimiento.substring(3, 5), 0);
                        strFechaFinRecordatorio = ultimoDia.toJSON().slice(0, 10);
                        $('#fechaFinRecordatorioNew').val(strFechaFinRecordatorio);
                    } else {
                        let mensaje;
                        if (respuesta === "si") {
                            mensaje = "Ya se tiene un registro del trabajador " + nombreTrabajador + " en el tipo de declaración jurada con código " + codigoTipoDeclaracionJurada + ".";
                        } else {
                            mensaje = "Ocurrio un error al seleccionar al trabajador " + nombreTrabajador + " con código " + codigoTrabajador + ". Comuniquese con el administrador del sistema.";
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: mensaje,
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Cerrar'
                        }).then(function () {
                            $('#modalAgregarTipoDeclaracionJuradaTrabajador').modal('hide');
                        });
                    }
                }
            });
        });
    });
    /*=============================================
    ACTIVAR TIPO DECLARACION JURADA TRABAJADOR
    =============================================*/
    $(".tablaTrabajadoresTipoDeclaracionJurada tbody").on("click", ".btnActivarTipoDeclaracionJuradaTrabajador", function () {
        let objectBtn = $(this);
        let codigoTipoDeclaracionJurada = $("#codigoTipoDeclaracionJuradaSearch").text();
        let codigoTrabajador = objectBtn.attr("codigo");
        let codigoEstado = objectBtn.attr("estado");
        let datos = new FormData();
        datos.append("codigotipodeclaracionjurada", codigoTipoDeclaracionJurada);
        datos.append("codigotrabajador", codigoTrabajador);
        $.ajax({
            url: "index.php?r=Contraloria/tipo-declaracion-jurada-trabajadores/activar-tipo-declaracion-jurada-trabajador-ajax",
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
                        text: "Ocurrio un error al cambiar el estado del trabajador con código " + codigoTrabajador + " en el tipo de declaración jurada " + codigoTipoDeclaracionJurada + ". Comuníquese con el administrador del sistema.",
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Cerrar'
                    });
                }
            }
        });
    });
    /*=============================================
    AGREGAR TIPO DECLARACION JURADA TRABAJADOR
    =============================================*/
    $("#btnAgregarTipoDeclaracionJuradaTrabajador").click(function () {
        let codigoTipoDeclaracionJurada = $("#codigoTipoDeclaracionJuradaSearch").text();
        let codigoTrabajador = $("#codigoTrabajadorNew").val();
        let nombreTrabajador = $("#nombreCompletoNew").val();
        let fechaInicioRecordatorio = $("#fechaInicioRecordatorioNew").val();
        let fechaFinRecordatorio = $("#fechaFinRecordatorioNew").val();
        let datos = new FormData();
        datos.append("codigotipodeclaracionjuradacrear", codigoTipoDeclaracionJurada);
        datos.append("codigotrabajadorcrear", codigoTrabajador);
        datos.append("fechainiciorecordatoriocrear", fechaInicioRecordatorio);
        datos.append("fechafinrecordatoriocrear", fechaFinRecordatorio);
        $.ajax({
            url: "index.php?r=Contraloria/tipo-declaracion-jurada-trabajadores/agregar-tipo-declaracion-jurada-trabajador-ajax",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                if (respuesta === "ok") {
                    $("#nombreCompletoNew").val("");
                    $("#codigoTrabajadorNew").val("");
                    $("#fechaInicioRecordatorioNew").val("");
                    $("#fechaFinRecordatorioNew").val("");
                    $("#modalAgregarTipoDeclaracionJuradaTrabajador").modal('hide');
                    Swal.fire({
                        icon: "success",
                        title: "Creación Completada",
                        text: "El trabajador " + nombreTrabajador + " con código de trabajador " + codigoTrabajador + "ha sido agregado correctamente en el tipo de declaracion jurada " + codigoTipoDeclaracionJurada + ".",
                        showCancelButton: false,
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Cerrar"
                    }).then(function () {
                        $(".tablaTrabajadoresTipoDeclaracionJurada").DataTable().ajax.reload();
                    });
                }
                else {
                    let mensaje;
                    if (respuesta === "existe") {
                        mensaje = "El trabajador " + nombreTrabajador + " con código " + codigoTrabajador + " ya fue agregado a este tipo de declaración jurada.";
                    } else {
                        mensaje = "Ocurrio un error al agregar al trabajador " + nombreTrabajador + "con código " + codigoTrabajador + ". Comuniquese con el administrador del sistema.";
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
    EDITAR TIPO DECLARACION JURADA TRABAJADOR
    =============================================*/
    $(".tablaTrabajadoresTipoDeclaracionJurada tbody").on("click", ".btnEditarTipoDeclaracionJuradaTrabajador", function () {
        let codigoTipoDeclaracionJurada = $("#codigoTipoDeclaracionJuradaSearch").text();
        let codigoTrabajador = $(this).attr("codigo");
        let fechaNacimiento = $(this).attr("fechanacimiento");
        let datos = new FormData();
        datos.append("codigotrabajador", codigoTrabajador);
        datos.append("codigotipodeclaracionjurada", codigoTipoDeclaracionJurada);
        $.ajax({
            url: "index.php?r=Contraloria/tipo-declaracion-jurada-trabajadores/buscar-tipo-declaracion-jurada-trabajador-ajax",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (respuesta) {
                $("#codigoTrabajadorUpd").val(respuesta["CodigoTrabajador"]);
                $("#idPersonaUpd").val(respuesta["IdPersona"]);
                $("#nombreCompletoUpd").val(respuesta["NombreCompleto"]);
                $('#fechaNacimientoUpd').val(fechaNacimiento);
                $("#fechaInicioRecordatorioUpd").val(respuesta["FechaInicioRecordatorio"]);
                $("#fechaFinRecordatorioUpd").val(respuesta["FechaFinRecordatorio"]);
                $(".entrada-datos").show();
            },
            error: function (respuesta) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "Ocurrio un error al cargar los datos del trabajador con código " + codigoTrabajador + " en el tipo de declaración jurada " + codigoTipoDeclaracionJurada + ". Comuníquese con el administrador del sistema.",
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Cerrar'
                }).then(function () {
                    $('#modalActualizarTipoDeclaracionJuradaTrabajador').modal('hide');
                });
            }
        });
    });
    /*=============================================
    ACTUALIZAR TIPO DECLARACION JURADA TRABAJADOR
    =============================================*/
    $("#btnActualizarTipoDeclaracionJuradaTrabajador").click(function () {
        let codigoTipoDeclaracionJurada = $("#codigoTipoDeclaracionJuradaSearch").text();
        let codigoTrabajador = $("#codigoTrabajadorUpd").val();
        let nombreCompleto = $("#nombreCompletoUpd").val();
        let fechaInicioRecortadorio = $("#fechaInicioRecordatorioUpd").val();
        let fechaFinRecortadorio = $("#fechaFinRecordatorioUpd").val();
        let datos = new FormData();
        datos.append("codigotipodeclaracionjurada", codigoTipoDeclaracionJurada);
        datos.append("codigotrabajador", codigoTrabajador);
        datos.append("fechainiciorecordatorio", fechaInicioRecortadorio);
        datos.append("fechafinrecordatorio", fechaFinRecortadorio);
        $.ajax({
            url: "index.php?r=Contraloria/tipo-declaracion-jurada-trabajadores/actualizar-tipo-declaracion-jurada-trabajador-ajax",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                if (respuesta === "ok") {
                    $("#modalActualizarTipoDeclaracionJuradaTrabajador").modal('hide');
                    Swal.fire({
                        icon: "success",
                        title: "Actualización Completada",
                        text: "El trabajador " + nombreCompleto + " con código " + codigoTrabajador + " ha sido guardado correctamente en el tipo de declaracion jurada con código " + codigoTipoDeclaracionJurada + ".",
                        showCancelButton: false,
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Cerrar"
                    }).then(function () {
                        $(".tablaTrabajadoresTipoDeclaracionJurada").DataTable().ajax.reload();
                    });
                }
                else {
                    let mensaje;
                    if (respuesta === "existe") {
                        mensaje = "El trabajador " + nombreCompleto + " ya esta asignado en el tipo de declaracion jurada con código " + codigoTipoDeclaracionJurada + ".";
                    } else {
                        mensaje = "Ocurrio un error al actualizar las fechas de recordatorio del trabajador " + nombreCompleto + " en el tipo de declaracion jurada con código " + codigoTipoDeclaracionJurada + ". Comuniquese con el administrador del sistema.";
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
    ELIMINAR TIPO DECLARACION JURADA TRABAJADOR
    =============================================*/
    $(".tablaTrabajadoresTipoDeclaracionJurada tbody").on("click", ".btnEliminarTipoDeclaracionJuradaTrabajador", function () {
        let codigoTipoDeclaracionJurada = $("#codigoTipoDeclaracionJuradaSearch").text();
        let codigoTrabajador = $(this).attr("codigo");
        let nombreTrabajador = $(this).attr("nombre");
        let datos = new FormData();
        datos.append("codigotrabajadoreliminar", codigoTrabajador);
        datos.append("codigotipodeclaracionjuradaeliminar", codigoTipoDeclaracionJurada);
        Swal.fire({
            icon: "warning",
            title: "Confirmación eliminación",
            text: "¿Está seguro de quitar al trabajador " + nombreTrabajador + " con código " + codigoTrabajador + "?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            confirmButtonText: 'Borrar',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar'
        }).then(function (resultado) {
            if (resultado.value) {
                $.ajax({
                    url: "index.php?r=Contraloria/tipo-declaracion-jurada-trabajadores/eliminar-tipo-declaracion-jurada-trabajador-ajax",
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
                                text: "El trabajador " + nombreTrabajador + " con código " + codigoTrabajador + " ha sido quitado correctamente.",
                                showCancelButton: false,
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Cerrar"
                            }).then(function () {
                                $(".tablaTrabajadoresTipoDeclaracionJurada").DataTable().ajax.reload();
                            });
                        }
                        else {
                            let mensaje;
                            if (respuesta === "enUso") {
                                mensaje = "No se puede quitar al trabajador " + nombreCompleto + " con código " + codigoTrabajador + ", ya que está en uso actualmente y no puede ser quitado. Solo puede ser inhabilitado.";
                            } else {
                                mensaje = "Ocurrio un error al quitar al trabajador " + nombreCompleto + " con código " + codigoTrabajador + ". Comuniquese con el administrador del sistema.";
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
    RECORDATORIO AÑO ACTUAL TRABAJADOR
    =============================================*/
    $("#btnCargarCumpleActualNew").click(function () {
        let fechaActual = new Date();
        let anio = fechaActual.getFullYear();
        let fechaNacimiento = $('#fechaNacimientoNew').val();

        //El mes se resta -1, porque Date recibe meses de 0 a 11
        let dateFechaInicioRecordatorio = new Date(anio, fechaNacimiento.substring(3, 5) - 1, 1);
        //d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
        strFechaInicioRecordatorio = dateFechaInicioRecordatorio.toJSON().slice(0, 10);
        $('#fechaInicioRecordatorioNew').val(strFechaInicioRecordatorio);

        //El mes siguiente se obtiene con el mes de nacimiento, porque Date recibe meses de 0 a 11
        //Si deseamos el ultimo mes de Octubre enviamos (Mes 10 = Noviembre), el cero resta un dia. Y se obtiene 31/10/xxxx
        let ultimoDia = new Date(anio, fechaNacimiento.substring(3, 5), 0);
        strFechaFinRecordatorio = ultimoDia.toJSON().slice(0, 10);
        $('#fechaFinRecordatorioNew').val(strFechaFinRecordatorio);
    });
    /*=============================================
    RECORDATORIO AÑO SIGUIENTE TRABAJADOR
    =============================================*/
    $("#btnCargarCumpleSiguienteNew").click(function () {
        let fechaActual = new Date();
        let anio = fechaActual.getFullYear();
        anio = anio + 1;
        let fechaNacimiento = $('#fechaNacimientoNew').val();

        //El mes se resta -1, porque Date recibe meses de 0 a 11
        let dateFechaInicioRecordatorio = new Date(anio, fechaNacimiento.substring(3, 5) - 1, 1);
        //d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
        strFechaInicioRecordatorio = dateFechaInicioRecordatorio.toJSON().slice(0, 10);
        $('#fechaInicioRecordatorioNew').val(strFechaInicioRecordatorio);

        //El mes siguiente se obtiene con el mes de nacimiento, porque Date recibe meses de 0 a 11
        //Si deseamos el ultimo mes de Octubre enviamos (Mes 10 = Noviembre), el cero resta un dia. Y se obtiene 31/10/xxxx
        let ultimoDia = new Date(anio, fechaNacimiento.substring(3, 5), 0);
        strFechaFinRecordatorio = ultimoDia.toJSON().slice(0, 10);
        $('#fechaFinRecordatorioNew').val(strFechaFinRecordatorio);
    });
    /*=============================================
    RECORDATORIO AÑO SIGUIENTE TRABAJADOR
    =============================================*/
    $("#btnCargarCincoAniosNew").click(function () {
        let fechaActual = new Date();
        let anio = fechaActual.getFullYear();
        anio = anio + 5;
        let fechaNacimiento = $('#fechaNacimientoNew').val();

        //El mes se resta -1, porque Date recibe meses de 0 a 11
        let dateFechaInicioRecordatorio = new Date(anio, fechaNacimiento.substring(3, 5) - 1, 1);
        //d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
        strFechaInicioRecordatorio = dateFechaInicioRecordatorio.toJSON().slice(0, 10);
        $('#fechaInicioRecordatorioNew').val(strFechaInicioRecordatorio);

        //El mes siguiente se obtiene con el mes de nacimiento, porque Date recibe meses de 0 a 11
        //Si deseamos el ultimo mes de Octubre enviamos (Mes 10 = Noviembre), el cero resta un dia. Y se obtiene 31/10/xxxx
        let ultimoDia = new Date(anio, fechaNacimiento.substring(3, 5), 0);
        strFechaFinRecordatorio = ultimoDia.toJSON().slice(0, 10);
        $('#fechaFinRecordatorioNew').val(strFechaFinRecordatorio);
    });
    /*=============================================
    RECORDATORIO AÑO SIGUIENTE TRABAJADOR
    =============================================*/
    $("#btnCargarDiezAniosNew").click(function () {
        let fechaActual = new Date();
        let anio = fechaActual.getFullYear();
        anio = anio + 10;
        let fechaNacimiento = $('#fechaNacimientoNew').val();

        //El mes se resta -1, porque Date recibe meses de 0 a 11
        let dateFechaInicioRecordatorio = new Date(anio, fechaNacimiento.substring(3, 5) - 1, 1);
        //d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
        strFechaInicioRecordatorio = dateFechaInicioRecordatorio.toJSON().slice(0, 10);
        $('#fechaInicioRecordatorioNew').val(strFechaInicioRecordatorio);

        //El mes siguiente se obtiene con el mes de nacimiento, porque Date recibe meses de 0 a 11
        //Si deseamos el ultimo mes de Octubre enviamos (Mes 10 = Noviembre), el cero resta un dia. Y se obtiene 31/10/xxxx
        let ultimoDia = new Date(anio, fechaNacimiento.substring(3, 5), 0);
        strFechaFinRecordatorio = ultimoDia.toJSON().slice(0, 10);
        $('#fechaFinRecordatorioNew').val(strFechaFinRecordatorio);
    });
    /*===================================================
    RECORDATORIO 90 DIAS FINALIZACIÓN CONTRATO TRABAJADOR
    ===================================================*/
    $("#btnCargarFinalizacionNew").click(function () {
        alert("90 Dias");
    });
    /*=============================================
    RECORDATORIO AÑO ACTUAL TRABAJADOR
    =============================================*/
    $("#btnCargarCumpleActualUpd").click(function () {
        let fechaActual = new Date();
        let anio = fechaActual.getFullYear();
        let fechaNacimiento = $('#fechaNacimientoUpd').val();

        //El mes se resta -1, porque Date recibe meses de 0 a 11
        let dateFechaInicioRecordatorio = new Date(anio, fechaNacimiento.substring(3, 5) - 1, 1);
        //d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
        strFechaInicioRecordatorio = dateFechaInicioRecordatorio.toJSON().slice(0, 10);
        $('#fechaInicioRecordatorioUpd').val(strFechaInicioRecordatorio);

        //El mes siguiente se obtiene con el mes de nacimiento, porque Date recibe meses de 0 a 11
        //Si deseamos el ultimo mes de Octubre enviamos (Mes 10 = Noviembre), el cero resta un dia. Y se obtiene 31/10/xxxx
        let ultimoDia = new Date(anio, fechaNacimiento.substring(3, 5), 0);
        strFechaFinRecordatorio = ultimoDia.toJSON().slice(0, 10);
        $('#fechaFinRecordatorioUpd').val(strFechaFinRecordatorio);
    });
    /*=============================================
    RECORDATORIO AÑO SIGUIENTE TRABAJADOR
    =============================================*/
    $("#btnCargarCumpleSiguienteUpd").click(function () {
        let fechaActual = new Date();
        let anio = fechaActual.getFullYear();
        anio = anio + 1;
        let fechaNacimiento = $('#fechaNacimientoUpd').val();

        //El mes se resta -1, porque Date recibe meses de 0 a 11
        let dateFechaInicioRecordatorio = new Date(anio, fechaNacimiento.substring(3, 5) - 1, 1);
        //d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
        strFechaInicioRecordatorio = dateFechaInicioRecordatorio.toJSON().slice(0, 10);
        $('#fechaInicioRecordatorioUpd').val(strFechaInicioRecordatorio);

        //El mes siguiente se obtiene con el mes de nacimiento, porque Date recibe meses de 0 a 11
        //Si deseamos el ultimo mes de Octubre enviamos (Mes 10 = Noviembre), el cero resta un dia. Y se obtiene 31/10/xxxx
        let ultimoDia = new Date(anio, fechaNacimiento.substring(3, 5), 0);
        strFechaFinRecordatorio = ultimoDia.toJSON().slice(0, 10);
        $('#fechaFinRecordatorioUpd').val(strFechaFinRecordatorio);
    });
    /*=============================================
    RECORDATORIO 5 AÑOS TRABAJADOR
    =============================================*/
    $("#btnCargarCincoAniosUpd").click(function () {
        let fechaActual = new Date();
        let anio = fechaActual.getFullYear();
        anio = anio + 5;
        let fechaNacimiento = $('#fechaNacimientoUpd').val();

        //El mes se resta -1, porque Date recibe meses de 0 a 11
        let dateFechaInicioRecordatorio = new Date(anio, fechaNacimiento.substring(3, 5) - 1, 1);
        //d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
        strFechaInicioRecordatorio = dateFechaInicioRecordatorio.toJSON().slice(0, 10);
        $('#fechaInicioRecordatorioUpd').val(strFechaInicioRecordatorio);

        //El mes siguiente se obtiene con el mes de nacimiento, porque Date recibe meses de 0 a 11
        //Si deseamos el ultimo mes de Octubre enviamos (Mes 10 = Noviembre), el cero resta un dia. Y se obtiene 31/10/xxxx
        let ultimoDia = new Date(anio, fechaNacimiento.substring(3, 5), 0);
        strFechaFinRecordatorio = ultimoDia.toJSON().slice(0, 10);
        $('#fechaFinRecordatorioUpd').val(strFechaFinRecordatorio);
    });
    /*=============================================
    RECORDATORIO 10 AÑOS TRABAJADOR
    =============================================*/
    $("#btnCargarDiezAniosUpd").click(function () {
        let fechaActual = new Date();
        let anio = fechaActual.getFullYear();
        anio = anio + 10;
        let fechaNacimiento = $('#fechaNacimientoUpd').val();

        //El mes se resta -1, porque Date recibe meses de 0 a 11
        let dateFechaInicioRecordatorio = new Date(anio, fechaNacimiento.substring(3, 5) - 1, 1);
        //d.setMinutes(d.getMinutes() - d.getTimezoneOffset());
        strFechaInicioRecordatorio = dateFechaInicioRecordatorio.toJSON().slice(0, 10);
        $('#fechaInicioRecordatorioUpd').val(strFechaInicioRecordatorio);

        //El mes siguiente se obtiene con el mes de nacimiento, porque Date recibe meses de 0 a 11
        //Si deseamos el ultimo mes de Octubre enviamos (Mes 10 = Noviembre), el cero resta un dia. Y se obtiene 31/10/xxxx
        let ultimoDia = new Date(anio, fechaNacimiento.substring(3, 5), 0);
        strFechaFinRecordatorio = ultimoDia.toJSON().slice(0, 10);
        $('#fechaFinRecordatorioUpd').val(strFechaFinRecordatorio);
    });
    /*===================================================
    RECORDATORIO 90 DIAS FINALIZACIÓN CONTRATO TRABAJADOR
    ===================================================*/
    $("#btnCargarFinalizacionUpd").click(function () {
        alert("90 Dias");
    });
});