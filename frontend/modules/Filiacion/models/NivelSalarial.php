<?php

namespace app\modules\Filiacion\models;

class NivelSalarial extends \yii\db\ActiveRecord
{
    public $nombreSectorTrabajo;
    public $nombreCondicionLaboral;

    public static function tableName()
    {
        return 'NivelesSalariales';
    }

    /*public function isUsed()
    {
        if(Asignacion::find()->where(['CodigoNivelSalarial' => $this->CodigoNivelSalarial])->all() != null || IncrementoSalarial::find()->where(['CodigoNivelSalarial' => $this->CodigoNivelSalarial])->all() != null){
            return true;
        }else{
            return false;
        }
    }*/

    public function exist()
    {
        $nivelessalariales = NivelSalarial::find()->where(["NombreNivelSalarial" => $this->NombreNivelSalarial])->andWhere(["<>", "CodigoNivelSalarial", $this->CodigoNivelSalarial])->all();
        if(!empty($nivelessalariales)){
            return true;
        }else{
            return false;
        }
    }

    /*public function getSectorTrabajo()
    {
        return $this->hasOne(SectorTrabajo::className(), ['CodigoSectorTrabajo' => 'CodigoSectorTrabajo']);
    }*/

    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['CodigoEstado' => 'CodigoEstado']);
    }

    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['CodigoUsuario' => 'CodigoUsuario']);
    }
}