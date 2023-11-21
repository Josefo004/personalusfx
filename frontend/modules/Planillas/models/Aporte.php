<?php
namespace app\modules\Planillas\models;

use yii\db\ActiveRecord;

class Aporte extends ActiveRecord{

    public static function tableName()
    {
        return 'AportesLey';
    }

}
?>