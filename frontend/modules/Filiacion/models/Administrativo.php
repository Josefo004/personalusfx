<?php

namespace app\modules\Filiacion\models;

use Yii;

class Administrativo extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'Administrativos';
    }

    /*public function rules()
    {
        return [
            [['IdFuncionario', 'IdItem', 'FechaIngreso', 'CodigoCondicionLaboral', 'CodigoTiempoTrabajo', 'CodigoUsuario'], 'required'],
            [['IdFuncionario', 'IdItem', 'CodigoNivelSalarial'], 'integer'],
            [['FechaIngreso', 'FechaSalida', 'FechaHoraRegistro'], 'safe'],
            [['Observaciones'], 'string'],
            [['CodigoCondicionLaboral', 'CodigoUsuario'], 'string', 'max' => 3],
            [['NroMemorando'], 'string', 'max' => 25],
            [['CodigoTiempoTrabajo'], 'string', 'max' => 2],
            [['CodigoEstado'], 'string', 'max' => 1],
            [['FechaIngreso', 'IdFuncionario', 'IdItem'], 'unique', 'targetAttribute' => ['FechaIngreso', 'IdFuncionario', 'IdItem']],
            [['CodigoNivelSalarial'], 'exist', 'skipOnError' => true, 'targetClass' => NivelesSalariales::className(), 'targetAttribute' => ['CodigoNivelSalarial' => 'CodigoNivelSalarial']],
            [['CodigoEstado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['CodigoEstado' => 'CodigoEstado']],
            [['CodigoCondicionLaboral'], 'exist', 'skipOnError' => true, 'targetClass' => CondicionesLaborales::className(), 'targetAttribute' => ['CodigoCondicionLaboral' => 'CodigoCondicionLaboral']],
            [['IdItem'], 'exist', 'skipOnError' => true, 'targetClass' => Items::className(), 'targetAttribute' => ['IdItem' => 'IdItem']],
            [['CodigoTiempoTrabajo'], 'exist', 'skipOnError' => true, 'targetClass' => TiemposTrabajo::className(), 'targetAttribute' => ['CodigoTiempoTrabajo' => 'CodigoTiempoTrabajo']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'IdFuncionario' => 'Id Funcionario',
            'IdItem' => 'Id Item',
            'FechaIngreso' => 'Fecha Ingreso',
            'CodigoNivelSalarial' => 'Codigo Nivel Salarial',
            'CodigoCondicionLaboral' => 'Codigo Condicion Laboral',
            'FechaSalida' => 'Fecha Salida',
            'NroMemorando' => 'Nro Memorando',
            'CodigoTiempoTrabajo' => 'Codigo Tiempo Trabajo',
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

    public function getItem()
    {
        return $this->hasOne(Item::className(), ['IdItem' => 'IdItem']);
    }

    public function getTiempoTrabajo()
    {
        return $this->hasOne(TiempoTrabajo::className(), ['CodigoTiempoTrabajo' => 'CodigoTiempoTrabajo']);
    }
}
