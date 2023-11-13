<?php

namespace app\modules\Filiacion\models;

use Yii;

class EstadoCivil extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'EstadosCiviles';
    }

    public function attributeLabels()
    {
        return [
            'CodigoEstadoCivil' => 'Codigo Estado Civil',
            'NombreEstadoCivil' => 'Nombre Estado Civil',
        ];
    }


    public function getPersonasDatos()
    {
        return $this->hasOne(PersonaDato::className(), ['CodigoEstadoCivil' => 'CodigoEstadoCivil']);
    }
}
