<?php
namespace app\modules\Planillas\models;

use yii\db\ActiveRecord;

class Estado extends ActiveRecord{

    public static function tableName()
    {
        return 'Estados';
    }

    /**
     * @return \yii\db\ActiveQuery
    */

    public function getAportes(){
        return $this->hasMany(Aporte::className(),['CodigoEstado'=>'codigoEstado']);
    }

}
?>