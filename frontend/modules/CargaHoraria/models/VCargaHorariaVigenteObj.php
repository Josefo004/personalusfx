<?php

namespace app\modules\CargaHoraria\models;
use yii\base\Model;

class VCargaHorariaVigenteObj extends Model
{
    private $GestionAcademica;
    private $CodigoFacultad;
    private $NombreFacultad;
    private $CodigoCarrera;
    private $NombreCarrera;
    private $CodigoSedeAcad;
    private $NombreSedeAcad;
    private $NumeroPlanEstudios;
    private $SiglaMateria;
    private $NombreMateria;
    private $Grupo;
    private $TipoGrupo;
    private $IdPersona;
    private $CodigoTrabajador;
    private $Paterno;
    private $Materno;
    private $Nombres;
    private $FechaInicio;
    private $FechaFinal;
    private $CodigoUnidad;
    private $NombreCompleto;
    private $HorasSemana;
    private $HorasMes;
    private $Curso;

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