<?php

use yii\web\JqueryAsset;

app\modules\Contraloria\assets\ContraloriaAsset::register($this);

$this->registerJsFile("@web/js/reportes-declaraciones-juradas/reportesdeclaracionesjuradas.js", [
    'depends' => [
        JqueryAsset::className()
    ]
]);

$this->title = 'Administración Tipos Declaraciones Juradas';
$this->params['breadcrumbs'] = [['label' => 'Admin. Tipos Declaraciones Juradas']];
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
<div class="container" align="center">
    <div class="col-lg-4">
        <label for="mes" class="control-label">Mes: </label>
        <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
        <select id="mes" name="mes" required
                class="form-control input-lg" style="width: 100%;">
            <option value="">Seleccionar Mes</option>
            <?php
            foreach ($meses as $codigo => $nombre) {
                echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
            }
            ?>
        </select>
        <br>
        <label for="gestion" class="control-label">Gestion</label>
        <input id="gestion" name="gestion" maxlength="120" rows="3"
               placeholder="Ingresar la Gestion" class="form-control input-lg">
        <br>
        <button id="btnProcesarVista" name="btnProcesarVista" class="btn btn-primary">Procesar</button>
        <button id="btnPdf" name="btnPdf" class="btn btn-primary">Exportar PDF</button>
    </div>
</div>
<br>
<table id="tablaReportes" name="tablaReportes" class="table table-bordered table-striped dt-responsive tabla-reportes"
       width="100%">
    <thead>
    <tr>
        <th>Nombre Completo</th>
        <th>Id Persona</th>
        <th>Fecha de Nacimiento</th>
        <th>Celular</th>
        <th>Fecha Recordatorio</th>
        <th>Fecha Fin Recordatorio</th>
    </tr>
    </thead>
    <tbody id="contenidoReportes" name="contenidoReportes">

    </tbody>
</table>