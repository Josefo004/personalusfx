<?php

namespace app\modules\Filiacion\models;

class Cargo extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'Cargos';
    }

    public function isUsed()
    {
        $items = Item::find()->where(["CodigoCargo" =>$this->CodigoCargo])->all();
        if(!empty($items)){
            return true;
        }else{
            return false;
        }
    }

    public function exist()
    {
        $cargos = Cargo::find()->where(["NombreCargo" => $this->NombreCargo])->andWhere(["<>", "CodigoCargo", $this->CodigoCargo])->all();
        if(!empty($cargos)){
            return true;
        }else{
            return false;
        }
    }

    public function getSectorTrabajo()
    {
        return $this->hasOne(SectorTrabajo::className(), ['CodigoSectorTrabajo' => 'CodigoSectorTrabajo']);
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