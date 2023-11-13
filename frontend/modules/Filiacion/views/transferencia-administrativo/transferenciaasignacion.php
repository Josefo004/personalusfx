<?php

use yii\web\JqueryAsset;

app\modules\Filiacion\assets\FiliacionAsset::register($this);

$this->registerJsFile("@web/js/transferencia-administrativo/transferenciaasignacion.js", [
    'depends' => [
        JqueryAsset::className()
    ]
]);
$this->title = 'Transferencia Asignacion';
$this->params['breadcrumbs'] = [['label' => 'Asignacion Trans.']];

?>
<div class="card">
    <div class="card-header">
        <div class="offset-sm-2 col-sm-8 offset-md-3 col-md-6">
            <div class="box">
                <input id="Codigo" value='<?= $transferenciaAdministrativo->CodigoTransferencia ?>' hidden>
                <table class="table table-bordered table-striped " width="10%">
                    <tr>
                        <th style="background-color: #5095ff; color: white">Motivo</th>
                        <td style="background-color: white;"><?= $transferenciaAdministrativo->Motivo ?><input
                                    type="text" disabled hidden id="Motivo"
                                    value="<?= $transferenciaAdministrativo->CodigoTransferencia ?>"></td>
                    </tr>
                    <tr>
                        <th style="background-color: #5095ff; color: white"> Inicio Transferencia</th>
                        <td style="background-color: white;"><?= date_format(date_create($transferenciaAdministrativo->FechaInicioTransferencia), 'd/m/Y') ?></td>
                    </tr>
                    <tr>
                        <th style="background-color: #5095ff; color: white"> Fin Asignacion</th>
                        <td style="background-color: white;"><?= date_format(date_create($transferenciaAdministrativo->FechaFinAsignacion), 'd/m/Y') ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <br/>
    <div>
        <table id="tablaTransferenciaAsignacion" name="tablaTransferenciaAsignacion"
               class="table table-bordered table-striped dt-responsive tablaTransferenciaAsignacion"
               width="100%">
            <thead>
            <tr>
                <th>Trabajador</th>
                <th>Asignacion Actual</th>
                <th>Nueva Asignacion</th>
            </tr>
            </thead>
            <tbody id="contenidoTransferenciaAsignacion" name="contenidoTransferenciaAsignacion">

            </tbody>
        </table>
        <div align="center">
            <button id="btnfinalizarTransferencia" name="btnfinalizarTransferencia" codigo="" class="btn btn-primary">
                Finalizar
            </button>
        </div>
    </div>
</div>