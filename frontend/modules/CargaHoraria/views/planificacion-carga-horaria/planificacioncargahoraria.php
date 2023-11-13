<?php

use app\modules\CargaHoraria\assests\CargaHorariaAsset;
use yii\web\View;

CargaHorariaAsset::register($this);

$this->registerJsFile("@web/js/planificacioncargahoraria.js", [
    'depends' => [
        \yii\web\JqueryAsset::className()
    ]
]);
$this->title = 'Planificacion Carga Horaria';
?>
<div class="row">
    <div class="offset-sm-2 col-sm-8 offset-md-3 col-md-6">
        <table class="table table-bordered table-striped " width="10%">
            <tr class="search-autoridad" hidden>
                <th> Autoridad</th>
                <td>
                        <span>   <?= $codigoUsuario ?> </span>
                        <input id="codigoUsuarioSearch" value="<?= $codigoUsuario ?>">
                </td>
            </tr>
            <tr class="search-facultad">
                <th> Facultad</th>
                <td>
                    <?php
                    if ($cantidadFacultades != 1) {
                        ?>
                        <select id="codigoFacultadSearch" name="codigoFacultadSearch" required
                                class="form-control input-lg">
                            <option value="">Selecionar Facultad</option>
                            <?php
                            foreach ($facultades as $codigo => $nombre) {
                                echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                            }
                            ?>
                        </select>
                        <?php
                    } else {
                        ?>
                        <span>   <?= $nombreFacultad ?> </span>
                        <input id="codigoFacultadSearch" value="<?= $codigoFacultad ?>" hidden>
                        <?php
                    }
                    ?>
                </td>
            </tr>
            <tr class="search-carrera">
                <th> Carrera</th>
                <td>
                    <?php
                    if ($cantidadCarreras != 1) {
                        ?>
                        <select id="codigoCarreraSearch" name="codigoCarreraSearch" required
                                class="form-control input-lg">
                        </select>
                        <?php
                    } else {
                        ?>
                        <span>   <?= $nombreCarrera ?> </span>
                        <input id="codigoCarreraSearch" value="<?= $codigoCarrera ?>" hidden>
                        <?php
                    }
                    ?>
                </td>
            </tr>
            <tr class="search-sede">
                <th> Sede</th>
                <td>
                        <select id="sedeSearch" name="sedeSearch" required
                                class="form-control input-lg">
                        </select>
                </td>
            </tr>
            <tr class="search-plan">
                <th> Plan Estudios</th>
                <td>
                    <select id="numeroPlanEstudiosSearch" name="numeroPlanEstudiosSearch" required
                            class="form-control input-lg">
                    </select>
                </td>
            </tr>
            <tr class="search-curso">
                <th> Curso</th>
                <td>
                    <select id="cursoSearch" name="cursoSearch" required
                            class="form-control input-lg">
                    </select>
                    <input id="estadoPlanificacion" value="<?= $codigoEstadoPlanificacion ?>" hidden>
                </td>
            </tr>
        </table>
    </div>
