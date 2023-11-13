<?php

namespace app\modules\CargaHoraria\controllers;

use common\models\AgrupacionesMateriasDoc;
use common\models\CargaHorariaPropuesta;
use common\models\ConvocatoriaDocente;
use common\models\DetalleMateriasDoc;
use common\models\Estado;
use common\models\Idioma;
use common\models\PublicacionesDoc;
use common\models\SedeAcad;
use frontend\models\AcademicaDao;
use frontend\models\ConvocatoriasDocenteDao;
use yii\base\BaseObject;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\filters\AccessControl;
use Yii;

class ContratacionDocenteController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['llenar-sedes', 'index'],
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => [
                            'llenar-sedes',
                            'index',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id == "listar-convocatorias")
            $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }


    public function actionIndex()
    {
        $modelo = new ConvocatoriaDocente();
        return $this->render('convocatorias', ['modelo'=>$modelo]);
    }

    public function actionListarConvocatorias()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $filtro = $_POST["Filtro"];
            $convocatorias = ConvocatoriaDocente::find()->where(['CodigoEstado'=>$filtro,'CodigoUsuario'=>Yii::$app->user->identity->CodigoUsuario])->all();
            $datosJson = '{"data": [';
            $cantidad = count($convocatorias);
            for ($i = 0; $i < $cantidad; $i++) {
                /*=============================================
               REVISAR ESTADO
               =============================================*/
                if ($convocatorias[$i]->CodigoEstado == 'V') {
                    $colorEstado = "btn-success";
                    $textoEstado = "VIGENTE";
                    $estadoConvocatoria = "V";
                } else {
                    $colorEstado = "btn-danger";
                    $textoEstado = "NO VIGENTE";
                    $estadoConvocatoria = "C";
                }

                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                if ($filtro=='V')
                {
                    $acciones = "<div class='btn-group' style='horiz-align: center'>";
                    $acciones .= "<button class='btn btn-warning btnEditar' codigo='" . $convocatorias[$i]->CodigoConvocatoria . "' ><i class='fa fa-pen'></i></button>";
                    $acciones .= "<button class='btn btn-success btnAcefalias' codigo='" . $convocatorias[$i]->CodigoConvocatoria . "'><i class='fa fa-arrow-right'></i></button>";
                    $acciones .= "</div>";
                    $estado = "<button class='btn " . $colorEstado . " btn-xs btnEstado' estado='" . $estadoConvocatoria . "' codigo='" . $convocatorias[$i]->CodigoConvocatoria . "'>" . $textoEstado . "</button>";
                } else {
                    $acciones = "<div class='btn-group' style='horiz-align: center'>";
                    $acciones .= "</div>";
                    $estado = "<button class='btn " . $colorEstado . " btn-xs ' estado='" . $estadoConvocatoria . "' codigo='" . $convocatorias[$i]->CodigoConvocatoria . "'>" . $textoEstado . "</button>";
                }

                $tipo = '';
                switch ($convocatorias[$i]->TipoConvocatoria){
                    case "DCO":$tipo = 'Tipo convocatoria: Acefalias';break;
                    case "DSU":$tipo = 'Tipo convocatoria: Suplencias';break;
                }

                if ($i == $cantidad - 1) {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $convocatorias[$i]->GestionAcademica . '",
					 	"' . $tipo . '",
					 	"' . $convocatorias[$i]->NroCiteDireccion . '",
				      	"' . $convocatorias[$i]->Observaciones . '",
				      	"' . $estado . '",
				      	"' . $acciones . '"
  			  ]';
                } else {
                    $datosJson .= '[
					 	"' . ($i + 1) . '",
					 	"' . $convocatorias[$i]->GestionAcademica . '",
					 	"' . $tipo . '",
					 	"' . $convocatorias[$i]->NroCiteDireccion . '",
				      	"' . $convocatorias[$i]->Observaciones . '",
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

    public function actionGuardarConvocatoria()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost && isset($_POST['accion'])) {
            if ($_POST['accion'] == 'i')
            {
                $convocatoria = new ConvocatoriaDocente();

                $publicacion = new PublicacionesDoc();
                $publicacion->Gestion = 2022;
                $publicacion->CorrelativoGestion = 1;
                $publicacion->FechaPublicacion = date("d/m/Y");
                $publicacion->FechaHoraAperturaRecepcion = date("d/m/Y");
                $publicacion->FechaHoraCierreRecepcion = date("d/m/Y");
                $publicacion->Observaciones = '';
                $publicacion->CodigoEstado = 'V';
                $publicacion->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;
                $publicacion->save();
                $convocatoria->GestionAcademica = AcademicaDao::ObtenerGestionAcademica();
                $convocatoria->TipoConvocatoria = $_POST["tipoConvocatoria"];
                $convocatoria->NroCiteDireccion = $_POST["CiteDirector"];
                $convocatoria->Observaciones = $_POST["Observacion"];
                $convocatoria->CodigoPublicacion = $publicacion->CodigoPublicacion;
                $convocatoria->CodigoEstado = 'V';
                $convocatoria->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;
                if (!$convocatoria->exist()) {
                    if ($convocatoria->save())
                    {
                        return "ok";
                    } else
                    {
                        return "errorval";
                    }
                } else {
                    return "existe";
                }
            } else {
                $convocatoria = ConvocatoriaDocente::find()->where(['CodigoConvocatoria'=>$_POST['Codigo']])->one();
                if ($convocatoria){
                    $convocatoria->TipoConvocatoria = $_POST["tipoConvocatoria"];
                    $convocatoria->NroCiteDireccion = $_POST["CiteDirector"];
                    $convocatoria->Observaciones = $_POST["Observacion"];
                    $convocatoria->CodigoEstado = 'V';
                    $convocatoria->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;
                    if ($convocatoria->update()){
                        return 'ok';
                    } else {
                        return 'errorval';
                    }
                } else {
                    return 'errorload';
                }
            }
        } else {
            return "errorenvio";
        }

    }

    public function actionCambiarEstadoConvocatoriaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoConvocatoria"]) && $_POST["codigoConvocatoria"] != "") {
                $convocatoria = ConvocatoriaDocente::findOne($_POST["codigoConvocatoria"]);
                if ($convocatoria->CodigoEstado == "V") {
                    $convocatoria->CodigoEstado = "C";
                } else {
                    $convocatoria->CodigoEstado = "V";
                }
                $convocatoria->save();
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionBuscarConvocatoriaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigoConvocatoria"]) && $_POST["codigoConvocatoria"] != "") {
                $convocatoria =  ConvocatoriasDocenteDao::buscaConvocatoria("array", $_POST["codigoConvocatoria"]);
                return json_encode($convocatoria);
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionIrAcefalias($codigo)
    {
        return $this->render('acefalias',['codigo'=>$codigo]);
    }

    public function actionListarMaterias()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $Codigo = $_POST["Codigo"];
            $convocatoria = ConvocatoriaDocente::find()->where(['CodigoConvocatoria'=>$Codigo])->one();
            if($convocatoria){
                if ($convocatoria->TipoConvocatoria ==='DCO'){
                    $rows = AcademicaDao::ListarMateriasAcefalias(\Yii::$app->user->identity->CodigoUsuario);
                } else
                {
                    $rows = AcademicaDao::ListarMateriasSuplencias(AcademicaDao::ObtenerGestionAcademica(),\Yii::$app->user->identity->Carreras);
                }
            }
            $datosJson = '{"data": [';
            $i=0;
            $length = count($rows);
            foreach ($rows as $row){
                $i++;
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                $acciones = "<div class='btn-group' style='horiz-align: center'>";
                $acciones .= "<input type='checkbox' hidden id='".$i."'  convocatoria = '".$convocatoria->CodigoConvocatoria."' materia='".$row['SiglaMateria']."' carrera='".$row['CodigoCarrera']."' sede = '".$row['CodigoSede']."' grupo = '".$row['Grupo']."' tipogrupo = '".$row['CodigoTipoGrupo']."' horas = '".$row['TotalHoras']."' plan = '".$row['NumeroPlanEstudios']."' class='btn-check chk'  autocomplete='off'>";
                $acciones .= "</div>";

                $Tipo = ($row['CodigoTipoGrupo'] === 'P')?'Practica':($row['CodigoTipoGrupo'] === 'L')?'Laboratorio':'Teoria';
                $datosJson .= '[
					 	"' . ($i) . '",
					 	"' . $row['NombreCarrera'] . '",
					 	"' . $row['NombreSede'] . '",
					 	"' . $row['NumeroPlanEstudios'] . '",
					 	"' . $row['SiglaMateria'] . '",
				      	"' . $row['NombreMateria'] . '",
				      	"' . $row['Curso'] . '",
				      	"' . $row['Grupo']. '",
				      	"' . $Tipo . '",
				      	"' . $row['HorasTeoria'] . '",
				      	"' . $row['HorasPractica'] . '",
				      	"' . $row['HorasLaboratorio'] . '",
				      	"' . $row['TotalHoras'] . $acciones .'",
				      	"' . '' . '"
  			    ]';
                if($i !== $length){
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

    public function actionRegistroMateriasAgrupacionAjax(){
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost && isset($_POST['accion'])) {
            $convocatoria = $_POST['convocatoria'];
            $materia = $_POST['materia'];
            $carrera = $_POST['carrera'];
            $plan = $_POST['plan'];
            $sede = $_POST['sede'];
            $grupo = $_POST['grupo'];
            $tipogrupo = $_POST['tipogrupo'];
            $horas = $_POST['horas'];

            if (boolval($_POST['accion'])){
                $agrupacion = AgrupacionesMateriasDoc::find()->where(['CodigoConvocatoria'=>$convocatoria,'CodigoSede'=>$sede,'CodigoCarrera'=>$carrera,'NumeroPlanEstudios'=>$plan,'SiglaMateria'=>$materia])->one();
                if ($agrupacion)
                {

                } else {
                    $nAgrupacion = new AgrupacionesMateriasDoc();
                    $nAgrupacion->CodigoConvocatoria = $convocatoria;
                    $nAgrupacion->CodigoSede = $sede;
                    $nAgrupacion->CodigoCarrera = $carrera;
                    $nAgrupacion->NumeroPlanEstudios = $plan;
                    $nAgrupacion->SiglaMateria = $materia;
                    $nAgrupacion->Agrupacion = 0;
                    $nAgrupacion->Evalua = 1;
                    $nAgrupacion->CodigoPerfilProfesional = 1;
                    $nAgrupacion->CodigoEstado = 'V';
                    $nAgrupacion->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;

                    $nDetalle = new DetalleMateriasDoc();
                    $nDetalle->CodigoConvocatoria = $convocatoria;
                    $nDetalle->CodigoSede = $sede;
                    $nDetalle->CodigoCarrera = $carrera;
                    $nDetalle->NumeroPlanEstudios = $plan;
                    $nDetalle->SiglaMateria = $materia;
                    $nDetalle->Grupo =  7; //$grupo;
                    $nDetalle->TipoGrupo = $tipogrupo;
                    $nDetalle->HorasSemana = floor($horas/4);
                    $nDetalle->GrupoDetalle = 0;
                    $nDetalle->IdPersona = 'ACE0001';
                    $nDetalle->CodigoEstado = 'V';
                    $nDetalle->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;


                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        $isValid = $nAgrupacion->validate();
                        if($isValid){
                            if ($nAgrupacion->save()) {
                                $isValid = $nDetalle->validate();
                                if($isValid){
                                    if ($nDetalle->save()) {
                                        $transaction->commit();
                                        return 'ok';
                                    } else {
                                        $transaction->rollBack();
                                        return 'ErrorID';
                                    }
                                } else {
                                    $transaction->rollBack();
                                    return var_dump($nDetalle->errors);
                                }
                            } else {
                                $transaction->rollBack();
                                return 'ErrorIA';
                            }
                        } else {
                            $transaction->rollBack();
                            return var_dump($nAgrupacion->errors);
                        }

                    } catch (\Exception $e) {
                        $transaction->rollBack();
                        return 'Errores1';
                    } catch (\Throwable $e) {
                        $transaction->rollBack();
                        return 'Errores2';
                    }
                }
            } else {
                $agrupacion = AgrupacionesMateriasDoc::find()->where(['CodigoConvocatoria'=>$convocatoria,'CodigoSede'=>$sede,'CodigoCarrera'=>$carrera,'NumeroPlanEstudios'=>$plan,'SiglaMateria'=>$materia])->one();
                $detalle = DetalleMateriasDoc::find()->where(['CodigoConvocatoria'=>$convocatoria,'CodigoSede'=>$sede,'CodigoCarrera'=>$carrera,'NumeroPlanEstudios'=>$plan,'SiglaMateria'=>$materia,'grupo'=>$grupo,'TipoGrupo'=>$tipogrupo])->one();

                if ($detalle){
                    if ($detalle->delete()){
                        return 'ok';
                    } else {
                        return 'ErrorDD';
                    }
                } else {
                    if ($agrupacion){
                        if ($agrupacion->delete()){
                            return 'ok';
                        } else {
                            return 'ErrorDA';
                        }
                    } else {
                        return 'pos no';
                    }
                }
            }
        }
        else
        {
            return 'ErrorE';
        }
    }

}



