<?php

namespace app\modules\Administracion\models;
use common\models\Estado;
use common\models\Usuario;

class TipoDocumento extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'TiposDocumentos';
    }

    public function exist()
    {
        $tiposDocumentos = TipoDocumento::find()->where(["NombreTipoDocumento" => $this->NombreTipoDocumento])->andWhere(["<>", "CodigoTipoDocumento", $this->CodigoTipoDocumento])->all();
        if(!empty($tiposDocumentos)){
            return true;
        }else{
            return false;
        }
    }

   /* public function isUsed()
    {
        $asignaciones = Asignacion::find()->where(["CodigoAsignacion" =>$this->CodigoAsignacion])->all();
        if(!empty($asignaciones)){
            return true;
        }else{
            return false;
        }
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