$(document).ready(function(){
    $("#vistaPersonas").hide();
    $("#vistaCrearTrabajadorPestañas").hide();
    //$(".entrada-datos").hide();

    $("#btnCancelar").click(function () {
        $("#vistaTrabajadores").show(300);
        $("#vistaPersonas").hide(300);
        $("#vistaCrearTrabajadorPestañas").hide(300);
    });
});

$(document).ready(function () {
    $('#fechaIngresoNew').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });
    $('#fechaIngresoUpd').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });
    $('#fechaSalidaNew').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });
    $('#fechaSalidaUpd').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });
    $('#fechaResolucionDocenteNew').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });
    $('#fechaResolucionDocenteUpd').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });
    $('#fechaResolucionAdministrativoNew').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });
    $('#fechaResolucionAdministrativoUpd').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });

});
/*=============================================
CARGAR LA TABLA DINÁMICA DE FUNCIONARIOS
=============================================*/
$(".tablaTrabajadores").DataTable({
    //"ajax": "index.php?r=trabajadores/listar-trabajadores-ajax",
    ajax: {
        method: "POST",
        dataType: 'json',
        cache: false,
        url: 'index.php?r=Filiacion/trabajadores/listar-funcionarios',
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
CARGAR LA TABLA DINÁMICA DE PERSONAS
=============================================*/
$("#tablaPersonas").DataTable({
    //"ajax": "index.php?r=trabajadores/listar-personas-ajax",
    ajax: {
        method: "POST",
        dataType: 'json',
        cache: false,
        url: 'index.php?r=Filiacion/trabajadores/listar-personas',
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
ACTIVAR TRABAJADOR
=============================================*/
$(".tablaTrabajadores tbody").on("click", ".btnActivar", function () {
    let objectBtn = $(this);
    let codigo = objectBtn.attr("codigo");
    let estado = objectBtn.attr("estado");
    let datos = new FormData();
    datos.append("codigoactivar", codigo);
    datos.append("estadoactivar", estado);
    $.ajax({
        url: "index.php?r=Filiacion/trabajadores/activar-trabajador-ajax",
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
SELECCIONAR PERSONA
=============================================*/
$("#tablaPersonas tbody").on("click", ".btnElegir", function () {
    let objectBtn = $(this);
    let idPersona = objectBtn.attr("codigo");
    let nombre = objectBtn.attr("nombre");
    $("#vistaTrabajadores").hide(300);
    $("#vistaPersonas").hide(300);
    $("#vistaCrearTrabajadorPestañas").show(300);
    $("#idPersonaNew").val(idPersona);
    $("#idPersonaDatosNew").val(idPersona);
    $("#nombreCompletoNew").val(nombre);
    let datos = new FormData();
    datos.append("idpersona", idPersona);
    /*$.ajax({
        url: "index.php?r=Filiacion/trabajadores/generar-codigo-trabajador-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            if (respuesta != "error"){
                $("#idFuncionarioNew").val(respuesta);
            }
            else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "Ocurrio un error al generar el código del trabajador " + nombre + ". Comuniquese con el administrador del sistema.",
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Cerrar'
                });
            }
        }
    });*/
});
/*=============================================
MOSTRAR CREAR TRABAJADOR
=============================================*/
$("#btnMostrarCrearTrabajador").click(function () {
    $("#vistaTrabajadores").hide(300);
    $("#vistaPersonas").show(300);
    $("#vistaCrearTrabajadorPestañas").hide(300);
});
/*=============================================
CREAR TRABAJADOR
=============================================*/
$("#btnCrearTrabajador").click(function () {
    //let idFuncionario = $("#idFuncionarioNew").val();
    let idPersona = $("#idPersonaNew").val();
    let nombreCompleto = $("#nombreCompletoNew").val();
    let codigoSectorTrabajo = $("#codigoSectorTrabajoNew").val();
    let fechaIngreso = $("#fechaIngresoNew").val();
    let fechaSalida = $("#fechaSalidaNew").val();
    let fechaCalculoAntiguedad = $("#fechaCalculoAntiguedadNew").val();
    let antiguedadExternaReconocida = $("#antiguedadExternaReconocidaNew").val();
    let fechaCalculoVacaciones = $("#fechaCalculoVacacionesNew").val();
    let fechaFiniquito = $("#fechaFiniquitoNew").val();

    let idPersonaDatos = $("#idPersonaDatosNew").val();
    let codigoAfp = $("#codigoAfpNew").val();
    let resolucionAfp = $("#resolucionAfpNew").val();
    let fechaRegistroAfp = $("#fechaRegistroAfpNew").val();
    let primerMesRegistroAfp = $("#fechaPrimerRegistroAfpNew").val();
    let ultimoMesRegistroAfp = $("#ultimoMesRegistroAfpNew").val();
    let exclusionVoluntariaAfp = $("#exclusionVoluntariaNew").val();
    let nua = $("#nuaNew").val();
    let seguroSocial = $("#codigoSeguroSaludNew").val();
    let codigoBanco = $("#codigoBancoNew").val();
    let nroCuenta = $("#nroCuentaBancariaNew").val();
    let tipoRenta = $("#codigoTipoRentaNew").val();
    let datos = new FormData();
    datos.append("idpersonacrear", idPersona);
    datos.append("codigosectortrabajocrear", codigoSectorTrabajo);
    datos.append("fechaingresocrear", fechaIngreso);
    datos.append("fechasalidacrear", fechaSalida);
    datos.append("fechacalculoantiguedadcrear", fechaCalculoAntiguedad);
    datos.append("antiguedadexternareconocidacrear", antiguedadExternaReconocida);
    datos.append("fechacalculovacacionescrear", fechaCalculoVacaciones);
    datos.append("fechafiniquitocrear", fechaFiniquito);

    datos.append("idpersonadatoscrear", idPersonaDatos);
    datos.append("resolucionafpcrear", resolucionAfp);
    datos.append("codigoafpcrear", codigoAfp);
    datos.append("fecharegistroafpcrear", fechaRegistroAfp);
    datos.append("primermesregistroafpcrear", primerMesRegistroAfp);
    datos.append("ultimomesregistroafpcrear", ultimoMesRegistroAfp);
    datos.append("exclusionvoluntariaafpcrear", exclusionVoluntariaAfp);
    datos.append("nuacrear", nua);
    datos.append("segurosocialcrear", seguroSocial);
    datos.append("codigobancocrear",codigoBanco);
    datos.append("nrocuentabancariacrear",nroCuenta);
    datos.append("tiporentacrear",tipoRenta);
    $.ajax({
        url: "index.php?r=Filiacion/trabajadores/crear-trabajador-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            if (respuesta === "ok"){
                Swal.fire({
                    icon: "success",
                    title: "Creación Completada",
                    text: "Los datos de trabajador de la persona " + nombreCompleto + " con C.I. " + idPersona + "ha sido guardado correctamente.",
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Cerrar"
                }).then(function(){
                    $("#tablaTrabajadores").DataTable().ajax.reload();
                    $("#vistaTrabajadores").show(300);
                    $("#vistaPersonas").hide(300);
                    $("#vistaCrearTrabajadorPestañas").hide(300);
                });
            }
            else{
                let mensaje;
                if(respuesta === "existe"){
                    mensaje = "El trabajador con código " + idPersona + " ya existe o la persona ya tiene un código de trabajador asignado. Ingrese otro código.";
                }else{
                    mensaje = "Ocurrio un error al crear los datos de trabajador de la persona " + nombreCompleto + ". Comuniquese con el administrador del sistema.";
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
});
/*=============================================
EDITAR TRABAJADOR
=============================================*/
$(".tablaTrabajadores tbody").on("click", ".btnEditarTrabajador", function () {
    let codigo = $(this).attr("codigo");
    let idpersona = $(this).attr("idpersona");
    let fechaactuializacion = $(this).attr("fechaactualizacion");
    let datos = new FormData();
    datos.append("codigoeditar", codigo);
    datos.append("idpersonaeditar", idpersona);
    datos.append("fechaactualizacioneditar", fechaactuializacion);
    $.ajax({
        url: "index.php?r=Filiacion/trabajadores/buscar-trabajador-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            if (respuesta != "error"){
                $(".entrada-datos").show();
                $("#idFuncionarioUpd").val(respuesta["IdFuncionario"]);
                $("#idPersonaUpd").val(respuesta["IdPersona"]);
                $("#nombreCompletoUpd").val(respuesta["NombreCompleto"]);
                $("#codigoTrabajadorUpd").val(respuesta["CodigoTrabajador"]);
                $("#codigoSectorTrabajoUpd").val(respuesta["CodigoSectorTrabajo"]);
                $("#resolucionAfpUpd").val(respuesta["ResolucionAFP"]);
                $("#codigoAfpUpd").val(respuesta["CodigoAFP"]);
                $("#fechaPrimerRegistroAfpUpd").val(respuesta["FechaPrimerRegistroAFP"]);
                $("#ultimoMesRegistroAfpUpd").val(respuesta["UltimoMesRegistroAFP"]);
                $("#exclusionVoluntariaUpd").val(respuesta["ExclusionVoluntariaAFP"]);
                $("#nuaUpd").val(respuesta["NUA"]);
                $("#codigoSeguroSaludUpd").val(respuesta["CodigoSeguroSocial"]);
                $("#codigoBancoUpd").val(respuesta["CodigoBanco"]);
                $("#nroCuentaBancariaUpd").val(respuesta["NroCuentaBancaria"]);
                $("#codigoTipoRentaUpd").val(respuesta["CodigoTipoRenta"]);

                $("#idPersonaDatosUpd").val(respuesta["IdPersona"]);
                $("#fechaActualizacionUpd").val(respuesta["FechaActualizacion"]);
                $("#fechaIngresoUpd").val(respuesta["FechaIngreso"]);
                $("#fechaSalidaUpd").val(respuesta["FechaSalida"]);
                $("#fechaCalculoAntiguedadUpd").val(respuesta["FechaCalculoAntiguedad"]);
                $("#antiguedadExternaReconocidaUpd").val(respuesta["AntiguedadExternaReconocida"]);
                $("#fechaCalculoVacacionesUpd").val(respuesta["FechaCalculoVacaciones"]);
                $("#fechaFiniquitoUpd").val(respuesta["FechaFiniquito"]);
            }
            else{
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "Ocurrio un error al cargar los datos del trabajador con código . Comuniquese con el administrador del sistema.",
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Cerrar'
                }).then(function(){
                    $('#modalActualizarTrabajador').modal('hide');
                });
            }
        }
    });
});
/*=============================================
ACTUALIZAR TRABAJADOR
=============================================*/
$("#btnActualizarTrabajador").click(function () {
    let idFuncionario = $("#idFuncionarioUpd").val();
    let idPersona = $("#idPersonaUpd").val();
    let nombreCompleto = $("#nombreCompletoUpd").val();
    let codigoSectorTrabajo = $("#codigoSectorTrabajoUpd").val();
    let fechaIngreso = $("#fechaIngresoUpd").val();
    let fechaSalida = $("#fechaSalidaUpd").val();
    let fechaCalculoAntiguedad = $("#fechaCalculoAntiguedadUpd").val();
    let antiguedadExternaReconocida = $("#antiguedadExternaReconocidaUpd").val();
    let fechaCalculoVacaciones = $("#fechaCalculoVacacionesUpd").val();
    let fechaFiniquito = $("#fechaFiniquitoUpd").val();

    let idPersonaDatos = $("#idPersonaDatosUpd").val();
    let fechaHoraActualizacion = $("#fechaActualizacionUpd").val();
    let codigoAfp = $("#codigoAfpUpd").val();
    let resolucionAfp = $("#resolucionAfpUpd").val();
    let fechaRegistroAfp = $("#fechaRegistroAfpUpd").val();
    let primerMesRegistroAfp = $("#fechaPrimerRegistroAfpUpd").val();
    let ultimoMesRegistroAfp = $("#ultimoMesRegistroAfpUpd").val();
    let exclusionVoluntariaAfp = $("#exclusionVoluntariaUpd").val();
    let nua = $("#nuaUpd").val();
    let seguroSocial = $("#codigoSeguroSaludUpd").val();
    let codigoBanco = $("#codigoBancoUpd").val();
    let nroCuenta = $("#nroCuentaBancariaUpd").val();
    let tipoRenta = $("#codigoTipoRentaUpd").val();
    let datos = new FormData();
    datos.append("idfuncionarioactualizar", idFuncionario);
    datos.append("idpersonaactualizar", idPersona);
    datos.append("codigosectortrabajoactualizar", codigoSectorTrabajo);
    datos.append("fechaingresoactualizar", fechaIngreso);
    datos.append("fechasalidaactualizar", fechaSalida);
    datos.append("fechacalculoantiguedadactualizar", fechaCalculoAntiguedad);
    datos.append("antiguedadexternareconocidaactualizar", antiguedadExternaReconocida);
    datos.append("fechacalculovacacionesactualizar", fechaCalculoVacaciones);
    datos.append("fechafiniquitoactualizar", fechaFiniquito);

    datos.append("idpersonadatosactualizar", idPersonaDatos);
    datos.append("fechahoraactualizar", fechaHoraActualizacion);
    datos.append("resolucionafpactualizar", resolucionAfp);
    datos.append("codigoafpactualizar", codigoAfp);
    datos.append("fecharegistroafpactualizar", fechaRegistroAfp);
    datos.append("primermesregistroafpactualizar", primerMesRegistroAfp);
    datos.append("ultimomesregistroafpactualizar", ultimoMesRegistroAfp);
    datos.append("exclusionvoluntariaafpactualizar", exclusionVoluntariaAfp);
    datos.append("nuaactualizar", nua);
    datos.append("segurosocialactualizar", seguroSocial);
    datos.append("codigobancoactualizar",codigoBanco);
    datos.append("nrocuentabancariaactualizar",nroCuenta);
    datos.append("tiporentaactualizar",tipoRenta);
    $.ajax({
        url: "index.php?r=Filiacion/trabajadores/actualizar-trabajador-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            if (respuesta === "ok"){
                $("#modalActualizarTrabajador").modal('hide');
                Swal.fire({
                    icon: "success",
                    title: "Actualización Completada",
                    text: "Los datos de trabajador de la persona " + nombreCompleto + " ha sido guardado correctamente .",
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Cerrar"
                }).then(function(){
                    $("#tablaTrabajadores").DataTable().ajax.reload(null, false);
                });
            }
            else{
                let mensaje;
                if(respuesta === "existe"){
                    mensaje = "El trabajador con código " + idFuncionario + " ya existe o la persona ya tiene un código de trabajador asignado. Ingrese otro código.";
                }else{
                    mensaje = "Ocurrio un error al actualizar los datos de trabajador de la persona " + nombreCompleto + ". Comuniquese con el administrador del sistema.";
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
});
/*=============================================
ELIMINAR TRABAJADOR
=============================================*/
$(".tablaTrabajadores tbody").on("click", ".btnEliminarTrabajador", function () {
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
                url: "index.php?r=Filiacion/trabajadores/eliminar-trabajador-ajax",
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
                            $("#tablaTrabajadores").DataTable().ajax.reload();
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
});