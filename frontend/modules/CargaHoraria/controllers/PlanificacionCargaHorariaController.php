<?php

namespace app\modules\CargaHoraria\controllers;

use app\modules\CargaHoraria\models\AcademicaDao;
use app\modules\CargaHoraria\models\ComparativasActualPropuestaDao;
use app\modules\CargaHoraria\models\CargaHorariaPlanificacionDao;
use app\modules\CargaHoraria\models\CargaHorariaActualDao;
use common\models\CargaHoraria;
use common\models\CargaHorariaConfiguracion;
use common\models\DetalleCargaHoraria;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use Yii;

class PlanificacionCargaHorariaController extends Controller
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

    public function actionIndex()
    {
        $codigoUsuario = \Yii::$app->user->identity->CodigoUsuario;
        $listaFacultades = AcademicaDao::listaFacultadesUsuario($codigoUsuario);
        $listaCarreras = AcademicaDao::listaCarrerasUsuario($codigoUsuario);
        $codigoCarrera = $listaCarreras[0]->CodigoCarrera;
        $listaSedes = AcademicaDao::listaSedesCarrera($codigoCarrera);
        $codigoSede = $listaSedes[0]->CodigoSede;
        $nombreSede = $listaSedes[0]->NombreSede;
        $cantidadFacultades = count($listaFacultades);
        $cantidadCarreras = count($listaCarreras);
        $cantidadSedes = count($listaSedes);
        $estadoPlanificacion = AcademicaDao::buscaCargaHorariaConfiguracion("obj", $codigoCarrera, $codigoSede);
        $codigoEstadoPlanificiacion = $estadoPlanificacion->CodigoEstadoPlanificacion;
        if ($cantidadFacultades == 1) {
            $codigoFacultad = $listaFacultades[0]->CodigoFacultad;
            $nombreFacultad = $listaFacultades[0]->NombreFacultad;
            $listaCarreras = AcademicaDao::listaCarrerasUsuario($codigoUsuario);
            $cantidadCarreras = count($listaCarreras);
            if ($cantidadCarreras == 1) {
                $listaCarreras = AcademicaDao::listaCarrerasUsuario($codigoUsuario);
                $codigoCarrera = $listaCarreras[0]->CodigoCarrera;
                $nombreCarrera = $listaCarreras[0]->NombreCarrera;
                $listaSedes = AcademicaDao::listaSedesCarrera($codigoCarrera);
                $cantidadSedes = count($listaSedes);
                if ($cantidadSedes == 1) {
                    $listaSedes = AcademicaDao::listaSedesCarrera($codigoCarrera);
                    $cantidadSedes = count($listaSedes);
                    $codigoSede = $listaSedes[0]->CodigoSede;
                    $nombreSede = $listaSedes[0]->NombreSede;
                } else {
                    return $this->render('planificacioncargahoraria', [
                        'cantidadFacultades' => $cantidadFacultades,
                        'codigoFacultad' => $codigoFacultad,
                        'nombreFacultad' => $nombreFacultad,
                        'cantidadCarreras' => $cantidadCarreras,
                        'codigoCarrera' => $codigoCarrera,
                        'nombreCarrera' => $nombreCarrera,
                        'cantidadSedes' => $cantidadSedes,
                        'codigoSede' => $codigoSede,
                        'nombreSede' => $nombreSede,
                        'codigoEstadoPlanificacion' => $codigoEstadoPlanificiacion,
                        'codigoUsuario' => $codigoUsuario,
                    ]);
                }
                return $this->render('planificacioncargahoraria', [
                    'cantidadFacultades' => $cantidadFacultades,
                    'codigoFacultad' => $codigoFacultad,
                    'nombreFacultad' => $nombreFacultad,
                    'cantidadCarreras' => $cantidadCarreras,
                    'codigoCarrera' => $codigoCarrera,
                    'nombreCarrera' => $nombreCarrera,
                    'cantidadSedes' => $cantidadSedes,
                    'codigoSede' => $codigoSede,
                    'nombreSede' => $nombreSede,
                    'codigoEstadoPlanificacion' => $codigoEstadoPlanificiacion,
                    'codigoUsuario' => $codigoUsuario,
                ]);
            } else {
                $listaCarreras = AcademicaDao::listaCarrerasFacultad($codigoFacultad);
                return $this->render('planificacioncargahoraria', [
                    'cantidadFacultades' => $cantidadFacultades,
                    'codigoFacultad' => $codigoFacultad,
                    'nombreFacultad' => $nombreFacultad,
                    'listaCarreras' => $listaCarreras,
                    'cantidadCarreras' => $cantidadCarreras,
                    'codigoCarrera' => $codigoCarrera,
                    'cantidadSedes' => $cantidadSedes,
                    'codigoSede' => $codigoSede,
                    'nombreSede' => $nombreSede,
                    'codigoEstadoPlanificacion' => $codigoEstadoPlanificiacion,
                    'codigoUsuario' => $codigoUsuario,
                    //'nombreCarrera' => $nombreCarrera,
                ]);
            }
        } else {
            $listaFacultades = ArrayHelper::map(AcademicaDao::listaFacultadesUsuario($codigoUsuario), 'CodigoFacultad', 'NombreFacultad');
            return $this->render('planificacioncargahoraria', [
                'cantidadFacultades' => $cantidadFacultades,
                'facultades' => $listaFacultades,
                'cantidadCarreras' => $cantidadCarreras,
                'cantidadSedes' => $cantidadSedes,
                'nombreSede' => $nombreSede,
                'codigoSede' => $codigoSede,
                'codigoEstadoPlanificacion' => $codigoEstadoPlanificiacion,
                'codigoUsuario' => $codigoUsuario,
            ]);
        }
    }

    public function actionListarCarrerasAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $opciones = "<option value=''>Selecionar Carrera</option>";
            $codigoFacultad = $_POST["codigofacultad"];
            $carreras = AcademicaDao::listaCarrerasFacultad($codigoFacultad);
            foreach ($carreras as $carrera) {
                $opciones .= "<option value='" . $carrera->CodigoCarrera . "'>" . $carrera->NombreCarrera . "</option>";
            }
            return $opciones;
        }
    }

    public function actionListarCarrerasUsuarioAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $opciones = "<option value=''>Selecionar Carrera</option>";
            $codigoUsuario = \Yii::$app->user->identity->CodigoUsuario;
            $carreras = AcademicaDao::listaCarrerasUsuario($codigoUsuario);
            foreach ($carreras as $carrera) {
                $opciones .= "<option value='" . $carrera->CodigoCarrera . "'>" . $carrera->NombreCarrera . "</option>";
            }
            return $opciones;
        }
    }

    public function actionListarSedesAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $opciones = "<option value=''>Selecionar Sede</option>";
            $codigoCarrera = $_POST["codigocarrera"];
            $sedes = AcademicaDao::listaSedesCarrera($codigoCarrera);
            foreach ($sedes as $sede) {
                $opciones .= "<option value='" . $sede->CodigoSede . "' valueacad='" . $sede->CodigoSede . "'>" . $sede->NombreSede . "</option>";
            }
            return $opciones;
        }
    }

    public function actionListarPlanesEstudiosAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $opciones = "<option value=''>Selecionar Plan</option>";
            $codigoCarrera = $_POST["codigocarrera"];
            $planesEstudios = AcademicaDao::listaPlanesEstudioCarrera($codigoCarrera);
            foreach ($planesEstudios as $planEstudio) {
                $opciones .= "<option value='" . $planEstudio->NumeroPlanEstudios . "'>" . $planEstudio->NumeroPlanEstudios . "</option>";
            }
            return $opciones;
        }
    }

    public function actionListarCursosAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $opciones = "<option value=''>Selecionar Curso</option>";
            $codigoCarrera = $_POST["codigocarrera"];
            $numeroPlanEstudios = $_POST["numeroplanestudios"];
            $listaSedes = AcademicaDao::listaSedesCarrera($codigoCarrera);
            $codigoSede = $listaSedes[0]->CodigoSede;
            $cursos = AcademicaDao::listaCursos($codigoCarrera, $numeroPlanEstudios);
            foreach ($cursos as $curso) {
                $opciones .= "<option value='" . $curso->Curso . "'>" . $curso->Curso . "</option>";
            }
            return $opciones;
        }
    }

    public function actionListarMateriasAjax()
    {
        $contenido = "";
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigocarrera"]) && isset($_POST["numeroplanestudios"]) && isset($_POST["codigosede"]) && isset($_POST["codigosedeacad"]) && isset($_POST["curso"])) {
                $materias = AcademicaDao::listaMateriasCursoProyectados($_POST["codigocarrera"], $_POST["codigosede"], $_POST["codigosedeacad"], $_POST["numeroplanestudios"], $_POST["curso"]);
                $cantidad = count($materias);
                if ($cantidad == 0) {
                    $contenido .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                } else {
                    $totalCursoActual = 0;
                    $totalCursoAnterior = 0;
                    for ($i = 0; $i < $cantidad; $i++) {
                        $sigla = "<a href='#' class='lnkHorasPlan' codigocarrera='" . $materias[$i]->CodigoCarrera . "' nombrecarrera='" . $materias[$i]->NombreCarrera . "' numeroplanestudios='" . $materias[$i]->NumeroPlanEstudios . "' siglamateria='" . $materias[$i]->SiglaMateria . "' nombremateria='" . $materias[$i]->NombreMateria . "' hrsteoria='" . $materias[$i]->HorasTeoria . "' hrspractica='" . $materias[$i]->HorasPractica . "' hrslaboratorio='" . $materias[$i]->HorasLaboratorio . "' data-toggle='modal' data-target='#modalHorasPlanEstudios'>" . $materias[$i]->SiglaMateria . "</a>";
                        $nombreMateria = "<a href='#' class='lnkDocentesMateriaResumenActual' codigocarrera='" . $materias[$i]->CodigoCarrera . "' nombrecarrera='" . $materias[$i]->NombreCarrera . "' numeroplanestudios='" . $materias[$i]->NumeroPlanEstudios . "'siglamateria='" . $materias[$i]->SiglaMateria . "' nombremateria='" . $materias[$i]->NombreMateria . "' data-toggle='modal' data-target='#modalDocentesMateriaResumenActual'>" . $materias[$i]->NombreMateria . "</a>";
                        $numeroEstudiantesAnterior = "<a href='#' class='lnkDocentesMateriaResumenAnterior' codigocarrera='" . $materias[$i]->CodigoCarrera . "' nombrecarrera='" . $materias[$i]->NombreCarrera . "' numeroplanestudios='" . $materias[$i]->NumeroPlanEstudios . "'siglamateria='" . $materias[$i]->SiglaMateria . "' nombremateria='" . $materias[$i]->NombreMateria . "' data-toggle='modal' data-target='#modalDocentesMateriaResumenAnterior'>" . $materias[$i]->NumEstAnterior . "</a>";
                        $gruposTeoriaAnterior = "<a href='#' class='lnkMateriasDocentesAcadAnterior' codigocarrera='" . $materias[$i]->CodigoCarrera . "' nombrecarrera='" . $materias[$i]->NombreCarrera . "' numeroplanestudios='" . $materias[$i]->NumeroPlanEstudios . "'siglamateria='" . $materias[$i]->SiglaMateria . "' nombremateria='" . $materias[$i]->NombreMateria . "' tipogrupo='T' tipogrupoliteral='TEORIA' data-toggle='modal' data-target='#modalMateriasDocentesAcadAnterior'>" . $materias[$i]->CantGrpsTeoriaAnterior . "</a>";
                        $gruposPracticaAnterior = "<a href='#' class='lnkMateriasDocentesAcadAnterior' codigocarrera='" . $materias[$i]->CodigoCarrera . "' nombrecarrera='" . $materias[$i]->NombreCarrera . "' numeroplanestudios='" . $materias[$i]->NumeroPlanEstudios . "'siglamateria='" . $materias[$i]->SiglaMateria . "' nombremateria='" . $materias[$i]->NombreMateria . "' tipogrupo='P' tipogrupoliteral='PRACTICA' data-toggle='modal' data-target='#modalMateriasDocentesAcadAnterior'>" . $materias[$i]->CantGrpsPracticaAnterior . "</a>";
                        $gruposLaboratorioAnterior = "<a href='#' class='lnkMateriasDocentesAcadAnterior' codigocarrera='" . $materias[$i]->CodigoCarrera . "' nombrecarrera='" . $materias[$i]->NombreCarrera . "' numeroplanestudios='" . $materias[$i]->NumeroPlanEstudios . "'siglamateria='" . $materias[$i]->SiglaMateria . "' nombremateria='" . $materias[$i]->NombreMateria . "' tipogrupo='L' tipogrupoliteral='LABORATORIO' data-toggle='modal' data-target='#modalMateriasDocentesAcadAnterior'>" . $materias[$i]->CantGrpsLaboratorioAnterior . "</a>";
                        $numeroEstudiantesActual = "<a href='#' class='lnkDocentesMateriaResumenActual' codigocarrera='" . $materias[$i]->CodigoCarrera . "' nombrecarrera='" . $materias[$i]->NombreCarrera . "' numeroplanestudios='" . $materias[$i]->NumeroPlanEstudios . "'siglamateria='" . $materias[$i]->SiglaMateria . "' nombremateria='" . $materias[$i]->NombreMateria . "' data-toggle='modal' data-target='#modalDocentesMateriaResumenActual'>" . $materias[$i]->NumEstActual . "</a>";
                        $gruposTeoriaActual = "<a href='#' class='lnkMateriasDocentesAcadActual' codigocarrera='" . $materias[$i]->CodigoCarrera . "' nombrecarrera='" . $materias[$i]->NombreCarrera . "' numeroplanestudios='" . $materias[$i]->NumeroPlanEstudios . "'siglamateria='" . $materias[$i]->SiglaMateria . "' nombremateria='" . $materias[$i]->NombreMateria . "' tipogrupo='T' tipogrupoliteral='TEORIA' data-toggle='modal' data-target='#modalMateriasDocentesAcadActual'>" . $materias[$i]->CantGrpsTeoriaActual . "</a>";
                        $gruposPracticaActual = "<a href='#' class='lnkMateriasDocentesAcadActual' codigocarrera='" . $materias[$i]->CodigoCarrera . "' nombrecarrera='" . $materias[$i]->NombreCarrera . "' numeroplanestudios='" . $materias[$i]->NumeroPlanEstudios . "'siglamateria='" . $materias[$i]->SiglaMateria . "' nombremateria='" . $materias[$i]->NombreMateria . "' tipogrupo='P' tipogrupoliteral='PRACTICA' data-toggle='modal' data-target='#modalMateriasDocentesAcadActual'>" . $materias[$i]->CantGrpsPracticaActual . "</a>";
                        $gruposLaboratorioActual = "<a href='#' class='lnkMateriasDocentesAcadActual' codigocarrera='" . $materias[$i]->CodigoCarrera . "' nombrecarrera='" . $materias[$i]->NombreCarrera . "' numeroplanestudios='" . $materias[$i]->NumeroPlanEstudios . "'siglamateria='" . $materias[$i]->SiglaMateria . "' nombremateria='" . $materias[$i]->NombreMateria . "' tipogrupo='L' tipogrupoliteral='LABORATORIO' data-toggle='modal' data-target='#modalMateriasDocentesAcadActual'>" . $materias[$i]->CantGrpsLaboratorioActual . "</a>";

                        if ($materias[$i]->CantGrpsTeoriaAnterior > 0) {
                            $estudiantesTeoriaAnterior = round($materias[$i]->NumEstAnterior / $materias[$i]->CantGrpsTeoriaAnterior, 0);
                            $totalCursoAnterior += $materias[$i]->CantGrpsTeoriaAnterior * $materias[$i]->HorasTeoria * 4;
                        } else {
                            $estudiantesTeoriaAnterior = 0;
                        }
                        if ($materias[$i]->CantGrpsPracticaAnterior > 0) {
                            $estudiantesPracticaAnterior = round($materias[$i]->NumEstAnterior / $materias[$i]->CantGrpsPracticaAnterior, 0);
                            $totalCursoAnterior += $materias[$i]->CantGrpsPracticaAnterior * $materias[$i]->HorasPractica * 4;
                        } else {
                            $estudiantesPracticaAnterior = 0;
                        }
                        if ($materias[$i]->CantGrpsLaboratorioAnterior > 0) {
                            $estudiantesLaboratorioAnterior = round($materias[$i]->NumEstAnterior / $materias[$i]->CantGrpsLaboratorioAnterior, 0);
                            $totalCursoAnterior += $materias[$i]->CantGrpsLaboratorioAnterior * $materias[$i]->HorasLaboratorio * 4;
                        } else {
                            $estudiantesLaboratorioAnterior = 0;
                        }

                        if ($materias[$i]->CantGrpsTeoriaActual > 0) {
                            $estudiantesTeoriaActual = round($materias[$i]->NumEstActual / $materias[$i]->CantGrpsTeoriaActual, 0);
                            $totalCursoActual += $materias[$i]->CantGrpsTeoriaActual * $materias[$i]->HorasTeoria * 4;
                        } else {
                            $estudiantesTeoriaActual = 0;
                        }
                        if ($materias[$i]->CantGrpsPracticaActual > 0) {
                            $estudiantesPracticaActual = round($materias[$i]->NumEstActual / $materias[$i]->CantGrpsPracticaActual, 0);
                            $totalCursoActual += $materias[$i]->CantGrpsPracticaActual * $materias[$i]->HorasPractica * 4;
                        } else {
                            $estudiantesPracticaActual = 0;
                        }
                        if ($materias[$i]->CantGrpsLaboratorioActual > 0) {
                            $estudiantesLaboratorioActual = round($materias[$i]->NumEstActual / $materias[$i]->CantGrpsLaboratorioActual, 0);
                            $totalCursoActual += $materias[$i]->CantGrpsLaboratorioActual * $materias[$i]->HorasLaboratorio * 4;
                        } else {
                            $estudiantesLaboratorioActual = 0;
                        }

                        $acciones = "<td><center>";
                        $acciones .= "<button class='btn btn-success btnNuevo' codigocarrera='" . $materias[$i]->CodigoCarrera . "' nombrecarrera='" . $materias[$i]->NombreCarrera . "' numeroplanestudios='" . $materias[$i]->NumeroPlanEstudios . "' siglamateria='" . $materias[$i]->SiglaMateria . "' nombremateria='" . $materias[$i]->NombreMateria . "' hrsteoria='" . $materias[$i]->HorasTeoria . "' hrspractica='" . $materias[$i]->HorasPractica . "' hrslaboratorio='" . $materias[$i]->HorasLaboratorio . "' data-toggle='modal' data-target='#modalNuevaPlanificacion'><i class='fa fa-plus'></i></button>";
                        $acciones .= "<button class='btn btn-warning btnEditar' codigocarrera='" . $materias[$i]->CodigoCarrera . "' nombrecarrera='" . $materias[$i]->NombreCarrera . "' numeroplanestudios='" . $materias[$i]->NumeroPlanEstudios . "' siglamateria='" . $materias[$i]->SiglaMateria . "' nombremateria='" . $materias[$i]->NombreMateria . "' data-toggle='modal' data-target='#modalModificarPlanificacion'><i class='fa fa-pen'></i></button>";
                        $acciones .= "</center></td>";
                        $contenido .= "<tr siglamateria = '" . $materias[$i]->SiglaMateria . "'>";
                        $contenido = $contenido . "<td><h5>" . $sigla . "</h5></td>";
                        $contenido = $contenido . "<td><h5>" . $nombreMateria . "</h5></td>";
                        $contenido = $contenido . "<td><h5>" . $numeroEstudiantesAnterior . "</h5></td>";
                        $contenido = $contenido . "<td><h5>" . $gruposTeoriaAnterior . "</h5></td>";
                        $contenido = $contenido . "<td><h5>" . $estudiantesTeoriaAnterior . "</h5></td>";
                        $contenido = $contenido . "<td><h5>" . $gruposPracticaAnterior . "</h5></td>";
                        $contenido = $contenido . "<td><h5>" . $estudiantesPracticaAnterior . "</h5></td>";
                        $contenido = $contenido . "<td><h5>" . $gruposLaboratorioAnterior . "</h5></td>";
                        $contenido = $contenido . "<td><h5>" . $estudiantesLaboratorioAnterior . "</h5></td>";
                        $contenido = $contenido . "<td><h5>" . $numeroEstudiantesActual . "</h5></td>";
                        $contenido = $contenido . "<td><h5>" . $gruposTeoriaActual . "</h5></td>";
                        $contenido = $contenido . "<td><h5>" . $estudiantesTeoriaActual . "</h5></td>";
                        $contenido = $contenido . "<td><h5>" . $gruposPracticaActual . "</h5></td>";
                        $contenido = $contenido . "<td><h5>" . $estudiantesPracticaActual . "</h5></td>";
                        $contenido = $contenido . "<td><h5>" . $gruposLaboratorioActual . "</h5></td>";
                        $contenido = $contenido . "<td><h5>" . $estudiantesLaboratorioActual . "</h5></td>";
                        $contenido .= $acciones;
                        $contenido .= "</tr>";
                    }
                    $contenido .= "<tr>";
                    $contenido .= "<td colspan='2' style='text-align: right; font-weight: bold;'>TOTALES--></td>";
                    $contenido .= "<td colspan='7' style='text-align: center; font-weight: bold;'>" . $totalCursoAnterior . " Horas Mes</td>";
                    $contenido .= "<td colspan='7' style='text-align: center; font-weight: bold;'>" . $totalCursoActual . " Horas Mes</td>";
                    $contenido .= "</tr>";
                }
            } else {
                $contenido .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            }
            return $contenido;
        } else {
            $contenido .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            return $contenido;
        }
    }

    public function actionListarDocentesMateriaResumenActualAjax()
    {
        $contenido = "";
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigocarrera"]) && isset($_POST["codigosede"]) && isset($_POST["numeroplanestudios"]) && isset($_POST["siglamateria"])) {
                $docentes = AcademicaDao::listaDocentesMateria($_POST["codigocarrera"], $_POST["codigosede"], $_POST["numeroplanestudios"], $_POST["siglamateria"]);
                $cantidad = count($docentes);
                if ($cantidad == 0) {
                    $contenido .= "<tr> <td colspan='11' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                } else {
                    for ($i = 0; $i < $cantidad; $i++) {
                        $contenido .= "<tr>";
                        $contenido = $contenido . "<td>" . ($i + 1) . "</td>";
                        $contenido = $contenido . "<td>" . $docentes[$i]->IdPersona . "</td>";
                        $contenido = $contenido . "<td>" . $docentes[$i]->NombreCompleto . "</td>";
                        $contenido = $contenido . "<td>" . $docentes[$i]->CondicionLaboral . "</td>";
                        $contenido = $contenido . "<td style='text-align: right;'>" . $docentes[$i]->CantGrpsTeoria . "</td>";
                        $contenido = $contenido . "<td style='text-align: right;'>" . $docentes[$i]->CantGrpsPractica . "</td>";
                        $contenido = $contenido . "<td style='text-align: right;'>" . $docentes[$i]->CantGrpsLaboratorio . "</td>";
                        $contenido = $contenido . "<td style='text-align: right;'>" . $docentes[$i]->HorasMesTeoria . "</td>";
                        $contenido = $contenido . "<td style='text-align: right;'>" . $docentes[$i]->HorasMesPractica . "</td>";
                        $contenido = $contenido . "<td style='text-align: right;'>" . $docentes[$i]->HorasMesLaboratorio . "</td>";
                        $contenido = $contenido . "<td style='text-align: right; font-weight: bold;'>" . $docentes[$i]->TotalHorasMes . "</td>";
                        $contenido .= "</tr>";
                    }
                }
            } else {
                $contenido .= "<tr> <td colspan='11' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            }
            return $contenido;
        } else {
            $contenido .= "<tr> <td colspan='11' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            return $contenido;
        }
    }

    public function actionListarDocentesMateriaResumenAnteriorAjax()
    {
        $contenido = "";
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigocarrera"]) && isset($_POST["codigosede"]) && isset($_POST["numeroplanestudios"]) && isset($_POST["siglamateria"]) /*&& isset($_POST["gestionanterior"]) && isset($_POST["mesanterior"])*/) {
                //$docentes = AcademicaDao::listaDocentesMateriaAnterior($_POST["codigocarrera"], $_POST["codigosede"], $_POST["numeroplanestudios"], $_POST["siglamateria"]/*, $_POST["gestionanterior"], $_POST["mesanterior"]*/);
                $docentes = AcademicaDao::listaDocentesMateria($_POST["codigocarrera"], $_POST["codigosede"], $_POST["numeroplanestudios"], $_POST["siglamateria"]/*, $_POST["gestionanterior"], $_POST["mesanterior"]*/);
                $cantidad = count($docentes);
                if ($cantidad == 0) {
                    $contenido .= "<tr> <td colspan='11' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                } else {
                    for ($i = 0; $i < $cantidad; $i++) {
                        $contenido .= "<tr>";
                        $contenido = $contenido . "<td>" . ($i + 1) . "</td>";
                        $contenido = $contenido . "<td>" . $docentes[$i]->IdPersona . "</td>";
                        $contenido = $contenido . "<td>" . $docentes[$i]->NombreCompleto . "</td>";
                        $contenido = $contenido . "<td>" . $docentes[$i]->CondicionLaboral . "</td>";
                        $contenido = $contenido . "<td style='text-align: right;'>" . $docentes[$i]->CantGrpsTeoria . "</td>";
                        $contenido = $contenido . "<td style='text-align: right;'>" . $docentes[$i]->CantGrpsPractica . "</td>";
                        $contenido = $contenido . "<td style='text-align: right;'>" . $docentes[$i]->CantGrpsLaboratorio . "</td>";
                        $contenido = $contenido . "<td style='text-align: right;'>" . $docentes[$i]->HorasMesTeoria . "</td>";
                        $contenido = $contenido . "<td style='text-align: right;'>" . $docentes[$i]->HorasMesPractica . "</td>";
                        $contenido = $contenido . "<td style='text-align: right;'>" . $docentes[$i]->HorasMesLaboratorio . "</td>";
                        $contenido = $contenido . "<td style='text-align: right; font-weight: bold;'>" . $docentes[$i]->TotalHorasMes . "</td>";
                        $contenido .= "</tr>";
                    }
                }
            } else {
                $contenido .= "<tr> <td colspan='11' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            }
            return $contenido;
        } else {
            $contenido .= "<tr> <td colspan='11' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            return $contenido;
        }
    }

    public function actionListarMateriasDocentesAcadAjax()
    {
        $contenido = "";
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigocarrera"]) && isset($_POST["codigosede"]) && isset($_POST["codigosedeacad"]) && isset($_POST["numeroplanestudios"]) && isset($_POST["siglamateria"]) && isset($_POST["tipogrupo"]) && isset($_POST["gestionacademica"])) {
                $materiasDocentes = AcademicaDao::listaMateriasDocentes($_POST["codigocarrera"], $_POST["codigosede"], $_POST["codigosedeacad"], $_POST["numeroplanestudios"], $_POST["siglamateria"], $_POST["tipogrupo"], $_POST["gestionacademica"]);
                $cantidad = count($materiasDocentes);
                if ($cantidad == 0) {
                    $contenido .= "<tr> <td colspan='8' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                } else {
                    for ($i = 0; $i < $cantidad; $i++) {
                        $contenido .= "<tr>";
                        $contenido = $contenido . "<td>" . ($i + 1) . "</td>";
                        $contenido = $contenido . "<td>" . $materiasDocentes[$i]->IdPersona . "</td>";
                        $contenido = $contenido . "<td>" . $materiasDocentes[$i]->NombreCompleto . "</td>";
                        $contenido = $contenido . "<td>" . $materiasDocentes[$i]->Grupo . "</td>";
                        //$contenido = $contenido . "<td>" . $materiasDocentes[$i]->TipoGrupo . "</td>";
                        $contenido = $contenido . "<td>" . $materiasDocentes[$i]->NumeroEstudiantesLimite . "</td>";
                        $contenido = $contenido . "<td>" . $materiasDocentes[$i]->NumeroEstudiantesProgramados . "</td>";
                        $contenido = $contenido . "<td>" . $materiasDocentes[$i]->InformadoCargaHoraria . "</td>";
                        $contenido .= "</tr>";
                    }
                }
            } else {
                $contenido .= "<tr> <td colspan='8' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            }
            return $contenido;
        } else {
            $contenido .= "<tr> <td colspan='8' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            return $contenido;
        }
    }

    public function actionListarMateriasDocentesAcadActualAjax()
    {
        $contenido = "";
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigocarrera"]) && isset($_POST["codigosede"]) && isset($_POST["codigosedeacad"]) && isset($_POST["numeroplanestudios"]) && isset($_POST["siglamateria"]) && isset($_POST["tipogrupo"]) && isset($_POST["gestionacademica"])) {
                $materiasDocentes = AcademicaDao::listaMateriasDocentesActual($_POST["codigocarrera"], $_POST["codigosede"], $_POST["codigosedeacad"], $_POST["numeroplanestudios"], $_POST["siglamateria"], $_POST["tipogrupo"], $_POST["gestionacademica"]);
                $cantidad = count($materiasDocentes);
                if ($cantidad == 0) {
                    $contenido .= "<tr> <td colspan='8' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                } else {
                    for ($i = 0; $i < $cantidad; $i++) {
                        $contenido .= "<tr>";
                        $contenido = $contenido . "<td>" . ($i + 1) . "</td>";
                        $contenido = $contenido . "<td>" . $materiasDocentes[$i]->IdPersona . "</td>";
                        $contenido = $contenido . "<td>" . $materiasDocentes[$i]->NombreCompleto . "</td>";
                        $contenido = $contenido . "<td>" . $materiasDocentes[$i]->Grupo . "</td>";
                        //$contenido = $contenido . "<td>" . $materiasDocentes[$i]->TipoGrupo . "</td>";
                        $contenido = $contenido . "<td>" . $materiasDocentes[$i]->NumeroEstudiantesLimite . "</td>";
                        $contenido = $contenido . "<td>" . $materiasDocentes[$i]->NumeroEstudiantesProgramados . "</td>";
                        $contenido = $contenido . "<td>" . $materiasDocentes[$i]->InformadoCargaHoraria . "</td>";
                        $contenido .= "</tr>";
                    }
                }
            } else {
                $contenido .= "<tr> <td colspan='8' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            }
            return $contenido;
        } else {
            $contenido .= "<tr> <td colspan='8' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            return $contenido;
        }
    }

    public function actionListarAcefaliasResumenAjax()
    {
        $contenido = "";
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigocarrera"]) && isset($_POST["codigosede"]) && isset($_POST["gestionacademica"])) {
                $acefalias = AcademicaDao::listaAcefaliasResumen($_POST["codigocarrera"], $_POST["codigosede"], $_POST["gestionacademica"]);
                $cantidad = count($acefalias);
                if ($cantidad == 0) {
                    $contenido .= "<tr> <td colspan='7' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                } else {
                    $totalCh = 0;
                    $totalProp = 0;
                    for ($i = 0; $i < $cantidad; $i++) {
                        $contenido .= "<tr>";
                        $contenido = $contenido . "<td>" . ($i + 1) . "</td>";
                        $contenido = $contenido . "<td>" . $acefalias[$i]->NumeroPlanEstudios . "</td>";
                        $contenido = $contenido . "<td>" . $acefalias[$i]->Curso . "</td>";
                        $contenido = $contenido . "<td>" . $acefalias[$i]->SiglaMateria . "</td>";
                        $contenido = $contenido . "<td>" . $acefalias[$i]->NombreMateria . "</td>";
                        $contenido = $contenido . "<td style='text-align: right; font-weight: bold;'>" . $acefalias[$i]->HorasMesCh . "</td>";
                        $contenido = $contenido . "<td style='text-align: right; font-weight: bold;'>" . $acefalias[$i]->HorasMesProp . "</td>";
                        $contenido .= "</tr>";
                        $totalCh += $acefalias[$i]->HorasMesCh;
                        $totalProp += $acefalias[$i]->HorasMesProp;
                    }
                    $contenido .= "<tr>";
                    $contenido .= "<td colspan='5' style='text-align: right; font-weight: bold;'>TOTALES--></td>";
                    $contenido .= "<td style='text-align: right; font-weight: bold;'>" . $totalCh . "</td>";
                    $contenido .= "<td style='text-align: right; font-weight: bold;'>" . $totalProp . "</td>";
                    $contenido .= "</tr>";
                }
            } else {
                $contenido .= "<tr> <td colspan='7' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            }
            return $contenido;
        } else {
            $contenido .= "<tr> <td colspan='7' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            return $contenido;
        }
    }

    public function actionListarAcefaliasDetalleAjax()
    {
        $contenido = "";
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigocarrera"]) && isset($_POST["codigosede"]) && isset($_POST["gestionacademica"])) {
                $acefalias = AcademicaDao::listaAcefaliasDetalle($_POST["codigocarrera"], $_POST["codigosede"], $_POST["gestionacademica"]);
                $cantidad = count($acefalias);
                if ($cantidad == 0) {
                    $contenido .= "<tr> <td colspan='9' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                } else {
                    $totalCh = 0;
                    $totalProp = 0;
                    for ($i = 0; $i < $cantidad; $i++) {
                        $contenido .= "<tr>";
                        $contenido = $contenido . "<td>" . ($i + 1) . "</td>";
                        $contenido = $contenido . "<td>" . $acefalias[$i]->NumeroPlanEstudios . "</td>";
                        $contenido = $contenido . "<td>" . $acefalias[$i]->Curso . "</td>";
                        $contenido = $contenido . "<td>" . $acefalias[$i]->SiglaMateria . "</td>";
                        $contenido = $contenido . "<td>" . $acefalias[$i]->NombreMateria . "</td>";
                        $contenido = $contenido . "<td>" . $acefalias[$i]->TipoGrupoLiteral . "</td>";
                        $contenido = $contenido . "<td>" . $acefalias[$i]->Grupo . "</td>";
                        $contenido = $contenido . "<td style='text-align: right; font-weight: bold;'>" . $acefalias[$i]->HorasMesCh . "</td>";
                        $contenido = $contenido . "<td style='text-align: right; font-weight: bold;'>" . $acefalias[$i]->HorasMesProp . "</td>";
                        $contenido .= "</tr>";
                        $totalCh += $acefalias[$i]->HorasMesCh;
                        $totalProp += $acefalias[$i]->HorasMesProp;
                    }
                    $contenido .= "<tr>";
                    $contenido .= "<td colspan='7' style='text-align: right; font-weight: bold;'>TOTALES--></td>";
                    $contenido .= "<td style='text-align: right; font-weight: bold;'>" . $totalCh . "</td>";
                    $contenido .= "<td style='text-align: right; font-weight: bold;'>" . $totalProp . "</td>";
                    $contenido .= "</tr>";
                }
            } else {
                $contenido .= "<tr> <td colspan='9' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            }
            return $contenido;
        } else {
            $contenido .= "<tr> <td colspan='9' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            return $contenido;
        }
    }

    public function actionListarSuplenciasResumenAjax()
    {
        $contenido = "";
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigocarrera"]) && isset($_POST["codigosede"])) {
                $suplencias = AcademicaDao::listaSuplenciasResumen($_POST["codigocarrera"], $_POST["codigosede"]);
                $cantidad = count($suplencias);
                if ($cantidad == 0) {
                    $contenido .= "<tr> <td colspan='12' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                } else {
                    $totalHoras = 0;
                    for ($i = 0; $i < $cantidad; $i++) {
                        $fechaInicioFormato = date_format(date_create($suplencias[$i]->FechaInicio), 'd/m/Y');
                        $fechaFinFormato = date_format(date_create($suplencias[$i]->FechaFin), 'd/m/Y');
                        $contenido .= "<tr>";
                        $contenido = $contenido . "<td>" . ($i + 1) . "</td>";
                        $contenido = $contenido . "<td>" . $suplencias[$i]->NumeroPlanEstudios . "</td>";
                        $contenido = $contenido . "<td>" . $suplencias[$i]->Curso . "</td>";
                        $contenido = $contenido . "<td>" . $suplencias[$i]->SiglaMateria . "</td>";
                        $contenido = $contenido . "<td>" . $suplencias[$i]->NombreMateria . "</td>";
                        $contenido = $contenido . "<td>" . $suplencias[$i]->IdPersona . "</td>";
                        $contenido = $contenido . "<td>" . $suplencias[$i]->NombreCompleto . "</td>";
                        $contenido = $contenido . "<td>" . $suplencias[$i]->CondicionLaboral . "</td>";
                        $contenido = $contenido . "<td>" . $suplencias[$i]->TipoDeclaratoria . "</td>";
                        $contenido = $contenido . "<td>" . $fechaInicioFormato . "</td>";
                        $contenido = $contenido . "<td>" . $fechaFinFormato . "</td>";
                        $contenido = $contenido . "<td style='text-align: right; font-weight: bold;'>" . $suplencias[$i]->HorasMes . "</td>";
                        $contenido .= "</tr>";
                        $totalHoras += $suplencias[$i]->HorasMes;
                    }
                    $contenido .= "<tr>";
                    $contenido .= "<td colspan='11' style='text-align: right; font-weight: bold;'>TOTALES--></td>";
                    $contenido .= "<td style='text-align: right; font-weight: bold;'>" . $totalHoras . "</td>";
                    $contenido .= "</tr>";
                }
            } else {
                $contenido .= "<tr> <td colspan='12' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            }
            return $contenido;
        } else {
            $contenido .= "<tr> <td colspan='12' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            return $contenido;
        }
    }

    public function actionListarSuplenciasDetalleAjax()
    {
        $contenido = "";
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigocarrera"]) && isset($_POST["codigosede"])) {
                $suplencias = AcademicaDao::listaSuplenciasDetalle($_POST["codigocarrera"], $_POST["codigosede"]);
                $cantidad = count($suplencias);
                if ($cantidad == 0) {
                    $contenido .= "<tr> <td colspan='14' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                } else {
                    $totalHoras = 0;
                    for ($i = 0; $i < $cantidad; $i++) {
                        $fechaInicioFormato = date_format(date_create($suplencias[$i]->FechaInicio), 'd/m/Y');
                        $fechaFinFormato = date_format(date_create($suplencias[$i]->FechaFin), 'd/m/Y');
                        $contenido .= "<tr>";
                        $contenido = $contenido . "<td>" . ($i + 1) . "</td>";
                        $contenido = $contenido . "<td>" . $suplencias[$i]->NumeroPlanEstudios . "</td>";
                        $contenido = $contenido . "<td>" . $suplencias[$i]->Curso . "</td>";
                        $contenido = $contenido . "<td>" . $suplencias[$i]->SiglaMateria . "</td>";
                        $contenido = $contenido . "<td>" . $suplencias[$i]->NombreMateria . "</td>";
                        $contenido = $contenido . "<td>" . $suplencias[$i]->TipoGrupoLiteral . "</td>";
                        $contenido = $contenido . "<td>" . $suplencias[$i]->Grupo . "</td>";
                        $contenido = $contenido . "<td>" . $suplencias[$i]->IdPersona . "</td>";
                        $contenido = $contenido . "<td>" . $suplencias[$i]->NombreCompleto . "</td>";
                        $contenido = $contenido . "<td>" . $suplencias[$i]->CondicionLaboral . "</td>";
                        $contenido = $contenido . "<td>" . $suplencias[$i]->TipoDeclaratoria . "</td>";
                        $contenido = $contenido . "<td>" . $fechaInicioFormato . "</td>";
                        $contenido = $contenido . "<td>" . $fechaFinFormato . "</td>";
                        $contenido = $contenido . "<td style='text-align: right; font-weight: bold;'>" . $suplencias[$i]->HorasMes . "</td>";
                        $contenido .= "</tr>";
                        $totalHoras += $suplencias[$i]->HorasMes;
                    }
                    $contenido .= "<tr>";
                    $contenido .= "<td colspan='13' style='text-align: right; font-weight: bold;'>TOTALES--></td>";
                    $contenido .= "<td style='text-align: right; font-weight: bold;'>" . $totalHoras . "</td>";
                    $contenido .= "</tr>";
                }
            } else {
                $contenido .= "<tr> <td colspan='14' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            }
            return $contenido;
        } else {
            $contenido .= "<tr> <td colspan='14' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            return $contenido;
        }
    }

    public function actionListarDocentesCarreraResumenAjax()
    {
        $contenido = "";
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigocarrera"]) && isset($_POST["codigosede"]) && isset($_POST["gestionacademica"])) {
                $docentes = AcademicaDao::listaDocentesCarrera($_POST["codigocarrera"], $_POST["codigosede"], $_POST["gestionacademica"]);
                $cantidad = count($docentes);
                if ($cantidad == 0) {
                    $contenido .= "<tr> <td colspan='6' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                } else {
                    $totalCh = 0;
                    $totalProp = 0;
                    for ($i = 0; $i < $cantidad; $i++) {
                        if ($docentes[$i]->TotalHorasMesCh > $docentes[$i]->TotalHorasMesProp) {
                            $contenido .= "<tr class='table-danger'>";
                        } else {
                            if ($docentes[$i]->TotalHorasMesCh < $docentes[$i]->TotalHorasMesProp) {
                                $contenido .= "<tr class='table-success'>";
                            } else {
                                $contenido .= "<tr>";
                            }
                        }
                        $contenido = $contenido . "<td>" . ($i + 1) . "</td>";
                        $contenido = $contenido . "<td>" . $docentes[$i]->IdPersona . "</td>";
                        $contenido = $contenido . "<td>" . $docentes[$i]->NombreCompleto . "</td>";
                        $contenido = $contenido . "<td>" . $docentes[$i]->CondicionLaboral . "</td>";
                        $contenido = $contenido . "<td style='text-align: right; font-weight: bold;'>" . $docentes[$i]->TotalHorasMesCh . "</td>";
                        $contenido = $contenido . "<td style='text-align: right; font-weight: bold;'>" . $docentes[$i]->TotalHorasMesProp . "</td>";
                        $contenido .= "</tr>";
                        $totalCh += $docentes[$i]->TotalHorasMesCh;
                        $totalProp += $docentes[$i]->TotalHorasMesProp;
                    }
                    $contenido .= "<tr>";
                    $contenido .= "<td colspan='4' style='text-align: right; font-weight: bold;'>TOTALES--></td>";
                    $contenido .= "<td style='text-align: right; font-weight: bold;'>" . $totalCh . "</td>";
                    $contenido .= "<td style='text-align: right; font-weight: bold;'>" . $totalProp . "</td>";
                    $contenido .= "</tr>";
                }
            } else {
                $contenido .= "<tr> <td colspan='6' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            }
            return $contenido;
        } else {
            $contenido .= "<tr> <td colspan='6' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            return $contenido;
        }
    }

    public function actionListarDocentesUniversidadResumenAjax()
    {
        $contenido = "";
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigocarrera"]) && isset($_POST["codigosede"]) && isset($_POST["gestionacademica"])) {
                $docentes = AcademicaDao::listaDocentesUniversidad($_POST["codigocarrera"], $_POST["codigosede"], $_POST["gestionacademica"]);
                $cantidad = count($docentes);
                if ($cantidad == 0) {
                    $contenido .= "<tr> <td colspan='6' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                } else {
                    $totalCh = 0;
                    $totalProp = 0;
                    for ($i = 0; $i < $cantidad; $i++) {
                        if ($docentes[$i]->TotalHorasMesCh > $docentes[$i]->TotalHorasMesProp) {
                            $contenido .= "<tr class='table-danger'>";
                        } else {
                            if ($docentes[$i]->TotalHorasMesCh < $docentes[$i]->TotalHorasMesProp) {
                                $contenido .= "<tr class='table-success'>";
                            } else {
                                $contenido .= "<tr>";
                            }
                        }
                        $contenido = $contenido . "<td>" . ($i + 1) . "</td>";
                        $contenido = $contenido . "<td>" . $docentes[$i]->IdPersona . "</td>";
                        $contenido = $contenido . "<td>" . $docentes[$i]->NombreCompleto . "</td>";
                        $contenido = $contenido . "<td>" . $docentes[$i]->CondicionLaboral . "</td>";
                        $contenido = $contenido . "<td style='text-align: right; font-weight: bold;'>" . $docentes[$i]->TotalHorasMesCh . "</td>";
                        $contenido = $contenido . "<td style='text-align: right; font-weight: bold;'>" . $docentes[$i]->TotalHorasMesProp . "</td>";
                        $contenido .= "</tr>";
                        $totalCh += $docentes[$i]->TotalHorasMesCh;
                        $totalProp += $docentes[$i]->TotalHorasMesProp;
                    }
                    $contenido .= "<tr>";
                    $contenido .= "<td colspan='4' style='text-align: right; font-weight: bold;'>TOTALES--></td>";
                    $contenido .= "<td style='text-align: right; font-weight: bold;'>" . $totalCh . "</td>";
                    $contenido .= "<td style='text-align: right; font-weight: bold;'>" . $totalProp . "</td>";
                    $contenido .= "</tr>";
                }
            } else {
                $contenido .= "<tr> <td colspan='6' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            }
            return $contenido;
        } else {
            $contenido .= "<tr> <td colspan='6' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            return $contenido;
        }
    }

    public function actionListarExtraordinariasResumenAjax()
    {
        $contenido = "";
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigocarrera"]) && isset($_POST["codigosede"])) {
                $extraordinarias = AcademicaDao::listaExtraordinariasResumen($_POST["codigocarrera"], $_POST["codigosede"]);
                $cantidad = count($extraordinarias);
                if ($cantidad == 0) {
                    $contenido .= "<tr> <td colspan='9' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                } else {
                    $totalHoras = 0;
                    for ($i = 0; $i < $cantidad; $i++) {
                        $contenido .= "<tr>";
                        $contenido = $contenido . "<td>" . ($i + 1) . "</td>";
                        $contenido = $contenido . "<td>" . $extraordinarias[$i]->NumeroPlanEstudios . "</td>";
                        $contenido = $contenido . "<td>" . $extraordinarias[$i]->Curso . "</td>";
                        $contenido = $contenido . "<td>" . $extraordinarias[$i]->SiglaMateria . "</td>";
                        $contenido = $contenido . "<td>" . $extraordinarias[$i]->NombreMateria . "</td>";
                        $contenido = $contenido . "<td>" . $extraordinarias[$i]->IdPersona . "</td>";
                        $contenido = $contenido . "<td>" . $extraordinarias[$i]->NombreCompleto . "</td>";
                        $contenido = $contenido . "<td>" . $extraordinarias[$i]->CondicionLaboral . "</td>";
                        $contenido = $contenido . "<td style='text-align: right; font-weight: bold;'>" . $extraordinarias[$i]->HorasMes . "</td>";
                        $contenido .= "</tr>";
                        $totalHoras += $extraordinarias[$i]->HorasMes;
                    }
                    $contenido .= "<tr>";
                    $contenido .= "<td colspan='8' style='text-align: right; font-weight: bold;'>TOTALES--></td>";
                    $contenido .= "<td style='text-align: right; font-weight: bold;'>" . $totalHoras . "</td>";
                    $contenido .= "</tr>";
                }
            } else {
                $contenido .= "<tr> <td colspan='9' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            }
            return $contenido;
        } else {
            $contenido .= "<tr> <td colspan='9' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            return $contenido;
        }
    }

    public function actionListarCargaHorariaPropuestaAjax()
    {
        $contenido = "";
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigocarrera"]) && isset($_POST["codigosede"]) && isset($_POST["numeroplanestudios"]) && isset($_POST["siglamateria"]) && isset($_POST["gestionplanificacion"])) {
                $docentes = AcademicaDao::listaDocentes();
                $cantidadDocentes = count($docentes);
                $cargasHorariasPropuestas = AcademicaDao::listaCargasHorariasPropuestas($_POST["codigocarrera"], $_POST["codigosede"], $_POST["numeroplanestudios"], $_POST["siglamateria"], $_POST["gestionplanificacion"]);
                $cantidadCh = count($cargasHorariasPropuestas);
                if ($cantidadCh == 0) {
                    $contenido .= "<tr> <td colspan='7' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                } else {
                    for ($i = 0; $i < $cantidadCh; $i++) {
                        $nombreTrabajador = "<select class='selectTrabajador' grupo= '" . $cargasHorariasPropuestas[$i]->Grupo . "' tipogrupo= '" . $cargasHorariasPropuestas[$i]->CodigoTipoGrupo . "'>";
                        $opciones = "<option value=''>Selecionar Docente</option>";
                        for ($j = 0; $j < $cantidadDocentes; $j++) {
                            $seleccionado = "";
                            if ($cargasHorariasPropuestas[$i]->IdPersona == $docentes[$j]->IdPersona) {
                                $seleccionado = "selected";
                            }
                            $opciones .= "<option value='" . $docentes[$j]->IdPersona . "'" . $seleccionado . ">" . $docentes[$j]->NombreCompleto . "</option>";
                        }
                        $nombreTrabajador .= $opciones;
                        $nombreTrabajador .= "</select>";
                        $acciones = "<td><center>";
                        $acciones .= "<button class='btn btn-danger btnEliminarChPropuesta' codigocarrera='" . $cargasHorariasPropuestas[$i]->CodigoCarrera . "' numeroplanestudios='" . $cargasHorariasPropuestas[$i]->NumeroPlanEstudios . "' siglamateria='" . $cargasHorariasPropuestas[$i]->SiglaMateria . "' grupo='" . $cargasHorariasPropuestas[$i]->Grupo . "' tipogrupo='" . $cargasHorariasPropuestas[$i]->CodigoTipoGrupo . "' codigotrabajador='" . $cargasHorariasPropuestas[$i]->CodigoTrabajador . "' nombretrabajador='" . $cargasHorariasPropuestas[$i]->NombreCompleto . "' idpersona='" . $cargasHorariasPropuestas[$i]->IdPersona . "'><i class='fa fa-times'></i></button>";
                        $acciones .= "</center></td>";
                        $contenido .= "<tr>";
                        $contenido = $contenido . "<td>" . $cargasHorariasPropuestas[$i]->CodigoTrabajador . "</td>";
                        $contenido = $contenido . "<td>" . $cargasHorariasPropuestas[$i]->IdPersona . "</td>";
                        $contenido = $contenido . "<td>" . $nombreTrabajador . "</td>";
                        $contenido = $contenido . "<td>" . $cargasHorariasPropuestas[$i]->CondicionLaboral . "</td>";
                        $contenido = $contenido . "<td>" . $cargasHorariasPropuestas[$i]->Grupo . "</td>";
                        $contenido = $contenido . "<td>" . $cargasHorariasPropuestas[$i]->TipoGrupoLiteral . "</td>";
                        $contenido = $contenido . "<td>" . $cargasHorariasPropuestas[$i]->HorasSemana . "</td>";
                        $contenido = $contenido . $acciones . "</td>";
                        $contenido .= "</tr>";
                    }
                }
            } else {
                $contenido .= "<tr> <td colspan='7' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            }
            return $contenido;
        } else {
            $contenido .= "<tr> <td colspan='7' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            return $contenido;
        }
    }

    public function actionListarCargaHorariaPropuestaTipoGrupoAjax()
    {
        $contenido = "";
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigocarrera"]) && isset($_POST["codigosede"]) && isset($_POST["numeroplanestudios"]) && isset($_POST["siglamateria"]) && isset($_POST["tipogrupo"]) && isset($_POST["gestionplanificacion"])) {
                $docentes = AcademicaDao::listaDocentes();
                $cantidadDocentes = count($docentes);
                $cargasHorariasPropuestas = AcademicaDao::listaCargasHorariasPropuestasTipo($_POST["codigocarrera"], $_POST["codigosede"], $_POST["numeroplanestudios"], $_POST["siglamateria"], $_POST["gestionplanificacion"], $_POST["tipogrupo"]);
                $cantidadCh = count($cargasHorariasPropuestas);
                if ($cantidadCh == 0) {
                    $contenido .= "<tr> <td colspan='7' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                } else {
                    for ($i = 0; $i < $cantidadCh; $i++) {
                        $nombreTrabajador = "<select class='selectTrabajador' grupo= '" . $cargasHorariasPropuestas[$i]->Grupo . "' tipogrupo= '" . $cargasHorariasPropuestas[$i]->TipoGrupo . "'>";
                        $opciones = "<option value=''>Selecionar Docente</option>";
                        for ($j = 0; $j < $cantidadDocentes; $j++) {
                            $seleccionado = "";
                            if ($cargasHorariasPropuestas[$i]->IdPersona == $docentes[$j]->IdPersona) {
                                $seleccionado = "selected";
                            }
                            $opciones .= "<option value='" . $docentes[$j]->IdPersona . "'" . $seleccionado . ">" . $docentes[$j]->NombreCompleto . "</option>";
                        }
                        $nombreTrabajador .= $opciones;
                        $nombreTrabajador .= "</select>";
                        $acciones = "<td><center>";
                        $acciones .= "<button class='btn btn-danger btnEliminarChPropuesta' codigocarrera='" . $cargasHorariasPropuestas[$i]->CodigoCarrera . "' numeroplanestudios='" . $cargasHorariasPropuestas[$i]->NumeroPlanEstudios . "' siglamateria='" . $cargasHorariasPropuestas[$i]->SiglaMateria . "' grupo='" . $cargasHorariasPropuestas[$i]->Grupo . "' tipogrupo='" . $cargasHorariasPropuestas[$i]->TipoGrupo . "' codigotrabajador='" . $cargasHorariasPropuestas[$i]->CodigoTrabajador . "' nombretrabajador='" . $cargasHorariasPropuestas[$i]->NombreCompleto . "' idpersona='" . $cargasHorariasPropuestas[$i]->IdPersona . "'><i class='fa fa-times'></i></button>";
                        $acciones .= "</center></td>";
                        $contenido .= "<tr>";
                        $contenido = $contenido . "<td>" . $cargasHorariasPropuestas[$i]->CodigoTrabajador . "</td>";
                        $contenido = $contenido . "<td>" . $cargasHorariasPropuestas[$i]->IdPersona . "</td>";
                        $contenido = $contenido . "<td>" . $nombreTrabajador . "</td>";
                        $contenido = $contenido . "<td>" . $cargasHorariasPropuestas[$i]->CondicionLaboral . "</td>";
                        $contenido = $contenido . "<td>" . $cargasHorariasPropuestas[$i]->Grupo . "</td>";
                        $contenido = $contenido . "<td>" . $cargasHorariasPropuestas[$i]->TipoGrupoLiteral . "</td>";
                        $contenido = $contenido . "<td>" . $cargasHorariasPropuestas[$i]->HorasSemana . "</td>";
                        $contenido = $contenido . $acciones . "</td>";
                        $contenido .= "</tr>";
                    }
                }
            } else {
                $contenido .= "<tr> <td colspan='7' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            }
            return $contenido;
        } else {
            $contenido .= "<tr> <td colspan='7' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            return $contenido;
        }
    }

    public function actionBuscarConfiguracionVigenteAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigocarrera"]) && isset($_POST["codigosede"])) {
                $configuracion = AcademicaDao::buscaCargaHorariaConfiguracion("obj", $_POST["codigocarrera"], $_POST["codigosede"]);
                $session = Yii::$app->session;
                if ($session->isActive) {
                    $session->set("GestionAcademica", $configuracion->GestionAcademica);
                    $session->set("GestionAcademicaAnterior", $configuracion->GestionAcademicaAnterior);
                    $session->set("GestionAcademicaPlanificacion", $configuracion->GestionAcademicaPlanificacion);
                    $session->set("GestionAnterior", $configuracion->GestionAnterior);
                    $session->set("MesAnterior", $configuracion->MesAnterior);
                    $arraySession = [
                        "GestionAcademica" => $session->get("GestionAcademica"),
                        "GestionAcademicaAnterior" => $session->get("GestionAcademicaAnterior"),
                        "GestionAcademicaPlanificacion" => $session->get("GestionAcademicaPlanificacion"),
                        "GestionAnterior" => $session->get("GestionAnterior"),
                        "MesAnterior" => $session->get("MesAnterior"),
                    ];
                    return json_encode($arraySession);
                }
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionCrearCargaHorariaPropuestaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            $cargaHorariaPlanificacion = CargaHoraria::find()
                ->where(['CodigoCarrera' => $_POST["codigocarrera"]])
                ->andWhere(['NumeroPlanEstudios' => $_POST["numeroplanestudios"]])
                ->andWhere(['SiglaMateria' => $_POST["siglamateria"]])
                ->andWhere(['CodigoSede' => $_POST["codigosede"]])
                //->andWhere(['NumeroPlanificacion' => 1])
                ->andWhere(['GestionAcademica' => $_POST["gestionplanificacion"]])->one();
            if ($cargaHorariaPlanificacion == "") {
                $cargaHorariaPlanificacion = new CargaHoraria();
                $cargaHorariaPlanificacion->CodigoCarrera = $_POST["codigocarrera"];
                $cargaHorariaPlanificacion->NumeroPlanEstudios = $_POST["numeroplanestudios"];
                $cargaHorariaPlanificacion->SiglaMateria = $_POST["siglamateria"];
                $cargaHorariaPlanificacion->CodigoSede = $_POST["codigosede"];
                $cargaHorariaPlanificacion->GestionAcademica = $_POST["gestionplanificacion"];
                $cargaHorariaPlanificacion->CantidadGruposTeoria = 0;
                $cargaHorariaPlanificacion->CantidadGruposPractica = 0;
                $cargaHorariaPlanificacion->CantidadGruposLaboratorio = 0;
                $cargaHorariaPlanificacion->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;
            }
            if ($_POST["tipogrupo"] == "T") {
                $cargaHorariaPlanificacion->CantidadGruposTeoria = $cargaHorariaPlanificacion->CantidadGruposTeoria + 1;
            } else {
                if ($_POST["tipogrupo"] == "P") {
                    $cargaHorariaPlanificacion->CantidadGruposPractica = $cargaHorariaPlanificacion->CantidadGruposPractica + 1;
                } else {
                    if ($_POST["tipogrupo"] == "L") {
                        $cargaHorariaPlanificacion->CantidadGruposLaboratorio = $cargaHorariaPlanificacion->CantidadGruposLaboratorio + 1;
                    }
                }
            }
            $cargaHorariaPlanificacion->save();
            $cargaHorariaPropuesta = new DetalleCargaHoraria();
            $cargaHorariaPropuesta->GestionAcademica = $_POST["gestionplanificacion"];
            $cargaHorariaPropuesta->CodigoCarrera = $_POST["codigocarrera"];
            $cargaHorariaPropuesta->NumeroPlanEstudios = $_POST["numeroplanestudios"];
            $cargaHorariaPropuesta->SiglaMateria = $_POST["siglamateria"];
            $cargaHorariaPropuesta->Grupo = $_POST["grupo"];
            $cargaHorariaPropuesta->CodigoTipoGrupo = $_POST["tipogrupo"];
            $cargaHorariaPropuesta->IdPersona = $_POST["idpersona"];
            $cargaHorariaPropuesta->CodigoSede = $_POST["codigosede"];
            $cargaHorariaPropuesta->FechaInicio = '20/01/2022';
            $cargaHorariaPropuesta->CodigoUsuario = Yii::$app->user->identity->CodigoUsuario;
            if (!$cargaHorariaPropuesta->exist()) {
                $cargaHorariaPropuesta->save();
                return "ok";
            } else {
                return "existe";
            }
        } else {
            return "error";
        }
    }

    public function actionActualizarCargaHorariaPropuestaAjax()
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

    public function actionEliminarCargaHorariaPropuestaAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigocarrera"]) && isset($_POST["numeroplanestudios"]) && isset($_POST["siglamateria"]) && isset($_POST["grupo"]) && isset($_POST["tipogrupo"]) && isset($_POST["gestionplanificacion"]) && isset($_POST["codigosede"])) {
                $cargaHorariaPropuesta = DetalleCargaHoraria::find()
                    ->where(['CodigoCarrera' => $_POST["codigocarrera"]])
                    ->andWhere(['NumeroPlanEstudios' => $_POST["numeroplanestudios"]])
                    ->andWhere(['SiglaMateria' => $_POST["siglamateria"]])
                    ->andWhere(['Grupo' => $_POST["grupo"]])
                    ->andWhere(['CodigoTipoGrupo' => $_POST["tipogrupo"]])
                    ->andWhere(['GestionAcademica' => $_POST["gestionplanificacion"]])->one();
                $cargaHorariaPropuesta->delete();
                $cargaHorariaPlanificacion = CargaHoraria::find()
                    ->where(['CodigoCarrera' => $_POST["codigocarrera"]])
                    ->andWhere(['NumeroPlanEstudios' => $_POST["numeroplanestudios"]])
                    ->andWhere(['SiglaMateria' => $_POST["siglamateria"]])
                    ->andWhere(['CodigoSede' => $_POST["codigosede"]])
                    //->andWhere(['NumeroPlanificacion' => 1])
                    ->andWhere(['GestionAcademica' => $_POST["gestionplanificacion"]])->one();
                if ($_POST["tipogrupo"] == "T") {
                    $cargaHorariaPlanificacion->CantidadGruposTeoria = $cargaHorariaPlanificacion->CantidadGruposTeoria - 1;
                } else {
                    if ($_POST["tipogrupo"] == "P") {
                        $cargaHorariaPlanificacion->CantidadGruposPractica = $cargaHorariaPlanificacion->CantidadGruposPractica - 1;
                    } else {
                        if ($_POST["tipogrupo"] == "L") {
                            $cargaHorariaPlanificacion->CantidadGruposLaboratorio = $cargaHorariaPlanificacion->CantidadGruposLaboratorio - 1;
                        }
                    }
                }
                $cargaHorariaPlanificacion->save();
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionActualizarCargaHorariaConfiguracionAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigocarrera"]) && isset($_POST["codigosede"]) && isset($_POST["gestionacademica"]) && isset($_POST["gestionanterior"]) && isset($_POST["mesanterior"]) && isset($_POST["gestionacademicaanterior"])) {
                $cargaHorariaConfiguracion = CargaHorariaConfiguracion::find()
                    ->where(['CodigoCarrera' => $_POST["codigocarrera"]])
                    ->andWhere(['CodigoSedeAcad' => $_POST["codigosede"]])
                    ->andWhere(['GestionAcademica' => $_POST["gestionacademica"]])->one();
                $cargaHorariaConfiguracion->GestionAnterior = $_POST["gestionanterior"];
                $cargaHorariaConfiguracion->MesAnterior = $_POST["mesanterior"];
                $cargaHorariaConfiguracion->GestionAcademicaAnterior = $_POST["gestionacademicaanterior"];
                $cargaHorariaConfiguracion->save();
                return "ok";
            } else {
                return "error";
            }
        } else {
            return "error";
        }
    }

    public function actionFinalizarCargaHorariaConfiguracionAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigocarrera"]) && isset($_POST["codigosede"])) {
                $finalizarCargaHoraria = CargaHorariaConfiguracion::find()
                    ->where(['CodigoCarrera' => $_POST["codigocarrera"]])
                    ->andWhere(['CodigoSedeAcad' => $_POST["codigosede"]])
                    ->andWhere(['CodigoEstado' => "V"])->one();
                if ($finalizarCargaHoraria->CodigoEstadoPlanificacion == "P") {
                    $finalizarCargaHoraria->CodigoEstadoPlanificacion = "V";
                } else {
                    $finalizarCargaHoraria->CodigoEstadoPlanificacion = "P";
                }
                $finalizarCargaHoraria->save();
                return "ok";
            } else {
                return "error1";
            }
        } else {
            return "error2";
        }
    }

    public function actionFinalizarCargaHorariaConfiguracionRectorAjax()
    {
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["codigocarrera"]) && isset($_POST["codigosede"])) {
                $finalizarCargaHoraria = CargaHorariaConfiguracion::find()
                    ->where(['CodigoCarrera' => $_POST["codigocarrera"]])
                    ->andWhere(['CodigoSedeAcad' => $_POST["codigosede"]])
                    ->andWhere(['CodigoEstado' => "V"])->one();
                if ($finalizarCargaHoraria->CodigoEstadoPlanificacion == "V") {
                    $finalizarCargaHoraria->CodigoEstadoPlanificacion = "F";
                } else {
                    $finalizarCargaHoraria->CodigoEstadoPlanificacion = "V";
                }
                $finalizarCargaHoraria->save();
                return "ok";
            } else {
                return "error1";
            }
        } else {
            return "error2";
        }
    }
}