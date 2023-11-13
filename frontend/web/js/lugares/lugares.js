$(document).ready(function () {
    $("#vistaLugaresAcad").hide();
    $(".main-footer").hide();
    /*=============================================
    CARGAR LA TABLA DINÁMICA DE LUGARES
    =============================================*/
    $(".tablaLugares").DataTable({
        ajax: {
            method: "POST",
            dataType: 'json',
            cache: false,
            url: 'index.php?r=Administracion/lugares/listar-lugares',
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
    CARGAR LA TABLA DINÁMICA DE LUGARES ACADEMICA
    =============================================*/
    $(".tablaLugaresAcad").DataTable({
        ajax: {
            method: "POST",
            dataType: 'json',
            cache: false,
            url: 'index.php?r=Administracion/lugares/listar-lugares-acad',
            data: {
                "codigoprovinciaacad": function (d) {
                    return $("#codigoProvincia").val();
                }
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
    ACTIVAR LUGAR
    =============================================*/
    $(".tablaLugares tbody").on("click", ".btnActivarLugar", function () {
        let objectBtn = $(this);
        let codigoLugar = objectBtn.attr("codigo-lugar");
        let codigoEstado = objectBtn.attr("codigo-estado");
        let datos = new FormData();
        datos.append("codigolugar", codigoLugar);
        $.ajax({
            url: "index.php?r=Administracion/lugares/cambiar-estado-lugar",
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
                        objectBtn.attr('codigo-estado', 'C');
                    } else {
                        objectBtn.addClass('btn-success');
                        objectBtn.removeClass('btn-danger');
                        objectBtn.html('VIGENTE');
                        objectBtn.attr('codigo-estado', 'V');
                    }
                }
                else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: "Ocurrio un error al cambiar el estado del lugar con código " + codigoLugar + ". Comuniquese con el administrador del sistema.",
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Cerrar'
                    });
                }
            }
        });
    });

    /*=============================================
    SELECCIONAR PAIS
    =============================================*/
    $("#codigoPais").change(function () {
        let codigoPais = $(this).val();
        if (codigoPais != "") {
            let datos = new FormData();
            datos.append("codigopais", codigoPais);
            $.ajax({
                url: "index.php?r=Administracion/lugares/listar-departamentos",
                method: "POST",
                dataType: 'html',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    $(".codigoDepartamento").empty().append(respuesta);
                    $(".codigoDepartamento").prop("disabled", false);
                    $(".entrada-datos1").show(500);
                    $(".entrada-datos2").hide(500);
                    $(".modal-content .tablaLugaresAcad").hide(500);
                    $(".modal-content .dataTables_info").hide(500);
                    $(".modal-content .dataTables_length").hide(500);
                    $(".modal-content .dataTables_filter").hide(500);
                    $(".modal-content .dataTables_paginate").hide(500);
                }
            });
        } else {
            $(".codigoDepartamento").empty().append("<option value=''>Selecionar Departamento</option>");
            $(".codigoDepartamento").prop("disabled", true);
            $(".entrada-datos1").hide(500);
            $(".entrada-datos2").hide(500);
            $(".modal-content .tablaLugaresAcad").hide(500);
            $(".modal-content .dataTables_info").hide(500);
            $(".modal-content .dataTables_length").hide(500);
            $(".modal-content .dataTables_filter").hide(500);
            $(".modal-content .dataTables_paginate").hide(500);
        }
    });

    /*=============================================
    SELECCIONAR DEPARTAMENTO
    =============================================*/
    $("#codigoDepartamento").change(function () {
        let codigoDepartamento = $(this).val();
        if (codigoDepartamento != "") {
            let datos = new FormData();
            datos.append("codigodepartamento", codigoDepartamento);
            $.ajax({
                url: "index.php?r=Administracion/lugares/listar-provincias",
                method: "POST",
                dataType: 'html',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    $(".codigoProvincia").empty().append(respuesta);
                    $(".codigoProvincia").prop("disabled", false);
                    $(".entrada-datos2").show(500);
                    $(".tablaLugaresAcad").hide(500);
                    $(".dataTables_info").hide(500);
                    $(".dataTables_length").hide(500);
                    $(".dataTables_filter").hide(500);
                    $(".dataTables_paginate").hide(500);
                }
            });
        } else {
            $(".codigoProvincia").empty().append("<option value=''>Selecionar Provincia</option>");
            $(".codigoProvincia").prop("disabled", true);
            $(".entrada-datos2").hide(500);
            $(".tablaLugaresAcad").hide(500);
            $(".dataTables_info").hide(500);
            $(".dataTables_length").hide(500);
            $(".dataTables_filter").hide(500);
            $(".dataTables_paginate").hide(500);
        }
    });

    /*=============================================
    SELECCIONAR PROVINCIA
    =============================================*/
    $(".codigoProvincia").change(function () {
        let codigoProvincia = $(this).val();
        if (codigoProvincia != "") {
            let datos = new FormData();
            datos.append("codigoprovincia", codigoProvincia);
            $(".tablaLugaresAcad").show(500);
            $(".dataTables_info").show(500);
            $(".dataTables_length").show(500);
            $(".dataTables_filter").show(500);
            $(".dataTables_paginate").show(500);
            $(".tablaLugaresAcad").DataTable().ajax.reload();
        } else {
            $(".modal-content .tablaLugaresAcad").hide(500);
            $(".modal-content .dataTables_info").hide(500);
            $(".modal-content .dataTables_length").hide(500);
            $(".modal-content .dataTables_filter").hide(500);
            $(".modal-content .dataTables_paginate").hide(500);
        }
    });

    /*=============================================
    CREAR LUGAR
    =============================================*/
    $("#btnMostrarCrearLugar").click(function () {
        $('#codigoPais').val("");
        $('#codigoDepartamento').val("");
        $('#codigoLugar').val("");
        $("#vistaLugares").hide(500);
        $(".entrada-datos1").hide(500);
        $(".entrada-datos2").hide(500);
        $(".tablaLugaresAcad").hide(500);
        $(".dataTables_info").hide(500);
        $(".dataTables_length").hide(500);
        $(".dataTables_filter").hide(500);
        $(".dataTables_paginate").hide(500);
        $("#vistaLugaresAcad").show(500);
        $(".tablaLugaresAcad").hide(500);
        $(".tablaLugaresAcad").DataTable().ajax.reload();
    });

    $("#btnCancelar").click(function () {
        //$('.icon').toggleClass('opened');
        $("#vistaLugaresAcad").hide(500);
        $("#vistaLugares").show(500);
    });


    $(".tablaLugaresAcad tbody").on("click", ".btnElegir", function () {
        let codigoLugarAcad = $(this).attr("codigo-lugar-acad");
        let nombreLugarAcad = $(this).attr("nombre-lugar-acad");
        let codigoProvincia = $('#codigoProvincia').val();
        let codigoPaisAcad = $(this).attr("codigo-pais-acad");
        let codigoDepartamentoAcad = $(this).attr("codigo-departamento-acad");
        let codigoProvinciaAcad = $(this).attr("codigo-provincia-acad");
        let idLugarAcad = $(this).attr("id-lugar-acad");
        let datos = new FormData();
        datos.append("codigolugaracad", codigoLugarAcad);
        datos.append("nombrelugaracad", nombreLugarAcad);
        datos.append("codigopaisacad", codigoPaisAcad);
        datos.append("codigodepartamentoacad", codigoDepartamentoAcad);
        datos.append("codigoprovinciaacad", codigoProvinciaAcad);
        datos.append("codigoprovincia", codigoProvincia);
        datos.append("idlugaracad", idLugarAcad);
        Swal.fire({
            icon: "warning",
            title: "Confirmación de creacion",
            text: "¿Está seguro de guardar el lugar " + nombreLugarAcad + "?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            confirmButtonText: 'Guardar',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar'
        }).then(function (resultado) {
            if (resultado.value) {
                $.ajax({
                    url: "index.php?r=Administracion/lugares/guardar-lugar",
                    method: "POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (respuesta) {
                        if (respuesta === "ok") {
                            //$("#modalCrearLugar").modal('hide');
                            $("#vistaLugaresAcad").hide(500);
                            $("#vistaLugares").show(500);
                            //$("#tablaProvincias").show();
                            Swal.fire({
                                icon: "success",
                                title: "Creación Completada",
                                text: "El lugar " + nombreLugarAcad + " con código " + codigoLugarAcad + " ha sido guardado correctamente.",
                                showCancelButton: false,
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Cerrar"
                            }).then(function () {
                                $(".tablaLugares").DataTable().ajax.reload();
                            });
                        }
                        else {
                            let mensaje;
                            if (respuesta === "existe") {
                                mensaje = "El lugar " + nombreLugarAcad + " ya existe.";
                            } else {
                                mensaje = "Ocurrio un error al crear el lugar " + nombreLugarAcad + ". Comuniquese con el administrador del sistema.";
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
    ELIMINAR PROVINCIA
    =============================================*/
    $(".tablaLugares tbody").on("click", ".btnEliminarLugar", function () {
        let codigoLugar = $(this).attr("codigo-lugar");
        let nombreLugar = $(this).attr("nombre-lugar");
        let datos = new FormData();
        datos.append("codigolugar", codigoLugar);
        Swal.fire({
            icon: "warning",
            title: "Confirmación eliminación",
            text: "¿Está seguro de borrar el lugar " + nombreLugar + "?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            confirmButtonText: 'Borrar',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar'
        }).then(function (resultado) {
            if (resultado.value) {
                $.ajax({
                    url: "index.php?r=Administracion/lugares/eliminar-lugar",
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
                                text: "El lugar " + nombreLugar + "con el código " + codigoLugar + " ha sido borrado correctamente.",
                                showCancelButton: false,
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Cerrar"
                            }).then(function () {
                                $(".tablaLugares").DataTable().ajax.reload();
                                $(".tablaLugaresAcad").DataTable().ajax.reload();
                            });
                        }
                        else {
                            let mensaje;
                            if (respuesta === "enUso") {
                                mensaje = "No se puede eliminar el lugar " + nombreLugar + " con código " + codigoLugar + ", ya que está en uso actualmente y no puede ser eliminado. Solo puede ser inhabilitado.";
                            } else {
                                mensaje = "Ocurrio un error al eliminar el lugar con código " + codigoLugar + ". Comuniquese con el administrador del sistema.";
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
});