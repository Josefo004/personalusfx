<?php

namespace app\modules\Administracion\models;
use common\models\Estado;

class CondicionLaboral extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'CondicionesLaborales';
    }

    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['CodigoEstado' => 'CodigoEstado']);
    }

    public function getSectorTrabajo()
    {
        return $this->hasOne(SectorTrabajo::className(), ['CodigoSectorTrabajo' => 'CodigoSectorTrabajo']);
    }
}
