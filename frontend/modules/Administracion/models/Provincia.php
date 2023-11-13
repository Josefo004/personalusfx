<?php

namespace app\modules\Administracion\models;

use Yii;

class Provincia extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'Provincias';
    }

    public function exist()
    {
        $provincias = Provincia::find()->where(["NombreProvincia" => $this->NombreProvincia])->andWhere(["<>", "CodigoProvincia", $this->CodigoProvincia])->all();
        if(!empty($provincias)){
            return true;
        }else{
            return false;
        }
    }

    public function enUso()
    {
        $lugares = Lugar::find()->where(["CodigoProvincia" => $this->CodigoProvincia])->all();
        if(!empty($lugares)){
            return true;
        }else{
            return false;
        }
    }

    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['CodigoEstado' => 'CodigoEstado']);
    }

    public function getDepartamento()
    {
        return $this->hasOne(Departamento::className(), ['CodigoDepartamento' => 'CodigoDepartamento']);
    }
}