</div>
<br/>
<div class="card tabla-materias">
    <div class="card-header">
        <div class="row row-cols-1">
            <label class="col">
                <h1>CONFIGURACIÓN DE COMPARACIÓN</h1>
                <button class='btn btn-warning btnEditarConfiguracion' data-toggle='modal'
                        data-target='#modalModificarConfiguracion'>
                    <i class='fa fa-pen'></i>
                </button>
            </label>
        </div>
        <div class="row row-cols-8 align-items-start">
            <div class="col">
                <label>Año:</label>
            </div>
            <div class="col">
                <span id="gestionAnteriorConf"></span>
            </div>
            <div class="col">
                <label>Mes:</label>
            </div>
            <div class="col">
                <span id="mesAnteriorConf"></span>
            </div>
            <div class="col">
                <label>Gestion Anterior:</label>
            </div>
            <div class="col">
                <span id="gestionAcademicaAnteriorConf"></span>
            </div>
            <div class="col">
                <label>Gestion Planif.:</label>
            </div>
            <div class="col">
                <span id="gestionAcademicaPlanificacionConf"></span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table id="tablaMaterias" class="table table-bordered table-striped dt-responsive" width="100%">
            <thead>
            <tr>
                <th colspan="2" style="text-align: center; font-weight: bold;">Materia</th>
                <th colspan="7" style="text-align: center; font-weight: bold;"><span
                            id="gestionAcademicaAnterior"></span></th>
                <th colspan="7" style="text-align: center; font-weight: bold;"><span
                            id="gestionAcademicaPlanificacion"></span></th>
                <th id="accionesConfiguracion" rowspan="3" style="text-align: center; font-weight: bold;">Acciones</th>
            </tr>
            <tr>
                <th rowspan="2" style="text-align: center; font-weight: bold;">Sigla</th>
                <th rowspan="2" style="text-align: center; font-weight: bold;">Nombre</th>
                <th rowspan="2" style="text-align: center; font-weight: bold;">Est</th>
                <th colspan="6" style="text-align: center; font-weight: bold;">Grupos</th>
                <th rowspan="2" style="text-align: center; font-weight: bold;">Est</th>
                <th colspan="6" style="text-align: center; font-weight: bold;">Grupos</th>
            </tr>
            <tr>
                <th style="text-align: center; font-weight: bold;">T</th>
                <th style="text-align: center; font-weight: bold;">ET</th>
                <th style="text-align: center; font-weight: bold;">P</th>
                <th style="text-align: center; font-weight: bold;">EP</th>
                <th style="text-align: center; font-weight: bold;">L</th>
                <th style="text-align: center; font-weight: bold;">EL</th>
                <th style="text-align: center; font-weight: bold;">T</th>
                <th style="text-align: center; font-weight: bold;">ET</th>
                <th style="text-align: center; font-weight: bold;">P</th>
                <th style="text-align: center; font-weight: bold;">EP</th>
                <th style="text-align: center; font-weight: bold;">L</th>
                <th style="text-align: center; font-weight: bold;">EL</th>
            </tr>
            </thead>
            <tbody id="contenidoMaterias">

            </tbody>
        </table>
        <br>
        <button  class='btn btn-danger btnFinalizarConfiguracion' >
            FINALIZAR
        </button>
        <button  class='btn btn-danger btnFinalizarConfiguracionRector' >
            FINALIZAR
        </button>
    </div>
    <div class="card-footer-direcciones">
        <button id="btnComparaciones" class="btn btn-primary" data-toggle="modal"
                data-target="#modalComparaciones">
            Comparaciones
        </button>
    </div>
    <div class="card-footer">
        <button id="btnAcefaliasResumen" class="btn btn-primary" data-toggle="modal"
                data-target="#modalAcefaliasResumen">
            Acefalias Resumen
        </button>
        <button id="btnAcefaliasDetalle" class="btn btn-primary" data-toggle="modal"
                data-target="#modalAcefaliasDetalle">
            Acefalias Detalle
        </button>
        <button id="btnSuplenciasResumen" class="btn btn-warning" data-toggle="modal"
                data-target="#modalSuplenciasResumen">
            Suplencias Resumen
        </button>
        <button id="btnSuplenciasDetalle" class="btn btn-warning" data-toggle="modal"
                data-target="#modalSuplenciasDetalle">
            Suplencias Detalle
        </button>
        <button id="btnDocentesCarreraResumen" class="btn btn-success" data-toggle="modal"
                data-target="#modalDocentesCarreraResumen">
            Docentes Carrera Resumen
        </button>
        <button id="btnDocentesUniversidadResumen" class="btn btn-success" data-toggle="modal"
                data-target="#modalDocentesUniversidadResumen">
            Docentes Universidad Resumen
        </button>
        <button id="btnExtraordinariasResumen" class="btn btn-danger" data-toggle="modal"
                data-target="#modalExtraordinariasResumen">
            Monitorajes Resumen
        </button>
    </div>
</div>

<!--=====================================
MODAL NUEVA CARGA HORARIA PROPUESTA
======================================-->
<div id="modalNuevaPlanificacion" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Creación Grupo(Planificación)</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--==============================================
                    DATOS DE LA MATERIA
                    ================================================-->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Carrera:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="nombreCarreraNew"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Plan:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="numeroPlanEstudiosNew"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Sigla:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="siglaMateriaNew"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Materia:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="nombreMateriaNew"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Tipo:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <select id="tipoGrupoNew">
                                    <option value="">Seleccionar Tipo</option>
                                    <option value="T">TEORIA</option>
                                    <option value="P">PRACTICA</option>
                                    <option value="L">LABORATORIO</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Grupo:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <input type="text" id="grupoNew"/>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnCrearCargaHorariaPropuesta" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!--=====================================
