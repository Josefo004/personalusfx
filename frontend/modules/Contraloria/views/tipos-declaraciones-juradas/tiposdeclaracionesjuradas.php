<?php

use yii\web\JqueryAsset;

app\modules\Contraloria\assets\ContraloriaAsset::register($this);

$this->registerJsFile("@web/js/tipos-declaraciones-juradas/tiposdeclaracionesjuradas.js", [
    'depends' => [
        JqueryAsset::className()
    ]
]);

$this->title = 'Contraloria Tipos Declaraciones Juradas';
$this->params['breadcrumbs'] = [['label' => 'Contr. Tipos Declaraciones Juradas']];
?>
<div class="card">
    <div class="card-header">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalCrearTipoDeclaracionJurada">
            Nuevo Registro
        </button>
    </div>
    <br/>
    <div class="card-body">
        <table class="table table-bordered table-striped dt-responsive tablaTiposDeclaracionesJuradas" width="100%">
            <thead>
            <tr>
                <th style="width:10px">#</th>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Frecuencia</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<!--=====================================
MODAL CREAR TIPO DECLARACION JURADA
======================================-->
<div id="modalCrearTipoDeclaracionJurada" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Agregar Tipo de Declaracion Jurada</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--=====================================
                    DATOS DEL NUEVO TIPO DECLARACION JURADA
                    ======================================-->
                    <div class="form-group">
                        <label for="nombreTipoDeclaracionJuradaNew" class="control-label">Nombre</label>
                        <input id="nombreTipoDeclaracionJuradaNew" name="nombreTipoDeclaracionJuradaNew" type="text"
                               maxlength="150"
                               placeholder="Ingresar nombre del tipo de declaracion jurada" required
                               class="form-control input-lg">
                    </div>
                    <div class="form-group">
                        <label for="frecuenciaNew" class="control-label">Frecuencia</label>
                        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                        <select id="frecuenciaNew" name="frecuenciaNew" required
                                class="form-control input-lg" style="width: 100%;">
                            <option value="">Seleccionar Frecuencia</option>
                            <?php
                            foreach ($frecuencias as $codigo => $nombre) {
                                echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnCrearTipoDeclaracionJurada" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!--=====================================
MODAL ACTUALIZAR TIPO DECLARACION JURADA
======================================-->
<div id="modalActualizarTipoDeclaracionJurada" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Editar Tipo de Declarcion Jurada</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            CUERPO DEL MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--============================================
                     DATOS DEL TIPO DE DECLARACION JURADA MODIFICADO
                     =============================================-->
                    <div class="form-group">
                        <label for="nombreTipoDeclaracionJuradaUpd" class="control-label">Nombre</label>
                        <input id="codigoTipoDeclaracionJuradaUpd" name="codigoTipoDeclaracionJuradaUpd" type="hidden"
                               maxlength="150" hidden
                               class="form-control input-lg">
                        <input id="nombreTipoDeclaracionJuradaUpd" name="nombreTipoDeclaracionJuradaUpd" type="text"
                               maxlength="150"
                               placeholder="Ingresar nombre del tipo de declaracion jurada" required
                               class="form-control input-lg">
                    </div>
                    <div class="form-group">
                        <label for="frecuenciaUpd" class="control-label">Frecuencia</label>
                        <select id="frecuenciaUpd" name="frecuenciaUpd" required
                                class="form-control input-lg" style="width: 100%;">
                            <option value="">Seleccionar Frecuencia</option>
                            <?php
                            foreach ($frecuencias as $codigo => $nombre) {
                                echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnActualizarTipoDeclaracionJurada" class="btn btn-primary">Guardar
                </button>
            </div>
        </div>
    </div>
</div>