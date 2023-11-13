<?php

use yii\web\JqueryAsset;

app\modules\Filiacion\assets\FiliacionAsset::register($this);

$this->registerJsFile("@web/js/transferencia-administrativo/transferenciaadministrativo.js",[
    'depends' => [
        JqueryAsset::className()
    ]
]);
$this->title = 'Transferencias Administrativos';
$this->params['breadcrumbs'] = [['label' => 'Trasnferencias Adm.']];

?>
<div class="card">
    <div class="card-header">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalCrearTransferenciaAdministrativo">
            Nuevo
        </button>
    </div>
    <br/>
    <div class="card-body">
        <table class="table table-bordered table-striped dt-responsive tablaTransferenciaAdministrativo" width="100%">
            <thead>
            <tr>
                <th style="width:10px">#</th>
                <th>Codigo</th>
                <th>Motivo</th>
                <th>Fecha Transferencia</th>
                <th>Fecha Fin Asignacion</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<!--=====================================
MODAL CREAR TRANSFERENCIA ADMINISTRATIVO
======================================-->
<div id="modalCrearTransferenciaAdministrativo" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Agregar Transferencia Administrativo</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--=====================================
                    DATOS DE LA NUEVA TRANSFERENCIA ADMINISTARTIVO
                    ======================================-->
                    <div class="form-group">
                        <label for="motivoNew" class="control-label">Motivo</label>
                        <input id="motivoNew" name="motivoNew" type="text"
                               maxlength="150"
                               placeholder="Ingresar motivo de la trasnferencia" required
                               class="form-control input-lg">
                        <div class="form-group entrada-datos">
                            <label for="fechaInicioTransferenciaNew" class="control-label">Inicio de Transferencia</label>
                            <input id="fechaInicioTransferenciaNew" name="fechaInicioTransferenciaNew" type="date" maxlength="150"
                                   placeholder="Ingresar inicio de Transferencia." class="form-control input-lg">
                        </div>
                        <div class="form-group entrada-datos" hidden>
                            <label for="fechaFinAsignacionNew" class="control-label">Fecha Fin de Asignacion</label>
                            <input id="fechaFinAsignacionNew" name="fechaFinAsignacionNew" type="date" maxlength="150"
                                   placeholder="Ingresar fin de Asignacion." class="form-control input-lg">
                        </div>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnCrearTransferenciaAdministrativo" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!--=====================================
MODAL ACTUALIZAR TRANSFERENCIA ADMINISTRATIVO
======================================-->
<div id="modalActualizarTransferenciaAdministrativo" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Editar Transferencia Administrativo</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            CUERPO DEL MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--============================================
                     DATOS DE LA TRANSFERENCIA ADMINISTRATIVO
                     =============================================-->
                    <div class="form-group">
                        <label for="motivoUpd" class="control-label">Motivo</label>
                        <input id="codigoTransferenciaUpd" name="codigoTransferenciaUpd" type="hidden"
                               maxlength="150" hidden
                               class="form-control input-lg">
                        <input id="motivoUpd" name="motivoUpd" type="text"
                               maxlength="150"
                               placeholder="Ingresar el motivo de la transferencia" required
                               class="form-control input-lg">
                        <div class="form-group entrada-datos">
                            <label for="fechaInicioTransferenciaUpd" class="control-label">Fecha de Transferencia</label>
                            <input id="fechaInicioTransferenciaUpd" name="fechaInicioTransferenciaUpd" type="date" maxlength="150"
                                   placeholder="Ingresar inicio de Transferencia." class="form-control input-lg">
                        </div>
                        <div class="form-group entrada-datos" hidden>
                            <label for="fechaFinAsignacionUpd" class="control-label">Fecha Fin Asignacion</label>
                            <input id="fechaFinAsignacionUpd" name="fechaFinAsignacionUpd" type="date" maxlength="150"
                                   placeholder="Ingresar fin de Asignacion." class="form-control input-lg">
                        </div>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnActualizarTransferenciaAdministrativo" class="btn btn-primary">Guardar
                </button>
            </div>
        </div>
    </div>
</div>