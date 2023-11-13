<?php

namespace app\modules\Administracion\models;

use yii\base\Model;

class ProvinciaAcadObj extends Model
{    
    private $CodigoPais;
    private $CodigoDepartamento;
    private $CodigoProvincia;
    private $NombreProvincia; 
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