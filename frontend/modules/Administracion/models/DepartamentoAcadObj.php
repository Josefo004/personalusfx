<?php

namespace app\modules\Administracion\models;

use yii\base\Model;

class DepartamentoAcadObj extends Model
{
    private $CodigoPais;
    private $CodigoDepartamento;
    private $NombreDepartamento;    
    private $NombrePais;

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