<?php
use common\models\Carrera;
app\modules\CargaHoraria\assests\CargaHorariaAsset::register($this);

$this->registerJsFile("@web/js/acefalias.js",[
    'depends' => [
        \yii\web\JqueryAsset::className()
    ]
]);
$this->title = 'Convocatorias Docentes';
$this->params['breadcrumbs'] = [['label' => 'Convocatorias Doc.']];

?>
<link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet">

<div class="card">
    <div class="card-header">
        <div class="row">
            <div  style="vertical-align: middle; width: 50%">
                <button id="btnMostrarCrearConvocatoria" class="btn btn-primary" >
                    Continuar
                </button>
                <input id="Codigo" value='<?=$codigo?>' hidden>
            </div>
        </div>
    </div>
    <div id="Divtabla" class="card-body">
        <table class="table table-bordered table-striped dt-responsive tablaMaterias" width="100%">
            <thead>
            <tr class="vertical-align: middle">
                <th style="text-align: center; vertical-align: middle;">#</th>
                <th style="text-align: center; vertical-align: middle;">Carrera</th>
                <th style="text-align: center; vertical-align: middle;">Sede</th>
                <th style="text-align: center; vertical-align: middle;">Plan de Estudios</th>
                <th style="text-align: center; vertical-align: middle;">Sigla</th>
                <th style="text-align: center; vertical-align: middle;">Materia</th>
                <th style="text-align: center; vertical-align: middle;">Curso</th>
                <th style="text-align: center; vertical-align: middle;">Grupo</th>
                <th style="text-align: center; vertical-align: middle;">Tipo de Grupo</th>
                <th style="text-align: center; vertical-align: middle;">Hrs. Teoria</th>
                <th style="text-align: center; vertical-align: middle;">Hrs. Practica</th>
                <th style="text-align: center; vertical-align: middle;">Hrs. Laboratorio</th>
                <th style="text-align: center; vertical-align: middle;">Total Horas</th>
                <th style="text-align: center; vertical-align: middle;">Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>





