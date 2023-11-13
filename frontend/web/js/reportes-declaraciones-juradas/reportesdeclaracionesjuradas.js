$(document).ready(function () {
    /*=============================================
    CARGAR LA TABLA DINÁMICA
    =============================================*/
    $("#btnProcesarVista").click(function () {
        let mes = $("#mes").val();
        let gestion = $("#gestion").val();
        if (mes != "" && gestion != "") {
            let datos = new FormData();
            datos.append("mes", mes);
            datos.append("gestion", gestion);
            $.ajax({
                url: "index.php?r=Contraloria/reportes-declaraciones-juradas/reporte-declaracion-jurada-ajax",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "html",
                success: function (respuesta) {
                    $("#tablaReportes tbody tr").remove();
                    $("#contenidoReportes").append(respuesta);
                    $(".tabla-reportes").show();
                }
            });
        } else {
            $(".tabla-reportes").hide();
        }
    });

    /*/!*===============================================
    MOSTRAR TABLA PARA REPORTE
    =================================================*!/
    $("#tablaReportes tbody").on("click",".btnProcesarVista", function (ev) {
        ev.preventDefault();
        let codigotrabajador = $(this).attr("codigotrabajador");
        let idpersona = $(this).attr("idpersona");
        let fechanacimiento = $(this).attr("fechanacimiento");
        let fechainiciorecordatorio = $(this).attr("fechainiciorecordatorio");
        let fechafinrecordatorio = $(this).attr("fechafinrecordatorio");
        $("#codigoTrabajador").text(codigotrabajador);
        $("#idPersona").text(idpersona);
        $("#fechaNacimiento").text(fechanacimiento);
        $("#fechaInicioRecordatorio").text(fechainiciorecordatorio);
        $("#fechafinrecordatorio").text(fechafinrecordatorio);
        });*/

    /*===============================================
    BOTON PARA GENERAR EL REPORTE
    =================================================*/
    $("#btnPdf").click(function () {
        let mes = $("#mes").val();
        let gestion = $("#gestion").val();
        if (mes != "" && gestion != "") {
            let datos = new FormData();
            datos.append("mes", mes);
            datos.append("gestion", gestion);
            $.ajax({
                url: "index.php?r=Contraloria/reportes-declaraciones-juradas/pdf-reportes-declaraciones-juradas-ajax",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "html",
                success: function (respuesta) {
                    $("#tablapdfReportesReportes tbody tr").remove();
                    $("#contenidoReportes").append(respuesta);
                    $(".tabla-pdf-reportes").show();
                }
            });
        } else {
            $(".tabla-pdf-reportes").hide();
        }
    });
});