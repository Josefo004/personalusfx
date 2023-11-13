<?php

namespace app\modules\Filiacion\models;

use common\models\Usuario;
use Yii;

class Cargo extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'Cargos';
    }

    public function rules()
    {
        return [
            [['CodigoCargo', 'NombreCargo', 'CodigoSectorTrabajo', 'CodigoEstado', 'CodigoUsuario'], 'required'],
            [['FechaHoraRegistro'], 'safe'],
            [['CodigoCargo'], 'string', 'max' => 6],
            [['NombreCargo', 'ArchivoManualFunciones'], 'string', 'max' => 150],
            [['DescripcionCargo', 'RequisitosPrincipales', 'RequisitosOpcionales'], 'string', 'max' => 500],
            [['CodigoSectorTrabajo', 'CodigoUsuario'], 'string', 'max' => 3],
            [['CodigoEstado'], 'string', 'max' => 1],
            [['NombreCortoCargo', 'CargoExportacion'], 'string', 'max' => 200],
            [['NombreCargo'], 'unique'],
            [['CodigoCargo'], 'unique'],
            [['CodigoEstado'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['CodigoEstado' => 'CodigoEstado']],
            [['CodigoSectorTrabajo'], 'exist', 'skipOnError' => true, 'targetClass' => SectorTrabajo::className(), 'targetAttribute' => ['CodigoSectorTrabajo' => 'CodigoSectorTrabajo']],
            [['CodigoUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['CodigoUsuario' => 'CodigoUsuario']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'CodigoCargo' => 'Codigo Cargo',
            'NombreCargo' => 'Nombre Cargo',
            'DescripcionCargo' => 'Descripcion Cargo',
            'RequisitosPrincipales' => 'Requisitos Principales',
            'RequisitosOpcionales' => 'Requisitos Opcionales',
            'ArchivoManualFunciones' => 'Archivo Manual Funciones',
            'CodigoSectorTrabajo' => 'Codigo Sector Trabajo',
            'CodigoEstado' => 'Codigo Estado',
            'FechaHoraRegistro' => 'Fecha Hora Registro',
            'CodigoUsuario' => 'Codigo Usuario',
            'NombreCortoCargo' => 'Nombre Corto Cargo',
            'CargoExportacion' => 'Cargo Exportacion',
        ];
    }

    public function getCodigoEstado()
    {
        return $this->hasOne(Estado::className(), ['CodigoEstado' => 'CodigoEstado']);
    }

    public function getCodigoSectorTrabajo()
    {
        return $this->hasOne(SectorTrabajo::className(), ['CodigoSectorTrabajo' => 'CodigoSectorTrabajo']);
    }

    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['CodigoUsuario' => 'CodigoUsuario']);
    }

    public function getItems()
    {
        return $this->hasMany(Item::className(), ['CodigoCargo' => 'CodigoCargo']);
    }

    public function getUnidadesCargos()
    {
        return $this->hasMany(UnidadCargo::className(), ['Cargo' => 'CodigoCargo']);
    }

    public function getUnidadesCargos0()
    {
        return $this->hasMany(UnidadCargo::className(), ['Cargo' => 'CodigoCargo']);
    }

    public function getUnidadesCargos1()
    {
        return $this->hasMany(UnidadCargo::className(), ['Cargo' => 'CodigoCargo']);
    }
}