MODAL MODIFICAR PLANIFICACION
======================================-->
<div id="modalModificarPlanificacion" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Asignación de docentes (Planificación)</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--==============================================
                    DATOS DE LA MATERIA
                    ================================================-->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Carrera:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="nombreCarreraModif"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Plan:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="numeroPlanEstudiosModif"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Sigla:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="siglaMateriaModif"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Materia:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="nombreMateriaModif"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Tipo:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <select id="tipoGrupoModif">
                                    <option value="">Seleccionar Tipo</option>
                                    <option value="T">TEORIA</option>
                                    <option value="P">PRACTICA</option>
                                    <option value="L">LABORATORIO</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <table id="tablaCargasHorariasPropuestas"
                                   class="table table-bordered table-striped dt-responsive"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th style="text-align: center; font-weight: bold;">Codigo</th>
                                    <th style="text-align: center; font-weight: bold;">Id Persona</th>
                                    <th style="text-align: center; font-weight: bold;">Nombre Completo</th>
                                    <th style="text-align: center; font-weight: bold;">Condicion</th>
                                    <th style="text-align: center; font-weight: bold;">Grupo</th>
                                    <th style="text-align: center; font-weight: bold;">Tipo</th>
                                    <th style="text-align: center; font-weight: bold;">Horas</th>
                                </tr>
                                </thead>
                                <tbody id="contenidoCargasHorariasPropuestas">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>
<!--=====================================
MODAL MODIFICAR CONFIGURACION DE PLANIFICACION
======================================-->
<div id="modalModificarConfiguracion" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Configuración de Planificación</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--==============================================
                    DATOS DE LA CARRERA
                    ================================================-->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Carrera:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="nombreCarreraConfModif"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Sede:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="sedeConfigModif"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Año:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <input type="text" id="gestionAnteriorConfModif"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Mes:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <select id="mesAnteriorConfModif">
                                    <option value="">Seleccionar Mes</option>
                                    <option value="1">Enero</option>
                                    <option value="2">Febrero</option>
                                    <option value="3">Marzo</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Mayo</option>
                                    <option value="6">Junio</option>
                                    <option value="7">Julio</option>
                                    <option value="8">Agosto</option>
                                    <option value="9">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Gestión Ant:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <input type="text" id="gestionAcademicaAnteriorConfModif"/>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnActualizarConfiguracion" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!--=====================================
MODAL HORAS PLAN DE ESTUDIOS
======================================-->
<div id="modalHorasPlanEstudios" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Horas de acuerdo a plan de estudios</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--==============================================
                    DATOS DE LA MATERIA
                    ================================================-->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Carrera:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="hrsPlanNombreCarrera"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Plan:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="hrsPlanNumeroPlanEstudios"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Sigla:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="hrsPlanSiglaMateria"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Materia:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="hrsPlanNombreMateria"></span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <table id="tablaHorasPlanEstudiosMateria"
                                   class="table table-bordered table-striped dt-responsive"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th style="text-align: center; font-weight: bold;">Teoria</th>
                                    <th style="text-align: center; font-weight: bold;">Practica</th>
                                    <th style="text-align: center; font-weight: bold;">Laboratorio</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td style="text-align: center; font-weight: bold;"><span
                                                id="hrsPlanHrsTeoria"></span>
                                    </td>
                                    <td style="text-align: center; font-weight: bold;"><span
                                                id="hrsPlanHrsPractica"></span>
                                    </td>
                                    <td style="text-align: center; font-weight: bold;"><span
                                                id="hrsPlanHrsLaboratorio"></span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>
