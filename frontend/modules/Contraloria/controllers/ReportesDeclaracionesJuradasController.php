<?php


namespace app\modules\Contraloria\controllers;

use app\modules\Contraloria\models\TiposDeclaracionesJuradasDao;
use app\modules\Contraloria\models\TipoDeclaracionJuradaTrabajador;
use kartik\mpdf\Pdf;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use app\modules\Contraloria\models\TiposDeclaracionesJuradasTrabajadoresDao;
use yii\filters\VerbFilter;
use Yii;


class ReportesDeclaracionesJuradasController extends Controller
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
        return $this->render('reportesdeclaracionesjuradas', [
            'meses' => $listaMeses
        ]);
    }



    public function actionReporteDeclaracionJuradaAjax()
    {
        $contenido = "";
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["mes"]) && isset($_POST["gestion"])) {
                $reportes = TiposDeclaracionesJuradasTrabajadoresDao::listaDeclaracionJuradaTrabajador($_POST["mes"], $_POST["gestion"]);
                $cantidad = count($reportes);
                if($cantidad == 0){
                    $contenido .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                }else{
                    for ($i = 0; $i < $cantidad; $i++) {
                        $contenido .= "<tr>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->NombreCompleto . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->IdPersona . "</td>";
                        $contenido = $contenido . "<td>" . date_format(date_create($reportes[$i]->FechaNacimiento),'d/m/Y') . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->Celular . "</td>";
                        $contenido = $contenido . "<td>" . date_format(date_create($reportes[$i]->FechaInicioRecordatorio),'d/m/Y') . "</td>";
                        $contenido = $contenido . "<td>" . date_format(date_create($reportes[$i]->FechaFinRecordatorio),'d/m/Y') . "</td>";
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

    public function actionPdfReportesDeclaracionesJuradasAjax()
    {
        $contenido = "";
        $contenido .= "<div class='card'>      
        <img src='img/logo.png' width='20%' align='left'>
        <br>
        <h4 align='center'>UNVERSIDAD MAYOR Y REAL DE SAN FRANCISCO XAVIER DE CHUQUISACA</h4>
            <h5 align='center'>REPORTE DECLARACIONES JURADAS</h5>
               <h6 align='center'>Mes:  </h6>
                <h6 align='center'>Año:  </h6>
                <br>
        <div class= 'card-body'>
            <table align='center' border='default' width='100%' >
                <thead>
                <tr >
                    <th >Codigo de Trabajador</th>
                    <th >CI</th>
                    <th >Nombre Completo</th>
                    <th >Fecha de Nacimiento</th>
                    <th >Fecha de Recordatorio</th>
                    <th >Fecha Fin    </th>
                </tr>
                </thead>
            </table>
        </div>
    </div>";

        $contenido = "";
        if (\Yii::$app->request->isAjax && \Yii::$app->request->isPost) {
            if (isset($_POST["mes"]) && isset($_POST["gestion"])) {
                $reportes = TiposDeclaracionesJuradasTrabajadoresDao::listaDeclaracionJuradaTrabajador($_POST["mes"], $_POST["gestion"]);
                $cantidad = count($reportes);
                if($cantidad == 0){
                    $contenido .= "<tr> <td colspan='17' style='text-align: center; font-weight: bold;'>Ningún dato disponible en esta tabla</td></tr>";
                }else{
                    for ($i = 0; $i < $cantidad; $i++) {
                        $contenido .= "<tr>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->CodigoTrabajador . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->IdPersona . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->NombreCompleto . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->FechaNacimiento . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->FechaInicioRecordatorio . "</td>";
                        $contenido = $contenido . "<td>" . $reportes[$i]->FechaFinRecordatorio . "</td>";
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
        };

        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $contenido,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            // 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Krajee Report Title'],
            // call mPDF methods on the fly
            'methods' => [
                'SetFooter'=>['{PAGENO} de {nbpg}'],

            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }
}


