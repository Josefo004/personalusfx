<?php

namespace app\modules\Administracion\models;
use common\models\Estado;

class Pais extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'Paises';
    }

    public function existe()
    {
        $paises = Pais::find()->where(["NombrePais" => $this->NombrePais])->andWhere(["<>", "CodigoPais", $this->CodigoPais])->all();
        if(!empty($paises)){
            return true;
        }else{
            return false;
        }
    }

    public function enUso()
    {
        $departamentos = Departamento::find()->where(["CodigoPais" => $this->CodigoPais])->all();
        if(!empty($departamentos)){
            return true;
        }else{
            return false;
        }
    }

    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['CodigoEstado' => 'CodigoEstado']);
    }
}