<?php

namespace app\modules\Filiacion\models;
use app\modules\Administracion\models\Lugar;
use app\modules\Administracion\models\LugarEmision;


class Persona extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'Personas';
    }

    public function getSexoLiteral()
    {
        if ($this->Sexo == 'F') {
            $sexoLiteral = 'FEMENINO';
        } else {
            if ($this->Sexo == 'M') {
                $sexoLiteral = 'MASCULINO';
            } else {
                $sexoLiteral = 'OTRO';
            }
        }
        return $sexoLiteral;
    }

    /*public function getDiscapacidadLiteral()
    {
        if ($this->Discapacidad == 'S') {
            $discapacidadLiteral = 'SI';
        } else {
            if ($this->Discapacidad == 'N') {
                $discapacidadLiteral = 'NO';
            } else {
                $discapacidadLiteral = 'OTRO';
            }
        }
        return $discapacidadLiteral;
    }*/

    public function getNombreCompleto()
    {
        $nombreCompleto = "";
        if(!$this->Paterno){
            $nombreCompleto=$nombreCompleto."";
        }else{
            $nombreCompleto=$nombreCompleto.$this->Paterno;
        }
        $nombreCompleto=$nombreCompleto." ";
        if(!$this->Materno){
            $nombreCompleto=$nombreCompleto."";
        }else{
            $nombreCompleto=$nombreCompleto.$this->Materno;
        }
        $nombreCompleto=$nombreCompleto." ";
        if(!$this->Nombres){
            $nombreCompleto=$nombreCompleto."";
        }else{
            $nombreCompleto=$nombreCompleto.$this->Nombres;
        }
        return strtoupper($nombreCompleto);
    }

    public function isUsed()
    {
        $trabajador = Trabajador::findOne(['IdPersona' => $this->IdPersona]);
        if($trabajador != null){
            return true;
        }else{
            return false;
        }
    }

    public function exist()
    {
        $personas = Persona::find()->where(["IdPersona" => $this->IdPersona])->all();
        if(!empty($personas)){
            return true;
        }else{
            return false;
        }
    }

   /* public function getLugar()
    {
        return $this->hasOne(LugarEmision::className(), ['CodigoLugarEmision' => 'CodigoLugarEmision']);
    }*/
}