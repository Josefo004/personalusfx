<?php

use yii\web\JqueryAsset;

app\modules\Contraloria\assets\ContraloriaAsset::register($this);

$this->registerJsFile("@web/js/tipos-declaraciones-juradas/tipodeclaracionjuradatrabajadores.js", [
    'depends' => [
        JqueryAsset::className()
    ]
]);

$this->title = 'Contraloria Tipos Declaraciones Juradas Trabajadores';
$this->params['breadcrumbs'] = [['label' => 'Contr. Tipos Declaraciones Juradas Trabajadores']];
?>
<div class="row">
    <div class="offset-sm-2 col-sm-8 offset-md-3 col-md-6">
        <div class="box">
            <table class="table table-bordered" width="100%">
                <tr>
                    <th style="width: 25%; background-color: #5095ff; color: white"> Codigo</th>
                    <td style="background-color: white;"><span id="codigoTipoDeclaracionJuradaSearch"><?= $tipoDeclaracionJurada->CodigoTipoDeclaracionJurada ?></span></td>
                </tr>
                <tr>
                    <th style="width: 25%; background-color: #5095ff; color: white"> Nombre</th>
                    <td style="background-color: white;"><?= $tipoDeclaracionJurada->NombreTipoDeclaracionJurada ?></td>
                </tr>
                <tr>
                    <th style="width: 25%; background-color: #5095ff; color: white"> Frecuencia</th>
                    <td style="background-color: white;"><?= $tipoDeclaracionJurada->Frecuencia ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<br/>
<div class="card">
    <div class="card-header">
        <button id="btnMostrarAgregarTipoDeclaracionJuradaTrabajador" name="btnMostrarAgregarTipoDeclaracionJuradaTrabajador" class="btn btn-primary"
                data-toggle="modal" data-target="#modalAgregarTipoDeclaracionJuradaTrabajador">
            Agregar Trabajador
        </button>
    </div>
    <br/>
    <div class="card-body">
        <table class="table table-bordered table-striped dt-responsive tablaTrabajadoresTipoDeclaracionJurada" width="100%">
            <thead>
            <tr>
                <th style="text-align: center; font-weight: bold;">#</th>
                <th style="text-align: center; font-weight: bold;">Codigo</th>
                <th style="text-align: center; font-weight: bold;">C.I.</th>
                <th style="text-align: center; font-weight: bold;">Nombre Completo</th>
                <th style="text-align: center; font-weight: bold;">Fecha Ingreso</th>
                <th style="text-align: center; font-weight: bold;">Fecha Salida</th>
                <th style="text-align: center; font-weight: bold;">AFP</th>
                <th style="text-align: center; font-weight: bold;">Nivel Académico</th>
                <th style="text-align: center; font-weight: bold;">Estado</th>
                <th style="text-align: center; font-weight: bold;">Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<!--=====================================
