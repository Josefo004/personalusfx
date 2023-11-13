<?php

namespace app\modules\Administracion\models;

use Yii;

class Lugar extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'Lugares';
    }

    public function exist()
    {
        $lugares = Lugar::find()->where(["NombreLugar" => $this->NombreLugar])->andWhere(["<>", "CodigoLugar", $this->CodigoLugar])->all();
        if (!empty($lugares)) {
            return true;
        } else {
            return false;
        }
    }

    /* public function isUsed()
    {
        $personas = Persona::find()->where(["CodigoLugar" => $this->CodigoLugar])->all();
        if(!empty($personas)){
            return true;
        }else{
            return false;
        }
    }*/

    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['CodigoEstado' => 'CodigoEstado']);
    }

    public function getProvincia()
    {
        return $this->hasOne(Provincia::className(), ['CodigoProvincia' => 'CodigoProvincia']);
    }
}
