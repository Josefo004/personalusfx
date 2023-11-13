/*=============================================
CARGAR LA TABLA DINÁMICA DE NIVELES SALARIALES
=============================================*/
$(".tablaNivelesSalariales").DataTable({
    //"ajax": "index.php?r=cargos/listar-cargos-ajax",
    ajax: {
        method: "POST",
        dataType: 'json',
        cache: false,
        url: 'index.php?r=Administracion/niveles-salariales/listar-niveles-salariales-ajax',
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
SELECCIONAR SECTOR DE TRABAJO
=============================================*/
$("#codigoSectorTrabajoNew").change(function () {
    let codigoSectorTrabajo = $(this).val();
    if (codigoSectorTrabajo != "") {
        $(".entrada-datos").show();
    } else {
        $(".entrada-datos").hide();
    }
})
/*=============================================
CREAR NIVEL SALARIAL
=============================================*/
$("#btnCrearNivelSalarial").click(function () {
    let codigoSectorTrabajo = $("#codigoSectorTrabajoNew").val();
    let nombreNivelSalarial = $("#nombreNivelSalarialNew").val();
    let descripcionNivelSalarial = $("#descripcionNivelSalarialNew").val();
    let haberBasico = $("#haberBasicoNew").val();
    let puntosEscalafon = $("#puntosEscalafonNew").val();
    let datos = new FormData();
    datos.append("codigosectortrabajo", codigoSectorTrabajo);
    datos.append("nombrenivelsalarial", nombreNivelSalarial);
    datos.append("descripcionnivelsalarial", descripcionNivelSalarial);
    datos.append("haberbasico", haberBasico);
    datos.append("puntosescalafon", puntosEscalafon);
    $.ajax({
        url: "index.php?r=Administracion/niveles-salariales/crear-nivel-salarial-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            if (respuesta === "ok") {
                $("#codigoSectorTrabajoNew").val("");
                $("#nombreNivelSalarialNew").val("");
                $("#descripcionNivelSalarialNew").val("");
                $("#haberBasicoNew").val("");
                $("#puntosEscalafonNew").val("");
                $("#modalCrearNivelSalarial").modal('hide');
                Swal.fire({
                    icon: "success",
                    title: "Creación Completada",
                    text: "El nivel salarial " + nombreNivelSalarial + " ha sido guardado correctamente.",
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Cerrar"
                }).then(function () {
                    $(".tablaNivelesSalariales").DataTable().ajax.reload();
                });
            }
            else {
                let mensaje;
                if (respuesta === "existe") {
                    mensaje = "El nivel salarial " + nombreNivelSalarial + " ya existe. Ingrese otro nombre.";
                } else {
                    mensaje = "Ocurrio un error al crear el nivel salarial " + nombreNivelSalarial + ". Comuniquese con el administrador del sistema."
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
ACTIVAR NIVEL
=============================================*/
$(".tablaNivelesSalariales tbody").on("click", ".btnActivarNivelSalarial", function () {
    let objectBtn = $(this);
    let codigoNivelSalarial = objectBtn.attr("codigo");
    let codigoEstado = objectBtn.attr("estado");
    let datos = new FormData();
    datos.append("codigonivelsalarial", codigoNivelSalarial);
    $.ajax({
        url: "index.php?r=Administracion/niveles-salariales/activar-nivel-salarial-ajax",
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
                    text: "Ocurrio un error al cambiar el estado del nivel salarial con código " + codigoNivelSalarial + ". Comuniquese con el administrador del sistema.",
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Cerrar'
                });
            }
        }
    });
});

/*=============================================
EDITAR NIVEL SALARIAL
=============================================*/
$(".tablaNivelesSalariales tbody").on("click", ".btnEditarNivelSalarial", function () {
    let codigoNivelSalarial = $(this).attr("codigo");
    let datos = new FormData();
    datos.append("codigonivelsalarial", codigoNivelSalarial);
    $.ajax({
        url: "index.php?r=Administracion/niveles-salariales/buscar-nivel-salarial-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
            $("#codigoNivelSalarialUpd").val(respuesta["CodigoNivelSalarial"]);
            $("#nombreNivelSalarialUpd").val(respuesta["NombreNivelSalarial"]);
            $("#descripcionNivelSalarialUpd").val(respuesta["DescripcionNivelSalarial"]);
            $("#haberBasicoUpd").val(parseFloat(respuesta["HaberBasico"]).toFixed(2));
            $("#puntosEscalafonUpd").val(parseFloat(respuesta["PuntosEscalafon"]).toFixed(2));
            $("#codigoSectorTrabajoUpd").val(respuesta["CodigoSectorTrabajo"]);
        },
        error: function (respuesta) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "Ocurrio un error al cargar los datos del nivel salarial con código " + codigoNivelSalarial + ". Comuniquese con el administrador del sistema.",
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Cerrar'
            }).then(function () {
                $('#modalActualizarNivelSalarial').modal('show');
            });
        }
    });
});