MODAL AGREGAR TRABAJADOR
======================================-->
<div id="modalAgregarTipoDeclaracionJuradaTrabajador" class="modal fade" role="dialog">
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
                    <!--==============================================
                    DATOS DEL NUEVO TRABAJADOR TIPO DECLARACION JURADA
                    ================================================-->
                    <table class="table table-bordered table-striped dt-responsive tablaTrabajadores" width="100%">
                        <thead>
                        <tr>
                            <th style="text-align: center; font-weight: bold;">#</th>
                            <th style="text-align: center; font-weight: bold;">Codigo</th>
                            <th style="text-align: center; font-weight: bold;">C.I.</th>
                            <th style="text-align: center; font-weight: bold;">Nombre</th>
                            <th style="text-align: center; font-weight: bold;">Fec. Nacimiento</th>
                            <th style="text-align: center; font-weight: bold;">Fec. Ingreso</th>
                            <th style="text-align: center; font-weight: bold;">Fec. Salida</th>
                            <th style="text-align: center; font-weight: bold;">Acciones</th>
                        </tr>
                        </thead>
                    </table>
                    <div class="form-group entrada-datos">
                        <label for="codigoTrabajadorNew" class="control-label">Codigo</label>
                        <input id="codigoTrabajadorNew" name="codigoTrabajadorNew" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="idPersonaNew" class="control-label">C.I.</label>
                        <input id="idPersonaNew" name="idPersonaNew" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="nombreCompletoNew" class="control-label">Nombre</label>
                        <input id="nombreCompletoNew" name="nombreCompletoNew" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="fechaNacimientoNew" class="control-label">Fecha Nacimiento</label>
                        <input id="fechaNacimientoNew" name="fechaNacimientoNew" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="fechaInicioRecordatorioNew" class="control-label">Inicio Recordatorio</label>
                        <input id="fechaInicioRecordatorioNew" name="fechaInicioRecordatorioNew" type="date" maxlength="150"
                               placeholder="Ingresar fecha de inicio del recordatorio." class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="fechaFinRecordatorioNew" class="control-label">Fin Recordatorio</label>
                        <input id="fechaFinRecordatorioNew" name="fechaFinRecordatorioNew" type="date" maxlength="150"
                               placeholder="Ingresar fecha de salida." class="form-control input-lg">
                    </div>
                    <button type="button" id="btnCargarCumpleActualNew" class="btn btn-default entrada-datos">Cumpleaños Año Actual</button>
                    <button type="button" id="btnCargarCumpleSiguienteNew" class="btn btn-default entrada-datos">Cumpleaños Año Siguiente</button>
                    <button type="button" id="btnCargarCincoAniosNew" class="btn btn-default entrada-datos">5 Años Despues</button>
                    <button type="button" id="btnCargarDiezAniosNew" class="btn btn-default entrada-datos">10 Años Despues</button>
                    <button type="button" id="btnCargarFinalizacionNew" class="btn btn-default entrada-datos">90 dias Finalización Contrato</button>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnAgregarTipoDeclaracionJuradaTrabajador" class="btn btn-primary entrada-datos">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!--=====================================
MODAL ACTUALIZAR TRABAJADOR
======================================-->
<div id="modalActualizarTipoDeclaracionJuradaTrabajador" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Editar Trabajador</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--============================================
                     DATOS DEL TRABAJADOR MODIFICADO
                     =============================================-->
                    <div class="form-group entrada-datos">
                        <label for="codigoTrabajadorUpd" class="control-label">Codigo</label>
                        <input id="codigoTrabajadorUpd" name="codigoTrabajadorUpd" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="idPersonaUpd" class="control-label">C.I.</label>
                        <input id="idPersonaUpd" name="idPersonaUpd" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="nombreCompletoUpd" class="control-label">Nombre</label>
                        <input id="nombreCompletoUpd" name="nombreCompletoUpd" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="fechaNacimientoUpd" class="control-label">Fecha Nacimiento</label>
                        <input id="fechaNacimientoUpd" name="fechaNacimientoUpd" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="fechaInicioRecordatorioUpd" class="control-label">Inicio Recordatorio</label>
                        <input id="fechaInicioRecordatorioUpd" name="fechaInicioRecordatorioUpd" type="date" maxlength="150"
                               placeholder="Ingresar fecha de inicio del recordatorio." class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="fechaFinRecordatorioUpd" class="control-label">Fin Recordatorio</label>
                        <input id="fechaFinRecordatorioUpd" name="fechaFinRecordatorioUpd" type="date" maxlength="150"
                               placeholder="Ingresar fecha de fin del recordatorio." class="form-control input-lg">
                    </div>
                    <button type="button" id="btnCargarCumpleActualUpd" class="btn btn-default entrada-datos">Cumpleaños Año Actual</button>
                    <button type="button" id="btnCargarCumpleSiguienteUpd" class="btn btn-default entrada-datos">Cumpleaños Año Siguiente</button>
                    <button type="button" id="btnCargarCincoAniosUpd" class="btn btn-default entrada-datos">5 Años Despues</button>
                    <button type="button" id="btnCargarDiezAniosUpd" class="btn btn-default entrada-datos">10 Años Despues</button>
                    <button type="button" id="btnCargarFinalizacionUpd" class="btn btn-default entrada-datos">90 dias Finalización Contrato</button>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnActualizarTipoDeclaracionJuradaTrabajador" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>