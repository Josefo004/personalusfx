<?php

//namespace frontend\models;
namespace app\modules\CargaHoraria\models;

use Yii;

class FacultadesDao
{
    /*=============================================
    LISTA FACULTADES
    =============================================*/
    static public function listaFacultades()
    {
        $dbAcad = Yii::$app->dbAcad;
        $consulta = "SELECT fac.CodigoFacultad, fac.NombreFacultad
                     FROM Facultades fac
                     WHERE fac.CodigoFacultad not in('CE')                     
                     ORDER BY fac.NombreFacultad ";
        $instruccion = $dbAcad->createCommand($consulta);
        $lector = $instruccion->query();
        $facultades = [];
        while ($facultad = $lector->readObject(FacultadObj::className(), [])) {
            $facultades[] = $facultad;
        }
        return $facultades;
    }
}