<?php

namespace app\modules\Administracion\models;

use yii\base\Model;

class LugarAcadObj extends Model
{
    private $IdLugar;
    private $CodigoPais;
    private $CodigoDepartamento;
    private $CodigoProvincia;
    private $CodigoLugar;
    private $NombreLugar;
    private $Urbano;

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