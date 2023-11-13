<?php

namespace app\modules\Administracion\models;

use app\modules\Filiacion\models\Persona;
use common\models\Estado;
use common\models\Usuario;
use Yii;

class LugarEmision extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'LugaresEmision';
    }

    public function attributeLabels()
    {
        return [
            'CodigoLugarEmision' => 'Codigo Lugar Emision',
            'NombreLugarEmision' => 'Nombre Lugar Emision',
            'CodigoEstado' => 'Codigo Estado',
            'CodigoUsuario' => 'Codigo Usuario',
            'FechaHoraRegistro' => 'Fecha Hora Registro',
        ];
    }

    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['CodigoEstado' => 'CodigoEstado']);
    }

    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['CodigoUsuario' => 'CodigoUsuario']);
    }

    public function getPersonas()
    {
        return $this->hasOne(Persona::className(), ['CodigoLugarEmision' => 'CodigoLugarEmision']);
    }
}
