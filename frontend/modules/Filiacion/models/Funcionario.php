<?php

namespace app\modules\Filiacion\models;

class Funcionario extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'Funcionarios';
    }

    /*public function exist()
    {
        $trabajadores = Funcionario::find()->where(["IdFuncionario" => $this->IdFuncionario])->orWhere(["IdPersona" => $this->IdPersona])->all();
        if(!empty($trabajadores)){
            return true;
        }else{
            return false;
        }
    }*/

}