<?php

namespace app\modules\Filiacion\controllers;

use app\modules\Administracion\models\CondicionLaboral;
use app\modules\Administracion\models\Item;
use app\modules\Administracion\models\TiempoTrabajo;
use app\modules\Filiacion\models\Administrativo;
use app\modules\Filiacion\models\AdministrativosDao;
use app\modules\Filiacion\models\Cargo;
use app\modules\Filiacion\models\NivelSalarial;
use app\modules\Filiacion\models\SectorTrabajo;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use Yii;

class AdministrativosController extends Controller
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
        if ($action->id == "listar-administrativos" || $action->id == "listar-funcionarios")
            $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $listaItems = ArrayHelper::map(Item::find()->orderBy('NroItem')->all(), 'IdItem', 'NroItem');
        $listaNivelesSalariales = ArrayHelper::map(NivelSalarial::find()->orderBy('NombreNivelSalarial')->all(), 'CodigoNivelSalarial', 'NombreNivelSalarial');
        $listaCondicionesLaborales = ArrayHelper::map(CondicionLaboral::find()->orderBy('NombreCondicionLaboral')->all(), 'CodigoCondicionLaboral', 'NombreCondicionLaboral');
        $listaTiemposTrabajo = ArrayHelper::map(TiempoTrabajo::find()->orderBy('NombreTiempoTrabajo')->all(), 'CodigoTiempoTrabajo', 'NombreTiempoTrabajo');
        $listaSectoresTrabajo = ArrayHelper::map(SectorTrabajo::find()->orderBy('NombreSectorTrabajo')->all(), 'CodigoSectorTrabajo', 'NombreSectorTrabajo');
        return $this->render('administrativos', [
            'item' => $listaItems,
            'nivelSalarial' => $listaNivelesSalariales,
            'condicionLaboral' => $listaCondicionesLaborales,
            'tiempoTrabajo' => $listaTiemposTrabajo,
            'sectorTrabajo' => $listaSectoresTrabajo,
        ]);
    }

    public function actionListarAdministrativos()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $administrativos = AdministrativosDao::listaAdministrativos();
            $datosJson = '{"data": [';
            $cantidad = count($administrativos);
            for ($i = 0; $i < $cantidad; $i++) {
                $fechaIngreso = date_format(date_create($administrativos[$i]->FechaIngreso), 'd/m/Y');
                if ($administrativos[$i]->FechaSalida != null) {
                    $fechaSalida = date_format(date_create($administrativos[$i]->Fechasalida), 'd/m/Y');
                } else {
                    $fechaSalida = "Indefinido";
                }
                /*=============================================
                REVISAR ESTADO
                =============================================*/
                if ($administrativos[$i]->CodigoEstado == 'V') {
                    $colorEstado = "btn-success";
                    $textoEstado = "VIGENTE";
                    $estadoAdministrativo = "V";
                } else {
                    $colorEstado = "btn-danger";
                    $textoEstado = "NO VIGENTE";
                    $estadoAdministrativo = "C";
                }
                $estado = "<button class='btn " . $colorEstado . " btn-xs btnActivar' estado='" . $estadoAdministrativo . "' codigo='" . $administrativos[$i]->IdFuncionario . "' iditem='" . $administrativos[$i]->IdItem . "' fechaingreso='" . $administrativos[$i]->FechaIngreso . "'>" . $textoEstado . "</button>";
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                $acciones = "<div class='btn-group'>";
                $acciones .= "<button class='btn btn-warning btnEditarAdministrativo' codigo='" . $administrativos[$i]->IdFuncionario . "' idpersona='" . $administrativos[$i]->IdPersona . "' nombrecompleto='" . $administrativos[$i]->NombreCompleto . "' iditem='" . $administrativos[$i]->IdItem . "' fechaingreso='" . $administrativos[$i]->FechaIngreso . "' sectortrabajo='" . $administrativos[$i]->CodigoSectorTrabajo . "' data-toggle='modal' data-target='#modalActualizarAdministrativo'><i class='fa fa-pen'>Editar</i></button>";
                //$acciones .= "<button class='btn btn-danger btnEliminarAdministrativo' codigo='" . $administrativos[$i]->IdFuncionario . "' nombre='" . $administrativos[$i]->NombreCompleto . "'><i class='fa fa-times'>Eliminar</i></button>";
                /*$acciones .= "<button class='btn btn-success btnVerImagen' tipoDocumento='" . trim($asignaciones[$i]->NombreTipoDocumento) . "' codigoTrabajador='" . $asignaciones[$i]->CodigoTrabajador . "' documento='" . $asignaciones[$i]->NroDocumento . "' sectorTrabajo='" . $asignaciones[$i]->CodigoCondicionLaboral . "' data-toggle='modal' data-target='#modalMostarMemorandum'><i class='fa fa-address-book'></i></button>";*/
                $acciones .= "</div>";
                if ($i == $cantidad - 1) {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $administrativos[$i]->IdFuncionario . '",
					 	"' . $administrativos[$i]->IdPersona . '",
					 	"' . $administrativos[$i]->NombreCompleto . '",
					 	"' . $fechaIngreso . '",
					 	"' . $administrativos[$i]->NombreNivelSalarial . '",
					 	"' . $administrativos[$i]->NombreCondicionLaboral . '",	
					 	"' . $fechaSalida . '",
					 	"' . $administrativos[$i]->NroMemorando . '",
					 	"' . $administrativos[$i]->NombreTiempoTrabajo . '",
					 	"' . $administrativos[$i]->Observaciones . '",
					 	"' . $estado . '",				      	
				      	"' . $acciones . '"
  			  ]';
                } else {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $administrativos[$i]->IdFuncionario . '",
					 	"' . $administrativos[$i]->IdPersona . '",
					 	"' . $administrativos[$i]->NombreCompleto . '",
					 	"' . $fechaIngreso . '",
					 	"' . $administrativos[$i]->NombreNivelSalarial . '",
					 	"' . $administrativos[$i]->NombreCondicionLaboral . '",	
					 	"' . $fechaSalida . '",
					 	"' . $administrativos[$i]->NroMemorando . '",
					 	"' . $administrativos[$i]->NombreTiempoTrabajo . '",
					 	"' . $administrativos[$i]->Observaciones . '",
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

    public function actionListarFuncionarios()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $funcionarios = AdministrativosDao::listaFuncionarios();
            //$personas = persona::find()->orderBy('Paterno, Materno, Nombres')->all();
            $datosJson = '{"data": [';
            $cantidad = count($funcionarios);
            for ($i = 0; $i < $cantidad; $i++) {
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                //if ($funcionarios[$i]->IdFuncionario == null) {
                    $acciones = "<center><button class='btn btn-primary btnElegir' codigo='" . $funcionarios[$i]->IdFuncionario . "' idpersona='" . $funcionarios[$i]->IdPersona . "' nombre='" . $funcionarios[$i]->NombreCompleto . "' >Seleccionar</button></center>";
                /*} else {
                    $acciones = "<center><span class='text-danger'>Ya tiene registro</span></center>";
                }*/
                if ($i == $cantidad - 1) {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $funcionarios[$i]->IdFuncionario . '",
					 	"' . $funcionarios[$i]->IdPersona . '",
					 	"' . $funcionarios[$i]->NombreCompleto . '",				 	 	
				      	"' . $acciones . '"
  			  ]';
                } else {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $funcionarios[$i]->IdFuncionario . '",
					 	"' . $funcionarios[$i]->IdPersona . '",
					 	"' . $funcionarios[$i]->NombreCompleto . '",
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

    /*public function actionActivarAdministrativoAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoactivar"]) && isset($_POST["estadoactivar"])) {
                $administrativo = Administrativo::findOne($_POST["codigoactivar"]);
                if ($_POST["estadoactivar"] == "V") {
                    $administrativo->CodigoEstado = "C";
                } else {
                    $administrativo->CodigoEstado = "V";
                }
                $administrativo->save();
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }*/
    public function actionActivarAdministrativoAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoactivar"]) && isset($_POST["fechaingresoactivar"]) && isset($_POST["iditemactivar"]) && isset($_POST["estadoactivar"])) {
                $docente = Administrativo::findOne(['IdFuncionario'=>$_POST["codigoactivar"],'IdItem'=>$_POST["iditemactivar"],'FechaIngreso'=>$_POST["fechaingresoactivar"]]);
                if ($docente !== null) {
                    if ($_POST["estadoactivar"] == "V") {
                        $docente->CodigoEstado = "C";
                    } else {
                        $docente->CodigoEstado = "V";
                    }
                    $docente->save();
                    return "ok";
                } else {
                    return "error2"; // No se encontró el registro en la base de datos
                }
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionBuscarAdministrativoAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoeditar"]) || isset($_POST["iditemeditar"]) || isset($_POST["fechaingresoeditar"]) /*|| isset($_POST["sectortrabajoeditar"])*/ ) {
                $administrativo = AdministrativosDao::buscaAdministrativo("array",$_POST["codigoeditar"],$_POST["iditemeditar"],$_POST["fechaingresoeditar"]/*,$_POST["sectortrabajoeditar"]*/);
                return json_encode($administrativo);
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionCrearAdministrativoAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $administrativo = new Administrativo();
            $administrativo->IdFuncionario = $_POST["idfuncionariocrear"];
            $administrativo->IdItem = $_POST["iditemcrear"];
            $administrativo->FechaIngreso = $_POST["fechaingresocrear"];
            $administrativo->CodigoNivelSalarial = $_POST["codigonivelsalarialcrear"];
            $administrativo->CodigoCondicionLaboral = $_POST["codigocondicionlaboralcrear"];
            $administrativo->FechaSalida = $_POST["fechasalidacrear"];
            $administrativo->NroMemorando = $_POST["nromemorandocrear"];
            $administrativo->CodigoTiempoTrabajo = $_POST["codigotiempotrabajocrear"];
            $administrativo->Observaciones = $_POST["observacionescrear"];
            $administrativo->CodigoEstado = 'V';
            $administrativo->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;
            //if (!$trabajador->exist()) {
            $administrativo->save();
            return "ok";
            //} else {
            //return "existe";
            //}
            //} else {
            //return "error";
        }
    }

    public function actionActualizarAdministrativoAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["idfuncionarioactualizar"]) || $_POST["iditemactualizar"] || $_POST["fechaingresoactualizar"] ) {
                $administrativo = Administrativo::findOne(['IdFuncionario'=>$_POST["idfuncionarioactualizar"], 'IdItem'=>$_POST["iditemactualizar"], 'FechaIngreso'=>$_POST["fechaingresoactualizar"]]);
                $administrativo->IdItem = $_POST["iditemactualizar"];
                $administrativo->FechaIngreso = $_POST["fechaingresoactualizar"];
                $administrativo->CodigoNivelSalarial = $_POST["codigonivelsalarialactualizar"];
                $administrativo->CodigoCondicionLaboral = $_POST["codigocondicionlaboralactualizar"];
                $administrativo->FechaSalida = $_POST["fechasalidaactualizar"];
                $administrativo->NroMemorando = $_POST["nromemorandocrear"];
                $administrativo->CodigoTiempoTrabajo = $_POST["codigotiempotrabajoactualizar"];
                $administrativo->Observaciones = $_POST["observacionesactualizar"];
                $administrativo->save();
                return "ok";
            } else {
                return "error1";
            }
        } else {
            return "error";
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

    public function actionListarNivelesSalarialesAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $opciones = "<option value=''>Selecionar Nivel Salarial</option>";
            $codigoSectorTrabajo = $_POST["codigosectortrabajo"];
            $nivelesSalariales = NivelSalarial::find()->where(["CodigoSectorTrabajo" => $codigoSectorTrabajo])->orderBy('NombreNivelSalarial')->all();
            foreach ($nivelesSalariales as $nivelSalarial) {
                $opciones .= "<option value='" . $nivelSalarial->CodigoNivelSalarial . "'>" . $nivelSalarial->NombreNivelSalarial . "</option>";
            }
            return $opciones;
        }
    }

    public function actionListarCargosAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $opciones = "<option value=''>Selecionar Cargo</option>";
            $codigoCargo = $_POST["codigosectortrabajo"];
            $cargos = Cargo::find()->where(["CodigoSectorTrabajo" => $codigoCargo])->orderBy('NombreCargo')->all();
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
            //$codigoUnidad = $_POST["codigoUnidad"];
            $items = Item::find()->where(["CodigoCargo" => $nroItem/*, "CodigoUnidad" => $codigoUnidad*/])->orderBy('NroItem')->all();
            foreach ($items as $item) {
                $opciones .= "<option value='" . $item->IdItem . "'>" . $item->NroItem . "</option>";
            }
            return $opciones;
        }
    }

    /*public function actionEliminarAdministrativoAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoeliminar"])) {
                $administrativo = Administrativo::findOne($_POST["codigoeliminar"]);
                //if (!$trabajador->isUsed()) {
                $administrativo->delete();
                return "ok";
                //} else {
                //    return "enUso";
                //}
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }*/
}