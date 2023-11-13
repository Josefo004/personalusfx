<?php

namespace app\modules\Filiacion\models;

use Yii;

class DatoPersonaFuncionario extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'DatosPersonasFuncionarios';
    }


    /*public function rules()
    {
        return [
            [['IdPersona', 'FechaHoraActualizacion'], 'required'],
            [['FechaHoraActualizacion', 'FechaRegistroAFP', 'PrimerMesRegistroAFP', 'UltimoMesRegistroAFP'], 'safe'],
            [['ExclusionVoluntariaAFP'], 'integer'],
            [['IdPersona'], 'string', 'max' => 15],
            [['CodigoAFP'], 'string', 'max' => 1],
            [['ResolucionAFP', 'NUA'], 'string', 'max' => 10],
            [['CodigoSeguroSocial', 'CodigoBanco'], 'string', 'max' => 3],
            [['NroCuentaBancaria'], 'string', 'max' => 50],
            [['CodigoTipoRenta'], 'string', 'max' => 4],
            [['FechaHoraActualizacion', 'IdPersona'], 'unique', 'targetAttribute' => ['FechaHoraActualizacion', 'IdPersona']],
            [['CodigoAFP'], 'exist', 'skipOnError' => true, 'targetClass' => Afp::className(), 'targetAttribute' => ['CodigoAFP' => 'CodigoAfp']],
            [['CodigoBanco'], 'exist', 'skipOnError' => true, 'targetClass' => EntidadBancaria::className(), 'targetAttribute' => ['CodigoBanco' => 'CodigoBanco']],
            [['CodigoTipoRenta'], 'exist', 'skipOnError' => true, 'targetClass' => TipoRenta::className(), 'targetAttribute' => ['CodigoTipoRenta' => 'CodigoTipoRenta']],
            [['IdPersona'], 'exist', 'skipOnError' => true, 'targetClass' => Persona::className(), 'targetAttribute' => ['IdPersona' => 'IdPersona']],
            [['CodigoSeguroSocial'], 'exist', 'skipOnError' => true, 'targetClass' => SeguroSocial::className(), 'targetAttribute' => ['CodigoSeguroSocial' => 'CodigoSeguroSocial']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'IdPersona' => 'Id Persona',
            'FechaHoraActualizacion' => 'Fecha Hora Actualizacion',
            'CodigoAFP' => 'Codigo Afp',
            'ResolucionAFP' => 'Resolucion Afp',
            'FechaRegistroAFP' => 'Fecha Registro Afp',
            'PrimerMesRegistroAFP' => 'Primer Mes Registro Afp',
            'UltimoMesRegistroAFP' => 'Ultimo Mes Registro Afp',
            'ExclusionVoluntariaAFP' => 'Exclusion Voluntaria Afp',
            'NUA' => 'Nua',
            'CodigoSeguroSocial' => 'Codigo Seguro Social',
            'CodigoBanco' => 'Codigo Banco',
            'NroCuentaBancaria' => 'Nro Cuenta Bancaria',
            'CodigoTipoRenta' => 'Codigo Tipo Renta',
        ];
    }*/

    public function getAFP()
    {
        return $this->hasOne(Afp::className(), ['CodigoAfp' => 'CodigoAFP']);
    }

    public function getBanco()
    {
        return $this->hasOne(EntidadBancaria::className(), ['CodigoBanco' => 'CodigoBanco']);
    }

    public function getTipoRenta()
    {
        return $this->hasOne(TipoRenta::className(), ['CodigoTipoRenta' => 'CodigoTipoRenta']);
    }

    public function getIdPersona()
    {
        return $this->hasOne(Persona::className(), ['IdPersona' => 'IdPersona']);
    }

    public function getSeguroSocial()
    {
        return $this->hasOne(SeguroSocial::className(), ['CodigoSeguroSocial' => 'CodigoSeguroSocial']);
    }
}
