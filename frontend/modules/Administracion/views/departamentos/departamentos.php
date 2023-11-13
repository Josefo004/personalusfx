<?php

use yii\web\JqueryAsset;

app\modules\Administracion\assets\AdministracionAsset::register($this);

$this->registerJsFile("@web/js/departamentos/departamentos.js", [
    'depends' => [
        JqueryAsset::className()
    ]
]);

$this->title = 'Administración Departamentos';
$this->params['breadcrumbs'] = [['label' => 'Admin. Departamentos']];
?>

<!--<div class="card">
    <div class="card-header">        
        <button id="btnMostrarImportarDepartamento" name="btnMostrarImportarDepartamento" class="btn btn-primary bg-gradient-primary">
            <div class="icon closed">
                <div class="circle">                    
                    <div class="horizontal"></div>
                    <div class="vertical"></div>
                </div>
                Importar Departamento
            </div>
        </button>
    </div>
    <br/>
    <div class="card-body" id="divListaDepartamentos" name="divListaDepartamentos">
        <table id="tablaDepartamentos" name="tablaDepartamentos" class="table table-bordered table-striped dt-responsive" width="100%">
            <thead>
                <tr>
                    <th style="text-align: center; font-weight: bold;">#</th>
                    <th style="text-align: center; font-weight: bold;">Pais</th>
                    <th style="text-align: center; font-weight: bold;">Departamento</th>
                    <th style="text-align: center; font-weight: bold;">Estado</th>
                    <th style="text-align: center; font-weight: bold;">Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="card-body" id="divListaDepartamentosAcad" name="divListaDepartamentosAcad">
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
        <table id="tablaDepartamentosAcad" name="tablaDepartamentosAcad" class="table table-bordered table-striped dt-responsive" width="100%">            
            <thead>
                <tr>
                <th style="width:10px">#</th>
                    <th>Codigo</th>
                    <th>Departamento</th>
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

<div id="vistaDepartamentos" class="card">
    <div class="card-header">
        <button id="btnMostrarCrearDepartamento" class="btn btn-primary bg-gradient-primary">
            <div class="icon closed">
                <div class="horizontal"></div>
                <div class="vertical"></div>
                Agregar Departamento
            </div>
        </button>
    </div>
    <br/>
    <div class="card-body">
        <table id="tablaDepartamentos" class="table table-bordered table-striped dt-responsive tablaDepartamentos" width="100%">
            <thead>
            <tr>
                <th style="text-align: center; font-weight: bold;">#</th>
                <th style="text-align: center; font-weight: bold;">Nombre Pais</th>
                <th style="text-align: center; font-weight: bold;">Nombre Departamento</th>
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
<div id="vistaDepartamentosAcad" class="card">
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
        <table id="tablaDepartamentosAcad" name="tablaDepartamentosAcad"
               class="table table-bordered table-striped dt-responsive" width="100%">
            <thead>
            <tr>
                <th style="width:10px">#</th>
                <th>Codigo</th>
                <th>Departamento</th>
                <th>Acciones</th>
            </tr>
            </thead>
        </table>
        <div align="center">
            <button id="btnCancelar" class="btn btn-danger">
                <div class="icon closed">
                    <div class="horizontal"></div>
                    <div class="vertical"></div>
                    Cancelar
                </div>
            </button>
        </div>
    </div>
</div>