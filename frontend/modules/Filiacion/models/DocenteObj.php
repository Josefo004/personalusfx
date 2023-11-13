<?php

namespace app\modules\Filiacion\models;

use yii\base\Model;

class DocenteObj extends Model
{
    private $IdFuncionario;
    private $IdPersona;
    private $NombreCompleto;
    private $FechaIngreso;
    private $CodigoNivelsalarial;
    private $NombreNivelSalarial;
    private $CodigoSectorTrabajo;
    private $NombreSectorTrabajo;
    private $CodigoCondicionLaboral;
    private $NombreCondicionLaboral;
    private $FechaSalida;
    private $Observaciones;
    private $CodigoEstado;
    private $CodigoUsuario;
    private $FechaHoraRegistro;


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