<?php

namespace app\modules\Administracion\models;

use Yii;

class PaisesDao
{
    /*=============================================
    GENERA UN NUEVO CODIGO DE PAIS
    =============================================*/
    static public function generarCodigoPais()
    {
        $dbSiacPersonal = Yii::$app->db;
        $consulta = "SELECT max(CodigoPais) AS UltimoCodigoPais
                     FROM Paises";
        $instruccion = $dbSiacPersonal->createCommand($consulta);
        $arrayMaximo = $instruccion->queryOne();
        if (!$arrayMaximo) {
            return 1;
        } else {
            return $arrayMaximo['UltimoCodigoPais'] + 1;
        }
    }    

    /*=============================================
     LISTA PAISES SIAC PERSONAL
     =============================================*/
    static public function listaPaises()
    {
        $dbSiacPersonal = Yii::$app->db;
        $consulta = "SELECT CodigoPais, upper(rtrim(NombrePais)) AS NombrePais, CodigoPaisAcad, upper(rtrim(Nacionalidad)) AS Nacionalidad, CodigoEstado
                     FROM Paises
					 ORDER BY NombrePais";
        $instruccion = $dbSiacPersonal->createCommand($consulta);
        $lector = $instruccion->query();
        $paises = [];
        while ($pais = $lector->readObject(PaisObj::className(), [])) {
            $paises[] = $pais;
        }
        return $paises;
    }
}