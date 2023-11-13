<?php

namespace app\modules\CargaHoraria\models;

use yii\base\Model;

class MateriaPlanificacionObj extends Model
{
    private $CodigoFacultad;
    private $NombreFacultad;
    private $CodigoCarrera;
    private $NombreCarrera;
    private $NombreCortoCarrera;
    private $NumeroPlanEstudios;
    private $Curso;
    private $SiglaMateria;
    private $NombreMateria;
    private $HorasTeoria;
    private $HorasPractica;
    private $HorasLaboratorio;
    private $GestionAcademicaAnterior;
    private $GestionAcademicaActual;
    private $CantGrpsTeoriaAnterior;
    private $CantGrpsPracticaAnterior;
    private $CantGrpsLaboratorioAnterior;
    private $CantGrpsTeoriaActual;
    private $CantGrpsPracticaActual;
    private $CantGrpsLaboratorioActual;
    private $NumEstAnterior;
    private $NumEstActual;
    private $CodigoSedeAcad;

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