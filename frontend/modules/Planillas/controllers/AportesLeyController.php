<?php

namespace app\modules\Planillas\controllers;

use yii\web\Controller;
use app\modules\Planillas\models\AportesDao;
use app\modules\Planillas\models\Aporte;
use Yii;

class AportesLeyController extends Controller {
    public function actionIndex(){
        return $this->render('aportesley');
    }

    public function actionListarAportes(){
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {

            $aportes = AportesDao::listarAportes();
            //$datosJson = json_encode($aportes);

            $datosJson = '{"data": [';
            $cantidad = count($aportes);
            for ($i = 0; $i < $cantidad; $i++) {

                $colorEstado = $aportes[$i]->codigoEstado == 'V' ? "btn-success" : "btn-danger";
                $textoEstado = $aportes[$i]->NombreEstado;
                $estadoAporte = $aportes[$i]->codigoEstado;
                $estado = "<button class='btn " . $colorEstado . " btn-xs btnActivar' estado='" . $estadoAporte . "' codigo='" . $aportes[$i]->codigoAporteLey . "'>" . $textoEstado . "</button>";
                $acciones = "<button class='btn btn-warning btn-sm btnEditarAporte' codigo='" . $aportes[$i]->codigoAporteLey . "' data-toggle='modal' data-target='#modalActualizarAporte'><i class='fa fa-pen'></i> Editar</button>";
                if ($i == $cantidad - 1) {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $aportes[$i]->nombreAporteLey . '",
                        "' . $aportes[$i]->tipoAporte . '",
                        "' . $aportes[$i]->porcentaje . ' % ",
                        "' . $aportes[$i]->fechaInicio . '",
                        "' . $aportes[$i]->fechaFin . '",
                        "' . $estado . '",				      	
                        "' . $acciones . '"
  			    ]';
                } else {
                    $datosJson .= '[
                        "' . ($i + 1) . '",
                        "' . $aportes[$i]->nombreAporteLey . '",
                        "' . $aportes[$i]->tipoAporte . '",
                        "' . $aportes[$i]->porcentaje . ' % ",
                        "' . $aportes[$i]->fechaInicio . '",
                        "' . $aportes[$i]->fechaFin . '",
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

    public function actionActivarAporte()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoactivar"]) && isset($_POST["estadoactivar"])) {
                $aporte = Aporte::findOne($_POST["codigoactivar"]);
                if ($_POST["estadoactivar"] == "V") {
                    $aporte->codigoEstado = "C";
                } else {
                    $aporte->codigoEstado = "V";
                }
                $aporte->save();
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionBuscarAporte()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoeditar"])) {
                $aporte = Aporte::find()->where(['CodigoAporteLey'=>$_POST["codigoeditar"]])->asArray()->one();
                return json_encode($aporte);
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionActualizarAporte()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoAporteLeyactualizar"])) {
                $cod = $_POST["codigoAporteLeyactualizar"];
                if ($cod==0) {
                    $aporte = new Aporte();
                    // $aportes = Aporte::find()->count();
                    // $aporte->CodigoAporteLey = $aportes+1;
                } else {
                    $aporte = Aporte::findOne($_POST["codigoAporteLeyactualizar"]);
                }
                $aporte->nombreAporteLey = strtoupper($_POST["nombreAporteLeyactualizar"]);
                $aporte->tipoAporte = $_POST["tipoAporteactualizar"];
                $aporte->porcentaje = $_POST["porcentajeactualizar"];
                $aporte->montoSalario = $_POST["montoSalarioactualizar"];
                $aporte->observaciones = strtoupper($_POST["observacionesactualizar"]);
                $aporte->fechaInicio = $_POST["fechaInicioactualizar"];
                $aporte->fechaFin = $_POST["fechaFinactualizar"];
                $aporte->codigoEstado = $_POST["codigoEstadoactualizar"];
                $aporte->codigoUsuario = Yii::$app->user->identity->CodigoUsuario;
                $aporte->save();
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

}
