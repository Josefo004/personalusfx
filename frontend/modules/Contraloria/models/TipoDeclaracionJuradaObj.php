<?php
namespace app\modules\Contraloria\models;

use yii\base\Model;

class TipoDeclaracionJuradaObj extends Model {
    private $CodigoTipoDeclaracionJurada;
    private $NombreTipoDeclaracionJurada;
    private $Frecuencia;
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