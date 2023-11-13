<?php

namespace app\modules\Filiacion\models;

use app\modules\Administracion\models\Lugar;
use app\modules\Filiacion\models\EstadoCivil;
use Yii;

class PersonaDato extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'PersonasDatos';
    }

    public function attributeLabels()
    {
        return [
            'IdPersona' => 'Id Persona',
            'CodigoLugar' => 'Codigo Lugar',
            'CodigoEstadoCivil' => 'Codigo Estado Civil',
            'ApellidoEsposo' => 'Apellido Esposo',
            'Direccion' => 'Direccion',
            'Telefono' => 'Telefono',
            'Celular' => 'Celular',
        ];
    }

    public function getCodigoLugar()
    {
        return $this->hasOne(Lugar::className(), ['CodigoLugar' => 'CodigoLugar']);
    }

    public function getCodigoEstadoCivil()
    {
        return $this->hasOne(EstadoCivil::className(), ['CodigoEstadoCivil' => 'CodigoEstadoCivil']);
    }

    public function exist()
    {
        $personasDatos = PersonaDato::find()->where(["IdPersona" => $this->IdPersona])->all();
        if(!empty($personasDatos)){
            return true;
        }else{
            return false;
        }
    }
}
