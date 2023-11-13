<?php

namespace app\modules\Administracion\models;

use yii\base\Model;

class PaisAcadObj extends Model
{
    private $CodigoPais;
    private $CodigoISO3166;
    private $NumeroPais;
    private $NombrePais;
    private $Gentilicio;
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
