<?php
namespace app\modules\Planillas\models;

use yii\db\ActiveRecord;

class Aporte extends ActiveRecord{

    public static function tableName()
    {
        return 'AportesLey';
    }

    /**
     * @return \yii\db\ActiveQuery
    */

    public function getEstado(){
        return $this->hasOne(Estado::className(),['CodigoEstado'=>'codigoEstado'] );
    }

}
?>