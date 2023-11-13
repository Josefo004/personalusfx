/*$(document).ready(function () {
  $("#divListaPaisesAcad").hide();
  $("#tablaPaisesAcad").DataTable({
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
      url: "index.php?r=Administracion/paises/listar-paises-acad",
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

  let table = $("#tablaPaises").DataTable({
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
      url: "index.php?r=Administracion/paises/listar-paises",
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

  $("#btnMostrarImportarPais").on("click", function () {
    let icono = $(".icon");
    icono.toggleClass("opened");
    if (icono.hasClass("opened")) {
      $("#divListaPaisesAcad").show(500);
      $("#divListaPaises").hide(500);
      $("#tablaPaisesAcad").DataTable().ajax.reload(null, false);
    } else {
      $("#divListaPaisesAcad").hide(500);
      $("#divListaPaises").show(500);
    }
  });

  $("#btnCancelar").click(function () {
    $(".icon").toggleClass("opened");
    $("#divListaPaisesAcad").hide(500);
    $("#divListaPaises").show(500);
  });

  $("#tablaPaises tbody").on("click", ".btnEstado", function () {
    let objectBtn = $(this);
    let codigoPais = objectBtn.attr("codigo-pais");
    let codigoEstado = objectBtn.attr("codigo-estado");
    let datos = new FormData();
    datos.append("codigoPais", codigoPais);
    $.ajax({
      url: "index.php?r=Administracion/paises/cambiar-estado-pais",
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
              "Error: No se pudo recuperar el pais " +
              nombrePais +
              " para su cambio de estado.";
          } else if (respuesta === "errorSql") {
            mensaje =
              "Error: Ocurrio un error en la base de datos al cambiar el estado del PAIS.";
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

  $("#tablaPaisesAcad tbody").on("click", ".btnElegir", function () {
    let codigoPaisAcad = $(this).attr("codigo-pais-acad");
    let nombrePaisAcad = $(this).attr("nombre-pais-acad");
    let nacionalidadAcad = $(this).attr("nacionalidad-acad");
    let datos = new FormData();
    datos.append("codigoPaisAcad", codigoPaisAcad);
    datos.append("nombrePaisAcad", nombrePaisAcad);
    datos.append("nacionalidadAcad", nacionalidadAcad);
    Swal.fire({
      icon: "warning",
      title: "Confirmación de adición",
      text:
        "¿Está seguro de adicionar el pais " +
        nombrePaisAcad +
        " al catálogo de paises?",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Guardar",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
    }).then(function (resultado) {
      if (resultado.value) {
        $.ajax({
          url: "index.php?r=Administracion/paises/guardar-pais",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function (respuesta) {
            if (respuesta === "ok") {
              $("#divListaPaisesAcad").hide(500);
              $("#divListaPaises").show(500);
              Swal.fire({
                icon: "success",
                title: "Creación Completada",
                text:
                  "El Pais " +
                  nombrePaisAcad +
                  " con código " +
                  codigoPaisAcad +
                  " ha sido guardado correctamente.",
                showCancelButton: false,
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Cerrar",
              }).then(function () {
                $("#tablaPaises").DataTable().ajax.reload(null, false);
              });
            } else {
              let mensaje;
              if (respuesta === "existe") {
                mensaje = "El Pais " + nombrePaisAcad + " ya existe.";
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
                    "Error: Los datos ingresados ya corresponden a un PAIS existente.";
                } else if (respuesta === "errorSql") {
                  mensaje =
                    "Error: Ocurrio un error en la base de datos al guardar el PAIS.";
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

  $("#tablaPaises tbody").on("click", ".btnEliminar", function () {
    let codigoPais = $(this).attr("codigo-pais");
    let nombrePais = $(this).attr("nombre-pais");
    let datos = new FormData();
    datos.append("codigoPais", codigoPais);
    Swal.fire({
      icon: "warning",
      title: "Confirmación eliminación",
      text: "¿Está seguro de borrar el pais " + nombrePais + "?",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Borrar",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
    }).then(function (resultado) {
      if (resultado.value) {
        $.ajax({
          url: "index.php?r=Administracion/paises/eliminar-pais",
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
                  "El pais " +
                  nombrePais +
                  " con código " +
                  codigoPais +
                  " ha sido borrado correctamente.",
                showCancelButton: false,
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Cerrar",
              }).then(function () {
                $("#tablaPaises").DataTable().ajax.reload(null, false);
                $("#tablaPaisesAcad").DataTable().ajax.reload(null, false);
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
                  "Error: No se pudo recuperar el pais " +
                  nombrePais +
                  " para su eliminacion.";
              } else if (respuesta === "errorEnUso") {
                mensaje =
                  "Error: El pais " +
                  nombrePais +
                  " se encuentra en uso y no puede ser eliminado.";
              } else if (respuesta === "errorSql") {
                mensaje =
                  "Error: Ocurrio un error en la base de datos al eliminar el PAIS.";
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
      }
    });
  });
});*/

