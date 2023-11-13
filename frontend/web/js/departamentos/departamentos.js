/*
$(document).ready(function () {
  $("#divListaDepartamentosAcad").hide();
  $("#tablaDepartamentosAcad").DataTable({
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
      url: "index.php?r=Administracion/departamentos/listar-departamentos-acad",
      data: {
        codigoPaisAcad: function (d) {
          return $("#codigoPais").val();
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
  let table = $("#tablaDepartamentos").DataTable({
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
      url: "index.php?r=Administracion/departamentos/listar-departamentos",
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

  $("#btnMostrarImportarDepartamento").on("click", function () {
    let icono = $(".icon");
    icono.toggleClass("opened");
    if (icono.hasClass("opened")) {
      $("#divListaDepartamentosAcad").show(500);
      $("#divListaDepartamentos").hide(500);
      $("#tablaDepartamentosAcad").DataTable().ajax.reload(null, false);
    } else {
      $("#divListaDepartamentosAcad").hide(500);
      $("#divListaDepartamentos").show(500);
    }
  });

  $("#btnCancelar").click(function () {
    $(".icon").toggleClass("opened");
    $("#divListaDepartamentosAcad").hide(500);
    $("#divListaDepartamentos").show(500);
  });

  $("#tablaDepartamentos tbody").on("click", ".btnEstado", function () {
    let objectBtn = $(this);
    let codigoDepartamento = objectBtn.attr("codigo-departamento");
    let codigoEstado = objectBtn.attr("codigo-estado");
    let datos = new FormData();
    datos.append("codigoDepartamento", codigoDepartamento);
    $.ajax({
      url: "index.php?r=Administracion/departamentos/cambiar-estado-departamento",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        if (respuesta === "ok") {
          if (codigoEstado === "V") {
            objectBtn.removeClass("btn-success").addClass("btn-danger");
            objectBtn.html("NO VIGENTE");
            objectBtn.attr("codigo-estado", "C");
          } else {
            objectBtn.addClass("btn-success").removeClass("btn-danger");
            objectBtn.html("VIGENTE");
            objectBtn.attr("codigo-estado", "V");
          }
        } else {
          let mensaje;
          if (respuesta === "errorCabecera") {
            mensaje =
              "Error: Se esta intentando ingresar por un acceso no autorizado.";
          } else if (respuesta === "errorEnvio") {
            mensaje = "Error: Ocurrio un error en el envio de los datos.";
          } else if (respuesta === "errorNoEncontrado") {
            mensaje =
              "Error: No se pudo recuperar el departamento " +
              nombreDepartamento +
              " para su cambio de estado.";
          } else if (respuesta === "errorSql") {
            mensaje =
              "Error: Ocurrio un error en la base de datos al cambiar el estado del DEPARTAMENTO.";
          } else {
            mensaje = respuesta;
          }
          Swal.fire({
            icon: "error",
            title: "Alerta...",
            text: mensaje,
            showCancelButton: false,
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Cerrar",
          });
        }
      },
    });
  });

  $("#tablaDepartamentosAcad tbody").on("click", ".btnElegir", function () {
    let codigoPaisAcad = $(this).attr("codigo-pais-acad");
    let codigoPais = $("#codigoPais").val();
    let codigoDepartamentoAcad = $(this).attr("codigo-departamento-acad");
    let nombreDepartamentoAcad = $(this).attr("nombre-departamento-acad");
    let datos = new FormData();
    datos.append("codigoDepartamentoAcad", codigoDepartamentoAcad);
    datos.append("nombreDepartamentoAcad", nombreDepartamentoAcad);
    datos.append("codigoPaisAcad", codigoPaisAcad);
    datos.append("codigoPais", codigoPais);
    Swal.fire({
      icon: "warning",
      title: "Confirmación de adición",
      text:
        "¿Está seguro de adicionar el departamento " +
        nombreDepartamentoAcad +
        " al catálogo de departamentos?",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Guardar",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
    }).then(function (resultado) {
      if (resultado.value) {
        $.ajax({
          url: "index.php?r=Administracion/departamentos/guardar-departamento",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function (respuesta) {
            if (respuesta === "ok") {
              $("#divListaDepartamentosAcad").hide(500);
              $("#divListaDepartamentos").show(500);
              Swal.fire({
                icon: "success",
                title: "Creación Completada",
                text:
                  "El Departamento " +
                  nombreDepartamentoAcad +
                  " con código " +
                  codigoDepartamentoAcad +
                  " ha sido guardado correctamente.",
                showCancelButton: false,
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Cerrar",
              }).then(function () {
                $("#tablaDepartamentos").DataTable().ajax.reload(null, false);
              });
            } else {
              let mensaje;
              if (respuesta === "existe") {
                mensaje =
                  "El Departamento " + nombreDepartamentoAcad + " ya existe.";
              } else {
                let mensaje;
                if (respuesta === "errorCabecera") {
                  mensaje =
                    "Error: Se esta intentando ingresar por un acceso no autorizado.";
                } else if (respuesta === "errorEnvio") {
                  mensaje = "Error: Ocurrio un error en el envio de los datos.";
                } else if (respuesta === "errorValidacion") {
                  mensaje =
                    "Error: No se llenaron correctamente los datos requeridos.";
                } else if (respuesta === "errorExiste") {
                  mensaje =
                    "Error: Los datos ingresados ya corresponden a un DEPARTAMENTO existente.";
                } else if (respuesta === "errorSql") {
                  mensaje =
                    "Error: Ocurrio un error en la base de datos al guardar el DEPARTAMENTO.";
                } else {
                  mensaje = respuesta;
                }
                Swal.fire({
                  icon: "error",
                  title: "Advertencia...",
                  text: mensaje,
                  showCancelButton: false,
                  confirmButtonColor: "#3085d6",
                  confirmButtonText: "Cerrar",
                }).then(function () {
                  //acciones
                });
              }
            }
          },
        });
      }
    });
  });

  $("#codigoPais").change(function () {
    let codigoPais = $(this).val();
    if (codigoPais != "") {
      let datos = new FormData();
      datos.append("codigoPais", codigoPais);
      $("#tablaDepartamentosAcad").show(500);
      $(".dataTables_info").show(500);
      $(".dataTables_length").show(500);
      $(".dataTables_filter").show(500);
      $(".dataTables_paginate").show(500);
      $("#tablaDepartamentosAcad").DataTable().ajax.reload();
    } else {
      $("#tablaDepartamentosAcad").hide(500);
      $(".dataTables_info").hide(500);
      $(".dataTables_length").hide(500);
      $(".dataTables_filter").hide(500);
      $(".dataTables_paginate").hide(500);
    }
  });

  $("#tablaDepartamentos tbody").on("click", ".btnEliminar", function () {
    let codigoDepartamento = $(this).attr("codigo-departamento");
    let nombreDepartamento = $(this).attr("nombre-departamento");
    let datos = new FormData();
    datos.append("codigoDepartamento", codigoDepartamento);
    Swal.fire({
      icon: "warning",
      title: "Confirmación eliminación",
      text:
        "¿Está seguro de borrar el departamento " + nombreDepartamento + "?",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Borrar",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
    }).then(function (resultado) {
      if (resultado.value) {
        $.ajax({
          url: "index.php?r=Administracion/departamentos/eliminar-departamento",
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
                text:
                  "El departamento " +
                  nombreDepartamento +
                  " con código " +
                  codigoDepartamento +
                  " ha sido borrado correctamente.",
                showCancelButton: false,
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Cerrar",
              }).then(function () {
                $("#tablaDepartamentos").DataTable().ajax.reload(null, false);
                $("#tablaDepartamentosAcad").DataTable().ajax.reload(null, false);
              });
            } else {
              let mensaje;
              if (respuesta === "errorCabecera") {
                  mensaje =
                    "Error: Se esta intentando ingresar por un acceso no autorizado.";
                } else if (respuesta === "errorEnvio") {
                  mensaje = "Error: Ocurrio un error en el envio de los datos.";
                } else if (respuesta === "errorNoEncontrado") {
                  mensaje =
                    "Error: No se pudo recuperar el departamento " +
                    nombreDepartamento +
                    " para su eliminacion.";
                } else if (respuesta === "errorEnUso") {
                  mensaje =
                    "Error: El departamento " +
                    nombreDepartamento +
                    " se encuentra en uso y no puede ser eliminado.";
                } else if (respuesta === "errorSql") {
                  mensaje =
                    "Error: Ocurrio un error en la base de datos al eliminar el DEPARTAMENTO.";
                } else {
                  mensaje = respuesta;
                }
              Swal.fire({
                icon: "error",
                title: "Error",
                text: mensaje,
                showCancelButton: false,
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Cerrar",
              }).then(function () {
                //acciones
              });
          }
        },
      });
    }
  });
});
});*/

