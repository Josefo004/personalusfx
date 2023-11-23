<?php

namespace app\modules\Planillas\models;

use yii\base\Model;

class AportesObj extends Model
{
    private $codigoAporteLey;
    private $nombreAporteLey;
    private $tipoAporte;
    private $porcentaje;
    private $montoSalario;
    private $observaciones;
    private $fechaInicio;
    private $fechaFin;
    private $codigoEstado;
    private $NombreEstado;
    private $fechaRegistro;
    private $codigoUsuario;

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