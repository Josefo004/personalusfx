<?php

use yii\web\JqueryAsset;

app\modules\Filiacion\assets\FiliacionAsset::register($this);

$this->registerJsFile("@web/js/asignaciones/asignaciones.js", [
    'depends' => [
        JqueryAsset::className()
    ]
]);
$this->title = 'Administración Asignaciones';
$this->params['breadcrumbs'] = [['label' => 'Admin. Asignaciones']];
?>

<div id="vistaAsignaciones" class="card">
    <div class="card-header">
        <button id="btnMostrarCrearAsignacion" name="btnMostrarCrearAsignacion" class="btn btn-primary"
                data-toggle="modal" data-target="#modalCrearAsignacion">
            Nuevo
        </button>
    </div>
    <br/>
    <div class="card-body">
        <table id="tablaAsignaciones" class="table table-bordered table-striped dt-responsive tablaAsignaciones" width="100%">
            <thead>
            <tr>
                <th style="width:10px">#</th>
                <th>Funcionario</th>
                <th>Unidad</th>
                <th>Cargo</th>
                <th>Asignacion</th>
                <th>Duracion</th>
                <th>Jefatura</th>
                <th>Documento</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<!--=====================================
MODAL AGREGAR TRABAJADOR
======================================
<div id="modalCrearAsignacion" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Agregar Asigacion</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================
            <div class="modal-body">
                <div class="box-body">
                    <!--==============================================
                    DATOS DEL NUEVO TRABAJADOR A ASIGNACION
                    ================================================
                    <table class="table table-bordered table-striped dt-responsive tablaTrabajadores" width="100%">
                        <thead>
                        <tr>
                            <th style="width:10px">#</th>
                            <th>Codigo</th>
                            <th>Id Persona</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                    </table>
                    <div class=" entrada-datos form-group">
                        <label for="nombreCompletoNew" class="control-label">Nombre</label>
                        <input id="nombreCompletoNew" name="nombreCompletoNew" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="entrada-datos form-group">
                        <label for="idPersonaNew" class="control-label">C.I.</label>
                        <input id="idPersonaNew" name="idPersonaNew" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="entrada-datos form-group" hidden>
                        <label for="codigoTrabajadorNew" class="control-label">C.I.</label>
                        <input id="codigoTrabajadorNew" name="codigoTrabajadorNew" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos2" style="display: none;">
                        <label for="codigoUnidadNew" class="control-label">Elegir unidad</label>
                        <select id="codigoUnidadNew" name="codigoUnidadNew"
                                class="form-control input-lg listaUnidadesnew" style="width: 100%">
                        </select>
                    </div>
                    <div class="entrada-datos form-group" style="display: none;">
                        <label for="codigoSectorTrabajoNew ">Sector de Trabajo</label>
                        <select id="codigoSectorTrabajoNew" name="codigoSectorTrabajoNew" required style="width: 100%"
                                class="form-control input-lg codigoSectorTrabajo"
                                onChange="getSectorTrabajo(this.value);">
                            <option value="">Selecionar Sector</option>
                            <?php