/*=============================================
ACTUALIZAR NIVEL SALARIAL
=============================================*/
$("#btnActualizarNivelSalarial").click(function () {
    let codigoSectorTrabajo = $("#codigoSectorTrabajoUpd").val();
    let codigoNivelSalarial = $("#codigoNivelSalarialUpd").val();
    let nombreNivelSalarial = $("#nombreNivelSalarialUpd").val();
    let descripcionNivelSalarial = $("#descripcionNivelSalarialUpd").val();
    let haberBasico = $("#haberBasicoUpd").val();
    let puntosEscalafon = $("#puntosEscalafonUpd").val();
    let datos = new FormData();
    datos.append("codigonivelsalarial", codigoNivelSalarial);
    datos.append("nombrenivelsalarial", nombreNivelSalarial);
    datos.append("descripcionnivelsalarial", descripcionNivelSalarial);
    datos.append("haberbasico", haberBasico);
    datos.append("puntosescalafon", puntosEscalafon);
    datos.append("codigosectortrabajo", codigoSectorTrabajo);
    $.ajax({
        url: "index.php?r=Administracion/niveles-salariales/actualizar-nivel-salarial-ajax",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            if (respuesta === "ok") {
                $("#modalActualizarNivelSalarial").modal('hide');
                Swal.fire({
                    icon: "success",
                    title: "Actualización Completada",
                    text: "El nivel salarial " + nombreNivelSalarial + " ha sido guardado correctamente con el código " + codigoNivelSalarial + ".",
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Cerrar"
                }).then(function () {
                    $(".tablaNivelesSalariales").DataTable().ajax.reload();
                });
            }
            else {
                let mensaje;
                if (respuesta === "existe") {
                    mensaje = "El Nivel Salarial " + nombreNivelSalarial + " ya existe. Ingrese otro nombre.";
                } else {
                    mensaje = "Ocurrio un error al actualizar los datos del nivel salarial con código " + codigoNivelSalarial + ". Comuniquese con el administrador del sistema."
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
ELIMINAR NIVEL SALARIAL
=============================================*/
$(".tablaNivelesSalariales tbody").on("click", ".btnEliminarNivelSalarial", function () {
    let codigoNivelSalarial = $(this).attr("codigo");
    let nombreNivelSalarial = $(this).attr("nombre");
    let datos = new FormData();
    datos.append("codigonivelsalarial", codigoNivelSalarial);
    Swal.fire({
        icon: "warning",
        title: "Confirmación eliminación",
        text: "¿Está seguro de borrar el nivel salarial " + nombreNivelSalarial + "?",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        confirmButtonText: 'Borrar',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar'
    }).then(function (resultado) {
        if (resultado.value) {
            $.ajax({
                url: "index.php?r=Administracion/niveles-salariales/eliminar-nivel-salarial-ajax",
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
                            text: "El nivel salarial " + nombreNivelSalarial + "con el código " + codigoNivelSalarial + " ha sido borrado correctamente.",
                            showCancelButton: false,
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Cerrar"
                        }).then(function () {
                            $(".tablaNivelesSalariales").DataTable().ajax.reload();
                        });
                    }
                    else {
                        let mensaje;
                        if (respuesta === "enUso") {
                            mensaje = "No se puede eliminar el nivel salarial " + nombreNivelSalarial + " con código " + codigoNivelSalarial + ", ya que está en uso actualmente y no puede ser eliminado. Solo puede ser inhabilitado.";
                        } else {
                            mensaje = "Ocurrio un error al eliminar el nivel salarial con código " + codigoNivelSalarial + ". Comuniquese con el administrador del sistema."
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