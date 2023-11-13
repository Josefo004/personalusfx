<?php

namespace app\modules\Filiacion\controllers;

use app\modules\Filiacion\models\AsignacionesDao;
use app\modules\Filiacion\models\TrabajadoresDao;
use app\modules\Filiacion\models\Asignacion;
use app\modules\Administracion\models\Item;
use app\modules\Administracion\models\Unidad;
use app\modules\Administracion\models\SectorTrabajo;
use common\models\PlanificacionDao;//Cargo;Unidad;
use app\modules\Administracion\models\CondicionLaboral;
use app\modules\Administracion\models\NivelSalarial;
use app\modules\Administracion\models\TiempoTrabajo;
use app\modules\Administracion\models\TipoDocumento;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use Yii;

class AsignacionesController extends Controller
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
        if ($action->id == "listar-asignaciones-ajax" || $action->id == "listar-trabajadores-ajax")
            $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $listaSectorTrabajo = ArrayHelper::map(SectorTrabajo::find()->orderBy('NombreSectorTrabajo')->all(), 'CodigoSectorTrabajo', 'NombreSectorTrabajo');
        $listaTipoDocumento = ArrayHelper::map(TipoDocumento::find()->orderBy('NombreTipoDocumento')->all(), 'CodigoTipoDocumento', 'NombreTipoDocumento');
        $listaTiempoTrabajo = ArrayHelper::map(TiempoTrabajo::find()->orderBy('NombreTiempoTrabajo')->all(), 'CodigoTiempoTrabajo','NombreTiempoTrabajo');
        return $this->render('asignaciones', [
            'sectoresTrabajo' => $listaSectorTrabajo,
            'tiposDocumento' => $listaTipoDocumento,
            'tiemposTrabajo' => $listaTiempoTrabajo,
        ]);
    }

    public function actionListarAsignacionesAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $asignaciones = AsignacionesDao::listaAsignaciones();
            $datosJson = '{"data": [';
            $cantidad = count($asignaciones);
            for ($i = 0; $i < $cantidad; $i++) {
                $fechaInicio = date_format(date_create($asignaciones[$i]->FechaInicio), 'd/m/Y');
                if ($asignaciones[$i]->FechaFin != null) {
                    $fechaFin = date_format(date_create($asignaciones[$i]->FechaFin), 'd/m/Y');
                } else {
                    $fechaFin = "Indefinido";
                }
                /*=============================================
                REVISAR ESTADO
                =============================================*/
                if ($asignaciones[$i]->CodigoEstado == 'V') {
                    $colorEstado = "btn-success";
                    $textoEstado = "VIGENTE";
                    $estadoAsignacion = "V";
                } else {
                    $colorEstado = "btn-danger";
                    $textoEstado = "NO VIGENTE";
                    $estadoAsignacion = "C";
                }
                $estado = "<button class='btn " . $colorEstado . " btn-xs btnActivar' estado='" . $estadoAsignacion . "' codigo='" . $asignaciones[$i]->CodigoAsignacion . "'>" . $textoEstado . "</button>";
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                $acciones = "<div class='btn-group'>";
                /*$acciones .= "<button class='btn btn-warning btnEditarAsignacion' codigo='" . $asignaciones[$i]->CodigoAsignacion . "' data-toggle='modal' data-target='#modalActualizarAsignacion'><i class='fa fa-pen'></i></button>";*/
                $acciones .= "<button class='btn btn-danger btnEliminarAsignacion' codigo='" . $asignaciones[$i]->CodigoAsignacion . "' nombre='" . $asignaciones[$i]->CodigoTrabajador . "'><i class='fa fa-times'>Eliminar</i></button>";
                /*$acciones .= "<button class='btn btn-success btnVerImagen' tipoDocumento='" . trim($asignaciones[$i]->NombreTipoDocumento) . "' codigoTrabajador='" . $asignaciones[$i]->CodigoTrabajador . "' documento='" . $asignaciones[$i]->NroDocumento . "' sectorTrabajo='" . $asignaciones[$i]->CodigoCondicionLaboral . "' data-toggle='modal' data-target='#modalMostarMemorandum'><i class='fa fa-address-book'></i></button>";*/
                $acciones .= "</div>";
                if ($i == $cantidad - 1) {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $asignaciones[$i]->NombreCompleto . '<br> ' . '<br>' . '<b>' . 'Codigo : ' . '</b>' . $asignaciones[$i]->CodigoTrabajador . '<br> ' . '<br>' . '<b>' . 'CI : ' . '</b>' . $asignaciones[$i]->IdPersona . '",
					 	"' . $asignaciones[$i]->NombreUnidad . '<br>' . '<br>' . '<b>' . 'Depende de : ' . '</b>' . $asignaciones[$i]->NombreUnidadPadre . '",
					 	"' . $asignaciones[$i]->NombreCargo . '<br>' . '<br>' . '<b>' . 'Sector: ' . '</b>' . $asignaciones[$i]->NombreSectorTrabajo . '<br>' . '<br>' . '<b>' . 'Tiempo: ' . '</b>' . $asignaciones[$i]->NombreTiempoTrabajo .'",
					 	"' . /*'<b>' . 'Item RRHH: ' . '</b>' . $asignaciones[$i]->NroItemRrhh . '<br>' . '<br>' .*/ '<b>' . 'Nro Item: ' . '</b>' . $asignaciones[$i]->NroItemPlanillas
                        . '<br>' . '<br>' . '<b>' . 'Nivel Salarial: ' . '</b>' . $asignaciones[$i]->NombreNivelSalarial . '<br>' . '<br>' . '<b>' . 'Haber Basico: ' . '</b>' . round($asignaciones[$i]->HaberBasico , 2) . '",
					 	"' . '<b>' . 'Inicio: ' . '</b>' . $fechaInicio . '<br>' . '<br>' . '<b>' . 'Finalización: ' . '</b>' . $fechaFin . '",
					 	"' . $asignaciones[$i]->JefaturaLiteral . '<br>' . '<br>' . '<b>' . 'Interinato: ' . '</b>' . $asignaciones[$i]->InterinatoLiteral . '",
					 	"' . $asignaciones[$i]->NroDocumento . '<br>' . '<br>' . '<b>' . 'Tipo: ' . '</b>' . $asignaciones[$i]->NombreTipoDocumento . '",	
					 	"' . $estado . '",				      	
				      	"' . $acciones . '"
  			  ]';
                } else {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $asignaciones[$i]->NombreCompleto . '<br> ' . '<br>' . '<b>' . 'Codigo : ' . '</b>' . $asignaciones[$i]->CodigoTrabajador . '<br> ' . '<br>' . '<b>' . 'CI : ' . '</b>' . $asignaciones[$i]->IdPersona . '",
					 	"' . $asignaciones[$i]->NombreUnidad . '<br>' . '<br>' . '<b>' . 'Depende de : ' . '</b>' . $asignaciones[$i]->NombreUnidadPadre . '",
					 	"' . $asignaciones[$i]->NombreCargo . '<br>' . '<br>' . '<b>' . 'Sector: ' . '</b>' . $asignaciones[$i]->NombreSectorTrabajo . '<br>' . '<br>' . '<b>' . 'Tiempo: ' . '</b>' . $asignaciones[$i]->NombreTiempoTrabajo .'",
					 	"' . /*'<b>' . 'Item RRHH: ' . '</b>' . $asignaciones[$i]->NroItemRrhh . '<br>' . '<br>' .*/ '<b>' . 'Nro Item: ' . '</b>' . $asignaciones[$i]->NroItemPlanillas
                        . '<br>' . '<br>' . '<b>' . 'Nivel Salarial: ' . '</b>' . $asignaciones[$i]->NombreNivelSalarial . '<br>' . '<br>' . '<b>' . 'Haber Basico: ' . '</b>' . round($asignaciones[$i]->HaberBasico , 2) . '",
					 	"' . '<b>' . 'Inicio: ' . '</b>' . $fechaInicio . '<br>' . '<br>' . '<b>' . 'Finalización: ' . '</b>' . $fechaFin . '",
					 	"' . $asignaciones[$i]->JefaturaLiteral . '<br>' . '<br>' . '<b>' . 'Interinato: ' . '</b>' . $asignaciones[$i]->InterinatoLiteral . '",
					 	"' . $asignaciones[$i]->NroDocumento . '<br>' . '<br>' . '<b>' . 'Tipo: ' . '</b>' . $asignaciones[$i]->NombreTipoDocumento . '",	
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

    public function actionListarTrabajadoresAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $trabajadores = TrabajadoresDao::listaTrabajadores();
            $datosJson = '{"data": [';
            $cantidad = count($trabajadores);
            for ($i = 0; $i < $cantidad; $i++) {
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                if ($trabajadores[$i]->CodigoAsignacion == null) {
                    $acciones = "<center><button class='btn btn-primary btnElegir' codigoTrabajador='" . $trabajadores[$i]->CodigoTrabajador . "' idPersona='" . $trabajadores[$i]->IdPersona . "' nombre='" . $trabajadores[$i]->NombreCompleto . "' >Seleccionar</button></center>";
                } else {
                    $acciones = "<center><span class='text-danger'>Ya tiene Asignacion</span></center>";
                }
                if ($i == $cantidad - 1) {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $trabajadores[$i]->CodigoTrabajador . '",
					 	"' . $trabajadores[$i]->IdPersona . '",					 	
					 	"' . $trabajadores[$i]->NombreCompleto . '",			      	
				      	"' . $acciones . '"
  			  ]';
                } else {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $trabajadores[$i]->CodigoTrabajador . '",
					 	"' . $trabajadores[$i]->IdPersona . '",					 	
					 	"' . $trabajadores[$i]->NombreCompleto . '",
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

    public function actionActivarAsignacionAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoactivar"]) && isset($_POST["estadoactivar"])) {
                $asignacion = Asignacion::findOne($_POST["codigoactivar"]);
                $estadoActualAsignacion = $asignacion->CodigoEstado;
                if ($estadoActualAsignacion == "V") {
                    $asignacion->CodigoEstado = "C";
                } else {
                    $asignacion->CodigoEstado = "V";
                }
                $asignacion->save();
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionCrearAsignacionAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            //if (isset($_POST["codigounidad"]) && $_POST["codigounidad"] != "") {
                if (isset($_POST["codigocondicionlaboral"]) && $_POST["codigocondicionlaboral"] != "") {
                    //if (isset($_POST["codigocargo"]) && $_POST["codigocargo"] != "") {
                        if (isset($_POST["nroitem"]) && $_POST["nroitem"] != "") {
                            if (isset($_POST["codigonivelsalarial"]) && $_POST["codigonivelsalarial"] != "") {
                                if (isset($_POST["fechainicio"]) && $_POST["fechainicio"] != "") {
                                    if ($_POST["fechafin"] <= $_POST["fechainicio"]) {
                                        if (isset($_POST["jefatura"]) && $_POST["jefatura"] != "") {
                                            if (isset($_POST["nrodocumento"]) && $_POST["nrodocumento"] != "") {
                                                if (isset($_POST["codigotipodocumento"]) && $_POST["codigotipodocumento"] != "") {
                                                    $maximo = AsignacionesDao::maximoAsignaciones();
                                                    $maximo = $maximo + 1;
                                                    $nuevoCodigo = "ASG";
                                                    if ($maximo <= 9999) {
                                                        $nuevoCodigo = $nuevoCodigo . '0';
                                                    }
                                                    if ($maximo <= 999) {
                                                        $nuevoCodigo = $nuevoCodigo . '0';
                                                    }
                                                    if ($maximo <= 99) {
                                                        $nuevoCodigo = $nuevoCodigo . '0';
                                                    }
                                                    if ($maximo <= 9) {
                                                        $nuevoCodigo = $nuevoCodigo . '0';
                                                    }
                                                    $nuevoCodigo = $nuevoCodigo . $maximo;
                                                    $asignacion = new Asignacion();
                                                    $asignacion->CodigoAsignacion = $nuevoCodigo;
                                                    $asignacion->CodigoTrabajador = $_POST["codigotrabajador"];
                                                    //$asignacion->CodigoUnidad = $_POST["codigounidad"];
                                                    $asignacion->CodigoCondicionLaboral = $_POST["codigocondicionlaboral"];
                                                    //$asignacion->CodigoCargo = $_POST["codigocargo"];
                                                    $asignacion->NroItem = $_POST["nroitem"];
                                                    $asignacion->CodigoNivelSalarial = $_POST["codigonivelsalarial"];
                                                    $asignacion->FechaInicio = $_POST["fechainicio"];
                                                    $asignacion->FechaFin = $_POST["fechafin"];
                                                    $asignacion->Jefatura = $_POST["jefatura"];
                                                    $asignacion->NroDocumento = $_POST["nrodocumento"];
                                                    $asignacion->FechaDocumento = $_POST["fechadocumento"];
                                                    $asignacion->CodigoTipoDocumento = $_POST["codigotipodocumento"];
                                                    $asignacion->Interinato = $_POST["interinato"];
                                                    $asignacion->CodigoTiempoTrabajo = $_POST["codigotiempotrabajo"];
                                                    $asignacion->CodigoEstado = 'V';
                                                    $asignacion->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;
                                                    if (!$asignacion->exist()) {
                                                        $asignacion->save();
                                                        return "ok";
                                                    } else {
                                                        return "existe";
                                                    }
                                                } else {
                                                    return "errorTipoDocumento";
                                                }
                                            } else {
                                                return "errorNroDocumento";
                                            }
                                        } else {
                                            return "errorJefatura";
                                        }
                                    } else {
                                        return "errorFechaFin";
                                    }
                                } else {
                                    return "errorFechaInicio";
                                }
                            } else {
                                return "errorNivel";
                            }
                        } else {
                            return "errorItem";
                        }
                    //} else {
                        //return "errorCargo";
                    //}
                } else {
                    return "errorCondicionLaboral";
                }
            //} else {
                //return "errorUnidad";
            //}
        } else {
            return "error";
        }
    }

    public function actionActualizarAsignacionAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoasignacion"])) {
                //if (isset($_POST["codigounidad"]) && $_POST["codigounidad"] != "") {
                    if (isset($_POST["codigocondicionlaboral"]) && $_POST["codigocondicionlaboral"] != "") {
                        //if (isset($_POST["codigocargo"]) && $_POST["codigocargo"] != "") {
                            if (isset($_POST["nroitem"]) && $_POST["nroitem"] != "") {
                                if (isset($_POST["codigonivelsalarial"]) && $_POST["codigonivelsalarial"] != "") {
                                    if (isset($_POST["fechainicio"]) && $_POST["fechainicio"] != "") {
                                        if ($_POST["fechafin"] <= $_POST["fechainicio"]) {
                                            if (isset($_POST["jefatura"]) && $_POST["jefatura"] != "") {
                                                if (isset($_POST["nrodocumento"]) && $_POST["nrodocumento"] != "") {
                                                    if (isset($_POST["codigotipodocumento"]) && $_POST["codigotipodocumento"] != "") {
                                                        $asignacion = Asignacion::findOne($_POST["codigoasignacion"]);
                                                        $asignacion->CodigoTrabajador = $_POST["codigotrabajador"];
                                                        //$asignacion->CodigoUnidad = $_POST["codigounidad"];
                                                        $asignacion->CodigoCondicionLaboral = $_POST["codigocondicionlaboral"];
                                                        //$asignacion->CodigoCargo = $_POST["codigocargo"];
                                                        $asignacion->NroItem = $_POST["nroitem"];
                                                        $asignacion->CodigoNivelSalarial = $_POST["codigonivelsalarial"];
                                                        $asignacion->FechaInicio = $_POST["fechainicio"];
                                                        $asignacion->FechaFin = $_POST["fechafin"];
                                                        $asignacion->Jefatura = $_POST["jefatura"];
                                                        $asignacion->NroDocumento = $_POST["nrodocumento"];
                                                        $asignacion->FechaDocumento = $_POST["fechadocumento"];
                                                        $asignacion->CodigoTipoDocumento = $_POST["codigotipodocumento"];
                                                        $asignacion->Interinato = $_POST["interinato"];
                                                        $asignacion->CodigoTiempoTrabajo = $_POST["codigotiempotrabajo"];
                                                        $asignacion->save();
                                                        return "ok";
                                                    } else {
                                                        return "errorTipoDocumento";
                                                    }
                                                } else {
                                                    return "errorNroDocumento";
                                                }
                                            } else {
                                                return "errorJefatura";
                                            }
                                        } else {
                                            return "errorFechaFin";
                                        }
                                    } else {
                                        return "errorFechaInicio";
                                    }
                                } else {
                                    return "errorNivel";
                                }
                            } else {
                                return "errorItem";
                            }
                        //} else {
                            //return "errorCargo";
                        //}
                    } else {
                        return "errorCondicionLaboral";
                    }
                //} else {
                    //return "errorUnidad";
                //}
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionEliminarAsignacionAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoeliminar"])) {
                $asignacion = Asignacion::findOne($_POST["codigoeliminar"]);
                $asignacion->delete();
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionListarUnidadesAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST['search'])) {
                $unidades = Unidad::find()->where(['like', 'NombreUnidad', '%' . $_POST['search'] . '%', false])->orderBy(['CodigoUnidad' => SORT_ASC])->all();
            } else {
                $unidades = Unidad::find()->orderBy(['CodigoUnidad' => SORT_ASC])->all();
            }

            $data = array();
            foreach ($unidades as $unidad) {
                $padre = Unidad::find()->where(['CodigoUnidad' => $unidad->CodigoUnidadPadre])->one();
                if ($padre) {
                    $data[] = array('id' => $unidad->CodigoUnidad, 'text' => $unidad->NombreUnidad, 'padre' => $padre->NombreUnidad);
                } else {
                    $data[] = array('id' => $unidad->CodigoUnidad, 'text' => $unidad->NombreUnidad, 'padre' => 'Raiz');
                }
            }
            return json_encode($data);
        } else {
            $data[] = array('id' => 0, 'text' => 'Error en el envio de datos');
            return json_encode($data);
        }
    }

    public function actionListarCondicionesLaboralesAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $opciones = "<option value=''>Selecionar Condicion Laboral</option>";
            $codigoCondicionLaboral = $_POST["codigosectortrabajo"];
            $condicionesLaborales = CondicionLaboral::find()->where(["CodigoSectorTrabajo" => $codigoCondicionLaboral])->orderBy('NombreCondicionLaboral')->all();
            foreach ($condicionesLaborales as $condicionLaboral) {
                $opciones .= "<option value='" . $condicionLaboral->CodigoCondicionLaboral . "'>" . $condicionLaboral->NombreCondicionLaboral . "</option>";
            }
            return $opciones;
        }
    }

    /*public function actionListarCargosAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $opciones = "<option value=''>Selecionar Cargo</option>";
            $codigoCargo = $_POST["codigosectortrabajo"];
            $cargos = PlanificacionDao::listaCargos($codigoCargo);
            //$cargos = Cargo::find()->where(["CodigoSectorTrabajo" => $codigoCargo])->orderBy('NombreCargo')->all();
            foreach ($cargos as $cargo) {
                $opciones .= "<option value='" . $cargo->CodigoCargo . "'>" . $cargo->NombreCargo . "</option>";
            }
            return $opciones;
        }
    }*/

    public function actionListarCargosAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $opciones = "<option value=''>Seleccionar Cargo</option>";
            $codigoSectorTrabajo = $_POST["codigosectortrabajo"];
            $codigoUnidad = $_POST["codigounidad"];
            $cargos = PlanificacionDao::listaCargos($codigoSectorTrabajo,$codigoUnidad);
            foreach ($cargos as $cargo) {
                $opciones .= "<option value='" . $cargo->CodigoCargo . "'>" . $cargo->NombreCargo . "</option>";
            }
            return $opciones;
        }
    }

    public function actionListarItemsAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $opciones = "<option value=''>Selecionar Item</option>";
            $nroItem = $_POST["codigoCargo"];
            $codigoUnidad = $_POST["codigoUnidad"];
            $items = Item::find()->where(["CodigoCargo" => $nroItem, "CodigoUnidad" => $codigoUnidad])->orderBy('NroItemRrhh')->all();
            foreach ($items as $item) {
                $opciones .= "<option value='" . $item->NroItem . "'>" . $item->NroItemRrhh . "</option>";
            }
            return $opciones;
        }
    }

    public function actionListarNivelesSalarialesAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $opciones = "<option value=''>Selecionar Nivel Salarial</option>";
            $codigoSectorTrabajo = $_POST["codigosectortrabajo"];
            $nivelesSalariales = NivelSalarial::find()->where(["CodigoSectorTrabajo" => $codigoSectorTrabajo])->orderBy('NombreNivelSalarial')->all();
            foreach ($nivelesSalariales as $nivelSalarial) {
                $opciones .= "<option value='" . $nivelSalarial->CodigoNivelSalarial . "'>" . $nivelSalarial->NombreNivelSalarial . ' - (' . $nivelSalarial->DescripcionNivelSalarial . ')' . '(' . $nivelSalarial->HaberBasico . ' Bs.)' . "</option>";
            }
            return $opciones;
        }
    }

    public function actionIrItems()
    {
        return $this->render('items/index');
    }

    public function actionExisteAsignacionTrabajadorAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigo"]) && isset($_POST["sector"])) {
                $asignacion = AsignacionesDao::existeAsignacionTrabajador("array", $_POST["codigo"], $_POST["sector"]);
                return json_encode($asignacion);
                //return "error";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionBuscarAsignacionAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoeditar"])) {
                $asignacion = AsignacionesDao::buscaAsignacion("array", "CodigoAsignacion", $_POST["codigoeditar"]);
                return json_encode($asignacion);
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionSubirArchivosAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {

            $tipoDocumento = $_POST["tipoDocumento"];
            $codigoTrabajador = $_POST["codigoTrabajador"];
            $documento = $_POST["documento"];
            $sectorTrabajo = $_POST["codigoCondicionLaboral"];
            $imagenOriginal = $_FILES['file']['name'];
            $imagenTemporal = $_FILES["file"]["tmp_name"];
            $imagenTipo = strtolower(pathinfo($imagenOriginal, PATHINFO_EXTENSION));
            $dir = "img/asignaciones/";

            //Especificamos cual sera el ancho y alto maximo permitido
            //para la imagen redimensionada

            $anchoMaximo = 2100;
            $altoMaximo = 2800;


            if (($imagenTipo === "jpeg") || ($imagenTipo === "jpg")) {
                $fileName = str_replace(" ", "_", trim($tipoDocumento)) . '_' . trim($codigoTrabajador) . '_' . $sectorTrabajo . '_' . str_replace("/", "-", $documento) . '.' . 'jpeg';
                $fileNameComplete = $dir . $fileName;
                $imagenGuardada = move_uploaded_file($imagenTemporal, $fileNameComplete);

                if ($imagenGuardada) {
                    $mostrarImagen = $fileNameComplete;

                    return $mostrarImagen;
                    //more code here...
                    //Extraigo los atributos ancho y alto de la imagen original
                    $dimensiones = getimagesize($mostrarImagen);
                    $ancho = $dimensiones[0];
                    $alto = $dimensiones[1];
                    if (($ancho >= $anchoMaximo) && ($alto >= $altoMaximo)) {

                        //Creamos una imagen temporal para poder manipularla
                        //sin modificar imagen original
                        $imagenTemporal = imagecreatefromjpeg($imagenGuardada);


                        //Calculamos el ancho y alto propocional de
                        //la imagen redimensionada
                        $anchoProporcional = $anchoMaximo / $ancho;
                        $altoProporcional = $altoMaximo / $alto;
                        //En caso de que el ancho y el alto estan dentro,
                        //de los maximos permitidos, los mantenemos
                        if (($ancho <= $anchoMaximo) && ($alto <= $altoMaximo)) {
                            $anchoNuevo = $ancho;
                            $altoNuevo = $alto;
                        }
                        //Si el alto es mayor que el ancho
                        //calculamos un alto proporcional al maximo permitido
                        elseif (($anchoProporcional * $alto) < $altoMaximo) {
                            $altoNuevo = ceil($anchoProporcional * $alto);
                            $anchoNuevo = $anchoMaximo;
                        }
                        //Si el ancho es mayor que el alto
                        //calculamos un ancho proporcional al maximo permitido
                        else {
                            $anchoNuevo = ceil($altoProporcional * $ancho);
                            $altoNuevo = $altoMaximo;
                        }

                        //Creamos una imagen de tamaño $anchonuevo  por $altonuevo .
                        $imgNueva = imagecreatetruecolor($anchoNuevo, $altoNuevo);
                        //Copiamos la imagen temporal sobre la imagen nueva con las
                        //dimensiones definidas
                        imagecopyresampled($imgNueva, $imagenTemporal, 0, 0, 0, 0, $anchoNuevo, $altoNuevo, $ancho, $alto);
                        //Quitamos la imagen temporal de la Ram
                        imagedestroy($imagenTemporal);

                        //Definimos la calidad de la imagen nueva
                        $calidad = 100;
                        //separamos el nombre del archivo de su extension
                        $archivo = explode(".", $imagenOriginal);
                        //Añadimos al nuevo archivo la palabra mini
                        //para saber que es un miniatura
                        $archivoNuevo = $archivo[0] . "-mini." . $archivo[1];

                        //Guardamos la nueva imagen en la carpeta que
                        //asignemos, por ejemplo podemos tener una carpeta
                        //para imagenes originales y otra para miniaturas
                        imagejpeg($imgNueva, $archivoNuevo, $calidad);
                    } else {
                        return "errorTamaño";
                    }
                } else {
                    return "errorGuardado";
                }
            } else {
                return "errorFormato";
            }
        } else {
            return "error";

        }
    }

    public function actionMostrarArchivosAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $tipoDocumento = $_POST["tipoDocumento"];
            $codigoTrabajador = $_POST["codigoTrabajador"];
            $documento = $_POST["documento"];
            $sectorTrabajo = $_POST["codigoCondicionLaboral"];
            $dir = "/urrhhsoft/backend/web/img/asignaciones/";
            $fileName = str_replace(" ", "_", trim($tipoDocumento)) . '_' . trim($codigoTrabajador) . '_' . $sectorTrabajo . '_' . str_replace("/", "-", $documento) . '.' . 'jpeg';
            $fileNameComplete = $dir . $fileName;
            if ($fileNameComplete) {
                return $fileNameComplete;
            } else
                return "errorNombre";
        }
    }

    public function actionEliminarImagenAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $tipoDocumento = $_POST["tipoDocumento"];
            $codigoTrabajador = $_POST["codigoTrabajador"];
            $documento = $_POST["documento"];
            $sectorTrabajo = $_POST["codigoCondicionLaboral"];
            $dir = "/urrhhsoft/backend/web/img/asignaciones/";
            $fileName = str_replace(" ", "_", trim($tipoDocumento)) . '_' . trim($codigoTrabajador) . '_' . $sectorTrabajo . '_' . str_replace("/", "-", $documento) . '.' . 'jpeg';
            $fileNameComplete = $dir . $fileName;
            //$borrar = @unlink(realpath($fileNameComplete));
            if ($fileNameComplete) {
                return unlink($dir . $fileName);
            } else
                return "errorNoEliminado";
        }
    }

}