<?php

namespace app\modules\Contraloria\controllers;

use app\modules\Contraloria\models\TiposDeclaracionesJuradasDao;
use app\modules\Filiacion\models\TrabajadoresDao;
//use backend\models\TrabajadoresDeclaracionesJuradasDao;
use app\modules\Contraloria\models\TiposDeclaracionesJuradasTrabajadoresDao;
use app\modules\Contraloria\models\TipoDeclaracionJuradaTrabajador;
use app\modules\Contraloria\models\TrabajadorDeclaracionJurada;
use app\modules\Contraloria\models\TrabajadoresDeclaracionesJuradasDao;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Yii;

class TrabajadoresDeclaracionesJuradasController extends Controller
{
    private $dao;

    public function getDao()
    {
        if ($this->dao == null) {
            $this->dao = new TrabajadoresDeclaracionesJuradasDao();
        }
        return $this->dao;
    }

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
        if ($action->id == "listar-trabajadores-declaraciones-juradas-ajax" || $action->id == "listar-trabajadores-ajax")
            $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $listaMeses = array('1' => 'Enero', '2' => 'Febrero', '3' => 'Marzo', '4' => 'Abril', '5' => 'Mayo', '6' => 'Junio', '7' => 'Julio', '8' => 'Agosto', '9' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre');
        return $this->render('trabajadoresdeclaracionesjuradas', [
            'meses' => $listaMeses
        ]);
    }

