$(document).ready(function () {
    let Codigo = $("#Codigo").val();
    let datos = new FormData();
    datos.append("Codigo", Codigo);
    $.ajax({
        url: 'index.php?r=Filiacion/transferencia-administrativo/listar-transferencia-asignacion-ajax',
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "html",
        success: function (respuesta) {
            if (respuesta != "error") {
                $("#contenidoTransferenciaAsignacion tr").remove();
                $("#contenidoTransferenciaAsignacion").append(respuesta);

                //alert(respuesta);
            }
            else {

            }
        }
    });
});

/*==============================
ACTUALIZAR TRABAJADOR
================================*/
$("#tablaTransferenciaAsignacion tbody").on("change", ".selectTrabajador", function (ev) {
    let trabajador = $(this).val();
    let itemTrabajador = $(this).attr("itemTrabajador");
    let itemActual = $(".nuevaAsignacion" + itemTrabajador).attr("itemActual");
    let item = $("#nivelSalarialActual"+itemTrabajador).attr("item");
    let datos = new FormData();
    datos.append("trabajador", trabajador);
    datos.append("itemTrabajador", itemTrabajador);
    datos.append("itemActual",itemActual);
    datos.append("item",item);
    $.ajax({
        url: 'index.php?r=Filiacion/transferencia-administrativo/mostrar-nivel-salarial-ajax',
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
                if (respuesta) {
                    if (itemActual === itemTrabajador && itemActual === item ){
                        $("#nivelSalarialActual"+itemTrabajador).append(respuesta);
                    }
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "El Trabajadior no tiene nivel salarial vigente",
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

/*==============================
GUARDAR TRABAJADOR
================================*/
