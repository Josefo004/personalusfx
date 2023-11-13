$(document).ready(function(){
    $(".tablaAsignaciones").DataTable({
        columnDefs: [
            {targets: "_all", className: "SmallFont"}
        ],
        ajax: {
            method: "POST",
            dataType: 'json',
            cache: false,
            url: 'index.php?r=Filiacion/transferencia-administrativo/listar-asignaciones-ajax',
            data:{
                "Codigo":function ( d ) {
                    return $('#Codigo').val();
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

    $(".tablaAsignacionesSeleccionadas").DataTable({
        ajax: {
            method: "POST",
            dataType: 'json',
            cache: false,
            url: 'index.php?r=Filiacion/transferencia-administrativo/listar-asignaciones-seleccionadas-ajax',
            data:{
                "Codigo":$("#Codigo").val()
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

    var table = $(".tablaAsignaciones").DataTable();

    $("#btnMostrarAgregarAsignaciones").on("click", function () {
        $(".tablaAsignaciones").DataTable().ajax.reload();
    });

    $('.tablaAsignaciones tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
        let data = table.row(this).node();
        let id = $(data).find('input');
        if (id.prop('checked'))
        {
            id.prop( "checked", false );
        } else {
            id.prop( "checked", true );
        }
    });

    /*=============================================
    GUARDAR ASIGNACIONES
    =============================================*/
    $("#btnGuardarTransferenciaDetalleAdministrativo").on("click", function () {
        $flag = false ;
        $(".tablaAsignaciones").DataTable().rows().every(function () {
            var data = this.node();
            var Chk = $(data).find('input');
            if (Chk.prop('checked')) {
                $flag = true;
                let transferencia = Chk.attr("codigotransferencia");
                let trabajador = Chk.attr("codigotrabajador");
                let item = Chk.attr("nroitem");
                let nivelsalarial = Chk.attr('codigonivelsalarial');
                let accion = 1;
                let datos = new FormData();
                datos.append("codigotransferencia", transferencia);
                datos.append("codigotrabajador", trabajador);
                datos.append("nroitem", item);
                datos.append("codigonivelsalarial", nivelsalarial);
                datos.append("accion", accion);
                $.ajax({
                    url: "index.php?r=Filiacion/transferencia-administrativo/registro-asignaciones-ajax",
                    method: "POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (respuesta) {
                        //let mensaje = '';
                        //let estado = true;
                        /*switch (respuesta){

                            case 'ok': estado = true; break;
                            case 'ErrorE': mensaje = 'Ocurrio un error debido a un envio incorrecto de datos comuniquese con el administrador del sistema'; estado = false; break;
                            case 'ErrorIA': mensaje = 'Ocurrio un error en el insertado de la informacion agrupacion'; estado = false; break;
                            case 'ErrorID': mensaje = 'Ocurrio un error en el insertado de la informacion detalle'; estado = false; break;
                            case 'ErrorDD': mensaje = 'Ocurrio un error al eliminar detalle'; estado = false; break;
                            case 'ErrorDA': mensaje = 'Ocurrio un error al eliminar agrupacion'; estado = false; break;
                            default:{
                                estado = false;
                                mensaje = respuesta;
                            }
                        }
                        if (!estado){
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: mensaje,
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Cerrar'
                            });
                        }*/
                    }
                });
            }
        });
        if ($flag){
            Swal.fire({
                icon: 'success',
                title: 'Procesado correcto',
                text: 'Los trabajadores fueron registrados correctamente',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Cerrar'
            });
            $('#modalAgregarAsignacion').modal('hide');
            $(".tablaAsignacionesSeleccionadas").DataTable().ajax.reload();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Sin datos',
                text: 'No existe ningun trabajador seleccionado',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Cerrar'
            });
        }
    });

    $('.tablaAsignaciones tbody').on( 'click', 'button', function () {
        var data = table.row( $(this).parents('tr') ).data();
        if ( $(this).hasClass('btn-outline-success') ){
            $(this).removeClass('btn-outline-success');
            $(this).addClass('btn-success');
        } else {
            $(this).removeClass('btn-success');
            $(this).addClass('btn-outline-success');
        }
        $("#"+data[0]).click();
        $(this).parents('tr').toggleClass('selected');
    } );

    $('.tablaAsignaciones tbody').on( '', '', function () {
        let objectchk = $(this);
        let transferencia = objectchk.attr("transferencia");
        let trabajador = objectchk.attr("trabajador");
        let item = objectchk.attr("item");
        let nivelsalarial = objectchk.attr('nivelsalarial');
        let accion = 0;
        if (objectchk.prop('checked'))
        {
            accion = 1;
        }
        let datos = new FormData();
        datos.append("transferencia", transferencia);
        datos.append("trabajador", trabajador);
        datos.append("item", item);
        datos.append("nivelsalarial", nivelsalarial);
        datos.append("accion", accion);
        $.ajax({
            url: "index.php?r=Filiacion/transferencia-administrativo/registro-asignaciones-ajax",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                let mensaje = '';
                let estado = true;
                switch (respuesta){
                    case 'ok': estado = true; break;
                    case 'ErrorE': mensaje = 'Ocurrio un error debido a un envio incorrecto de datos comuniquese con el administrador del sistema'; estado = false; break;
                    case 'ErrorIA': mensaje = 'Ocurrio un error en el insertado de la informacion agrupacion'; estado = false; break;
                    case 'ErrorID': mensaje = 'Ocurrio un error en el insertado de la informacion detalle'; estado = false; break;
                    case 'ErrorDD': mensaje = 'Ocurrio un error al eliminar detalle'; estado = false; break;
                    case 'ErrorDA': mensaje = 'Ocurrio un error al eliminar agrupacion'; estado = false; break;
                    default:{
                        estado = false;
                        mensaje = respuesta;
                    }
                }
                if (!estado){
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: mensaje,
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Cerrar'
                    });
                }
            }
        });
    });

    /*=============================================
    ELIMINAR TRABAJADOR REGISTRADA
    =============================================*/
    $(".tablaAsignacionesSeleccionadas tbody").on("click", ".btnEliminarTransferenciaDetalleAdministrativo", function () {
        let codigoTransferencia = $(this).attr("codigo");
        let codigoTrabajador = $(this).attr("trabajador");
        let nroItem = $(this).attr("item");
        let tipoTransferencia = $(this).attr("tipo");
        let datos = new FormData();
        datos.append("codigo", codigoTransferencia);
        datos.append("trabajador", codigoTrabajador);
        datos.append("item", nroItem);
        datos.append("tipo", tipoTransferencia);
        Swal.fire({
            icon: "warning",
            title: "Confirmación eliminación",
            text: "¿Está seguro de eliminar este registro?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            confirmButtonText: 'Borrar',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar'
        }).then(function (resultado) {
            if (resultado.value) {
                $.ajax({
                    url: "index.php?r=Filiacion/transferencia-administrativo/eliminar-transferencia-detalle-administrativo-ajax",
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
                                text: "El registro  ha sido borrado correctamente.",
                                showCancelButton: false,
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Cerrar"
                            }).then(function () {
                                $(".tablaAsignacionesSeleccionadas").DataTable().ajax.reload();
                            });
                        }
                        else {
                            let mensaje;
                            mensaje = "Ocurrio un error al eliminar el aporte de ley con código  Comuniquese con el administrador del sistema.";
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
    IR TRANSFERENCIA ASIGNACION
    ==================================================*/
    $("#btnirTransferenciaAsignacion").on("click", function () {
        var codigoTransferencia = $('#Codigo').val();
        window.location = 'index.php?r=Filiacion/transferencia-administrativo/ir-transferencia-asignacion&codigoTransferencia=' + codigoTransferencia;
    });

});