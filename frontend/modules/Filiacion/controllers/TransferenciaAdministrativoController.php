<?php

namespace app\modules\Filiacion\controllers;

use backend\models\AsignacionesDao;
use backend\models\NivelesSalarialesDao;
use backend\models\TrabajadoresDao;
use app\modules\Filiacion\models\NivelSalarial;
use app\modules\Filiacion\models\TransferenciaAdministrativo;
use app\modules\Filiacion\models\TransferenciaDetalleAdministrativo;
use app\modules\Filiacion\models\TransferenciaAdministrativosDao;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use Yii;

class TransferenciaAdministrativoController extends Controller
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
        if ($action->id == "listar-transferencias-administrativos-ajax" || $action->id == "listar-transferencia-asignacion-ajax")
            $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('transferenciaadministrativo');
    }

    public function actionListarTransferenciasAdministrativosAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $transferenciasAdministrativos = TransferenciaAdministrativo::find()->orderBy('CodigoTransferencia')->all();
            $datosJson = '{"data": [';
            $cantidad = count($transferenciasAdministrativos);
            for ($i = 0; $i < $cantidad; $i++) {
                $fechaInicioTransferencia = date_format(date_create($transferenciasAdministrativos[$i]->FechaInicioTransferencia), 'd/m/Y');
                $fechaFinAsignacion = date_format(date_create($transferenciasAdministrativos[$i]->FechaFinAsignacion), 'd/m/Y');
                /*=============================================
               REVISAR ESTADO
               =============================================*/
                if ($transferenciasAdministrativos[$i]->CodigoEstado == 'V') {
                    $colorEstado = "btn-success";
                    $textoEstado = "VIGENTE";
                    $estadoTipoDJ = "V";
                } else {
                    $colorEstado = "btn-danger";
                    $textoEstado = "CADUCADO";
                    $estadoTipoDJ = "C";
                }
                $estado = "<button class='btn " . $colorEstado . " btn-xs btnActivarTrasnferenciaAdministrativo' codigo='" . $transferenciasAdministrativos[$i]->CodigoTransferencia . "' estado='" . $transferenciasAdministrativos[$i]->CodigoEstado . "'>" . $textoEstado . "</button>";
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                $acciones = "<div class='btn-group'>";
                $acciones .= "<button class='btn-sm btn-warning btnEditarTransferenciaAdministrativo' codigo='" . $transferenciasAdministrativos[$i]->CodigoTransferencia . "' motivo='" . $transferenciasAdministrativos[$i]->Motivo . "' data-toggle='modal' data-target='#modalActualizarTransferenciaAdministrativo'>Editar</button>";
                $acciones .= "<button class='btn-sm btn-danger btnEliminarTransferenciaAdministrativo' codigo='" . $transferenciasAdministrativos[$i]->CodigoTransferencia . "' motivo='" . $transferenciasAdministrativos[$i]->Motivo . "'>Eliminar</button>";
                $acciones .= "<button class='btn-sm btn-success btnTransferenciasDetalleAdministrativos' codigo='" . $transferenciasAdministrativos[$i]->CodigoTransferencia . "'>Ir</button>";
                $acciones .= "</div>";
                if ($i == $cantidad - 1) {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $transferenciasAdministrativos[$i]->CodigoTransferencia . '",
					 	"' . $transferenciasAdministrativos[$i]->Motivo . '",
					 	"' . $fechaInicioTransferencia . '",
					 	"' . $fechaFinAsignacion . '",
				 	 	"' . $estado . '",				      	
				      	"' . $acciones . '"
  			        ]';
                } else {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $transferenciasAdministrativos[$i]->CodigoTransferencia . '",
					 	"' . $transferenciasAdministrativos[$i]->Motivo . '",
					 	"' . $fechaInicioTransferencia . '",
					 	"' . $fechaFinAsignacion . '",
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

    public function actionBuscarTransferenciaAdministrativoAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigotransferencia"])) {
                $transferenciaAdministrativo = TransferenciaAdministrativosDao::buscaTransferenciaAdministrativo("array", $_POST["codigotransferencia"]);
                return json_encode($transferenciaAdministrativo);
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionCrearTransferenciaAdministrativoAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["motivo"]) && $_POST["motivo"] != "") {
                $maximo = TransferenciaAdministrativosDao::maximoTransferenciasAdministrativos();
                $nuevoCodigo = $maximo + 1;
                $transferenciaAdministrativo = new TransferenciaAdministrativo();
                $transferenciaAdministrativo->CodigoTransferencia = $nuevoCodigo;
                $transferenciaAdministrativo->Motivo = $_POST["motivo"];
                $transferenciaAdministrativo->FechaInicioTransferencia = $_POST["fechainiciotransferencia"];
                $transferenciaAdministrativo->FechaFinAsignacion = strtotime('-1 day', strtotime($_POST["fechainiciotransferencia"]));
                $transferenciaAdministrativo->FechaFinAsignacion = date('d-m-Y', $transferenciaAdministrativo->FechaFinAsignacion);
                $transferenciaAdministrativo->CodigoEstado = 'V';
                $transferenciaAdministrativo->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;
                if (!$transferenciaAdministrativo->exist()) {
                    $transferenciaAdministrativo->save();
                    return "ok";
                } else {
                    return "existe";
                }
            } else {
                return "errorNombre";
            }
        } else {
            return "error";
        }
    }

    public function actionActualizarTransferenciaAdministrativoAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigotransferencia"])) {
                $transferenciaAdministrativo = TransferenciaAdministrativo::findOne($_POST["codigotransferencia"]);
                $transferenciaAdministrativo->Motivo = $_POST["motivo"];
                $transferenciaAdministrativo->FechaInicioTransferencia = $_POST["fechainiciotransferencia"];
                $transferenciaAdministrativo->FechaFinAsignacion = strtotime('-1 day', strtotime($_POST["fechainiciotransferencia"]));
                $transferenciaAdministrativo->FechaFinAsignacion = date('d-m-Y', $transferenciaAdministrativo->FechaFinAsignacion);
                if (!$transferenciaAdministrativo->exist()) {
                    $transferenciaAdministrativo->save();
                    return "ok";
                } else {
                    return "existe";
                }
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionEliminarTransferenciaAdministrativoAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigotransferencia"])) {
                $transferenciaAdministrativo = TransferenciaAdministrativo::findOne($_POST["codigotransferencia"]);
                $transferenciaAdministrativo->delete();
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    /*------------------------------------------------------------*/
    /*        TRANSFERENCIAS DETALLE ADMINISTRATIVOS              */
    /*------------------------------------------------------------*/

    public function actionIrDetalle($codigoTransferencia)
    {
        $transferenciaAdministrativo = TransferenciaAdministrativo::findOne($codigoTransferencia);
        return $this->render('transferenciadetalleadministrativo', [
            'transferenciaAdministrativo' => $transferenciaAdministrativo,
        ]);
    }

    public function actionListarAsignacionesAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $Codigo = $_POST["Codigo"];
            $transferencia = TransferenciaAdministrativo::find()->where(['CodigoTransferencia' => $Codigo])->one();
            $asignaciones = TransferenciaAdministrativosDao::listaAsignacionesAdministrativos();
            $datosJson = '{"data": [';
            $i = 0;
            $length = count($asignaciones);
            foreach ($asignaciones as $asignacion) {
                $i++;

                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/

                $acciones = "<div class='btn-group' style='horiz-align: center; vertical-align: middle'>";
                $acciones .= "<input type='checkbox' hidden id='" . $i . "'  codigotransferencia = '" . $transferencia->CodigoTransferencia . "' codigotrabajador='" . $asignacion['IdFuncionario'] . "' nombre='" . $asignacion['NombreCompleto'] . "' ci = '" . $asignacion['IdPersona'] . "' unidad = '" . $asignacion['CodigoUnidad'] . "' cargo = '" . $asignacion['CodigoCargo'] . "' nroitem = '" . $asignacion['NroItem'] . "' codigonivelsalarial = '" . $asignacion['CodigoNivelSalarial'] . "' class='btn-check chk'  autocomplete='off'>";
                $acciones .= "</div>";

                $datosJson .= '[
					 	"' . ($i) . '",
					 	"' . $asignacion['IdFuncionario'] . '",
					 	"' . $asignacion['IdPersona'] . '",
					 	"' . $asignacion['NombreCompleto'] . '",					 	
					 	"' . $asignacion['NombreUnidad'] . '",
				      	"' . $asignacion['NombreCargo'] . '",
				      	"' . $asignacion['NombreNivelSalarial'] . $acciones . '"				      	
  			    ]';
                if ($i !== $length) {
                    $datosJson .= ',';
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

    public function actionListarAsignacionesSeleccionadasAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $Codigo = $_POST["Codigo"];
            $transferencia = TransferenciaAdministrativo::find()->where(['CodigoTransferencia' => $Codigo])->one();
            $asignaciones = TransferenciaAdministrativosDao::listaTransferenciaDetalleAdministrativo($Codigo);
            $datosJson = '{"data": [';
            $i = 0;
            $length = count($asignaciones);
            foreach ($asignaciones as $asignacion) {
                $i++;
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                $acciones = "<div class='btn-group' style='horiz-align: center; vertical-align: middle'>";
                $acciones .= "<button class='btn-sm  btn-danger btnEliminarTransferenciaDetalleAdministrativo' codigo = '" . $transferencia->CodigoTransferencia . "' trabajador='" . $asignacion['CodigoTrabajador'] . "' item='" . $asignacion['NroItem'] . "' tipo = '" . $asignacion['TipoTransferencia'] . "' >Eliminar</button>";
                $acciones .= "</div>";
                $datosJson .= '[
					 	"' . ($i) . '",
					 	"' . $asignacion['CodigoTrabajador'] . '",
					 	"' . $asignacion['IdPersona'] . '",
					 	"' . $asignacion['NombreCompleto'] . '",
					 	"' . $asignacion['NombreUnidad'] . '",
					 	"' . $asignacion['NombreCargo'] . '",
					 	"' . $asignacion['NombreNivelSalarial'] . '",
                        "' . $acciones . '"
				      	
  			    ]';
                if ($i !== $length) {
                    $datosJson .= ',';
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

    public function actionRegistroAsignacionesAjax()
    {
        if (isset($_POST["codigotransferencia"]) && isset($_POST["codigotrabajador"]) && isset($_POST["nroitem"]) && isset($_POST["codigonivelsalarial"]) && isset($_POST["accion"])) {
            $transferenciaDetalleAdministrativo = new TransferenciaDetalleAdministrativo();
            $transferenciaDetalleAdministrativo->CodigoTransferencia = $_POST["codigotransferencia"];
            $transferenciaDetalleAdministrativo->IdFuncionario = $_POST["codigotrabajador"];
            $transferenciaDetalleAdministrativo->NroItem = $_POST["nroitem"];
            $transferenciaDetalleAdministrativo->CodigoNivelSalarial = $_POST["codigonivelsalarial"];
            $transferenciaDetalleAdministrativo->TipoTransferencia = 'O';
            $transferenciaDetalleAdministrativo->CodigoEstado = 'V';
            $transferenciaDetalleAdministrativo->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;
            //if (!$transferenciaDetalleAdministrativo->isUsed()) {
            $transferenciaDetalleAdministrativo->save();
            //return "ok";
            /*} else {
                return "existe";
            }*/

        } else {
            return "error";
        }

    }

    public function actionEliminarTransferenciaDetalleAdministrativoAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if ((isset($_POST["codigo"])) && (isset($_POST["trabajador"])) && (isset($_POST["item"])) && (isset($_POST["tipo"]))) {
                $transferenciaDetalle = TransferenciaDetalleAdministrativo::find()->where(["CodigoTransferencia" => $_POST["codigo"]])
                    ->andWhere(["Idfuncionario" => $_POST["trabajador"]])
                    ->andWhere(["NroItem" => $_POST["item"]])
                    ->andWhere(["TipoTransferencia" => $_POST["tipo"]])
                    ->One();
                if ($transferenciaDetalle->delete()) {
                    return "ok";
                } else {
                    return "error";
                }
            } else {
                return "error";
            }
        }
    }

    /*------------------------------------------------------------*/
    /*                      TRANSFERENCIAS                        */
    /*------------------------------------------------------------*/

    public function actionIrTransferenciaAsignacion($codigoTransferencia)
    {
        $transferenciaAdministrativo = TransferenciaAdministrativo::findOne($codigoTransferencia);
        return $this->render('transferenciaasignacion', [
            'transferenciaAdministrativo' => $transferenciaAdministrativo,
        ]);
    }

    public function actionListarTransferenciaAsignacionAjax()
    {
        $contenido = "";
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $Codigo = $_POST["Codigo"];
            $transferencia = TransferenciaAdministrativo::find()->where(['CodigoTransferencia' => $Codigo])->one();
            $asignaciones = TransferenciaAdministrativosDao::listaTransferenciaDetalleAdministrativo($Codigo);
            $i = 0;
            $length = count($asignaciones);
            if ($length == 0) {
                $contenido .= "<tr> <td colspan='7' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            } else {
                foreach ($asignaciones as $asignacion) {
                    $i++;
                    /*=============================================
                    CREAR LAS ACCIONES
                    =============================================*/
                    $nombreTrabajador = " <select  class='selectTrabajador form-control form-control-sm'   codigotransferencia = '" . $transferencia->CodigoTransferencia . "' itemTrabajador = '" . $asignacion['NroItemPlanillas'] . "'>";
                    $opciones = "<option value=''>Selecionar Trabajador</option>";
                    $transferenciasAdministrativos = TransferenciaAdministrativosDao::listaTransferenciaDetalleAdministrativo($Codigo);
                    foreach ($transferenciasAdministrativos as $transferenciaAdministrativo) {
                        $opciones .= "<option value='" . $transferenciaAdministrativo->CodigoTrabajador . "'>" . $transferenciaAdministrativo->NombreCompleto . "</option>";
                    }
                    $nombreTrabajador .= $opciones;
                    $nombreTrabajador .= "</select>";
                    $nivelSalarial = " <select  class='selectNivelSalarial form-control form-control-sm' >";
                    $opcionesNivel = "<option value=''>Selecionar Nivel Salarial</option>";
                    $codigoSectorTrabajo = 'ADM';
                    $transferenciasAdministrativosNiveles = NivelSalarial::find()->where(["CodigoSectorTrabajo" => $codigoSectorTrabajo])->orderBy('NombreNivelSalarial')->all();
                    foreach ($transferenciasAdministrativosNiveles as $transferenciaAdministrativoNivel) {
                        $opcionesNivel .= "<option value='" . $transferenciaAdministrativoNivel->CodigoNivelSalarial . "'>" . $transferenciaAdministrativoNivel->NombreNivelSalarial . "</option>";
                    }
                    $nivelSalarial .= $opcionesNivel;
                    $nivelSalarial .= "</select>";
                    $nivelSalarialActual = "<span id='nivelSalarialActual".$asignacion['NroItemPlanillas']."' codigotransferencia = '" . $transferencia->CodigoTransferencia . "' item = '" . $asignacion['NroItemPlanillas'] . "' >" . "</span>";
                    $contenido .= "<tr>";
                    $contenido = $contenido . "<td>" . '<b>' . 'Codigo: ' . '</b>' . $asignacion['IdFuncionario'] . '<br>' . '<b>' . 'C.I.: ' . '</b>' . $asignacion['IdPersona'] . '<br>' . '<b>' . 'Nombre: ' . '</b>' . $asignacion['NombreCompleto'] . '<br>' . '<b>' . 'Nivel: ' . '</b>' . $asignacion['NombreNivelSalarial'] . "</td>";
                    $contenido = $contenido . "<td class='nuevaAsignacion".$asignacion['NroItemPlanillas']."' itemActual = '" . $asignacion['NroItemPlanillas'] . "'>" . '<b>' . 'Unidad: ' . '</b>' . $asignacion['NombreUnidad'] . '<br>' . '<b>' . 'Cargo: ' . '</b>' . $asignacion['NombreCargo'] . '<br>' . '<b>' . 'Item: ' . '</b>' . $asignacion['NroItemPlanillas'] . "</td>";
                    $contenido = $contenido . "<td >" . '<b>' . 'Nombre: ' . '</b>' . $nombreTrabajador . '<br>' . '<b>' . 'Nivel Salarial Actual: ' . '</b>' . $nivelSalarialActual . '<br>' . '<b>' . 'Nivel: ' . '</b>' . $nivelSalarial . "</td>";
                    $contenido .= "</tr>";
                }
            }
        } else {
            $contenido .= "<tr> <td colspan='7' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
        }
        return $contenido;
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

    public function actionMostrarNivelSalarialAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $codigoTrabajador = $_POST["trabajador"];
            $nivelSalarial = TransferenciaAdministrativosDao::ObtenerNivelTrabajador($codigoTrabajador);
            if ($nivelSalarial != '') {
                return json_encode($nivelSalarial->NombreNivelSalarial);
            } else {
                return "error";
            }
        }
    }

    public function actionActualizarTransferenciaTrabajadorAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigocarrera"]) && isset($_POST["numeroplanestudios"]) && isset($_POST["siglamateria"]) && isset($_POST["grupo"]) && isset($_POST["tipogrupo"]) && isset($_POST["gestionplanificacion"]) && isset($_POST["idpersonaactualizar"])) {
                $cargaHorariaPropuesta = DetalleCargaHoraria::find()
                    ->where(['CodigoCarrera' => $_POST["codigocarrera"]])
                    ->andWhere(['NumeroPlanEstudios' => $_POST["numeroplanestudios"]])
                    ->andWhere(['SiglaMateria' => $_POST["siglamateria"]])
                    ->andWhere(['Grupo' => $_POST["grupo"]])
                    ->andWhere(['CodigoTipoGrupo' => $_POST["tipogrupo"]])
                    ->andWhere(['GestionAcademica' => $_POST["gestionplanificacion"]])->one();
                $cargaHorariaPropuesta->IdPersona = $_POST["idpersonaactualizar"];
                $cargaHorariaPropuesta->save();
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }
}