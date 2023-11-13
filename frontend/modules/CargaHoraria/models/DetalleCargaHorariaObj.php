<?php


namespace app\modules\CargaHoraria\models;
use yii\base\Model;

class DetalleCargaHorariaObj extends Model
{
    private $GestionAcademica;
    private $Gestion;
    private $CodigoCarrera;
    private $CodigoSede;
    private $NumeroPlanEstudios;
    private $SiglaMateria;
    private $Grupo;
    private $CodigoTipoGrupo;
    private $IdPersona;
    private $FechaInicio;
    private $FechaFinal;
    private $CodigoUsuario;
    private $FechaHoraRegistro;
    private $NombreCompleto;
    private $NombreCarrera;
    private $NombreFacultad;
    private $NombreSede;
    private $NombreMateria;
    private $Curso;
    private $TotalHorasSemana;
    private $TotalHorasMes;
    private $CodigoTrabajador;

    public function __get($property){
        if(property_exists($this, $property)) {
            return $this->$property;
        }
    }
    public function __set($property, $value){
        if(property_exists($this, $property)) {
            $this->$property = $value;
        }
    }
}