/*                            foreach ($sectoresTrabajo as $codigo => $nombre) {
                                echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                            }
                            */ ?>
                        </select>
                    </div>
                    <div class="entrada-datos1 form-group">
                        <label for="codigoCondicionLaboralNew">Condicion Laboral</label>
                        <select id="codigoCondicionLaboralNew" name="codigoCondicionLaboralNew" required
                                class="form-control input-lg codigoCondicionLaboral " style="width: 100%"
                                disabled>
                            <option value="">Selecionar Condicion Laboral</option>
                        </select>
                    </div>
                    <div class="row entrada-datos-sector" style="width: 100%" hidden>
                        <div class="form-group">
                            <label for="codigoSectorTrabajoShow" class="control-label">Sector Trabajo</label>
                            <input id="codigoSectorTrabajoShow" name="codigoSectorTrabajoShow" type="text"
                                   maxlength="150"
                                   readonly="true" class="form-control input-lg" hidden>
                            <input id="nombreSectorTrabajoShow" name="nombreSectorTrabajoShow" type="text"
                                   maxlength="150"
                                   readonly="true" class="form-control input-lg">
                        </div>
                        <div class="form-group">
                            <label for="codigoCondicionLaboralShow" class="control-label">CondicionLaboral</label>
                            <input id="codigoCondicionLaboralShow" name="codigoCondicionLaboralShow" type="text"
                                   maxlength="150"
                                   readonly="true" class="form-control input-lg" hidden>
                            <input id="nombreCondicionLaboralShow" name="nombreCondicionLaboralShow" type="text"
                                   maxlength="150"
                                   readonly="true" class="form-control input-lg">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 ml-auto">
                            <label for="codigoAsignacionNew" class="control-label" hidden>Asignacion</label>
                            <input id="codigoAsignacionNew" name="codigoAsignacionNew" type="text" maxlength="150"
                                   readonly="true" class="form-control input-lg" hidden>
                        </div>
                        <div class="form-group col-md-6 ml-auto">
                            <label for="codigoTrabajadorNew" class="control-label" hidden>Codigo</label>
                            <input id="codigoTrabajadorNew" name="codigoTrabajadorNew" type="text" maxlength="150"
                                   readonly="true" class="form-control input-lg" hidden>
                        </div>
                    </div>
                    <div class="form-group entrada-datos3" style="display: none;">
                        <label for="codigoCargoNew">Cargo</label>
                        <select id="codigoCargoNew" name="codigoCargoNew" required
                                class="form-control input-lg codigoCargo select2" style="width: 100%;"
                                disabled>
                            <option value="">Selecionar Cargo</option>
                        </select>
                    </div>
                    <div class="form-group entrada-datos4">
                        <label for="nroItemNew">Item</label>
                        <select id="nroItemNew" name="nroItemNew" required
                                class="form-control input-lg nroItem select2" style="width: 100%"
                                disabled>
                            <option value="">Selecionar Item</option>
                        </select>
                        <br><br>
                        <center>
                            <button type="button" id="btnCrearItemNew" class="btn btn-primary entrada-datos">CrearItem
                            </button>
                        </center>
                    </div>
                    <div class="row entrada-datos5" style="display: none;">
                        <div class="form-group col-md-6 ml-auto">
                            <label for="fechaInicioNew" class="control-label">Fecha Inicio</label>
                            <input id="fechaInicioNew" name="fechaInicioNew" type="date" maxlength="150"
                                   placeholder="Ingresar fecha de inicio." class="form-control input-lg">
                        </div>
                        <div class="form-group col-md-6 ml-auto">
                            <label for="fechaFinNew" class="control-label">Fecha Fin</label>
                            <input id="fechaFinNew" name="fechaFinNew" type="date" maxlength="150"
                                   placeholder="Ingresar fechafin." class="form-control input-lg">
                        </div>
                    </div>
                    <div class="row entrada-datos5" style="display: none;">
                        <div class="form-group col-md-6 ml-auto">
                            <label for="jefaturaNew">Jefatura</label>
                            <select id="jefaturaNew" name="jefaturaNew" required
                                    class="form-control input-lg">
                                <option value="">Selecionar si ocupa una jefatura</option>
                                <option value="0">SI</option>
                                <option value="1">NO</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6 ml-auto">
                            <label for="codigoNivelSalarialNew">Nivel Salarial</label>
                            <select id="codigoNivelSalarialNew" name="codigoNivelSalarialNew" required
                                    class="form-control input-lg codigoNivelSalarial select2" style="width: 100%"
                                    disabled>
                                <option value="">Selecionar Nivel Salarial</option>
                            </select>
                        </div>
                    </div>
                    <div class="row entrada-datos5" style="display: none;">
                        <div class="form-group col-md-6 ml-auto">
                            <label for="nroDocumentoNew" class="control-label">Documento</label>
                            <input id="nroDocumentoNew" name="nroDocumentoNew" maxlength="120" rows="1"
                                   placeholder="Documento"
                                   class="form-control input-lg">
                        </div>
                        <div class="form-group col-md-6 ml-auto">
                            <label for="fechaDocumentoNew" class="control-label">Fecha Documento</label>
                            <input id="fechaDocumentoNew" name="fechaDocumentoNew" type="date" maxlength="150"
                                   placeholder="Ingresar fechafin." class="form-control input-lg">
                        </div>
                    </div>
                    <div class="row entrada-datos5">
                        <div class="form-group col-md-6 ml-auto">
                            <label for="tipoDocumentoNew">Tipo de Documento</label>
                            <select id="tipoDocumentoNew" name="tipoDocumentoNew" required style="width: 100%"
                                    class="form-control input-lg tipoDocumento">
                                <option value="">Seleccionar tipo de documento</option>
                                <?php
