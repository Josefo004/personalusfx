/*
$(document).ready(function () {
  $("#divListaProvinciasAcad").hide();
  $("#tablaProvinciasAcad").DataTable({
    columnDefs: [
      {
        targets: [2, 3],
        className: "dt-center",
      },
      {
        targets: 0,
        searchable: false,
        orderable: false,
      },
    ],
    order: [[1, "asc"]],
    ajax: {
      method: "POST",
      dataType: "json",
      cache: false,
      url: "index.php?r=Administracion/provincias/listar-provincias-acad",
      data: {
        codigoDepartamentoAcad: function (d) {
          return $("#codigoDepartamento").val();
        },
      },
    },
    deferRender: true,
    retrieve: true,
    processing: true,
    language: {
      sProcessing: "Procesando...",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron resultados",
      sEmptyTable: "Ningún dato disponible en esta tabla",
      sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
      sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0",
      sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
      sInfoPostFix: "",
      sSearch: "Buscar:",
      sUrl: "",
      sInfoThousands: ",",
      sLoadingRecords: "Cargando...",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "Siguiente",
        sPrevious: "Anterior",
      },
      oAria: {
        sSortAscending:
          ": Activar para ordenar la columna de manera ascendente",
        sSortDescending:
          ": Activar para ordenar la columna de manera descendente",
      },
    },
  });
  let table = $("#tablaProvincias").DataTable({
    columnDefs: [
      {
        targets: [3, 4],
        className: "dt-center",
      },
      {
        targets: 0,
        searchable: false,
        orderable: false,
      },
    ],
    order: [[1, "asc"]],
    ajax: {
      method: "POST",
      dataType: "json",
      cache: false,
      url: "index.php?r=Administracion/provincias/listar-provincias",
      data: {},
    },
    deferRender: true,
    retrieve: true,
    processing: true,
    language: {
      sProcessing: "Procesando...",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron resultados",
      sEmptyTable: "Ningún dato disponible en esta tabla",
      sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
      sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0",
      sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
      sInfoPostFix: "",
      sSearch: "Buscar:",
      sUrl: "",
      sInfoThousands: ",",
      sLoadingRecords: "Cargando...",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "Siguiente",
        sPrevious: "Anterior",
      },
      oAria: {
        sSortAscending:
          ": Activar para ordenar la columna de manera ascendente",
        sSortDescending:
          ": Activar para ordenar la columna de manera descendente",
      },
    },
  });

  table
    .on("order.dt search.dt", function () {
      let i = 1;
      table
        .cells(null, 0, { search: "applied", order: "applied" })
        .every(function () {
          this.data(i++);
        });
    })
    .draw();

  $("#btnMostrarImportarProvincia").click(function () {
    let icono = $(".icon");
    icono.toggleClass("opened");    
    if (icono.hasClass("opened")) {                
      $("#divListaProvinciasAcad").show(500);
      $("#divListaProvincias").hide(500);
      $("#tablaProvinciasAcad").DataTable().ajax.reload(null, false);
    } else {        
      $("#divListaProvinciasAcad").hide(500);
      $("#divListaProvincias").show(500);
    }    
  });

});
*/

