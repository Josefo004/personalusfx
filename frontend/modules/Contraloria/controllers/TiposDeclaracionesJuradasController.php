<?php

namespace app\modules\Contraloria\controllers;

use app\modules\Contraloria\models\TiposDeclaracionesJuradasDao;
use app\modules\Contraloria\models\TipoDeclaracionJurada;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Yii;

class TiposDeclaracionesJuradasController extends Controller
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
        if ($action->id == "listar-tipos-declaraciones-juradas-ajax")
            $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $listaFrecuencias = array('0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10',);
        return $this->render('tiposdeclaracionesjuradas', ['frecuencias' => $listaFrecuencias]);
    }

    public function actionListarTiposDeclaracionesJuradasAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $tiposDeclaracionesJuradas = TipoDeclaracionJurada::find()->orderBy('CodigoTipoDeclaracionJurada')->all();
            $datosJson = '{"data": [';
            $cantidad = count($tiposDeclaracionesJuradas);
            for ($i = 0; $i < $cantidad; $i++) {
                /*=============================================
               REVISAR ESTADO
               =============================================*/
                if ($tiposDeclaracionesJuradas[$i]->CodigoEstado == 'V') {
                    $colorEstado = "btn-success";
                    $textoEstado = "VIGENTE";
                    $estadoTipoDJ = "V";
                } else {
                    $colorEstado = "btn-danger";
                    $textoEstado = "CADUCADO";
                    $estadoTipoDJ = "C";
                }
                $estado = "<button class='btn " . $colorEstado . " btn-xs btnActivarTipoDeclaracionJurada' codigo='" . $tiposDeclaracionesJuradas[$i]->CodigoTipoDeclaracionJurada . "' estado='" . $tiposDeclaracionesJuradas[$i]->CodigoEstado . "'>" . $textoEstado . "</button>";
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                $acciones = "<div class='btn-group'>";
                $acciones .= "<button class='btn btn-warning btnEditarTipoDeclaracionJurada' codigo='" . $tiposDeclaracionesJuradas[$i]->CodigoTipoDeclaracionJurada . "' data-toggle='modal' data-target='#modalActualizarTipoDeclaracionJurada'><i class='fa fa-pen'></i></button>";
                $acciones .= "<button class='btn btn-danger btnEliminarTipoDeclaracionJurada' codigo='" . $tiposDeclaracionesJuradas[$i]->CodigoTipoDeclaracionJurada . "' nombre='" . $tiposDeclaracionesJuradas[$i]->NombreTipoDeclaracionJurada . "'><i class='fa fa-times'></i></button>";
                $acciones .= "<button class='btn btn-success btnTrabajadoresTipoDeclaracionJurada' codigo='" . $tiposDeclaracionesJuradas[$i]->CodigoTipoDeclaracionJurada . "'><i class='fa fa-arrow-right'></i></button>";
                $acciones .= "</div>";
                if ($i == $cantidad - 1) {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $tiposDeclaracionesJuradas[$i]->CodigoTipoDeclaracionJurada . '",
					 	"' . $tiposDeclaracionesJuradas[$i]->NombreTipoDeclaracionJurada . '",
					 	"' . $tiposDeclaracionesJuradas[$i]->Frecuencia . '",
				 	 	"' . $estado . '",				      	
				      	"' . $acciones . '"
  			        ]';
                } else {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $tiposDeclaracionesJuradas[$i]->CodigoTipoDeclaracionJurada . '",
					 	"' . $tiposDeclaracionesJuradas[$i]->NombreTipoDeclaracionJurada . '",
					 	"' . $tiposDeclaracionesJuradas[$i]->Frecuencia . '",
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

    public function actionActivarTipoDeclaracionJuradaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigotipodeclaracionjurada"])) {
                $tipoDeclaracionJurada = TipoDeclaracionJurada::findOne($_POST["codigotipodeclaracionjurada"]);
                if ($tipoDeclaracionJurada->CodigoEstado == "V") {
                    $tipoDeclaracionJurada->CodigoEstado = "C";
                } else {
                    $tipoDeclaracionJurada->CodigoEstado = "V";
                }
                $tipoDeclaracionJurada->save();
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionBuscarTipoDeclaracionJuradaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigotipodeclaracionjurada"])) {
                $tipoDeclaracionJurada = TiposDeclaracionesJuradasDao::buscaTipoDeclaracionJurada("array", $_POST["codigotipodeclaracionjurada"]);
                return json_encode($tipoDeclaracionJurada);
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionCrearTipoDeclaracionJuradaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $maximo = TiposDeclaracionesJuradasDao::maximoTiposDeclaracionesJuradas('DCJ');
            $maximo = $maximo + 1;
            $nuevoCodigo = 'DCJ';
            if ($maximo <= 99) {
                $nuevoCodigo = $nuevoCodigo . '0';
            }
            if ($maximo <= 9) {
                $nuevoCodigo = $nuevoCodigo . '0';
            }
            $nuevoCodigo = $nuevoCodigo . $maximo;
            $tipoDeclaracionJurada = new TipoDeclaracionJurada();
            $tipoDeclaracionJurada->CodigoTipoDeclaracionJurada = $nuevoCodigo;
            $tipoDeclaracionJurada->NombreTipoDeclaracionJurada = $_POST["nombretipodeclaracionjurada"];
            $tipoDeclaracionJurada->Frecuencia = $_POST["frecuencia"];
            $tipoDeclaracionJurada->CodigoEstado = 'V';
            $tipoDeclaracionJurada->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;
            if (!$tipoDeclaracionJurada->exist()) {
                $tipoDeclaracionJurada->save();
                return "ok";
            } else {
                return "existe";
            }
        } else {
            return "error";

        }
    }

    public function actionActualizarTipoDeclaracionJuradaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigotipodeclaracionjurada"])) {
                $tipoDeclaracionJurada = TipoDeclaracionJurada::findOne($_POST["codigotipodeclaracionjurada"]);
                $tipoDeclaracionJurada->NombreTipoDeclaracionJurada = $_POST["nombretipodeclaracionjurada"];
                $tipoDeclaracionJurada->Frecuencia = $_POST["frecuencia"];
                if (!$tipoDeclaracionJurada->exist()) {
                    $tipoDeclaracionJurada->save();
                    return "ok";
                } else {
                    return "existe";
                }
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionEliminarTipoDeclaracionJuradaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigotipodeclaracionjurada"])) {
                $tipoDeclaracionJurada = TipoDeclaracionJurada::findOne($_POST["codigotipodeclaracionjurada"]);
                if (!$tipoDeclaracionJurada->isUsed()) {
                    $tipoDeclaracionJurada->delete();
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

    public function actionIrTrabajadores($codigoTipoDeclaracionJurada)
    {
        $tipoDeclaracionJurada = TipoDeclaracionJurada::findOne($codigoTipoDeclaracionJurada);
        return $this->render('tipodeclaracionjuradatrabajadores', [
            'tipoDeclaracionJurada' => $tipoDeclaracionJurada,
        ]);
    }
}