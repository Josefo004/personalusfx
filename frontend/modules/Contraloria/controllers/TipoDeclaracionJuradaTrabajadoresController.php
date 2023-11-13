<?php

namespace app\modules\Contraloria\controllers;

//use common\models\TiposDeclaracionesJuradasDao;
use app\modules\Contraloria\models\TiposDeclaracionesJuradasTrabajadoresDao;
use app\modules\Filiacion\models\TrabajadoresDao;
use app\modules\Contraloria\models\TipoDeclaracionJuradaTrabajador;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Yii;

class TipoDeclaracionJuradaTrabajadoresController extends Controller
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
        if ($action->id == "listar-trabajadores-tipo-declaracion-jurada-ajax")
            $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionListarTrabajadoresAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $trabajadores = TrabajadoresDao::listaTrabajadores();
            if (count($trabajadores) > 0) {
                $datosJson = '{"data": [';
                $cantidad = count($trabajadores);
                for ($i = 0; $i < $cantidad; $i++) {
                    $fechaNacimiento = date_format(date_create($trabajadores[$i]->FechaNacimiento), 'd/m/Y');
                    $fechaIngreso = date_format(date_create($trabajadores[$i]->FechaIngreso), 'd/m/Y');
                    $fechaSalida = "";
                    if ($trabajadores[$i]->FechaSalida != null) {
                        $fechaSalida = date_format(date_create($trabajadores[$i]->FechaSalida), 'd/m/Y');
                    }
                    /*=============================================
                    CREAR LAS ACCIONES
                    =============================================*/
                    $acciones = "<center><button class='btn btn-primary btnElegirTrabajador' idpersona='" . $trabajadores[$i]->IdPersona . "' codigo='" . $trabajadores[$i]->CodigoTrabajador . "' nombre='" . $trabajadores[$i]->NombreCompleto . "' fechanacimiento='" . $fechaNacimiento . "'>Seleccionar</button></center>";
                    if ($i == $cantidad - 1) {
                        $datosJson .= '[
                                "' . ($i + 1) . '",
                                "' . $trabajadores[$i]->CodigoTrabajador . '",
                                "' . $trabajadores[$i]->IdPersona . '",					 	
                                "' . $trabajadores[$i]->NombreCompleto . '",
                                "' . $fechaNacimiento . '",
                                "' . $fechaIngreso . '",
                                "' . $fechaSalida . '",                                
                                "' . $acciones . '"
  			                ]';
                    } else {
                        $datosJson .= '[
                                "' . ($i + 1) . '",
                                "' . $trabajadores[$i]->CodigoTrabajador . '",
                                "' . $trabajadores[$i]->IdPersona . '",					 	
                                "' . $trabajadores[$i]->NombreCompleto . '",
                                "' . $fechaNacimiento . '",
                                "' . $fechaIngreso . '",
                                "' . $fechaSalida . '",
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
        } else {
            $datosJson = '{"data": [';
            $datosJson .= ']}';
            return $datosJson;
        }
    }

    public function actionListarTrabajadoresTipoDeclaracionJuradaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $trabajadores = TrabajadoresDao::listaTrabajadoresTipoDeclaracionJurada($_POST["codigotipodeclaracionjurada"]);
            if (count($trabajadores) > 0) {
                $datosJson = '{"data": [';
                $cantidad = count($trabajadores);
                for ($i = 0; $i < $cantidad; $i++) {
                    $fechaNacimiento = date_format(date_create($trabajadores[$i]->FechaNacimiento), 'd/m/Y');
                    $fechaIngreso = date_format(date_create($trabajadores[$i]->FechaIngreso), 'd/m/Y');
                    $fechaSalida = "";
                    if ($trabajadores[$i]->FechaSalida != null) {
                        $fechaSalida = date_format(date_create($trabajadores[$i]->FechaSalida), 'd/m/Y');
                    }
                    /*=============================================
                   REVISAR ESTADO
                   =============================================*/
                    if ($trabajadores[$i]->CodigoEstado == 'V') {
                        $colorEstado = "btn-success";
                        $textoEstado = "VIGENTE";
                        $estadoTrabajador = "V";
                    } else {
                        $colorEstado = "btn-danger";
                        $textoEstado = "CADUCADO";
                        $estadoTrabajador = "C";
                    }
                    $estado = "<button class='btn " . $colorEstado . " btn-xs btnActivarTipoDeclaracionJuradaTrabajador' estado='" . $estadoTrabajador . "' codigo='" . $trabajadores[$i]->CodigoTrabajador . "'>" . $textoEstado . "</button>";
                    /*=============================================
                    CREAR LAS ACCIONES
                    =============================================*/
                    $acciones = "<div class='btn-group'>";
                    $acciones .= "<button class='btn btn-warning btnEditarTipoDeclaracionJuradaTrabajador' codigo='" . $trabajadores[$i]->CodigoTrabajador . "' fechanacimiento='" . $fechaNacimiento . "' data-toggle='modal' data-target='#modalActualizarTipoDeclaracionJuradaTrabajador'><i class='fa fa-pen'></i></button>";
                    $acciones .= "<button class='btn btn-danger btnEliminarTipoDeclaracionJuradaTrabajador' codigo='" . $trabajadores[$i]->CodigoTrabajador . "' nombre='" . $trabajadores[$i]->NombreCompleto . "'><i class='fa fa-times'></i></button>";
                    $acciones .= "</div>";
                    if ($i == $cantidad - 1) {
                        $datosJson .= '[
                                "' . ($i + 1) . '",
                                "' . $trabajadores[$i]->CodigoTrabajador . '",
                                "' . $trabajadores[$i]->IdPersona . '",					 	
                                "' . $trabajadores[$i]->NombreCompleto . '",
                                "' . $fechaIngreso . '",
                                "' . $fechaSalida . '",					 	
                                "' . $trabajadores[$i]->NombreAfp . '",
                                "' . $trabajadores[$i]->NombreNivelAcademico . '",
                                "' . $estado . '",				      	
                                "' . $acciones . '"
  			                ]';
                    } else {
                        $datosJson .= '[
                                "' . ($i + 1) . '",
                                "' . $trabajadores[$i]->CodigoTrabajador . '",
                                "' . $trabajadores[$i]->IdPersona . '",					 	
                                "' . $trabajadores[$i]->NombreCompleto . '",
                                "' . $fechaIngreso . '",
                                "' . $fechaSalida . '",					 	
                                "' . $trabajadores[$i]->NombreAfp . '",
                                "' . $trabajadores[$i]->NombreNivelAcademico . '",
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

        } else {
            $datosJson = '{"data": [';
            $datosJson .= ']}';
            return $datosJson;
        }
    }

    public function actionAgregarTipoDeclaracionJuradaTrabajadorAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $tipoDeclaracionJuradaTrabajador = new TipoDeclaracionJuradaTrabajador();
            $tipoDeclaracionJuradaTrabajador->CodigoTipoDeclaracionJurada = $_POST["codigotipodeclaracionjuradacrear"];
            $tipoDeclaracionJuradaTrabajador->CodigoTrabajador = $_POST["codigotrabajadorcrear"];
            $tipoDeclaracionJuradaTrabajador->FechaInicioRecordatorio = $_POST["fechainiciorecordatoriocrear"];
            $tipoDeclaracionJuradaTrabajador->FechaFinRecordatorio = $_POST["fechafinrecordatoriocrear"];
            $tipoDeclaracionJuradaTrabajador->CodigoEstado = 'V';
            $tipoDeclaracionJuradaTrabajador->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;
            if (!$tipoDeclaracionJuradaTrabajador->exist()) {
                $tipoDeclaracionJuradaTrabajador->save();
                return "ok";
            } else {
                return "existe";
            }
        } else {
            return "error";

        }
    }

    public function actionActivarTipoDeclaracionJuradaTrabajadorAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigotipodeclaracionjurada"]) && isset($_POST["codigotrabajador"])) {
                $tipoDeclaracionJuradaTrabajador = TipoDeclaracionJuradaTrabajador::findOne(["CodigoTipoDeclaracionJurada" => $_POST["codigotipodeclaracionjurada"], "CodigoTrabajador" => $_POST["codigotrabajador"]]);
                if ($tipoDeclaracionJuradaTrabajador->CodigoEstado == "V") {
                    $tipoDeclaracionJuradaTrabajador->CodigoEstado = "C";
                } else {
                    $tipoDeclaracionJuradaTrabajador->CodigoEstado = "V";
                }
                $tipoDeclaracionJuradaTrabajador->save();
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionBuscarTipoDeclaracionJuradaTrabajadorAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigotipodeclaracionjurada"]) && isset($_POST["codigotrabajador"])) {
                $tipoDeclaracionJuradaTrabajador = TiposDeclaracionesJuradasTrabajadoresDao::buscaTipoDeclaracionJuradaTrabajador("array", $_POST["codigotipodeclaracionjurada"], $_POST["codigotrabajador"]);
                return json_encode($tipoDeclaracionJuradaTrabajador);
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionActualizarTipoDeclaracionJuradaTrabajadorAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigotipodeclaracionjurada"]) && isset($_POST["codigotrabajador"])) {
                $tipoDeclaracionJuradaTrabajador = TipoDeclaracionJuradaTrabajador::findOne(["CodigoTipoDeclaracionJurada" => $_POST["codigotipodeclaracionjurada"], "CodigoTrabajador" => $_POST["codigotrabajador"]]);
                $tipoDeclaracionJuradaTrabajador->FechaInicioRecordatorio = $_POST["fechainiciorecordatorio"];
                $tipoDeclaracionJuradaTrabajador->FechaFinRecordatorio = $_POST["fechafinrecordatorio"];
                $tipoDeclaracionJuradaTrabajador->save();
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionEliminarTipoDeclaracionJuradaTrabajadorAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigotipodeclaracionjuradaeliminar"]) && isset($_POST["codigotrabajadoreliminar"])) {
                $tipoDeclaracionJuradaTrabajador = TipoDeclaracionJuradaTrabajador::find()->where(["CodigoTipoDeclaracionJurada" => $_POST["codigotipodeclaracionjuradaeliminar"]])->andWhere(["CodigoTrabajador" => $_POST["codigotrabajadoreliminar"]])->one();
                if (!$tipoDeclaracionJuradaTrabajador->isUsed()) {
                    $tipoDeclaracionJuradaTrabajador->delete();
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

    public function actionExisteTipoDeclaracionJuradaTrabajadorAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigotipodeclaracionjurada"]) && isset($_POST["codigotrabajador"])) {
                $tipoDeclaracionJuradaTrabajador = TipoDeclaracionJuradaTrabajador::findOne(["CodigoTipoDeclaracionJurada" => $_POST["codigotipodeclaracionjurada"], "CodigoTrabajador" => $_POST["codigotrabajador"]]);
                if ($tipoDeclaracionJuradaTrabajador != null) {
                    return "si";
                } else {
                    return "no";
                }
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }
}