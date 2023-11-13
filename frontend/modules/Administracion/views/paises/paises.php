<?php

use yii\web\JqueryAsset;

app\modules\Administracion\assets\AdministracionAsset::register($this);

$this->registerJsFile("@web/js/paises/paises.js", [
    'depends' => [
        JqueryAsset::className()
    ]
]);

$this->title = 'Administración Paises';
$this->params['breadcrumbs'] = [['label' => 'Admin. Paises']];
?>

<!--<div class="card">
    <div class="card-header">
        <button id="btnMostrarImportarPais" name="btnMostrarImportarPais" class="btn btn-primary bg-gradient-primary">
            <div class="icon closed">
                <div class="circle">
                    <div class="horizontal"></div>
                    <div class="vertical"></div>
                </div>
                Importar Pais
            </div>
        </button>        
    </div>    
    <div class="card-body" id="divListaPaises" name="divListaPaises">
        <table id="tablaPaises" name="tablaListaPaises" class="table table-bordered table-striped dt-responsive" style="width: 100%">
            <thead>
                <th style="text-align: center; vertical-align: middle;">#</th>
                <th style="text-align: center; vertical-align: middle;">Nombre</th>
                <th style="text-align: center; vertical-align: middle;">Nacionalidad</th>
                <th style="text-align: center; vertical-align: middle;">Estado</th>
                <th style="text-align: center; vertical-align: middle;">Acciones</th>
            </thead>
        </table>
    </div>
    <div class="card-body" id="divListaPaisesAcad" name="divListaPaisesAcad">
        <table id="tablaPaisesAcad" name="tablaPaisesAcad" class="table table-bordered table-striped dt-responsive" width="100%">
            <p align="center">*Seleccione el pais que desea importar</p>
            <thead>
                <tr>
                    <th style="width:10px">#</th>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Nacionalidad</th>
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

<div id="vistaPaises" class="card">
    <div class="card-header">
        <button id="btnMostrarCrearPais" class="btn btn-primary">
            Agregar Pais
        </button>
    </div>
    <br/>
    <div class="card-body">
        </button>
        <table id="tablaPaises" name="tablaPaises" class="table table-bordered table-striped dt-responsive"
               width="100%">
            <thead>
            <tr>
                <th style="text-align: center; font-weight: bold;">#</th>
                <th style="text-align: center; font-weight: bold;">Nombre</th>
                <th style="text-align: center; font-weight: bold;">Nacionalidad</th>
                <th style="text-align: center; font-weight: bold;">Estado</th>
                <th style="text-align: center; font-weight: bold;">Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<!--=====================================
VISTA CREAR PAIS
======================================-->
<div id="vistaPaisesAcad" class="card">
    <div class="card-body">
        <table id="tablaPaisesAcad" name="tablaPaisesAcad" class="table table-bordered table-striped dt-responsive"
               width="100%">
            <p align="center">*Seleccione el item que desea guardar</p>
            <thead>
            <tr>
                <th style="width:10px">#</th>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Nacionalidad</th>
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