$(document).ready(function () {
    $("#vistaPaisesAcad").hide();
    /*=============================================
    CARGAR LA TABLA DINÁMICA DE PAISES
    =============================================*/
    $("#tablaPaises").DataTable({
        ajax: {
            method: "POST",
            dataType: 'json',
            cache: false,
            //url: 'index.php?r=paises/listar-paises-ajax',
            url: "index.php?r=Administracion/paises/listar-paises",
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
    CARGAR LA TABLA DINÁMICA DE PAISES ACADEMICA
    =============================================*/
    $("#tablaPaisesAcad").DataTable({
        ajax: {
            method: "POST",
            dataType: 'json',
            cache: false,
            //url: 'index.php?r=paises/listar-paises-acad-ajax',
            url: "index.php?r=Administracion/paises/listar-paises-acad",
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
    ACTIVAR PAIS
    =============================================*/
    $("#tablaPaises tbody").on("click", ".btnActivarPais", function () {
        let objectBtn = $(this);
        let codigoPais = objectBtn.attr("codigo-pais");
        let codigoEstado = objectBtn.attr("codigo-estado");
        let datos = new FormData();
        datos.append("codigopais", codigoPais);
        $.ajax({
            //url: "index.php?r=paises/activar-pais-ajax",
            url: "index.php?r=Administracion/paises/cambiar-estado-pais",
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
                        text: "Ocurrio un error al cambiar el estado del pais con código " + codigoPais + ". Comuniquese con el administrador del sistema.",
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Cerrar'
                    });
                }
            }
        });
    });
    /*=============================================
    CREAR PAIS
    =============================================*/
    $("#btnMostrarCrearPais").on('click', function () {
        $("#vistaPaisesAcad").show(300);
        $("#vistaPaises").hide(300);
        $("#tablaPaisesAcad").DataTable().ajax.reload();
    });

    $("#btnCancelar").click(function () {
        //$('.icon').toggleClass('opened');
        $("#vistaPaisesAcad").hide(300);
        $("#vistaPaises").show(300);
    });

    $("#tablaPaisesAcad tbody").on("click", ".btnElegir", function () {
        let codigoPaisAcad = $(this).attr("codigo-pais-acad");
        let nombrePaisAcad = $(this).attr("nombre-pais-acad");
        let nacionalidadAcad = $(this).attr("nacionalidad-acad");
        let datos = new FormData();
        datos.append("codigopaisacad", codigoPaisAcad);
        datos.append("nombrepaisacad", nombrePaisAcad);
        datos.append("nacionalidadacad", nacionalidadAcad);
        Swal.fire({
            icon: "warning",
            title: "Confirmación de creacion",
            text: "¿Está seguro de guardar el pais " + nombrePaisAcad + "?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            confirmButtonText: 'Guardar',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar'
        }).then(function (resultado) {
            if (resultado.value) {
                $.ajax({
                    //url: "index.php?r=paises/crear-pais-ajax",
                    url: "index.php?r=Administracion/paises/guardar-pais",
                    method: "POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (respuesta) {
                        if (respuesta === "ok"){
                            //$("#modalCrearPais").modal('hide');
                            $("#vistaPaisesAcad").hide(340);
                            $("#vistaPaises").show(340);
                            Swal.fire({
                                icon: "success",
                                title: "Creación Completada",
                                text: "El Pais " + nombrePaisAcad + " con código " + codigoPaisAcad + " ha sido guardado correctamente.",
                                showCancelButton: false,
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Cerrar"
                            }).then(function(){
                                $("#tablaPaises").DataTable().ajax.reload();
                            });
                        }
                        else{
                            let mensaje;
                            if(respuesta === "existe"){
                                mensaje = "El Pais " + nombrePaisAcad + " ya existe.";
                            }else{
                                mensaje = "Ocurrio un error al crear el pais " + nombrePaisAcad + ". Comuniquese con el administrador del sistema.";
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
    /*=============================================
    ELIMINAR PAIS
    =============================================*/
    $("#tablaPaises tbody").on("click", ".btnEliminarPais", function () {
        let codigoPais = $(this).attr("codigo-pais");
        let nombrePais = $(this).attr("nombre-pais");
        let datos = new FormData();
        datos.append("codigopais", codigoPais);
        Swal.fire({
            icon: "warning",
            title: "Confirmación eliminación",
            text: "¿Está seguro de borrar el pais " + nombrePais + "?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            confirmButtonText: 'Borrar',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar'
        }).then(function (resultado) {
            if (resultado.value) {
                $.ajax({
                    //url: "index.php?r=paises/eliminar-pais-ajax",
                    url: "index.php?r=Administracion/paises/eliminar-pais",
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
                                text: "El pais " + nombrePais + " con código " + codigoPais + " ha sido borrado correctamente.",
                                showCancelButton: false,
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Cerrar"
                            }).then(function () {
                                $("#tablaPaises").DataTable().ajax.reload();
                                $("#tablaPaisesAcad").DataTable().ajax.reload();
                            });
                        }
                        else {
                            let mensaje;
                            if (respuesta === "enUso") {
                                mensaje = "No se puede eliminar el pais " + nombrePais + " con código " + codigoPais + ", ya que está en uso actualmente y no puede ser eliminado. Solo puede ser inhabilitado.";
                            } else {
                                mensaje = "Ocurrio un error al eliminar el pais con código " + codigoPais + ". Comuniquese con el administrador del sistema.";
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