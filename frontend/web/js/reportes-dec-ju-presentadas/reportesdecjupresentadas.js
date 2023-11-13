$(document).ready(function () {
    /*=============================================
    CARGAR LA TABLA DINÁMICA
    =============================================*/
    $("#btntrimestre1").click(function () {
        //let mes = $("#mes").val();
        let gestion = $("#gestion").val();
        if (/*mes != "" &&*/ gestion != "") {
            let datos = new FormData();
            // datos.append("mes", mes);
            datos.append("gestion", gestion);
            $.ajax({
                url: "index.php?r=Contraloria/reportes-dec-ju-presentadas/reporte-dec-ju-presentada-tri-uno-ajax",
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

    $("#btntrimestre2").click(function () {
        //let mes = $("#mes").val();
        let gestion = $("#gestion").val();
        if (/*mes != "" &&*/ gestion != "") {
            let datos = new FormData();
            // datos.append("mes", mes);
            datos.append("gestion", gestion);
            $.ajax({
                url: "index.php?r=Contraloria/reportes-dec-ju-presentadas/reporte-dec-ju-presentada-tri-dos-ajax",
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

    $("#btntrimestre3").click(function () {
        //let mes = $("#mes").val();
        let gestion = $("#gestion").val();
        if (/*mes != "" &&*/ gestion != "") {
            let datos = new FormData();
            // datos.append("mes", mes);
            datos.append("gestion", gestion);
            $.ajax({
                url: "index.php?r=Contraloria/reportes-dec-ju-presentadas/reporte-dec-ju-presentada-tri-tres-ajax",
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

    $("#btntrimestre4").click(function () {
        //let mes = $("#mes").val();
        let gestion = $("#gestion").val();
        if (/*mes != "" &&*/ gestion != "") {
            let datos = new FormData();
            // datos.append("mes", mes);
            datos.append("gestion", gestion);
            $.ajax({
                url: "index.php?r=Contraloria/reportes-dec-ju-presentadas/reporte-dec-ju-presentada-tri-cuatro-ajax",
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

    $("#btntrimestre1FueraPlazo").click(function () {
        //let mes = $("#mes").val();
        let gestion = $("#gestionFueraPlazo").val();
        if (/*mes != "" &&*/ gestion != "") {
            let datos = new FormData();
            // datos.append("mes", mes);
            datos.append("gestion", gestion);
            $.ajax({
                url: "index.php?r=Contraloria/reportes-dec-ju-presentadas/reporte-dec-ju-fuera-plazo-tri-uno-ajax",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "html",
                success: function (respuesta) {
                    $("#tablaReportesFueraPlazo tbody tr").remove();
                    $("#contenidoReportesFueraPlazo").append(respuesta);
                    $(".tabla-reportesFueraPlazo").show();
                }
            });
        } else {
            $(".tabla-reportesFueraPlazo").hide();
        }
    });

    $("#btntrimestre2FueraPlazo").click(function () {
        //let mes = $("#mes").val();
        let gestion = $("#gestionFueraPlazo").val();
        if (/*mes != "" &&*/ gestion != "") {
            let datos = new FormData();
            // datos.append("mes", mes);
            datos.append("gestion", gestion);
            $.ajax({
                url: "index.php?r=Contraloria/reportes-dec-ju-presentadas/reporte-dec-ju-fuera-plazo-tri-dos-ajax",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "html",
                success: function (respuesta) {
                    $("#tablaReportesFueraPlazo tbody tr").remove();
                    $("#contenidoReportesFueraPlazo").append(respuesta);
                    $(".tabla-reportesFueraPlazo").show();
                }
            });
        } else {
            $(".tabla-reportesFueraPlazo").hide();
        }
    });

    $("#btntrimestre3FueraPlazo").click(function () {
        //let mes = $("#mes").val();
        let gestion = $("#gestionFueraPlazo").val();
        if (/*mes != "" &&*/ gestion != "") {
            let datos = new FormData();
            // datos.append("mes", mes);
            datos.append("gestion", gestion);
            $.ajax({
                url: "index.php?r=Contraloria/reportes-dec-ju-presentadas/reporte-dec-ju-fuera-plazo-tri-tres-ajax",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "html",
                success: function (respuesta) {
                    $("#tablaReportesFueraPlazo tbody tr").remove();
                    $("#contenidoReportesFueraPlazo").append(respuesta);
                    $(".tabla-reportesFueraPlazo").show();
                }
            });
        } else {
            $(".tabla-reportesFueraPlazo").hide();
        }
    });

    $("#btntrimestre4FueraPlazo").click(function () {
        //let mes = $("#mes").val();
        let gestion = $("#gestionFueraPlazo").val();
        if (/*mes != "" &&*/ gestion != "") {
            let datos = new FormData();
            // datos.append("mes", mes);
            datos.append("gestion", gestion);
            $.ajax({
                url: "index.php?r=Contraloria/reportes-dec-ju-presentadas/reporte-dec-ju-fuera-plazo-tri-cuatro-ajax",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "html",
                success: function (respuesta) {
                    $("#tablaReportesFueraPlazo tbody tr").remove();
                    $("#contenidoReportesFueraPlazo").append(respuesta);
                    $(".tabla-reportesFueraPlazo").show();
                }
            });
        } else {
            $(".tabla-reportesFueraPlazo").hide();
        }
    });
});