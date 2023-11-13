<?php

namespace app\modules\Filiacion\models;

use yii\base\Model;

class PersonaDeclaracionJuradaObj extends Model
{
    private $IdPersona;
    private $Emision;
    private $Nombres;
    private $Paterno;
    private $Materno;
    private $NombreCompleto;
    private $FechaNacimiento;
    private $Sexo;
    private $SexoLiteral;
    private $discapacidad;
    private $estadocivil;
    private $direccion;

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