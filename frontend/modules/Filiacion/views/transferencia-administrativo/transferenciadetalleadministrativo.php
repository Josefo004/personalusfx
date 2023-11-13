<?php

use yii\web\JqueryAsset;

app\modules\Filiacion\assets\FiliacionAsset::register($this);

$this->registerJsFile("@web/js/transferencia-administrativo/transferenciadetalleadministrativo.js",[
    'depends' => [
        JqueryAsset::className()
    ]
]);
$this->title = 'Detalle Transferencia';
$this->params['breadcrumbs'] = [['label' => 'Detalle Trans.']];

?>
<div class="card">
    <div class="offset-sm-2 col-sm-8 offset-md-3 col-md-6">
        <div class="box">
            <input id="Codigo" value='<?=$transferenciaAdministrativo->CodigoTransferencia?>' hidden>
            <table class="table table-bordered table-striped " width="10%">
                <tr>
                    <th style="background-color: #5095ff; color: white" >Motivo</th>
                    <td style="background-color: white;" ><?= $transferenciaAdministrativo->Motivo ?><input type="text" disabled hidden  id="Motivo" value="<?=$transferenciaAdministrativo->CodigoTransferencia?>"></td>
                </tr>
                <tr>
                    <th style="background-color: #5095ff; color: white" > Inicio Transferencia</th>
                    <td style="background-color: white;" ><?= date_format(date_create($transferenciaAdministrativo->FechaInicioTransferencia), 'd/m/Y') ?></td>
                </tr>
                <tr>
                    <th style="background-color: #5095ff; color: white" > Fin Asignacion</th>
                    <td style="background-color: white;" ><?= date_format(date_create($transferenciaAdministrativo->FechaFinAsignacion), 'd/m/Y') ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<br/>
<div class="card">
    <div class="card-header">
        <button id="btnMostrarAgregarAsignaciones" name="btnMostrarAgregarAsignaciones" codigo="" class="btn btn-primary"
                data-toggle="modal" data-target="#modalAgregarAsignacion">
            Agregar Trabajador
        </button>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped dt-responsive tablaAsignacionesSeleccionadas" width="100%">
            <thead>
            <tr class="vertical-align: middle">
                <th style="width:10px">#</th>
                <th>Id Funcionario</th>
                <th>C.I</th>
                <th>Nombre Completo</th>
                <th>Unidad</th>
                <th>Cargo</th>
                <th>Nivel Salarial</th>
                <th>Acciones</th>
            </tr>
            </thead>
        </table>
        <button id="btnirTransferenciaAsignacion" name="btnirTransferenciaAsignacion" codigo="" class="btn btn-primary">
            Continuar
        </button>
    </div>
</div>
<!--=====================================
MODAL AGREGAR ASIGNACION
======================================-->
<div id="modalAgregarAsignacion" class="modal fade" role="dialog"  data-backdrop="static" >
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Agregar Asignacion</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--==============================================
                    DATOS DE LA NUEVA ASIGNACION
                    ================================================-->
                    <table class="table table-bordered table-striped dt-responsive tablaAsignaciones" width="100%">
                        <thead>
                        <tr class="vertical-align: middle">
                            <th style="text-align: center; vertical-align: middle;">#</th>
                            <th style="text-align: center; vertical-align: middle;">Id Funcionario</th>
                            <th style="text-align: center; vertical-align: middle;">C.I.</th>
                            <th style="text-align: center; vertical-align: middle;">Nombre Completo</th>
                            <th style="text-align: center; vertical-align: middle;">Unidad</th>
                            <th style="text-align: center; vertical-align: middle;">Cargo</th>
                            <th style="text-align: center; vertical-align: middle;">Nivel Salarial</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnGuardarTransferenciaDetalleAdministrativo" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
