<?php

namespace app\modules\Contraloria\models;

class TrabajadorDeclaracionJurada extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'TrabajadoresDeclaracionesJuradas';
    }

   /* public function rules()
    {
        return [
            [['CodigoDeclaracionJurada', 'Gestion', 'Mes', 'FechaNotificacion', 'FechaRecepcion', 'CodigoTrabajador', 'CodigoTipoDeclaracionJurada', 'CodigoUsuario'], 'required'],
            [['Gestion', 'Mes'], 'integer'],
            [['FechaInicioRecordatorio', 'FechaFinRecordatorio', 'FechaNotificacion', 'FechaRecepcion', 'FechaHoraRegistro'], 'safe'],
            [['CodigoDeclaracionJurada'], 'string', 'max' => 30],
            [['Observacion'], 'string', 'max' => 100],
            [['CodigoTrabajador'], 'string', 'max' => 10],
            [['CodigoTipoDeclaracionJurada'], 'string', 'max' => 6],
            [['CodigoUsuario'], 'string', 'max' => 3],
            [['CodigoDeclaracionJurada'], 'unique'],
            [['CodigoUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['CodigoUsuario' => 'CodigoUsuario']],
            [['CodigoTipoDeclaracionJurada'], 'exist', 'skipOnError' => true, 'targetClass' => TipoDeclaracionJurada::className(), 'targetAttribute' => ['CodigoTipoDeclaracionJurada' => 'CodigoTipoDeclaracionJurada']],
            [['CodigoTrabajador'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajador::className(), 'targetAttribute' => ['CodigoTrabajador' => 'CodigoTrabajador']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'CodigoDeclaracionJurada' => 'Codigo Declaracion Jurada',
            'Gestion' => 'Gestion',
            'Mes' => 'Mes',
            'FechaInicioRecordatorio' => 'Fecha Inicio Recordatorio',
            'FechaFinRecordatorio' => 'Fecha Fin Recordatorio',
            'FechaNotificacion' => 'Fecha Notificacion',
            'FechaRecepcion' => 'Fecha Recepcion',
            'Observacion' => 'Observacion',
            'CodigoTrabajador' => 'Codigo Trabajador',
            'CodigoTipoDeclaracionJurada' => 'Codigo Tipo Declaracion Jurada',
            'FechaHoraRegistro' => 'Fecha Hora Registro',
            'CodigoUsuario' => 'Codigo Usuario',
        ];
    }*/

    public function exist()
    {
        $trabajadoresDeclaracionesJuradas = TrabajadorDeclaracionJurada::find()->where(["CodigoDeclaracionJurada" => $this->CodigoDeclaracionJurada])->all();
        if(!empty($trabajadoresDeclaracionesJuradas)){
            return true;
        }else{
            return false;
        }
    }


    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['CodigoUsuario' => 'CodigoUsuario']);
    }

    public function getTipoDeclaracionJuradaTrabajador()
    {
        return $this->hasOne(TipoDeclaracionJuradaTrabajador::className(), ['CodigoTipoDeclaracionJurada' => 'CodigoTipoDeclaracionJurada', 'CodigoTrabajador' => 'CodigoTrabajador']);
    }
}
