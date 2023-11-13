<?php

namespace app\modules\Administracion\controllers;

use common\models\AcademicaCatalogosDao;
use app\modules\Administracion\models\PaisesDao;
use app\modules\Administracion\models\DepartamentosDao;
use app\modules\Administracion\models\Departamento;
use yii\web\Controller;

class DepartamentosController extends Controller
{    
    public function beforeAction($action)
    {
        if ($action->id == "listar-departamentos" || $action->id == "listar-departamentos-acad")
            $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $paises = PaisesDao::listaPaises();
        return $this->render('departamentos', [
            'paises' => $paises,
        ]);
    }

    public function actionListarDepartamentos()
    {
        /*if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $departamentos = DepartamentosDao::listaDepartamentos();
            $datosJson = '{"data": [';            
            foreach ($departamentos as $index => $departamento) {
                if ($departamento->CodigoEstado == 'V') {
                    $colorEstado = "btn-success";
                    $textoEstado = "VIGENTE";
                    $codigoEstado = 'V';
                } else {
                    $colorEstado = "btn-danger";
                    $textoEstado = "NO VIGENTE";
                    $codigoEstado = "C";
                }
                $acciones = "<div class='btn-group'>";
                $acciones .= "<button class='btn btn-danger btnEliminar' codigo-departamento='" . $departamento->CodigoDepartamento . "' nombre-departamento='" . $departamento->NombreDepartamento . "'><i class='fa fa-times'></i> Eliminar</button>";
                $acciones .= "</div>";
                $estado = "<button class='btn " . $colorEstado . " btn-xs btnEstado' codigo-departamento='" . $departamento->CodigoDepartamento . "' codigo-estado='" . $codigoEstado . "'>" . $textoEstado . "</button>";
                $datosJson .= '[
                    "' . ($index) . '",
                    "' . $departamento->NombrePais . '",
                    "' . $departamento->NombreDepartamento . '",
                    "' . $estado . '",
                     "' . $acciones . '"]';
                if ($index !== array_key_last($departamentos))
                    $datosJson .= ',';
            }
        } else {
            $datosJson = '{"data": [';
        }
        $datosJson .= ']}';
        return $datosJson;*/

        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $departamentos = DepartamentosDao::listaDepartamentos();
            $datosJson = '{"data": [';
            $cantidad = count($departamentos);
            for ($i = 0; $i < $cantidad; $i++) {
                /*=============================================
               REVISAR ESTADO
               =============================================*/
                if ($departamentos[$i]->CodigoEstado == 'V') {
                    $colorEstado = "btn-success";
                    $textoEstado = "VIGENTE";
                    $estadoDepartamento = "V";
                } else {
                    $colorEstado = "btn-danger";
                    $textoEstado = "NO VIGENTE";
                    $estadoDepartamento = "C";
                }
                $estado = "<button class='btn " . $colorEstado . " btn-xs btnActivarDepartamento' codigo-estado='" . $estadoDepartamento . "' codigo-departamento='" . $departamentos[$i]->CodigoDepartamento . "'>" . $textoEstado . "</button>";
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                $acciones = "<div class='btn-group'>";
                $acciones .= "<button class='btn btn-danger btnEliminarDepartamento' codigo-departamento='" . $departamentos[$i]->CodigoDepartamento . "' nombre-departamento='" . $departamentos[$i]->NombreDepartamento . "'><i class='fa fa-times'></i> Eliminar</button>";
                $acciones .= "</div>";
                $datosJson .= '[';
                $datosJson .= '"' . ($i + 1) . '",';
                $datosJson .= '"' . $departamentos[$i]->NombrePais . '",';
                $datosJson .= '"' . $departamentos[$i]->NombreDepartamento . '",';
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

    public function actionGuardarDepartamento()
    {
        /*if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoDepartamentoAcad"]) && isset($_POST["nombreDepartamentoAcad"]) && isset($_POST["codigoPaisAcad"]) && isset($_POST["codigoPais"])) {
                $departamento = new Departamento();
                $departamento->CodigoDepartamento = DepartamentosDao::generarCodigoDepartamento();
                $departamento->NombreDepartamento = $_POST["nombreDepartamentoAcad"];
                $departamento->CodigoPais = $_POST["codigoPais"];
                $departamento->CodigoPaisAcad = $_POST["codigoPaisAcad"];
                $departamento->CodigoDepartamentoAcad = $_POST["codigoDepartamentoAcad"];
                $departamento->CodigoEstado = 'V';
                if ($departamento->validate()) {
                    if (!$departamento->existe()) {
                        if ($departamento->save()) {
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
        }        */

        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $maximo = DepartamentosDao::generarCodigoDepartamento();
            $nuevoCodigo = $maximo + 1;
            $departamento = new Departamento();
            $departamento->CodigoDepartamento = $nuevoCodigo;
            $departamento->NombreDepartamento = $_POST["nombredepartamentoacad"];
            $departamento->CodigoPais = $_POST["codigopais"];
            $departamento->CodigoPaisAcad = $_POST["codigopaisacad"];
            $departamento->CodigoDepartamentoAcad = $_POST["codigodepartamentoacad"];
            $departamento->CodigoEstado = 'V';
            if (!$departamento->existe()) {
                $departamento->save();
                return "ok";
            } else {
                return "existe";
            }
        } else {
            return "error";
        }
    }

    public function actionCambiarEstadoDepartamento()
    {
        /*if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoDepartamento"]) && $_POST["codigoDepartamento"] != "") {
                $departamento = Departamento::findOne($_POST["codigoDepartamento"]);
                if ($departamento->CodigoEstado == "V") {
                    $departamento->CodigoEstado = "C";
                } else {
                    $departamento->CodigoEstado = "V";
                }
                $departamento->save();
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }*/

        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigodepartamento"]) && $_POST["codigodepartamento"] != "") {
                $departamento = Departamento::findOne($_POST["codigodepartamento"]);
                if ($departamento->CodigoEstado == "V") {
                    $departamento->CodigoEstado = "C";
                } else {
                    $departamento->CodigoEstado = "V";
                }
                $departamento->save();
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }    

    public function actionEliminarDepartamento()
    {
        /*if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoDepartamento"]) && $_POST["codigoDepartamento"] != "") {
                $departamento = Departamento::findOne($_POST["codigoDepartamento"]);
                if ($departamento) {
                    if (!$departamento->enUso()) {
                        if ($departamento->delete()) {
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
            if (isset($_POST["codigodepartamento"]) && $_POST["codigodepartamento"] != "") {
                $departamento = Departamento::findOne($_POST["codigodepartamento"]);
                if (!$departamento->enUso()) {
                    $departamento->delete();
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

    public function actionListarDepartamentosAcad()
    {
        /*if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $codigoPaisAcad = $_POST["codigoPaisAcad"];
            $departamentos = AcademicaCatalogosDao::listaDepartamentosPaisAcad($codigoPaisAcad);
            $datosJson = '{"data": [';
            foreach ($departamentos as $index => $departamento) {
                $acciones = "<center><button class='btn btn-primary btnElegir' codigo-departamento-acad='" . $departamento->CodigoDepartamento . "' nombre-departamento-acad='" . $departamento->NombreDepartamento . "' codigo-pais-acad='" . $departamento->CodigoPais . "'>Seleccionar</button></center>";
                $datosJson .= '[
                    "' . ($index) . '",
                    "' . $departamento->CodigoDepartamento . '",
                    "' . $departamento->NombreDepartamento . '",                    
                     "' . $acciones . '"]';
                if ($index !== array_key_last($departamentos))
                    $datosJson .= ',';
            }
        } else {
            $datosJson = '{"data": [';
        }
        $datosJson .= ']}';
        return $datosJson;*/

        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $codigoPaisAcad = $_POST["codigopaisacad"];
            $departamentosAcad = AcademicaCatalogosDao::listaDepartamentosPaisAcad($codigoPaisAcad);
            $datosJson = '{"data": [';
            $cantidad = count($departamentosAcad);
            for ($i = 0; $i < $cantidad; $i++) {
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                $acciones = "<center><button class='btn btn-primary btnElegir' codigo-departamento-acad='" . $departamentosAcad[$i]->CodigoDepartamento . "' nombre-departamento-acad='" . $departamentosAcad[$i]->NombreDepartamento . "' codigo-pais-acad='" . $departamentosAcad[$i]->CodigoPais . "'>Seleccionar</button></center>";
                if ($i == $cantidad - 1) {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $departamentosAcad[$i]->CodigoDepartamento . '",
					 	"' . strtoupper($departamentosAcad[$i]->NombreDepartamento) . '",				 	 	
				      	"' . $acciones . '"
  			  ]';
                } else {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $departamentosAcad[$i]->CodigoDepartamento . '",
					 	"' . strtoupper($departamentosAcad[$i]->NombreDepartamento) . '",				 	 	
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
}