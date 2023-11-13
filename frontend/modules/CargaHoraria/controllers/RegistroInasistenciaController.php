<?php

namespace app\modules\CargaHoraria\controllers;
use app\modules\CargaHoraria\models\CargaHorariaInasistenciasMesDao;
use app\modules\CargaHoraria\models\VCargaHorariaVigenteDao;
use common\models\CargaHorariaInasistenciaMes;
use common\models\TipoInasistencia;
use yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class RegistroInasistenciaController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['listar-docentes-director-ajax', 'index'],
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => [
                            'listar-docentes-director-ajax',
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
        if ($action->id == "listar-docentes-director-ajax")
            $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $listaTiposInasistencias = ArrayHelper::map(TipoInasistencia::find()->orderBy('NombreTipoInasistencia')->all(), 'CodigoTipoInasistencia', 'NombreTipoInasistencia');
        return $this->render('index', [
            'listaTiposInasistencias' => $listaTiposInasistencias
        ]);

    }
    public function actionListarDocentesDirectorAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $codigoUsuario = \Yii::$app->user->identity->CodigoUsuario;
            $docentesDirectorMes = VCargaHorariaVigenteDao::listaDocentesDirectorMes($codigoUsuario);
            $datosJson = '{"data": [';
            $cantidad = count($docentesDirectorMes);
            for ($i = 0; $i < $cantidad; $i++) {
                /*=============================================
                CREAR LAS ACCIONES
                =============================================*/
                $acciones = "<div class='btn-group'>";
                $acciones .= "<button class='btn btn-outline-info btnVerMateriasDocente' codigo='" . $docentesDirectorMes[$i]->IdPersona . "' nombrecompleto='" . $docentesDirectorMes[$i]->NombreCompleto . "' ><i class='fa fa-list' ></i></button>";
                $acciones .= "</div>";
                if ($i == $cantidad - 1) {
                    $datosJson .= '[
                  "' . ($i + 1) . '",
                  "' . $docentesDirectorMes[$i]->NombreCompleto . '",                           
                  "' . $acciones . '"
           ]';
                } else {
                    $datosJson .= '[
                  "' . ($i + 1) . '",
                "' . $docentesDirectorMes[$i]->NombreCompleto . '",                          
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
    public function actionListarMateriasDocenteAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $codigoUsuario = \Yii::$app->user->identity->CodigoUsuario;
            $contenido = "";
            if (isset($_POST["idpersona"])) {
                $materiasDocente = VCargaHorariaVigenteDao::mostrarMateriasDocente($codigoUsuario, $_POST["idpersona"]);
                $cantidad = count($materiasDocente);
                if ($cantidad == 0) {
                    $contenido .= "<tr> <td colspan='3' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                } else {
                    for ($i = 0; $i < $cantidad; $i++) {
                        $contenido .= "<tr >";
                        $contenido = $contenido . "<td><h6>" . ($i + 1) . "</h6></td>";
                        $contenido = $contenido . "<td>" .
                            '<b>' . 'Carrera : ' . '</b>' . $materiasDocente[$i]->NombreCarrera . '<br>' .
                            '<b>' . 'Sede: ' . '</b>' . $materiasDocente[$i]->NombreSedeAcad . '<br>' .
                            "</td>";
                        $contenido = $contenido . "<td>" .
                            '<b>' . 'Materia : ' . '</b>' . $materiasDocente[$i]->NombreMateria . '<br>' .
                            '<b>' . 'Plan de estudios : ' . '</b>' . $materiasDocente[$i]->NumeroPlanEstudios . '<br>' .
                            '<b>' . 'Sigla : ' . '</b>' . $materiasDocente[$i]->SiglaMateria . '<br>' .
                            '<b>' . 'Curso : ' . '</b>' . $materiasDocente[$i]->Curso . '<br>' .
                            "</td>";
                        $contenido = $contenido . "<td><h6>" . $materiasDocente[$i]->Grupo . "</h6></td>";
                        $contenido = $contenido . "<td><h6>" . $materiasDocente[$i]->HorasSemana . "</h6></td>";
                        $contenido = $contenido . "<td><h6>" . $materiasDocente[$i]->HorasMes . "</h6></td>";
                        $contenido = $contenido . "<td><h6>" . "<button class='btn btn-outline-info btnVerDetalleMateria' idpersona='" . $materiasDocente[$i]->IdPersona . "' carrera='" . $materiasDocente[$i]->NombreCarrera . "' curso='" . $materiasDocente[$i]->Curso . "' codigocarrera='" . $materiasDocente[$i]->CodigoCarrera . "' hs='" . $materiasDocente[$i]->HorasSemana . "' codigotrabajador='" . $materiasDocente[$i]->CodigoTrabajador . "' hm='" . $materiasDocente[$i]->HorasMes . "' materia='" . $materiasDocente[$i]->NombreMateria . "' siglamateria='" . $materiasDocente[$i]->SiglaMateria . "' codigosede='" . $materiasDocente[$i]->CodigoSedeAcad . "' sede='" . $materiasDocente[$i]->NombreSedeAcad . "' numeroplanestudios='" . $materiasDocente[$i]->NumeroPlanEstudios . "' grupo='" . $materiasDocente[$i]->Grupo . "' ><i class='fa fa-eye' ></i></button>" . "</h6></td>";
                        $contenido .= "</tr>";
                    }
                }
            } else {
                $contenido .= "<tr> <td colspan='4' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            }
            return $contenido;
        }
    }
    public function actionListarInasistenciasRegistradasAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $gestion = date("Y");
            $mes = date("m");
            $contenido = "";
            if ((isset($_POST["codigocarrera"])) && (isset($_POST["codigosedeacad"])) && (isset($_POST["numeroplanestudios"])) && (isset($_POST["siglamateria"])) && (isset($_POST["grupo"])) && (isset($_POST["codigotrabajador"]))) {
                $inasistencia = CargaHorariaInasistenciasMesDao::inasistenciasRegistradas($_POST["codigocarrera"],
                    $_POST["codigosedeacad"], $_POST["numeroplanestudios"], $_POST["siglamateria"], $_POST["grupo"], $gestion, $mes,
                    $_POST["codigotrabajador"]);
                $cantidad = count($inasistencia);
                if ($cantidad == 0) {
                    $contenido .= "<tr> <td colspan='3' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                } else {

                    for ($i = 0; $i < $cantidad; $i++) {
                        $fecha = date_format(date_create($inasistencia[$i]['Fecha']), 'd/m/Y');
                        $contenido .= "<tr >";
                        $contenido = $contenido . "<td><h6>" . ($i + 1) . "</h6></td>";
                        $contenido = $contenido . "<td><h6>" . $fecha . "</h6></td>";
                        $contenido = $contenido . "<td><h6>" . $inasistencia[$i]['Horas'] . "</h6></td>";
                        $contenido = $contenido . "<td><h6>" . $inasistencia[$i]['Grupo'] . "</h6></td>";
                        $contenido = $contenido . "<td><h6>" . $inasistencia[$i]['NombreTipoInasistencia'] . "</h6></td>";
                        $contenido = $contenido . "<td><h6>" . $inasistencia[$i]['Observacion'] . "</h6></td>";
                        $contenido = $contenido . "<td><h6>" . "<button class='btn btn-warning btnEditarInasistencia' codigocarrera='" . $inasistencia[$i]['CodigoCarrera'] . "' codigosedeacad='" . $inasistencia[$i]['CodigoSedeAcad'] . "' numeroplanestudios='" . $inasistencia[$i]['NumeroPlanEstudios'] . "' siglamateria='" . $inasistencia[$i]['SiglaMateria'] . "' Grupo='" . $inasistencia[$i]['Grupo'] . "' Gestion='" . $inasistencia[$i]['Gestion'] . "' mes='" . $inasistencia[$i]['Mes'] . "' codigotrabajador='" . $inasistencia[$i]['CodigoTrabajador'] . "' data-toggle='modal' data-target='#modalActualizarInasistencia'><i class='fa fa-pen'></i></button>
                                                       <button class='btn btn-danger btnEliminarInasistencia' codigocarrera='" . $inasistencia[$i]['CodigoCarrera'] . "' codigosedeacad='" . $inasistencia[$i]['CodigoSedeAcad'] . "' numeroplanestudios='" . $inasistencia[$i]['NumeroPlanEstudios'] . "' siglamateria='" . $inasistencia[$i]['SiglaMateria'] . "' Grupo='" . $inasistencia[$i]['Grupo'] . "' Gestion='" . $inasistencia[$i]['Gestion'] . "' mes='" . $inasistencia[$i]['Mes'] . "' codigotrabajador='" . $inasistencia[$i]['CodigoTrabajador'] . "'><i class='fa fa-times'></i></button>" . "</h6></td>";
                        $contenido .= "</tr>";
                    }
                }
            } else {
                $contenido .= "<tr> <td colspan='4' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            }
            return $contenido;
        }
    }
    public function actionCrearRegistroInasistenciaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if ((isset($_POST["codigocarrera"])) && (isset($_POST["codigosedeacad"])) && (isset($_POST["numeroplanestudios"])) && (isset($_POST["siglamateria"])) && (isset($_POST["grupo"])) && (isset($_POST["gestion"])) && (isset($_POST["mes"])) && (isset($_POST["codigotrabajador"])) && (isset($_POST["horasinasistencia"])) && (isset($_POST["horasmes"]))) {
                $horasInasistenciaRegistradas = CargaHorariaInasistenciasMesDao::validarHoras($_POST["codigocarrera"], $_POST["codigosedeacad"], $_POST["numeroplanestudios"], $_POST["siglamateria"], $_POST["grupo"], $_POST["gestion"], $_POST["mes"], $_POST["codigotrabajador"], $_POST["horasinasistencia"]);
                $horasTotales = $horasInasistenciaRegistradas + $_POST["horasinasistencia"];
                if ($horasTotales <= $_POST["horasmes"]) {
                    $inasistencia = new CargaHorariaInasistenciaMes();
                    $inasistencia->CodigoCarrera = $_POST["codigocarrera"];
                    $inasistencia->CodigoSedeAcad = $_POST["codigosedeacad"];
                    $inasistencia->NumeroPlanEstudios = $_POST["numeroplanestudios"];
                    $inasistencia->SiglaMateria = $_POST["siglamateria"];
                    $inasistencia->Grupo = $_POST["grupo"];
                    $inasistencia->Gestion = $_POST["gestion"];
                    $inasistencia->Mes = $_POST["mes"];
                    $inasistencia->CodigoTrabajador = $_POST["codigotrabajador"];
                    $inasistencia->Fecha = $_POST["fechainasistencia"];
                    $inasistencia->Horas = $_POST["horasinasistencia"];
                    $inasistencia->Observacion = $_POST["observaciones"];
                    $inasistencia->CodigoTipoInasistencia = $_POST["tipoinasistencia"];
                    $inasistencia->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;
                    if ($inasistencia->save()) {
                        return "ok";
                    } else {
                        return "error";
                    }
                } else {
                    return "Horas";
                }

            }
        }
    }
    public function actionEliminarInasistenciaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if ((isset($_POST["codigocarrera"])) && (isset($_POST["codigosedeacad"])) && (isset($_POST["numeroplanestudios"])) && (isset($_POST["siglamateria"])) && (isset($_POST["grupo"])) && (isset($_POST["gestion"])) && (isset($_POST["mes"])) && (isset($_POST["codigotrabajador"]))) {
                $inasistencia = CargaHorariaInasistenciaMes::find()->where(["CodigoCarrera" => $_POST["codigocarrera"]])
                    ->andWhere(["CodigoSedeAcad" => $_POST["codigosedeacad"]])
                    ->andWhere(["NumeroPlanEstudios" => $_POST["numeroplanestudios"]])
                    ->andWhere(["SiglaMateria" => $_POST["siglamateria"]])
                    ->andWhere(["Grupo" => $_POST["grupo"]])
                    ->andWhere(["Gestion" => $_POST["gestion"]])
                    ->andWhere(["Mes" => $_POST["mes"]])
                    ->andWhere(["CodigoTrabajador" => $_POST["codigotrabajador"]])
                    ->One();
                if ($inasistencia->delete()) {
                    return "ok";
                } else {
                    return "error";
                }
            } else {
                return "error";
            }
        }
    }
    public function actionBuscarInasistenciaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if ((isset($_POST["codigocarrera"])) && (isset($_POST["codigosedeacad"])) && (isset($_POST["numeroplanestudios"])) && (isset($_POST["siglamateria"])) && (isset($_POST["grupo"])) && (isset($_POST["gestion"])) && (isset($_POST["mes"])) && (isset($_POST["codigotrabajador"]))) {
                $inasistencia = CargaHorariaInasistenciasMesDao::buscaInasistencia("array", $_POST["codigocarrera"], $_POST["codigosedeacad"], $_POST["numeroplanestudios"],
                    $_POST["siglamateria"], $_POST["grupo"], $_POST["gestion"], $_POST["mes"], $_POST["codigotrabajador"]);
                return json_encode($inasistencia);
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }
    public function actionActualizarInasistenciaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if ((isset($_POST["codigocarrera"])) && (isset($_POST["codigosedeacad"])) && (isset($_POST["numeroplanestudios"])) && (isset($_POST["siglamateria"])) && (isset($_POST["grupo"])) && (isset($_POST["gestion"])) && (isset($_POST["mes"])) && (isset($_POST["codigotrabajador"]))) {
                $inasistencia = CargaHorariaInasistenciaMes::find()->where(["CodigoCarrera" => $_POST["codigocarrera"]])
                    ->andWhere(["CodigoSedeAcad" => $_POST["codigosedeacad"]])
                    ->andWhere(["NumeroPlanEstudios" => $_POST["numeroplanestudios"]])
                    ->andWhere(["SiglaMateria" => $_POST["siglamateria"]])
                    ->andWhere(["Grupo" => $_POST["grupo"]])
                    ->andWhere(["Gestion" => $_POST["gestion"]])
                    ->andWhere(["Mes" => $_POST["mes"]])
                    ->andWhere(["CodigoTrabajador" => $_POST["codigotrabajador"]])
                    ->One();
                $inasistencia->CodigoCarrera = $_POST["codigocarrera"];
                $inasistencia->CodigoSedeAcad = $_POST["codigosedeacad"];
                $inasistencia->NumeroPlanEstudios = $_POST["numeroplanestudios"];
                $inasistencia->SiglaMateria = $_POST["siglamateria"];
                $inasistencia->Grupo = $_POST["grupo"];
                $inasistencia->Gestion = $_POST["gestion"];
                $inasistencia->Mes = $_POST["mes"];
                $inasistencia->Fecha = $_POST["fecha"];
                $inasistencia->Horas = $_POST["horas"];
                $inasistencia->Observacion = $_POST["observacion"];
                $inasistencia->CodigoTrabajador = $_POST["codigotrabajador"];
                $inasistencia->CodigoTipoInasistencia = $_POST["codigotipoinasistencia"];
                if ($inasistencia->save()) {
                    return "ok";
                }
            } else {
                return "error";
            }
        }
    }
    public function actionVistaPreviaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $gestion = date("Y");
            $mes = date("m");
            $registros = "";
            if ((isset($_POST["codigocarrera"])) && (isset($_POST["codigosede"]))&& (isset($_POST["nombreCarrera"]))) {
                $codigoCarrera=$_POST["codigocarrera"];
                $codigoSede=$_POST["codigosede"];
                $nombreCarrera=$_POST["nombreCarrera"];
                $inasistencia = CargaHorariaInasistenciasMesDao::verInasistenciasRegistradas($_POST["codigocarrera"], $_POST["codigosede"], $gestion, $mes);
                $cantidad = count($inasistencia);
                if ($cantidad == 0) {
                    $registros .= "<tr> <td colspan='3' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                } else {
                    for ($i = 0; $i < $cantidad; $i++) {
                        $fecha = date_format(date_create($inasistencia[$i]['Fecha']), 'd/m/Y');
                        $registros .= "<tr >";
                        $registros = $registros . "<td><h6>" . ($i + 1) . "</h6></td>";
                        $registros = $registros . "<td><h6>" . $inasistencia[$i]['NombreCompleto'] . "</h6></td>";
                        $registros = $registros . "<td><h6>" . $inasistencia[$i]['SiglaMateria'] . "</h6></td>";
                        $registros = $registros . "<td><h6>" . $fecha . "</h6></td>";
                        $registros = $registros . "<td><h6>" . $inasistencia[$i]['Grupo'] . "</h6></td>";
                        $registros = $registros . "<td><h6>" . $inasistencia[$i]['Horas'] . "</h6></td>";
                        $registros = $registros . "<td><h6>" . $inasistencia[$i]['NombreTipoInasistencia'] . "</h6></td>";
                        $registros = $registros . "<td><h6>" . $inasistencia[$i]['Observacion'] . "</h6></td>";
                        $registros .= "</tr>";
                    }
                }
                $registros .= "<tr>";
                $registros .= "<td colspan='8' width='100%'align='center'>
                               
                <button id='btnVolver' class='btn btn-info btnVolver'>Ver Carreras</button>
                <a class='btn btn-danger' href='index.php?r=CargaHoraria/registro-inasistencia/inasistencia-mensual-reporte&carrera=$codigoCarrera&sede=$codigoSede' target='_blank'>Reporte</a>
                </td>";
                $registros .= "</tr>";
            } else {
                $registros .= "<tr> <td colspan='4' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            }
            return $registros;
        }
    }
   public function actionInasistenciaMensualReporte($carrera, $sede)
    {
            $gestion = date("Y");
            $mes = date("m");
            $idPersona = \Yii::$app->user->identity->IdPersona;
            $cargo=CargaHorariaInasistenciasMesDao::obtenerCargo($idPersona);
            $nombreCargo = $cargo['NombreCargo'];
            $inasistencia = CargaHorariaInasistenciasMesDao::verInasistenciasRegistradas($carrera, $sede, $gestion, $mes);
            $content = $this->renderPartial('informemensualpdf',
                    [
                        'informeInasistencias' => $inasistencia,
                        'cargo' => $nombreCargo
                    ]);
              $cabecera = $this->renderPartial('..\reportes\cabecera');
              $pie = $this->renderPartial('..\reportes\pie');
               $mpdf = new \Mpdf\Mpdf(
                    [
                        'mode' => 'utf-8',
                        'format' => [220, 280],
                        'setAutoTopMargin' => 'stretch',
                        'autoMarginPadding' => 2,
                    ]
                );
                $mpdf->SetHTMLHeader($cabecera);
                $mpdf->SetHTMLFooter($pie);
                $mpdf->WriteHTML($content);
                $mpdf->Output();
    }
}

