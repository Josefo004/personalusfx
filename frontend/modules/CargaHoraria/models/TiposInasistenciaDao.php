<?php


namespace app\modules\CargaHoraria\models;
use yii\db\Query;
use yii\db\mssql\PDO;
use Yii;

class TiposInasistenciaDao
{
    /*=============================================
    CORRELATIVO MAXIMO DE LOS TIPOS DE INASISTENCIA
    =============================================*/
    static public function maximoTiposInasistencia()
    {
        $consulta = new Query();
        $arrayMaximo = $consulta->select('max(CodigoTipoInasistencia) AS Maximo')
            ->from('TiposInasistencias')
            ->one();
        if (!$arrayMaximo) {
            return 0;
        } else {
            return $arrayMaximo['Maximo'];
        }
    }


    /*=============================================
   BUSCA TIPO DE INASISTENCIA
   =============================================*/
    static public function buscaTipoInasistencia($tipo, $codigoTipoInasistencia)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT CodigoTipoInasistencia, NombreTipoInasistencia, Descripcion, Sancion 
                     FROM TiposInasistencias                   
                     WHERE CodigoTipoInasistencia = :codigoTipoInasistencia ";
        if ($tipo == "array") {
            $tipoInasistencia = $dbRRHH->createCommand($consulta)
                ->bindParam(":codigoTipoInasistencia", $codigoTipoInasistencia, PDO::PARAM_STR)
                ->queryOne();
            return $tipoInasistencia;
        } else {
            $instruccion = $dbRRHH->createCommand($consulta)
                ->bindParam(":codigoTipoInasistencia", $codigoTipoInasistencia, PDO::PARAM_STR);
            $lector = $instruccion->query();
            $tipoInasistencia = $lector->readObject(TipoInasistenciaObj::className(), []);
            return $tipoInasistencia;
        }
    }

}





