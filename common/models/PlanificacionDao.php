<?php

namespace common\models;

use app\modules\Administracion\models\UnidadObj;
use yii\db\mssql\PDO;
use Yii;
use app\modules\Administracion\models\CargoObj;

class PlanificacionDao
{
    /*=============================================
     BUSCA CARGO
     =============================================*/
    static public function buscaCargo($tipo, $codigoCargo)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT car.CodigoCargo, car.NombreCargo, car.DescripcionCargo, car.RequisitosPrincipales, car.RequisitosOpcionales, car.ArchivoManualFunciones, car.CodigoSectorTrabajo, sec.NombreSectorTrabajo, car.CodigoEstado, car.FechaHoraRegistro, car.CodigoUsuario 
                     FROM SiacPlanificacion.dbo.Cargos car
                     INNER JOIN SectoresTrabajo sec ON car.CodigoSectorTrabajo = sec.CodigoSectorTrabajo
                     WHERE car.CodigoCargo = :codigoCargo ";
        if($tipo == "array"){
            $cargo = $dbRRHH->createCommand($consulta)
                ->bindParam(":codigoCargo", $codigoCargo, PDO::PARAM_STR)
                ->queryOne();
            return $cargo;
        }else{
            $instruccion = $dbRRHH->createCommand($consulta)
                ->bindParam(":codigoCargo", $codigoCargo, PDO::PARAM_STR);
            $lector = $instruccion->query();
            $cargo = $lector->readObject(CargoObj::className(), []);
            return $cargo;
        }
    }

    /*=============================================
    LISTA CARGOS
    =============================================*/
    static public function listaCargos($codigoSectorTrabajo,$codigoUnidad)
    {
        $dbRRHH = Yii::$app->db;
        /*$consulta = "SELECT car.CodigoCargo, car.NombreCargo, car.DescripcionCargo, car.RequisitosPrincipales, car.RequisitosOpcionales, car.ArchivoManualFunciones, car.CodigoSectorTrabajo, sec.NombreSectorTrabajo, car.CodigoEstado, car.FechaHoraRegistro, car.CodigoUsuario
                     FROM SiacPlanificacion.dbo.Cargos car
                     INNER JOIN SectoresTrabajo sec ON car.CodigoSectorTrabajo = sec.CodigoSectorTrabajo
                     WHERE car.CodigoSectorTrabajo = :codigoSectorTrabajo
                     ORDER BY car.NombreCargo";*/
        $consulta = "SELECT car.CodigoCargo, car.NombreCargo, car.DescripcionCargo, car.RequisitosPrincipales, car.RequisitosOpcionales, car.ArchivoManualFunciones, car.CodigoSectorTrabajo, sec.NombreSectorTrabajo, car.CodigoEstado, car.FechaHoraRegistro, car.CodigoUsuario 
                     FROM Cargos car
                     INNER JOIN SectoresTrabajo sec ON car.CodigoSectorTrabajo = sec.CodigoSectorTrabajo
					 INNER JOIN UnidadesCargos uc ON car.CodigoCargo = uc.Cargo
					 INNER JOIN Unidades u ON uc.Unidad = u.CodigoUnidad
                     WHERE car.CodigoSectorTrabajo = :codigoSectorTrabajo and uc.Unidad = :codigoUnidad
                     ORDER BY car.NombreCargo";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":codigoSectorTrabajo", $codigoSectorTrabajo, PDO::PARAM_STR)
            ->bindParam(":codigoUnidad", $codigoUnidad, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $cargos = [];
        while ($cargo = $lector->readObject(CargoObj::className(), [])) {
            $cargos[] = $cargo;
        }
        return $cargos;
    }

    /*=============================================
    LISTA UNIDADES
    =============================================*/
    static public function listaUnidades()
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT CodigoUnidad, NombreUnidad, NombreCorto,CodigoUnidadPadre,CodigoEstado,FechaHoraRegistro,CodigoUsuario
                     FROM Unidades u
                     ORDER BY u.CodigoUnidad";
        $instruccion = $dbRRHH->createCommand($consulta);
            //->bindParam(":codigoSectorTrabajo", $codigoSectorTrabajo, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $unidades = [];
        while ($unidad = $lector->readObject(UnidadObj::className(), [])) {
            $unidades[] = $unidad;
        }
        return $unidades;
    }
}


