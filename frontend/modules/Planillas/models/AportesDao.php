<?php

namespace app\modules\Planillas\models;

use app\modules\Planillas\models\AportesObj;

use Yii;

class AportesDao {
    static public function listarAportes()
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT apl.CodigoAporteLey, apl.NombreAporteLey, UPPER(apl.TipoAporte) as TipoAporte, FORMAT(apl.Porcentaje, 'N', 'en-us') Porcentaje, apl.MontoSalario, apl.Observaciones, apl.CodigoEstado, est.NombreEstado, apl.FechaHoraRegistro, apl.CodigoUsuario 
                     FROM AportesLey as apl, Estados as est 
                     WHERE apl.CodigoEstado = est.CodigoEstado;";
        $instruccion = $dbRRHH->createCommand($consulta);
        $lector = $instruccion->query();
        $aportes = [];

        while ($aporte = $lector->readObject(AportesObj::class, [])) {
            $aportes[] = $aporte;
        }
        return $aportes;
    }

    static public function contarAportes(){
        $re=0;
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT count(*) as total FROM AportesLey;";
        $instruccion = $dbRRHH->createCommand($consulta);
        $lector = $instruccion->query();
        $re = $lector->count();
        return $re;
    }
}