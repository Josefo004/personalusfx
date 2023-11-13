<?php

namespace app\modules\Filiacion\models;

use app\modules\Administracion\models\CondicionLaboral;
use app\modules\Administracion\models\Item;
use app\modules\Administracion\models\NivelSalarial;
use app\modules\Administracion\models\TiempoTrabajo;
use app\modules\Administracion\models\TipoDocumento;
use app\modules\Administracion\models\Unidad;
use common\models\Estado;
use common\models\Usuario;

class Asignacion extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'AsignacionesAdministrativos';
    }

    public function exist()
    {
        $a = Asignacion::find()->where(["CodigoTrabajador"=>$this->CodigoTrabajador,"CodigoCondicionLaboral"=>$this->CodigoCondicionLaboral])->all();
        if ($a){
            return true;
        } else {
            return false;
        }
        /*$asignaciones = Asignacion::find()->where(["CodigoSectorTrabajo" => $this->CodigoSectorTrabajo])
            ->andWhere(["CodigoTrabajador" => $this->CodigoTrabajador])->all();
        if(!empty($asignaciones)){
            return true;
        }else{
            return false;
        }*/
    }



    public function isUsed()
    {
        $item = Item::findOne(['NroItem' => $this->NroItem]);
        if($item != null){
            return true;
        }else{
            return false;
        }
    }

    public function getCondicionLaboral()
    {
        return $this->hasOne(CondicionLaboral::className(), ['CodigoCondicionLaboral' => 'CodigoCondicionLaboral']);
    }

    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['CodigoEstado' => 'CodigoEstado']);
    }

    public function getItem()
    {
        return $this->hasOne(Item::className(), ['NroItem' => 'NroItem']);
    }

    public function getCodigoTrabajador()
    {
        return $this->hasOne(Trabajador::className(), ['CodigoTrabajador' => 'CodigoTrabajador']);
    }

    public function getCodigoNivelSalarial()
    {
        return $this->hasOne(NivelSalarial::className(), ['CodigoNivelSalarial' => 'CodigoNivelSalarial']);
    }

    public function getUnidad()
    {
        return $this->hasOne(Unidad::className(), ['CodigoUnidad' => 'CodigoUnidad']);
    }

    public function getCargo()
    {
        return $this->hasOne(Cargo::className(), ['CodigoCargo' => 'CodigoCargo']);
    }

    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['CodigoUsuario' => 'CodigoUsuario']);
    }

    public function getTipoDocumento()
    {
        return $this->hasOne(TipoDocumento::className(), ['CodigoTipoDocumento' => 'CodigoTipoDocumento']);
    }

    public function getTiempoTrabajo()
    {
        return $this->hasOne(TiempoTrabajo::className(), ['CodigoTiempoTrabajo' => 'CodigoTiempoTrabajo']);
    }
}
