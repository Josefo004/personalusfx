<?php

namespace common\models;

use yii\base\Model;

class TrabajadorDeclaracionJuradaObj extends Model
{
    private $CodigoDeclaracionJurada;
    private $CodigoTrabajador;
    private $IdPersona;
    private $Paterno;
    private $Materno;
    private $Nombres;
    private $NombreCompleto;
    private $CodigoTipoDeclaracionJurada;
    private $NombreTipoDeclaracionJurada;
    private $Gestion;
    private $Mes;
    private $FechaInicioRecordatorio;
    private $FechaFinRecordatorio;
    private $FechaNotificacion;
    private $FechaRecepcion;
    private $Observacion;
    private $FechaHoraRegistro;
    private $CodigoUsuario;
    private $FechaNacimiento;
    private $Reside;
    private $Funcion;
    private $Cargo;

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