<!--================================================
MODAL RESUMEN CH DE DOCENTES DE UNA MATERIA (ANTERIOR)
==================================================-->
<div id="modalDocentesMateriaResumenAnterior" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Nomina de Docentes (Anterior)</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--==============================================
                    DATOS DE LA MATERIA
                    ================================================-->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Carrera:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="docMatResAnteriorNombreCarrera"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Plan:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="docMatResAnteriorNumeroPlanEstudios"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Sigla:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="docMatResAnteriorSiglaMateria"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Materia:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="docMatResAnteriorNombreMateria"></span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <table id="tablaDocentesMateriaResumenAnterior"
                                   class="table table-bordered table-striped dt-responsive"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th rowspan="2" style="width:10px">#</th>
                                    <th colspan="2" style="text-align: center; font-weight: bold;">Docente</th>
                                    <th rowspan="2" style="text-align: center; font-weight: bold;">Condicion</th>
                                    <th colspan="3" style="text-align: center; font-weight: bold;">Grupos</th>
                                    <th colspan="4" style="text-align: center; font-weight: bold;">Horas</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center; font-weight: bold;">C.I.</th>
                                    <th style="text-align: center; font-weight: bold;">Nombre Completo</th>
                                    <th style="text-align: center; font-weight: bold;">Teo.</th>
                                    <th style="text-align: center; font-weight: bold;">Pra.</th>
                                    <th style="text-align: center; font-weight: bold;">Lab.</th>
                                    <th style="text-align: center; font-weight: bold;">Teo.</th>
                                    <th style="text-align: center; font-weight: bold;">Pra.</th>
                                    <th style="text-align: center; font-weight: bold;">Lab.</th>
                                    <th style="text-align: center; font-weight: bold;">Total</th>
                                </tr>
                                </thead>
                                <tbody id="contenidoDocentesMateriaResumenAnterior">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>
<!--=====================================
MODAL RESUMEN CH DE DOCENTES DE UNA MATERIA (ACTUAL)
======================================-->
<div id="modalDocentesMateriaResumenActual" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Nomina de Docentes (Actual)</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--==============================================
                    DATOS DE LA MATERIA
                    ================================================-->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Carrera:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="docMatResActualNombreCarrera"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Plan:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="docMatResActualNumeroPlanEstudios"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Sigla:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="docMatResActualSiglaMateria"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Materia:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="docMatResActualNombreMateria"></span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <table id="tablaDocentesMateriaResumenActual"
                                   class="table table-bordered table-striped dt-responsive"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th rowspan="2" style="width:10px">#</th>
                                    <th colspan="2" style="text-align: center; font-weight: bold;">Docente</th>
                                    <th rowspan="2" style="text-align: center; font-weight: bold;">Condicion</th>
                                    <th colspan="3" style="text-align: center; font-weight: bold;">Grupos</th>
                                    <th colspan="4" style="text-align: center; font-weight: bold;">Horas</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center; font-weight: bold;">C.I.</th>
                                    <th style="text-align: center; font-weight: bold;">Nombre Completo</th>
                                    <th style="text-align: center; font-weight: bold;">Teo.</th>
                                    <th style="text-align: center; font-weight: bold;">Pra.</th>
                                    <th style="text-align: center; font-weight: bold;">Lab.</th>
                                    <th style="text-align: center; font-weight: bold;">Teo.</th>
                                    <th style="text-align: center; font-weight: bold;">Pra.</th>
                                    <th style="text-align: center; font-weight: bold;">Lab.</th>
                                    <th style="text-align: center; font-weight: bold;">Total</th>
                                </tr>
                                </thead>
                                <tbody id="contenidoDocentesMateriaResumenActual">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>
<!--====================================
MODAL MATERIAS DOCENTES ACAD (ANTERIOR)
=======================================-->
<div id="modalMateriasDocentesAcadAnterior" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Asignación Materias Docentes (Anterior)</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--==============================================
                    DATOS DE LA MATERIA
                    ================================================-->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Gestión Acad.:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="matDocAcadAnteriorGestionAcademica"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Carrera:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="matDocAcadAnteriorNombreCarrera"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Plan:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="matDocAcadAnteriorNumeroPlanEstudios"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Sigla:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="matDocAcadAnteriorSiglaMateria"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Materia:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="matDocAcadAnteriorNombreMateria"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Tipo:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="matDocAcadAnteriorTipoGrupo"></span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <table id="tablaMateriasDocentesAcadAnterior"
                                   class="table table-bordered table-striped dt-responsive"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th rowspan="2" style="width:10px">#</th>
                                    <th colspan="2" style="text-align: center; font-weight: bold;">Docente</th>
                                    <th rowspan="2" style="text-align: center; font-weight: bold;">Grupo</th>
                                    <!--                                    <th rowspan="2" style="text-align: center; font-weight: bold;">Tipo</th>-->
                                    <th colspan="2" style="text-align: center; font-weight: bold;">Estudiantes</th>
                                    <th rowspan="2" style="text-align: center; font-weight: bold;">Informa C.H.</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center; font-weight: bold;">C.I.</th>
                                    <th style="text-align: center; font-weight: bold;">Nombre Completo</th>
                                    <th style="text-align: center; font-weight: bold;">Limite</th>
                                    <th style="text-align: center; font-weight: bold;">Programados</th>
                                </tr>
                                </thead>
                                <tbody id="contenidoMateriasDocentesAcadAnterior">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>
