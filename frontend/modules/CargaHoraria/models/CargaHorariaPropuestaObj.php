<?php

namespace app\modules\CargaHoraria\models;

use yii\base\Model;

class CargaHorariaPropuestaObj extends Model
{
    private $CodigoTrabajador;
    private $IdPersona;
    private $Paterno;
    private $Materno;
    private $Nombres;
    private $NombreCompleto;
    private $CondicionLaboral;
    private $GestionAcademica;
    private $CodigoCarrera;
    private $NumeroPlanEstudios;
    private $SiglaMateria;
    private $Grupo;
    private $TipoGrupo;
    private $CodigoTipoGrupo;
    private $TipoGrupoLiteral;
    private $HorasSemana;

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