<?php

namespace app\modules\Filiacion\models;

use yii\base\Model;

class PersonaObj extends Model
{
    private $IdPersona;
    private $NumeroDocumento;
    private $NroComplemento;
    private $TipoDocumento;
    private $LugarExpedicion;
    private $PrimerNombre;
    private $SegundoNombres;
    private $TercerNombre;
    private $ApellidoPaterno;
    private $ApellidoMaterno;
    private $NombreCompleto;
    private $FechaNacimiento;
    private $Sexo;
    private $SexoLiteral;
    private $CodigoEstadoCivil;
    private $NombreEstadoCivil;
    private $Discapadidad;
    private $Domicilio;
    private $LibretaServicioMilitar;
    private $CodigoEstado;
    private $FechaHoraRegistro;
    private $CodigoUsuario;

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}