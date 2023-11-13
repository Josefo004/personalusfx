<?php

namespace app\modules\Administracion\models;

use yii\base\Model;

class PaisObj extends Model
{
    private $CodigoPais;
    private $NombrePais;
    private $CodigoPaisAcad;
    private $Nacionalidad;
    private $CodigoEstado;

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