<!--====================================
MODAL MATERIAS DOCENTES ACAD (ACTUAL)
=======================================-->
<div id="modalMateriasDocentesAcadActual" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Asignación Materias Docentes (Actual)</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--==============================================
                    DATOS DE LA MATERIA
                    ================================================-->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Gestión Acad.:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="matDocAcadActualGestionAcademica"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Carrera:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="matDocAcadActualNombreCarrera"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Plan:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="matDocAcadActualNumeroPlanEstudios"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Sigla:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="matDocAcadActualSiglaMateria"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Materia:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="matDocAcadActualNombreMateria"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Tipo:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="matDocAcadActualTipoGrupo"></span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <table id="tablaMateriasDocentesAcadActual"
                                   class="table table-bordered table-striped dt-responsive"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th rowspan="2" style="width:10px">#</th>
                                    <th colspan="2" style="text-align: center; font-weight: bold;">Docente</th>
                                    <th rowspan="2" style="text-align: center; font-weight: bold;">Grupo</th>
                                    <th rowspan="2" style="text-align: center; font-weight: bold;">Tipo</th>
                                    <th colspan="2" style="text-align: center; font-weight: bold;">Estudiantes</th>
                                    <th rowspan="2" style="text-align: center; font-weight: bold;">Informa C.H.</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center; font-weight: bold;">C.I.</th>
                                    <th style="text-align: center; font-weight: bold;">Nombre Completo</th>
                                    <th style="text-align: center; font-weight: bold;">Limite</th>
                                    <th style="text-align: center; font-weight: bold;">Programados</th>
                                </tr>
                                </thead>
                                <tbody id="contenidoMateriasDocentesAcadActual">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>
<!--========================================
MODAL ACEFALIAS RESUMEN (ACTUAL y PROPUESTO)
==========================================-->
<div id="modalAcefaliasResumen" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Comparativa Acefalias (Resumen)</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--==============================================
                    DATOS DE LA CARRERA
                    ================================================-->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Gestión Acad.:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="aceResGestionAcademica"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Carrera:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="aceResNombreCarrera"></span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <table id="tablaAcefaliasResumen" class="table table-bordered table-striped dt-responsive"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th rowspan="2" style="width:10px">#</th>
                                    <th colspan="4" style="text-align: center; font-weight: bold;">Materia</th>
                                    <th colspan="2" style="text-align: center; font-weight: bold;">Horas</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center; font-weight: bold;">Plan</th>
                                    <th style="text-align: center; font-weight: bold;">Curso</th>
                                    <th style="text-align: center; font-weight: bold;">Sigla</th>
                                    <th style="text-align: center; font-weight: bold;">Nombre</th>
                                    <th style="text-align: center; font-weight: bold;">C.H.</th>
                                    <th style="text-align: center; font-weight: bold;">PROP</th>
                                </tr>
                                </thead>
                                <tbody id="contenidoAcefaliasResumen">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>
<!--=========================================
MODAL ACEFALIAS DETALLE (ACTUAL y PROPUESTO)
===========================================-->
<div id="modalAcefaliasDetalle" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Comparativa Acefalias (Detalle)</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--==============================================
                    DATOS DE LA CARRERA
                    ================================================-->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Gestión Acad.:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="aceDetGestionAcademica"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Carrera:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="aceDetNombreCarrera"></span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <table id="tablaAcefaliasDetalle" class="table table-bordered table-striped dt-responsive"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th rowspan="2" style="width:10px">#</th>
                                    <th colspan="6" style="text-align: center; font-weight: bold;">Materia</th>
                                    <th colspan="2" style="text-align: center; font-weight: bold;">Horas</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center; font-weight: bold;">Plan</th>
                                    <th style="text-align: center; font-weight: bold;">Curso</th>
                                    <th style="text-align: center; font-weight: bold;">Sigla</th>
                                    <th style="text-align: center; font-weight: bold;">Nombre</th>
                                    <th style="text-align: center; font-weight: bold;">Tipo</th>
                                    <th style="text-align: center; font-weight: bold;">Grupo</th>
                                    <th style="text-align: center; font-weight: bold;">C.H.</th>
                                    <th style="text-align: center; font-weight: bold;">PROP</th>
                                </tr>
                                </thead>
                                <tbody id="contenidoAcefaliasDetalle">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>
