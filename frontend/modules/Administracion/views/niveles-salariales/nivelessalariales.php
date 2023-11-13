<?php

use yii\web\JqueryAsset;

app\modules\Administracion\assets\AdministracionAsset::register($this);

$this->registerJsFile("@web/js/niveles-salariales/nivelessalariales.js", [
    'depends' => [
        JqueryAsset::className()
    ]
]);

$this->title = 'Administración Niveles Salariales';
$this->params['breadcrumbs'] = [['label' => 'Admin. Niveles Salariales']];
?>

<div class="card">
    <div class="card-header">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalCrearNivelSalarial">
            Nuevo
        </button>
    </div>
    <br/>
    <div class="card-body">
        <table class="table table-bordered table-striped dt-responsive tablaNivelesSalariales" width="100%">
            <thead>
            <tr>
                <th style="width:10px">#</th>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Haber Basico</th>
                <th>SectorTrabajo</th>
                <th>Puntos Escalafon</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<!--=====================================
MODAL CREAR NIVEL SALARIAL
======================================-->
<div id="modalCrearNivelSalarial" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Agregar Nivel Salarial</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--=====================================
                    DATOS DEL NUEVO NIVEL SALARIAL
                    ======================================-->
                    <div class="form-group">
                        <label for="codigoSectorTrabajoNew">Sector de Trabajo</label>
                        <select id="codigoSectorTrabajoNew" name="codigoSectorTrabajoNew" required
                                class="form-control input-lg" >
                            <option value="">Selecionar Sector</option>
                            <?php
                            foreach ($sectoresTrabajo as $codigo => $nombre) {
                                echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group entrada-datos" style="display: none;" >
                        <label for="nombreNivelSalarialNew" class="control-label">Nombre</label>
                        <input id="nombreNivelSalarialNew" name="nombreNivelSalarialNew" type="text" maxlength="150"
                               placeholder="Ingresar nombre del nivel salarial" required class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos" style="display: none;" >
                        <label for="descripcionNivelSalarialNew" class="control-label">Descripcion</label>
                        <input id="descripcionNivelSalarialNew" name="descripcionNivelSalarialNew" type="text" maxlength="150"
                               placeholder="Ingresar descripcion del nivel salarial" required class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos" style="display: none;">
                        <label for="haberBasicoNew" class="control-label">Haber Basico</label>
                        <input id="haberBasicoNew" name="haberBasicoNew" maxlength="120"
                                  placeholder="Ingresar Haber Basico" required class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos" style="display: none;">
                        <label for="puntosEscalafonNew" class="control-label">Puntos Escalafon</label>
                        <input id="puntosEscalafonNew" name="puntosEscalafonNew" maxlength="120"
                               placeholder="Ingresar Puntos Escalafón" required class="form-control input-lg">
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnCrearNivelSalarial" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!--=====================================
MODAL ACTUALIZAR NIVEL SALARIAL
======================================-->
<div id="modalActualizarNivelSalarial" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Editar Nivel Salarial</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            CUERPO DEL MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--=====================================
                     DATOS DEL NIVEL SALARIAL MODIFICADO
                     ======================================-->
                    <div class="form-group">
                        <label for="codigoSectorTrabajoUpd">Sector de Trabajo</label>
                        <select id="codigoSectorTrabajoUpd" name="codigoSectorTrabajoUpd" required
                                class="form-control input-lg>
                            <option value="">Selecionar Sector</option>
                            <?php
                            foreach ($sectoresTrabajo as $codigo => $nombre) {
                                echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="nombreNivelSalarialUpd" class="control-label">Nombre</label>
                        <input id="codigoNivelSalarialUpd" name="codigoNivelSalarialUpd" type="hidden" maxlength="150" hidden
                               class="form-control input-lg">
                        <input id="nombreNivelSalarialUpd" name="nombreNivelSalarialUpd" type="text" maxlength="150"
                               placeholder="Ingresar nombre del nivel salarial" required class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="descripcionNivelSalarialUpd" class="control-label">Descripcion</label>
                        <input id="descripcionNivelSalarialUpd" name="descripcionNivelSalarialUpd" type="text" maxlength="150"
                               placeholder="Ingresar descripcion del nivel salarial" required class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="haberBasicoUpd" class="control-label">Haber Basico</label>
                        <input id="haberBasicoUpd" name="haberBasicoUpd" maxlength="120"
                               placeholder="Ingresar haber basico" required class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="puntosEscalafonUpd" class="control-label">Puntos Escalafon</label>
                        <input id="puntosEscalafonUpd" name="puntosEscalafonUpd" maxlength="120"
                               placeholder="Ingresar puntos escalafon" required class="form-control input-lg">
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnActualizarNivelSalarial" class="btn btn-primary">Guardar
                </button>
            </div>
        </div>
    </div>
</div>
