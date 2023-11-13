<?php

namespace app\modules\Contraloria\models;

use yii\db\Query;
use yii\db\mssql\PDO;
use Yii;

class TiposDeclaracionesJuradasDao
{
    /*=============================================
    CORRELATIVO MAXIMO DE LOS TIPOS DECLARACIONES JURADAS
    =============================================*/
    static public function maximoTiposDeclaracionesJuradas($prefijo)
    {
        $consulta = new Query();
        $arrayMaximo = $consulta->select('max(cast(substring(CodigoTipoDeclaracionJurada, len(CodigoTipoDeclaracionJurada)-2,len(CodigoTipoDeclaracionJurada)) AS int)) AS Maximo')
            ->from('TiposDeclaracionesJuradas')
            ->where(['like', 'CodigoTipoDeclaracionJurada', [$prefijo]])
            ->one();
        if (!$arrayMaximo) {
            return 0;
        } else {
            return $arrayMaximo['Maximo'];
        }
    }

    /*=============================================
    BUSCA TIPO DECLARACION JURADA
    =============================================*/
    static public function buscaTipoDeclaracionJurada($tipo, $codigoTipoDeclaracionJurada)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT tip.CodigoTipoDeclaracionJurada, tip.NombreTipoDeclaracionJurada, tip.Frecuencia, tip.CodigoEstado, tip.FechaHoraRegistro, tip.CodigoUsuario 
                     FROM TiposDeclaracionesJuradas tip                     
                     WHERE CodigoTipoDeclaracionJurada = :codigoTipoDeclaracionJurada ";
        if ($tipo == "array") {
            $tipoDeclaracionJurada = $dbRRHH->createCommand($consulta)
                ->bindParam(":codigoTipoDeclaracionJurada", $codigoTipoDeclaracionJurada, PDO::PARAM_STR)
                ->queryOne();
            return $tipoDeclaracionJurada;
        } else {
            $instruccion = $dbRRHH->createCommand($consulta)
                ->bindParam(":codigoTipoDeclaracionJurada", $codigoTipoDeclaracionJurada, PDO::PARAM_STR);
            $lector = $instruccion->query();
            $tipoDeclaracionJurada = $lector->readObject(TipoDeclaracionJuradaObj::className(), []);
            return $tipoDeclaracionJurada;
        }
    }

    /*=============================================
    LISTA TIPOS DECLARACIONES JURADAS TRABAJADOR
    =============================================*/
    static public function listaTiposDeclaracionesJuradasTrabajador($codigoTrabajador)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT tip.CodigoTipoDeclaracionJurada, tip.NombreTipoDeclaracionJurada, tip.Frecuencia, tip.CodigoEstado, tip.FechaHoraRegistro, tip.CodigoUsuario 
                     FROM TiposDeclaracionesJuradasTrabajadores tiptra
                     INNER JOIN TiposDeclaracionesJuradas tip ON tiptra.CodigoTipoDeclaracionJurada = tip.CodigoTipoDeclaracionJurada                                          
                     WHERE  tiptra.CodigoTrabajador = :codigoTrabajador ";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":codigoTrabajador", $codigoTrabajador, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $tiposDeclaracionesJuradas = [];
        while ($tipoDeclaracionJurada = $lector->readObject(TipoDeclaracionJuradaObj::className(), [])){
            $tiposDeclaracionesJuradas[] = $tipoDeclaracionJurada;
        }
        return $tiposDeclaracionesJuradas;
    }
}