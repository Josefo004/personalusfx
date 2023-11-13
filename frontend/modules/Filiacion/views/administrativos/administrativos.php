<?php

use yii\web\JqueryAsset;

app\modules\Filiacion\assets\FiliacionAsset::register($this);

$this->registerJsFile("@web/js/administrativos/administrativos.js", [
    'depends' => [
        JqueryAsset::className()
    ]
]);
$this->title = 'Administración Administrativos';
$this->params['breadcrumbs'] = [['label' => 'Admin. Administrativos']];
?>

<div id="vistaAdministrativos" class="card">
    <div class="card-header">
        <button id="btnMostrarCrearAdministrativo" name="btnMostrarCrearAdministrativo" class="btn btn-primary"
                data-toggle="modal" data-target="#modalCrearAdministrativo">
            Agregar Administrativo
        </button>
    </div>
    <br/>
    <div class="card-body">
        <table id="tablaAdministrativos" class="table table-bordered table-striped dt-responsive tablaAdministrativos"
               width="100%">
            <thead>
            <tr>
                <th style="width:10px">#</th>
                <th>IdFuncionario</th>
                <th>C.I.</th>
                <th>Nombre Completo</th>
                <th>Fecha de Ingreso</th>
                <th>Nivel Salarial</th>
                <th>Condicion Laboral</th>
                <th>Fechas de Salida</th>
                <th>Memorandom</th>
                <th>Tiempo de Trabajo</th>
                <th>Observaciones</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<!--=====================================
VISTA SELECCIONAR FUNCIONARIO
======================================-->
<div id="vistaFuncionarios" class="card">
    <div class="card-body">
        <table id="tablaFuncionarios" name="tablaFuncionarios"
               class="table table-bordered table-striped dt-responsive tablaFuncionarios"
               width="100%">
            <p align="center">*Seleccione el item que desea guardar</p>
            <thead>
            <tr>
                <th style="width:10px">#</th>
                <th>Id Funcionario</th>
                <th>Id Persona</th>
                <th>Nombre Completo</th>
                <th>Acciones</th>
            </tr>
            </thead>
        </table>
        <div align="center">
            <button id="btnCancelar" class="btn btn-danger">
                Salir
            </button>
        </div>
    </div>
