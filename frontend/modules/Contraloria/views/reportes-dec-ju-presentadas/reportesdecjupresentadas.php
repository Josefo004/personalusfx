<?php

use yii\web\JqueryAsset;

app\modules\Contraloria\assets\ContraloriaAsset::register($this);

$this->registerJsFile("@web/js/reportes-dec-ju-presentadas/reportesdecjupresentadas.js", [
    'depends' => [
        JqueryAsset::className()
    ]
]);

$this->title = 'Administración Declaraciones Juradas Presentadas';
$this->params['breadcrumbs'] = [['label' => 'Admin. Declaraciones Juradas Presentadas']];
?>

<form>
    <div class="container">
        <div>
            <a href="http//www.usfx.bo">
                <img src='img/icono.png' width='10%' align='left'>
                <img src='img/logo.png' width='20%' align='right'>
            </a>
            <h4 align='center'>UNVERSIDAD MAYOR Y REAL DE SAN FRANCISCO XAVIER DE CHUQUISACA</h4>
            <h5 align='center'>REPORTES DE DECLARACIONES JURADAS </h5>
        </div>
    </div>
</form>
<br>
<br>
<div id="vistaReportePestañas" class="card col-lg-12">
    <div class="card-header">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="presentadas-tab" data-toggle="tab" href="#presentadas" role="tab"
                   aria-controls="presentadas" aria-selected="false">Presentadas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="fuera-plazo-tab" data-toggle="tab" href="#fuera-plazo" role="tab"
                   aria-controls="fuera-plazo" aria-selected="false">Fuera de Plazo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="sin-presentar-tab" data-toggle="tab" href="#sin-presentar" role="tab"
                   aria-controls="sin-presentar" aria-selected="false">Sin Presentar</a>
            </li>
        </ul>
    </div>
    <div class="tab-content mytab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="presentadas" role="tabpanel" aria-labelledby="presentadas-tab">
            <div class="container" align="center">
                <div class="col-lg-8">
                    <!--<label for="mes" class="control-label">Mes: </label>
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <select id="mes" name="mes" required
                        class="form-control input-lg" style="width: 100%;">
                    <option value="">Seleccionar Mes</option>
                    <?php
                    /*                    foreach ($meses as $codigo => $nombre) {
                                            echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                        }
                                        */ ?>
                </select>-->
                    <br>
                    <div class=" col-lg-4">
                        <label for="gestion" class="control-label">Gestion</label>
                        <input id="gestion" name="gestion" maxlength="120" rows="3"
                               placeholder="Ingresar la Gestion" class="form-control input-lg">
                    </div>
                    <br>
                    <button id="btntrimestre1" name="btntrimestre1" class="btn btn-primary">1er Trimenstre</button>
                    <button id="btntrimestre2" name="btntrimestre2" class="btn btn-primary">2do Trimenstre</button>
                    <button id="btntrimestre3" name="btntrimestre3" class="btn btn-primary">3er Trimenstre</button>
                    <button id="btntrimestre4" name="btntrimestre4" class="btn btn-primary">4to Trimenstre</button>
                    <br>
                    <br>
                </div>
            </div>
            <br>
            <table id="tablaReportes" name="tablaReportes"
                   class="table table-bordered table-striped dt-responsive tabla-reportes"
                   width="100%">
                <thead>
                <tr>
                    <th>Nombre Completo</th>
                    <th>N° CI</th>
                    <th>Cargo</th>
                    <th>Funcion que Cumple</th>
                    <th>Reside Ciudad Capital</th>
                    <th>Fecha de Nacimiento</th>
                    <th>N° Certificado</th>
                    <th>Fecha de Declaracion</th>
                </tr>
                </thead>
                <tbody id="contenidoReportes" name="contenidoReportes">

                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="fuera-plazo" role="tabpanel" aria-labelledby="fuera-plazo-tab">
            <div class="container" align="center">
                <div class="col-lg-8">
                    <!--<label for="mes" class="control-label">Mes: </label>
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <select id="mes" name="mes" required
                        class="form-control input-lg" style="width: 100%;">
                    <option value="">Seleccionar Mes</option>
                    <?php
                    /*                    foreach ($meses as $codigo => $nombre) {
                                            echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                        }
                                        */ ?>
                </select>-->
                    <br>
                    <div class=" col-lg-4">
                        <label for="gestionFueraPlazo" class="control-label">Gestion</label>
                        <input id="gestionFueraPlazo" name="gestionFueraPlazo" maxlength="120" rows="3"
                               placeholder="Ingresar la Gestion" class="form-control input-lg">
                    </div>
                    <br>
                    <button id="btntrimestre1FueraPlazo" name="btntrimestre1FueraPlazo" class="btn btn-primary">1er Trimenstre</button>
                    <button id="btntrimestre2FueraPlazo" name="btntrimestre2FueraPlazo" class="btn btn-primary">2do Trimenstre</button>
                    <button id="btntrimestre3FueraPlazo" name="btntrimestre3FueraPlazo" class="btn btn-primary">3er Trimenstre</button>
                    <button id="btntrimestre4FueraPlazo" name="btntrimestre4FueraPlazo" class="btn btn-primary">4to Trimenstre</button>
                    <br>
                    <br>
                </div>
            </div>
            <br>
            <table id="tablaReportesFueraPlazo" name="tablaReportesFueraPlazo"
                   class="table table-bordered table-striped dt-responsive tabla-reportesFueraPlazo"
                   width="100%">
                <thead>
                <tr>
                    <th>Nombre Completo</th>
                    <th>N° CI</th>
                    <th>Cargo</th>
                    <th>Funcion que Cumple</th>
                    <th>Reside Ciudad Capital</th>
                    <th>Fecha de Nacimiento</th>
                    <th>N° Certificado</th>
                    <th>Fecha de Declaracion</th>
                </tr>
                </thead>
                <tbody id="contenidoReportesFueraPlazo" name="contenidoReportesFueraPlazo">

                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="sin-presentar" role="tabpanel" aria-labelledby="sin-presentar-tab">
            <div class="container" align="center">
                <div class="col-lg-8">
                    <!--<label for="mes" class="control-label">Mes: </label>
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                <select id="mes" name="mes" required
                        class="form-control input-lg" style="width: 100%;">
                    <option value="">Seleccionar Mes</option>
                    <?php
                    /*                    foreach ($meses as $codigo => $nombre) {
                                            echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                        }
                                        */ ?>
                </select>-->
                    <br>
                    <div class=" col-lg-4">
                        <label for="gestion" class="control-label">Gestion</label>
                        <input id="gestion" name="gestion" maxlength="120" rows="3"
                               placeholder="Ingresar la Gestion" class="form-control input-lg">
                    </div>
                    <br>
                    <button id="btntrimestre1" name="btntrimestre1" class="btn btn-primary">1er Trimenstre</button>
                    <button id="btntrimestre2" name="btntrimestre2" class="btn btn-primary">2do Trimenstre</button>
                    <button id="btntrimestre3" name="btntrimestre3" class="btn btn-primary">3er Trimenstre</button>
                    <button id="btntrimestre4" name="btntrimestre4" class="btn btn-primary">4to Trimenstre</button>
                    <br>
                    <br>
                </div>
            </div>
            <br>
            <table id="tablaReportes" name="tablaReportes"
                   class="table table-bordered table-striped dt-responsive tabla-reportes"
                   width="100%">
                <thead>
                <tr>
                    <th>Nombre Completo</th>
                    <th>N° CI</th>
                    <th>Cargo</th>
                    <th>Funcion que Cumple</th>
                    <th>Reside Ciudad Capital</th>
                    <th>Fecha de Nacimiento</th>
                    <th>N° Certificado</th>
                    <th>Fecha de Declaracion</th>
                </tr>
                </thead>
                <tbody id="contenidoReportes" name="contenidoReportes">

                </tbody>
            </table>
        </div>
    </div>
</div>
