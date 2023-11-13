<?php

namespace app\modules\Administracion\models;

use yii\db\mssql\PDO;
use Yii;
use yii\db\Query;

class LugaresDao
{
    /*========================================
    GENERA UN NUEVO CODIGO DE LUGAR
    ==========================================*/
    static public function generarCodigoLugar()
    {
        $dbSiacPersonal = Yii::$app->db;
        $consulta = "SELECT max(CodigoLugar) AS UltimoCodigoLugar
                     FROM Lugares";
        $instruccion = $dbSiacPersonal->createCommand($consulta);
        $arrayMaximo = $instruccion->queryOne();
        if (!$arrayMaximo) {
            return 0;
        } else {
            return $arrayMaximo['UltimoCodigoLugar'] + 1;
        }
    }

    /*=============================================
     LISTA LUGARES SIAC PERSONAL
     =============================================*/
    static public function listaLugares()
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT p.NombrePais, d.NombreDepartamento, pr.NombreProvincia, l.CodigoLugar, l.NombreLugar, 
                            l.CodigoProvincia, l.CodigoPaisAcad, l.CodigoDepartamentoAcad, l.CodigoProvinciaAcad,
		                    l.CodigoLugarAcad, l.IdLugarAcad, l. CodigoEstado 
                     FROM Lugares l
                     INNER JOIN Provincias pr ON l.CodigoProvincia = pr.CodigoProvincia
                     INNER JOIN Departamentos d ON pr.CodigoDepartamento = d.CodigoDepartamento
                     INNER JOIN Paises p ON d.CodigoPais = p.CodigoPais
                     ORDER BY d.CodigoPais, l.CodigoProvincia, l.CodigoLugar";
        $instruccion = $dbRRHH->createCommand($consulta);
        $lector = $instruccion->query();
        $lugares = [];
        while ($lugar = $lector->readObject(LugarObj::className(), [])) {
            $lugares[] = $lugar;
        }
        return $lugares;
    }
}