    public function actionListarTrabajadoresDeclaracionesJuradasAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $trabajadoresDeclaracionesJuradas = TrabajadoresDeclaracionesJuradasDao::listaTrabajadoresDeclaracionesJuradas();
            $datosJson = '{"data": [';
            $cantidad = count($trabajadoresDeclaracionesJuradas);
            for ($i = 0; $i < $cantidad; $i++) {
                $listaMeses = array('1' => 'Enero', '2' => 'Febrero', '3' => 'Marzo', '4' => 'Abril', '5' => 'Mayo', '6' => 'Junio', '7' => 'Julio', '8' => 'Agosto', '9' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre');
                $fechaNotificacionFormato = date_format(date_create($trabajadoresDeclaracionesJuradas[$i]->FechaNotificacion), 'd/m/Y');
                $fechaRecepcionFormato = date_format(date_create($trabajadoresDeclaracionesJuradas[$i]->FechaRecepcion), 'd/m/Y');
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                $acciones = "<div class='btn-group'><button class='btn btn-warning btnEditarTrabajadorDeclaracionJurada' codigo='" . $trabajadoresDeclaracionesJuradas[$i]->CodigoDeclaracionJurada . "' data-toggle='modal' data-target='#modalActualizarTrabajadorDeclaracionJurada'><i class='fa fa-pen'></i></button><button class='btn btn-danger btnEliminarTrabajadorDeclaracionJurada' codigo='" . $trabajadoresDeclaracionesJuradas[$i]->CodigoDeclaracionJurada . "' nombre='" . $trabajadoresDeclaracionesJuradas[$i]->NombreCompleto . "'><i class='fa fa-times'></i></button></div>";
                if ($i == $cantidad - 1) {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $trabajadoresDeclaracionesJuradas[$i]->NombreCompleto . '",
					 	"' . $trabajadoresDeclaracionesJuradas[$i]->NombreTipoDeclaracionJurada . '",
					 	"' . $trabajadoresDeclaracionesJuradas[$i]->CodigoDeclaracionJurada . '",
					 	"' . $trabajadoresDeclaracionesJuradas[$i]->Gestion . '",					 	
					 	"' . $listaMeses[$trabajadoresDeclaracionesJuradas[$i]->Mes] . '",
					 	"' . $fechaNotificacionFormato . '",
					 	"' . $fechaRecepcionFormato . '",
					 	"' . $trabajadoresDeclaracionesJuradas[$i]->Observacion . '",	
				      	"' . $acciones . '"
  			  ]';
                } else {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $trabajadoresDeclaracionesJuradas[$i]->NombreCompleto . '",
					 	"' . $trabajadoresDeclaracionesJuradas[$i]->NombreTipoDeclaracionJurada . '",
					 	"' . $trabajadoresDeclaracionesJuradas[$i]->CodigoDeclaracionJurada . '",
					 	"' . $trabajadoresDeclaracionesJuradas[$i]->Gestion . '",					 	
					 	"' . $listaMeses[$trabajadoresDeclaracionesJuradas[$i]->Mes] . '",
					 	"' . $fechaNotificacionFormato . '",
					 	"' . $fechaRecepcionFormato . '",
					 	"' . $trabajadoresDeclaracionesJuradas[$i]->Observacion . '",		
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

    public function actionCrearTrabajadorDeclaracionJuradaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if ($_POST["codigodeclaracionjuradacrear"] != "" && $_POST["fechanotificacioncrear"] != "" && $_POST["fecharecepcioncrear"] != "") {
                $trabajadorDeclaracionJurada = new TrabajadorDeclaracionJurada();
                $trabajadorDeclaracionJurada->CodigoDeclaracionJurada = $_POST["codigodeclaracionjuradacrear"];
                $trabajadorDeclaracionJurada->CodigoTrabajador = $_POST["codigotrabajadorcrear"];
                $trabajadorDeclaracionJurada->CodigoTipoDeclaracionJurada = $_POST["codigotipodeclaracionjuradacrear"];
                $trabajadorDeclaracionJurada->Gestion = $_POST["gestioncrear"];
                $trabajadorDeclaracionJurada->Mes = $_POST["mescrear"];

                $fechaInicioRecordatorioTemp = strtr($_POST["fechainiciorecordatoriocrear"], '/', '-');
                $fechaInicioRecordatorioTemp = strtotime($fechaInicioRecordatorioTemp);
                $fechaInicioRecordatorioTemp = date('Y-m-d', $fechaInicioRecordatorioTemp);
                $trabajadorDeclaracionJurada->FechaInicioRecordatorio = $fechaInicioRecordatorioTemp;
                $fechaFinRecordatorioTemp = strtr($_POST["fechafinrecordatoriocrear"], '/', '-');
                $fechaFinRecordatorioTemp = strtotime($fechaFinRecordatorioTemp);
                $fechaFinRecordatorioTemp = date('Y-m-d', $fechaFinRecordatorioTemp);
                $trabajadorDeclaracionJurada->FechaFinRecordatorio = $fechaFinRecordatorioTemp;

                $trabajadorDeclaracionJurada->FechaNotificacion = $_POST["fechanotificacioncrear"];
                $trabajadorDeclaracionJurada->FechaRecepcion = $_POST["fecharecepcioncrear"];
                $trabajadorDeclaracionJurada->Observacion = $_POST["observacioncrear"];
                $trabajadorDeclaracionJurada->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;
                if (!$trabajadorDeclaracionJurada->exist()) {
                    $trabajadorDeclaracionJurada->save();
                    $tipoDeclaracionJuradaTrabajador = TiposDeclaracionesJuradasTrabajadoresDao::buscaTipoDeclaracionJuradaTrabajador("object", $_POST["codigotipodeclaracionjuradacrear"], $_POST["codigotrabajadorcrear"]);
                    $frecuencia = $tipoDeclaracionJuradaTrabajador->Frecuencia;
                    $fechaInicioRecordatorio = $tipoDeclaracionJuradaTrabajador->FechaInicioRecordatorio;
                    $nuevaFechaInicioRecordatorio = strtotime('+' . $frecuencia . ' year', strtotime($fechaInicioRecordatorio));
                    $nuevaFechaInicioRecordatorio = date('Y-m-d', $nuevaFechaInicioRecordatorio);
                    $fechaFinRecordatorio = $tipoDeclaracionJuradaTrabajador->FechaFinRecordatorio;
                    $nuevaFechaFinRecordatorio = strtotime('+' . $frecuencia . ' year', strtotime($fechaFinRecordatorio));
                    $nuevaFechaFinRecordatorio = date('Y-m-d', $nuevaFechaFinRecordatorio);

                    $fechaInicioRecordatorioEntero = strtotime($fechaInicioRecordatorio);
                    $nuevaFechaFinRecordatorioEntero = strtotime($nuevaFechaFinRecordatorio);
                    $mes = date("m", $fechaInicioRecordatorioEntero);
                    if ($mes == 2) {//Febrero
                        $anioInicio = date("Y", $fechaInicioRecordatorioEntero);
                        if ((($anioInicio % 4 == 0) && ($anioInicio % 100 != 0)) || ($anioInicio % 400 == 0)) {
                            $nuevaFechaFinRecordatorio = strtotime('-1 days', strtotime($nuevaFechaFinRecordatorio));
                            $nuevaFechaFinRecordatorio = date('Y-m-d', $nuevaFechaFinRecordatorio);
                        }
                        $anioFin = date("Y", $nuevaFechaFinRecordatorioEntero);
                        if ((($anioFin % 4 == 0) && ($anioFin % 100 != 0)) || ($anioFin % 400 == 0)) {
                            $nuevaFechaFinRecordatorio = strtotime('+1 days', strtotime($nuevaFechaFinRecordatorio));
                            $nuevaFechaFinRecordatorio = date('Y-m-d', $nuevaFechaFinRecordatorio);
                        }
                    }
                    $tipoDeclaracionJuradaTrabajador = TipoDeclaracionJuradaTrabajador::findOne(["CodigoTipoDeclaracionJurada" => $tipoDeclaracionJuradaTrabajador->CodigoTipoDeclaracionJurada, "CodigoTrabajador" => $tipoDeclaracionJuradaTrabajador->CodigoTrabajador]);
                    $tipoDeclaracionJuradaTrabajador->FechaInicioRecordatorio = $nuevaFechaInicioRecordatorio;
                    $tipoDeclaracionJuradaTrabajador->FechaFinRecordatorio = $nuevaFechaFinRecordatorio;
                    $tipoDeclaracionJuradaTrabajador->save();
                    return "ok";
                } else {
                    return "existe";
                }
            } else {
                return "error-completar";
            }

        } else {
            return "error";
        }
    }

