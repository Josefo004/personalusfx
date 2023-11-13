<?php

namespace app\modules\CargaHoraria\models;

use yii\base\Model;

class DocenteObj extends Model
{
    private $CodigoTrabajador;
    private $IdPersona;
    private $Paterno;
    private $Materno;
    private $Nombres;
    private $NombreCompleto;
    private $CondicionLaboral;

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