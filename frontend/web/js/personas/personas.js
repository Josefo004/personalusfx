$(document).ready(function () {
    $('.select2').select2();
    $('#fechaNacimientoNew').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });
    $('#fechaNacimientoUpd').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });
    $("#tablaPersonas_wrapper").show();
    $("#vistaPersonasDeclaracionJurada").hide();
    $("#vistaCrearPersona").hide();
    $("#vistaCrearPersonaPestañas").hide();
    $(".entrada-datos1").hide();
    $(".entrada-datos2").hide();
    $(".entrada-datos1Upd").hide();
    $(".entrada-datos2Upd").hide();
    $("#vistaActuaizarPersonaPestañas").hide();

    $("#btnCancelar").click(function () {
        $("#vistaPersonas").show(300);
        $("#vistaPersonasDeclaracionJurada").hide(300);
        $("#vistaCrearPersona").hide(300);
        $("#vistaCrearPersonaPestañas").hide(300);
        $(".entrada-datos1").hide(300);
        $(".entrada-datos2").hide(300);
        $(".entrada-datos1Upd").hide(300);
        $(".entrada-datos2Upd").hide(300);
        $("#vistaActuaizarPersonaPestañas").hide(300);
    });

    /*=============================================
    CARGAR LA TABLA DINÁMICA DE PERSONAS
    =============================================*/
    $(".tablaPersonas").DataTable({
        //"ajax": "index.php?r=personas/listar-personas-ajax",
        ajax: {
            method: "POST",
            dataType: 'json',
            cache: false,
            url: 'index.php?r=Filiacion/personas/listar-personas',
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
    CARGAR LA TABLA DINÁMICA DE PERSONAS DECLARACIONES JURADAS
    =============================================*/
    $("#tablaPersonasDeclaracionJurada").DataTable({
        //"ajax": "index.php?r=personas/listar-personas-ajax",
        ajax: {
            method: "POST",
            dataType: 'json',
            cache: false,
            url: 'index.php?r=Filiacion/personas/listar-personas-declaracion-jurada-ajax',
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
    ACTIVAR PERSONA
    =============================================*/
    $(".tablaPersonas tbody").on("click", ".btnActivar", function () {
        let objectBtn = $(this);
        let codigo = objectBtn.attr("codigo");
        let estado = objectBtn.attr("estado");
        let datos = new FormData();
        datos.append("codigoactivar", codigo);
        datos.append("estadoactivar", estado);
        $.ajax({
            url: "index.php?r=Filiacion/personas/activar-persona-ajax",
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
                        text: "Ocurrio un error al cambiar el estado de la persona con C.I " + codigo + ". Comuniquese con el administrador del sistema.",
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
    $(".codigoPais").change(function () {
        let pais = $(this).val();
        if (pais != "") {
            let datos = new FormData();
            datos.append("codigopais", pais);
            $.ajax({
                url: "index.php?r=Filiacion/personas/listar-departamentos-ajax",
                method: "POST",
                dataType: 'html',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    $(".codigoDepartamento").empty().append(respuesta);
                    $(".codigoDepartamento").prop("disabled", false);
                    $(".codigoProvincia").empty().append("<option value=''>Selecionar Provincia</option>");
                    $(".codigoProvincia").prop("disabled", true);
                    $(".codigoLugar").empty().append("<option value=''>Selecionar Lugar</option>");
                    $(".codigoLugar").prop("disabled", true);
                }
            });
        } else {
            $(".codigoDepartamento").empty().append("<option value=''>Selecionar Departamento</option>");
            $(".codigoDepartamento").prop("disabled", true);
            $(".codigoProvincia").empty().append("<option value=''>Selecionar Provincia</option>");
            $(".codigoProvincia").prop("disabled", true);
            $(".codigoLugar").empty().append("<option value=''>Selecionar Lugar</option>");
            $(".codigoLugar").prop("disabled", true);
        }
    });
    /*=============================================
    SELECCIONAR DEPARTAMENTO
    =============================================*/
    $(".codigoDepartamento").change(function () {
        let pais;
        if ($(this).attr("nuevo") === "si") {
            pais = $("#codigoPaisNew").val();
        } else {
            pais = $("#codigoPaisUpd").val();
        }
        let departamento = $(this).val();
        if (departamento != "") {
            let datos = new FormData();
            datos.append("codigopais", pais);
            datos.append("codigodepartamento", departamento);
            $.ajax({
                url: "index.php?r=Filiacion/personas/listar-provincias-ajax",
                method: "POST",
                dataType: 'html',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    $(".codigoProvincia").empty().append(respuesta);
                    $(".codigoProvincia").prop("disabled", false);
                    $(".codigoLugar").empty().append("<option value=''>Selecionar Lugar</option>");
                    $(".codigoLugar").prop("disabled", true);
                }
            });
        } else {
            $(".codigoProvincia").empty().append("<option value=''>Selecionar Provincia</option>");
            $(".codigoProvincia").prop("disabled", true);
            $(".codigoLugar").empty().append("<option value=''>Selecionar Lugar</option>");
            $(".codigoLugar").prop("disabled", true);
        }
    });
    /*=============================================
    SELECCIONAR PROVINCIA
    =============================================*/
    $(".codigoProvincia").change(function () {
        let pais;
        let departamento;
        if ($(this).attr("nuevo") === "si") {
            pais = $("#codigoPaisNew").val();
            departamento = $("#codigoDepartamentoNew").val();
        } else {
            pais = $("#codigoPaisUpd").val();
            departamento = $("#codigoDepartamentoUpd").val();
        }
        let provincia = $(this).val();
        if (provincia != "") {
            let datos = new FormData();
            datos.append("codigopais", pais);
            datos.append("codigodepartamento", departamento);
            datos.append("codigoprovincia", provincia);
            $.ajax({
                url: "index.php?r=Filiacion/personas/listar-lugares-ajax",
                method: "POST",
                dataType: 'html',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    $(".codigoLugar").empty().append(respuesta);
                    $(".codigoLugar").prop("disabled", false);
                }
            });
        } else {
            $(".codigoLugar").empty().append("<option value=''>Selecionar Lugar</option>");
            $(".codigoLugar").prop("disabled", true);
        }
    });
    /*=============================================
    MOSTRAR SELECCIONAR PERSONA
    =============================================*/
    $("#btnMostrarSeleccionarPersona").click(function () {
        $("#vistaPersonasDeclaracionJurada").show(300);
        $("#vistaPersonas").hide(300);
        $(".entrada-datos1").hide(300);
        $(".entrada-datos2").hide(300);
    });

    $("#tablaPersonasDeclaracionJurada tbody").on("click", ".btnElegir", function () {
        let idPersona = $(this).attr("idpersona");
        let emision = $(this).attr("emision");
        let paterno = $(this).attr("paterno");
        let materno = $(this).attr("materno");
        let nombres = $(this).attr("nombres");
        let fechaNacimiento = $(this).attr("fechanacimiento");
        let sexo = $(this).attr("sexo");
        let estadoCivil = $(this).attr("estadocivil");
        //let sexoLiteral = $(this).attr("sexoliteral");
        let direccion = $(this).attr("direccion");
        let datos = new FormData;
        $("#idPersonaNew").val(idPersona);
        $("#numeroDocumentoNew").val(idPersona);
        $("#lugarExpedicionNew").val(emision);
        $("#apellidoPaternoNew").val(paterno);
        $("#apellidoMaternoNew").val(materno);
        $("#primerNombreNew").val(nombres);
        $("#fechaNacimientoNew").val(fechaNacimiento);
        $("#sexoNew").val(sexo);
        $("#codigoEstadoCivilNew").val(estadoCivil);
        $("#domicilioNew").val(direccion);
        //$("#libretaServicioMilitarNew").val(libretaMilitar);
        $("#vistaPersonasDeclaracionJurada").hide(300);
        $("#tablaPersonas_wrapper").hide(300);
        $("#vistaCrearPersona").hide(300);
        $(".entrada-datos1").hide(300);
        $(".entrada-datos2").hide(300);
        $("#vistaCrearPersonaPestañas").show(300);
    });
    /*=============================================
    CREAR PERSONA
    =============================================*/
    $("#btnCrearPersona").click(function () {
        $(".entrada-datos1").hide(300);
        $(".entrada-datos2").show(300);
    });

    $("#btnCrearPersonaDatos").click(function () {
        let idPersona = $("#idPersonaNew").val();
        let numeroDocumento = $("#numeroDocumentoNew").val();
        let lugarExpedicion = $("#lugarExpedicionNew").val();
        let tipoDocumento = $("#tipoDocumentoNew").val();
        let primerNombre = $("#primerNombreNew").val();
        let segundoNombres = $("#segundoNombresNew").val();
        let tercerNombre = $("#tercerNombreNew").val();
        let apellidoPaterno = $("#apellidoPaternoNew").val();
        let apellidoMaterno = $("#apellidoMaternoNew").val();
        let fechaNacimiento = $("#fechaNacimientoNew").val();
        let sexo = $("#sexoNew").val();
        let codigoEstadoCivil = $("#codigoEstadoCivilNew").val();
        //let discapacidad = $("#discapacidadNew").val();
        let domicilio = $("#domicilioNew").val();
        let libretaMilitar = $("#libretaServicioMilitarNew").val();
        let datos = new FormData();
        datos.append("idpersonacrear", idPersona);
        datos.append("numerodocumentocrear", numeroDocumento);
        datos.append("lugarexpedicioncrear", lugarExpedicion);
        datos.append("tipodocumentocrear", tipoDocumento);
        datos.append("primernombrecrear", primerNombre);
        datos.append("segundonombrescrear", segundoNombres);
        datos.append("tercernombrecrear", tercerNombre);
        datos.append("apellidopaternocrear", apellidoPaterno);
        datos.append("apllidomaternocrear", apellidoMaterno);
        datos.append("fechanacimientocrear", fechaNacimiento);
        datos.append("sexocrear", sexo);
        datos.append("codigoestadocivilcrear", codigoEstadoCivil);
        //datos.append("discapacidadcrear", discapacidad);
        datos.append("domiciliocrear", domicilio);
        datos.append("libretamilitarcrear", libretaMilitar);
        $.ajax({
            url: "index.php?r=Filiacion/personas/crear-persona-ajax",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                if (respuesta === "ok") {
                    Swal.fire({
                        icon: "success",
                        title: "Creación Completada",
                        text: "La persona " + primerNombre  + " " + segundoNombres + + " " + tercerNombre + " " + apellidoPaterno + " " + apellidoMaterno + " ha sido guardado correctamente.",
                        showCancelButton: false,
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Cerrar"
                    }).then(function () {
                        $(".tablaPersonas").DataTable().ajax.reload();
                        $("#vistaPersonas").show(200);
                        $("#tablaPersonas_wrapper").show();
                        $(".entrada-datos1").hide(300);
                        $(".entrada-datos2").hide(300);
                        $("#vistaCrearPersonaPestañas").hide(300);
                    });
                }
                else {
                    let mensaje;
                    if (respuesta === "existe") {
                        mensaje = "La persona con C.I " + idPersona + " ya existe. Ingrese otro C.I..";
                    } else {
                        mensaje = "Ocurrio un error al crear la persona " + primerNombre  + " " + segundoNombres + + " " + tercerNombre + " " + apellidoPaterno + " " + apellidoMaterno + ". Comuniquese con el administrador del sistema.";
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
    MOSTRAR CREAR NUEVA PERSONA
    =============================================*/
    $("#btnCrearNuevaPersona").click(function () {
        $("#idPersonaNew").val("");
        $("#emisionNew").val("");
        $("#paternoNew").val("");
        $("#maternoNew").val("");
        $("#nombresNew").val("");
        $("#fechaNacimientoNew").val("");
        $("#sexoNew").val("");
        $("#discapacidadNew").val("");
        $("#cantidadDependientesDescapacidadNew").val("");
        $("#codigoPaisNew").val("");
        $("#codigoDepartamentoNew").val("");
        $("#codigoProvinciaNew").val("");
        $("#codigoLugarNacimientoNew").val("");
        $("#codigoEstadoCivilNew").val("");
        $("#apellidoEsposoUpd").val("");
        $("#direccionUpd").val("");
        $("#telefonoNew").val("");
        $("#celularNew").val("");
        $("#vistaPersonasDeclaracionJurada").hide(300);
        $("#tablaPersonas_wrapper").hide(300);
        $("#vistaCrearPersonaPestañas").show(300);
        $(".entrada-datos1").show(300);
        $(".entrada-datos2").hide(300);
    });
    /*=============================================
    EDITAR PERSONA
    =============================================*/
    $(".tablaPersonas tbody").on("click", ".btnEditarPersona", function () {
        let codigo = $(this).attr("codigo");
        let datos = new FormData();
        datos.append("codigoeditar", codigo);
        $.ajax({
            url: "index.php?r=Filiacion/personas/buscar-persona-ajax",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (respuesta) {
                $("#idPersonaUpd").val(respuesta["IdPersona"]);
                //$("#idPersonaDatosUpd").val(respuesta["IdPersona"]);
                $("#lugarExpedicionUpd").val(respuesta["LugarExpedicion"]);
                $("#tipoDocumentoUpd").val(respuesta["TipoDocumento"]);
                $("#primerNombreUpd").val(respuesta["PrimerNombre"]);
                $("#segundoNombresUpd").val(respuesta["SegundoNombres"]);
                $("#tercerNombreUpd").val(respuesta["TercerNombre"]);
                $("#apellidoPaternoUpd").val(respuesta["ApellidoPaterno"]);
                $("#apellidoMaternoUpd").val(respuesta["ApellidoMaterno"]);
                //$("#apellidoEsposoUpd").val(respuesta["ApellidoEsposo"]);
                $("#fechaNacimientoUpd").val(respuesta["FechaNacimiento"]);
                $("#sexoUpd").val(respuesta["Sexo"]);
                //$("#discapacidadUpd").val(respuesta["Discapacidad"]);
                //$("#cantidadDependientesDiscapacidadUpd").val(respuesta["CantidadDependientesDiscapacidad"]);
                $("#codigoEstadoCivilUpd").val(respuesta["CodigoEstadoCivil"]);
                $("#domicilioUpd").val(respuesta["Domicilio"]);
                $("#libretaServicioMilitarUpd").val(respuesta["LibretaServicioMilitar"]);
                /*$("#direccionUpd").val(respuesta["Direccion"]);
                $("#telefonoUpd").val(respuesta["Telefono"]);
                $("#celularUpd").val(respuesta["Celular"]);*/
                $("#codigoPaisUpd").val(respuesta["CodigoPais"]);
                $("#codigoPaisUpd").select2({
                    tags: true
                });
                let datos2 = new FormData();
                datos2.append("codigopais", respuesta["CodigoPais"]);
                $.ajax({
                    url: "index.php?r=Filiacion/personas/listar-departamentos-ajax",
                    method: "POST",
                    dataType: 'html',
                    data: datos2,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (respuesta2) {
                        $("#codigoDepartamentoUpd").prop("disabled", false);
                        $("#codigoDepartamentoUpd").empty().append(respuesta2);
                        $("#codigoDepartamentoUpd").val(respuesta["CodigoDepartamento"])
                        //$("#codigoDepartamentoUpd option[value="+ respuesta["CodigoDepartamentoNacimiento"] +"]").attr("selected", true);
                        $("#codigoDepartamentoUpd").select2({
                            tags: true
                        });
                    }
                });
                let datos3 = new FormData();
                datos3.append("codigopais", respuesta["CodigoPais"]);
                datos3.append("codigodepartamento", respuesta["CodigoDepartamento"]);
                $.ajax({
                    url: "index.php?r=Filiacion/personas/listar-provincias-ajax",
                    method: "POST",
                    dataType: 'html',
                    data: datos3,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (respuesta3) {
                        $("#codigoProvinciaUpd").prop("disabled", false);
                        $("#codigoProvinciaUpd").empty().append(respuesta3);
                        $("#codigoProvinciaUpd").val(respuesta["CodigoProvincia"]);
                        $("#codigoProvinciaUpd").select2({
                            tags: true
                        });
                    }
                });
                let datos4 = new FormData();
                datos4.append("codigopais", respuesta["CodigoPais"]);
                datos4.append("codigodepartamento", respuesta["CodigoDepartamento"]);
                datos4.append("codigoprovincia", respuesta["CodigoProvincia"]);
                $.ajax({
                    url: "index.php?r=Filiacion/personas/listar-lugares-ajax",
                    method: "POST",
                    dataType: 'html',
                    data: datos4,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (respuesta4) {
                        $("#codigoLugarNacimientoUpd").prop("disabled", false);
                        $("#codigoLugarNacimientoUpd").empty().append(respuesta4);
                        $("#codigoLugarNacimientoUpd").val(respuesta["CodigoLugarNacimiento"]);
                        $("#codigoLugarNacimientoUpd").select2({
                            tags: true
                        });
                    }
                });
            },
            error: function (respuesta) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "Ocurrio un error al cargar los datos de la persona con C.I. " + codigo + ". Comuniquese con el administrador del sistema.",
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Cerrar'
                }).then(function () {
                    $('#modalActualizarPersona').modal('hide');
                });
            }
        });
    });
    /*=============================================
    ACTUALIZAR PERSONA
    =============================================*/
    $("#btnActualizarPersona").click(function () {
        let idPersona = $("#idPersonaUpd").val();
        let lugarExpedicion = $("#lugarExpedicionUpd").val();
        let tipoDocumento = $("#tipoDocumentoUpd").val();
        let primerNombre = $("#primerNombreUpd").val();
        let segundoNombres = $("#segundoNombresUpd").val();
        let tercerNombre = $("#tercerNombreUpd").val();
        let apellidoPaterno = $("#apellidoPaternoUpd").val();
        let apellidoMaterno = $("#apellidoMaternoUpd").val();
        let fechaNacimiento = $("#fechaNacimientoUpd").val();
        let sexo = $("#sexoUpd").val();
        //let discapacidad = $("#discapacidadUpd").val();
        //let cantidadDiscapacitadoDependiente = $("#cantidadDependientesDiscapacidadUpd").val();
        //let idPersonaDatos = $("#idPersonaDatosUpd").val();
        //let codigoLugarNacimiento = $("#codigoLugarNacimientoUpd").val();
        let codigoEstadoCivil = $("#codigoEstadoCivilUpd").val();
        let domicilio = $("#domicilioUpd").val();
        let libretaMilitar = $("#libretaServicioMilitarUpd").val();
        //let apellidoEsposo = $("#apellidoEsposoUpd").val();
        //let direccion = $("#direccionUpd").val();
        //let celular = $("#celularUpd").val();
        //let telefono = $("#telefonoUpd").val();
        let datos = new FormData();
        datos.append("idpersonaactualizar", idPersona);
        datos.append("lugarexpedicionactualizar", lugarExpedicion);
        datos.append("primernombreactualizar", primerNombre);
        datos.append("segundonombresactualizar", segundoNombres);
        datos.append("tercernombreactualizar", tercerNombre);
        datos.append("apellidopaternoactualizar", apellidoPaterno);
        datos.append("apllidomaternoactualizar", apellidoMaterno);
        datos.append("fechanacimientoactualizar", fechaNacimiento);
        datos.append("sexoactualizar", sexo);
        datos.append("domicilioactualizar", domicilio);
        datos.append("libretamilitaractualizar", libretaMilitar);
        //datos.append("discapacidadactualizar", discapacidad);
        //datos.append("cantidaddependientesdiscapacitadosactualizar", cantidadDiscapacitadoDependiente);
        //datos.append("idpersonadatosactualizar", idPersonaDatos);
        //datos.append("codigolugaractualizar", codigoLugarNacimiento);
        datos.append("codigoestadocivilactualizar", codigoEstadoCivil);
        //datos.append("apellidoesposoactualizar", apellidoEsposo);
        //datos.append("direccionactualizar", direccion);
        //datos.append("celularactualizar", celular);
        //datos.append("telefonoactualizar", telefono);
        $.ajax({
            url: "index.php?r=Filiacion/personas/actualizar-persona-ajax",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                if (respuesta === "ok") {
                    $("#modalActualizarPersona").modal('hide');
                    Swal.fire({
                        icon: "success",
                        title: "Actualización Completada",
                        text: "La persona " + primerNombre  + " " + segundoNombres + + " " + tercerNombre + " " + apellidoPaterno + " " + apellidoMaterno + " ha sido guardado correctamente con el C.I. " + idPersona + ".",
                        showCancelButton: false,
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "Cerrar"
                    }).then(function () {
                        $(".tablaPersonas").DataTable().ajax.reload();
                        //$(".tablaPersonas").DataTable().ajax.reload(null, false);
                        //$("#tablaPersonas_wrapper").show(300);
                        //$(".entrada-datos1Upd").hide(300);
                        //$(".entrada-datos2Upd").hide(300);
                        //$("#vistaActuaizarPersonaPestañas").hide(300);
                    });
                }
                else {
                    let mensaje;
                    if (respuesta === "existe") {
                        mensaje = "La persona con C.I " + idPersona + " ya existe. Ingrese otro C.I..";
                    } else {
                        mensaje = "Ocurrio un error al actualizar los datos de la persona " + primerNombre  + " " + segundoNombres + + " " + tercerNombre + " " + apellidoPaterno + " " + apellidoMaterno + ". Comuniquese con el administrador del sistema.";
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
    ELIMINAR PERSONA
    =============================================*/
    $(".tablaPersonas tbody").on("click", ".btnEliminarPersona", function () {
        let codigo = $(this).attr("codigo");
        let nombre = $(this).attr("nombre");
        let datos = new FormData();
        datos.append("codigoeliminar", codigo);
        Swal.fire({
            icon: "warning",
            title: "Confirmación eliminación",
            text: "¿Está seguro de borrar el cargo " + nombre + "?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            confirmButtonText: 'Borrar',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar'
        }).then(function (resultado) {
            if (resultado.value) {
                $.ajax({
                    url: "index.php?r=Filiacion/personas/eliminar-persona-ajax",
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
                                text: "La persona " + nombre + "con el C.I. " + codigo + " ha sido borrado correctamente.",
                                showCancelButton: false,
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Cerrar"
                            }).then(function () {
                                $(".tablaPersonas").DataTable().ajax.reload();
                            });
                        }
                        else {
                            let mensaje;
                            if (respuesta === "enUso") {
                                mensaje = "No se puede eliminar la persona " + nombre + " con C.I. " + codigo + ",  ya que está en uso actualmente y no puede ser eliminada. Solo puede ser inhabilitada.";
                            } else {
                                mensaje = "Ocurrio un error al eliminar la persona con C.I. " + codigo + ". Comuniquese con el administrador del sistema."
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
    SUBIR IMAGEN ANVERSO
    =============================================*/
    $("#uploadAnverso").on('click', function () {
        let datos = new FormData();
        let idpersona = $("#idPersonaNew").val();
        let files = $('#ciAnverso')[0].files[0];
        datos.append('file', files);
        datos.append("idpersona", idpersona);
        $.ajax({
            url: 'index.php?r=Filiacion/personas/subir-anverso-ajax',
            type: 'post',
            data: datos,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response != 'errorFormato') {
                    $("#imgAnverso").attr("src", response);
                    if (response != 'errorTamaño') {
                        $("#imgAnverso").attr("src", response);
                    } else {
                        alert('Tamaño de imagen incorrecto.');
                    }
                } else {
                    alert('Formato de imagen incorrecto.');
                }
            }
        });
        return false;
    });
    /*=============================================
    SUBIR IMAGEN REVERSO
    =============================================*/
    $("#uploadReverso").on('click', function () {
        let datos = new FormData();
        let idpersona = $("#idPersonaNew").val();
        let files = $('#imagenReverso')[0].files[0];
        datos.append('file', files);
        datos.append("idpersona", idpersona);
        $.ajax({
            url: 'index.php?r=Filiacion/personas/subir-reverso-ajax',
            type: 'post',
            data: datos,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response != 'errorFormato') {
                    $("#imgReverso").attr("src", response);
                    if (response != 'errorTamaño') {
                        $("#imgReverso").attr("src", response);
                    } else {
                        alert('Tamaño de imagen incorrecto.');
                    }
                } else {
                    alert('Formato de imagen incorrecto.');
                }
            }
        });
        return false;
    });
    /*=============================================
    SUBIR IMAGEN CERTIFICADO DE NACIMIENTO
    =============================================*/
    $("#uploadCertificadoNacimiento").on('click', function () {
        let datos = new FormData();
        let idpersona = $("#idPersonaNew").val();
        let files = $('#imagenCertificadoNacimiento')[0].files[0];
        datos.append('file', files);
        datos.append("idpersona", idpersona);
        $.ajax({
            url: 'index.php?r=Filiacion/personas/subir-certificado-nacimiento-ajax',
            type: 'post',
            data: datos,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response != 'errorFormato') {
                    $("#imgCertificadoNacimiento").attr("src", response);
                    if (response != 'errorTamaño') {
                        $("#imgCertificadoNacimiento").attr("src", response);
                    } else {
                        alert('Tamaño de imagen incorrecto.');
                    }
                } else {
                    alert('Formato de imagen incorrecto.');
                }
            }
        });
        return false;
    });
    /*=============================================
    SUBIR IMAGEN CERTIFICADO DE ESTADO CIVIL
    =============================================*/
    $("#uploadEstadoCivil").on('click', function () {
        let datos = new FormData();
        let idpersona = $("#idPersonaNew").val();
        let files = $('#imagenEstadoCivil')[0].files[0];
        datos.append('file', files);
        datos.append("idpersona", idpersona);
        $.ajax({
            url: 'index.php?r=Filiacion/personas/subir-certificado-estado-civil-ajax',
            type: 'post',
            data: datos,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response != 'errorFormato') {
                    $("#imgEstadoCivil").attr("src", response);
                    if (response != 'errorTamaño') {
                        $("#imgEstadoCivil").attr("src", response);
                    } else {
                        alert('Tamaño de imagen incorrecto.');
                    }
                } else {
                    alert('Formato de imagen incorrecto.');
                }
            }
        });
        return false;
    });
    /*=============================================
    MOSTRAR IMAGEN
    =============================================*/
    $(".tablaPersonas tbody").on("click", ".btnVerImagen", function () {
        let objectBtn = $(this);
        let nombre = objectBtn.attr("nombre");
        let datos = new FormData();
        datos.append("nombre", nombre);
        $.ajax({
            url: 'index.php?r=Filiacion/personas/mostrar-imagen-ajax',
            type: 'post',
            data: datos,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response != 'errorNombre') {
                    $("#mostrarImagen").attr("src", response);
                    $("#siguiente").on('click', function () {
                        $.ajax({
                            url: 'index.php?r=Filiacion/personas/mostrar-ci-reverso-ajax',
                            type: 'post',
                            data: datos,
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                if (response != 'errorNombre') {
                                    $("#mostrarImagen").attr("src", response);
                                    $("#siguiente").on('click', function () {
                                        $.ajax({
                                            url: 'index.php?r=Filiacion/personas/mostrar-certificado-nacimiento-ajax',
                                            type: 'post',
                                            data: datos,
                                            contentType: false,
                                            processData: false,
                                            success: function (response) {
                                                if (response != 'errorNombre') {
                                                    $("#mostrarImagen").attr("src", response);
                                                    $("#siguiente").on('click', function () {
                                                        $.ajax({
                                                            url: 'index.php?r=Filiacion/personas/mostrar-certificado-estado-civil-ajax',
                                                            type: 'post',
                                                            data: datos,
                                                            contentType: false,
                                                            processData: false,
                                                            success: function (response) {
                                                                if (response != 'errorNombre') {
                                                                    $("#mostrarImagen").attr("src", response);
                                                                    $("#siguiente").hide();
                                                                } else {
                                                                    $("#mostrarImagen").attr("src", src);
                                                                }
                                                            }
                                                        });
                                                    });
                                                } else {
                                                    $("#mostrarImagen").attr("src", src);
                                                }
                                            }
                                        });
                                    });
                                } else {
                                    $("#mostrarImagen").attr("src", src);
                                }
                            }
                        });
                    });
                } else {
                    $("#mostrarImagen").attr("src", src);
                }
            }
        });
    });
});