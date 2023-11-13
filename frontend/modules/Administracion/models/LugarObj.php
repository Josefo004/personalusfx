<?php

namespace app\modules\Administracion\models;

use yii\base\Model;

class LugarObj extends Model
{
    private $NombrePais;
    private $NombreDepartamento;
    private $NombreProvincia;
    private $IdLugarAcad;
    private $CodigoPais;
    private $CodigoDepartamento;
    private $CodigoProvincia;
    private $CodigoLugar;
    private $NombreLugar;
    private $CodigoPaisAcad;
    private $CodigoDepartamentoAcad;
    private $CodigoProvinciaAcad;
    private $CodigoLugarAcad;
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