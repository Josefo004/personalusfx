<?php

use yii\web\JqueryAsset;

app\modules\Filiacion\assets\FiliacionAsset::register($this);

$this->registerJsFile("@web/js/personas/personas.js", [
    'depends' => [
        JqueryAsset::className()
    ]
]);

$this->title = 'Filiacion Personas';
$this->params['breadcrumbs'] = [['label' => 'Filiacion Personas']];
?>
<!--=====================================
VISTA CREAR PERSONA
======================================-->
<div id="vistaPersonas" class="card">
    <div class="card-header">
        <button id="btnMostrarSeleccionarPersona" name="btnMostrarSeleccionarPersona" class="btn btn-primary">
            Agregar Persona
        </button>
    </div>
    <br/>
    <div class="card-body">
        <table id="tablaPersonas" class="table table-bordered table-striped dt-responsive tablaPersonas" width="100%">
            <thead>
            <tr>
                <th style="width:10px">#</th>
                <th>C.I.</th>
                <th>Nombre Completo</th>
                <th>Sexo</th>
                <th>Fecha Nacimiento</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
        </table>
        <br>
    </div>
</div>

<div id="vistaCrearPersonaPestañas" class="card">
    <div class="card-header">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="identificacion-tab" data-toggle="tab" href="#identificacion" role="tab"
                   aria-controls="identificacion"
                   aria-selected="true"></a>
            </li>
            <!--<li class="nav-item">
                <a class="nav-link" id="datos-personales-tab" data-toggle="tab" href="#datos-personales" role="tab"
                   aria-controls="datos-personales"
                   aria-selected="false">Datos Personales</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="datos-civiles-tab" data-toggle="tab" href="#datos-civiles" role="tab"
                   aria-controls="datos-civiles" aria-selected="false">Datos Civiles</a>
            </li>-->
        </ul>
    </div>
    <div class="tab-content mytab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="identificacion" role="tabpanel" aria-labelledby="identificacion-tab">
            <div class="col d-flex justify-content-center">
                <div class="card " style="width: 80rem;">
                    <div class="card-header bg-gradient-primary">Registro de Datos</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-4 ml-auto" align="center">
                                <label for="idPersonaNew" class="control-label">C.I.</label>
                                <input style="width : 400px; text-align: center" id="idPersonaNew"
                                       name="idPersonaNew" type="text" maxlength="150"
                                       class="form-control input-lg">
                                <input style="width : 400px; text-align: center" id="numeroDocumentoNew"
                                       name="numeroDocumentoNew" type="text" maxlength="150"
                                       class="form-control input-lg" hidden>
                            </div>
                            <div class="form-group col-md-4 ml-auto" align="center">
                                <label for="lugarExpedicionNew" class="control-label">Lugar Expedicion</label>
                                <input id="idPersonaNew" name="idPersonaNew" type="hidden" maxlength="150" hidden
                                       class="form-control input-lg">
                                <input style="width : 400px; text-align: center" id="lugarExpedicionNew"
                                       name="lugarExpedicionNew" type="text" maxlength="150"
                                       class="form-control input-lg">
                            </div>
                            <div class="form-group col-md-4 ml-auto" align="center">
                                <label for="tipoDocumentoNew" class="control-label">Tipo de Documento</label>
                                <br>
                                <select id="tipoDocumentoNew" name="tipoDocumentoNew" required
                                        class="form-control input-lg" style="width : 400px;">
                                    <option value="">Selecionar Documento</option>
                                    <?php
                                    foreach ($tiposDocumentos as $codigo => $nombre) {
                                        echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="form-group col-md-6 ml-auto" align="center">
                            <!--<label for="ciAnverso">CI Anverso</label>
                            <form method="post" action="#" enctype="multipart/form-data"
                                  class="form-group entrada-datos5">
                                <div class="card" style="width: 10rem;">
                                    <img id="imgAnverso" class="card-img-top" src="img/memo.jpg">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <input type="file" class="form-control-file" name="ciAnverso"
                                                   id="ciAnverso">
                                        </div>
                                        <input type="button" class="btn btn-primary uploadAnverso"
                                               id="uploadAnverso"
                                               value="Visualizar">
                                    </div>
                                </div>
                            </form>-->
                            <label for="apellidoPaternoNew" class="control-label">Apellido Paterno</label>
                            <input style="width : 400px; text-align: center" id="apellidoPaternoNew"
                                   name="apellidoPaternoNew" type="text" maxlength="150"
                                   placeholder="Ingresar apellido paterno de la persona" required
                                   class="form-control input-lg">
                        </div>
                        <div class="form-group col-md-6 ml-auto" align="center">
                            <!--<label for="imagenReverso">CI Reverso</label>
                            <form method="post" action="#" enctype="multipart/form-data"
                                  class="form-group entrada-datos5">
                                <div class="card" style="width: 10rem;">
                                    <img id="imgReverso" class="card-img-top" src="img/memo.jpg">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <input type="file" class="form-control-file" name="imagenReverso"
                                                   id="imagenReverso">
                                        </div>
                                        <input type="button" class="btn btn-primary uploadReverso"
                                               id="uploadReverso"
                                               value="Visualizar">
                                    </div>
                                </div>
                            </form>-->
                            <label for="apellidoMaternoNew" class="control-label">Apellido Materno</label>
                            <input style="width : 400px; text-align: center" id="apellidoMaternoNew"
                                   name="apellidoMaternoNew" type="text" maxlength="150"
                                   placeholder="Ingresar apellido materno de la persona" required
                                   class="form-control input-lg">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4 ml-auto" align="center">
                            <label for="primerNombreNew" class="control-label">Primer Nombre</label>
                            <input style="width : 400px; text-align: center"
                                   id="idPersonaNew" name="idPersonaNew" type="hidden" maxlength="150" hidden
                                   class="form-control input-lg">
                            <input style="width : 400px; text-align: center" id="primerNombreNew"
                                   name="primerNombreNew" type="text" maxlength="150"
                                   placeholder="Ingresar primer nombre de la persona" required
                                   class="form-control input-lg">
                        </div>
                        <div class="form-group col-md-4 ml-auto" align="center">
                            <label for="segundoNombresNew" class="control-label">Segundo Nombre</label>
                            <input style="width : 400px; text-align: center" id="idPersonaNew"
                                   name="idPersonaNew" type="hidden" maxlength="150" hidden
                                   class="form-control input-lg">
                            <input style="width : 400px; text-align: center" id="segundoNombresNew"
                                   name="segundoNombresNew" type="text" maxlength="150"
                                   placeholder="Ingresar segundo nombre de la persona" required
                                   class="form-control input-lg">
                        </div>
                        <div class="form-group col-md-4 ml-auto" align="center">
                            <label for="tercerNombreNew" class="control-label">Tercer Nombre</label>
                            <input style="width : 400px; text-align: center" id="idPersonaNew"
                                   name="idPersonaNew" type="hidden" maxlength="150" hidden
                                   class="form-control input-lg">
                            <input style="width : 400px; text-align: center" id="tercerNombreNew"
                                   name="tercerNombreNew" type="text" maxlength="150"
                                   placeholder="Ingresar tercer nombre de la persona" required
                                   class="form-control input-lg">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4 ml-auto" align="center">
                            <label for="fechaNacimientoNew" class="control-label">Fecha de Nacimiento</label>
                            <input style="width : 400px; text-align: center" id="fechaNacimientoNew"
                                   name="fechaNacimientoNew" type="text" maxlength="150"
                                   class="form-control input-lg">
                        </div>
                        <div class="form-group col-md-4 ml-auto" align="center">
                            <label for="sexoNew">Sexo</label>
                            <select style="width : 400px; text-align: center" id="sexoNew"
                                    name="sexoNew" required
                                    class="form-control input-lg">
                                <option value="">Selecionar Sexo</option>
                                <option value="F">FEMENINO</option>
                                <option value="M">MASCULINO</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 ml-auto" align="center">
                            <label for="codigoEstadoCivilNew" class="control-label">Estado Civil</label>
                            <br>
                            <select style="width : 400px; text-align: center" id="codigoEstadoCivilNew"
                                    name="codigoEstadoCivilNew" required
                                    class="form-control input-lg codigoEstadoCivilNew" style="width: 100%;">
                                <option value="">Selecionar Estado Civil</option>
                                <?php
                                foreach ($estadosCiviles as $codigo => $nombre) {
                                    echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 ml-auto" align="center">
                            <label for="domicilioNew" class="control-label">Domicilio</label>
                            <input style="width : 400px; text-align: center" id="domicilioNew"
                                   name="domicilioNew" type="text" maxlength="150"
                                   placeholder="Ingresar domicilio" required
                                   class="form-control input-lg">
                        </div>
                        <div class="form-group col-md-6 ml-auto" align="center">
                            <label for="libretaServicioMilitarNew" class="control-label">Libreta de Servicio Militar</label>
                            <input style="width : 400px; text-align: center" id="libretaServicioMilitarNew"
                                   name="libretaServicioMilitarNew" type="text" maxlength="150"
                                   placeholder="Ingresar libreta de servicio militar" required
                                   class="form-control input-lg">
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" id="btnCrearPersonaDatos" class='btn btn-primary bg-gradient-primary'>
                            <i class='fa fa-check-circle-o'>Guardar</i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="tab-pane fade" id="datos-personales" role="tabpanel" aria-labelledby="datos-personales-tab">
        <div class="col d-flex justify-content-center">
            <div class="card " style="width: 80rem;">
                <div class="card-header bg-gradient-primary">Ingreso Datos</div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4 ml-auto" align="center">
                            <label for="paternoNew" class="control-label">Paterno</label>
                            <input style="width : 400px; text-align: center" id="paternoNew" name="paternoNew"
                                   type="text"
                                   maxlength="150"
                                   class="form-control input-lg">
                        </div>
                        <div class="form-group col-md-4 ml-auto" align="center">
                            <label for="maternoNew" class="control-label">Materno</label>
                            <input style="width : 400px; text-align: center" id="maternoNew" name="maternoNew"
                                   type="text"
                                   maxlength="150"
                                   class="form-control input-lg">
                        </div>
                        <div class="form-group col-md-4 ml-auto" align="center">
                            <label for="nombresNew" class="control-label">Nombres</label>
                            <input style="width : 400px; text-align: center" id="nombresNew" name="nombresNew"
                                   type="text"
                                   maxlength="150"
                                   class="form-control input-lg">
                        </div>
                    </div>
                    <div class="row">

                        <div class="form-group col-md-3 ml-auto" align="center">
                            <label for="fechaNacimientoNew" class="control-label">Fecha de Nacimiento</label>
                            <input style="width : 100%; text-align: center" id="fechaNacimientoNew"
                                   name="fechaNacimientoNew"
                                   type="text" maxlength="150"
                                   class="form-control input-lg">
                        </div>
                        <div class="form-group col-md-3 ml-auto" align="center">
                            <label for="sexoNew">Sexo</label>
                            <select style="width : 100%; text-align: center" id="sexoNew" name="sexoNew" required
                                    class="form-control input-lg">
                                <option value="">Selecionar Sexo</option>
                                <option value="F">FEMENINO</option>
                                <option value="M">MASCULINO</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3 ml-auto" align="center">
                            <label for="discapacidadNew">Discapacidad</label>
                            <select style="width : 100%; text-align: center" id="discapacidadNew"
                                    name="discapacidadNew"
                                    required
                                    class="form-control input-lg">
                                <option value="">¿Presenta discapacidad?</option>
                                <option value="S">SI</option>
                                <option value="N">NO</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3 ml-auto" align="center">
                            <label for="cantidadDependientesDescapacidadNew" class="control-label">Cantida de
                                Dependientes
                                Discapacitados</label>
                            <input style="width : 100%; text-align: center"
                                   id="cantidadDependientesDescapacidadNew"
                                   name="cantidadDependientesDescapacidadNew" type="text"
                                   maxlength="150"
                                   class="form-control input-lg">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3 ml-auto" align="center">
                            <label for="codigoPaisNew" class="control-label">Pais de Nacimiento</label>
                            <br>
                            <input style="width : 400px; text-align: center" id="idPersonaDatosNew"
                                   name="idPersonaNew"
                                   type="text"
                                   maxlength="150"
                                   class="form-control input-lg" hidden>-->
    <!--<select style="width : 100%; text-align: center" id="codigoPaisNew"
                                name="codigoPaisNew"
                                required
                                class="form-control input-lg codigoPais select2" style="width: 100%;"
                                nuevo="si">
                            <option value="">Selecionar Pais</option>
                            <?php
    /*                            foreach ($paises as $codigo => $nombre) {
                                    echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                }
                                */ ?>
                        </select>-->
    <!--</div>
    <div class="form-group col-md-3 ml-auto" align="center">
        <label for="codigoDepartamentoNew">Departamento de Nacimiento</label>
        <br>
        <select style="width : 100%; text-align: center" id="codigoDepartamentoNew"
                name="codigoDepartamentoNew" required
                class="form-control input-lg codigoDepartamento select2" style="width: 100%;"
                nuevo="si"
                disabled>
            <option value="">Selecionar Departamento</option>
        </select>
    </div>
    <div class="form-group col-md-3 ml-auto" align="center">
        <label for="codigoProvinciaNew">Provincia de Nacimiento</label>
        <br>
        <select style="width : 100%; text-align: center" id="codigoProvinciaNew"
                name="codigoProvinciaNew"
                required
                class="form-control input-lg codigoProvincia select2" style="width: 100%;"
                nuevo="si"
                disabled>
            <option value="">Selecionar Provincia</option>
        </select>
    </div>
    <div class="form-group col-md-3 ml-auto" align="center">
        <label for="codigoLugarNacimientoNew">Lugar de Nacimiento</label>
        <br>
        <select style="width : 100%; text-align: center" id="codigoLugarNacimientoNew"
                name="codigoLugarNacimientoNew" required
                class="form-control input-lg codigoLugar select2" style="width: 100%;"
                nuevo="si"
                disabled>
            <option value="">Selecionar Lugar</option>
        </select>
    </div>
</div>
<div class="row entrada-datos" align="center">
    <div class="form-group col-md-11 ml-auto">
        <label for="imagenCertificadoNacimiento" class="control-label">Certificado de
            Nacimiento</label>
        <form method="post" action="#" enctype="multipart/form-data"
              class="form-group entrada-datos">
            <div class="card" style="width: 10rem;">
                <img id="imgCertificadoNacimiento" class="card-img-top" src="img/memo.jpg">
                <div class="card-body">
                    <div class="form-group">
                        <input type="file" class="form-control-file"
                               name="imagenCertificadoNacimiento"
                               id="imagenCertificadoNacimiento">
                    </div>
                    <input type="button" class="btn btn-primary uploadCertificadoNacimiento"
                           id="uploadCertificadoNacimiento"
                           value="Visualizar">
                </div>
            </div>
        </form>
    </div>
</div>
</div>
</div>
</div>
<!-- content here -->
    <!-- </div>-->
    <!--<div class="tab-pane fade" id="datos-civiles" role="tabpanel" aria-labelledby="datos-civiles-tab">
        <div class="col d-flex justify-content-center">
            <div class="card " style="width: 80rem;">
                <div class="card-header bg-gradient-primary">Ingreso Datos</div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6 ml-auto" align="center">
                            <label for="codigoEstadoCivilNew" class="control-label">Estado Civil</label>
                            <br>-->
    <!--<select style="width : 100%; text-align: center" id="codigoEstadoCivilNew"
                                name="codigoEstadoCivilNew" required
                                class="form-control input-lg codigoEstadoCivilNew select2" style="width: 100%;"
                                nuevo="si">
                            <option value="">Selecionar Estado Civil</option>
                            <?php
    /*                            foreach ($estadosCiviles as $codigo => $nombre) {
                                    echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                }
                                */ ?>
                        </select>-->
    <!--</div>
    <div class="form-group col-md-6 ml-auto" align="center">
        <label for="apellidoEsposoNew" class="control-label">Apellido de Esposo</label>
        <input style="width : 100% text-align: center" id="apellidoEsposoNew"
               name="apellidoEsposoNew"
               type="text" maxlength="150"
               class="form-control input-lg">
    </div>
</div>
<div class="row">
    <div class="form-group col-md-4 ml-auto" align="center">
        <label for="direccionNew" class="control-label">Dirección</label>
        <input style="width : 100%; text-align: center" id="direccionNew" name="direccionNew"
               type="text"
               maxlength="150"
               class="form-control input-lg">
    </div>
    <div class="form-group col-md-4 ml-auto" align="center">
        <label for="telefonoNew" class="control-label">Telefono</label>
        <input style="width : 100%; text-align: center" id="telefonoNew" name="telefonoNew"
               type="text"
               maxlength="150"
               class="form-control input-lg">
    </div>
    <div class="form-group col-md-4 ml-auto" align="center">
        <label for="celularNew" class="control-label">Celular</label>
        <input style="width : 100%; text-align: center" id="celularNew" name="celularNew"
               type="text"
               maxlength="150"
               class="form-control input-lg">
    </div>
</div>
</div>
<div class="row entrada-datos" align="center">
<div class="form-group col-md-11 ml-auto">
    <label for="imgagenEstadoCivil" class="control-label">Certificado de Estado
        Civil</label>
    <form method="post" action="#" enctype="multipart/form-data"
          class="form-group entrada-datos">
        <div class="card" style="width: 10rem;">
            <img id="imgEstadoCivil" class="card-img-top" src="img/memo.jpg">
            <div class="card-body">
                <div class="form-group">
                    <input type="file" class="form-control-file" name="imagenEstadoCivil"
                           id="imagenEstadoCivil">
                </div>
                <input type="button" class="btn btn-primary upload" id="uploadEstadoCivil"
                       value="Visualizar">
            </div>
        </div>
    </form>
</div>
</div>
<br>
<div class="card-footer text-center">
<button type="submit" id="btnCrearPersonaDatos" class='btn btn-primary bg-gradient-primary'>
    <i class='fa fa-check-circle-o'>Guardar</i></button>
</div>
</div>
</div>
</div>-->
</div>
</div>


<!--=====================================
VISTA SELECCIONAR PERSONA DECLARACIONES JURADAS
======================================-->
<div id="vistaPersonasDeclaracionJurada" class="card">
    <div class="card-body">
        <table id="tablaPersonasDeclaracionJurada" name="tablaPersonasDeclaracionJurada"
               class="table table-bordered table-striped dt-responsive"
               width="100%">
            <p align="center">*Seleccione el item que desea guardar</p>
            <thead>
            <tr>
                <th style="width:10px">#</th>
                <th>Id Persona</th>
                <th>Emision</th>
                <th>Nombre Completo</th>
                <th>Fecha de Nacimiento</th>
                <th>Acciones</th>
            </tr>
            </thead>
        </table>
        <div align="center">
            <button id="btnCrearNuevaPersona" class="btn btn-primary">
                Nueva Persona
            </button>
            <button id="btnCancelar" class="btn btn-danger">
                Salir
            </button>
        </div>
    </div>
</div>

<!--=====================================
VISTA ACTUALIZAR PERSONA
======================================-->
<!--<div id="vistaActuaizarPersonaPestañas" class="card">
    <div class="card-header">
        <ul class="nav nav-tabs" id="myTabUpd" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="datos-upd-tab" data-toggle="tab" href="#datosUpd" role="tab"
                   aria-controls="datosUpd"
                   aria-selected="true">Identificacion Personal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="identificacion-upd-tab" data-toggle="tab" href="#identificacionUpd" role="tab"
                   aria-controls="identificacionUpd"
                   aria-selected="false">Datos Personales</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="datos-civiles-upd-tab" data-toggle="tab" href="#datos-civilesUpd"
                   role="tab"
                   aria-controls="datos-civilesUpd" aria-selected="false">Datos Civiles</a>
            </li>
        </ul>
    </div>
    <div class="tab-content mytab-content-upd" id="myTabContentUpd">
        <div class="tab-pane fade show active" id="datosUpd" role="tabpanel" aria-labelledby="datos-upd-tab">
            <div class="col d-flex justify-content-center">
                <div class="card " style="width: 30rem;">
                    <div class="card-header bg-gradient-primary">Ingreso Datos</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="idPersonaUpd" class="control-label">C.I.</label>
                            <input style="width : 400px; text-align: center" id="idPersonaUpd" name="idPersonaUpd"
                                   type="text"
                                   maxlength="150"
                                   class="form-control input-lg">
                        </div>
                        <div class="form-group">
                            <label for="codigoLugarEmisionUpd" class="control-label">Lugar de Emision</label>
                            <br>
                            <select style="width : 400px; text-align: center" id="codigoLugarEmisionUpd"
                                    name="codigoLugarEmisionUpd" required
                                    class="form-control input-lg" style="width: 100%;">
                                <option value="">Selecionar Emision</option>
                                <?php
/*                                foreach ($lugaresEmision as $codigo => $nombre) {
                                    echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                }
                                */ ?>
                            </select>
                        </div>
                    </div>
                    <div class="row entrada-datos" hidden>
                        <div class="form-group col-md-6 ml-auto">
                            <label for="imagenAnverso" class="control-label">Anverso</label>
                            <form method="post" action="#" enctype="multipart/form-data"
                                  class="form-group entrada-datos">
                                <div class="card" style="width: 10rem;">
                                    <img id="imgAnverso" class="card-img-top" src="img/memo.jpg">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="imagenAnverso">Subir Imagen</label>
                                            <input type="file" class="form-control-file" name="imagenAnverso"
                                                   id="imagenAnverso">
                                        </div>
                                        <input type="button" class="btn btn-primary upload" id="uploadAnverso"
                                               value="Visualizar">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="form-group col-md-6 ml-auto">
                            <label for="imagenReverso" class="control-label">Reverso</label>
                            <form method="post" action="#" enctype="multipart/form-data"
                                  class="form-group entrada-datos">
                                <div class="card" style="width: 10rem;">
                                    <img id="imgReverso" class="card-img-top" src="img/memo.jpg">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="imagenReverso">Subir Imagen</label>
                                            <input type="file" class="form-control-file" name="imagenReverso"
                                                   id="imagenReverso">
                                        </div>
                                        <input type="button" class="btn btn-primary upload" id="uploadReverso"
                                               value="Visualizar">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="identificacionUpd" role="tabpanel" aria-labelledby="identificacion-upd-tab">
            <div class="col d-flex justify-content-center">
                <div class="card " style="width: 30rem;">
                    <div class="card-header bg-gradient-primary">Ingreso Datos</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="paternoUpd" class="control-label">Paterno</label>
                            <input style="width : 300px; text-align: center" id="paternoUpd" name="paternoUpd"
                                   type="text"
                                   maxlength="150"
                                   class="form-control input-lg">
                        </div>
                        <div class="form-group">
                            <label for="maternoUpd" class="control-label">Materno</label>
                            <input style="width : 300px; text-align: center" id="maternoUpd" name="maternoUpd"
                                   type="text"
                                   maxlength="150"
                                   class="form-control input-lg">
                        </div>
                        <div class="form-group">
                            <label for="nombresUpd" class="control-label">Nombres</label>
                            <input style="width : 300px; text-align: center" id="nombresUpd" name="nombresUpd"
                                   type="text"
                                   maxlength="150"
                                   class="form-control input-lg">
                        </div>
                        <div class="form-group">
                            <label for="fechaNacimientoUpd" class="control-label">Fecha de Nacimiento</label>
                            <input style="width : 300px; text-align: center" id="fechaNacimientoUpd"
                                   name="fechaNacimientoUpd"
                                   type="text" maxlength="150"
                                   class="form-control input-lg">
                        </div>
                        <div class="form-group">
                            <label for="sexoUpd">Sexo</label>
                            <select style="width : 300px; text-align: center" id="sexoUpd" name="sexoUpd" required
                                    class="form-control input-lg">
                                <option value="">Seleccionar Sexo</option>
                                <option value="F">FEMENINO</option>
                                <option value="M">MASCULINO</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="discapacidadUpd">Discapacidad</label>
                            <select style="width : 300px; text-align: center" id="discapacidadUpd"
                                    name="discapacidadUpd"
                                    required
                                    class="form-control input-lg">
                                <option value="">¿Presenta discapacidad?</option>
                                <option value="S">SI</option>
                                <option value="N">NO</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cantidadDependientesDiscapacidadUpd" class="control-label">Cantida de
                                Dependientes
                                Discapacitados</label>
                            <input style="width : 300px; text-align: center" id="cantidadDependientesDiscapacidadUpd"
                                   name="cantidadDependientesDiscapacidadUpd" type="text"
                                   maxlength="150"
                                   class="form-control input-lg">
                        </div>

                        <div class="form-group">
                            <input style="width : 400px; text-align: center" id="idPersonaDatosUpd" name="idPersonaDatosUpd"
                                   type="text"
                                   maxlength="150"
                                   class="form-control input-lg" hidden>
                            <label for="codigoPaisUpd" class="control-label">Pais de Nacimiento</label>
                            <br>
                            <select style="width : 300px; text-align: center" id="codigoPaisUpd" name="codigoPaisUpd"
                                    required
                                    class="form-control input-lg codigoPais select2" style="width: 100%;" nuevo="si">
                                <option value="">Selecionar Pais</option>
                                <?php
/*                                foreach ($paises as $codigo => $nombre) {
                                    echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                }
                                */ ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="codigoDepartamentoUpd">Departamento de Nacimiento</label>
                            <br>
                            <select style="width : 300px; text-align: center" id="codigoDepartamentoUpd"
                                    name="codigoDepartamentoUpd" required
                                    class="form-control input-lg codigoDepartamento select2" style="width: 100%;"
                                    nuevo="si"
                                    disabled>
                                <option value="">Selecionar Departamento</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="codigoProvinciaUpd">Provincia de Nacimiento</label>
                            <br>
                            <select style="width : 300px; text-align: center" id="codigoProvinciaUpd"
                                    name="codigoProvinciaUpd"
                                    required
                                    class="form-control input-lg codigoProvincia select2" style="width: 100%;"
                                    nuevo="si"
                                    disabled>
                                <option value="">Selecionar Provincia</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="codigoLugarNacimientoUpd">Lugar de Nacimiento</label>
                            <br>
                            <select style="width : 300px; text-align: center" id="codigoLugarNacimientoUpd"
                                    name="codigoLugarNacimientoUpd" required
                                    class="form-control input-lg codigoLugar select2" style="width: 100%;" nuevo="si"
                                    disabled>
                                <option value="">Selecionar Lugar</option>
                            </select>
                        </div>

                        <div class="row entrada-datos" hidden>
                            <div class="form-group col-md-11 ml-auto">
                                <label for="imagenCertificadoNacimiento" class="control-label">Certificado de
                                    Nacimiento</label>
                                <form method="post" action="#" enctype="multipart/form-data"
                                      class="form-group entrada-datos">
                                    <div class="card" style="width: 10rem;">
                                        <img id="imgCertificadoNacimiento" class="card-img-top" src="img/memo.jpg">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="imagenCertificadoNacimiento">Subir Imagen</label>
                                                <input type="file" class="form-control-file" name="imagenNew"
                                                       id="imagenCertificadoNacimiento">
                                            </div>
                                            <input type="button" class="btn btn-primary upload"
                                                   id="uploadCertificadoNacimiento"
                                                   value="Visualizar">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="datos-civilesUpd" role="tabpanel" aria-labelledby="datos-civiles-upd-tab">
            <div class="col d-flex justify-content-center">
                <div class="card " style="width: 30rem;">
                    <div class="card-header bg-gradient-primary">Ingreso Datos</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="codigoEstadoCivilUpd" class="control-label">Estado Civil</label>
                            <br>
                            <select style="width : 300px; text-align: center" id="codigoEstadoCivilUpd"
                                    name="codigoEstadoCivilUpd" required
                                    class="form-control input-lg codigoEstadoCivilUpd" style="width: 100%;"
                                    nuevo="si">
                                <option value="">Selecionar Estado Civil</option>
                                <?php
/*                                foreach ($estadosCiviles as $codigo => $nombre) {
                                    echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                }
                                */ ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="apellidoEsposoUpd" class="control-label">Apellido de Esposo</label>
                            <input style="width : 300px; text-align: center" id="apellidoEsposoUpd"
                                   name="apellidoEsposoUpd"
                                   type="text" maxlength="150"
                                   class="form-control input-lg">
                        </div>
                        <div class="form-group">
                            <label for="direccionUpd" class="control-label">Dirección</label>
                            <input style="width : 300px; text-align: center" id="direccionUpd" name="direccionUpd"
                                   type="text"
                                   maxlength="150"
                                   class="form-control input-lg">
                        </div>
                        <div class="form-group">
                            <label for="telefonoUpd" class="control-label">Telefono</label>
                            <input style="width : 300px; text-align: center" id="telefonoUpd" name="telefonoUpd"
                                   type="text"
                                   maxlength="150"
                                   class="form-control input-lg">
                        </div>
                        <div class="form-group">
                            <label for="celularNew" class="control-label">Celular</label>
                            <input style="width : 300px; text-align: center" id="celularUpd" name="celularUpd"
                                   type="text"
                                   maxlength="150"
                                   class="form-control input-lg">
                        </div>
                    </div>
                    <div class="row entrada-datos" hidden>
                        <div class="form-group col-md-11 ml-auto">
                            <label for="imgagenEstadoCivil" class="control-label">Certificado de Estado Civil</label>
                            <form method="post" action="#" enctype="multipart/form-data"
                                  class="form-group entrada-datos">
                                <div class="card" style="width: 10rem;">
                                    <img id="imgEstadoCivil" class="card-img-top" src="img/memo.jpg">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="imagenEstadoCivil">Subir Imagen</label>
                                            <input type="file" class="form-control-file" name="imagenEstadoCivil"
                                                   id="imagenEstadoCivil">
                                        </div>
                                        <input type="button" class="btn btn-primary upload" id="uploadEstadoCivil"
                                               value="Visualizar">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <br>
                    <div class="card-footer text-center">
                        <button type="submit" id="btnActualizarPersonaDatos" class='btn btn-primary bg-gradient-primary'>
                            <i class='fa fa-check-circle-o'>Guardar</i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->
</div>
<!--=====================================
MODAL ACTUALIZAR PERSONA
======================================-->
<div id="modalActualizarPersona" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">Editar Persona</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            CUERPO DEL MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--=====================================
                     DATOS DE PERSONA MODIFICADO
                     ======================================-->
                    <div class="form-group entrada-datos">
                        <label for="idPersonaUpd" class="control-label">Identificacion</label>
                        <input id="idPersonaUpd" name="idPersonaUpd" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg">
                        <!--<input id="idPersonaDatosUpd" name="idPersonaUpd" type="text" maxlength="150"
                               readonly="true" class="form-control input-lg" hidden>-->
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="lugarExpedicionUpd" class="control-label">Lugar Expedicion</label>
                        <input id="idPersonaUpd" name="idPersonaUpd" type="hidden" maxlength="150" hidden
                               class="form-control input-lg">
                        <input id="lugarExpedicionUpd" name="lugarExpedicionUpd" type="text" maxlength="150"
                               placeholder="Ingresa lugar de expedicion" required class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="tipoDocumentoUpd" class="control-label">Tipo de Documento</label>
                        <br>
                        <select id="tipoDocumentoUpd" name="tipoDocumentoUpd" required
                                class="form-control input-lg" style="width: 100%;">
                            <option value="">Selecionar Documento</option>
                            <?php
                            foreach ($tiposDocumentos as $codigo => $nombre) {
                                echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="primerNombreUpd" class="control-label">Primer Nombre</label>
                        <input id="idPersonaUpd" name="idPersonaUpd" type="hidden" maxlength="150" hidden
                               class="form-control input-lg">
                        <input id="primerNombreUpd" name="primerNombreUpd" type="text" maxlength="150"
                               placeholder="Ingresar primer nombre de la persona" required
                               class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="segundoNombresUpd" class="control-label">Segundo Nombre</label>
                        <input id="idPersonaUpd" name="idPersonaUpd" type="hidden" maxlength="150" hidden
                               class="form-control input-lg">
                        <input id="segundoNombresUpd" name="segundoNombresUpd" type="text" maxlength="150"
                               placeholder="Ingresar segundo nombre de la persona" required
                               class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="tercerNombreUpd" class="control-label">Tercer Nombre</label>
                        <input id="idPersonaUpd" name="idPersonaUpd" type="hidden" maxlength="150" hidden
                               class="form-control input-lg">
                        <input id="tercerNombreUpd" name="tercerNombreUpd" type="text" maxlength="150"
                               placeholder="Ingresar tercer nombre de la persona" required
                               class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="apellidoPaternoUpd" class="control-label">Apellido Paterno</label>
                        <input id="apellidoPaternoUpd" name="apellidoPaternoUpd" type="text" maxlength="150"
                               placeholder="Ingresar apellido paterno de la persona" required
                               class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="apellidoMaternoUpd" class="control-label">Apellido Materno</label>
                        <input id="apellidoMaternoUpd" name="apellidoMaternoUpd" type="text" maxlength="150"
                               placeholder="Ingresar apellido materno de la persona" required
                               class="form-control input-lg">
                    </div>
                    <div class="form-group entrada-datos">
                        <label for="fechaNacimientoUpd" class="control-label">Fecha de Nacimiento</label>
                        <input id="fechaNacimientoUpd" name="fechaNacimientoUpd" type="text" maxlength="150"
                               class="form-control input-lg">
                    </div>
                    <div class="form-group">
                        <label for="sexoUpd">Sexo</label>
                        <select id="sexoUpd" name="sexoUpd" required
                                class="form-control input-lg">
                            <option value="">Selecionar Sexo</option>
                            <option value="F">FEMENINO</option>
                            <option value="M">MASCULINO</option>
                        </select>
                    </div>
                    <!--<div class="form-group">
                        <label for="codigoPaisUpd">Pais de Nacimiento</label>
                        <select id="codigoPaisUpd" name="codigoPaisUpd" required
                                class="form-control input-lg codigoPais select2" style="width: 100%;" nuevo="no">
                            <option value="">Selecionar Pais</option>
                            <?php
                    /*                            foreach ($paises as $codigo => $nombre) {
                                                    echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                                                }
                                                */ ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="codigoDepartamentoUpd">Departamento de Nacimiento</label>
                        <select id="codigoDepartamentoUpd" name="codigoDepartamentoUpd" required
                                class="form-control input-lg codigoDepartamento select2" style="width: 100%;"
                                nuevo="no">
                            <option value="">Selecionar Departamento</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="codigoProvinciaUpd">Provincia de Nacimiento</label>
                        <select id="codigoProvinciaUpd" name="codigoProvinciaUpd" required
                                class="form-control input-lg codigoProvincia select2" style="width: 100%;" nuevo="no">
                            <option value="">Selecionar Provincia</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="codigoLugarNacimientoUpd">Lugar de Nacimiento</label>
                        <select id="codigoLugarNacimientoUpd" name="codigoLugarNacimientoUpd" required
                                class="form-control input-lg codigoLugar select2" style="width: 100%;" nuevo="no">
                            <option value="">Selecionar Lugar</option>
                        </select>
                    </div>-->
                    <div class="form-group">
                        <label for="codigoEstadoCivilUpd" class="control-label">Estado Civil</label>
                        <br>
                        <select id="codigoEstadoCivilUpd"
                                name="codigoEstadoCivilUpd" required
                                class="form-control input-lg codigoEstadoCivilUpd" style="width: 100%;">
                            <option value="">Selecionar Estado Civil</option>
                            <?php
                            foreach ($estadosCiviles as $codigo => $nombre) {
                                echo "<option value='" . $codigo . "'>" . $nombre . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="domicilioUpd" class="control-label">Domicilio</label>
                        <input id="domicilioUpd"
                               name="domicilioNew" type="text" maxlength="150"
                               placeholder="Ingresar domicilio" required
                               class="form-control input-lg" style="width: 100%;">
                    </div>
                    <div class="form-group">
                        <label for="libretaServicioMilitarUpd" class="control-label">Libreta de Servicio Militar</label>
                        <input id="libretaServicioMilitarUpd"
                               name="libretaServicioMilitarUpd" type="text" maxlength="150"
                               placeholder="Ingresar libreta de servicio militar" required
                               class="form-control input-lg" style="width: 100%;">
                    </div>
                    <!--<div class="form-group">
                        <label for="direccionUpd" class="control-label">Dirección</label>
                        <input id="direccionUpd" name="direccionUpd" type="text" maxlength="150"
                               class="form-control input-lg">
                    </div>
                    <div class="form-group">
                        <label for="telefonoUpd" class="control-label">Telefono</label>
                        <input id="telefonoUpd" name="telefonoUpd" type="text" maxlength="150"
                               class="form-control input-lg">
                    </div>
                    <div class="form-group">
                        <label for="celularNew" class="control-label">Celular</label>
                        <input id="celularUpd" name="celularUpd" type="text" maxlength="150"
                               class="form-control input-lg">
                    </div>-->
                </div>
            </div>
            <!--=====================================
            FOOTER MODAL
            ======================================-->
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                <button type="button" id="btnActualizarPersona" class="btn btn-primary">Guardar
                </button>
            </div>
        </div>
    </div>
</div>
<!--=====================================
MODAL MOSTRAR IMAGEN
======================================-->
<div id="modalMostrarImagen" class="modal fade" role="dialog" hidden>
    <div class="modal-dialog">
        <div class="modal-content">
            <!--=====================================
            HEADER MODAL
            ======================================-->
            <div class="modal-header" style="background:#5095ff; color:white">
                <h4 class="modal-title">IMAGEN</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!--=====================================
            CUERPO DEL MODAL
            ======================================-->
            <div class="modal-body">
                <div class="box-body">
                    <!--=====================================
                     DATOS DE LA ASIGNACION MODIFICADO
                     ======================================-->
                    <img id="mostrarImagen" class="card-img-top" src="/SiacPersonal/backend/web/img/memo.jpg">
                </div>
            </div>
            <!--=====================================
            FOOTER MODAL
            ======================================-->
            <div class="modal-footer">
                <button id="siguiente" type="button" class="btn btn-default pull-left">Siguiente</button>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>

