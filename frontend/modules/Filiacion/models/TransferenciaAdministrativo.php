<?php

namespace app\modules\Filiacion\models;

use common\models\Usuario;
use Yii;


class TransferenciaAdministrativo extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'TransferenciasAdministrativos';
    }


    public function rules()
    {
        return [
            [['CodigoTransferencia', 'Motivo', 'FechaInicioTransferencia', 'FechaFinAsignacion', 'CodigoEstado', 'CodigoUsuario'], 'required'],
            [['CodigoTransferencia'], 'integer'],
            [['FechaInicioTransferencia', 'FechaFinAsignacion', 'FechaHoraRegistro'], 'safe'],
            [['Motivo'], 'string', 'max' => 150],
            [['CodigoEstado'], 'string', 'max' => 1],
            [['CodigoUsuario'], 'string', 'max' => 3],
            [['CodigoTransferencia'], 'unique'],
            [['CodigoEstado'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['CodigoEstado' => 'CodigoEstado']],
            [['CodigoUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['CodigoUsuario' => 'CodigoUsuario']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'CodigoTransferencia' => 'Codigo Transferencia',
            'Motivo' => 'Motivo',
            'FechaInicioTransferencia' => 'Fecha Inicio Transferencia',
            'FechaFinAsignacion' => 'Fecha Fin Asignacion',
            'CodigoEstado' => 'Codigo Estado',
            'FechaHoraRegistro' => 'Fecha Hora Registro',
            'CodigoUsuario' => 'Codigo Usuario',
        ];
    }

    public function exist()
    {
        $transferenciaAdministrativo = TransferenciaAdministrativo::find()
            ->where(["Motivo" => $this->Motivo])
            ->andWhere(["<>", "CodigoTransferencia", $this->CodigoTransferencia])->all();
        if(!empty($transferenciaAdministrativo)){
            return true;
        }else{
            return false;
        }
    }

    public function getCodigoEstado()
    {
        return $this->hasOne(Estado::className(), ['CodigoEstado' => 'CodigoEstado']);
    }


    public function getCodigoUsuario()
    {
        return $this->hasOne(Usuario::lassName(), ['CodigoUsuario' => 'CodigoUsuario']);
    }
}
