<?php

namespace app\modules\Planillas\controllers;

use yii\web\Controller;
use app\modules\Planillas\models\AportesDao;
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
                $estadoPersona = $aportes[$i]->CodigoEstado;
                $estado = "<button class='btn " . $colorEstado . " btn-xs btnActivar' estado='" . $estadoPersona . "' codigo='" . $aportes[$i]->CodigoAporteLey . "'>" . $textoEstado . "</button>";

                if ($i == $cantidad - 1) {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $aportes[$i]->NombreAporteLey . '",
                        "' . $aportes[$i]->TipoAporte . '",
                        "' . $aportes[$i]->Porcentaje . ' % ",
                        "' . $estado . '",  
                        ""
  			    ]';
                } else {
                    $datosJson .= '[
                        "' . ($i + 1) . '",
					 	"' . $aportes[$i]->NombreAporteLey . '",
                        "' . $aportes[$i]->TipoAporte . '",
                        "' . $aportes[$i]->Porcentaje . ' %",
                        "' . $estado . '",  
                        ""
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

}
