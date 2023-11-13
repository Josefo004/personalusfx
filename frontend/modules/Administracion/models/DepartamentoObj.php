<?php

namespace app\modules\Administracion\models;

use yii\base\Model;

class DepartamentoObj extends Model
{
    private $CodigoDepartamento;
    private $NombreDepartamento;
    private $CodigoPais;
    private $CodigoPaisAcad;
    private $CodigoDepartamentoAcad;
    private $CodigoEstado;
    private $NombrePais;
    private $Nacionalidad;

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