/*                                foreach ($tiposDocumento as $codigo => $nombre) {
                                    echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                }
                                */ ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6 ml-auto">
                            <label for="interinatoNew">Interinato</label>
                            <select id="interinatoNew" name="interinatoNew" required
                                    class="form-control input-lg">
                                <option value="">Seleccionar si el cargo es interinato</option>
                                <option value="0">SI</option>
                                <option value="1">NO</option>
                            </select>
                        </div>
                    </div>
                    <div class="row entrada-datos5">
                        <div class="form-group col-md-6 ml-center">
                            <label for="codigoTiempoTrabajoNew" class="control-label">Horas Trabajadas</label>
                            <select id="codigoTiempoTrabajoNew" name="codigoTiempoTrabajoNew" required
                                    style="width: 100%"
                                    class="form-control input-lg tipoDocumento">
                                <option value="">Seleccionar tiempo de trabajo</option>
                                <?php
/*                                foreach ($tiemposTrabajo as $codigo => $nombre) {
                                    echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                }
                                */ ?>
                            </select>
                        </div>
                    </div>
                    <center>
                        <form method="post" action="#" enctype="multipart/form-data" class="form-group entrada-datos5">
                            <div class="card" style="width: 18rem;">
                                <img class="card-img-top" src="img/memo.jpg">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="imagenNew">Sube Memorandum</label>
                                        <input type="file" class="form-control-file" name="imagenNew" id="imagenNew">
                                    </div>
                                    <input type="button" class="btn btn-primary upload" id="uploadNew"
                                           value="Visualizar">
                                </div>
                            </div>
                        </form>
                    </center>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnAgregarAsignacion" class="btn btn-primary entrada-datos">Guardar</button>
            </div>
        </div>
    </div>
</div>-->

