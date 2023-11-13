<?php

use yii\web\JqueryAsset;

app\modules\Filiacion\assets\FiliacionAsset::register($this);

$this->registerJsFile("@web/js/trabajadores/trabajadores.js", [
    'depends' => [
        JqueryAsset::className()
    ]
]);

$this->title = 'Filiacion Funcionarios';
$this->params['breadcrumbs'] = [['label' => 'Filiacion Funcionarios']]; ?>

<div id="vistaTrabajadores" class="card">
    <div class="card-header">
        <button id="btnMostrarCrearTrabajador" name="btnMostrarCrearTrabajador" class="btn btn-primary">
            Agregar Trabajador
        </button>
    </div>
    <br/>
    <div class="card-body">
        <table id="tablaTrabajadores" class="table table-bordered table-striped dt-responsive tablaTrabajadores"
               width="100%">
            <thead>
            <tr>
                <th style="width:10px">#</th>
                <th>Id Funcionario</th>
                <th>C.I.</th>
                <th>Nombre Completo</th>
                <th>Fecha Ingreso</th>
                <th>Fecha Salida</th>
                <th>Fecha Calculo Antiguedad.</th>
                <th>Fecha Calculo Vacaciones</th>
                <th>Fecha Finiquito</th>
                <th>AFP</th>
                <th>NUA</th>
                <th>Seguro de Salud</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<!--=====================================
MODAL CREAR TRABAJADOR
======================================
<div id="modalCrearTrabajador" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Agregar Trabajador</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            BODY MODAL
            ======================================
            <div class="modal-body">
                <div class="box-body">
                    <!--=====================================
                    DATOS DEL NUEVO TRABAJADOR
                    ======================================
                    <table class="table table-bordered table-striped dt-responsive tablaPersonas" width="100%">
                        <thead>
                        <tr>
                            <th style="width:10px">#</th>
                            <th>Id Persona</th>
                            <th>Nombre Completo</th>
                            <th>Acciones</th>
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
                        <label for="fechaIngresoNew" class="control-label">Ingreso</label>
                        <input id="fechaIngresoNew" name="fechaIngresoNew" type="date" maxlength="150"
                               placeholder="Ingresar 1ra fecha de ingreso." class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="fechaSalidaNew" class="control-label">Salida</label>
                        <input id="fechaSalidaNew" name="fechaSalidaNew" type="date" maxlength="150"
                               placeholder="Ingresar fecha de salida." class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="resolucionDocenteNew" class="control-label">Nro Resolución (Docente)</label>
                        <input id="resolucionDocenteNew" name="resolucionDocenteNew" type="text" maxlength="150"
                               placeholder="Ingresar nro de resolución (Docente)." class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="fechaResolucionDocenteNew" class="control-label">Fecha Resolución (Docente)</label>
                        <input id="fechaResolucionDocenteNew" name="fechaResolucionDocenteNew" type="date"
                               maxlength="150"
                               placeholder="Ingresar fecha de resolución (Docente)." class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="fechaCalculoDocenteNew" class="control-label">Calculo Docente</label>
                        <input id="fechaCalculoDocenteNew" name="fechaCalculoDocenteNew" type="date" maxlength="150"
                               placeholder="Ingresar fecha de calculo." class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="resolucionAdministrativoNew" class="control-label">Nro Resolución
                            (Administrativo)</label>
                        <input id="resolucionAdministrativoNew" name="resolucionAdministrativoNew" type="text"
                               maxlength="150"
                               placeholder="Ingresar nro de resolución (Administrativo)." class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="fechaResolucionAdministrativoNew" class="control-label">Fecha Resolución
                            (Administrativo)</label>
                        <input id="fechaResolucionAdministrativoNew" name="fechaResolucionAdministrativoNew" type="date"
                               maxlength="150"
                               placeholder="Ingresar fecha de resolución (Administrativo)." class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="fechaCalculoAdministrativoNew" class="control-label">Calculo</label>
                        <input id="fechaCalculoAdministrativoNew" name="fechaCalculoAdministrativoNew" type="date" maxlength="150"
                               placeholder="Ingresar fecha de calculo." class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="codigoNivelAcademicoNew">Nivel Académico</label>
                        <select id="codigoNivelAcademicoNew" name="codigoNivelAcademicoNew" required
                                class="form-control input-lg" style="width: 100%;">
                            <option value="">Selecionar Nivel Academico</option>
                            <?php