<!--===================
MODAL SUPLENCIAS RESUMEN
========================-->
<div id="modalSuplenciasResumen" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Suplencias (Resumen)</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--==============================================
                    DATOS DE LA CARRERA
                    ================================================-->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Gestión Acad.:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="supResGestionAcademica"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Carrera:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="supResNombreCarrera"></span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <table id="tablaSuplenciasResumen" class="table table-bordered table-striped dt-responsive"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th rowspan="2" style="width:10px">#</th>
                                    <th colspan="4" style="text-align: center; font-weight: bold;">Materia</th>
                                    <th colspan="3" style="text-align: center; font-weight: bold;">Docente</th>
                                    <th colspan="3" style="text-align: center; font-weight: bold;">Declaratoria</th>
                                    <th rowspan="2" style="text-align: center; font-weight: bold;">Horas</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center; font-weight: bold;">Plan</th>
                                    <th style="text-align: center; font-weight: bold;">Curso</th>
                                    <th style="text-align: center; font-weight: bold;">Sigla</th>
                                    <th style="text-align: center; font-weight: bold;">Nombre</th>
                                    <th style="text-align: center; font-weight: bold;">Id Persona</th>
                                    <th style="text-align: center; font-weight: bold;">Nombre</th>
                                    <th style="text-align: center; font-weight: bold;">Condicion</th>
                                    <th style="text-align: center; font-weight: bold;">Tipo</th>
                                    <th style="text-align: center; font-weight: bold;">Inicio</th>
                                    <th style="text-align: center; font-weight: bold;">Fin</th>
                                </tr>
                                </thead>
                                <tbody id="contenidoSuplenciasResumen">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>
<!--===================
MODAL SUPLENCIAS DETALLE
========================-->
<div id="modalSuplenciasDetalle" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Suplencias (Detalle)</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--==============================================
                    DATOS DE LA CARRERA
                    ================================================-->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Gestión Acad.:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="supDetGestionAcademica"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Carrera:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="supDetNombreCarrera"></span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <table id="tablaSuplenciasDetalle" class="table table-bordered table-striped dt-responsive"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th rowspan="2" style="width:10px">#</th>
                                    <th colspan="6" style="text-align: center; font-weight: bold;">Materia</th>
                                    <th colspan="3" style="text-align: center; font-weight: bold;">Docente</th>
                                    <th colspan="3" style="text-align: center; font-weight: bold;">Declaratoria</th>
                                    <th rowspan="2" style="text-align: center; font-weight: bold;">Horas</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center; font-weight: bold;">Plan</th>
                                    <th style="text-align: center; font-weight: bold;">Curso</th>
                                    <th style="text-align: center; font-weight: bold;">Sigla</th>
                                    <th style="text-align: center; font-weight: bold;">Nombre</th>
                                    <th style="text-align: center; font-weight: bold;">Tipo</th>
                                    <th style="text-align: center; font-weight: bold;">Grupo</th>
                                    <th style="text-align: center; font-weight: bold;">Id Persona</th>
                                    <th style="text-align: center; font-weight: bold;">Nombre</th>
                                    <th style="text-align: center; font-weight: bold;">Condicion</th>
                                    <th style="text-align: center; font-weight: bold;">Tipo</th>
                                    <th style="text-align: center; font-weight: bold;">Inicio</th>
                                    <th style="text-align: center; font-weight: bold;">Fin</th>
                                </tr>
                                </thead>
                                <tbody id="contenidoSuplenciasDetalle">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>
<!--==============================================
MODAL DOCENTES DE UNA CARRERA (ACTUAL y PROPUESTO)
=================================================-->
<div id="modalDocentesCarreraResumen" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Nomina de Docentes (Carrera)</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--==============================================
                    DATOS DE LA MATERIA
                    ================================================-->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Gestión Acad.:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="docCarResGestionAcademica"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Carrera:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="docCarResNombreCarrera"></span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <table id="tablaDocentesCarreraResumen"
                                   class="table table-bordered table-striped dt-responsive"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th rowspan="2" style="width:10px">#</th>
                                    <th colspan="3" style="text-align: center; font-weight: bold;">Docente</th>
                                    <th colspan="2" style="text-align: center; font-weight: bold;">Horas</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center; font-weight: bold;">C.I.</th>
                                    <th style="text-align: center; font-weight: bold;">Nombre Completo</th>
                                    <th style="text-align: center; font-weight: bold;">Condicion</th>
                                    <th style="text-align: center; font-weight: bold;">C.H.</th>
                                    <th style="text-align: center; font-weight: bold;">PROP</th>
                                </tr>
                                </thead>
                                <tbody id="contenidoDocentesCarreraResumen">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>
