<?php

namespace app\modules\Administracion\models;

use yii\db\mssql\PDO;
use Yii;
use yii\db\Query;

class ProvinciasDao
{
    /*===================================
    GENERA UN NUEVO CODIGO DE PROVINCIA
    =====================================*/
    static public function generarCodigoProvincia()
    {
        $dbSiacPersonal = Yii::$app->db;
        $consulta = "SELECT max(CodigoProvincia) AS UltimoCodigoProvincia
                     FROM Provincias";
        $instruccion = $dbSiacPersonal->createCommand($consulta);
        $arrayMaximo = $instruccion->queryOne();
        if (!$arrayMaximo) {
            return 1;
        } else {
            return $arrayMaximo['UltimoCodigoProvincia'] + 1;
        }
    }

    /*=============================================
     LISTA PROVINCIAS SIAC PERSONAL
     =============================================*/
    static public function listaProvincias()
    {
        $dbRRHH = Yii::$app->db;
        $consulta = " SELECT  pro.CodigoProvincia, pro.NombreProvincia, pro.CodigoDepartamento, pro.CodigoPaisAcad, pro.CodigoDepartamentoAcad, pro.CodigoProvinciaAcad, pro.CodigoEstado, pai.NombrePais, dep.NombreDepartamento
                      FROM Provincias pro
                      INNER JOIN Departamentos dep ON pro.CodigoDepartamento = dep.CodigoDepartamento
                      INNER JOIN Paises pai ON dep.CodigoPais = pai.CodigoPais
                      ORDER BY pai.NombrePais, dep.NombreDepartamento, pro.NombreProvincia ";
        $instruccion = $dbRRHH->createCommand($consulta);
        $lector = $instruccion->query();
        $provincias = [];
        while ($provincia = $lector->readObject(ProvinciaObj::className(), [])){
            $provincias[] = $provincia;
        }
        return $provincias;
    }
}