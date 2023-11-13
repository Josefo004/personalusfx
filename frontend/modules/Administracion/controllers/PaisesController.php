<?php

namespace app\modules\Administracion\controllers;

use common\models\AcademicaCatalogosDao;
use app\modules\Administracion\models\PaisesDao;
use app\modules\Administracion\models\Pais;
use yii\web\Controller;

class PaisesController extends Controller
{
    public function beforeAction($action)
    {
        if ($action->id == "listar-paises" || $action->id == "listar-paises-acad")
            $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('paises');
    }

    public function actionListarPaises()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $paises = PaisesDao::listaPaises();
            $datosJson = '{"data": [';
            $cantidad = count($paises);
            for ($i = 0; $i < $cantidad; $i++) {
                /*=============================================
               REVISAR ESTADO
               =============================================*/
                if ($paises[$i]->CodigoEstado == 'V') {
                    $colorEstado = "btn-success";
                    $textoEstado = "VIGENTE";
                    $estadoPais = "V";
                } else {
                    $colorEstado = "btn-danger";
                    $textoEstado = "NO VIGENTE";
                    $estadoPais = "C";
                }
                $estado = "<button class='btn " . $colorEstado . " btn-xs btnActivarPais' codigo-estado='" . $estadoPais . "' codigo-pais='" . $paises[$i]->CodigoPais . "'>" . $textoEstado . "</button>";
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                $acciones = "<div class='btn-group'>";
                $acciones .= "<button class='btn btn-danger btnEliminarPais' codigo-pais='" . $paises[$i]->CodigoPais . "' nombre-pais='" . $paises[$i]->NombrePais . "'><i class='fa fa-times'></i> Eliminar</button>";
                $acciones .= "</div>";
                $datosJson .= '[';
                $datosJson .= '"' . ($i + 1) . '",';
                $datosJson .= '"' . $paises[$i]->NombrePais . '",';
                $datosJson .= '"' . $paises[$i]->Nacionalidad . '",';
                $datosJson .= '"' . $estado . '",';
                $datosJson .= '"' . $acciones . '"';
                if ($i == $cantidad - 1) {
                    $datosJson .= ']';
                } else {
                    $datosJson .= '],';
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

    public function actionGuardarPais()
    {
        /*if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoPaisAcad"]) && isset($_POST["nombrePaisAcad"]) && isset($_POST["nacionalidadAcad"])) {
                $pais = new Pais();
                $pais->CodigoPais = PaisesDao::generarCodigoPais();
                $pais->NombrePais = $_POST["nombrePaisAcad"];
                $pais->Nacionalidad = $_POST["nacionalidadAcad"];
                $pais->CodigoPaisAcad = $_POST["codigoPaisAcad"];
                $pais->CodigoEstado = 'V';
                if ($pais->validate()) {
                    if (!$pais->existe()) {
                        if ($pais->save()) {
                            return "ok";
                        } else {
                            return "errorSql";
                        }
                    } else {
                        return "errorExiste";
                    }
                } else {
                    return "errorValidacion";
                }
            } else {
                return 'errorEnvio';
            }
        } else {
            return "errorCabecera";
        }*/
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $maximo = PaisesDao::generarCodigoPais();
            $nuevoCodigo = $maximo + 1;
            $pais = new Pais();
            $pais->CodigoPais = $nuevoCodigo;
            $pais->NombrePais = $_POST["nombrepaisacad"];
            $pais->Nacionalidad = $_POST["nacionalidadacad"];
            $pais->CodigoPaisAcad = $_POST["codigopaisacad"];
            $pais->CodigoEstado = 'V';
            //$pais->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;
            if (!$pais->existe()) {
                $pais->save();
                return "ok";
            } else {
                return "existe";
            }
        } else {
            return "error";
        }
    }

    public function actionCambiarEstadoPais()
    {
        /*if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoPais"]) && $_POST["codigoPais"] != "") {
                $pais = Pais::findOne($_POST["codigoPais"]);
                if ($pais) {
                    if ($pais->CodigoEstado == "V") {
                        $pais->CodigoEstado = "C";
                    } else {
                        $pais->CodigoEstado = "V";
                    }
                    if ($pais->update()) {
                        return "ok";
                    } else {
                        return "errorSql";
                    }
                } else {
                    return 'errorNoEncontrado';
                }
            } else {
                return "errorEnvio";
            }
        } else {
            return "errorCabecera";
        }*/
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigopais"]) && $_POST["codigopais"] != "") {
                $pais = Pais::findOne($_POST["codigopais"]);
                if ($pais->CodigoEstado == "V") {
                    $pais->CodigoEstado = "C";
                } else {
                    $pais->CodigoEstado = "V";
                }
                $pais->save();
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionEliminarPais()
    {
        /*if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoPais"]) && $_POST["codigoPais"] != "") {
                $pais = Pais::findOne($_POST["codigoPais"]);
                if ($pais) {
                    if (!$pais->enUso()) {
                        if ($pais->delete()) {
                            return "ok";
                        } else {
                            return "errorSql";
                        }
                    } else {
                        return "errorEnUso";
                    }
                } else {
                    return 'errorNoEncontrado';
                }
            } else {
                return "errorEnvio";
            }
        } else {
            return "errorCabecera";
        }*/
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigopais"]) && $_POST["codigopais"] != "") {
                $pais = Pais::findOne($_POST["codigopais"]);
                if (!$pais->enUso()) {
                    $pais->delete();
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

    public function actionListarPaisesAcad()
    {
        /*if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $paises = AcademicaCatalogosDao::listaPaisesAcad();
            $datosJson = '{"data": [';
            foreach ($paises as $index => $pais) {
                $acciones = "<center><button class='btn btn-primary btnElegir' codigo-pais-acad='" . $pais->CodigoPais . "' nombre-pais-acad='" . $pais->NombrePais . "' nacionalidad-acad='" . $pais->Nacionalidad . "'>Seleccionar</button></center>";
                $datosJson .= '[
                    "' . ($index) . '",
                    "' . $pais->CodigoPais . '",
                    "' . $pais->NombrePais . '",
                    "' . $pais->Nacionalidad . '",
                     "' . $acciones . '"]';
                if ($index !== array_key_last($paises))
                    $datosJson .= ',';
            }
        } else {
            $datosJson = '{"data": [';
        }
        $datosJson .= ']}';
        return $datosJson;*/
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $paises = AcademicaCatalogosDao::listaPaisesAcad();
            $datosJson = '{"data": [';
            $cantidad = count($paises);
            for ($i = 0; $i < $cantidad; $i++) {
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                $acciones = "<center><button class='btn btn-primary btnElegir' codigo-pais-acad='" . $paises[$i]->CodigoPais . "' nombre-pais-acad='" . $paises[$i]->NombrePais . "' nacionalidad-acad='" . $paises[$i]->Nacionalidad . "'>Seleccionar</button></center>";
                $datosJson .= '[';
                $datosJson .= '"' . ($i + 1) . '",';
                $datosJson .= '"' . $paises[$i]->CodigoPais . '",';
                $datosJson .= '"' . $paises[$i]->NombrePais . '",';
                $datosJson .= '"' . $paises[$i]->Nacionalidad . '",';
                $datosJson .= '"' . $acciones . '"';
                if ($i == $cantidad - 1) {
                    $datosJson .= ']';
                } else {
                    $datosJson .= '],';
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