</div>
<!--=====================================
VISTA CREAR ADMINISTRATIVO
======================================-->
<div id="vistaCrearAdministrativoPestañas" class="card">
    <div class="card-header">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="datos-administrativo-tab" data-toggle="tab" href="#datos-administrativo"
                   role="tab"
                   aria-controls="datos-administrativo"
                   aria-selected="true"></a>
            </li>
        </ul>
    </div>
    <div class="tab-content mytab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="datos-administrativo" role="tabpanel"
             aria-labelledby="datos-administrativo-tab">
            <div class="col d-flex justify-content-center">
                <div class="card " style="width: 85rem;">
                    <div class="card-header bg-gradient-primary">Ingreso Datos</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="idFuncionarioNew" class="control-label">Id Funcionario.</label>
                                    <input id="idFuncionarioNew" name="idFuncionarioNew" type="text"
                                           maxlength="150"
                                           readonly="true" class="form-control input-lg">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="idPersonaNew" class="control-label">C.I.</label>
                                    <input id="idPersonaNew" name="idPersonaNew" type="text" maxlength="150"
                                           readonly="true" class="form-control input-lg">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="nombreCompletoNew" class="control-label">Nombre Completo</label>
                                    <input id="nombreCompletoNew" name="nombreCompletoNew" type="text" maxlength="150"
                                           readonly="true" class="form-control input-lg">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="codigoSectorTrabajoNew ">Sector de Trabajo</label>
                                    <select id="codigoSectorTrabajoNew" name="codigoSectorTrabajoNew" required
                                            style="width: 100%"
                                            class="form-control input-lg codigoSectorTrabajo"
                                            onChange="getSectorTrabajo(this.value);">
                                        <option value="">Selecionar Sector</option>
                                        <?php
                                        foreach ($sectorTrabajo as $codigo => $nombre) {
                                            echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="codigoCondicionLaboralNew">Condicion Laboral</label>
                                    <!--<select id="codigoCondicionLaboralNew" name="codigoCondicionLaboralNew" required
                                            class="form-control input-lg" style="width: 100%;">
                                        <option value="">Selecionar Condicion Laboral</option>
                                        <?php
                                    /*                                        foreach ($condicionLaboral as $codigo => $nombre) {
                                                                                echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                                                            }
                                                                            */ ?>
                                    </select>-->
                                    <select id="codigoCondicionLaboralNew" name="codigoCondicionLaboralNew" required
                                            class="form-control input-lg codigoCondicionLaboral " style="width: 100%"
                                            disabled>
                                        <option value="">Selecionar Condicion Laboral</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="codigoCargoNew">Cargo</label>
                                    <select id="codigoCargoNew" name="codigoCargoNew" required
                                            class="form-control input-lg codigoCargo select2" style="width: 100%;"
                                            disabled>
                                        <option value="">Selecionar Cargo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="idItemNew">Item</label>
                                    <!--<select id="idItemNew" name="idItemNew" required
                                            class="form-control input-lg" style="width: 100%;">
                                        <option value="">Selecionar Item</option>
                                        <?php
                                    /*                                        foreach ($item as $codigo => $nombre) {
                                                                                echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                                                            }
                                                                            */ ?>
                                    </select>-->
                                    <select id="idItemNew" name="idItemNew" required
                                            class="form-control input-lg nroItem select2" style="width: 100%"
                                            disabled>
                                        <option value="">Selecionar Item</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="fechaIngresoNew" class="control-label">Fecha Ingreso</label>
                                    <input id="fechaIngresoNew" name="fechaIngresoNew" type="date"
                                           maxlength="150"
                                           placeholder="Ingresar fecha de ingreso." class="form-control input-lg">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="codigoNivelSalarialNew">Nivel Salarial</label>
                                    <!--<select id="codigoNivelSalarialNew" name="codigoNivelSalarialNew" required
                                            class="form-control input-lg" style="width: 100%;">
                                        <option value="">Selecionar Nivel Salarial</option>
                                        <?php
                                    /*                                        foreach ($nivelSalarial as $codigo => $nombre) {
                                                                                echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                                                            }
                                                                            */ ?>
                                    </select>-->
                                    <select id="codigoNivelSalarialNew" name="codigoNivelSalarialNew" required
                                            class="form-control input-lg codigoNivelSalarial select2"
                                            style="width: 100%"
                                            disabled>
                                        <option value="">Selecionar Nivel Salarial</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="nroMemorandoNew" class="control-label">Nro Memorando</label>
                                    <input id="nroMemorandoNew" name="nroMemorandoNew" type="text"
                                           maxlength="150"
                                           placeholder="Ingresar nro memorando."
                                           class="form-control input-lg">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="codigoTiempoTrabajoNew">Tiempo Trabajo</label>
                                    <select id="codigoTiempoTrabajoNew" name="codigoTiempoTrabajoNew" required
                                            class="form-control input-lg" style="width: 100%;">
                                        <option value="">Selecionar Tiempo Trabajo</option>
                                        <?php
                                        foreach ($tiempoTrabajo as $codigo => $nombre) {
                                            echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="observacionesNew" class="control-label">Observaciones</label>
                                    <input id="observacionesNew" name="observacionesNew" type="text"
                                           maxlength="150"
                                           placeholder="Ingresar observaciones."
                                           class="form-control input-lg">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="fechaSalidaNew" class="control-label">Fecha Salida</label>
                                    <input id="fechaSalidaNew" name="fechaSalidaNew" type="date"
                                           maxlength="150"
                                           placeholder="Ingresar fecha de salida." class="form-control input-lg">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="card-footer text-center">
                        <button type="submit" id="btnCrearAdministrativo"
                                class='btn btn-primary bg-gradient-primary'>
                            <i class='fa fa-check-circle-o'>Guardar</i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--=====================================
MODAL ACTUALIZAR ADMINISTRATIVO
======================================-->
<div id="modalActualizarAdministrativo" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Editar Administrativo</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            CUERPO DEL MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--=====================================
                     DATOS DEL ADMINISTRATIVO MODIFICADO
                     ======================================-->
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="idFuncionarioUpd" class="control-label">Id Funcionario.</label>
                                <input id="idFuncionarioUpd" name="idFuncionarioUpd" type="text"
                                       maxlength="150"
                                       readonly="true" class="form-control input-lg">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="idPersonaUpd" class="control-label">C.I.</label>
                                <input id="idPersonaUpd" name="idPersonaUpd" type="text" maxlength="150"
                                       readonly="true" class="form-control input-lg">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="nombreCompletoUpd" class="control-label">Nombre Completo</label>
                                <input id="nombreCompletoUpd" name="nombreCompletoUpd" type="text" maxlength="150"
                                       readonly="true" class="form-control input-lg">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="codigoSectorTrabajoUpd ">Sector de Trabajo</label>
                                <select id="codigoSectorTrabajoUpd" name="codigoSectorTrabajoUpd" required
                                        style="width: 100%"
                                        class="form-control input-lg codigoSectorTrabajo"
                                        onChange="getSectorTrabajo(this.value);">
                                    <option value="">Selecionar Sector</option>
                                    <?php
                                    foreach ($sectorTrabajo as $codigo => $nombre) {
                                        echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="codigoCondicionLaboralUpd">Condicion Laboral</label>
                                <!--<select id="codigoCondicionLaboralNew" name="codigoCondicionLaboralNew" required
                                            class="form-control input-lg" style="width: 100%;">
                                        <option value="">Selecionar Condicion Laboral</option>
                                        <?php
                                /*                                        foreach ($condicionLaboral as $codigo => $nombre) {
                                                                            echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                                                        }
                                                                        */ ?>
                                    </select>-->
                                <select id="codigoCondicionLaboralUpd" name="codigoCondicionLaboralUpd" required
                                        class="form-control input-lg codigoCondicionLaboral " style="width: 100%">
                                    <option value="">Selecionar Condicion Laboral</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="codigoCargoUpd">Cargo</label>
                                <select id="codigoCargoUpd" name="codigoCargoUpd" required
                                        class="form-control input-lg codigoCargo select2" style="width: 100%;">
                                    <option value="">Selecionar Cargo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="idItemUpd">Item</label>
                                <!--<select id="idItemNew" name="idItemNew" required
                                            class="form-control input-lg" style="width: 100%;">
                                        <option value="">Selecionar Item</option>
                                        <?php
                                /*                                        foreach ($item as $codigo => $nombre) {
                                                                            echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                                                        }
                                                                        */ ?>
                                    </select>-->
                                <select id="idItemUpd" name="idItemUpd" required
                                        class="form-control input-lg nroItem select2 nroItem" style="width: 100%">
                                    <option value="">Selecionar Item</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="fechaIngresoUpd" class="control-label">Fecha Ingreso</label>
                                <input id="fechaIngresoUpd" name="fechaIngresoUpd" type="date"
                                       maxlength="150"
                                       placeholder="Ingresar fecha de ingreso." class="form-control input-lg">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="codigoNivelSalarialUpd">Nivel Salarial</label>
                                <!--<select id="codigoNivelSalarialNew" name="codigoNivelSalarialNew" required
                                            class="form-control input-lg" style="width: 100%;">
                                        <option value="">Selecionar Nivel Salarial</option>
                                        <?php
                                /*                                        foreach ($nivelSalarial as $codigo => $nombre) {
                                                                            echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                                                        }
                                                                        */ ?>
                                    </select>-->
                                <select id="codigoNivelSalarialUpd" name="codigoNivelSalarialUpd" required
                                        class="form-control input-lg codigoNivelSalarial select2"
                                        style="width: 100%">
                                    <option value="">Selecionar Nivel Salarial</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="nroMemorandoUpd" class="control-label">Nro Memorando</label>
                                <input id="nroMemorandoUpd" name="nroMemorandoUpd" type="text"
                                       maxlength="150"
                                       placeholder="Ingresar nro memorando."
                                       class="form-control input-lg">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="codigoTiempoTrabajoUpd">Tiempo Trabajo</label>
                                <select id="codigoTiempoTrabajoUpd" name="codigoTiempoTrabajoUpd" required
                                        class="form-control input-lg" style="width: 100%;">
                                    <option value="">Selecionar Tiempo Trabajo</option>
                                    <?php
                                    foreach ($tiempoTrabajo as $codigo => $nombre) {
                                        echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="observacionesUpd" class="control-label">Observaciones</label>
                                <input id="observacionesUpd" name="observacionesUpd" type="text"
                                       maxlength="150"
                                       placeholder="Ingresar observaciones."
                                       class="form-control input-lg">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="fechaSalidaUpd" class="control-label">Fecha Salida</label>
                                <input id="fechaSalidaUpd" name="fechaSalidaUpd" type="date"
                                       maxlength="150"
                                       placeholder="Ingresar fecha de salida." class="form-control input-lg">
                            </div>
                        </div>
                    </div>
            </div>
            <!--=====================================
            FOOTER MODAL
            ======================================-->
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnActualizarAdministrativo" class="btn btn-primary">Guardar
                </button>
            </div>
        </div>
    </div>
</div>