<?php

namespace app\modules\Administracion\controllers;

use app\modules\Administracion\models\Departamento;
use common\models\AcademicaCatalogosDao;
use app\modules\Administracion\models\PaisesDao;
use app\modules\Administracion\models\DepartamentosDao;
use app\modules\Administracion\models\ProvinciasDao;
use app\modules\Administracion\models\Provincia;
use yii\web\Controller;

class ProvinciasController extends Controller
{
    public function beforeAction($action)
    {
        if ($action->id == "listar-provincias" || $action->id == "listar-provincias-acad")
            $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {        
        $listaPaises = PaisesDao::listaPaises();        
        $listaDepartamentos = DepartamentosDao::listaDepartamentos();
        return $this->render('provincias', [
            'departamentos' => $listaDepartamentos,
            'paises' => $listaPaises,
        ]);
    }

    public function actionListarProvincias()
    {
        /*if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $provincias = ProvinciasDao::listaProvincias();
            $datosJson = '{"data": [';            
            foreach ($provincias as $index => $provincia) {
                if ($provincia->CodigoEstado == 'V') {
                    $colorEstado = "btn-success";
                    $textoEstado = "VIGENTE";
                    $codigoEstado = 'V';
                } else {
                    $colorEstado = "btn-danger";
                    $textoEstado = "NO VIGENTE";
                    $codigoEstado = "C";
                }
                $acciones = "<div class='btn-group'>";
                $acciones .= "<button class='btn btn-danger btnEliminar' codigo-provincia='" . $provincia->CodigoProvincia . "' nombre-provincia='" . $provincia->NombreProvincia . "'><i class='fa fa-times'></i> Eliminar</button>";
                $acciones .= "</div>";
                $estado = "<button class='btn " . $colorEstado . " btn-xs btnEstado' codigo-provincia='" . $provincia->CodigoProvincia . "' codigo-estado='" . $codigoEstado . "'>" . $textoEstado . "</button>";
                $datosJson .= '[
                    "' . ($index) . '",
                    "' . $provincia->NombrePais . '",
                    "' . $provincia->NombreDepartamento . '",
                    "' . $provincia->NombreProvincia . '",
                    "' . $estado . '",
                     "' . $acciones . '"]';
                if ($index !== array_key_last($provincias))
                    $datosJson .= ',';
            }
        } else {
            $datosJson = '{"data": [';
        }
        $datosJson .= ']}';
        return $datosJson;      */

        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $provincias = ProvinciasDao::listaProvincias();
            $datosJson = '{"data": [';
            $cantidad = count($provincias);
            for ($i = 0; $i < $cantidad; $i++) {
                /*=============================================
               REVISAR ESTADO
               =============================================*/
                if ($provincias[$i]->CodigoEstado == 'V') {
                    $colorEstado = "btn-success";
                    $textoEstado = "VIGENTE";
                    $estadoProvincia = "V";
                } else {
                    $colorEstado = "btn-danger";
                    $textoEstado = "NO VIGENTE";
                    $estadoProvincia = "C";
                }
                $estado = "<button class='btn " . $colorEstado . " btn-xs btnActivarProvincia' codigo-estado='" . $estadoProvincia . "' codigo-provincia='" . $provincias[$i]->CodigoProvincia . "'>" . $textoEstado . "</button>";
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                $acciones = "<div class='btn-group'>";
                $acciones .= "<button class='btn btn-danger btnEliminarProvincia' codigo-provincia='" . $provincias[$i]->CodigoProvincia . "' nombre-provincia='" . $provincias[$i]->NombreProvincia . "'><i class='fa fa-times'></i> Eliminar</button>";
                $acciones .= "</div>";
                $datosJson .= '[';
                $datosJson .= '"' . ($i + 1) . '",';
                $datosJson .= '"' . $provincias[$i]->NombrePais . '",';
                $datosJson .= '"' . $provincias[$i]->NombreDepartamento . '",';
                $datosJson .= '"' . $provincias[$i]->NombreProvincia . '",';
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

    public function actionGuardarProvincia()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $maximo = ProvinciasDao::generarCodigoProvincia();
            $nuevoCodigo = $maximo + 1;
            $provincia = new Provincia();
            $provincia->CodigoProvincia = $nuevoCodigo;
            $provincia->NombreProvincia = $_POST["nombreprovinciaacad"];
            $provincia->CodigoDepartamento = $_POST["codigodepartamento"];
            $provincia->CodigoPaisAcad = $_POST["codigopaisacad"];
            $provincia->CodigoDepartamentoAcad = $_POST["codigodepartamentoacad"];
            $provincia->CodigoProvinciaAcad = $_POST["codigoprovinciaacad"];
            $provincia->CodigoEstado = 'V';
            //$pais->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;
            if (!$provincia->exist()) {
                $provincia->save();
                return "ok";
            } else {
                return "existe";
            }
        } else {
            return "error";
        }
    }

    public function actionCambiarEstadoProvincia()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoprovincia"]) && $_POST["codigoprovincia"] != "") {
                $provincia = Provincia::findOne($_POST["codigoprovincia"]);
                if ($provincia->CodigoEstado == "V") {
                    $provincia->CodigoEstado = "C";
                } else {
                    $provincia->CodigoEstado = "V";
                }
                $provincia->save();
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionEliminarProvincia()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoprovincia"]) && $_POST["codigoprovincia"] != "") {
                $provincia = Provincia::findOne($_POST["codigoprovincia"]);
                if (!$provincia->enUso()) {
                    $provincia->delete();
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

    public function actionListarProvinciasAcad()
    {
        /*if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $codigoDepartamentoAcad = $_POST["codigoDepartamentoAcad"];
            $provincias = AcademicaCatalogosDao::listaProvinciasDepartamentoAcad($codigoDepartamentoAcad);
            $datosJson = '{"data": [';
            foreach ($provincias as $index => $provincia) {
                $acciones = "<center><button class='btn btn-primary btnElegir' codigo-provincia-acad='" . $provincia->CodigoProvincia . "' nombre-provincia-acad='" . $provincia->NombreProvincia . "' codigo-departamento-acad='" . $provincia->CodigoDepartamento . "'>Seleccionar</button></center>";
                $datosJson .= '[
                    "' . ($index) . '",
                    "' . $provincia->CodigoProvincia . '",
                    "' . $provincia->NombreProvincia . '",
                     "' . $acciones . '"]';
                if ($index !== array_key_last($provincias))
                    $datosJson .= ',';
            }
        } else {
            $datosJson = '{"data": [';
        }
        $datosJson .= ']}';
        return $datosJson;    */

        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $codigoDepartamentoAcad = $_POST["codigodepartamentoacad"];
            $provinciasAcad = AcademicaCatalogosDao::listaProvinciasDepartamentoAcad($codigoDepartamentoAcad);
            $datosJson = '{"data": [';
            $cantidad = count($provinciasAcad);
            for ($i = 0; $i < $cantidad; $i++) {
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                $acciones = "<center><button class='btn btn-primary btnElegir' codigo-provincia-acad='" . $provinciasAcad[$i]->CodigoProvincia . "' nombre-provincia-acad='" . $provinciasAcad[$i]->NombreProvincia . "' codigo-pais-acad='" . $provinciasAcad[$i]->CodigoPais . "' codigo-departamento-acad='" . $provinciasAcad[$i]->CodigoDepartamento . "'>Seleccionar</button></center>";
                if ($i == $cantidad - 1) {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $provinciasAcad[$i]->CodigoProvincia . '",
					 	"' . strtoupper($provinciasAcad[$i]->NombreProvincia) . '",				 	 	
				      	"' . $acciones . '"
  			  ]';
                } else {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $provinciasAcad[$i]->CodigoProvincia . '",
					 	"' . strtoupper($provinciasAcad[$i]->NombreProvincia) . '",				 	 	
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

    public function actionListarDepartamentos()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $opciones = "<option value=''>Selecionar Departamento</option>";
            $codigoPais = $_POST["codigopais"];
            $departamentos = Departamento::find()->where(["CodigoPais" => $codigoPais])->orderBy('CodigoPais')->all();
            foreach ($departamentos as $departamento) {
                $opciones .= "<option value='" . $departamento->CodigoDepartamento . "'>" . $departamento->NombreDepartamento . "</option>";
            }
            return $opciones;
        }
    }
}