/*                            foreach ($nivelesAcademicos as $codigo => $nombre) {
                                echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                            }
                            */ ?>
                        </select>
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="codigoAfpNew">AFP</label>
                        <select id="codigoAfpNew" name="codigoAfpNew" required
                                class="form-control input-lg" style="width: 100%;">
                            <option value="">Selecionar Afp</option>
                            <?php
/*                            foreach ($afps as $codigo => $nombre) {
                                echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                            }
                            */ ?>
                        </select>
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="cuaNew" class="control-label">CUA</label>
                        <input id="cuaNew" name="cuaNew" type="text"
                               maxlength="150"
                               placeholder="Ingresar Codigo Unido de Asegurado (CUA)." class="form-control input-lg">
                    </div>
                </div>
                <div class="form-group entrada-datos">
                    <label for="codigoSeguroSaludNew">Segguro de Salud</label>
                    <select id="codigoSeguroSaludNew" name="codigoSeguroSaludNew" required
                            class="form-control input-lg" style="width: 100%;">
                        <option value="">Selecionar Seguro de Salud</option>
                        <?php
/*                        foreach ($seguroSalud as $codigo => $nombre) {
                            echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                        }
                        */ ?>
                    </select>
                </div>
            </div>
            <!--=====================================
            FOOTER DEL MODAL
            ======================================
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="submit" id="btnCrearTrabajador" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>-->

