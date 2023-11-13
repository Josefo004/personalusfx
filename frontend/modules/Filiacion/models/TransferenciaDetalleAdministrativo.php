<?php

namespace app\modules\Filiacion\models;

use Yii;

class TransferenciaDetalleAdministrativo extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'TransferenciasDetalleAdministrativos';
    }

    public function rules()
    {
        return [
            [['CodigoTransferencia', 'CodigoTrabajador', 'NroItem', 'CodigoNivelSalarial', 'TipoTransferencia', 'CodigoEstado', 'CodigoUsuario'], 'required'],
            [['CodigoTransferencia', 'NroItem', 'CodigoNivelSalarial'], 'integer'],
            [['FechaHoraRegistro'], 'safe'],
            [['CodigoTrabajador'], 'string', 'max' => 10],
            [['TipoTransferencia', 'CodigoEstado'], 'string', 'max' => 1],
            [['CodigoUsuario'], 'string', 'max' => 3],
            [['CodigoTrabajador', 'CodigoTransferencia', 'NroItem', 'TipoTransferencia'], 'unique', 'targetAttribute' => ['CodigoTrabajador', 'CodigoTransferencia', 'NroItem', 'TipoTransferencia']],
            [['NroItem'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['NroItem' => 'NroItem']],
            [['CodigoEstado'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['CodigoEstado' => 'CodigoEstado']],
            [['CodigoNivelSalarial'], 'exist', 'skipOnError' => true, 'targetClass' => NivelSalarial::className(), 'targetAttribute' => ['CodigoNivelSalarial' => 'CodigoNivelSalarial']],
            [['CodigoUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['CodigoUsuario' => 'CodigoUsuario']],
            [['CodigoTransferencia'], 'exist', 'skipOnError' => true, 'targetClass' => TransferenciaAdministrativo::className(), 'targetAttribute' => ['CodigoTransferencia' => 'CodigoTransferencia']],
            [['CodigoTrabajador'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajador::className(), 'targetAttribute' => ['CodigoTrabajador' => 'CodigoTrabajador']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'CodigoTransferencia' => 'Codigo Transferencia',
            'CodigoTrabajador' => 'Codigo Trabajador',
            'NroItem' => 'Nro Item',
            'CodigoNivelSalarial' => 'Codigo Nivel Salarial',
            'TipoTransferencia' => 'Tipo Transferencia',
            'CodigoEstado' => 'Codigo Estado',
            'FechaHoraRegistro' => 'Fecha Hora Registro',
            'CodigoUsuario' => 'Codigo Usuario',
        ];
    }

    /*public function isUsed()
    {
        $transferenciaDetalleAdministrativo = TransferenciaDetalleAdministrativo::find()
            ->andWhere(["CodigoTrabajador" =>$this->CodigoTrabajador])
            ->where(["CodigoEstado" =>'V'])->one();
        if(!empty($transferenciaDetalleAdministrativo)){
            return true;
        }else{
            return false;
        }
    }*/

    public function getNroItem()
    {
        return $this->hasOne(Item::className(), ['NroItem' => 'NroItem']);
    }

    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['CodigoEstado' => 'CodigoEstado']);
    }

    public function getNivelSalarial()
    {
        return $this->hasOne(NivelSalarial::className(), ['CodigoNivelSalarial' => 'CodigoNivelSalarial']);
    }

    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['CodigoUsuario' => 'CodigoUsuario']);
    }

    public function getTransferencia()
    {
        return $this->hasOne(TransferenciaAdministrativo::className(), ['CodigoTransferencia' => 'CodigoTransferencia']);
    }

    public function getTrabajador()
    {
        return $this->hasOne(Trabajador::className(), ['CodigoTrabajador' => 'CodigoTrabajador']);
    }
}
