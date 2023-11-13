<?php
use common\models\Carrera;
app\modules\CargaHoraria\assests\CargaHorariaAsset::register($this);

$this->registerJsFile("@web/js/contrataciondocente.js",[
    'depends' => [
        \yii\web\JqueryAsset::className()
    ]
]);
$this->title = 'Convocatorias Docentes';
$this->params['breadcrumbs'] = [['label' => 'Convocatorias Doc.']];
//var_dump(\Yii::$app->user->identity->Carreras);
/*foreach(\Yii::$app->user->identity->Carreras as $carrera){
    echo ':' . $carrera["CodigoUsuario"] . ':'.$carrera["CodigoCarrera"]. ':'.$carrera["CodigoSede"]. ':'.$carrera["CodigoFacultad"]. ':'.$carrera["NombreCarrera"]. ':'.$carrera["NombreFacultad"] . ':'.$carrera["NombreSede"]                 .'<br>';
}*/
?>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div  style="vertical-align: middle; width: 50%">
                <button id="btnMostrarCrearConvocatoria" class="btn btn-primary" >
                    Nuevo
                </button>
            </div>
            <div  class="col-sm" style="align-content: left">
                <label for="Filtro" class="control-label">Tipos de convocatorias a mostrar</label>
                <select id="Filtro" name="Filtro" class="form-control input-sm">
                    <option value="V" >Convocatorias Vigentes</option>
                    <option value="C">Convocatorias Caducadas</option>
                    <option value="F">Convocatorias Finalizadas</option>
                </select>
            </div>
        </div>
    </div>

    <div id="IngresoDatos">
        <table class="table table-sm">
            <tbody>
            <tr>
                <th scope="row" style="width: 25%">
                </th>
                <td style="width: 25%">
                    <label for="tipoConvocatoria" class="control-label">Tipo de Convocatoria</label>
                    <select id="tipoConvocatoria" name="tipoConvocatoria"  class="form-control input-sm">
                        <option value="DCO">Tipo convocatoria: Acefalias</option>
                        <option value="DSU">Tipo convocatoria: Suplencias</option>
                    </select>
                    <br>
                    <label for="citeDirector" class="control-label">Nro de Cite</label>
                    <input id="citeDirector" name="citeDirector" type="text" maxlength="150"
                           placeholder="Ingresar numero de cite" required class="form-control input-sm">
                    <br>
                    <label for="Observaciones" class="control-label">Observaciones</label>
                    <textarea id="Observaciones" name="Observaciones" cols="2" maxlength="150"
                              placeholder="Ingresar una observacion" required class="form-control input-sm">

                        </textarea>
                    <br>
                    <input id="accion" type="text" hidden>
                    <input id="codigo" type="text" hidden>
                    <button class='btn btn-info form-control-lg btnGuardar'><i class='fa fa-check-circle-o'>Guardar</i></button>
                    <button class='btn btn-danger  btnCancel'><i class='fa fa-warning'>Cancelar</i></button>
                </td>
                <td style="width: 25%; vertical-align: middle" rowspan="2">
                </td>
            </tr>
            </tbody>
        </table>
    </div>



    <div id="Divtabla" class="card-body">
        <table class="table table-bordered table-striped dt-responsive tablaConvocatorias" width="100%">
            <thead>
            <tr>
                <th style="text-align: center; font-weight: bold;">#</th>
                <th style="text-align: center; font-weight: bold;">Gestion Academica</th>
                <th style="text-align: center; font-weight: bold;">Tipo Convocatoria</th>
                <th style="text-align: center; font-weight: bold;">Nro Cite</th>
                <th style="text-align: center; font-weight: bold;">Observaciones</th>
                <th style="text-align: center; font-weight: bold;">Estado</th>
                <th style="text-align: center; font-weight: bold;">Acciones</th>
            </tr>
            </thead>
        </table>
    </div>