<!--=====================================
VISTA SELECCIONAR TRABAJADOR
======================================-->
<div id="vistaTrabajadores" class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped dt-responsive tablaTrabajadores" width="100%">
            <thead>
            <tr>
                <th style="width:10px">#</th>
                <th>Codigo</th>
                <th>Id Persona</th>
                <th>Nombre</th>
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
VISTA CREAR ASIGNACION
======================================-->
<div id="vistaCrearAsignacionTrabajador" class="card">
    <div class="col d-flex justify-content-center">
        <div class="card " style="width: 85rem;">
            <div class="card-header bg-gradient-primary">Ingreso Datos</div>
            <div class="card-body">
                <div class="row">
                    <div class="entrada-datos form-group col-md-4 ml-auto" align="center">
                        <label for="codigoTrabajadorNew" class="control-label">Codigo</label>
                        <input id="codigoTrabajadorNew" name="codigoTrabajadorNew" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class=" entrada-datos form-group col-md-4 ml-auto" align="center">
                        <label for="nombreCompletoNew" class="control-label">Nombre</label>
                        <input id="nombreCompletoNew" name="nombreCompletoNew" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="entrada-datos form-group col-md-4 ml-auto" align="center">
                        <label for="idPersonaNew" class="control-label">C.I.</label>
                        <input id="idPersonaNew" name="idPersonaNew" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group entrada-datos2 col-md-4 ml-auto" align="center">
                        <label for="codigoUnidadNew" class="control-label">Elegir unidad</label>
                        <select id="codigoUnidadNew" name="codigoUnidadNew"
                                class="form-control input-lg listaUnidadesnew" style="width: 400px">
                        </select>
                    </div>
                    <div class="entrada-datos form-group col-md-4 ml-auto" align="center">
                        <label for="codigoSectorTrabajoNew ">Sector de Trabajo</label>
                        <select id="codigoSectorTrabajoNew" name="codigoSectorTrabajoNew" required style="width: 400px"
                                class="form-control input-lg codigoSectorTrabajo"
                                onChange="getSectorTrabajo(this.value);">
                            <option value="">Selecionar Sector</option>
                            <?php
                            foreach ($sectoresTrabajo as $codigo => $nombre) {
                                echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="entrada-datos1 form-group col-md-4 ml-auto" align="center">
                        <label for="codigoCondicionLaboralNew">Condicion Laboral</label>
                        <select id="codigoCondicionLaboralNew" name="codigoCondicionLaboralNew" required
                                class="form-control input-lg codigoCondicionLaboral " style="width: 400px"
                                disabled>
                            <option value="">Selecionar Condicion Laboral</option>
                        </select>
                    </div>
                </div>
                <div class="row entrada-datos-sector" style="width: 100%" hidden>
                    <div class="form-group">
                        <label for="codigoSectorTrabajoShow" class="control-label">Sector Trabajo</label>
                        <input id="codigoSectorTrabajoShow" name="codigoSectorTrabajoShow" type="text"
                               maxlength="150"
                               readonly="true" class="form-control input-lg" hidden>
                        <input id="nombreSectorTrabajoShow" name="nombreSectorTrabajoShow" type="text"
                               maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="form-group">
                        <label for="codigoCondicionLaboralShow" class="control-label">CondicionLaboral</label>
                        <input id="codigoCondicionLaboralShow" name="codigoCondicionLaboralShow" type="text"
                               maxlength="150"
                               readonly="true" class="form-control input-lg" hidden>
                        <input id="nombreCondicionLaboralShow" name="nombreCondicionLaboralShow" type="text"
                               maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 ml-auto">
                        <label for="codigoAsignacionNew" class="control-label" hidden>Asignacion</label>
                        <input id="codigoAsignacionNew" name="codigoAsignacionNew" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg" hidden>
                    </div>
                    <div class="form-group col-md-6 ml-auto">
                        <label for="codigoTrabajadorNew" class="control-label" hidden>Codigo</label>
                        <input id="codigoTrabajadorNew" name="codigoTrabajadorNew" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg" hidden>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4 ml-auto" align="center">
                        <label for="codigoCargoNew">Cargo</label>
                        <select id="codigoCargoNew" name="codigoCargoNew" required
                                class="form-control input-lg codigoCargo select2" style="width: 400px;"
                                disabled>
                            <option value="">Selecionar Cargo</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4 ml-auto" align="center">
                        <label for="nroItemNew">Item</label>
                        <select id="nroItemNew" name="nroItemNew" required
                                class="form-control input-lg nroItem select2" style="width: 400px"
                                disabled>
                            <option value="">Selecionar Item</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4 ml-auto" align="center">
                        <label for="codigoNivelSalarialNew">Nivel Salarial</label>
                        <select id="codigoNivelSalarialNew" name="codigoNivelSalarialNew" required
                                class="form-control input-lg codigoNivelSalarial select2" style="width: 400px"
                                disabled>
                            <option value="">Selecionar Nivel Salarial</option>
                        </select>
                    </div>
                </div>
                <div class="row entrada-datos" align="center">
                    <div class="form-group col-md-11 ml-auto">
                        <center>
                            <button type="button" id="btnCrearItemNew" class="btn btn-primary entrada-datos">CrearItem
                            </button>
                        </center>
                    </div>
                </div>
                <div class="row">
                    <div class="entrada-datos5 col-md-4 ml-auto" align="center">
                        <label for="fechaInicioNew" class="control-label">Fecha Inicio</label>
                        <input id="fechaInicioNew" name="fechaInicioNew" type="date" maxlength="150"
                               placeholder="Ingresar fecha de inicio." class="form-control input-lg">
                    </div>
                    <div class="form-group col-md-4 ml-auto" align="center">
                        <label for="fechaFinNew" class="control-label">Fecha Fin</label>
                        <input id="fechaFinNew" name="fechaFinNew" type="date" maxlength="150"
                               placeholder="Ingresar fechafin." class="form-control input-lg">
                    </div>
                    <div class="entrada-datos5 col-md-4 ml-auto" align="center">
                        <label for="jefaturaNew">Jefatura</label>
                        <select id="jefaturaNew" name="jefaturaNew" required
                                class="form-control input-lg">
                            <option value="">Selecionar si ocupa una jefatura</option>
                            <option value="0">SI</option>
                            <option value="1">NO</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="entrada-datos5 col-md-2 ml-auto" align="center">
                        <label for="nroDocumentoNew" class="control-label">Documento</label>
                        <input id="nroDocumentoNew" name="nroDocumentoNew" maxlength="120"
                               placeholder="Documento"
                               class="form-control input-lg">
                    </div>
                    <div class="form-group col-md-2 ml-auto" align="center">
                        <label for="fechaDocumentoNew" class="control-label">Fecha Documento</label>
                        <input id="fechaDocumentoNew" name="fechaDocumentoNew" type="date" maxlength="150"
                               placeholder="Ingresar fechafin." class="form-control input-lg">
                    </div>
                    <div class="entrada-datos5 col-md-2 ml-auto" align="center">
                        <label for="tipoDocumentoNew">Tipo de Documento</label>
                        <select id="tipoDocumentoNew" name="tipoDocumentoNew" required
                                class="form-control input-lg tipoDocumento">
                            <option value="">Seleccionar tipo de documento</option>
                            <?php
                            foreach ($tiposDocumento as $codigo => $nombre) {
                                echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-2 ml-auto" align="center">
                        <label for="interinatoNew">Interinato</label>
                        <select id="interinatoNew" name="interinatoNew" required
                                class="form-control input-lg">
                            <option value="">Seleccionar si el cargo es interinato</option>
                            <option value="0">SI</option>
                            <option value="1">NO</option>
                        </select>
                    </div>
                    <div class="entrada-datos5 col-md-2 ml-auto" align="center">
                        <label for="codigoTiempoTrabajoNew" class="control-label">Horas Trabajadas</label>
                        <select id="codigoTiempoTrabajoNew" name="codigoTiempoTrabajoNew" required
                                class="form-control input-lg tipoDocumento">
                            <option value="">Seleccionar tiempo de trabajo</option>
                            <?php
                            foreach ($tiemposTrabajo as $codigo => $nombre) {
                                echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row" align="center">
                    <div class="form-group col-md-11 ml-auto">
                        <center>
                            <form method="post" action="#" enctype="multipart/form-data"
                                  class="form-group entrada-datos5">
                                <div class="card" style="width: 10rem;">
                                    <img class="card-img-top" src="img/memo.jpg">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="imagenNew">Sube Memorandum</label>
                                            <input type="file" class="form-control-file" name="imagenNew"
                                                   id="imagenNew">
                                        </div>
                                        <input type="button" class="btn btn-primary upload" id="uploadNew"
                                               value="Visualizar">
                                    </div>
                                </div>
                            </form>
                        </center>
                    </div>
                </div>
            </div>
            <br>
            <div class="card-footer text-center">
                <button type="submit" id="btnAgregarAsignacion"
                        class='btn btn-primary bg-gradient-primary'>
                    <i class='fa fa-check-circle-o'>Guardar</i></button>
            </div>
        </div>
    </div>
</div>

<!--=====================================
MODAL ACTUALIZAR ASIGNACION
======================================-->
<div id="modalActualizarAsignacion" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Editar Asignacion</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            CUERPO DEL MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--=====================================
                     DATOS DE LA ASIGNACION MODIFICADO
                     ======================================-->
                    <div class="form-group ">
                        <label for="codigoAsignacionUpd" class="control-label" hidden>Asignacion</label>
                        <input id="codigoAsignacionUpd" name="codigoAsignacionUpd" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg" hidden>
                    </div>
                    <div class="form-group ">
                        <label for="codigoTrabajadorUpd" class="control-label" hidden>Codigo</label>
                        <input id="codigoTrabajadorUpd" name="codigoTrabajadorUpd" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg" hidden>
                    </div>
                    <div class="form-group ">
                        <label for="nombreCompletoUpd" class="control-label">Nombre</label>
                        <input id="nombreCompletoUpd" name="nombreCompletoUpd" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="form-group ">
                        <label for="idPersonaUpd" class="control-label">C.I.</label>
                        <input id="idPersonaUpd" name="idPersonaUpd" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="form-group">
                        <label for="codigoSectorTrabajoUpd ">Sector de Trabajo</label>
                        <select id="codigoSectorTrabajoUpd" name="codigoSectorTrabajoUpd" required style="width: 100%"
                                class="form-control input-lg tipoDocumento">
                            <option value="">Selecionar Sector</option>
                            <?php
                            foreach ($sectoresTrabajo as $codigo => $nombre) {
                                echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="codigoCondicionLaboralUpd">Condicion Laboral</label>
                        <select id="codigoCondicionLaboralUpd" name="codigoCondicionLaboralUpd" required
                                class="form-control input-lg codigoCondicionLaboral" style="width: 100%">
                            <option value="">Selecionar Condicion Laboral</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nombreUnidadUpd" class="control-label">Unidad Actual</label>
                        <input id="nombreUnidadUpd" name="nombreUnidadUpd" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="form-group">
                        <label for="codigoUnidadUpd" class="control-label">Elegir unidad</label>
                        <select id="codigoUnidadUpd" name="codigoUnidadUpd"
                                class="form-control input-lg listaUnidadesnew" style="width: 100%">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="codigoCargoUpd">Cargo</label>
                        <select id="codigoCargoUpd" name="codigoCargoUpd" required
                                class="form-control input-lg codigoCargo select2" style="width: 100%;">
                            <option value="">Selecionar Cargo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nroItemUpd">Item</label>
                        <select id="nroItemUpd" name="nroItemUpd" required
                                class="form-control input-lg nroItem select2" style="width: 100%">
                            <option value="">Selecionar Item</option>
                        </select>
                        <br><br>
                        <center>
                            <button type="button" id="btnCrearItemUpd" class="btn btn-primary entrada-datos">CrearItem
                            </button>
                        </center>
                    </div>
                    <div class="row ">
                        <div class="form-group col-md-6 ml-auto">
                            <label for="fechaInicioUpd" class="control-label">Fecha Inicio</label>
                            <input id="fechaInicioUpd" name="fechaInicioUpd" type="date" maxlength="150"
                                   placeholder="Ingresar fecha de inicio." class="form-control input-lg">
                        </div>
                        <div class="form-group col-md-6 ml-auto">
                            <label for="fechaFinUpd" class="control-label">Fecha Fin</label>
                            <input id="fechaFinUpd" name="fechaFinUpd" type="date" maxlength="150"
                                   placeholder="Ingresar fechafin." class="form-control input-lg">
                        </div>
                    </div>
                    <div class="row ">
                        <div class="form-group col-md-6 ml-auto">
                            <label for="jefaturaUpd">Jefatura</label>
                            <select id="jefaturaUpd" name="jefaturaUpd" required
                                    class="form-control input-lg">
                                <option value="">Selecionar si ocupa una jefatura</option>
                                <option value="0">SI</option>
                                <option value="1">NO</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6 ml-auto">
                            <label for="codigoNivelSalarialUpd">Nivel Salarial</label>
                            <select id="codigoNivelSalarialUpd" name="codigoNivelSalarialUpd" required
                                    class="form-control input-lg codigoNivelSalarial select2" style="width: 100%">
                                <option value="">Selecionar Nivel Salarial</option>
                            </select>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="form-group col-md-6 ml-auto">
                            <label for="nroDocumentoUpd" class="control-label">Documento</label>
                            <input id="nroDocumentoUpd" name="nroDocumentoUpd" maxlength="120" rows="1"
                                   placeholder="Documento" class="form-control input-lg">
                        </div>
                        <div class="form-group col-md-6 ml-auto">
                            <label for="fechaDocumentoUpd" class="control-label">Fecha Documento</label>
                            <input id="fechaDocumentoUpd" name="fechaDocumentoUpd" type="date" maxlength="150"
                                   placeholder="Ingresar fechafin." class="form-control input-lg">
                        </div>
                    </div>
                    <div class="row ">
                        <div class="form-group col-md-6 ml-auto" readonly="true">
                            <label for="tipoDocumentoUpd">Tipo de Documento</label>
                            <input id="nombreTipoDocumentoUpd" name="nombreTipoDocumentoUpd" type="text" maxlength="150"
                                   readonly="true" class="form-control input-lg" hidden>
                            <select id="tipoDocumentoUpd" name="tipoDocumentoUpd" required style="width: 100%"
                                    class="form-control input-lg tipoDocumento">
                                <option value="">Seleccionar tipo de documento</option>
                                <?php
                                foreach ($tiposDocumento as $codigo => $nombre) {
                                    echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6 ml-auto">
                            <label for="interinadoUpd">Interinato</label>
                            <select id="interinatoUpd" name="interinatoUpd" required
                                    class="form-control input-lg">
                                <option value="">Seleccionar si el cargo es interinato</option>
                                <option value="0">SI</option>
                                <option value="1">NO</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 ml-center">
                            <label for="codigoTiempoTrabajoUpd" class="control-label">Horas Trabajadas</label>
                            <select id="codigoTiempoTrabajoUpd" name="codigoTiempoTrabajoUpd" required
                                    style="width: 100%"
                                    class="form-control input-lg tipoDocumento">
                                <option value="">Seleccionar tiempo de trabajo</option>
                                <?php
                                foreach ($tiemposTrabajo as $codigo => $nombre) {
                                    echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="form-group col-md-6 ml-auto">
                            <div class="card" style="width: 13rem;">
                                <img id="imagenAsignacionUpd" class="card-img-top"
                                     src="/urrhhsoft/backend/web/img/memo.jpg">
                            </div>
                        </div>
                        <div class="form-group col-md-6 ml-auto" align="center">
                            <form method="post" action="#" enctype="multipart/form-data" class="form-group">
                                <div class="card" style="width: 13rem;">
                                    <img class="card-img-top" src="img/memo.jpg">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="imagenUpd">Sube Memorandum</label>
                                            <input type="file" class="form-control-file" name="imagenUpd"
                                                   id="imagenUpd">
                                        </div>
                                        <br>
                                        <input type="button" class="btn btn-primary upload" id="uploadUpd"
                                               value="Visualizar">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnActualizarAsignacion" class="btn btn-primary">Guardar
                </button>
            </div>
        </div>
    </div>
</div>

<!--=====================================
MODAL MOSTRAR IMAGEN
======================================-->

<div id="modalMostarMemorandum" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">MEMORANDUM TRABAJADOR</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            CUERPO DEL MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--=====================================
                     DATOS DE LA ASIGNACION MODIFICADO
                     ======================================-->
                    <img id="mostrarMemo" class="card-img-top" src="/urrhhsoft/backend/web/img/memo.jpg">
                </div>
            </div>
            <!--=====================================
            FOOTER MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>