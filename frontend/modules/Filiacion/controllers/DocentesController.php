<?php

namespace app\modules\Filiacion\controllers;

use app\modules\Administracion\models\CondicionLaboral;
use app\modules\Administracion\models\TiempoTrabajo;
use app\modules\Filiacion\models\Docente;
use app\modules\Filiacion\models\DocentesDao;
use app\modules\Filiacion\models\NivelSalarial;
use app\modules\Filiacion\models\SectorTrabajo;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use Yii;

class DocentesController extends Controller
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
        if ($action->id == "listar-docentes" || $action->id == "listar-funcionarios")
            $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $listaSectoresTrabajo = ArrayHelper::map(SectorTrabajo::find()->orderBy('NombreSectorTrabajo')->all(), 'CodigoSectorTrabajo', 'NombreSectorTrabajo');
        $listaTiemposTrabajo = ArrayHelper::map(TiempoTrabajo::find()->orderBy('NombreTiempoTrabajo')->all(), 'CodigoTiempoTrabajo', 'NombreTiempoTrabajo');
        return $this->render('docentes', [
            'sectorTrabajo' => $listaSectoresTrabajo,
            'tiempoTrabajo' => $listaTiemposTrabajo,
        ]);
    }

    public function actionListarDocentes()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $docentes = DocentesDao::listaDocentes();
            $datosJson = '{"data": [';
            $cantidad = count($docentes);
            for ($i = 0; $i < $cantidad; $i++) {
                $fechaIngreso = date_format(date_create($docentes[$i]->FechaIngreso), 'd/m/Y');
                if ($docentes[$i]->FechaSalida != null) {
                    $fechaSalida = date_format(date_create($docentes[$i]->Fechasalida), 'd/m/Y');
                } else {
                    $fechaSalida = "Indefinido";
                }
                /*=============================================
                REVISAR ESTADO
                =============================================*/
                if ($docentes[$i]->CodigoEstado == 'V') {
                    $colorEstado = "btn-success";
                    $textoEstado = "VIGENTE";
                    $estadoDocente = "V";
                } else {
                    $colorEstado = "btn-danger";
                    $textoEstado = "NO VIGENTE";
                    $estadoDocente = "C";
                }
                //$estado = "<button class='btn " . $colorEstado . " btn-xs btnActivar' estado='" . $estadoDocente . "' codigo='" . $docentes[$i]->IdFuncionario . "'>" . $textoEstado . "</button>";
                $estado = "<button class='btn " . $colorEstado . " btn-xs btnActivar' estado='" . $estadoDocente. "' codigo='" . $docentes[$i]->IdFuncionario . "' fechaingreso='" . $docentes[$i]->FechaIngreso . "'>" . $textoEstado . "</button>";
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                $acciones = "<div class='btn-group'>";
                $acciones .= "<button class='btn btn-warning btnEditarDocente' codigo='" . $docentes[$i]->IdFuncionario . "' idpersona='" . $docentes[$i]->IdPersona . "' nombrecompleto='" . $docentes[$i]->NombreCompleto .  "' fechaingreso='" . $docentes[$i]->FechaIngreso . "' sectortrabajo='" . $docentes[$i]->CodigoSectorTrabajo . "' data-toggle='modal' data-target='#modalActualizarDocente'><i class='fa fa-pen'>Editar</i></button>";
                /*$acciones .= "<button class='btn btn-danger btnEliminarAdministrativo' codigo='" . $docentes[$i]->CodigoEstado . "' nombre='" . $docentes[$i]->IdFuncionario . "'><i class='fa fa-times'>Eliminar</i></button>";*/
                /*$acciones .= "<button class='btn btn-success btnVerImagen' tipoDocumento='" . trim($docentes[$i]->NombreTipoDocumento) . "' codigoTrabajador='" . $docentes[$i]->CodigoTrabajador . "' documento='" . $docentes[$i]->NroDocumento . "' sectorTrabajo='" . $docentes[$i]->CodigoCondicionLaboral . "' data-toggle='modal' data-target='#modalMostarMemorandum'><i class='fa fa-address-book'></i></button>";*/
                $acciones .= "</div>";
                if ($i == $cantidad - 1) {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $docentes[$i]->IdFuncionario . '",
					 	"' . $docentes[$i]->IdPersona . '",
					 	"' . $docentes[$i]->NombreCompleto . '",
					 	"' . $fechaIngreso . '",
					 	"' . $docentes[$i]->NombreNivelSalarial . '",
					 	"' . $docentes[$i]->NombreCondicionLaboral . '",	
					 	"' . $fechaSalida . '",
					 	"' . $docentes[$i]->Observaciones . '",
					 	"' . $estado . '",				      	
				      	"' . $acciones . '"
  			  ]';
                } else {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $docentes[$i]->IdFuncionario . '",
					 	"' . $docentes[$i]->IdPersona . '",
					 	"' . $docentes[$i]->NombreCompleto . '",
					 	"' . $fechaIngreso . '",
					 	"' . $docentes[$i]->NombreNivelSalarial . '",
					 	"' . $docentes[$i]->NombreCondicionLaboral . '",	
					 	"' . $fechaSalida . '",
					 	"' . $docentes[$i]->Observaciones . '",
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
            $funcionarios = DocentesDao::listaFuncionarios();
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

    public function actionActivarDocenteAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoactivar"]) && isset($_POST["fechaingresoactivar"])&& isset($_POST["estadoactivar"])) {
                $docente = Docente::findOne(['IdFuncionario'=>$_POST["codigoactivar"],'FechaIngreso'=>$_POST["fechaingresoactivar"]]);
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

    public function actionBuscarDocenteAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoeditar"]) /*|| isset($_POST["iditemeditar"])*/ || isset($_POST["fechaingresoeditar"]) /*|| isset($_POST["sectortrabajoeditar"])*/ ) {
                $docente = DocentesDao::buscaDocente("array",$_POST["codigoeditar"],/*$_POST["iditemeditar"],*/$_POST["fechaingresoeditar"]/*,$_POST["sectortrabajoeditar"]*/);
                return json_encode($docente);
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionCrearDocenteAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $administrativo = new Docente();
            $administrativo->IdFuncionario = $_POST["idfuncionariocrear"];
            //$administrativo->IdItem = $_POST["iditemcrear"];
            $administrativo->FechaIngreso = $_POST["fechaingresocrear"];
            $administrativo->CodigoNivelSalarial = $_POST["codigonivelsalarialcrear"];
            $administrativo->CodigoCondicionLaboral = $_POST["codigocondicionlaboralcrear"];
            $administrativo->FechaSalida = $_POST["fechasalidacrear"];
            //$administrativo->NroMemorando = $_POST["nromemorandocrear"];
            //$administrativo->CodigoTiempoTrabajo = $_POST["codigotiempotrabajocrear"];
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

    public function actionActualizarDocenteAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["idfuncionarioactualizar"]) || $_POST["iditemactualizar"] || $_POST["fechaingresoactualizar"] ) {
                $administrativo = Docente::findOne(['IdFuncionario'=>$_POST["idfuncionarioactualizar"], /*'IdItem'=>$_POST["iditemactualizar"],*/ 'FechaIngreso'=>$_POST["fechaingresoactualizar"]]);
                //$administrativo->IdItem = $_POST["iditemactualizar"];
                $administrativo->FechaIngreso = $_POST["fechaingresoactualizar"];
                $administrativo->CodigoNivelSalarial = $_POST["codigonivelsalarialactualizar"];
                $administrativo->CodigoCondicionLaboral = $_POST["codigocondicionlaboralactualizar"];
                $administrativo->FechaSalida = $_POST["fechasalidaactualizar"];
                //$administrativo->NroMemorando = $_POST["nromemorandocrear"];
                //$administrativo->CodigoTiempoTrabajo = $_POST["codigotiempotrabajoactualizar"];
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
}