<?php

namespace app\modules\Administracion\models;

use common\models\CondicionLaboral;
use yii\db\Query;
use yii\db\mssql\PDO;
use Yii;

class NivelesSalarialesDao
{
    /*=============================================
    CORRELATIVO MAXIMO DE LOS NIVELES
    =============================================*/
    static public function maximoNivelesSalariales()
    {
        $consulta = new Query();
        $arrayMaximo = $consulta->select('max(CodigoNivelSalarial) AS Maximo')
            ->from('NivelesSalariales')
            ->one();
        if (!$arrayMaximo) {
            return 0;
        } else {
            return $arrayMaximo['Maximo'];
        }
    }

    /*=============================================
    BUSCA NIVEL
    =============================================*/
    static public function buscaNivelSalarial($tipo, $codigoNivelSalarial)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT niv.CodigoNivelSalarial, niv.NombreNivelSalarial, niv.DescripcionNivelSalarial, niv.HaberBasico, niv.PuntosEscalafon, sec.CodigoSectorTrabajo, sec.NombreSectorTrabajo, niv.CodigoEstado, niv.CodigoUsuario
                     FROM NivelesSalariales niv
                     INNER JOIN SectoresTrabajo sec ON niv.CodigoSectorTrabajo = sec.CodigoSectorTrabajo
                     WHERE niv.CodigoNivelSalarial = :codigoNivelSalarial";
        if($tipo == "array"){
            $nivel = $dbRRHH->createCommand($consulta)
                ->bindParam(":codigoNivelSalarial", $codigoNivelSalarial, PDO::PARAM_STR)
                ->queryOne();
            return $nivel;
        }else{
            $instruccion = $dbRRHH->createCommand($consulta)
                ->bindParam(":codigoNivelSalarial", $codigoNivelSalarial, PDO::PARAM_STR);
            $lector = $instruccion->query();
            $nivel = $lector->readObject(NivelSalarialObj::className(), []);
            return $nivel;
        }
    }
}