<!--=====================================
VISTA SELECCIONAR PERSONA
======================================-->
<div id="vistaPersonas" class="card">
    <div class="card-body">
        <table id="tablaPersonas" name="tablaPersonas"
               class="table table-bordered table-striped dt-responsive "
               width="100%">
            <p align="center">*Seleccione el item que desea guardar</p>
            <thead>
            <tr>
                <th style="width:10px">#</th>
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
VISTA CREAR TRABAJADOR
======================================-->
<div id="vistaCrearTrabajadorPestañas" class="card">
    <div class="card-header">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="datos-trabajador-tab" data-toggle="tab" href="#datos-trabajador"
                   role="tab"
                   aria-controls="datos-trabajador"
                   aria-selected="true">Datos Funcionario</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="datos-ingreso-tab" data-toggle="tab" href="#datos-ingreso" role="tab"
                   aria-controls="datos-ingreso"
                   aria-selected="false">Datos Ingreso</a>
            </li>
        </ul>
    </div>
    <div class="tab-content mytab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="datos-trabajador" role="tabpanel"
             aria-labelledby="datos-trabajador-tab">
            <div class="col d-flex justify-content-center">
                <div class="card " style="width: 85rem;">
                    <div class="card-header bg-gradient-primary">Ingreso Datos</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="idPersonaNew" class="control-label">C.I.</label>
                                    <input id="idPersonaNew" name="idPersonaNew" type="text" maxlength="150"
                                           readonly="true" class="form-control input-lg">
                                    <input id="idPersonaDatosNew" name="idFuncionarioNew" type="text"
                                           maxlength="150"
                                           readonly="true" class="form-control input-lg" hidden>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="nombreCompletoNew" class="control-label">Nombre Completo</label>
                                    <input id="nombreCompletoNew" name="nombreCompletoNew" type="text" maxlength="150"
                                           readonly="true" class="form-control input-lg">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="codigoSectorTrabajoNew" class="control-label">Sector Trabajo</label>
                                    <select id="codigoSectorTrabajoNew" name="codigoSectorTrabajoNew" required
                                            class="form-control input-lg" style="width: 100%;">
                                        <option value="">Selecionar Sector Trabajo</option>
                                        <?php
                                        foreach ($sectorTrabajo as $codigo => $nombre) {
                                            echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="resolucionAfpNew">Resolucion AFP</label>
                                    <input id="resolucionAfpNew" name="resolucionAfpNew" type="text" maxlength="150"
                                           placeholder="Ingresar fecha resolucion AFP." class="form-control input-lg">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="codigoAfpNew">AFP</label>
                                    <select id="codigoAfpNew" name="codigoAfpNew" required
                                            class="form-control input-lg" style="width: 100%;">
                                        <option value="">Selecionar Afp</option>
                                        <?php
                                        foreach ($afps as $codigo => $nombre) {
                                            echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="fechaRegistroAfpNew" class="control-label">Fecha registro AFP</label>
                                    <input id="fechaRegistroAfpNew" name="fechaRegistroAfpNew" type="date"
                                           maxlength="150"
                                           placeholder="Ingresar fecha registro AFP." class="form-control input-lg">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="fechaPrimerRegistroAfpNew" class="control-label">Fecha primer registro
                                        AFP</label>
                                    <input id="fechaPrimerRegistroAfpNew" name="fechaPrimerRegistroAfpNew" type="date"
                                           maxlength="150"
                                           placeholder="Ingresar fecha primer registro AFP."
                                           class="form-control input-lg">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="ultimoMesRegistroAfpNew" class="control-label">Ultimo mes registro
                                        AFP</label>
                                    <input id="ultimoMesRegistroAfpNew" name="ultimoMesRegistroAfpNew" type="date"
                                           maxlength="150"
                                           placeholder="Ingresar ultimo registro registro AFP."
                                           class="form-control input-lg">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="exclusionVoluntariaNew" class="control-label">Exclusion
                                        Voluntaria</label>
                                    <input id="exclusionVoluntariaNew" name="exclusionVoluntariaNew" type="text"
                                           maxlength="150"
                                           placeholder="Ingresar Exclusion Voluntaria."
                                           class="form-control input-lg">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="nuaNew" class="control-label">NUA</label>
                                    <input id="nuaNew" name="nuaNew" type="text"
                                           maxlength="150"
                                           placeholder="Ingresar Numero Unico de Asegurado (NUA)."
                                           class="form-control input-lg">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="codigoSeguroSaludNew">Seguro de Salud</label>
                                    <select id="codigoSeguroSaludNew" name="codigoSeguroSaludNew" required
                                            class="form-control input-lg" style="width: 100%;">
                                        <option value="">Selecionar Seguro de Salud</option>
                                        <?php
                                        foreach ($seguroSocial as $codigo => $nombre) {
                                            echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="codigoBancoNew">Entidad Bancaria</label>
                                    <select id="codigoBancoNew" name="codigoBancoNew" required
                                            class="form-control input-lg" style="width: 100%;">
                                        <option value="">Selecionar Entidad Bancaria</option>
                                        <?php
                                        foreach ($entidadBancaria as $codigo => $nombre) {
                                            echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="nroCuentaBancariaNew" class="control-label">Nro de Cuenta
                                        Bancaria</label>
                                    <input id="nroCuentaBancariaNew" name="nroCuentaBancariaNew" type="text"
                                           maxlength="150"
                                           placeholder="Ingresar Numero de Cuenta Bancaria."
                                           class="form-control input-lg">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="codigoTipoRentaNew">Tipo de Renta</label>
                                    <select id="codigoTipoRentaNew" name="codigoTipoRentaNew" required
                                            class="form-control input-lg" style="width: 100%;">
                                        <option value="">Selecionar Tipo Renta</option>
                                        <?php
                                        foreach ($tipoRenta as $codigo => $nombre) {
                                            echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="datos-ingreso" role="tabpanel" aria-labelledby="datos-ingreso-tab">
            <div class="col d-flex justify-content-center">
                <div class="card " style="width: 85rem;">
                    <div class="card-header bg-gradient-primary">Ingreso Datos</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="fechaIngresoNew" class="control-label">Fecha de Ingreso</label>
                                    <input id="fechaIngresoNew" name="fechaIngresoNew" type="date"
                                           maxlength="150"
                                           placeholder="Ingresar 1ra fecha de ingreso."
                                           class="form-control input-lg">
                                    <input id="idPersonaDatosNew" name="idPersonaDatosNew" type="text" maxlength="150"
                                           readonly="true" class="form-control input-lg" hidden>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="fechaSalidaNew" class="control-label">Fecha de Salida</label>
                                    <input id="fechaSalidaNew" name="fechaSalidaNew" type="date" maxlength="150"
                                           placeholder="Ingresar fecha de salida."
                                           class="form-control input-lg">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="fechaCalculoAntiguedadNew" class="control-label">Fecha Calculo de
                                        Antiguedad</label>
                                    <input id="fechaCalculoAntiguedadNew" name="fechaCalculoAntiguedadNew" type="date"
                                           maxlength="150"
                                           placeholder="Ingresar fecha calculo antiguedad."
                                           class="form-control input-lg">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="antiguedadExternaReconocidaNew" class="control-label">Antigüedad Externa
                                        Reconocida</label>
                                    <input id="antiguedadExternaReconocidaNew" name="antiguedadExternaReconocidaNew"
                                           type="text" maxlength="150"
                                           placeholder="Ingresar antiguedad reconocida."
                                           class="form-control input-lg">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="fechaCalculoVacacionesNew" class="control-label">Fecha Calculo
                                        Vacaciones</label>
                                    <input id="fechaCalculoVacacionesNew" name="fechaCalculoVacacionesNew" type="date"
                                           maxlength="150"
                                           placeholder="Ingresar fecha de calculo de vacaciones."
                                           class="form-control input-lg">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="fechaFiniquitoNew" class="control-label">Fecha Finiquito</label>
                                    <input id="fechaFiniquitoNew" name="fechaFiniquitoNew" type="date"
                                           maxlength="150"
                                           placeholder="Ingresar fecha de finiquito."
                                           class="form-control input-lg">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="card-footer text-center">
                        <button type="submit" id="btnCrearTrabajador"
                                class='btn btn-primary bg-gradient-primary'>
                            <i class='fa fa-check-circle-o'>Guardar</i></button>
                    </div>
                </div>
            </div>
            <!-- content here -->
        </div>
    </div>
</div>


<!--=====================================
MODAL ACTUALIZAR TRABAJADOR
======================================-->
<div id="modalActualizarTrabajador" class="modal fade" role="dialog">
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
            CUERPO DEL MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--=====================================
                     DATOS DEL TRABAJADOR MODIFICADO
                     ======================================-->
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group entrada-datos">
                                <label for="idFuncionarioUpd" class="control-label">Id Funcionario</label>
                                <input id="idFuncionarioUpd" name="IdFuncionarioUpd" type="text" maxlength="150"
                                       readonly="true" class="form-control input-lg">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group entrada-datos">
                                <label for="idPersonaUpd" class="control-label">C.I.</label>
                                <input id="idPersonaUpd" name="idPersonaUpd" type="text" maxlength="150"
                                       readonly="true" class="form-control input-lg">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group entrada-datos">
                                <label for="nombreCompletoUpd" class="control-label">Nombre</label>
                                <input id="nombreCompletoUpd" name="nombreCompletoUpd" type="text" maxlength="150"
                                       readonly="true" class="form-control input-lg">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="codigoSectorTrabajoUpd" class="control-label">Sector Trabajo</label>
                                <select id="codigoSectorTrabajoUpd" name="codigoSectorTrabajoUpd" required
                                        class="form-control input-lg" style="width: 100%;">
                                    <option value="">Selecionar Sector Trabajo</option>
                                    <?php
                                    foreach ($sectorTrabajo as $codigo => $nombre) {
                                        echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="resolucionAfpUpd">Resolucion AFP</label>
                                <input id="resolucionAfpUpd" name="resolucionAfpUpd" type="text" maxlength="150"
                                       placeholder="Ingresar fecha resolucion AFP." class="form-control input-lg">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="codigoAfpUpd">AFP</label>
                                <select id="codigoAfpUpd" name="codigoAfpUpd" required
                                        class="form-control input-lg" style="width: 100%;">
                                    <option value="">Selecionar Afp</option>
                                    <?php
                                    foreach ($afps as $codigo => $nombre) {
                                        echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="fechaRegistroAfpUpd" class="control-label">Fecha registro AFP</label>
                                <input id="fechaRegistroAfpUpd" name="fechaRegistroAfpUpd" type="date"
                                       maxlength="150"
                                       placeholder="Ingresar fecha registro AFP." class="form-control input-lg">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="fechaPrimerRegistroAfpUpd" class="control-label">Fecha primer registro
                                    AFP</label>
                                <input id="fechaPrimerRegistroAfpUpd" name="fechaPrimerRegistroAfpUpd" type="date"
                                       maxlength="150"
                                       placeholder="Ingresar fecha primer registro AFP."
                                       class="form-control input-lg">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="ultimoMesRegistroAfpUpd" class="control-label">Ultimo mes registro
                                    AFP</label>
                                <input id="ultimoMesRegistroAfpUpd" name="ultimoMesRegistroAfpUpd" type="date"
                                       maxlength="150"
                                       placeholder="Ingresar ultimo registro registro AFP."
                                       class="form-control input-lg">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="exclusionVoluntariaUpd" class="control-label">Exclusion
                                    Voluntaria</label>
                                <input id="exclusionVoluntariaUpd" name="exclusionVoluntariaUpd" type="text"
                                       maxlength="150"
                                       placeholder="Ingresar Exclusion Voluntaria."
                                       class="form-control input-lg">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="nuaUpd" class="control-label">NUA</label>
                                <input id="nuaUpd" name="nuaUpd" type="text"
                                       maxlength="150"
                                       placeholder="Ingresar Numero Unico de Asegurado (NUA)."
                                       class="form-control input-lg">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="codigoSeguroSaludUpd">Seguro de Salud</label>
                                <select id="codigoSeguroSaludUpd" name="codigoSeguroSaludUpd" required
                                        class="form-control input-lg" style="width: 100%;">
                                    <option value="">Selecionar Seguro de Salud</option>
                                    <?php
                                    foreach ($seguroSocial as $codigo => $nombre) {
                                        echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="codigoBancoUpd">Entidad Bancaria</label>
                                <select id="codigoBancoUpd" name="codigoBancoUpd" required
                                        class="form-control input-lg" style="width: 100%;">
                                    <option value="">Selecionar Entidad Bancaria</option>
                                    <?php
                                    foreach ($entidadBancaria as $codigo => $nombre) {
                                        echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="nroCuentaBancariaUpd" class="control-label">Nro de Cuenta
                                    Bancaria</label>
                                <input id="nroCuentaBancariaUpd" name="nroCuentaBancariaUpd" type="text"
                                       maxlength="150"
                                       placeholder="Ingresar Numero de Cuenta Bancaria."
                                       class="form-control input-lg">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="codigoTipoRentaUpd">Tipo de Renta</label>
                                <select id="codigoTipoRentaUpd" name="codigoTipoRentaUpd" required
                                        class="form-control input-lg" style="width: 100%;">
                                    <option value="">Selecionar Tipo Renta</option>
                                    <?php
                                    foreach ($tipoRenta as $codigo => $nombre) {
                                        echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="fechaIngresoUpd" class="control-label">Fecha de Ingreso</label>
                                <input id="fechaIngresoUpd" name="fechaIngresoUpd" type="date"
                                       maxlength="150"
                                       placeholder="Ingresar 1ra fecha de ingreso."
                                       class="form-control input-lg">
                                <input id="idPersonaDatosUpd" name="idPersonaDatosUpd" type="text" maxlength="150"
                                       readonly="true" class="form-control input-lg" hidden>
                                <input id="fechaActualizacionUpd" name="fechaActualizacionUpd" type="datetime" maxlength="150"
                                       readonly="true" class="form-control input-lg" hidden>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="fechaSalidaUpd" class="control-label">Fecha de Salida</label>
                                <input id="fechaSalidaUpd" name="fechaSalidaUpd" type="date" maxlength="150"
                                       placeholder="Ingresar fecha de salida."
                                       class="form-control input-lg">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="fechaCalculoAntiguedadUpd" class="control-label">Fecha Calculo de
                                    Antiguedad</label>
                                <input id="fechaCalculoAntiguedadUpd" name="fechaCalculoAntiguedadUpd" type="date"
                                       maxlength="150"
                                       placeholder="Ingresar fecha calculo antiguedad."
                                       class="form-control input-lg">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="antiguedadExternaReconocidaUpd" class="control-label">Antigüedad Externa
                                    Reconocida</label>
                                <input id="antiguedadExternaReconocidaUpd" name="antiguedadExternaReconocidaUpd"
                                       type="text" maxlength="150"
                                       placeholder="Ingresar antiguedad reconocida."
                                       class="form-control input-lg">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="fechaCalculoVacacionesUpd" class="control-label">Fecha Calculo
                                    Vacaciones</label>
                                <input id="fechaCalculoVacacionesUpd" name="fechaCalculoVacacionesUpd" type="date"
                                       maxlength="150"
                                       placeholder="Ingresar fecha de calculo de vacaciones."
                                       class="form-control input-lg">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="fechaFiniquitoUpd" class="control-label">Fecha Finiquito</label>
                                <input id="fechaFiniquitoUpd" name="fechaFiniquitoUpd" type="date"
                                       maxlength="150"
                                       placeholder="Ingresar fecha de finiquito."
                                       class="form-control input-lg">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--=====================================
            FOOTER MODAL
            ======================================-->
            <div class="modal-footer text-center" >
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnActualizarTrabajador" class="btn btn-primary">Guardar
                </button>
            </div>
        </div>
    </div>
</div>