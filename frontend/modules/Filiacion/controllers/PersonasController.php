<?php

namespace app\modules\Filiacion\controllers;

use app\modules\Administracion\models\TipoDocumento;
use app\modules\Filiacion\models\EstadoCivil;
use app\modules\Administracion\models\LugarEmision;
use app\modules\Filiacion\models\PersonaDato;
use app\modules\Filiacion\models\PersonasDao;
use app\modules\Filiacion\models\Persona;
use app\modules\Filiacion\models\PersonasDeclaracionJuradaDao;
use app\modules\Administracion\models\Pais;
use app\modules\Administracion\models\Departamento;
use app\modules\Administracion\models\Provincia;
use app\modules\Administracion\models\Lugar;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use Yii;

class PersonasController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id == "listar-personas" || $action->id == "listar-personas-declaracion-jurada-ajax")
            $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        //$listaPaises = ArrayHelper::map(Pais::find()->orderBy('NombrePais')->all(), 'CodigoPais', 'NombrePais');
        //$listaDepartamentos = ArrayHelper::map(Departamento::find(591)->orderBy('NombreDepartamento')->all(), 'CodigoDepartamentoAcad', 'NombreDepartamento');
        $listaEstadosCiviles = ArrayHelper::map(EstadoCivil::find()->orderBy('NombreEstadoCivil')->all(), 'CodigoEstadoCivil', 'NombreEstadoCivil');
        $listaTipoDocumento = ArrayHelper::map(TipoDocumento::find()->orderBy('Nombredocumento')->all(), 'TipoDocumento', 'NombreDocumento');
        return $this->render('personas', [
            //'paises' => $listaPaises,
            //'departamentos' => $listaDepartamentos,
            'estadosCiviles' => $listaEstadosCiviles,
            'tiposDocumentos' => $listaTipoDocumento,
        ]);
    }

    public function actionListarPersonas()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $personas = PersonasDao::listaPersonas();
            //$personas = persona::find()->orderBy('Paterno, Materno, Nombres')->all();
            $datosJson = '{"data": [';
            $cantidad = count($personas);
            for ($i = 0; $i < $cantidad; $i++) {
                //$lugarNacimiento = $personas[$i]->NombrePais . "-" . $personas[$i]->NombreDepartamento . "-" . $personas[$i]->NombreProvincia . "-" . $personas[$i]->NombreLugar;
                $fechaNacimientoFormato = date_format(date_create($personas[$i]->FechaNacimiento), 'd/m/Y');
                /*=============================================
               REVISAR ESTADO
               =============================================*/
                if ($personas[$i]->CodigoEstado == 'V') {
                    $colorEstado = "btn-success";
                    $textoEstado = "VIGENTE";
                    $estadoPersona = "V";
                } else {
                    $colorEstado = "btn-danger";
                    $textoEstado = "CADUCADO";
                    $estadoPersona = "C";
                }
                $estado = "<button class='btn " . $colorEstado . " btn-xs btnActivar' estado='" . $estadoPersona . "' codigo='" . $personas[$i]->IdPersona . "'>" . $textoEstado . "</button>";
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                $acciones = "<div class='btn-group'>";
                //$acciones .= "<button class='btn btn-warning btn-sm btnEditarPersona' codigo='" . $personas[$i]->IdPersona . "'><i class='fa fa-pen'> Editar</i></button>";
                $acciones .= "<button class='btn btn-warning btn-sm btnEditarPersona' codigo='" . $personas[$i]->IdPersona . "' data-toggle='modal' data-target='#modalActualizarPersona'><i class='fa fa-pen'>Editar</i></button>";
                //$acciones .= "<button class='btn btn-danger btn-sm btnEliminarPersona' codigo='" . $personas[$i]->IdPersona . "' nombre='" . $personas[$i]->NombreCompleto . "'><i class='fa fa-times'>Eliminar</i></button>";
                //$acciones .= "<button class='btn btn-success btn-sm btnVerImagen' nombre='" . $personas[$i]->IdPersona . "'data-toggle='modal' data-target='#modalMostrarImagen'><i class='fa fa-book'></i>Ver</button>";
                $acciones .= "</div>";
                if ($i == $cantidad - 1) {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $personas[$i]->IdPersona . '",
					 	"' . $personas[$i]->NombreCompleto . '",					 	
					 	"' . $personas[$i]->SexoLiteral . '",
					 	"' . $fechaNacimientoFormato . '",
				 	 	"' . $estado . '",				      	
				      	"' . $acciones . '"
  			  ]';
                } else {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $personas[$i]->IdPersona . '",
					 	"' . $personas[$i]->NombreCompleto . '",					 	
					 	"' . $personas[$i]->SexoLiteral . '",
					 	"' . $fechaNacimientoFormato . '",
				 	 	"' . $estado . '",
				      	"' . $acciones . '"
  			  ],';
                }
            }
            $datosJson .= ']}';
            return $datosJson;
        } else {
            $datosJson = '{"data": [';
            $datosJson .= ']}';
            return $datosJson;
        }
    }

    public function actionListarPersonasDeclaracionJuradaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $personasDeclaracionJurada = PersonasDeclaracionJuradaDao::listaPersonasDeclaracionJurada();
            $datosJson = '{"data": [';
            $cantidad = count($personasDeclaracionJurada);
            for ($i = 0; $i < $cantidad; $i++) {
                $fechaNacimiento = date_format(date_create($personasDeclaracionJurada[$i]->FechaNacimiento), 'd/m/Y');
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                $acciones = "<center><button class='btn btn-primary btnElegir' idpersona='" . $personasDeclaracionJurada[$i]->IdPersona . "' idpersona='" . $personasDeclaracionJurada[$i]->IdPersona . "' emision='" . $personasDeclaracionJurada[$i]->Emision . "' paterno='" . $personasDeclaracionJurada[$i]->Paterno . "' materno='" . $personasDeclaracionJurada[$i]->Materno . "' nombres='" . $personasDeclaracionJurada[$i]->Nombres . "' fechanacimiento='" . $fechaNacimiento . "' sexo='" . $personasDeclaracionJurada[$i]->Sexo . "' sexoliteral='" . $personasDeclaracionJurada[$i]->SexoLiteral . "' estadoCivil='" . $personasDeclaracionJurada[$i]->estadocivil . "' discapacidad='" . $personasDeclaracionJurada[$i]->discapacidad . "' direccion='" . $personasDeclaracionJurada[$i]->direccion . "'  >Seleccionar</button></center>";
                if ($i == $cantidad - 1) {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $personasDeclaracionJurada[$i]->IdPersona . '",
					 	"' . $personasDeclaracionJurada[$i]->Emision . '",
					 	"' . $personasDeclaracionJurada[$i]->NombreCompleto . '",
					 	"' . $fechaNacimiento . '",				 	 	
				      	"' . $acciones . '"
  			  ]';
                } else {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $personasDeclaracionJurada[$i]->IdPersona . '",
					 	"' . $personasDeclaracionJurada[$i]->Emision . '",
					 	"' . $personasDeclaracionJurada[$i]->NombreCompleto . '",
					 	"' . $fechaNacimiento . '",				 	 	
				      	"' . $acciones . '"
  			  ],';
                }
            }
            $datosJson .= ']}';
            return $datosJson;
        } else {
            $datosJson = '{"data": [';
            $datosJson .= ']}';
            return $datosJson;
        }
    }

    public function actionActivarPersonaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoactivar"]) && isset($_POST["estadoactivar"])) {
                $persona = Persona::findOne($_POST["codigoactivar"]);
                if ($_POST["estadoactivar"] == "V") {
                    $persona->CodigoEstado = "C";
                } else {
                    $persona->CodigoEstado = "V";
                }
                $persona->save();
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionBuscarPersonaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoeditar"])) {
                $persona = PersonasDao::buscaPersona("array", $_POST["codigoeditar"]);
                return json_encode($persona);
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionCrearPersonaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $persona = new Persona();
            $persona->IdPersona = $_POST["idpersonacrear"];
            $persona->NumeroDocumento = $_POST["numerodocumentocrear"];
            $persona->LugarExpedicion = $_POST["lugarexpedicioncrear"];
            $persona->TipoDocumento = $_POST["tipodocumentocrear"];
            $persona->PrimerNombre = $_POST["primernombrecrear"];
            $persona->SegundoNombres = $_POST["segundonombrescrear"];
            $persona->TercerNombre = $_POST["tercernombrecrear"];
            $persona->ApellidoPaterno = $_POST["apellidopaternocrear"];
            $persona->ApellidoMaterno = $_POST["apllidomaternocrear"];
            $persona->FechaNacimiento = $_POST["fechanacimientocrear"];
            $persona->Sexo = $_POST["sexocrear"];
            $persona->CodigoEstadoCivil = $_POST["codigoestadocivilcrear"];
            $persona->Domicilio = $_POST["domiciliocrear"];
            $persona->LibretaServicioMilitar = $_POST["libretamilitarcrear"];
            $persona->CodigoEstado = 'V';
            $persona->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;
            /*$persona->CodigoLugarEmision = $_POST["emisioncrear"];
            $persona->Nombres = $_POST["nombrescrear"];
            $persona->Paterno = $_POST["paternocrear"];
            $persona->Materno = $_POST["maternocrear"];
            $persona->FechaNacimiento = $_POST["fechanacimientocrear"];
            $persona->Sexo = $_POST["sexocrear"];
            $persona->Discapacidad = $_POST["discapacidadcrear"];
            $persona->CantidadDependientesDiscapacidad = $_POST["cantidaddependientesdiscapacitadoscrear"];
            $persona->CodigoEstado = 'V';
            $persona->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;

            $personaDatos = new PersonaDato();
            $personaDatos->IdPersona = $_POST["idpersonadatoscrear"];
            $personaDatos->CodigoLugar = $_POST["codigolugarcrear"];
            $personaDatos->CodigoEstadoCivil = $_POST["codigoestadocivilcrear"];
            $personaDatos->ApellidoEsposo = $_POST["apellidoesposocrear"];
            $personaDatos->Direccion = $_POST["direccioncrear"];
            $personaDatos->Telefono = $_POST["telefonocrear"];
            $personaDatos->Celular = $_POST["celularcrear"];*/
            if (!$persona->exist() /*&& !$personaDatos->exist()*/) {
                $persona->save();
                //$personaDatos->save();
                return "ok";
            } else {
                return "existe";
            }
        } else {
            return "error";
        }
    }

    public function actionActualizarPersonaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["idpersonaactualizar"])) {
                $persona = Persona::findOne($_POST["idpersonaactualizar"]);
                $persona->LugarExpedicion = $_POST["lugarexpedicionactualizar"];
                $persona->PrimerNombre = $_POST["primernombreactualizar"];
                $persona->SegundoNombres = $_POST["segundonombresactualizar"];
                $persona->TercerNombre = $_POST["tercernombreactualizar"];
                $persona->ApellidoPaterno = $_POST["apellidopaternoactualizar"];
                $persona->ApellidoMaterno = $_POST["apllidomaternoactualizar"];
                $persona->FechaNacimiento = $_POST["fechanacimientoactualizar"];
                $persona->Sexo = $_POST["sexoactualizar"];
                $persona->CodigoEstadoCivil = $_POST["codigoestadocivilactualizar"];
                $persona->Domicilio = $_POST["domicilioactualizar"];
                $persona->LibretaServicioMilitar = $_POST["libretamilitaractualizar"];
                $persona->save();
                //$persona->Discapacidad = $_POST["discapacidadactualizar"];
                //$persona->CantidadDependientesDiscapacidad = $_POST["cantidaddependientesdiscapacitadosactualizar"];

                /*$personaDatos = PersonaDato::findOne($_POST["idpersonadatosactualizar"]);
                $personaDatos->CodigoLugar = $_POST["codigolugaractualizar"];
                $personaDatos->CodigoEstadoCivil = $_POST["codigoestadocivilactualizar"];
                $personaDatos->ApellidoEsposo = $_POST["apellidoesposoactualizar"];
                $personaDatos->Direccion = $_POST["direccionactualizar"];
                $personaDatos->Celular = $_POST["celularactualizar"];
                $personaDatos->Telefono = $_POST["telefonoactualizar"];
                $persona->save();
                $personaDatos->save();*/
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionEliminarPersonaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoeliminar"])) {
                $persona = Persona::findOne($_POST["codigoeliminar"]);
                $personaDatos = PersonaDato::findOne($_POST["codigoeliminar"]);
                if (!$persona->isUsed()) {
                $persona->delete();
                $personaDatos->delete();
                return "ok";
                } else {
                  return "enUso";
                }
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionListarDepartamentosAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $opciones = "<option value=''>Selecionar Departamento</option>";
            $codigoPais = $_POST["codigopais"];
            $departamentos = Departamento::find()->where(["CodigoPais" => $codigoPais])->orderBy('NombreDepartamento')->all();
            foreach ($departamentos as $departamento) {
                $opciones .= "<option value='" . $departamento->CodigoDepartamento . "'>" . $departamento->NombreDepartamento . "</option>";
            }
            return $opciones;
        }
    }

    public function actionListarProvinciasAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $opciones = "<option value=''>Selecionar Provincia</option>";
            //$codigoPais = $_POST["codigopais"];
            $codigoDepartamento = $_POST["codigodepartamento"];
            //$provincias = Provincia::find()->where(["CodigoPais" => $codigoPais])->andWhere(["CodigoDepartamento" => $codigoDepartamento])->orderBy('NombreProvincia')->all();
            $provincias = Provincia::find()->where(["CodigoDepartamento" => $codigoDepartamento])->orderBy('NombreProvincia')->all();
            foreach ($provincias as $provincia) {
                $opciones .= "<option value='" . $provincia->CodigoProvincia . "'>" . $provincia->NombreProvincia . "</option>";
            }
            return $opciones;
        }
    }

    public function actionListarLugaresAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $opciones = "<option value=''>Selecionar Lugar</option>";
            //$codigoPais = $_POST["codigopais"];
            //$codigoDepartamento = $_POST["codigodepartamento"];
            $codigoProvincia = $_POST["codigoprovincia"];
            //$lugares = Lugar::find()->where(["CodigoPais" => $codigoPais])->andWhere(["CodigoDepartamento" => $codigoDepartamento])->andWhere(["CodigoProvincia" => $codigoProvincia])->orderBy('NombreLugar')->all();
            $lugares = Lugar::find()->where(["CodigoProvincia" => $codigoProvincia])->orderBy('NombreLugar')->all();
            foreach ($lugares as $lugar) {
                $opciones .= "<option value='" . $lugar->CodigoLugar . "'>" . $lugar->NombreLugar . "</option>";
            }
            return $opciones;
        }
    }

    public function actionSubirAnversoAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {

            $ciAnverso = $_POST["idpersona"];
            $imagenOriginal = $_FILES['file']['name'];
            $imagenTemporal = $_FILES["file"]["tmp_name"];
            $imagenTipo = strtolower(pathinfo($imagenOriginal, PATHINFO_EXTENSION));
            $dir = "img/ci/";

            //Especificamos cual sera el ancho y alto maximo permitido
            //para la imagen redimensionada

            $anchoMaximo = 2100;
            $altoMaximo = 2800;


            if (($imagenTipo === "jpeg") || ($imagenTipo === "jpg") || ($imagenTipo === "png")) {
                $fileName = str_replace(" ", "_", trim($ciAnverso)) . '_anverso' . '.' . 'jpeg';
                $fileNameComplete = $dir . $fileName;
                $imagenGuardada = move_uploaded_file($imagenTemporal, $fileNameComplete);

                if ($imagenGuardada) {
                    $mostrarImagen = $fileNameComplete;

                    return $mostrarImagen;
                    //more code here...
                    //Extraigo los atributos ancho y alto de la imagen original
                    $dimensiones = getimagesize($mostrarImagen);
                    $ancho = $dimensiones[0];
                    $alto = $dimensiones[1];
                    if (($ancho >= $anchoMaximo) && ($alto >= $altoMaximo)) {

                        //Creamos una imagen temporal para poder manipularla
                        //sin modificar imagen original
                        $imagenTemporal = imagecreatefromjpeg($imagenGuardada);


                        //Calculamos el ancho y alto propocional de
                        //la imagen redimensionada
                        $anchoProporcional = $anchoMaximo / $ancho;
                        $altoProporcional = $altoMaximo / $alto;
                        //En caso de que el ancho y el alto estan dentro,
                        //de los maximos permitidos, los mantenemos
                        if (($ancho <= $anchoMaximo) && ($alto <= $altoMaximo)) {
                            $anchoNuevo = $ancho;
                            $altoNuevo = $alto;
                        }
                        //Si el alto es mayor que el ancho
                        //calculamos un alto proporcional al maximo permitido
                        elseif (($anchoProporcional * $alto) < $altoMaximo) {
                            $altoNuevo = ceil($anchoProporcional * $alto);
                            $anchoNuevo = $anchoMaximo;
                        }
                        //Si el ancho es mayor que el alto
                        //calculamos un ancho proporcional al maximo permitido
                        else {
                            $anchoNuevo = ceil($altoProporcional * $ancho);
                            $altoNuevo = $altoMaximo;
                        }

                        //Creamos una imagen de tamaño $anchonuevo  por $altonuevo .
                        $imgNueva = imagecreatetruecolor($anchoNuevo, $altoNuevo);
                        //Copiamos la imagen temporal sobre la imagen nueva con las
                        //dimensiones definidas
                        imagecopyresampled($imgNueva, $imagenTemporal, 0, 0, 0, 0, $anchoNuevo, $altoNuevo, $ancho, $alto);
                        //Quitamos la imagen temporal de la Ram
                        imagedestroy($imagenTemporal);

                        //Definimos la calidad de la imagen nueva
                        $calidad = 100;
                        //separamos el nombre del archivo de su extension
                        $archivo = explode(".", $imagenOriginal);
                        //Añadimos al nuevo archivo la palabra mini
                        //para saber que es un miniatura
                        $archivoNuevo = $archivo[0] . "-mini." . $archivo[1];

                        //Guardamos la nueva imagen en la carpeta que
                        //asignemos, por ejemplo podemos tener una carpeta
                        //para imagenes originales y otra para miniaturas
                        imagejpeg($imgNueva, $archivoNuevo, $calidad);
                    } else {
                        return "errorTamaño";
                    }
                } else {
                    return "errorGuardado";
                }
            } else {
                return "errorFormato";
            }
        } else {
            return "error";

        }
    }

    public function actionSubirReversoAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {

            $ciAnverso = $_POST["idpersona"];
            $imagenOriginal = $_FILES['file']['name'];
            $imagenTemporal = $_FILES["file"]["tmp_name"];
            $imagenTipo = strtolower(pathinfo($imagenOriginal, PATHINFO_EXTENSION));
            $dir = "img/ci/";

            //Especificamos cual sera el ancho y alto maximo permitido
            //para la imagen redimensionada

            $anchoMaximo = 2100;
            $altoMaximo = 2800;


            if (($imagenTipo === "jpeg") || ($imagenTipo === "jpg") || ($imagenTipo === "png")) {
                $fileName = str_replace(" ", "_", trim($ciAnverso)) . '_reverso' . '.' . 'jpeg';
                $fileNameComplete = $dir . $fileName;
                $imagenGuardada = move_uploaded_file($imagenTemporal, $fileNameComplete);

                if ($imagenGuardada) {
                    $mostrarImagen = $fileNameComplete;

                    return $mostrarImagen;
                    //more code here...
                    //Extraigo los atributos ancho y alto de la imagen original
                    $dimensiones = getimagesize($mostrarImagen);
                    $ancho = $dimensiones[0];
                    $alto = $dimensiones[1];
                    if (($ancho >= $anchoMaximo) && ($alto >= $altoMaximo)) {

                        //Creamos una imagen temporal para poder manipularla
                        //sin modificar imagen original
                        $imagenTemporal = imagecreatefromjpeg($imagenGuardada);


                        //Calculamos el ancho y alto propocional de
                        //la imagen redimensionada
                        $anchoProporcional = $anchoMaximo / $ancho;
                        $altoProporcional = $altoMaximo / $alto;
                        //En caso de que el ancho y el alto estan dentro,
                        //de los maximos permitidos, los mantenemos
                        if (($ancho <= $anchoMaximo) && ($alto <= $altoMaximo)) {
                            $anchoNuevo = $ancho;
                            $altoNuevo = $alto;
                        }
                        //Si el alto es mayor que el ancho
                        //calculamos un alto proporcional al maximo permitido
                        elseif (($anchoProporcional * $alto) < $altoMaximo) {
                            $altoNuevo = ceil($anchoProporcional * $alto);
                            $anchoNuevo = $anchoMaximo;
                        }
                        //Si el ancho es mayor que el alto
                        //calculamos un ancho proporcional al maximo permitido
                        else {
                            $anchoNuevo = ceil($altoProporcional * $ancho);
                            $altoNuevo = $altoMaximo;
                        }

                        //Creamos una imagen de tamaño $anchonuevo  por $altonuevo .
                        $imgNueva = imagecreatetruecolor($anchoNuevo, $altoNuevo);
                        //Copiamos la imagen temporal sobre la imagen nueva con las
                        //dimensiones definidas
                        imagecopyresampled($imgNueva, $imagenTemporal, 0, 0, 0, 0, $anchoNuevo, $altoNuevo, $ancho, $alto);
                        //Quitamos la imagen temporal de la Ram
                        imagedestroy($imagenTemporal);

                        //Definimos la calidad de la imagen nueva
                        $calidad = 100;
                        //separamos el nombre del archivo de su extension
                        $archivo = explode(".", $imagenOriginal);
                        //Añadimos al nuevo archivo la palabra mini
                        //para saber que es un miniatura
                        $archivoNuevo = $archivo[0] . "-mini." . $archivo[1];

                        //Guardamos la nueva imagen en la carpeta que
                        //asignemos, por ejemplo podemos tener una carpeta
                        //para imagenes originales y otra para miniaturas
                        imagejpeg($imgNueva, $archivoNuevo, $calidad);
                    } else {
                        return "errorTamaño";
                    }
                } else {
                    return "errorGuardado";
                }
            } else {
                return "errorFormato";
            }
        } else {
            return "error";

        }
    }

    public function actionSubirCertificadoNacimientoAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {

            $ciAnverso = $_POST["idpersona"];
            $imagenOriginal = $_FILES['file']['name'];
            $imagenTemporal = $_FILES["file"]["tmp_name"];
            $imagenTipo = strtolower(pathinfo($imagenOriginal, PATHINFO_EXTENSION));
            $dir = "img/certificadonacimiento/";

            //Especificamos cual sera el ancho y alto maximo permitido
            //para la imagen redimensionada

            $anchoMaximo = 2100;
            $altoMaximo = 2800;


            if (($imagenTipo === "jpeg") || ($imagenTipo === "jpg") || ($imagenTipo === "png")) {
                $fileName = str_replace(" ", "_", trim($ciAnverso)) . '_certificado_nacimiento' . '.' . 'jpeg';
                $fileNameComplete = $dir . $fileName;
                $imagenGuardada = move_uploaded_file($imagenTemporal, $fileNameComplete);

                if ($imagenGuardada) {
                    $mostrarImagen = $fileNameComplete;

                    return $mostrarImagen;
                    //more code here...
                    //Extraigo los atributos ancho y alto de la imagen original
                    $dimensiones = getimagesize($mostrarImagen);
                    $ancho = $dimensiones[0];
                    $alto = $dimensiones[1];
                    if (($ancho >= $anchoMaximo) && ($alto >= $altoMaximo)) {

                        //Creamos una imagen temporal para poder manipularla
                        //sin modificar imagen original
                        $imagenTemporal = imagecreatefromjpeg($imagenGuardada);


                        //Calculamos el ancho y alto propocional de
                        //la imagen redimensionada
                        $anchoProporcional = $anchoMaximo / $ancho;
                        $altoProporcional = $altoMaximo / $alto;
                        //En caso de que el ancho y el alto estan dentro,
                        //de los maximos permitidos, los mantenemos
                        if (($ancho <= $anchoMaximo) && ($alto <= $altoMaximo)) {
                            $anchoNuevo = $ancho;
                            $altoNuevo = $alto;
                        }
                        //Si el alto es mayor que el ancho
                        //calculamos un alto proporcional al maximo permitido
                        elseif (($anchoProporcional * $alto) < $altoMaximo) {
                            $altoNuevo = ceil($anchoProporcional * $alto);
                            $anchoNuevo = $anchoMaximo;
                        }
                        //Si el ancho es mayor que el alto
                        //calculamos un ancho proporcional al maximo permitido
                        else {
                            $anchoNuevo = ceil($altoProporcional * $ancho);
                            $altoNuevo = $altoMaximo;
                        }

                        //Creamos una imagen de tamaño $anchonuevo  por $altonuevo .
                        $imgNueva = imagecreatetruecolor($anchoNuevo, $altoNuevo);
                        //Copiamos la imagen temporal sobre la imagen nueva con las
                        //dimensiones definidas
                        imagecopyresampled($imgNueva, $imagenTemporal, 0, 0, 0, 0, $anchoNuevo, $altoNuevo, $ancho, $alto);
                        //Quitamos la imagen temporal de la Ram
                        imagedestroy($imagenTemporal);

                        //Definimos la calidad de la imagen nueva
                        $calidad = 100;
                        //separamos el nombre del archivo de su extension
                        $archivo = explode(".", $imagenOriginal);
                        //Añadimos al nuevo archivo la palabra mini
                        //para saber que es un miniatura
                        $archivoNuevo = $archivo[0] . "-mini." . $archivo[1];

                        //Guardamos la nueva imagen en la carpeta que
                        //asignemos, por ejemplo podemos tener una carpeta
                        //para imagenes originales y otra para miniaturas
                        imagejpeg($imgNueva, $archivoNuevo, $calidad);
                    } else {
                        return "errorTamaño";
                    }
                } else {
                    return "errorGuardado";
                }
            } else {
                return "errorFormato";
            }
        } else {
            return "error";

        }
    }

    public function actionSubirCertificadoEstadoCivilAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {

            $ciAnverso = $_POST["idpersona"];
            $imagenOriginal = $_FILES['file']['name'];
            $imagenTemporal = $_FILES["file"]["tmp_name"];
            $imagenTipo = strtolower(pathinfo($imagenOriginal, PATHINFO_EXTENSION));
            $dir = "img/certificadoestadocivil/";

            //Especificamos cual sera el ancho y alto maximo permitido
            //para la imagen redimensionada

            $anchoMaximo = 2100;
            $altoMaximo = 2800;


            if (($imagenTipo === "jpeg") || ($imagenTipo === "jpg") || ($imagenTipo === "png")) {
                $fileName = str_replace(" ", "_", trim($ciAnverso)) . '_certificado_estado_civil' . '.' . 'jpeg';
                $fileNameComplete = $dir . $fileName;
                $imagenGuardada = move_uploaded_file($imagenTemporal, $fileNameComplete);

                if ($imagenGuardada) {
                    $mostrarImagen = $fileNameComplete;

                    return $mostrarImagen;
                    //more code here...
                    //Extraigo los atributos ancho y alto de la imagen original
                    $dimensiones = getimagesize($mostrarImagen);
                    $ancho = $dimensiones[0];
                    $alto = $dimensiones[1];
                    if (($ancho >= $anchoMaximo) && ($alto >= $altoMaximo)) {

                        //Creamos una imagen temporal para poder manipularla
                        //sin modificar imagen original
                        $imagenTemporal = imagecreatefromjpeg($imagenGuardada);


                        //Calculamos el ancho y alto propocional de
                        //la imagen redimensionada
                        $anchoProporcional = $anchoMaximo / $ancho;
                        $altoProporcional = $altoMaximo / $alto;
                        //En caso de que el ancho y el alto estan dentro,
                        //de los maximos permitidos, los mantenemos
                        if (($ancho <= $anchoMaximo) && ($alto <= $altoMaximo)) {
                            $anchoNuevo = $ancho;
                            $altoNuevo = $alto;
                        }
                        //Si el alto es mayor que el ancho
                        //calculamos un alto proporcional al maximo permitido
                        elseif (($anchoProporcional * $alto) < $altoMaximo) {
                            $altoNuevo = ceil($anchoProporcional * $alto);
                            $anchoNuevo = $anchoMaximo;
                        }
                        //Si el ancho es mayor que el alto
                        //calculamos un ancho proporcional al maximo permitido
                        else {
                            $anchoNuevo = ceil($altoProporcional * $ancho);
                            $altoNuevo = $altoMaximo;
                        }

                        //Creamos una imagen de tamaño $anchonuevo  por $altonuevo .
                        $imgNueva = imagecreatetruecolor($anchoNuevo, $altoNuevo);
                        //Copiamos la imagen temporal sobre la imagen nueva con las
                        //dimensiones definidas
                        imagecopyresampled($imgNueva, $imagenTemporal, 0, 0, 0, 0, $anchoNuevo, $altoNuevo, $ancho, $alto);
                        //Quitamos la imagen temporal de la Ram
                        imagedestroy($imagenTemporal);

                        //Definimos la calidad de la imagen nueva
                        $calidad = 100;
                        //separamos el nombre del archivo de su extension
                        $archivo = explode(".", $imagenOriginal);
                        //Añadimos al nuevo archivo la palabra mini
                        //para saber que es un miniatura
                        $archivoNuevo = $archivo[0] . "-mini." . $archivo[1];

                        //Guardamos la nueva imagen en la carpeta que
                        //asignemos, por ejemplo podemos tener una carpeta
                        //para imagenes originales y otra para miniaturas
                        imagejpeg($imgNueva, $archivoNuevo, $calidad);
                    } else {
                        return "errorTamaño";
                    }
                } else {
                    return "errorGuardado";
                }
            } else {
                return "errorFormato";
            }
        } else {
            return "error";

        }
    }

    public function actionMostrarImagenAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $nombre = $_POST["nombre"];
            $dirCiAnverso = "/SiacPersonal1/frontend/web/img/ci/";
            $fileNameAnverso = str_replace(" ", "_", trim($nombre)) . '_anverso' . '.' . 'jpeg';
            $fileNameCompleteAnverso = $dirCiAnverso . $fileNameAnverso;
            if ($fileNameCompleteAnverso ) {
                return $fileNameCompleteAnverso;
            } else
                return "errorNombre";
        }
    }

    public function actionMostrarCiReversoAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $nombre = $_POST["nombre"];
            $dirCiReverso = "/SiacPersonal1/frontend/web/img/ci/";
            $fileNameReverso = str_replace(" ", "_", trim($nombre)) . '_reverso' . '.' . 'jpeg';
            $fileNameCompleteReverso = $dirCiReverso . $fileNameReverso;
            if ($fileNameCompleteReverso ) {
                return $fileNameCompleteReverso;
            } else
                return "errorNombre";
        }
    }

    public function actionMostrarCertificadoNacimientoAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $nombre = $_POST["nombre"];
            $dirCertificadoNacimiento = "/SiacPersonal1/frontend/web/img/certificadonacimiento/";
            $fileNameCertificadoNacimiento = str_replace(" ", "_", trim($nombre)) . '_certificado_nacimiento' . '.' . 'jpeg';
            $fileNameCompleteCertificadoNacimiento = $dirCertificadoNacimiento . $fileNameCertificadoNacimiento;
            if ($fileNameCompleteCertificadoNacimiento ) {
                return $fileNameCompleteCertificadoNacimiento;
            } else
                return "errorNombre";
        }
    }

    public function actionMostrarCertificadoEstadoCivilAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $nombre = $_POST["nombre"];
            $dirCertificadoEstadoCivil = "/SiacPersonal1/frontend/web/img/certificadoestadocivil/";
            $fileNameCertificadoEstadoCivil = str_replace(" ", "_", trim($nombre)) . '_certificado_estado_civil' . '.' . 'jpeg';
            $fileNameCompleteCertificadoEstadoCivil = $dirCertificadoEstadoCivil . $fileNameCertificadoEstadoCivil;
            if ($fileNameCompleteCertificadoEstadoCivil) {
                return $fileNameCompleteCertificadoEstadoCivil;
            } else
                return "errorNombre";
        }
    }
}