<?php

namespace app\modules\CargaHoraria\controllers;
use yii\web\Controller;
use common\models\TipoInasistencia;
use app\modules\CargaHoraria\models\TiposInasistenciaDao;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class TiposInasistenciaController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['listar-tipos-inasistencia-ajax', 'index'],
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => [
                            'listar-tipos-inasistencia-ajax',
                            'index',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    public function beforeAction($action)
    {
        if ($action->id == "listar-tipos-inasistencia-ajax")
            $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionListarTiposInasistenciaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $tipoInasistencia = TipoInasistencia::find()->orderBy('CodigoTipoInasistencia')->all();
            $datosJson = '{"data": [';
            $cantidad = count($tipoInasistencia);
            for ($i = 0; $i < $cantidad; $i++) {
                /*=============================================
               REVISAR ESTADO
               =============================================*/
                if ($tipoInasistencia[$i]->CodigoEstado == 'V') {
                    $colorEstado = "btn-success";
                    $textoEstado = "VIGENTE";
                    $estadoTipoInasistencia = "V";
                } else {
                    $colorEstado = "btn-danger";
                    $textoEstado = "NO VIGENTE";
                    $estadoTipoInasistencia = "C";
                }
                $estado = "<button class='btn " . $colorEstado . " btn-xs btnActivarTipoInasistencia' estado='" . $estadoTipoInasistencia . "' codigo='" . $tipoInasistencia[$i]->CodigoTipoInasistencia . "'>" . $textoEstado . "</button>";
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                $acciones = "<div class='btn-group'>";
                $acciones .= "<button class='btn btn-warning btnEditarTipoInasistencia' codigo='" . $tipoInasistencia[$i]->CodigoTipoInasistencia . "' data-toggle='modal' data-target='#modalActualizarTipoInasistencia'><i class='fa fa-pen'></i></button>";
                $acciones .= "<button class='btn btn-danger btnEliminarTipoInasistencia' codigo='" . $tipoInasistencia[$i]->CodigoTipoInasistencia . "' nombre='" . $tipoInasistencia[$i]->Descripcion . "'><i class='fa fa-times'></i></button>";
                $acciones .= "</div>";
                if ($i == $cantidad - 1) {
                    $datosJson .= '[
                  "' . ($i + 1) . '",
                  "' . $tipoInasistencia[$i]->CodigoTipoInasistencia . '",
                  "' . $tipoInasistencia[$i]->NombreTipoInasistencia . '",
                  "' . $tipoInasistencia[$i]->Descripcion . '",
                  "' . $tipoInasistencia[$i]->Sancion . '",
                  "' . $estado . '",                 
                  "' . $acciones . '"
           ]';
                } else {
                    $datosJson .= '[
                  "' . ($i + 1) . '",
                  "' . $tipoInasistencia[$i]->CodigoTipoInasistencia . '",
                  "' . $tipoInasistencia[$i]->NombreTipoInasistencia . '",
                  "' . $tipoInasistencia[$i]->Descripcion . '",
                  "' . $tipoInasistencia[$i]->Sancion . '",
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
   public function actionCrearTipoInasistenciaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $maximo = TiposInasistenciaDao::maximoTiposInasistencia();
            $nuevoCodigo = $maximo + 1;
            $tipoInasistencia = new TipoInasistencia();
            $tipoInasistencia->CodigoTipoInasistencia = $nuevoCodigo;
            $tipoInasistencia->NombreTipoInasistencia = $_POST["nombretipoinasistencia"];
            $tipoInasistencia->Descripcion= $_POST["descripcion"];
            $tipoInasistencia->Sancion = $_POST["sancion"];
            $tipoInasistencia->CodigoEstado = 'V';
            $tipoInasistencia->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;
            if (!$tipoInasistencia->exist()) {
                $tipoInasistencia->save();
                return "ok";
            } else {
                return "existe";
            }
        } else {
            return "error";
        }
    }
    public function actionActivarTipoInasistenciaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigotipoinasistencia"])) {
                $tipoInasistencia = TipoInasistencia::findOne($_POST["codigotipoinasistencia"]);
                if ($tipoInasistencia->CodigoEstado == "V") {
                    $tipoInasistencia->CodigoEstado = "C";
                } else {
                    $tipoInasistencia->CodigoEstado = "V";
                }
                $tipoInasistencia->save();
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }
    public function actionBuscarTipoInasistenciaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigotipoinasistencia"])) {
                $tipoInasistencia = TiposInasistenciaDao::buscaTipoInasistencia("array", $_POST["codigotipoinasistencia"]);
                return json_encode($tipoInasistencia);
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }
    public function actionActualizarTipoInasistenciaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigotipoinasistencia"])) {
                $tipoInasistencia = TipoInasistencia::findOne($_POST["codigotipoinasistencia"]);
                $tipoInasistencia->NombreTipoInasistencia= $_POST["nombretipoinasistencia"];
                $tipoInasistencia->Descripcion= $_POST["descripcion"];
                $tipoInasistencia->Sancion = $_POST["sancion"];
                if (!$tipoInasistencia->exist()) {
                    $tipoInasistencia->save();
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
    public function actionEliminarTipoInasistenciaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigotipoinasistencia"])) {
                $tipoInasistencia = TipoInasistencia::findOne($_POST["codigotipoinasistencia"]);
                if ($tipoInasistencia->delete()) {
                         return "ok";
                }
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }
}