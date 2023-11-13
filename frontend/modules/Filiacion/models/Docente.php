<?php

namespace app\modules\Filiacion\models;

use common\models\Usuario;
use Yii;

class Docente extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'Docentes';
    }

    /*public function rules()
    {
        return [
            [['IdFuncionario', 'FechaIngreso', 'CodigoNivelSalarial', 'CodigoCondicionLaboral', 'CodigoUsuario'], 'required'],
            [['IdFuncionario', 'CodigoNivelSalarial'], 'integer'],
            [['FechaIngreso', 'FechaSalida', 'FechaHoraRegistro'], 'safe'],
            [['Observaciones'], 'string'],
            [['CodigoCondicionLaboral', 'CodigoUsuario'], 'string', 'max' => 3],
            [['CodigoEstado'], 'string', 'max' => 1],
            [['FechaIngreso', 'IdFuncionario'], 'unique', 'targetAttribute' => ['FechaIngreso', 'IdFuncionario']],
            [['CodigoNivelSalarial'], 'exist', 'skipOnError' => true, 'targetClass' => NivelSalarial::className(), 'targetAttribute' => ['CodigoNivelSalarial' => 'CodigoNivelSalarial']],
            [['CodigoEstado'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['CodigoEstado' => 'CodigoEstado']],
            [['CodigoCondicionLaboral'], 'exist', 'skipOnError' => true, 'targetClass' => CondicionLaboral::className(), 'targetAttribute' => ['CodigoCondicionLaboral' => 'CodigoCondicionLaboral']],
            [['CodigoUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['CodigoUsuario' => 'CodigoUsuario']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'IdFuncionario' => 'Id Funcionario',
            'FechaIngreso' => 'Fecha Ingreso',
            'CodigoNivelSalarial' => 'Codigo Nivel Salarial',
            'CodigoCondicionLaboral' => 'Codigo Condicion Laboral',
            'FechaSalida' => 'Fecha Salida',
            'CodigoEstado' => 'Codigo Estado',
            'Observaciones' => 'Observaciones',
            'CodigoUsuario' => 'Codigo Usuario',
            'FechaHoraRegistro' => 'Fecha Hora Registro',
        ];
    }*/

    public function getNivelSalarial()
    {
        return $this->hasOne(NivelSalarial::className(), ['CodigoNivelSalarial' => 'CodigoNivelSalarial']);
    }

    public function getCodigoEstado()
    {
        return $this->hasOne(Estado::className(), ['CodigoEstado' => 'CodigoEstado']);
    }

    public function getCondicionLaboral()
    {
        return $this->hasOne(CondicionLaboral::className(), ['CodigoCondicionLaboral' => 'CodigoCondicionLaboral']);
    }

    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['CodigoUsuario' => 'CodigoUsuario']);
    }
}
