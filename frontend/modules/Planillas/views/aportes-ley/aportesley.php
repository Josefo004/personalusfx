<?php

use yii\web\JqueryAsset;

app\modules\Planillas\assets\PlanillasAsset::register($this);

$this->registerJsFile("@web/js/planillas/planillas.js", [
    'depends' => [
        JqueryAsset::className()
    ]
]);

$this->title = 'Aportes de Ley';
$this->params['breadcrumbs'] = [['label' => 'Aportes de Ley']];
?>

<!--=====================================
VISTA CREAR NURVO APORTE DE LEY
======================================-->
<div id="vistaAportes" class="card">
    <div class="card-header">
        <button id="btnMostrarSeleccionarPersona" name="btnMostrarSeleccionarPersona" class="btn btn-primary">
            Agregar Aporte
        </button>
    </div>
    <br/>
    <div class="card-body">
        <table id="tablaAportesLey" class="table table-bordered table-striped dt-responsive" width="100%">
            <thead>
                <tr>
                    <th style="width:10px">#</th>
                    <th>Nombre Aporte Ley</th>
                    <th>Tipo de Aporte</th>
                    <th>Porcentaje</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
        <br>
    </div>
</div>