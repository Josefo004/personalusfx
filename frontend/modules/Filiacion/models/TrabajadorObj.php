<?php

namespace app\modules\Filiacion\models;

use yii\base\Model;

class   TrabajadorObj extends Model
{
    private $IdFuncionario;
    private $IdPersona;
    private $ApellidoPaterno;
    private $ApellidoMaterno;
    private $PrimerNombre;
    private $SegundoNombres;
    private $TercerNombre;
    private $NombreCompleto;
    private $FechaNacimiento;
    private $FechaIngreso;
    private $FechaSalida;
    private $FechaCalculoAntiguedad;
    private $FechaCalculoVacaciones;
    private $FechaFiniquito;
    private $FechaActualizacion;
    private $ResolucionAFP;
    private $FechaRegistroAFP;
    private $PrimerMesRegistroAFP;
    private $UltimoMesRegistroAFP;
    private $ExclusionVoluntariaAFP;
    private $CodigoBanco;
    private $NombreBanco;
    private $CodigoAfp;
    private $NombreAfp;
    private $Nua;
    private $CodigoSeguroSalud;
    private $NombreSeguroSalud;
    private $CodigoEstadoFuncionario;
    private $FechaHoraRegistro;
    private $CodigoUsuario;
    private $CodigoTipoDeclaracionJurada;
    private $NombreTipoDeclaracionJurada;

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