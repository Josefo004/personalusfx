<?php

namespace app\modules\Contraloria\controllers;

use app\modules\Contraloria\models\TiposDeclaracionesJuradasDao;
use app\modules\Contraloria\models\TrabajadoresDeclaracionesJuradasDao;
use app\modules\Contraloria\models\TipoDeclaracionJuradaTrabajador;
use kartik\mpdf\Pdf;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use app\modules\Contraloria\models\TiposDeclaracionesJuradasTrabajadoresDao;
use yii\filters\VerbFilter;
use Yii;

class ReportesDecJuPresentadasController extends Controller
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

        $listaMeses = array('1' => 'Enero', '2' => 'Febrero', '3' => 'Marzo', '4' => 'Abril', '5' => 'Mayo', '6' => 'Junio', '7' => 'Julio', '8' => 'Agosto', '9' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre');
        return $this->render('reportesdecjupresentadas', [
            'meses' => $listaMeses
        ]);
    }

    public function actionReporteDecJuPresentadaTriUnoAjax()
    {
        $contenido = "";
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (/*isset($_POST["mes"]) && */isset($_POST["gestion"])) {
                $reportes = TrabajadoresDeclaracionesJuradasDao::listaDeclaracionJuradaPresentadaTriUno(/*$_POST["mes"],*/ $_POST["gestion"]);
                $cantidad = count($reportes);
                if($cantidad == 0){
                    $contenido .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                }else{
                    for ($i = 0; $i < $cantidad; $i++) {
                        $contenido .= "<tr>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->NombreCompleto . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->IdPersona . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->Cargo . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->Funcion . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->Reside . "</td>";
                        $contenido = $contenido . "<td>" . date_format(date_create($reportes[$i]->FechaNacimiento),'d/m/Y') . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->CodigoDeclaracionJurada . "</td>";
                        $contenido = $contenido . "<td>" . date_format(date_create($reportes[$i]->FechaRecepcion),'d/m/Y') . "</td>";
                        $contenido .= "</tr>";
                    }
                }
            }else{
                $contenido .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            }
            return $contenido;
        } else {
            $contenido .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            return $contenido;
        }
    }

    public function actionReporteDecJuPresentadaTriDosAjax()
    {
        $contenido = "";
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (/*isset($_POST["mes"]) && */isset($_POST["gestion"])) {
                $reportes = TrabajadoresDeclaracionesJuradasDao::listaDeclaracionJuradaPresentadaTriDos(/*$_POST["mes"],*/ $_POST["gestion"]);
                $cantidad = count($reportes);
                if($cantidad == 0){
                    $contenido .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                }else{
                    for ($i = 0; $i < $cantidad; $i++) {
                        $contenido .= "<tr>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->NombreCompleto . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->IdPersona . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->Cargo . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->Funcion . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->Reside . "</td>";
                        $contenido = $contenido . "<td>" . date_format(date_create($reportes[$i]->FechaNacimiento),'d/m/Y') . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->CodigoDeclaracionJurada . "</td>";
                        $contenido = $contenido . "<td>" . date_format(date_create($reportes[$i]->FechaRecepcion),'d/m/Y') . "</td>";
                        $contenido .= "</tr>";
                    }
                }
            }else{
                $contenido .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            }
            return $contenido;
        } else {
            $contenido .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            return $contenido;
        }
    }

    public function actionReporteDecJuPresentadaTriTresAjax()
    {
        $contenido = "";
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (/*isset($_POST["mes"]) && */isset($_POST["gestion"])) {
                $reportes = TrabajadoresDeclaracionesJuradasDao::listaDeclaracionJuradaPresentadaTriTres(/*$_POST["mes"],*/ $_POST["gestion"]);
                $cantidad = count($reportes);
                if($cantidad == 0){
                    $contenido .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                }else{
                    for ($i = 0; $i < $cantidad; $i++) {
                        $contenido .= "<tr>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->NombreCompleto . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->IdPersona . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->Cargo . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->Funcion . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->Reside . "</td>";
                        $contenido = $contenido . "<td>" . date_format(date_create($reportes[$i]->FechaNacimiento),'d/m/Y') . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->CodigoDeclaracionJurada . "</td>";
                        $contenido = $contenido . "<td>" . date_format(date_create($reportes[$i]->FechaRecepcion),'d/m/Y') . "</td>";
                        $contenido .= "</tr>";
                    }
                }
            }else{
                $contenido .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            }
            return $contenido;
        } else {
            $contenido .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            return $contenido;
        }
    }

    public function actionReporteDecJuPresentadaTriCuatroAjax()
    {
        $contenido = "";
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (/*isset($_POST["mes"]) && */isset($_POST["gestion"])) {
                $reportes = TrabajadoresDeclaracionesJuradasDao::listaDeclaracionJuradaPresentadaTriCuatro(/*$_POST["mes"],*/ $_POST["gestion"]);
                $cantidad = count($reportes);
                if($cantidad == 0){
                    $contenido .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                }else{
                    for ($i = 0; $i < $cantidad; $i++) {
                        $contenido .= "<tr>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->NombreCompleto . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->IdPersona . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->Cargo . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->Funcion . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->Reside . "</td>";
                        $contenido = $contenido . "<td>" . date_format(date_create($reportes[$i]->FechaNacimiento),'d/m/Y') . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->CodigoDeclaracionJurada . "</td>";
                        $contenido = $contenido . "<td>" . date_format(date_create($reportes[$i]->FechaRecepcion),'d/m/Y') . "</td>";
                        $contenido .= "</tr>";
                    }
                }
            }else{
                $contenido .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            }
            return $contenido;
        } else {
            $contenido .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            return $contenido;
        }
    }

    public function actionReporteDecJuFueraPlazoTriUnoAjax()
    {
        $contenidoFueraPlazo = "";
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (/*isset($_POST["mes"]) && */isset($_POST["gestion"])) {
                $reportesFueraPlazo = TrabajadoresDeclaracionesJuradasDao::listaDeclaracionJuradaFueraPlazoTriUno(/*$_POST["mes"],*/ $_POST["gestion"]);
                $cantidad = count($reportesFueraPlazo);
                if($cantidad == 0){
                    $contenidoFueraPlazo .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                }else{
                    for ($i = 0; $i < $cantidad; $i++) {
                        $contenidoFueraPlazo .= "<tr>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . $reportesFueraPlazo[$i]->NombreCompleto . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . $reportesFueraPlazo[$i]->IdPersona . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . $reportesFueraPlazo[$i]->Cargo . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . $reportesFueraPlazo[$i]->Funcion . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . $reportesFueraPlazo[$i]->Reside . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . date_format(date_create($reportesFueraPlazo[$i]->FechaNacimiento),'d/m/Y') . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . $reportesFueraPlazo[$i]->CodigoDeclaracionJurada . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . date_format(date_create($reportesFueraPlazo[$i]->FechaRecepcion),'d/m/Y') . "</td>";
                        $contenidoFueraPlazo .= "</tr>";
                    }
                }
            }else{
                $contenidoFueraPlazo .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            }
            return $contenidoFueraPlazo;
        } else {
            $contenidoFueraPlazo .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            return $contenidoFueraPlazo;
        }
    }

    public function actionReporteDecJuFueraPlazoTriDosAjax()
    {
        $contenidoFueraPlazo = "";
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (/*isset($_POST["mes"]) && */isset($_POST["gestion"])) {
                $reportesFueraPlazo = TrabajadoresDeclaracionesJuradasDao::listaDeclaracionJuradaFueraPlazoTriDos(/*$_POST["mes"],*/ $_POST["gestion"]);
                $cantidad = count($reportesFueraPlazo);
                if($cantidad == 0){
                    $contenidoFueraPlazo .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                }else{
                    for ($i = 0; $i < $cantidad; $i++) {
                        $contenidoFueraPlazo .= "<tr>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . $reportesFueraPlazo[$i]->NombreCompleto . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . $reportesFueraPlazo[$i]->IdPersona . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . $reportesFueraPlazo[$i]->Cargo . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . $reportesFueraPlazo[$i]->Funcion . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . $reportesFueraPlazo[$i]->Reside . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . date_format(date_create($reportesFueraPlazo[$i]->FechaNacimiento),'d/m/Y') . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . $reportesFueraPlazo[$i]->CodigoDeclaracionJurada . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . date_format(date_create($reportesFueraPlazo[$i]->FechaRecepcion),'d/m/Y') . "</td>";
                        $contenidoFueraPlazo .= "</tr>";
                    }
                }
            }else{
                $contenidoFueraPlazo .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            }
            return $contenidoFueraPlazo;
        } else {
            $contenidoFueraPlazo .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            return $contenidoFueraPlazo;
        }
    }

    public function actionReporteDecJuFueraPlazoTriTresAjax()
    {
        $contenidoFueraPlazo = "";
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (/*isset($_POST["mes"]) && */isset($_POST["gestion"])) {
                $reportesFueraPlazo = TrabajadoresDeclaracionesJuradasDao::listaDeclaracionJuradaFueraPlazoTriTres(/*$_POST["mes"],*/ $_POST["gestion"]);
                $cantidad = count($reportesFueraPlazo);
                if($cantidad == 0){
                    $contenidoFueraPlazo .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                }else{
                    for ($i = 0; $i < $cantidad; $i++) {
                        $contenidoFueraPlazo .= "<tr>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . $reportesFueraPlazo[$i]->NombreCompleto . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . $reportesFueraPlazo[$i]->IdPersona . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . $reportesFueraPlazo[$i]->Cargo . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . $reportesFueraPlazo[$i]->Funcion . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . $reportesFueraPlazo[$i]->Reside . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . date_format(date_create($reportesFueraPlazo[$i]->FechaNacimiento),'d/m/Y') . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . $reportesFueraPlazo[$i]->CodigoDeclaracionJurada . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . date_format(date_create($reportesFueraPlazo[$i]->FechaRecepcion),'d/m/Y') . "</td>";
                        $contenidoFueraPlazo .= "</tr>";
                    }
                }
            }else{
                $contenidoFueraPlazo .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            }
            return $contenidoFueraPlazo;
        } else {
            $contenidoFueraPlazo .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            return $contenidoFueraPlazo;
        }
    }

    public function actionReporteDecJuFueraPlazoTriCuatroAjax()
    {
        $contenidoFueraPlazo = "";
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (/*isset($_POST["mes"]) && */isset($_POST["gestion"])) {
                $reportesFueraPlazo = TrabajadoresDeclaracionesJuradasDao::listaDeclaracionJuradaFueraPlazoTriCuatro(/*$_POST["mes"],*/ $_POST["gestion"]);
                $cantidad = count($reportesFueraPlazo);
                if($cantidad == 0){
                    $contenidoFueraPlazo .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                }else{
                    for ($i = 0; $i < $cantidad; $i++) {
                        $contenidoFueraPlazo .= "<tr>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . $reportesFueraPlazo[$i]->NombreCompleto . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . $reportesFueraPlazo[$i]->IdPersona . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . $reportesFueraPlazo[$i]->Cargo . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . $reportesFueraPlazo[$i]->Funcion . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . $reportesFueraPlazo[$i]->Reside . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . date_format(date_create($reportesFueraPlazo[$i]->FechaNacimiento),'d/m/Y') . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . $reportesFueraPlazo[$i]->CodigoDeclaracionJurada . "</td>";
                        $contenidoFueraPlazo = $contenidoFueraPlazo . "<td>" . date_format(date_create($reportesFueraPlazo[$i]->FechaRecepcion),'d/m/Y') . "</td>";
                        $contenidoFueraPlazo .= "</tr>";
                    }
                }
            }else{
                $contenidoFueraPlazo .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            }
            return $contenidoFueraPlazo;
        } else {
            $contenidoFueraPlazo .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
            return $contenidoFueraPlazo;
        }
    }
}