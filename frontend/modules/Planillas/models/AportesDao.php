<?php

namespace app\modules\Planillas\models;

use app\modules\Planillas\models\AportesObj;

use Yii;

class AportesDao {
    static public function listarAportes()
    {
        //$consulta = Aporte::find()->joinWith('estado', true, 'INNER JOIN')->asArray()->all();

        // $consulta = (new \yii\db\Query())
        //             ->select("*")
        //             ->from('AportesLey as apl')
        //             ->leftJoin('Estados as est', 'apl.codigoEstado = est.CodigoEstado')
        //             ->column();
        
        // return $consulta;
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT apl.codigoAporteLey, apl.nombreAporteLey, UPPER(apl.tipoAporte) as tipoAporte, FORMAT(apl.porcentaje, 'N', 'en-us') porcentaje, apl.montoSalario, 
        apl.observaciones, apl.codigoEstado, est.NombreEstado, apl.fechaInicio, apl.fechaFin, apl.fechaRegistro, apl.codigoUsuario 
        FROM AportesLey apl   
        JOIN Estados est ON apl.codigoEstado = est.CodigoEstado;";
        $instruccion = $dbRRHH->createCommand($consulta);
        $lector = $instruccion->query();
        $aportes = [];

        while ($aporte = $lector->readObject(AportesObj::class, [])) {
            $aportes[] = $aporte;
        }
        return $aportes;
    }

    // static public function contarAportes(){
    //     $re=0;
    //     $dbRRHH = Yii::$app->db;
    //     $consulta = "SELECT count(*) as total FROM AportesLey;";
    //     $instruccion = $dbRRHH->createCommand($consulta);
    //     $lector = $instruccion->query();
    //     $re = $lector->count();
    //     return $re;
    // }
}