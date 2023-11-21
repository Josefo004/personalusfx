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

            $datosJson = '{"data": [';
            $cantidad = count($aportes);
            for ($i = 0; $i < $cantidad; $i++) {

                $colorEstado = $aportes[$i]->CodigoEstado == 'V' ? "btn-success" : "btn-danger";
                $textoEstado = $aportes[$i]->NombreEstado;
                $estadoAporte = $aportes[$i]->CodigoEstado;
                $estado = "<button class='btn " . $colorEstado . " btn-xs btnActivar' estado='" . $estadoAporte . "' codigo='" . $aportes[$i]->CodigoAporteLey . "'>" . $textoEstado . "</button>";
                $acciones = "<button class='btn btn-warning btn-sm btnEditarAporte' codigo='" . $aportes[$i]->CodigoAporteLey . "' data-toggle='modal' data-target='#modalActualizarAporte'><i class='fa fa-pen'></i> Editar</button>";
                if ($i == $cantidad - 1) {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $aportes[$i]->NombreAporteLey . '",
                        "' . $aportes[$i]->TipoAporte . '",
                        "' . $aportes[$i]->Porcentaje . ' % ",
                        "' . $estado . '",				      	
                        "' . $acciones . '"
  			    ]';
                } else {
                    $datosJson .= '[
                        "' . ($i + 1) . '",
					 	"' . $aportes[$i]->NombreAporteLey . '",
                        "' . $aportes[$i]->TipoAporte . '",
                        "' . $aportes[$i]->Porcentaje . ' %",
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
                    $aporte->CodigoEstado = "C";
                } else {
                    $aporte->CodigoEstado = "V";
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
                    $aportes = Aporte::find()->count();
                    $aporte->CodigoAporteLey = $aportes+1;
                    $aporte->CodigoUsuario = "LNN";
                } else {
                    $aporte = Aporte::findOne($_POST["codigoAporteLeyactualizar"]);
                }
                $aporte->NombreAporteLey = strtoupper($_POST["nombreAporteLeyactualizar"]);
                $aporte->TipoAporte = $_POST["tipoAporteactualizar"];
                $aporte->Porcentaje = $_POST["porcentajeactualizar"];
                $aporte->MontoSalario = $_POST["montoSalarioactualizar"];
                $aporte->Observaciones = strtoupper($_POST["observacionesactualizar"]);
                $aporte->CodigoEstado = $_POST["codigoEstadoactualizar"];
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
