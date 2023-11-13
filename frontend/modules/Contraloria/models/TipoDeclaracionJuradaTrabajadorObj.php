<?php

namespace app\modules\Contraloria\models;

use yii\base\Model;

class TipoDeclaracionJuradaTrabajadorObj extends Model
{
    private $CodigoTipoDeclaracionJurada;
    private $NombreTipoDeclaracionJurada;
    private $Frecuencia;
    private $CodigoTrabajador;
    private $IdPersona;
    private $Paterno;
    private $Materno;
    private $Nombres;
    private $NombreCompleto;
    private $FechaNacimiento;
    private $Celular;
    private $FechaInicioRecordatorio;
    private $FechaFinRecordatorio;
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

    public function attributeLabels()
    {
        return [
            'CodigoTipoDeclaracionJurada' => 'Codigo',
            'CodigoTrabajador' => 'Trabajador',
            'FechaInicioRecordatorio' => 'Fecha Inicio',
            'FechaFinRecordatorio' => 'Fecha Fin',
            'FechaHoraRegistro' => 'Registro',
            'CodigoUsuario' => 'Usuario',
        ];
    }
}