<?php

namespace app\modules\Filiacion\models;

class Trabajador extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'Funcionarios';
    }

    /*public function isUsed()
    {
        $trabajador = TrabajadorDatos::findOne(['CodigoTrabajador' => $this->CodigoTrabajador]);
        if($trabajador != null){
            return true;
        }else{
            $trabajador = TipoDeclaracionJuradaTrabajador::findOne(['CodigoTrabajador' => $this->CodigoTrabajador]);
            if($trabajador != null){
                return true;
            }else{
                $trabajador = TrabajadorDeclaracionJurada::findOne(['CodigoTrabajador' => $this->CodigoTrabajador]);
                if($trabajador != null){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }*/

    /*public function exist()
    {
        $trabajadores = Funcionario::find()->where(["IdFuncionario" => $this->IdFuncionario])->orWhere(["IdPersona" => $this->IdPersona])->all();
        if(!empty($trabajadores)){
            return true;
        }else{
            return false;
        }
    }*/

    public function getNivelAcademico()
    {
        return $this->hasOne(NivelAcademico::className(), ['CodigoNivelAcademico' => 'CodigoNivelAcademico']);
    }

    public function getPersona()
    {
        return $this->hasOne(Persona::className(), ['IdPersona' => 'IdPersona']);
    }

    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['CodigoEstado' => 'CodigoEstado']);
    }

    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['CodigoUsuario' => 'CodigoUsuario']);
    }
}