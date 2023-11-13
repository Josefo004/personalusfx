<?php

namespace app\modules\Filiacion\models;

use yii\base\Model;

class AdministrativoObj extends Model
{
    private $IdFuncionario;
    private $IdPersona;
    private $NombreCompleto;
    private $IdItem;
    private $NroItem;
    private $FechaIngreso;
    private $CodigoNivelsalarial;
    private $NombreNivelSalarial;
    private $CodigoCondicionLaboral;
    private $NombreCondicionLaboral;
    private $FechaSalida;
    private $NroMemorando;
    private $Observaciones;
    private $CodigoTiempoTrabajo;
    private $NombreTiempoTrabajo;
    private $CodigoSectorTrabajo;
    private $NombreSectorTrabajo;
    private $CodigoCargo;
    private $Nombreargo;
    private $CodigoEstado;
    private $CodigoUsuario;
    private $FechaHoraRegistro;


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