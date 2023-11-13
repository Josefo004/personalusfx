<?php


namespace app\modules\frontend\models;
use yii\base\Model;


class TipoInasistenciaObj extends Model
{
    private $CodigoTipoInasistencia;
    private $NombreTipoInasistencia;
    private $Descripcion;
    private $Sancion;
    private $CodigoEstado;
    private $FechaHoraRegistro;
    private $CodigoUsuario;
    public function __get($property){
        if(property_exists($this, $property)) {
            return $this->$property;
        }
    }
    public function __set($property, $value){
        if(property_exists($this, $property)) {
            $this->$property = $value;
        }
    }


}