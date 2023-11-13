<?php

namespace app\modules\CargaHoraria\models;

use yii\base\Model;

class CargaHorariaConfiguracionObj extends Model
{
    private $GestionAcademica;
    private $CodigoCarrera;
    private $CodigoSede;
    private $CodigoSedeAcad;
    private $GestionAnterior;
    private $MesAnterior;
    private $GestionAcademicaAnterior;
    private $GestionAcademicaPlanificacion;
    private $CodigoModalidadCurso;
    private $FechaInicioPlanificacion;
    private $FechaFinPlanificacion;
    private $FechaInicioContrataciones;
    private $FechaFinContrataciones;
    private $DiaInicioInformes;
    private $DiaFinInformes;
    private $CodigoEstado;
    private $CodigoEstadoPlanificacion;
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