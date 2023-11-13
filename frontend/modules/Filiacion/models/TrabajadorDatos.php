<?php

namespace common\models;

class TrabajadorDatos extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'TrabajadoresDatos';
    }

    public function getTrabajador()
    {
        return $this->hasOne(Trabajador::className(), ['CodigoTrabajador' => 'CodigoTrabajador']);
    }

    public function getNacionalidad()
    {
        return $this->hasOne(Nacionalidad::className(), ['CodigoNacionalidad' => 'CodigoNacionalidad']);
    }

    public function getEstadoCivil()
    {
        return $this->hasOne(EstadoCivil::className(), ['CodigoEstadoCivil' => 'CodigoEstadoCivil']);
    }

    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['CodigoUsuario' => 'CodigoUsuario']);
    }
}
