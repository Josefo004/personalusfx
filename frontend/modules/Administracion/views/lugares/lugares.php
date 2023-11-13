<?php

use yii\web\JqueryAsset;

app\modules\Administracion\assets\AdministracionAsset::register($this);

$this->registerJsFile("@web/js/lugares/lugares.js", [
    'depends' => [
        JqueryAsset::className()
    ]
]);

$this->title = 'Administración Lugares';
$this->params['breadcrumbs'] = [['label' => 'Admin. Lugares']];
?>

<div id="vistaLugares" class="card">
    <div class="card-header">
        <button id="btnMostrarCrearLugar" class="btn btn-primary">
            Agregar Lugar
        </button>
    </div>
    <br/>
    <div class="card-body">
        <table class="table table-bordered table-striped dt-responsive tablaLugares" width="100%">
            <thead>
            <tr>
                <th style="text-align: center; font-weight: bold;">#</th>
                <th style="text-align: center; font-weight: bold;">Nombre Pais</th>
                <th style="text-align: center; font-weight: bold;">Nombre Departamento</th>
                <th style="text-align: center; font-weight: bold;">Nombre Provincia</th>
                <th style="text-align: center; font-weight: bold;">Nombre Lugar</th>
                <th style="text-align: center; font-weight: bold;">Estado</th>
                <th style="text-align: center; font-weight: bold;">Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<!--=====================================
VISTA CREAR LUGAR
======================================-->
<div id="vistaLugaresAcad" class="card">
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
            <p>*Seleccione un item de la lista</p>
        </div>
        <div class="entrada-datos1 form-group" align="center">
            <label for="codigoDepartamento">Departamento</label>
            <select  id="codigoDepartamento" name="codigoDepartamento" required
                    class="form-control input-lg codigoDepartamento " style="width: 20%"
                    disabled>
                <option value="">Selecionar Departamento</option>
            </select>
            <p>*Seleccione un item de la lista</p>
        </div>
        <div class="entrada-datos2 form-group" align="center">
            <label for="codigoProvincia">Provincia</label>
            <select id="codigoProvincia" name="codigoProvincia" required
                    class="form-control input-lg codigoProvincia " style="width: 20%"
                    disabled>
                <option value="">Selecionar Provincia</option>
            </select><p>*Seleccione un item de la lista</p>
        </div>
        <table class="table table-bordered table-striped dt-responsive tablaLugaresAcad" width="100%">
            <thead>
            <tr>
                <th style="width:10px">#</th>
                <th>Codigo Lugar</th>
                <th>Nombre Lugar</th>
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