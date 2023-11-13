<?php

namespace app\modules\Administracion\models;
use common\models\Estado;

class SectorTrabajo extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'SectoresTrabajo';
    }

    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['CodigoEstado' => 'CodigoEstado']);
    }
}
