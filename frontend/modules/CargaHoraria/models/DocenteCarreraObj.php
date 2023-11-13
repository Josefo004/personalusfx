<?php

namespace app\modules\CargaHoraria\models;

use yii\base\Model;

class DocenteCarreraObj extends Model
{
    private $IdPersona;
    private $Paterno;
    private $Materno;
    private $Nombres;
    private $NombreCompleto;
    private $CondicionLaboral;
    private $TotalHorasMesCh;
    private $TotalHorasMesProp;


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