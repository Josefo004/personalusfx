<?php

namespace app\modules\Administracion\models;

use yii\base\Model;

class NivelSalarialObj extends Model
{
    private $CodigoNivelSalarial;
    private $NombreNivelSalarial;
    private $DescripcionNivelSalarial;
    private $HaberBasico;
    private $PuntosEscalafon;
    private $CodigoSectorTrabajo;
    private $NombreSectorTrabajo;
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