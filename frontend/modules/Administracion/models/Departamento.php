<?php

namespace app\modules\Administracion\models;

use Yii;

class Departamento extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'Departamentos';
    }

    public function existe()
    {
        $departamentos = Departamento::find()->where(["NombreDepartamento" => $this->NombreDepartamento])->andWhere(["<>", "CodigoDepartamento", $this->CodigoDepartamento])->all();
        if (!empty($departamentos)) {
            return true;
        } else {
            return false;
        }
    }

    public function enUso()
    {
        $provincias = Provincia::find()->where(["CodigoDepartamento" => $this->CodigoDepartamento])->all();
        if (!empty($provincias)) {
            return true;
        } else {
            return false;
        }
    }

    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['CodigoEstado' => 'CodigoEstado']);
    }

    public function gePais()
    {
        return $this->hasOne(Pais::className(), ['CodigoPais' => 'CodigoPais']);
    }
}
