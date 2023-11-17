<?php

namespace app\modules\Planillas\models;

use yii\base\Model;

class AportesObj extends Model
{
    private $CodigoAporteLey;
    private $NombreAporteLey;
    private $TipoAporte;
    private $Porcentaje;
    private $MontoSalario;
    private $Observaciones;
    private $CodigoEstado;
    private $NombreEstado;
    private $FechaHoraRegistro;
    private $CodigoUsuario;

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