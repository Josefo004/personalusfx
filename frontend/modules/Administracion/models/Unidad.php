<?php

namespace app\modules\Administracion\models;
use common\models\Estado;
use common\models\Usuario;



class Unidad extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'Unidades';
    }

    public function isUsed()
    {
        $unidades = Unidad::find()->where(["CodigoUnidadPadre" =>$this->CodigoUnidad])->all();
        if(!empty($unidades)){
            return true;
        }else{
            $items = Item::find()->where(["CodigoUnidad" =>$this->CodigoUnidad])->all();
            if(!empty($items)){
                return true;
            }else{
                return false;
            }
        }
    }

    public function exist()
    {
        $unidades = Unidad::find()->where(["NombreUnidad" => $this->NombreUnidad])->andWhere(["CodigoUnidadPadre" => $this->CodigoUnidadPadre])->andWhere(["<>", "CodigoUnidad", $this->CodigoUnidad])->all();
        if(!empty($unidades)){
            return true;
        }else{
            return false;
        }
    }

    public function getUnidadPadre()
    {
        return $this->hasOne(Unidad::className(), ['CodigoUnidad' => 'CodigoUnidadPadre']);
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
