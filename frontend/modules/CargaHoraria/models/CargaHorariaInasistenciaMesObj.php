<?php


namespace app\modules\CargaHoraria\models;
use yii\base\Model;

class CargaHorariaInasistenciaMesObj extends Model
{
    private $CodigoCarrera;
    private $NombreCarrera;
    private $CodigoSedeAcad;
    private $NumeroPlanEstudios;
    private $SiglaMateria;
    private $Grupo;
    private $Gestion;
    private $Mes;
    private $CodigoTrabajador;
    private $Fecha;
    private $Horas;
    private $Observacion;
    private $CodigoTipoInasistencia;
    private $FechaHoraRegistro;
    private $CodigoUsuario;
    private $NombreTipoInasistencia;
    private $NombreCompleto;
    private $NombreSede;

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