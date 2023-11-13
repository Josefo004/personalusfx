<?php

namespace app\modules\Filiacion\models;

use yii\base\Model;

class TransferenciaDetalleAdministrativoObj extends Model
{
    private $CodigoTransferencia;
    private $CodigoAsignacion;
    private $IdFuncionario;
    private $IdPersona;
    private $FechaNacimiento;
    private $Paterno;
    private $Materno;
    private $Nombres;
    private $NombreCompleto;
    private $CodigoUnidad;
    private $NombreUnidad;
    private $CodigoUnidadPadre;
    private $NombreUnidadPadre;
    private $CodigoSectorTrabajo;
    private $NombreSectorTrabajo;
    private $CodigoCondicionLaboral;
    private $NombreCondicionLaboral;
    private $Sector;
    private $CodigoCargo;
    private $NombreCargo;
    private $NroItem;
    private $NroItemRrhh;
    private $NroItemPlanillas;
    private $CodigoNivelSalarial;
    private $NombreNivelSalarial;
    private $HaberBasico;
    private $FechaInicio;
    private $FechaFin;
    private $Jefatura;
    private $JefaturaLiteral;
    private $Interinato;
    private $InterinatoLiteral;
    private $NroDocumento;
    private $FechaDocumento;
    private $TipoDocumento;
    private $CodigoTipoDocumento;
    private $NombreTipoDocumento;
    private $CodigoTiempoTrabajo;
    private $NombreTiempoTrabajo;
    private $CodigoEstado;
    private $FechaHoraRegistro;
    private $CodigoUsuario;
    private $TipoTransferencia;


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