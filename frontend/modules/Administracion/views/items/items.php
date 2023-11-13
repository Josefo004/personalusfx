<?php

use yii\web\JqueryAsset;

app\modules\Administracion\assets\AdministracionAsset::register($this);

$this->registerJsFile("@web/js/items/items.js", [
    'depends' => [
        JqueryAsset::className()
    ]
]);

$this->title = 'Administración Items';
$this->params['breadcrumbs'] = [['label' => 'Admin. Items']];
?>

<div class="card">
    <div class="card-header">
        <button id="btnMostrarCrearItem" name="btnMostrarCrearItem" class="btn btn-primary" data-toggle="modal" data-target="#modalCrearItem">
            Nuevo
        </button>
    </div>
    <br/>
    <div class="card-body">
        <table class="table table-bordered table-striped dt-responsive tablaItems" width="100%">
            <thead>
            <tr>
                <th style="text-align: center; font-weight: bold;">#</th>
                <th style="text-align: center; font-weight: bold;">Numero de Item</th>
                <!--<th style="text-align: center; font-weight: bold;">Item RRHH</th>
                <th style="text-align: center; font-weight: bold;">Item Planillas</th>-->
                <th style="text-align: center; font-weight: bold;">Sector</th>
                <th style="text-align: center; font-weight: bold;">Unidad</th>
                <th style="text-align: center; font-weight: bold;">Cargo</th>
                <th style="text-align: center; font-weight: bold;">Dependencia</th>
                <th style="text-align: center; font-weight: bold;">Estado</th>
                <th style="text-align: center; font-weight: bold;">Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>


<!--=====================================
MODAL CREAR ITEM
======================================-->
<div id="modalCrearItem" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Agregar Item</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--=====================================
                    DATOS DEL NUEVO ITEM
                    ======================================-->
                    <div class="form-group">
                        <label for=" codigoUnidadNew" class="control-label">Elegir Unidad</label>
                        <select id="codigoUnidadNew" name="codigoUnidadNew"
                                class="form-control input-lg" style="width: 100%">
                        </select>
                    </div>
                    <div class="form-group">
                        <input id="nroItemUpd" name="nroItemUpd" type="hidden" maxlength="150" hidden
                               class="form-control input-lg">
                        <label for="codigoSectorTrabajoNew">Sector de Trabajo</label>
                        <select id="codigoSectorTrabajoNew" name="codigoSectorTrabajoNew" required
                                class="form-control input-lg" style="width: 100%">
                            <option value="">Seleccionar Sector</option>
                            <?php
                            foreach ($sectoresTrabajo as $codigo => $nombre) {
                                echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for=" codigoCargoNew">Cargo</label>
                        <select id="codigoCargoNew" name="codigoCargoNew" required
                                class="form-control input-lg" style="width: 100%;">
                            <option value="">Seleccionar Cargo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for=" codigoCargoDependenciaNew">Dependencia</label>
                        <select id="codigoCargoDependenciaNew" name="codigoCargoDependenciaNew" required
                                class="form-control input-lg" style="width: 100%;">
                            <option value="">Seleccionar Cargo</option>
                        </select>
                    </div>
                    <div class="form-group>
                        <label for="nroItemPlanillasNew" class="control-label">Nro de Item</label>
                        <input id="nroItemPlanillasNew" name="nroItemPlanillasNew" type="text" maxlength="150"
                               placeholder="Ingresar Nro de Item" required class="form-control input-lg">
                    </div>
                    <!--<div class="row"hidden>
                        <div class="form-group col-md-6 ml-auto">
                            <label for="nroItemPlanillasNew" class="control-label">Nro de Item</label>
                            <input id="nroItemPlanillasNew" name="nroItemPlanillasNew" type="text" maxlength="150"
                                   placeholder="Ingresar el Item de Planillas" required class="form-control input-lg">
                        </div>
                        <div class="form-group col-md-6 ml-auto" hidden>
                            <label for="nroItemRrhhNew" class="control-label">Item RRHH</label>
                            <input id="nroItemRrhhNew" name="nroItemTextoNew" type="text" maxlength="150"
                                   placeholder="Ingresar el Item de RRHH" required class="form-control input-lg">
                        </div>
                    </div>-->
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnCrearItem" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!--=====================================
MODAL ACTUALIZAR ITEM
======================================-->
<div id="modalActualizarItem" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Editar Item</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            CUERPO DEL MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--=====================================
                     DATOS DEL ITEM MODIFICADO
                     ======================================-->
                    <div class="form-group">
                        <label for="nombreSectorTrabajoUpd">Sector de Trabajo</label>
                        <input id="nombreSectorTrabajoUpd" name="nombreSectorTrabajoUpd" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="form-group">
                        <label for="nombreUnidadUpd" class="control-label">Unidad Actual</label>
                        <input id="nombreUnidadUpd" name="nombreUnidadUpd" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="form-group">
                        <label for="codigoUnidadUpd" class="control-label">Elegir unidad</label>
                        <select id="codigoUnidadUpd" name="codigoUnidadUpd"
                                class="form-control input-lg" style="width: 100%">
                        </select>
                    </div>
                   <!-- <div class="form-group">
                        <label for="codigoUnidadUpd">Unidad</label>
                        <select id="codigoUnidadUpd" name="codigoUnidadUpd" required
                                class="form-control input-lg" style="width: 100%">
                            <option value="">Seleccionar Unidad</option>
                            <?php
/*                            foreach ($unidades as $unidad) {
                                echo "<option value='" . $unidad->CodigoUnidad . "'>" . strtoupper($unidad->NombreUnidad) . "</option>";
                            }
                            */?>
                        </select>
                    </div>-->
                    <div class="form-group">
                        <label for="codigoCargoUpd" class="control-label">Cargo</label>
                        <select id="codigoCargoUpd" name="codigoCargoUpd" required style="width: 100%"
                                class="form-control input-lg">
                            <option value="">Seleccionar Cargo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="codigoCargoDependenciaUpd" class="control-label">Dependencia</label>
                        <select id="codigoCargoDependenciaUpd" name="codigoCargoDependenciaUpd" required style="width: 100%"
                                class="form-control input-lg">
                            <option value="">Seleccionar Cargo</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 ml-auto">
                            <label for="nroItemPlanillasUpd" class="control-label">Item Planillas</label>
                            <input id="nroItemPlanillasUpd" name="nroItemPlanillasUpd" type="text" maxlength="150"
                                   placeholder="Ingresar el Item de Planillas" required class="form-control input-lg">
                        </div>
                        <div class="form-group col-md-6 ml-auto">
                            <label for="nroItemRrhhUpd" class="control-label">Item RRHH</label>
                            <input id="nroItemRrhhUpd" name="nroItemTextoUpd" type="text" maxlength="150"
                                   placeholder="Ingresar el Item de RRHH" required class="form-control input-lg">
                        </div>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnActualizarItem" class="btn btn-primary">Guardar
                </button>
            </div>
        </div>
    </div>
</div>