$(document).ready(function () {
    $("#vistaProvinciasAcad").hide();
    /*=============================================
    CARGAR LA TABLA DINÁMICA DE PROVINCIAS
    =============================================*/
    $(".tablaProvincias").DataTable({
        ajax: {
            method: "POST",
            dataType: 'json',
            cache: false,
            url: 'index.php?r=Administracion/provincias/listar-provincias',
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
    CARGAR LA TABLA DINÁMICA DE PROVINCIAS ACADEMICA
    =============================================*/
    $("#tablaProvinciasAcad").DataTable({
        ajax: {
            method: "POST",
            dataType: 'json',
            cache: false,
            url: 'index.php?r=Administracion/provincias/listar-provincias-acad',
            data: {
                "codigodepartamentoacad": function (d) {
                    return $("#codigoDepartamento").val();
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
    ACTIVAR PROVINCIA
    =============================================*/
    $("#tablaProvincias tbody").on("click", ".btnActivarProvincia", function () {
        let objectBtn = $(this);
        let codigoProvincia = objectBtn.attr("codigo-provincia");
        let codigoEstado = objectBtn.attr("codigo-estado");
        let datos = new FormData();
        datos.append("codigoprovincia", codigoProvincia);
        $.ajax({
            url: "index.php?r=Administracion/provincias/cambiar-estado-provincia",
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
                        text: "Ocurrio un error al cambiar el estado de la provincia con código " + codigoProvincia + ". Comuniquese con el administrador del sistema.",
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
                url: "index.php?r=Administracion/provincias/listar-departamentos",
                method: "POST",
                dataType: 'html',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    $("#codigoDepartamento").empty().append(respuesta);
                    $("#codigoDepartamento").prop("disabled", false);
                    $(".entrada-datos1").show(500);
                    $("#tablaProvinciasAcad").hide(500);
                    $(".dataTables_info").hide(500);
                    $(".dataTables_length").hide(500);
                    $(".dataTables_filter").hide(500);
                    $(".dataTables_paginate").hide(500);
                }
            });
        } else {
            $("#codigoDepartamento").empty().append("<option value=''>Selecionar Departamento</option>");
            $("#codigoDepartamento").prop("disabled", true);
            $(".entrada-datos1").hide(500);
            $("#tablaProvinciasAcad").hide(500);
            $(".dataTables_info").hide(500);
            $(".dataTables_length").hide(500);
            $(".dataTables_filter").hide(500);
            $(".dataTables_paginate").hide(500);
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
            $("#tablaProvinciasAcad").show(500);
            $(".dataTables_info").show(500);
            $(".dataTables_length").show(500);
            $(".dataTables_filter").show(500);
            $(".dataTables_paginate").show(500);
            $("#tablaProvinciasAcad").DataTable().ajax.reload();
        } else {
            $("#tablaProvinciasAcad").hide(500);
            $(".dataTables_info").hide(500);
            $(".dataTables_length").hide(500);
            $(".dataTables_filter").hide(500);
            $(".dataTables_paginate").hide(500);
        }
    });

    /*=============================================
    CREAR PROVINCIA
    =============================================*/
    $("#btnMostrarCrearProvincia").click(function () {
        $('#codigoPais').val("");
        $('#codigoDepartamento').val("");
        $('#vistaProvincias').hide(500);
        $(".entrada-datos1").hide(500);
        $("#tablaProvincias").hide(500);
        $(".dataTables_info").hide(500);
        $(".dataTables_length").hide(500);
        $(".dataTables_filter").hide(500);
        $(".dataTables_paginate").hide(500);
        $("#vistaProvinciasAcad").show(500);
        $("#tablaProvinciasAcad").hide(500);
        $("#tablaProvinciasAcad").DataTable().ajax.reload();
    });

    $("#btnCancelar").click(function () {
        //$('.icon').toggleClass('opened');
        $("#vistaProvinciasAcad").hide(500);
        $("#vistaProvincias").show(500);
        $("#tablaProvincias").show(500);
        $(".dataTables_info").show(500);
        $(".dataTables_length").show(500);
        $(".dataTables_filter").show(500);
        $(".dataTables_paginate").show(500);
    });

    $("#tablaProvinciasAcad tbody").on("click", ".btnElegir", function () {
        let codigoPaisAcad = $(this).attr("codigo-pais-acad");
        let codigoDepartamentoAcad = $(this).attr("codigo-departamento-acad");
        let codigoProvinciaAcad = $(this).attr("codigo-provincia-acad");
        let nombreProvinciaAcad = $(this).attr("nombre-provincia-acad");
        let codigoDepartamento = $('#codigoDepartamento').val();
        let datos = new FormData();
        datos.append("codigoprovinciaacad", codigoProvinciaAcad);
        datos.append("nombreprovinciaacad", nombreProvinciaAcad);
        datos.append("codigopaisacad", codigoPaisAcad);
        datos.append("codigodepartamentoacad", codigoDepartamentoAcad);
        datos.append("codigodepartamento", codigoDepartamento);
        Swal.fire({
            icon: "warning",
            title: "Confirmación de creacion",
            text: "¿Está seguro de guardar la provincia " + nombreProvinciaAcad + "?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            confirmButtonText: 'Guardar',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar'
        }).then(function (resultado) {
            if (resultado.value) {
                $.ajax({
                    url: "index.php?r=Administracion/provincias/guardar-provincia",
                    method: "POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (respuesta) {
                        if (respuesta === "ok") {
                            //$("#modalCrearProvincia").modal('hide');
                            $("#vistaProvinciasAcad").hide(500);
                            $("#vistaProvincias").show(500);
                            $("#tablaProvincias").show(500);
                            Swal.fire({
                                icon: "success",
                                title: "Creación Completada",
                                text: "La provincia " + nombreProvinciaAcad + " con código " + codigoProvinciaAcad + " ha sido guardado correctamente.",
                                showCancelButton: false,
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Cerrar"
                            }).then(function () {
                                $("#tablaProvincias").DataTable().ajax.reload();
                            });
                        }
                        else {
                            let mensaje;
                            if (respuesta === "existe") {
                                mensaje = "La provincia " + nombreProvinciaAcad + " ya existe.";
                            } else {
                                mensaje = "Ocurrio un error al crear la provincia " + nombreProvinciaAcad + ". Comuniquese con el administrador del sistema.";
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
    $(".tablaProvincias tbody").on("click", ".btnEliminarProvincia", function () {
        let codigoProvincia = $(this).attr("codigo-provincia");
        let nombreProvincia = $(this).attr("nombre-provincia");
        let datos = new FormData();
        datos.append("codigoprovincia", codigoProvincia);
        Swal.fire({
            icon: "warning",
            title: "Confirmación eliminación",
            text: "¿Está seguro de borrar la provincia " + nombreProvincia + "?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            confirmButtonText: 'Borrar',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar'
        }).then(function (resultado) {
            if (resultado.value) {
                $.ajax({
                    url: "index.php?r=Administracion/provincias/eliminar-provincia",
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
                                text: "La provincia " + nombreProvincia + "con el código " + codigoProvincia + " ha sido borrado correctamente.",
                                showCancelButton: false,
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Cerrar"
                            }).then(function () {
                                $("#tablaProvincias").DataTable().ajax.reload();
                                $("#tablaProvinciasAcad").DataTable().ajax.reload();
                            });
                        }
                        else {
                            let mensaje;
                            if (respuesta === "enUso") {
                                mensaje = "No se puede eliminar el departamento " + nombreProvincia + " con código " + codigoProvincia + ", ya que está en uso actualmente y no puede ser eliminado. Solo puede ser inhabilitado.";
                            } else {
                                mensaje = "Ocurrio un error al eliminar el departamento con código " + codigoProvincia + ". Comuniquese con el administrador del sistema.";
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