<!--===================================================
MODAL DOCENTES DE UNA CARRERA-UNIV (ACTUAL y PROPUESTO)
=====================================================-->
<div id="modalDocentesUniversidadResumen" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Nomina de Docentes (Universidad)</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--==============================================
                    DATOS DE LA MATERIA
                    ================================================-->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Gestión Acad.:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="docUniResGestionAcademica"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Carrera:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="docUniResNombreCarrera"></span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <table id="tablaDocentesUniversidadResumen"
                                   class="table table-bordered table-striped dt-responsive"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th rowspan="2" style="width:10px">#</th>
                                    <th colspan="3" style="text-align: center; font-weight: bold;">Docente</th>
                                    <th colspan="2" style="text-align: center; font-weight: bold;">Horas</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center; font-weight: bold;">C.I.</th>
                                    <th style="text-align: center; font-weight: bold;">Nombre Completo</th>
                                    <th style="text-align: center; font-weight: bold;">Condicion</th>
                                    <th style="text-align: center; font-weight: bold;">C.H.</th>
                                    <th style="text-align: center; font-weight: bold;">PROP</th>
                                </tr>
                                </thead>
                                <tbody id="contenidoDocentesUniversidadResumen">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>
<!--===================
MODAL EXTRAORDINARIAS RESUMEN
========================-->
<div id="modalExtraordinariasResumen" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Monitorajes (Resumen)</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--==============================================
                    DATOS DE LA CARRERA
                    ================================================-->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Gestión Acad.:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="extResGestionAcademica"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-2">
                                <label>Carrera:</label>
                            </div>
                            <div class="col-xs-12 col-sm-10">
                                <span id="extResNombreCarrera"></span>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <table id="tablaExtraordinariasResumen"
                                   class="table table-bordered table-striped dt-responsive"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th rowspan="2" style="width:10px">#</th>
                                    <th colspan="4" style="text-align: center; font-weight: bold;">Materia</th>
                                    <th colspan="3" style="text-align: center; font-weight: bold;">Docente</th>
                                    <th rowspan="2" style="text-align: center; font-weight: bold;">Horas</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center; font-weight: bold;">Plan</th>
                                    <th style="text-align: center; font-weight: bold;">Curso</th>
                                    <th style="text-align: center; font-weight: bold;">Sigla</th>
                                    <th style="text-align: center; font-weight: bold;">Nombre</th>
                                    <th style="text-align: center; font-weight: bold;">Id Persona</th>
                                    <th style="text-align: center; font-weight: bold;">Nombre</th>
                                    <th style="text-align: center; font-weight: bold;">Condicion</th>
                                </tr>
                                </thead>
                                <tbody id="contenidoExtraordinariasResumen">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>
<!--===================
MODAL EXTRAORDINARIAS RESUMEN
========================-->
<div id="modalComparaciones" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Comparaciones Carga Horaria</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--==============================================
                    DATOS DE LA CARRERA
                    ================================================-->
                    <div class="container-fluid">
                        <div class="row">
                            <table id="tablaExtraordinariasResumen"
                                   class="table table-bordered table-striped dt-responsive"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th rowspan="2" style="width:10px">#</th>
                                    <th colspan="2" style="text-align: center; font-weight: bold;">Docente</th>
                                    <th colspan="2" style="text-align: center; font-weight: bold;">Carrera <br> (Horas Mes)</th>
                                    <th colspan="2" style="text-align: center; font-weight: bold;">Universidad</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center; font-weight: bold;">CI</th>
                                    <th style="text-align: center; font-weight: bold;">Nombre</th>
                                    <th style="text-align: center; font-weight: bold;">Antes</th>
                                    <th style="text-align: center; font-weight: bold;">Ahora</th>
                                    <th style="text-align: center; font-weight: bold;">Antes</th>
                                    <th style="text-align: center; font-weight: bold;">Ahora</th>
                                </tr>
                                </thead>
                                <tbody id="contenidoExtraordinariasResumen">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>