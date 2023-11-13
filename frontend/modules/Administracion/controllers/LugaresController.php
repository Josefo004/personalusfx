<?php

namespace app\modules\Administracion\controllers;

use app\modules\Administracion\models\Provincia;
use common\models\AcademicaCatalogosDao;
use app\modules\Administracion\models\PaisesDao;
use app\modules\Administracion\models\DepartamentosDao;
use app\modules\Administracion\models\Departamento;
use app\modules\Administracion\models\ProvinciasDao;
use app\modules\Administracion\models\LugaresDao;
use app\modules\Administracion\models\Lugar;
use yii\web\Controller;

class LugaresController extends Controller
{
    public function beforeAction($action)
    {
        if ($action->id == "listar-lugares" || $action->id == "listar-lugares-acad")
            $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $listaPaises = PaisesDao::listaPaises();
        $listaDepartamentos = DepartamentosDao::listaDepartamentos();
        $listaProvincias = ProvinciasDao::listaProvincias();
        return $this->render('lugares',[
            'paises' => $listaPaises,
            'departamentos' => $listaDepartamentos,
            'provincias' => $listaProvincias,
        ]);
    }

    public function actionListarLugares()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $lugares = LugaresDao::listaLugares();
            $datosJson = '{"data": [';
            $cantidad = count($lugares);
            for ($i = 0; $i < $cantidad; $i++) {
                /*=============================================
               REVISAR ESTADO
               =============================================*/
                if ($lugares[$i]->CodigoEstado == 'V') {
                    $colorEstado = "btn-success";
                    $textoEstado = "VIGENTE";
                    $estadoLugar = "V";
                } else {
                    $colorEstado = "btn-danger";
                    $textoEstado = "NO VIGENTE";
                    $estadoLugar = "C";
                }
                $estado = "<button class='btn " . $colorEstado . " btn-xs btnActivarLugar' codigo-estado='" . $estadoLugar . "' codigo-lugar='" . $lugares[$i]->CodigoLugar . "'>" . $textoEstado . "</button>";
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                $acciones = "<div class='btn-group'>";
                $acciones .= "<button class='btn btn-danger btnEliminarLugar' codigo-lugar='" . $lugares[$i]->CodigoLugar . "' nombre-lugar='" . $lugares[$i]->NombreLugar . "'>Eliminar</button>";
                $acciones .= "</div>";
                $datosJson .= '[';
                $datosJson .= '"' . ($i + 1) . '",';
                $datosJson .= '"' . $lugares[$i]->NombrePais . '",';
                $datosJson .= '"' . $lugares[$i]->NombreDepartamento . '",';
                $datosJson .= '"' . $lugares[$i]->NombreProvincia . '",';
                $datosJson .= '"' . $lugares[$i]->NombreLugar . '",';
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

    public function actionGuardarLugar()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $maximo = LugaresDao::generarCodigoLugar();
            $nuevoCodigo = $maximo + 1;
            $lugar = new Lugar();
            $lugar->CodigoLugar = $nuevoCodigo;
            $lugar->NombreLugar = $_POST["nombrelugaracad"];
            $lugar->CodigoProvincia = $_POST["codigoprovincia"];
            $lugar->CodigoPaisAcad = $_POST["codigopaisacad"];
            $lugar->CodigoDepartamentoAcad = $_POST["codigodepartamentoacad"];
            $lugar->CodigoProvinciaAcad = $_POST["codigoprovinciaacad"];
            $lugar->CodigoLugarAcad = $_POST["codigolugaracad"];
            $lugar->IdLugarAcad = $_POST["idlugaracad"];
            $lugar->CodigoEstado = 'V';
            //$pais->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;
            if (!$lugar->exist()) {
                $lugar->save();
                return "ok";
            } else {
                return "existe";
            }
        } else {
            return "error";
        }
    }


    public function actionCambiarEstadoLugar()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigolugar"]) && $_POST["codigolugar"] != "") {
                $lugar = Lugar::findOne($_POST["codigolugar"]);
                if ($lugar->CodigoEstado == "V") {
                    $lugar->CodigoEstado = "C";
                } else {
                    $lugar->CodigoEstado = "V";
                }
                $lugar->save();
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }


    public function actionEliminarLugar()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigolugar"]) && $_POST["codigolugar"] != "") {
                $lugar = Lugar::findOne($_POST["codigolugar"]);
                //if (!$lugar->isUsed()) {
                $lugar->delete();
                return "ok";
                /*} else {
                    return "enUso";
                }*/
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionListarLugaresAcad()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $codigoProvinciaAcad = $_POST["codigoprovinciaacad"];
            //$lugaresAcad = LugaresDao::listaLugaresProvinciaAcad($codigoProvinciaAcad);
            $lugaresAcad = AcademicaCatalogosDao::listaLugaresProvinciaAcad($codigoProvinciaAcad);
            $datosJson = '{"data": [';
            $cantidad = count($lugaresAcad);
            for ($i = 0; $i < $cantidad; $i++) {
                $nombreLugar = str_replace('"', " ", $lugaresAcad[$i]->NombreLugar);
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                $acciones = "<center><button class='btn btn-primary btnElegir' codigo-lugar-acad='" . $lugaresAcad[$i]->CodigoLugar . "' nombre-lugar-acad='" . $nombreLugar . "' codigo-pais-acad='" . $lugaresAcad[$i]->CodigoPais . "' codigo-departamento-acad='" . $lugaresAcad[$i]->CodigoDepartamento . "' codigo-provincia-acad='" . $lugaresAcad[$i]->CodigoProvincia . "' id-lugar-acad='" . $lugaresAcad[$i]->IdLugar . "'>Seleccionar</button></center>";
                if ($i == $cantidad - 1) {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $lugaresAcad[$i]->CodigoLugar . '",
					 	"' . $nombreLugar  . '",				 	 	
				      	"' . $acciones . '"
  			  ]';
                } else {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $lugaresAcad[$i]->CodigoLugar . '",
					 	"' . $nombreLugar . '",				 	 	
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

    public function actionListarProvincias()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $opciones = "<option value=''>Selecionar Provincia</option>";
            $codigoDepartamento = $_POST["codigodepartamento"];
            $provincias = Provincia::find()->where(["CodigoDepartamento" => $codigoDepartamento])->orderBy('CodigoDepartamento')->all();
            foreach ($provincias as $provincia) {
                $opciones .= "<option value='" . $provincia->CodigoProvincia . "'>" . $provincia->NombreProvincia . "</option>";
            }
            return $opciones;
        }
    }
}