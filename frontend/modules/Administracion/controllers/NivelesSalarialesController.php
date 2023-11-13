<?php

namespace app\modules\Administracion\controllers;

use app\modules\Administracion\models\NivelesSalarialesDao;
use app\modules\Administracion\models\NivelSalarial;
use app\modules\Administracion\models\SectorTrabajo;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use Yii;

class NivelesSalarialesController extends Controller
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
        if ($action->id == "listar-niveles-salariales-ajax")
            $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $listaSectoresTrabajo = ArrayHelper::map(SectorTrabajo::find()->orderBy('NombreSectorTrabajo')->all(), 'CodigoSectorTrabajo', 'NombreSectorTrabajo');
        return $this->render('nivelessalariales', [
            'sectoresTrabajo' => $listaSectoresTrabajo,
        ]);
    }

    public function actionListarNivelesSalarialesAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $nivelesSalariales = NivelSalarial::find()->orderBy('CodigoNivelSalarial')->all();
            $datosJson = '{"data": [';
            $cantidad = count($nivelesSalariales);
            for ($i = 0; $i < $cantidad; $i++) {
                /*=============================================
               REVISAR ESTADO
               =============================================*/
                if ($nivelesSalariales[$i]->CodigoEstado == 'V') {
                    $colorEstado = "btn-success";
                    $textoEstado = "VIGENTE";
                    $estadoNivel = "V";
                } else {
                    $colorEstado = "btn-danger";
                    $textoEstado = "NO VIGENTE";
                    $estadoNivel = "C";
                }
                $estado = "<button class='btn " . $colorEstado . " btn-xs btnActivarNivelSalarial' estado='" . $estadoNivel . "' codigo='" . $nivelesSalariales[$i]->CodigoNivelSalarial . "'>" . $textoEstado . "</button>";
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                $acciones = "<div class='btn-group'>";
                $acciones .= "<button class='btn btn-warning btnEditarNivelSalarial' codigo='" . $nivelesSalariales[$i]->CodigoNivelSalarial . "' data-toggle='modal' data-target='#modalActualizarNivelSalarial'><i class='fa fa-pen'></i></button>";
                $acciones .= "<button class='btn btn-danger btnEliminarNivelSalarial' codigo='" . $nivelesSalariales[$i]->CodigoNivelSalarial . "' nombre='" . $nivelesSalariales[$i]->NombreNivelSalarial . "'><i class='fa fa-times'></i></button>";
                $acciones .= "</div>";
                if ($i == $cantidad - 1) {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $nivelesSalariales[$i]->CodigoNivelSalarial . '",
					 	"' . $nivelesSalariales[$i]->NombreNivelSalarial . '",
					 	"' . $nivelesSalariales[$i]->DescripcionNivelSalarial . '",
					 	"' . $nivelesSalariales[$i]->HaberBasico . '",
					 	"' . $nivelesSalariales[$i]->sectorTrabajo->NombreSectorTrabajo . '",
					 	"' . $nivelesSalariales[$i]->PuntosEscalafon . '",
				 	 	"' . $estado . '",				      	
				      	"' . $acciones . '"
  			  ]';
                } else {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $nivelesSalariales[$i]->CodigoNivelSalarial . '",
					 	"' . $nivelesSalariales[$i]->NombreNivelSalarial . '",
					 	"' . $nivelesSalariales[$i]->DescripcionNivelSalarial . '",
					 	"' . $nivelesSalariales[$i]->HaberBasico . '",
					 	"' . $nivelesSalariales[$i]->sectorTrabajo->NombreSectorTrabajo . '",
					 	"' . $nivelesSalariales[$i]->PuntosEscalafon . '",
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

    public function actionCrearNivelSalarialAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $maximo = NivelesSalarialesDao::maximoNivelesSalariales();
            $nuevoCodigo = $maximo + 1;
            $nivelSalarial = new NivelSalarial();
            $nivelSalarial->CodigoNivelSalarial = $nuevoCodigo;
            $nivelSalarial->NombreNivelSalarial = $_POST["nombrenivelsalarial"];
            $nivelSalarial->DescripcionNivelSalarial = $_POST["descripcionnivelsalarial"];
            $nivelSalarial->HaberBasico = $_POST["haberbasico"];
            $nivelSalarial->PuntosEscalafon = $_POST["puntosescalafon"];
            $nivelSalarial->CodigoSectorTrabajo = $_POST["codigosectortrabajo"];
            $nivelSalarial->CodigoEstado = 'V';
            $nivelSalarial->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;
            if (!$nivelSalarial->exist()) {
                $nivelSalarial->save();
                return "ok";
            } else {
                return "existe";
            }
        } else {
            return "error";
        }
    }

    public function actionActivarNivelSalarialAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigonivelsalarial"])) {
                $nivelSalarial = NivelSalarial::findOne($_POST["codigonivelsalarial"]);
                if ($nivelSalarial->CodigoEstado == "V") {
                    $nivelSalarial->CodigoEstado = "C";
                } else {
                    $nivelSalarial->CodigoEstado = "V";
                }
                $nivelSalarial->save();
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionBuscarNivelSalarialAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigonivelsalarial"])) {
                $nivelSalarial = NivelesSalarialesDao::buscaNivelSalarial("array",$_POST["codigonivelsalarial"]);
                return json_encode($nivelSalarial);
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionActualizarNivelSalarialAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigonivelsalarial"])) {
                $nivelSalarial = NivelSalarial::findOne($_POST["codigonivelsalarial"]);
                $nivelSalarial->NombreNivelSalarial = $_POST["nombrenivelsalarial"];
                $nivelSalarial->DescripcionNivelSalarial = $_POST["descripcionnivelsalarial"];
                $nivelSalarial->HaberBasico = $_POST["haberbasico"];
                $nivelSalarial->PuntosEscalafon = $_POST["puntosescalafon"];
                $nivelSalarial->CodigoSectorTrabajo = $_POST["codigosectortrabajo"];
                if (!$nivelSalarial->exist()) {
                    $nivelSalarial->save();
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

    public function actionEliminarNivelSalarialAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigonivelsalarial"])) {
                $nivelSalarial = NivelSalarial::findOne($_POST["codigonivelsalarial"]);
                if (!$nivelSalarial->isUsed()) {
                    $nivelSalarial->delete();
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
}