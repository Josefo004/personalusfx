<?php

namespace app\modules\CargaHoraria\models;;

use yii\db\mssql\PDO;
use Yii;

class CarrerasDao
{
    /*=============================================
    LISTA CARRERAS
    =============================================*/
    static public function listaCarreras()
    {
        $dbAcad = Yii::$app->dbc;
        $consulta = "SELECT car.CodigoCarrera, car.NombreCarrera
                     FROM Carreras car
                     WHERE car.CodigoCarrera not in(10, 15, 16, 29, 39, 46, 47, 48, 53, 58, 59, 60, 63, 65, 66, 68, 71, 73, 75, 76, 77, 83, 85, 86, 87, 88, 89, 90, 91, 93, 94, 97, 98, 102, 113)                     
                     ORDER BY car.NombreCarrera ";
        $instruccion = $dbAcad->createCommand($consulta);
        $lector = $instruccion->query();
        $facultades = [];
        while ($facultad = $lector->readObject(CarreraObj::className(), [])) {
            $facultades[] = $facultad;
        }
        return $facultades;
    }

    /*=============================================
    LISTA CARRERAS DE UNA FACULTAD
    =============================================*/
    static public function listaCarrerasFacultad($codigoFacultad)
    {
        $dbAcad = Yii::$app->dbAcad;
        $consulta = "SELECT car.CodigoCarrera, car.NombreCarrera
                     FROM Carreras car
                     WHERE car.CodigoFacultad = :codigoFacultad AND
                           car.CodigoCarrera not in(10, 15, 16, 29, 39, 46, 47, 48, 53, 58, 59, 60, 63, 65, 66, 68, 71, 73, 75, 76, 77, 83, 85, 86, 87, 88, 89, 90, 91, 93, 94, 97, 98, 102, 113)                                          
                     ORDER BY car.NombreCarrera ";
        $instruccion = $dbAcad->createCommand($consulta)
            ->bindParam(":codigoFacultad", $codigoFacultad, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $facultades = [];
        while ($facultad = $lector->readObject(CarreraObj::className(), [])) {
            $facultades[] = $facultad;
        }
        return $facultades;
    }

    /*=============================================
    LISTA SEDES DE UNA CARRERA
    =============================================*/
    static public function listaSedesCarrera($codigoCarrera)
    {
        $dbRRHH = Yii::$app->dbAcad;
        $consulta = "SELECT DISTINCT sed.CodigoSede, UPPER(sed.NombreSede) as NombreSede
                     FROM Sedes sed
                     INNER JOIN CarrerasSedes car ON sed.CodigoSede = car.CodigoSede
                     WHERE car.CodigoCarrera = :codigoCarrera";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":codigoCarrera", $codigoCarrera, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $sedes = [];
        while ($sede = $lector->readObject(SedeObj::className(), [])) {
            $sedes[] = $sede;
        }
        return $sedes;
    }
}