$(document).ready(function () {
    $("#vistaDepartamentosAcad").hide();

    /*=============================================
    CARGAR LA TABLA DINÁMICA DE DEPARTAMENTOS
    =============================================*/
    $(".tablaDepartamentos").DataTable({
        ajax: {
            method: "POST",
            dataType: 'json',
            cache: false,
            //url: 'index.php?r=departamentos/listar-departamentos-ajax',
            url: "index.php?r=Administracion/departamentos/listar-departamentos",
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
    CARGAR LA TABLA DINÁMICA DE DEPARTAMENTOS ACADEMICA
    =============================================*/
    $("#tablaDepartamentosAcad").DataTable({
        ajax: {
            method: "POST",
            dataType: 'json',
            cache: false,
            //url: 'index.php?r=departamentos/listar-departamentos-acad-ajax',
            url: "index.php?r=Administracion/departamentos/listar-departamentos-acad",
            data: {
                "codigopaisacad": function (d) {
                    return $("#codigoPais").val();
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
    ACTIVAR DEPARTAMENTO
    =============================================*/
    $("#tablaDepartamentos tbody").on("click", ".btnActivarDepartamento", function () {
        let objectBtn = $(this);
        let codigoDepartamento = objectBtn.attr("codigo-departamento");
        let codigoEstado = objectBtn.attr("codigo-estado");
        let datos = new FormData();
        datos.append("codigodepartamento", codigoDepartamento);
        $.ajax({
            //url: "index.php?r=departamentos/activar-departamento-ajax",
            url: "index.php?r=Administracion/departamentos/cambiar-estado-departamento",
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
                        text: "Ocurrio un error al cambiar el estado del departamento con código " + codigoDepartamento + ". Comuniquese con el administrador del sistema.",
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
            $("#tablaDepartamentosAcad").show(500);
            $(".dataTables_info").show(500);
            $(".dataTables_length").show(500);
            $(".dataTables_filter").show(500);
            $(".dataTables_paginate").show(500);
            $("#tablaDepartamentosAcad").DataTable().ajax.reload();
        } else {
            $("#tablaDepartamentosAcad").hide(500);
            $(".dataTables_info").hide(500);
            $(".dataTables_length").hide(500);
            $(".dataTables_filter").hide(500);
            $(".dataTables_paginate").hide(500);
        }
    });

    /*=============================================
    CREAR DEPARTAMENTO
    =============================================*/
    $("#btnMostrarCrearDepartamento").click(function () {
        $('#codigoPais').val("");
        $("#vistaDepartamentos").hide(500);
        $("#vistaDepartamentosAcad").show(500);
        $("#tablaDepartamentosAcad").hide(500);
        $(".dataTables_info").hide(500);
        $(".dataTables_length").hide(500);
        $(".dataTables_filter").hide(500);
        $(".dataTables_paginate").hide(500);
        $("#tablaDepartamentosAcad").DataTable().ajax.reload();
    });

    $("#btnCancelar").click(function () {
        $('.icon').toggleClass('opened');
        $("#vistaDepartamentosAcad").hide(500);
        $("#vistaDepartamentos").show(500);
    });

    $("#tablaDepartamentosAcad tbody").on("click", ".btnElegir", function () {
        let codigoPaisAcad = $(this).attr("codigo-pais-acad");
        let codigoDepartamentoAcad = $(this).attr("codigo-departamento-acad");
        let nombreDepartamentoAcad = $(this).attr("nombre-departamento-acad");
        let codigoPais = $('#codigoPais').val();
        let datos = new FormData();
        datos.append("codigopaisacad", codigoPaisAcad);
        datos.append("codigodepartamentoacad", codigoDepartamentoAcad);
        datos.append("nombredepartamentoacad", nombreDepartamentoAcad);
        datos.append("codigopais", codigoPais);
        Swal.fire({
            icon: "warning",
            title: "Confirmación de creacion",
            text: "¿Está seguro de guardar el departamento " + nombreDepartamentoAcad + "?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            confirmButtonText: 'Guardar',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar'
        }).then(function (resultado) {
            if (resultado.value) {
                $.ajax({
                    url: "index.php?r=Administracion/departamentos/guardar-departamento",
                    method: "POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (respuesta) {
                        if (respuesta === "ok") {
                            //$("#modalCrearDepartamento").modal('hide');
                            $("#vistaDepartamentosAcad").hide(500);
                            $("#vistaDepartamentos").show(500);
                            Swal.fire({
                                icon: "success",
                                title: "Creación Completada",
                                text: "El departamento " + nombreDepartamentoAcad + " con código " + codigoDepartamentoAcad + " ha sido guardado correctamente.",
                                showCancelButton: false,
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Cerrar"
                            }).then(function () {
                                $(".tablaDepartamentos").DataTable().ajax.reload();
                            });
                        }
                        else {
                            let mensaje;
                            if (respuesta === "existe") {
                                mensaje = "El Departamento " + nombreDepartamentoAcad + " ya existe.";
                            } else {
                                mensaje = "Ocurrio un error al crear el departamento " + nombreDepartamentoAcad + ". Comuniquese con el administrador del sistema.";
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
    ELIMINAR DEPARTAMENTO
    =============================================*/
    $("#tablaDepartamentos tbody").on("click", ".btnEliminarDepartamento", function () {
        let codigoDepartamento = $(this).attr("codigo-departamento");
        let nombreDepartamento = $(this).attr("nombre-departamento");
        let datos = new FormData();
        datos.append("codigodepartamento", codigoDepartamento);
        Swal.fire({
            icon: "warning",
            title: "Confirmación eliminación",
            text: "¿Está seguro de borrar el departamento " + nombreDepartamento + "?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            confirmButtonText: 'Borrar',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar'
        }).then(function (resultado) {
            if (resultado.value) {
                $.ajax({
                    url: "index.php?r=Administracion/departamentos/eliminar-departamento",
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
                                text: "El departamento " + nombreDepartamento + "con el código " + codigoDepartamento + " ha sido borrado correctamente.",
                                showCancelButton: false,
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Cerrar"
                            }).then(function () {
                                $("#tablaDepartamentos").DataTable().ajax.reload();
                                $("#tablaDepartamentosAcad").DataTable().ajax.reload();
                            });
                        }
                        else {
                            let mensaje;
                            if (respuesta === "enUso") {
                                mensaje = "No se puede eliminar el departamento " + nombreDepartamento + " con código " + codigoDepartamento + ", ya que está en uso actualmente y no puede ser eliminado. Solo puede ser inhabilitado.";
                            } else {
                                mensaje = "Ocurrio un error al eliminar el departamento con código " + codigoDepartamento + ". Comuniquese con el administrador del sistema.";
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