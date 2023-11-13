<?php

namespace app\modules\Administracion\models;
use common\models\Estado;
use common\models\Usuario;

class Item extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'Items';
    }

    public function isUsed()
    {
        $asignaciones = Asignacion::find()->where(["NroItem" => $this->NroItem])->all();
        if ($asignaciones != null) {
            return true;
        } else {
            return false;
        }
    }

    public function exist()
    {
        $items = Item::find()->where(["NroItemPlanillas" => $this->NroItemPlanillas])->orWhere(["NroItemRrhh" => $this->NroItemRrhh])->all();
        if (!empty($items)) {
            return true;
        } else {
            return false;
        }
    }

    public function getUnidad()
    {
        return $this->hasOne(Unidad::className(), ['CodigoUnidad' => 'CodigoUnidad']);
    }

    public function getCargo()
    {
        return $this->hasOne(Cargo::className(), ['CodigoCargo' => 'CodigoCargo']);
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
