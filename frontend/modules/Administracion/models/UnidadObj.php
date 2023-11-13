<?php

namespace app\modules\Administracion\models;

use yii\base\Model;

class UnidadObj extends Model
{
    private $CodigoUnidad;
    private $NombreUnidad;
    private $NombreCortoUnidad;
    private $CodigoUnidadPadre;
    private $NombreUnidadPadre;
    private $CodigoEstado;
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