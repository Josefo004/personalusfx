$(document).ready(function () {
    /*=============================================
    CARGAR LA TABLA DINÁMICA DE Aportes
    =============================================*/    
    $("#tablaAportesLey").DataTable({
        ajax: {
            method: "POST",
            dataType: 'json',
            cache: false,
            url: 'index.php?r=Planillas/aportes-ley/listar-aportes',
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
    ACTIVAR Aporte
    =============================================*/
    $("#tablaAportesLey tbody").on("click", ".btnActivar", function () {
        //alert ("Hola Mundo");
        let objectBtn = $(this);
        let codigo = objectBtn.attr("codigo");
        let estado = objectBtn.attr("estado");
        let datos = new FormData();
        datos.append("codigoactivar", codigo);
        datos.append("estadoactivar", estado);
        $.ajax({
            url: 'index.php?r=Planillas/aportes-ley/activar-aporte',
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
                        text: "Ocurrio un error al cambiar el estado del Aporte " + codigo + ". Comuniquese con el administrador del sistema.",
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Cerrar'
                    });
                }
            }
        });
    });


    /*=============================================
    EDITAR APORTE
    =============================================*/
    $("#tablaAportesLey tbody").on("click", ".btnEditarAporte", function () {
        let codigo = $(this).attr("codigo");
        let datos = new FormData();
        $('#tituloAporte').text("Editar Aporte");
        datos.append("codigoeditar", codigo);
        $.ajax({
            url: 'index.php?r=Planillas/aportes-ley/buscar-aporte',
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (respuesta) {
                console.log(respuesta);
                $("#codigoAporteLeyUpd").val(respuesta["codigoAporteLey"]);
                $("#nombreAporteLeyUpd").val(respuesta["nombreAporteLey"]);
                $("#tipoAporteUpd").val(respuesta["tipoAporte"]);
                $("#porcentajeUpd").val(respuesta["porcentaje"]);
                $("#montoSalarioUpd").val(respuesta["montoSalario"]);
                $("#fechaInicioUpd").val(respuesta["fechaInicio"]);
                $("#fechaFinUpd").val(respuesta["fechaFin"]);
                $("#observacionesUpd").val(respuesta["observaciones"]);
                $("#codigoEstadoUpd").val(respuesta["codigoEstado"]);
                $("#fechaHoraRegistroUpd").val(respuesta["fechaRegistro"]);
                $("#codigoUsuarioUpd").val(respuesta["codigoUsuario"]);
            },
            error: function (respuesta) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "Ocurrio un error al cargar los datos " + codigo + ". Comuniquese con el administrador del sistema.",
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Cerrar'
                }).then(function () {
                    $('#modalActualizarAporte').modal('hide');
                });
            }
        });
    });

    /*=============================================
    ACTUALIZAR PERSONA
    =============================================*/
    $("#btnActualizarAporte").click(function () {

        let codigoAporteLey = $("#codigoAporteLeyUpd").val();
        let nombreAporteLey = $("#nombreAporteLeyUpd").val();
        let tipoAporte = $("#tipoAporteUpd").val();
        let porcentaje = $("#porcentajeUpd").val();
        let montoSalario = $("#montoSalarioUpd").val();
        let fechaInicio = $("#fechaInicioUpd").val();
        let fechaFin = $("#fechaFinUpd").val();
        let observaciones = $("#observacionesUpd").val();
        let codigoEstado = $("#codigoEstadoUpd").val();
        let fechaHoraRegistro = $("#fechaHoraRegistroUpd").val();
        let codigoUsuario = $("#codigoUsuarioUpd").val();
        
        let datos = new FormData();
        datos.append("codigoAporteLeyactualizar", codigoAporteLey);
        datos.append("nombreAporteLeyactualizar", nombreAporteLey);
        datos.append("tipoAporteactualizar", tipoAporte);
        datos.append("porcentajeactualizar", porcentaje);
        datos.append("montoSalarioactualizar", montoSalario);
        datos.append("observacionesactualizar", observaciones);
        datos.append("fechaInicioactualizar", fechaInicio);
        datos.append("fechaFinactualizar", fechaFin);
        datos.append("codigoEstadoactualizar", codigoEstado);
        datos.append("fechaHoraRegistroactualizar", fechaHoraRegistro);
        datos.append("codigoUsuarioactualizar", codigoUsuario);
        $.ajax({
            url: 'index.php?r=Planillas/aportes-ley/actualizar-aporte',
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                if (respuesta === "ok") {
                    $("#modalActualizarAporte").modal('hide');
                    
                    Swal.fire({
                        icon: "success",
                        title: "Operación Completada",
                        text: "Los datos del Aporte se guardaron correctamente.",
                        showCancelButton: false,
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Cerrar"
                    }).then(function () {
                        $("#tablaAportesLey").DataTable().ajax.reload();
                    });
                }
                else {
                    let mensaje;
    
                    mensaje = "Ocurrio un error al Guardar los datos del aporte Comuniquese con el administrador del sistema.";
                    
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

    $("#nuevoAporte").click(function(){
        $('#tituloAporte').text("Nuevo Aporte");
        //alert("nuevo Aporte");
        $("#codigoAporteLeyUpd").val("0");
        $("#nombreAporteLeyUpd").val("");
        $("#tipoAporteUpd").val("");
        $("#porcentajeUpd").val("0");
        $("#montoSalarioUpd").val("0");
        $("#fechaInicioUpd").val("");
        $("#fechaFinUpd").val("");
        $("#observacionesUpd").val("");
        $("#codigoEstadoUpd").val("V");
        $("#fechaHoraRegistroUpd").val("");
        $("#codigoUsuarioUpd").val("LNN");
    });

});
