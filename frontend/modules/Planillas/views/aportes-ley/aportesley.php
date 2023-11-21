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
VISTA CREAR / EDITAR APORTE DE LEY
======================================-->
<div id="vistaAportes" class="card">
    <div class="card-header">
        <!-- <button id="btnMostrarSeleccionarPersona" name="btnMostrarSeleccionarPersona" class="btn btn-primary">
            Agregar Aporte
        </button> -->
        <button id="nuevoAporte" class="btn btn-primary" codigo=0 data-toggle="modal" data-target="#modalActualizarAporte"><i class="fa fa-file"></i> Nuevo Aporte de Ley</button>
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

<!--=====================================
MODAL ACTUALIZAR APORTE
======================================-->
<div id="modalActualizarAporte" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title" id="tituloAporte"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <!--=====================================
                     DATOS DE APORTE A MODIFICAR
                     ======================================-->
                    <div class="form-group entrada-datos">
                        <label for="codigoAporteLeyUpd" class="control-label">Identificacion</label>
                        <input id="codigoAporteLeyUpd" name="codigoAporteLeyUpd" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="nombreAporteLeyUpd" class="control-label">Nombre Aporte de Ley</label>
                        <input id="nombreAporteLeyUpd" name="nombreAporteLeyUpd" type="text" maxlength="150" 
                               class="form-control input-lg" style="text-transform:uppercase" required>
                    </div>

                    <div class="form-group entrada-datos">
                        <label for="tipoAporteUpd">Tipo de Aporte</label>
                        <select id="tipoAporteUpd" name="tipoAporteUpd" class="form-control input-lg" style="text-transform:uppercase" required>
                            <option value="">Selecionar Tipo</option>
                            <option value="Laboral">Laboral</option>
                            <option value="Patronal">Patronal</option>
                        </select>
                    </div>

                    <div class="form-group entrada-datos">
                        <label for="porcentajeUpd" class="control-label">Porcentaje de Aporte</label>
                        <input id="porcentajeUpd" name="porcentajeUpd" type="text" maxlength="150"
                               placeholder="Ingresar segundo nombre de la persona" required
                               class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="montoSalarioUpd" class="control-label">Monto desde que se aplica</label>
                        <input id="montoSalarioUpd" name="montoSalarioUpd" type="text" maxlength="150"
                               placeholder="Ingresar tercer nombre de la persona"
                               class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="observacionesUpd" class="control-label">Obervaciones</label>
                        <textarea name="observacionesUpd" id="observacionesUpd" cols="20" rows="4" class="form-control input-lg" style="text-transform:uppercase"></textarea>
                    </div>
                   
                    <div class="form-group entrada-datos">
                        <label for="codigoEstadoUpd">Estado del Aporte de Ley</label>
                        <select id="codigoEstadoUpd" name="codigoEstadoUpd" class="form-control input-lg">
                            <option value="">Selecionar Estado</option>
                            <option value="V">VALIDO</option>
                            <option value="C">CADUCADO</option>
                        </select>
                    </div>
                    
                    <input id="fechaHoraRegistroUpd" name="fechaHoraRegistroUpd" type="text" maxlength="150" hidden>
                    <input id="codigoUsuarioUpd" name="codigoUsuarioUpd" type="text" maxlength="150" hidden>
                    
                </div>
            </div>
            <!--=====================================
            FOOTER MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnActualizarAporte" class="btn btn-primary">Guardar
                </button>
            </div>
        </div>
    </div>
</div>

