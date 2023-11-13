<?php

namespace app\modules\Filiacion\models;

use yii\base\Model;

class AsignacionObj extends Model
{
    private $CodigoAsignacion;
    private $CodigoTrabajador;
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
            'CodigoAsignacion' => 'Asignacion',
            'CodigoTrabajador' => 'Codigo',
            'IdPersona' => 'Id Persona',
            'Paterno' => 'Paterno',
            'Materno' => 'Materno',
            'Nombres' => 'Nombres',
            'NombreCompleto' => 'Nombre Completo',
            'FechaNacimiento' => 'Fecha Nacimiento',
            'CodigoUnidad' => 'Codigo Unidad',
            'NombreUnidad' => 'Nombre Unidad',
            'CodigoSectorTrabajo' => 'Codigo Sector Trabajo',
            'NombreSectorTrabajo' => 'Nombre Sector Trabajo',
            'CodigoCondicionLaboral' => 'Codigo Condicion Laboral',
            'NombreCondicionLaboral' => 'Nombre Condicion Laboral',
            'Sector' => 'Sector',
            'CodigoCargo' => 'Codigo Cargo',
            'NombreCargo' => 'Nombre Cargo',
            'NroItem' => 'Item',
            'NroItemRrhh' => 'Item',
            'NroItemPlanillas' => 'Item',
            'CodigoNivelSalarial' => 'Codigo Nivel Salarial',
            'NombreNivelSalarial' => 'Nombre Nivel Salarial',
            'HaberBasico' => 'Haber Basico',
            'FechaInicio' => 'Fecha Inicio',
            'FechaFin' => 'Fecha Fin',
            'Jefatura' => 'Jefatura',
            'Documento' => 'Documento',
            'FechaDocumento' => 'Fecha Documento',
            'FechaHoraRegistro' => 'Registro',
            'CodigoUsuario' => 'Usuario',
            'CodigoEstado' => 'Estado',
        ];
    }
}