    public function actionBuscarTrabajadorDeclaracionJuradaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoeditar"])) {
                $trabajadorDeclaracionJurada = TrabajadoresDeclaracionesJuradasDao::buscaTrabajadorDeclaracionJurada("array", $_POST["codigoeditar"]);
                return json_encode($trabajadorDeclaracionJurada);
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionActualizarTrabajadorDeclaracionJuradaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoactualizar"])) {
                $trabajadorDeclaracionJurada = TrabajadorDeclaracionJurada::findOne($_POST["codigoanterior"]);
                $trabajadorDeclaracionJurada->CodigoDeclaracionJurada = $_POST["codigoactualizar"];
                $trabajadorDeclaracionJurada->Gestion = $_POST["gestionactualizar"];
                $trabajadorDeclaracionJurada->Mes = $_POST["mesactualizar"];
                $trabajadorDeclaracionJurada->FechaNotificacion = $_POST["fechanotificacionactualizar"];
                $trabajadorDeclaracionJurada->FechaRecepcion = $_POST["fecharecepcionactualizar"];
                $trabajadorDeclaracionJurada->Observacion = $_POST["observacionactualizar"];
                if ($_POST["codigoanterior"] == $_POST["codigoactualizar"]) {
                    $trabajadorDeclaracionJurada->save();
                    return "ok";
                } else {
                    if (!$trabajadorDeclaracionJurada->exist()) {
                        $trabajadorDeclaracionJurada->save();
                        return "ok";
                    } else {
                        return "existe";
                    }
                }
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionEliminarTrabajadorDeclaracionJuradaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoeliminar"])) {
                $trabajadorDeclaracionJurada = TrabajadorDeclaracionJurada::findOne($_POST["codigoeliminar"]);
                $trabajadorDeclaracionJurada->delete();
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionListarTrabajadoresAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $trabajadores = TrabajadoresDao::listaTrabajadores();
            if (count($trabajadores) > 0) {
                $datosJson = '{"data": [';
                $cantidad = count($trabajadores);
                for ($i = 0; $i < $cantidad; $i++) {
                    $fechaNacimiento = date_format(date_create($trabajadores[$i]->FechaNacimiento), 'd/m/Y');
                    $fechaIngreso = date_format(date_create($trabajadores[$i]->FechaIngreso), 'd/m/Y');
                    $fechaSalida = "";
                    if ($trabajadores[$i]->FechaSalida != null) {
                        $fechaSalida = date_format(date_create($trabajadores[$i]->FechaSalida), 'd/m/Y');
                    }
                    /*=============================================
                    CREAR LAS ACCIONES
                    =============================================*/
                    $acciones = "<center><button class='btn btn-primary btnElegir' idpersona='" . $trabajadores[$i]->IdPersona . "' codigo='" . $trabajadores[$i]->CodigoTrabajador . "' nombre='" . $trabajadores[$i]->NombreCompleto . "' fechanacimiento='" . $fechaNacimiento . "'>Seleccionar</button></center>";
                    if ($i == $cantidad - 1) {
                        $datosJson .= '[
                                "' . ($i + 1) . '",
                                "' . $trabajadores[$i]->CodigoTrabajador . '",
                                "' . $trabajadores[$i]->IdPersona . '",					 	
                                "' . $trabajadores[$i]->NombreCompleto . '",
                                "' . $fechaNacimiento . '",
                                "' . $fechaIngreso . '",
                                "' . $fechaSalida . '",                                
                                "' . $acciones . '"
  			                ]';
                    } else {
                        $datosJson .= '[
                                "' . ($i + 1) . '",
                                "' . $trabajadores[$i]->CodigoTrabajador . '",
                                "' . $trabajadores[$i]->IdPersona . '",					 	
                                "' . $trabajadores[$i]->NombreCompleto . '",
                                "' . $fechaNacimiento . '",
                                "' . $fechaIngreso . '",
                                "' . $fechaSalida . '",
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
        } else {
            $datosJson = '{"data": [';
            $datosJson .= ']}';
            return $datosJson;
        }
    }

    public function actionListarTiposDeclaracionesJuradasAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $opciones = "<option value=''>Selecionar Tipo de Declaracion Jurada</option>";
            $codigoTrabajador = $_POST["codigotrabajador"];
            $tiposDeclaracionesJuradas = TiposDeclaracionesJuradasDao::listaTiposDeclaracionesJuradasTrabajador($codigoTrabajador);
            foreach ($tiposDeclaracionesJuradas as $tipoDeclaracionJurada) {
                $opciones .= "<option value='" . $tipoDeclaracionJurada->CodigoTipoDeclaracionJurada . "'>" . $tipoDeclaracionJurada->NombreTipoDeclaracionJurada . "</option>";
            }
            return $opciones;
        }
    }

    public function actionBuscarTipoDeclaracionJuradaTrabajadorAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigotipodeclaracionjurada"]) && isset($_POST["codigotrabajador"])) {
                $tipoDeclaracionJuradaTrabajador = TiposDeclaracionesJuradasTrabajadoresDao::buscaTipoDeclaracionJuradaTrabajador("array", $_POST["codigotipodeclaracionjurada"], $_POST["codigotrabajador"]);
                return json_encode($tipoDeclaracionJuradaTrabajador);
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }
}