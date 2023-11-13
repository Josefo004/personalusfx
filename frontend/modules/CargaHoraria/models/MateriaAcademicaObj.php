<?php

namespace app\modules\CargaHoraria\models;

use yii\base\Model;

class MateriaAcademicaObj extends Model
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
    private $Grupo;
    private $TipoGrupo;
    private $IdPersona;
    private $Paterno;
    private $Materno;
    private $Nombres;
    private $NombreCompleto;
    private $NumeroEstudiantesLimite;
    private $NumeroEstudiantesProgramados;
    private $InformadoCargaHoraria;

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