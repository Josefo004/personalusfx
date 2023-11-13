<?php
use yii\web\JqueryAsset;

app\modules\Planificacion\assets\PlanificacionAsset::register($this);

$this->registerJsFile("@web/js/unidades/unidades.js",[
    'depends' => [
        JqueryAsset::className()
    ]
]);
$this->title = 'Planificacion';
$this->params['breadcrumbs'] = [['label' => 'Unidades']];
?>

<div class="card ">
    <div class="card-header">
        <button id="btnMostrarCrearUnidad" class="btn btn-primary bg-gradient-primary" >
            <div class="icon closed">
                <div class="circle">
                    <div class="horizontal"></div>
                    <div class="vertical"></div>
                </div>
                Agregar Unidad
            </div>
        </button>
    </div>
    <div id="divIngresoDatos" class="card-body" >
        <div class="col d-flex justify-content-center">
            <div class="card " style="width: 80rem;" >
                <div class="card-header bg-gradient-primary">Ingreso Datos</div>
                <div class="card-body">
                    <input type="text" id="codigoUnidad" name="codigoUnidad" disabled hidden >
                    <form id="formUnidad" action="" method="post">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="searchArea">
                                                <button type="button" id="search" class="btn btn-primary btn-sm">Search</button>
                                                <div class="inputDiv">
                                                    <input id="search-term" class="form-control input-sm" placeholder="Buscar" autofocus>
                                                </div>
                                            </div>
                                            <label for="tree1">Seleccione unidad padre</label>
                                            <div id="unidadPadre"> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="tipoUnidad">Seleccione el tipo de unidad</label>
                                            <select class="form-control" id="tipoUnidad" name="tipoUnidad" >
                                                <option value="0" disabled selected>Seleccione el tipo de unidad</option>
                                                <?php foreach ($tiposUnidades as $tipoUnidad){  ?>
                                                    <option value="<?= $tipoUnidad->CodigoTipoUnidad ?>"><?=$tipoUnidad->NombreTipoUnidad?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="nombreUnidad" class="control-label">Nombre Unidad</label>
                                            <input type="text" class="form-control input-sm txt" id="nombreUnidad"
                                                   name="nombreUnidad" placeholder="nombre de unidad">
                                        </div>
                                        <div class="form-group">
                                            <label for="nombreCortoUnidad" class="control-label">Nombre corto</label>
                                            <input type="text" class="form-control input-sm txt" id="nombreCortoUnidad"
                                                   name="nombreCortoUnidad"  placeholder="nombre de unidad">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <button id="btnGuardar" name="btnGuardar" class='btn btn-primary bg-gradient-primary'><i class='fa fa-check-circle-o'>Guardar</i></button>
                    <button id="btnCancelar" name="btnCancelar" class='btn btn-danger'><i class='fa fa-warning'>Cancelar</i></button>
                </div>
            </div>
        </div>
    </div>
    <div id="divTabla" class="card-body">
        <table id="tablaListaUnidades" name="tablaListaUnidades" class="table table-bordered table-striped dt-responsive" style="width: 100%" >
            <thead>
            <th style="text-align: center; vertical-align: middle;">#</th>
            <th style="text-align: center; vertical-align: middle;">Codigo</th>
            <th style="text-align: center; vertical-align: middle;">Nombre</th>
            <th style="text-align: center; vertical-align: middle;">Nombre corto</th>
            <th style="text-align: center; vertical-align: middle;">Tipo</th>
            <th style="text-align: center; vertical-align: middle;">Unidad padre</th>
            <th style="text-align: center; vertical-align: middle;">Estado</th>
            <th style="text-align: center; vertical-align: middle;">Acciones</th>
            </thead>
        </table>
    </div>
</div>