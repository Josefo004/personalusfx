<?php

use yii\web\JqueryAsset;

app\modules\Administracion\assets\AdministracionAsset::register($this);

$this->registerJsFile("@web/js/provincias/provincias.js", [
    'depends' => [
        JqueryAsset::className()
    ]
]);

$this->title = 'Administración Provincias';
$this->params['breadcrumbs'] = [['label' => 'Admin. Provincias']];
?>

<!--<div class="card">
    <div class="card-header">
        <button id="btnMostrarImportarProvincia" name="btnMostrarImportarProvincia" class="btn btn-primary bg-gradient-primary">
            <div class="icon closed">
                <div class="circle">
                    <div class="horizontal"></div>
                    <div class="vertical"></div>
                </div>
                Importar Provincia
            </div>
        </button>
    </div>
    <br />
    <div class="card-body" id="divListaProvincias" name="divListaProvincias">
        <table id="tablaProvincias" name="tablaProvincias" class="table table-bordered table-striped dt-responsive" width="100%">
            <thead>
                <tr>
                    <th style="text-align: center; font-weight: bold;">#</th>
                    <th style="text-align: center; font-weight: bold;">Pais</th>
                    <th style="text-align: center; font-weight: bold;">Departamento</th>
                    <th style="text-align: center; font-weight: bold;">Provincia</th>
                    <th style="text-align: center; font-weight: bold;">Estado</th>
                    <th style="text-align: center; font-weight: bold;">Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="card-body" id="divListaProvinciasAcad" name="divListaProvinciasAcad">
        <div class="form-group" align="center">
            <label for="codigoPais">Pais</label>
            <select id="codigoPais" name="codigoPais" required style="width: 20%" class="form-control input-lg">
                <option value="">Selecionar pais...</option>
                <?php
/*                foreach ($paises as $pais) {
                    echo "<option codigo-pais-acad='" . $pais->CodigoPaisAcad . "' value='" . $pais->CodigoPais . "'>" . strtoupper($pais->NombrePais) . "</option>";
                }
                */?>
            </select>
        </div>
        <div class="form-group" align="center">
            <label for="codigoDepartamento">Departamento</label>
            <select id="codigoDepartamento" name="codigoDepartamento" required style="width: 20%" class="form-control input-lg">
                <option value="">Selecionar departamento...</option>
                <?php
/*                foreach ($departamentos as $departamento) {
                    echo "<option codigo-departamento-acad='" . $departamento->CodigoDepartamentoAcad . "' value='" . $departamento->CodigoDepartamento . "'>" . strtoupper($departamento->NombreDepartamento) . "</option>";
                }
                */?>
            </select>
        </div>
        <table id="tablaProvinciasAcad" name="tablaProvinciasAcad" class="table table-bordered table-striped dt-responsive" width="100%">
            <thead>
                <tr>
                    <th style="width:10px">#</th>
                    <th>Codigo</th>
                    <th>Provincia</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
        <div align="center">
            <button id="btnCancelar" class="btn btn-danger">
                Cancelar
            </button>
        </div>
    </div>
</div>-->

<div id="vistaProvincias" class="card">
    <div class="card-header">
        <button id="btnMostrarCrearProvincia" class="btn btn-primary">
            Agregar Provincia
        </button>
    </div>
    <br/>
    <div class="card-body">
        <table id="tablaProvincias" class="table table-bordered table-striped dt-responsive tablaProvincias"
               width="100%">
            <thead>
            <tr>
                <th style="text-align: center; font-weight: bold;">#</th>
                <th style="text-align: center; font-weight: bold;">Nombre Pais</th>
                <th style="text-align: center; font-weight: bold;">Nombre Departamento</th>
                <th style="text-align: center; font-weight: bold;">Nombre Provincia</th>
                <th style="text-align: center; font-weight: bold;">Estado</th>
                <th style="text-align: center; font-weight: bold;">Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<!--=====================================
VISTA CREAR DEPARTAMENTO
======================================-->
<div id="vistaProvinciasAcad" class="card">
    <div class="card-body">
        <div class="entrada-datos form-group" align="center">
            <label for="codigoPais">Pais</label>
            <select id="codigoPais" name="codigoPais" required style="width: 20%"
                    class="form-control input-lg codigoPais">
                <option value="">Selecionar Pais</option>
                <?php
                foreach ($paises as $pais) {
                    echo "<option codigo-pais-acad='" . $pais->CodigoPaisAcad . "' value='" . $pais->CodigoPais . "'>" . strtoupper($pais->NombrePais) . "</option>";
                }
                ?>
            </select>
            <span>*Seleccione un item de la lista</span>
        </div>
        <div class="entrada-datos1 form-group" align="center">
            <label for="codigoDepartamento">Departamento</label>
            <select id="codigoDepartamento" name="codigoDepartamento" required style="width: 20%"
                    class="form-control input-lg codigoDepartamento">
                <option value="">Selecionar Departamento</option>
                <?php
                foreach ($departamentos as $departamento) {
                    echo "<option codigo-departamento-acad='" . $departamento->CodigoDepartamentoAcad . "' value='" . $departamento->CodigoDepartamento . "'>" . strtoupper($departamento->NombreDepartamento) . "</option>";
                }
                ?>
            </select>
            <span>*Seleccione un item de la lista</span>
        </div>
        <table id="tablaProvinciasAcad" class="table table-bordered table-striped dt-responsive tablaProvinciasAcad" width="100%">
            <thead>
            <tr>
                <th style="width:10px">#</th>
                <th>Codigo</th>
                <th>Provincia</th>
                <th>Acciones</th>
            </tr>
            </thead>
        </table>
        <div align="center">
            <button id="btnCancelar" class="btn btn-danger">
                Cancelar
            </button>
        </div>
    </div>
</div>