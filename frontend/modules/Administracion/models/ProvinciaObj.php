<?php

namespace app\modules\Administracion\models;

use yii\base\Model;

class ProvinciaObj extends Model
{    
    private $CodigoProvincia;
    private $NombreProvincia;
    private $CodigoDepartamento;
    private $CodigoPaisAcad;
    private $CodigoDepartamentoAcad;
    private $CodigoProvinciaAcad;
    private $CodigoEstado;
    private $NombrePais;
    private $NombreDepartamento;

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