<?php

use yii\web\JqueryAsset;

app\modules\Contraloria\assets\ContraloriaAsset::register($this);

$this->registerJsFile("@web/js/trabajadores-declaraciones-juradas/trabajadoresdeclaracionesjuradas.js", [
    'depends' => [
        JqueryAsset::className()
    ]
]);

$this->title = 'Contraloria Declaraciones Juradas Trabajadores';
$this->params['breadcrumbs'] = [['label' => 'Contr. Declaraciones Juradas Trabajadores']];
?>

<div class="card">
    <div class="card-header">
        <button id="btnMostrarCrearTrabajadorDeclaracionJuada" name="btnMostrarCrearTrabajadorDeclaracionJuada"
                class="btn btn-primary"
                data-toggle="modal" data-target="#modalCrearTrabajadorDeclaracionJurada">
            Nuevo Registro
        </button>
    </div>
    <br/>
    <div class="card-body">
        <table class="table table-bordered table-striped dt-responsive tablaTrabajadoresDeclaracionesJuradas"
               width="100%">
            <thead>
            <tr>
                <th style="width:10px">#</th>
                <th>Trabajador</th>
                <th>Tipo Declaracion Jurada</th>
                <th>Codigo</th>
                <th>Gestion</th>
                <th>Mes</th>
                <th>Fecha Notificacion</th>
                <th>Fecha Recepcion</th>
                <th>Observacion</th>
                <th>Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<!--=====================================
