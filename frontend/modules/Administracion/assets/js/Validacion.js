$(document).ready(function() {
    $('input.txt[type=text]').on('keypress', function (event) {
        let regex = new RegExp("^[\\w ]+$");
        let key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });

    $('input.num[type=text]').on('keypress', function (event) {
        let regex = new RegExp("^[0-9,.]*$");
        let key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });

    $.validator.addMethod("MayorQue",
        function (value, element, param) {
            let $otherElement = $(param);
            return parseInt(value, 10) > parseInt($otherElement.val(), 10);
        });

    $.validator.addMethod("DiferenteQue",
        function (value, element, param) {
            return value !== "0";
        });

    $( "#formPei" ).validate( {
        rules: {
            descripcionPei: {
                required: true,
                minlength: 2,
                maxlength: 250
            },
            fechaAprobacion:{
                required: true,
                date: true
            },
            gestionInicio:{
                required: true,
                digits: true,
                min:2000
            },
            gestionFin:{
                required: true,
                digits: true,
                min:2000,
                MayorQue: "#gestionInicio"
            }
        },
        messages: {
            descripcionPei: {
                required: "Debe ingresar una descripcion para el PEI",
                minlength: "La descripcion debe tener almenos 2 letras",
                maxlength: "La descripcion debe tener maximo 250 letras"
            },
            fechaAprobacion: {
                required: "Debe ingresar la fecha de aprobacion del PEI",
                date: "Debe ingresar una fecha valida"
            },
            gestionInicio: {
                required: "Debe ingresar la gestion de inicio del PEI",
                digits: "Solo debe ingresar el numero de año",
                min:"Debe ingresar un año valido mayor al 2000"
            },
            gestionFin: {
                required: "Debe ingresar la gestion final del PEI",
                digits: "Solo debe ingresar el numero de año",
                min:"Debe ingresar un año valido mayor al 2000",
                MayorQue:"La gestion final debe ser mayor que la gestion de inicio"
            }
        },
        errorElement: "div",

        errorPlacement: function ( error, element ) {
            error.addClass( "invalid-feedback" );
            error.insertAfter(element);
        },
        highlight: function ( element  ) {
            $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
        },
        unhighlight: function (element) {
            $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
        }

    } );

    $( "#formObjEstrategico" ).validate( {
        rules: {
            codigoPei:{
                required: true,
                DiferenteQue: '0'
            },
            codigoCoge: {
                required: true,
                digits: true,
                max: 999
            },
            objetivo:{
                required: true,
                minlength: 2,
                maxlength: 200
            },
            producto:{
                required: true,
                minlength: 2,
                maxlength: 200
            }
        },
        messages: {
            codigoPei: {
                required: "Debe seleccionar un codigo PEI",
                DiferenteQue:"Debe seleccionar un codigo PEI"
            },
            codigoCoge: {
                required: "Debe ingresar un codigo de objetivo estrategico (COGE)",
                digits: "Solo se permite numeros enteros",
                max: "Debe ingresar un numero de 3 digitos como maximo"
            },
            objetivo: {
                required: "Debe ingresar la descripcion del objetivo estrategico",
                minlength: "El objetivo debe tener por lo menos 2 caracteres",
                maxlength: "El objetivo debe tener maximo 200 caracteres"
            },
            producto: {
                required: "Debe ingresar un producto esperado del objetivo estrategico",
                minlength: "El producto debe tener por lo menos 2 caracteres",
                maxlength: "El producto debe tener maximo 200 caracteres"
            }
        },
        errorElement: "div",

        errorPlacement: function ( error, element ) {
            error.addClass( "invalid-feedback" );
            error.insertAfter(element);
        },
        highlight: function ( element  ) {
            $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
        },
        unhighlight: function (element) {
            $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
        }
    } );

    $( "#formUnidad" ).validate({
        rules: {
            tipoUnidad: {
                required: true
            },
            nombreUnidad:{
                required: true,
                minlength: 5,
                maxlength: 150
            },
            nombreCorto:{
                required: true,
                minlength: 5,
                maxlength: 150
            }
        },
        messages: {
            tipoUnidad: {
                required: "Debe seleccionar un tipo de unidad"
            },
            nombreUnidad: {
                required: "Debe ingresar un nombre para la unidad",
                minlength: "El nombre debe tener al menos 5 letras",
                maxlength: "El nombre debe tener maximo 150 letras"
            },
            nombreCorto: {
                required: "Debe ingresar un nombre corto para la unidad",
                minlength: "El nombre corto debe tener almenos 5 letras",
                maxlength: "El nombre corto debe tener maximo 150 letras"
            }
        },
        errorElement: "div",

        errorPlacement: function ( error, element ) {
            error.addClass( "invalid-feedback" );
            error.insertAfter(element);
        },
        highlight: function ( element  ) {
            $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
        },
        unhighlight: function (element) {
            $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
        }

    } );

    $( "#formCargo" ).validate({
        rules: {
            sectorTrabajo: {
                required: true
            },
            nombreCargo:{
                required: true,
                minlength: 5,
                maxlength: 150
            },
            descripcionCargo:{
                required: false,
                minlength: 5,
                maxlength: 1000
            },
            requisitosPrincipales:{
                required: false,
                minlength: 5,
                maxlength: 1000
            },
            requisitosOpcionales:{
                required: false,
                minlength: 5,
                maxlength: 1000
            }
        },
        messages: {
            sectorTrabajo: {
                required: "Debe seleccionar un sector de trabajo"
            },
            nombreCargo: {
                required: "Debe ingresar un nombre para el cargo",
                minlength: "El nombre debe tener almenos 5 letras",
                maxlength: "El nombre debe tener maximo 150 letras"
            },
            descripcionCargo: {
                minlength: "El nombre corto debe tener almenos 5 letras",
                maxlength: "El nombre corto debe tener maximo 1000 letras"
            },
            requisitosPrincipales: {
                minlength: "El nombre corto debe tener almenos 5 letras",
                maxlength: "El nombre corto debe tener maximo 1000 letras"
            },
            requisitosOpcionales: {
                minlength: "El nombre corto debe tener almenos 5 letras",
                maxlength: "El nombre corto debe tener maximo 1000 letras"
            }
        },
        errorElement: "div",

        errorPlacement: function ( error, element ) {
            error.addClass( "invalid-feedback" );
            error.insertAfter(element);
        },
        highlight: function ( element  ) {
            $( element ).addClass( "is-invalid" ).removeClass( "is-valid" );
        },
        unhighlight: function (element) {
            $( element ).addClass( "is-valid" ).removeClass( "is-invalid" );
        }
    } );
});