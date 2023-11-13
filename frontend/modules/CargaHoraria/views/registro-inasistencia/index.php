<?php
use app\modules\CargaHoraria\assests\CargaHorariaAsset;
CargaHorariaAsset::register($this);
$this->registerJsFile("@web/js/registroinasistencia.js", [
    'depends' => [
        \yii\web\JqueryAsset::className()
    ]
]);
$user = \Yii::$app->user->identity->persona->NombreCompleto;
foreach (\Yii::$app->user->identity->carreras as $carrera) {
    $nombreFacultad = $carrera["NombreFacultad"];
}
?>
<!--============================================
DOCENTES DE LAS CARRERAS DEL DIRECTOR EN SESIÓN
================================================-->
<div class="row">
    <div class="col-xl-4 f-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle"
                            data-toggle="dropdown">
                        <b>Facultad:</b> <?= $nombreFacultad ?> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <?php foreach (\Yii::$app->user->identity->Carreras as $carrera) { ?>
                            <li class="list-group-item"><?php echo $carrera['NombreCarrera'] . ' -' . $carrera['NombreSede'] ?></li>
                        <?php } ?>
                    </ul>
                </div>
                <button type="button" class="btn btn-outline-info" id="btnVistaPrevia">Vista Previa</button>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped dt-responsive tablaDocentesDirector"
                       id="tablaDocentesDirector">
                    <thead>
                    <tr>
                        <th style="width: 1%; background-color: #5095ff; color: white">#</th>
                        <th style="width: 25%; background-color: #5095ff; color: white">Docente</th>
                        <th style="width: 5%; background-color: #5095ff; color: white">Registrar Inasistencia</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-8 d-flex">
        <div class="card flex-fill">
            <div class="card" id="materiasDocente" style="display: none">
                <div id="datosDocente">
                    <br>
                    &nbsp; &nbsp; &nbsp;<b>Docente:</b><span id="nombreDocente"></span><br>
                    &nbsp; &nbsp; &nbsp;<b>Documento de identidad:</b><span id="ci"></span>
                    <br> <br>
                </div>
                <table class="table tablaMaterias" width="100%"
                       id="tablaMaterias">
                    <thead>
                    <tr style=" background-color: #5095ff; color: white">
                        <th style="width:5%;">#</th>
                        <th>Carrera</th>
                        <th>Materia</th>
                        <th>Grupo</th>
                        <th>HS</th>
                        <th>HM</th>
                        <th>Registrar Inasistencia</th>
                    </tr>
                    </thead>
                    <tbody id="contenidoMaterias">
                    </tbody>
                </table>
            </div>
            <div class="card">
                <table class="table tablaDetallesMateria" width="100%"
                       id="tablaDetallesMateria" style="display: none">
                    <thead>
                    <tr>
                        <th style="width:10px">#</th>
                        <th>Carrera</th>
                        <th>Sede</th>
                        <th>Materia</th>
                        <th>Plan de Estudios</th>
                        <th>Sigla</th>
                        <th>Curso</th>
                        <th>HS</th>
                        <th>HM</th>
                    </tr>
                    </thead>
                    <tbody id="contenidoMaterias">
                    </tbody>
                </table>
            </div>
            <div class="row" id="detalleMateria" style="display: none">
                <div class="box offset-sm-4 col-sm-4">
                    <table class="table table-striped" style="width: 100%">
                        <tr>
                            <th style="width: 50%; background-color: #5095ff; color: white"> Carrera</th>
                            <td><span id="carrera"></span></td>
                        </tr>
                        <tr>
                            <th style="width: 50%; background-color: #5095ff; color: white"> Sede</th>
                            <td><span id="sede"></span></td>
                        </tr>
                        <tr>
                            <th style="width: 50%; background-color: #5095ff; color: white"> Materia</th>
                            <td><span id="materia"></span></td>
                        </tr>
                        <tr>
                            <th style="width: 50%; background-color: #5095ff; color: white"> Curso</th>
                            <td><span id="curso"></span></td>
                        </tr>
                        <tr>
                            <th style="width: 50%; background-color: #5095ff; color: white"> Plan de Estudios</th>
                            <td><span id="planEstudios"></span></td>
                        </tr>
                        <tr>
                            <th style="width: 50%; background-color: #5095ff; color: white"> Sigla</th>
                            <td><span id="siglaMateria"></span></td>
                        </tr>
                        <tr>
                            <th style="width: 50%; background-color: #5095ff; color: white">Grupo</th>
                            <td><span id="grupo"></span></td>
                        </tr>
                        <tr>
                            <th style="width: 50%; background-color: #5095ff; color: white">Horas Semanales</th>
                            <td><span id="horasSemana"></span></td>
                        </tr>
                        <tr>
                            <th style="width: 50%; background-color: #5095ff; color: white">Horas Mensuales</th>
                            <td><span id="horasMes"></span></td>
                        </tr>
                    </table>
                </div>
            </div>
            <!--=====================================
             TABLA  DE REGISTROS DE INASISTENCIAS
             ======================================-->
            <div class="card" id="registrarInasistencias" style="display: none">
                <div class="card-header">
                    <button class="btn btn-primary" data-toggle="modal"
                            data-target="#modalRegistrarDetalleInasistencia">
                        Nuevo
                    </button>
                </div>
                <div class="card-body" style="width: 100%;">
                    <table class="table tablaInasistencias" width="100%"
                           id="tablaInasistencias">
                        <thead>
                        <tr style="width: 40%; background-color: #5095ff; color: white">
                            <th style="width:5%">#</th>
                            <th style="width:15%">Fecha</th>
                            <th style="width:15%">Horas</th>
                            <th style="width:15%">Grupo</th>
                            <th style="width:15%">Tipo de Inasistencia</th>
                            <th style="width:20%">Observaciones</th>
                            <th style="width:15%">Acciones</th>
                        </tr>
                        </thead>
                        <tbody id="contenido">
                        </tbody>
                    </table>
                </div>
                <div align="center">
                    <button type="button" class="btn btn-danger pull-left" id="btnCerrar">Cerrar</button>
                </div>
                <br>
            </div>
            <!--=====================================
             VISTA PREVIA
            ======================================-->
            <div id="vistaPrevia" style="display: none">
                <table class="table tablaCarrerasReporte" id="tablaCarrerasReporte" style="width: 700px; "
                       align="center">
                    <tr style=" background-color: #5095ff; color: white">
                        <th>Carrera</th>
                        <th>Sede</th>
                        <th>Ver</th>
                    </tr>
                    <?php foreach (\Yii::$app->user->identity->Carreras as $carrera) { ?>
                        <tr>
                            <td><?= $carrera['NombreCarrera'] ?></td>
                            <td><?= $carrera['NombreSede'] ?></td>
                            <td>
                                <button class='btn btn-outline-info btnVerReporte' id="btnVerReporte"
                                        nombre="<?= $carrera['NombreCarrera'] ?>"
                                        codigo="<?= $carrera['CodigoCarrera'] ?>"
                                        sede="<?= $carrera['CodigoSede'] ?>"
                                        nombreSede="<?= $carrera['NombreSede'] ?>"
                                ><i class='fa fa-eye'></i>
                                </button>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <br>
            <span id="nombreCarrera" style="text-align: center;  font-size: 21px; padding: 5px;"></span>
            <span id="nombreSede" style="text-align: center; font-size: 21px ; padding-bottom: 5px; "></span>
            <br>
            <table class="table tablaInasistenciasReporte" width="100%"
                   id="tablaInasistenciasReporte" style="display: none;">
                <thead>
                <tr style="width: 100%; background-color: #5095ff; color: white">
                    <th style="width:5%">#</th>
                    <th style="width:15%">Docente</th>
                    <th style="width:15%">Materia</th>
                    <th style="width:15%">Fecha</th>
                    <th style="width:15%">Grupo</th>
                    <th style="width:15%">Horas</th>
                    <th style="width:15%">Tipo de Inasistencia</th>
                    <th style="width:20%">Observaciones</th>
                </tr>
                </thead>
                <tbody id="registros">
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--=====================================
MODAL REGISTRAR DETALLE DE INASISTENCIAS
======================================-->
<div id="modalRegistrarDetalleInasistencia" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Título del modal</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <input id="horasMesNew" name="horasMesNew" type="hidden"
                           maxlength="150" hidden
                           class="form-control input-lg">
                    <input id="codigoCarreraNew" name="codigoCarreraNew" type="hidden"
                           maxlength="150" hidden
                           class="form-control input-lg">
                    <input id="idPersonaNew" name="idPersonaNew" type="hidden"
                           maxlength="150" hidden
                           class="form-control input-lg">
                    <input id="codigoSedeNew" name="codigoSedeNew" type="hidden"
                           maxlength="150" hidden
                           class="form-control input-lg">
                    <input id="numeroPlanEstudiosNew" name="numeroPlanEstudiosNew" type="hidden"
                           maxlength="150" hidden
                           class="form-control input-lg">

                    <input id="siglaMateriaNew" name="siglaMateriaNew" type="hidden"
                           maxlength="150" hidden
                           class="form-control input-lg">
                    <input id="grupoNew" name="grupoNew" type="hidden"
                           maxlength="150" hidden
                           class="form-control input-lg">
                    <?php $gestion = date("Y");
                    $mes = date("m"); ?>
                    <input id="gestionNew" name="gestionNew" type="hidden"
                           maxlength="150" value="<?= $gestion; ?>" hidden
                           class="form-control input-lg">
                    <input id="mesNew" name="mesNew" type="hidden"
                           maxlength="150" value="<?= $mes; ?>" hidden
                           class="form-control input-lg">
                    <input id="codigoTrabajadorNew" name="codigoTrabajadorNew" type="hidden"
                           maxlength="150" hidden
                           class="form-control input-lg">
                    <div class="form-group entrada-datos">
                        <label for="fechaInasistenciaNew" class="control-label">Fecha</label>
                        <input id="fechaInasistenciaNew" name="fechaInasistenciaNew" type="date"
                               placeholder="Fecha de inasistencia" required
                               class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="horasInasistenciaNew" class="control-label">Horas</label>

                        <input id="horasInasistenciaNew" name="horasInasistenciaNew" type="text" maxlength="150"
                               placeholder="Horas de inasistencia" required
                               class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="tipoInasistenciaNew" class="control-label">Tipo de Inasistencia</label>
                        <select id="tipoInasistenciaNew" name="tipoInasistenciaNew" required
                                class="form-control input-lg select" style="width: 100%;">
                            <option value="">Selecionar Tipo de Inasistencia</option>
                            <?php
                            foreach ($listaTiposInasistencias as $codigo => $nombre) {
                                echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group entrada-datos">
                        <label for="observacionesNew" class="control-label">Observaciones</label>
                        <textarea id="observacionesNew" name="observacionesNew" type="text" maxlength="150"
                                  placeholder="Ingresar observaciones" required
                                  class="form-control input-lg"></textarea>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnRegistrarInasistencia" class="btn btn-primary">Guardar
                </button>
            </div>
        </div>
    </div>
</div>
</div>
<!--=====================================
MODAL ACTUALIZAR INASISTENCIA
======================================-->
<div id="modalActualizarInasistencia" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Editar Inasistencia Registrada</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            CUERPO DEL MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--=====================================
                     DATOS DEL REGISTRO A MODIFICAR
                    ======================================-->
                    <input id="codigoCarreraUpd" name="codigoCarreraUpd" maxlength="150" type="hidden" hidden
                           class="form-control input-lg">
                    <input id="codigoSedeAcadUpd" name="codigoSedeAcadUpd" maxlength="150" type="hidden" hidden
                           class="form-control input-lg">
                    <input id="numeroPlanEstudiosUpd" name="numeroPlanEstudiosUpd" maxlength="150" type="hidden" hidden
                           class="form-control input-lg">
                    <input id="siglaMateriaUpd" name="siglaMateriaUpd" maxlength="150" type="hidden" hidden
                           class="form-control input-lg">
                    <div class="form-group entrada-datos">
                        <label for="grupoUpd" class="control-label">Grupo</label>
                        <input id="grupoUpd" name="grupoUpd" maxlength="150"
                               class="form-control input-lg" readonly>
                    </div>
                    <input id="gestionUpd" name="gestionUpd" maxlength="150" type="hidden" hidden
                           class="form-control input-lg">
                    <input id="mesUpd" name="mesUpd" maxlength="150" type="hidden"
                           class="form-control input-lg">
                    <input id="codigoTrabajadorUpd" name="codigoTrabajadorUpd" maxlength="150" hidden
                           class="form-control input-lg">
                    <div class="form-group entrada-datos">
                        <label for="fechaUpd" class="control-label">Fecha</label>
                        <input id="fechaUpd" name="fechaUpd" type="date" maxlength="150"
                               placeholder="Ingresar fecha" required class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="horasUpd" class="control-label">Horas</label>
                        <input id="horasUpd" name="horasUpd" type="text" maxlength="150"
                               placeholder="Ingresar horas" required class="form-control input-lg">
                    </div>
                    <div class="form-group">
                        <label for="tipoInasistenciaUpd">Tipo de Inasistencia</label>
                        <select id="tipoInasistenciaUpd" name="tipoInasistenciaUpd" required
                                class="form-control input-lg select" style="width: 100%;">
                            <option value="">Selecionar Tipo de Inasistencia</option>
                            <?php
                            foreach ($listaTiposInasistencias as $codigo => $nombre) {
                                echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="observacionUpd" class="control-label">Observaciones</label>
                        <textarea id="observacionUpd" name="observacionUpd" type="text" maxlength="150"
                                  placeholder="Ingresar observaciones" required
                                  class="form-control input-lg"></textarea>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnActualizarInasistencia" class="btn btn-primary">Guardar
                </button>
            </div>
        </div>
    </div>
</div>



