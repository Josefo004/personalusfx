<?php

namespace app\modules\Contraloria\models;

class TipoDeclaracionJurada extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'TiposDeclaracionesJuradas';
    }

    /*public function rules()
    {
        return [
            [['CodigoTipoDeclaracionJurada', 'NombreTipoDeclaracionJurada', 'Frecuencia', 'CodigoEstado', 'CodigoUsuario'], 'required'],
            [['FechaHoraRegistro'], 'safe'],
            [['CodigoTipoDeclaracionJurada'], 'string', 'max' => 6],
            [['NombreTipoDeclaracionJurada'], 'string', 'max' => 150],
            [['Frecuencia'], 'integer'],
            [['CodigoEstado'], 'string', 'max' => 1],
            [['CodigoUsuario'], 'string', 'max' => 3],
            [['NombreTipoDeclaracionJurada'], 'unique'],
            [['CodigoTipoDeclaracionJurada'], 'unique'],
            [['CodigoEstado'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['CodigoEstado' => 'CodigoEstado']],
            [['CodigoUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['CodigoUsuario' => 'CodigoUsuario']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'CodigoTipoDeclaracionJurada' => 'Codigo Tipo Declaracion Jurada',
            'NombreTipoDeclaracionJurada' => 'Nombre Tipo Declaracion Jurada',
            'Frecuencia' => 'Frecuencia',
            'CodigoEstado' => 'Estado',
            'FechaHoraRegistro' => 'Registro',
            'CodigoUsuario' => 'Usuario',
        ];
    }*/

    public function isUsed()
    {
        $tiposDeclaracionesJuradasTrabajadores = TipoDeclaracionJuradaTrabajador::findOne(['CodigoTipoDeclaracionJurada' => $this->CodigoTipoDeclaracionJurada]);
        if($tiposDeclaracionesJuradasTrabajadores != null){
            return true;
        }else{
            return false;
        }
    }

    public function exist()
    {
        $tiposDeclaracionesJuradas = TipoDeclaracionJurada::find()
            ->where(["NombreTipoDeclaracionJurada" => $this->NombreTipoDeclaracionJurada])
            ->andWhere(["<>", "CodigoTipoDeclaracionJurada", $this->CodigoTipoDeclaracionJurada])->all();
        if(!empty($tiposDeclaracionesJuradas)){
            return true;
        }else{
            return false;
        }
    }

    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['CodigoEstado' => 'CodigoEstado']);
    }

    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['CodigoUsuario' => 'CodigoUsuario']);
    }
}
