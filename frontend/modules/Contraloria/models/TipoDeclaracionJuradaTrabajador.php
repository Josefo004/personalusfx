<?php

namespace app\modules\Contraloria\models;

class TipoDeclaracionJuradaTrabajador extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'TiposDeclaracionesJuradasTrabajadores';
    }

    /*public function rules()
    {
        return [
            [['CodigoTipoDeclaracionJurada', 'CodigoTrabajador', 'FechaInicioRecordatorio', 'FechaFinRecordatorio', 'CodigoEstado', 'CodigoUsuario'], 'required'],
            [['FechaInicioRecordatorio', 'FechaFinRecordatorio', 'FechaHoraRegistro'], 'safe'],
            [['CodigoTipoDeclaracionJurada'], 'string', 'max' => 6],
            [['CodigoTrabajador'], 'string', 'max' => 10],
            [['CodigoEstado'], 'string', 'max' => 1],
            [['CodigoUsuario'], 'string', 'max' => 3],
            [['CodigoTipoDeclaracionJurada', 'CodigoTrabajador'], 'unique', 'targetAttribute' => ['CodigoTipoDeclaracionJurada', 'CodigoTrabajador']],
            [['CodigoEstado'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['CodigoEstado' => 'CodigoEstado']],
            [['CodigoUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['CodigoUsuario' => 'CodigoUsuario']],
            [['CodigoTipoDeclaracionJurada'], 'exist', 'skipOnError' => true, 'targetClass' => TipoDeclaracionJurada::className(), 'targetAttribute' => ['CodigoTipoDeclaracionJurada' => 'CodigoTipoDeclaracionJurada']],
            [['CodigoTrabajador'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajador::className(), 'targetAttribute' => ['CodigoTrabajador' => 'CodigoTrabajador']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'CodigoTipoDeclaracionJurada' => 'Codigo Tipo Declaracion Jurada',
            'CodigoTrabajador' => 'Codigo Trabajador',
            'FechaInicioRecordatorio' => 'Fecha Inicio Recordatorio',
            'FechaFinRecordatorio' => 'Fecha Fin Recordatorio',
            'CodigoEstado' => 'Codigo Estado',
            'FechaHoraRegistro' => 'Fecha Hora Registro',
            'CodigoUsuario' => 'Codigo Usuario',
        ];
    }*/

    public function isUsed()
    {
        $trabajadoresDeclaracionesJuradas = TrabajadorDeclaracionJurada::find()->where(['CodigoTipoDeclaracionJurada' => $this->CodigoTipoDeclaracionJurada])->andWhere(['CodigoTrabajador' => $this->CodigoTrabajador])->all();
        if($trabajadoresDeclaracionesJuradas != null){
            return true;
        }else{
            return false;
        }
    }

    public function exist()
    {
        $tiposDeclaracionesJuradasTrabajadores = TipoDeclaracionJuradaTrabajador::find()
            ->where(["CodigoTipoDeclaracionJurada" => $this->CodigoTipoDeclaracionJurada])
            ->andWhere(["CodigoTrabajador" => $this->CodigoTrabajador])->all();
        if(!empty($tiposDeclaracionesJuradasTrabajadores)){
            return true;
        }else{
            return false;
        }
    }

    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['CodigoEstado' => 'CodigoEstado']);
    }

    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['CodigoUsuario' => 'CodigoUsuario']);
    }

    public function getTipoDeclaracionJurada()
    {
        return $this->hasOne(TipoDeclaracionJurada::className(), ['CodigoTipoDeclaracionJurada' => 'CodigoTipoDeclaracionJurada']);
    }

    public function getTrabajador()
    {
        return $this->hasOne(Trabajador::className(), ['CodigoTrabajador' => 'CodigoTrabajador']);
    }
}
