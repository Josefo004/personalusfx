<?php

namespace app\modules\Filiacion\controllers;

use app\modules\Filiacion\models\DatoPersonaFuncionario;
use app\modules\Filiacion\models\Funcionario;
use app\modules\Filiacion\models\SectorTrabajo;
use app\modules\Filiacion\models\TipoRenta;
use app\modules\Filiacion\models\TrabajadoresDao;
use app\modules\Filiacion\models\SeguroSocial;
use app\modules\Filiacion\models\EntidadBancaria;
use app\modules\Filiacion\models\Trabajador;
use app\modules\Filiacion\models\NivelAcademico;
use app\modules\Filiacion\models\Afp;
use app\modules\Filiacion\models\PersonasDao;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use Yii;

class TrabajadoresController extends Controller
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
        if ($action->id == "listar-funcionarios" || $action->id == "listar-personas")
            $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $listaEntidadesBancarias = ArrayHelper::map(EntidadBancaria::find()->orderBy('NombreBanco')->all(), 'CodigoBanco', 'NombreBanco');
        $listaAfps = ArrayHelper::map(Afp::find()->orderBy('NombreAfp')->all(), 'CodigoAfp', 'NombreAfp');
        $listaSegurosSociales = ArrayHelper::map(SeguroSocial::find()->orderBy('NombreSeguroSocial')->all(), 'CodigoSeguroSocial', 'NombreSeguroSocial');
        $listaTiposRenta = ArrayHelper::map(TipoRenta::find()->orderBy('NombreTipoRenta')->all(), 'CodigoTipoRenta', 'NombreTipoRenta');
        $listarSectoresTrabajo = ArrayHelper::map(SectorTrabajo::find()->orderBy('NombreSectorTrabajo')->all(), 'CodigoSectorTrabajo', 'NombreSectorTrabajo');
        return $this->render('trabajadores', [
            'entidadBancaria' => $listaEntidadesBancarias,
            'afps' => $listaAfps,
            'seguroSocial' => $listaSegurosSociales,
            'tipoRenta' => $listaTiposRenta,
            'sectorTrabajo' => $listarSectoresTrabajo,
        ]);
    }

    public function actionListarFuncionarios()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $trabajadores = TrabajadoresDao::listaTrabajadores();
            //$trabajadores = Trabajador::find()->orderBy('CodigoTrabajador')->all();
            $datosJson = '{"data": [';
            $cantidad = count($trabajadores);
            for ($i = 0; $i < $cantidad; $i++) {
                $fechaIngreso = date_format(date_create($trabajadores[$i]->FechaIngreso), 'd/m/Y');
                $fechaSalida = "";
                $fechaCalculoAntiguedad = "";
                $fechaCalculoVacaciones = "";
                $fechaFiniquito = "";
                if ($trabajadores[$i]->FechaSalida != null) {
                    $fechaSalida = date_format(date_create($trabajadores[$i]->FechaSalida), 'd/m/Y');
                }
                if ($trabajadores[$i]->FechaCalculoAntiguedad != null) {
                    $fechaCalculoAntiguedad = date_format(date_create($trabajadores[$i]->FechaCalculoAntiguedad), 'd/m/Y');
                }
                if ($trabajadores[$i]->FechaCalculoVacaciones != null) {
                    $fechaCalculoVacaciones = date_format(date_create($trabajadores[$i]->FechaCalculoVacaciones), 'd/m/Y');
                }
                if ($trabajadores[$i]->FechaFiniquito != null) {
                    $fechaFiniquito = date_format(date_create($trabajadores[$i]->FechaFiniquito), 'd/m/Y');
                }
                /*=============================================
               REVISAR ESTADO
               =============================================*/
                if ($trabajadores[$i]->CodigoEstadoFuncionario == 'V') {
                    $colorEstado = "btn-success";
                    $textoEstado = "VIGENTE";
                    $estadoTrabajador = "V";
                } else {
                    $colorEstado = "btn-danger";
                    $textoEstado = "CADUCADO";
                    $estadoTrabajador = "C";
                }
                $estado = "<button class='btn " . $colorEstado . " btn-xs btnActivar' estado='" . $estadoTrabajador . "' codigo='" . $trabajadores[$i]->IdFuncionario . "'>" . $textoEstado . "</button>";
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                $acciones = "<div class='btn-group'>";
                $acciones .= "<button class='btn btn-warning btn-sm btnEditarTrabajador' codigo='" . $trabajadores[$i]->IdFuncionario . "' idpersona='" . $trabajadores[$i]->IdPersona . "' fechaactualizacion='" . $trabajadores[$i]->FechaActualizacion . "' data-toggle='modal' data-target='#modalActualizarTrabajador' ><i class='fa fa-pen'> Editar</i></button>";
                //$acciones .= "<button class='btn btn-danger btn-sm btnEliminarTrabajador' codigo='" . $trabajadores[$i]->IdFuncionario . "' nombre='" . $trabajadores[$i]->NombreCompleto . "'><i class='fa fa-times'> Eliminar</i></button>";
                $acciones .= "</div>";
                if ($i == $cantidad - 1) {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $trabajadores[$i]->IdFuncionario . '",
					 	"' . $trabajadores[$i]->IdPersona . '",					 	
					 	"' . $trabajadores[$i]->NombreCompleto . '",
					 	"' . $fechaIngreso . '",
					 	"' . $fechaSalida . '",
					 	"' . $fechaCalculoAntiguedad . '",
					 	"' . $fechaCalculoVacaciones . '",
					 	"' . $fechaFiniquito . '",					 	
					 	"' . $trabajadores[$i]->NombreAfp . '",
					 	"' . $trabajadores[$i]->NUA . '",
					 	"' . $trabajadores[$i]->NombreSeguroSalud  . '",
				 	 	"' . $estado . '",				      	
				      	"' . $acciones . '"
  			  ]';
                } else {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $trabajadores[$i]->IdFuncionario . '",
					 	"' . $trabajadores[$i]->IdPersona . '",					 	
					 	"' . $trabajadores[$i]->NombreCompleto . '",
					 	"' . $fechaIngreso . '",
					 	"' . $fechaSalida . '",
					 	"' . $fechaCalculoAntiguedad . '",
					 	"' . $fechaCalculoVacaciones . '",
					 	"' . $fechaFiniquito . '",					 	
					 	"' . $trabajadores[$i]->NombreAfp . '",
					 	"' . $trabajadores[$i]->NUA . '",
					 	"' . $trabajadores[$i]->NombreSeguroSalud  . '",
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

    public function actionListarPersonas()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $personas = TrabajadoresDao::listaPersonas();
            //$personas = persona::find()->orderBy('Paterno, Materno, Nombres')->all();
            $datosJson = '{"data": [';
            $cantidad = count($personas);
            for ($i = 0; $i < $cantidad; $i++) {
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                if ($personas[$i]->CodigoTrabajador == null) {
                    $acciones = "<center><button class='btn btn-primary btnElegir' codigo='" . $personas[$i]->IdPersona . "' nombre='" . $personas[$i]->NombreCompleto . "'>Seleccionar</button></center>";
                } else {
                    $acciones = "<center><span class='text-danger'>Ya tiene registro</span></center>";
                }
                if ($i == $cantidad - 1) {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $personas[$i]->IdPersona . '",
					 	"' . $personas[$i]->NombreCompleto . '",				 	 	
				      	"' . $acciones . '"
  			  ]';
                } else {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $personas[$i]->IdPersona . '",
					 	"' . $personas[$i]->NombreCompleto . '",
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

    public function actionActivarTrabajadorAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoactivar"]) && isset($_POST["estadoactivar"])) {
                $trabajador = Funcionario::findOne($_POST["codigoactivar"]);
                if ($_POST["estadoactivar"] == "V") {
                    $trabajador->CodigoEstadoFuncionario = "C";
                } else {
                    $trabajador->CodigoEstadoFuncionario = "V";
                }
                $trabajador->save();
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionBuscarTrabajadorAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoeditar"]) || isset($_POST["idpersonaeditar"]) || isset($_POST["fechaactualizacioneditar"]) ) {
                $funcionario = TrabajadoresDao::buscaTrabajador("array",$_POST["codigoeditar"],$_POST["idpersonaeditar"],$_POST["fechaactualizacioneditar"] );
                return json_encode($funcionario);
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionCrearTrabajadorAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            //$maximo = TrabajadoresDao::generarIdFuncionario();
            //$nuevoIdFuncionario = $maximo + 1;
            $trabajador = new Funcionario();
            //$trabajador->IdFuncionario = $nuevoIdFuncionario;
            $trabajador->IdPersona = $_POST["idpersonacrear"];
            $trabajador->CodigoSectorTrabajo = $_POST["codigosectortrabajocrear"];
            $trabajador->FechaIngreso = $_POST["fechaingresocrear"];
            $trabajador->FechaSalida = $_POST["fechasalidacrear"];
            $trabajador->FechaCalculoAntiguedad = $_POST["fechacalculoantiguedadcrear"];
            $trabajador->AntiguedadExternaReconocida = $_POST["antiguedadexternareconocidacrear"];
            $trabajador->FechaCalculoVacaciones = $_POST["fechacalculovacacionescrear"];
            $trabajador->FechaFiniquito = $_POST["fechafiniquitocrear"];
            $trabajador->CodigoEstadoFuncionario = 'V';
            $trabajador->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;

            $trabajadorDatos = new DatoPersonaFuncionario();
            $trabajadorDatos->IdPersona = rtrim($_POST["idpersonadatoscrear"]);
            //$trabajadorDatos->FechaHoraActualizacion = getdate();
            $trabajadorDatos->CodigoAFP = $_POST["codigoafpcrear"];
            $trabajadorDatos->ResolucionAFP = $_POST["resolucionafpcrear"];
            $trabajadorDatos->FechaRegistroAFP = $_POST["fecharegistroafpcrear"];
            $trabajadorDatos->PrimerMesRegistroAFP = $_POST["primermesregistroafpcrear"];
            $trabajadorDatos->UltimoMesRegistroAFP = $_POST["ultimomesregistroafpcrear"];
            $trabajadorDatos->ExclusionVoluntariaAFP = $_POST["exclusionvoluntariaafpcrear"];
            $trabajadorDatos->NUA = $_POST["nuacrear"];
            $trabajadorDatos->CodigoSeguroSocial = $_POST["segurosocialcrear"];
            $trabajadorDatos->CodigoBanco = $_POST["codigobancocrear"];
            $trabajadorDatos->NroCuentaBancaria = $_POST["nrocuentabancariacrear"];
            $trabajadorDatos->CodigoTipoRenta = $_POST["tiporentacrear"];
            //if (!$trabajador->exist()) {
                $trabajador->save();
                $trabajadorDatos->save();
            //$trabajadorDatos->validate();
            //var_dump($trabajadorDatos->errors);
            //var_dump($_POST["idpersonadatoscrear"]) ;
                return "ok";
            //} else {
                //return "existe";
            //}
        //} else {
            //return "error";
        }
    }

    public function actionActualizarTrabajadorAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["idfuncionarioactualizar"]) || $_POST["fechahoraactualizar"] ) {
                $trabajador = Trabajador::findOne($_POST["idfuncionarioactualizar"]);
                $trabajador->IdPersona = $_POST["idpersonaactualizar"];
                $trabajador->CodigoSectorTrabajo = $_POST["codigosectortrabajoactualizar"];
                $trabajador->FechaIngreso = $_POST["fechaingresoactualizar"];
                $trabajador->FechaSalida = $_POST["fechasalidaactualizar"];
                $trabajador->FechaCalculoAntiguedad = $_POST["fechacalculoantiguedadactualizar"];
                $trabajador->AntiguedadExternaReconocida = $_POST["antiguedadexternareconocidaactualizar"];
                $trabajador->FechaCalculoVacaciones = $_POST["fechacalculovacacionesactualizar"];
                $trabajador->FechaFiniquito = $_POST["fechafiniquitoactualizar"];
                //$trabajador->CodigoEstadoFuncionario = 'V';
                //$trabajador->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;

                $trabajadorDatos = DatoPersonaFuncionario::findOne($_POST["fechahoraactualizar"]);
                $trabajadorDatos->IdPersona = rtrim($_POST["idpersonadatosactualizar"]);
                //$trabajadorDatos->FechaHoraActualizacion = getdate();
                $trabajadorDatos->CodigoAFP = $_POST["codigoafpactualizar"];
                $trabajadorDatos->ResolucionAFP = $_POST["resolucionafpactualizar"];
                $trabajadorDatos->FechaRegistroAFP = $_POST["fecharegistroafpactualizar"];
                $trabajadorDatos->PrimerMesRegistroAFP = $_POST["primermesregistroafpactualizar"];
                $trabajadorDatos->UltimoMesRegistroAFP = $_POST["ultimomesregistroafpactualizar"];
                $trabajadorDatos->ExclusionVoluntariaAFP = $_POST["exclusionvoluntariaafpactualizar"];
                $trabajadorDatos->NUA = $_POST["nuaactualizar"];
                $trabajadorDatos->CodigoSeguroSocial = $_POST["segurosocialactualizar"];
                $trabajadorDatos->CodigoBanco = $_POST["codigobancoactualizar"];
                $trabajadorDatos->NroCuentaBancaria = $_POST["nrocuentabancariaactualizar"];
                $trabajadorDatos->CodigoTipoRenta = $_POST["tiporentaactualizar"];
                $trabajador->save();
                $trabajadorDatos->save();
                return "ok";
            } else {
                return "error1";
            }
        } else {
            return "error";
        }
    }

    public function actionEliminarTrabajadorAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoeliminar"])) {
                $trabajador = Trabajador::findOne($_POST["codigoeliminar"]);
                //if (!$trabajador->isUsed()) {
                    $trabajador->delete();
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
    }

    /*public function actionGenerarCodigoTrabajadorAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["idpersona"])) {
                $codigoTrabajador = TrabajadoresDao::obtieneCodigoTrabajador($_POST["idpersona"], "dia");
                $trabajadorTemp = new Trabajador();
                $trabajadorTemp->CodigoTrabajador = $codigoTrabajador;
                if ($trabajadorTemp->exist()) {
                    $codigoTrabajador = TrabajadoresDao::obtieneCodigoTrabajador($_POST["idpersona"], "mes");
                }
                return $codigoTrabajador;
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }*/

}