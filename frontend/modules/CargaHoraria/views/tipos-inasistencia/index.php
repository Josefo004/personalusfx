<?php
use app\modules\CargaHoraria\assests\CargaHorariaAsset;
CargaHorariaAsset::register($this);

$this->registerJsFile("@web/js/tiposinasistencia.js",[
    'depends' => [
        \yii\web\JqueryAsset::className()
    ]
]);
?>
<div class="card">
    <div class="card-header">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalCrearTipoInasistencia">
            Nuevo
        </button>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped dt-responsive tablaTiposInasistencia" width="100%"
               id="tablaTiposInasistencia">
            <thead>
            <tr>
                <th style="width:10px">#</th>
                <th>Código</th>
                <th>Tipo de inasistencia</th>
                <th>Descripción</th>
                <th>Sanción</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<!--=====================================
MODAL CREAR TIPO DE INASISTENCIA
======================================-->
<div id="modalCrearTipoInasistencia" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Agregar Tipo de Inasistencia</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--=====================================
                    DATOS DEL NUEVO TIPO DE INASISTENCIA
                    ======================================-->
                    <div class="form-group entrada-datos">
                        <label for="nombreTipoInasistenciaNew" class="control-label">Tipo de Inasistencia</label>
                        <input id="nombreTipoInasistenciaNew" name="nombreTipoInasistenciaNew" type="text" maxlength="150"
                               placeholder="Ingresar el nombre del tipo de inasistencia" required class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="descripcionNew" class="control-label">Descripción</label>
                        <input id="descripcionNew" name="descripcionNew" type="text" maxlength="350"
                               placeholder="Descripción del tipo de inasistencia" required class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="sancionNew" class="control-label">Sanción</label>
                        <input id="sancionNew" name="sancionNew" type="text" maxlength="150"
                               placeholder="Ingresar porcentaje" required class="form-control input-lg">
                    </div>

                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnCrearTipoInasistencia" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!--=====================================
MODAL ACTUALIZAR TIPO DE INASISTENCIA
======================================-->
<div id="modalActualizarTipoInasistencia" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Editar Tipo de Inasistencia</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            CUERPO DEL MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--=====================================
                     DATOS DEL TIPO DE INASISTENCIA
                     ======================================-->
                    <div class="form-group entrada-datos">
                        <label for="nombreTipoInasistenciaUpd" class="control-label">Tipo de Inasistencia</label>
                        <input id="codigoTipoInasistenciaUpd" name="codigoTipoInasistenciaUpd" type="hidden"  hidden
                               class="form-control input-lg">
                        <input id="nombreTipoInasistenciaUpd" name="nombreTipoInasistenciaUpd" type="text" maxlength="150"
                               placeholder="Ingresar nombre del tipo de inasistencia" required class="form-control input-lg">
                    </div>

                    <div class="form-group entrada-datos">
                        <label for="descripcionUpd" class="control-label">Descripción</label>
                        <input id="descripcionUpd" name="descripcionUpd" type="text" maxlength="350"
                        placeholder="Ingresar la descripción del tipo de inasistencia" required class="form-control input-lg">
                    </div>

                    <div class="form-group entrada-datos">
                        <label for="sancionUpd" class="control-label">Sanción</label>
                        <input id="sancionUpd" name=sancionUpd" type="text" maxlength="3"
                               placeholder="Ingresar la sanción" required class="form-control input-lg">
                    </div>

                </div>
            </div>
            <!--=====================================
            FOOTER MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnActualizarTipoInasistencia" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

