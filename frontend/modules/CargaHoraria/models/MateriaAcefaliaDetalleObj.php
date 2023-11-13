<?php

namespace app\modules\CargaHoraria\models;

use yii\base\Model;

class MateriaAcefaliaDetalleObj extends Model
{
    private $CodigoCarrera;
    private $NumeroPlanEstudios;
    private $Curso;
    private $SiglaMateria;
    private $NombreMateria;
    private $Grupo;
    private $TipoGrupoLiteral;
    private $HorasMesCh;
    private $HorasMesProp;

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