MODAL CREAR TRABAJADOR DECLARACION JURADA
======================================-->
<div id="modalCrearTrabajadorDeclaracionJurada" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Agregar Trabajador</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--=====================================
                    DATOS DEL NUEVO TRABAJADOR
                    ======================================-->
                    <table class="table table-bordered table-striped dt-responsive tablaTrabajadores" width="100%">
                        <thead>
                        <tr>
                            <th style="width:10px">#</th>
                            <th>Codigo</th>
                            <th>Id Persona</th>
                            <th>Nombre</th>
                            <th>Fec. Nacimiento</th>
                            <th>Fec. Ingreso</th>
                            <th>Fec. Salida</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                    </table>
                    <div class="form-group entrada-datos-principal">
                        <label for="codigoTrabajadorNew" class="control-label">Codigo</label>
                        <input id="codigoTrabajadorNew" name="codigoTrabajadorNew" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos-principal">
                        <label for="idPersonaNew" class="control-label">C.I.</label>
                        <input id="idPersonaNew" name="idPersonaNew" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos-principal">
                        <label for="nombreCompletoNew" class="control-label">Nombre</label>
                        <input id="nombreCompletoNew" name="nombreCompletoNew" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos-principal">
                        <label for="codigoTipoDeclaracionJuradaNew">Tipo de Declaracion Jurada</label>
                        <select id="codigoTipoDeclaracionJuradaNew" name="codigoTipoDeclaracionJuradaNew" required
                                class="form-control input-lg codigoTipoDeclaracionJurada" style="width: 100%;"
                                nuevo="si">
                            <option value="">Selecionar Tipo de Declaracion Jurada</option>
                        </select>
                    </div>
                    <div class="form-group entrada-datos-complementaria">
                        <label class="control-label">Fechas Presentación</label>
                        <div class="form-inline">
                            <div class="form-group mx-sm-3">
                                <input id="fechaInicioRecordatorioNew" name="fechaInicioRecordatorioNew" type="text"
                                       maxlength="50"
                                       readonly="true" class="form-control input-lg">
                            </div>
                            <label class="control-label"> al </label>
                            <div class="form-group mx-sm-3">
                                <input id="fechaFinRecordatorioNew" name="fechaFinRecordatorioNew" type="text"
                                       maxlength="50"
                                       readonly="true" class="form-control input-lg">
                            </div>
                        </div>
                    </div>
                    <div class="form-group entrada-datos-complementaria">
                        <label for="codigoDeclaracionJuradaNew" class="control-label">Codigo Contraloria</label>
                        <input id="codigoDeclaracionJuradaNew" name="codigoDeclaracionJuradaNew" type="text"
                               maxlength="150"
                               placeholder="Ingresar el Codido de la Declaracion Jurada" required
                               class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos-complementaria">
                        <label for="gestionNew" class="control-label">Gestion</label>
                        <input id="gestionNew" name="gestionNew" maxlength="120" rows="3"
                               placeholder="Ingresar la Gestion" class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos-complementaria">
                        <label for="mesNew" class="control-label">Mes</label>
                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                        <select id="mesNew" name="mesNew" required
                                class="form-control input-lg" style="width: 100%;">
                            <option value="">Seleccionar Mes</option>
                            <?php
                            foreach ($meses as $codigo => $nombre) {
                                echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group entrada-datos-complementaria">
                        <label for="fechaNotificacionNew" class="control-label">Fecha de Notificacion</label>
                        <input id="fechaNotificacionNew" name="fechaNotificacionNew" type="date" maxlength="10"
                               placeholder="Seleccionar la fecha de Notificacion" required
                               class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos-complementaria">
                        <label for="fechaRecepcionNew" class="control-label">Fecha de Recepcion</label>
                        <input id="fechaRecepcionNew" name="fechaRecepcionNew" type="date" maxlength="10"
                               placeholder="Seleccionar la fecha de Recepcion" required
                               class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos-complementaria">
                        <label for="observacionNew" class="control-label">Observaciones</label>
                        <textarea id="observacionNew" name="observacionNew" maxlength="120" rows="3"
                                  placeholder="Observaciones"
                                  class="form-control input-lg"></textarea>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer entrada-datos-complementaria">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnCrearTrabajadorDeclaracionJurada" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!--=====================================
MODAL ACTUALIZAR TRABAJADOR DECLARACION JURADA
======================================-->
<div id="modalActualizarTrabajadorDeclaracionJurada" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Editar Trabajador Declaracion Jurada</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            CUERPO DEL MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--=====================================
                     DATOS DEL TRABAJADOR DECLARACION JURADA MODIFICADO
                     ======================================-->
                    <div class="form-group entrada-datos">
                        <label for="codigoTrabajadorUpd" class="control-label">Codigo</label>
                        <input id="codigoTrabajadorUpd" name="codigoTrabajadorUpd" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos-principal">
                        <label for="idPersonaUpd" class="control-label">C.I.</label>
                        <input id="idPersonaUpd" name="idPersonaUpd" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="nombreCompletoUpd" class="control-label">Nombre</label>
                        <input id="nombreCompletoUpd" name="nombreCompletoUpd" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="form-group">
                        <label for="tipoDeclaracionJuradaUpd">Tipo de Declaracion Jurada</label>
                        <input id="tipoDeclaracionJuradaUpd" name="tipoDeclaracionJuradaUpd" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Fechas Presentación</label>
                        <div class="form-inline">
                            <div class="form-group mx-sm-3">
                                <input id="fechaInicioRecordatorioUpd" name="fechaInicioRecordatorioUpd" type="text"
                                       maxlength="50"
                                       readonly="true" class="form-control input-lg">
                            </div>
                            <label class="control-label"> al </label>
                            <div class="form-group mx-sm-3">
                                <input id="fechaFinRecordatorioUpd" name="fechaFinRecordatorioUpd" type="text"
                                       maxlength="50"
                                       readonly="true" class="form-control input-lg">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="codigoDeclaracionJuradaAnteriorUpd">Codigo Contraloria Anterior</label>
                        <input id="codigoDeclaracionJuradaAnteriorUpd" name="codigoDeclaracionJuradaAnteriorUpd"
                               type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="codigoDeclaracionJuradaUpd" class="control-label">Codigo Contraloria</label>
                        <input id="codigoDeclaracionJuradaUpd" name="codigoDeclaracionJuradaUpd" type="text"
                               maxlength="150"
                               placeholder="Ingresar el Codido de la Declaracion Jurada" required
                               class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="gestionUpd" class="control-label">Gestion</label>
                        <input id="gestionUpd" name="gestionUpd" maxlength="120"
                               placeholder="Ingresar la Gestion" class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="mesUpd" class="control-label">Mes</label>
                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                        <select id="mesUpd" name="mesUpd" required
                                class="form-control input-lg" style="width: 100%;">
                            <option value="">Seleccionar Mes</option>
                            <?php
                            foreach ($meses as $codigo => $nombre) {
                                echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="fechaNotificacionUpd" class="control-label">Fecha de Notificacion</label>
                        <input id="fechaNotificacionUpd" name="fechaNotificacionUpd" type="date" maxlength="10"
                               placeholder="Seleccionar la fecha de Notificacion" required
                               class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="fechaRecepcionUpd" class="control-label">Fecha de Recepcion</label>
                        <input id="fechaRecepcionUpd" name="fechaRecepcionUpd" type="date" maxlength="10"
                               placeholder="Seleccionar la fecha de Recepcion" required
                               class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="observacionUpd" class="control-label">Observaciones</label>
                        <textarea id="observacionUpd" name="observacionUpd" maxlength="120" rows="3"
                                  placeholder="Observaciones"
                                  class="form-control input-lg"></textarea>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnActualizarTrabajadorDeclaracionJurada" class="btn btn-primary">Guardar
                </button>
            </div>
        </div>
    </div>
</div>
