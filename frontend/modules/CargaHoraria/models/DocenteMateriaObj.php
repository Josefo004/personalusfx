<?php

namespace app\modules\CargaHoraria\models;

use yii\base\Model;

class DocenteMateriaObj extends Model
{
    private $IdPersona;
    private $Paterno;
    private $Materno;
    private $Nombres;
    private $NombreCompleto;
    private $CondicionLaboral;
    private $CantGrpsTeoria;
    private $CantGrpsPractica;
    private $CantGrpsLaboratorio;
    private $HorasMesTeoria;
    private $HorasMesPractica;
    private $HorasMesLaboratorio;
    private $TotalHorasMes;


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