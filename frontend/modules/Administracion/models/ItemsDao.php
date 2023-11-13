<?php

namespace app\modules\Administracion\models;

use yii\db\Query;
use yii\db\mssql\PDO;
use Yii;


class ItemsDao
{

    /*=============================================
    CORRELATIVO MAXIMO DE LOS ITEMS
    =============================================*/
    static public function maximoItems()
    {
        $consulta = new Query();

        $arrayMaximo = $consulta->select('max(NroItem) AS Maximo')
            ->from('Items')
            ->one();
        if (!$arrayMaximo) {
            return 0;
        } else {
            return $arrayMaximo['Maximo'];
        }

    }

    /*==================================================
    LISTA ITEMS
    ==================================================*/
    static public function listaItems()
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT ite.NroItem, ite.NroItemRrhh, ite.NroItemPlanillas, sec.CodigoSectorTrabajo, sec.NombreSectorTrabajo, car.CodigoCargo, car.NombreCargo, ite.CodigoCargoDependencia, cardep.NombreCargo AS  NombreCargoDependencia, uni.NombreUnidad,
                     isnull(unipad.CodigoUnidad,'') AS CodigoUnidadPadre, isnull(unipad.NombreUnidad,'') AS NombreUnidadPadre, ite.CodigoEstado, ite.FechaHoraRegistro, ite.CodigoUsuario
                     FROM Items ite
                     INNER JOIN Cargos car on ite.CodigoCargo = car.CodigoCargo
                     LEFT JOIN Cargos cardep on ite.CodigoCargoDependencia = cardep.CodigoCargo
                     INNER JOIN Unidades uni on ite.CodigoUnidad = uni.CodigoUnidad
                     LEFT JOIN Unidades unipad on uni.CodigoUnidadPadre = unipad.CodigoUnidad
                     INNER JOIN SectoresTrabajo sec on car.CodigoSectorTrabajo = sec.CodigoSectorTrabajo ";
        /*$consulta = "SELECT ite.NroItem, ite.NroItemRrhh, ite.NroItemPlanillas, sec.CodigoSectorTrabajo, sec.NombreSectorTrabajo, car.CodigoCargo, car.NombreCargo, ite.CodigoCargoDependencia, cardep.NombreCargo AS  NombreCargoDependencia, uni.NombreUnidad,
                     isnull(unipad.CodigoUnidad,'') AS CodigoUnidadPadre, isnull(unipad.NombreUnidad,'') AS NombreUnidadPadre, ite.CodigoEstado, ite.FechaHoraRegistro, ite.CodigoUsuario
                     FROM Items ite
                     INNER JOIN SiacPlanificacion.dbo.Cargos car on ite.CodigoCargo = car.CodigoCargo
                     LEFT JOIN SiacPlanificacion.dbo.Cargos cardep on ite.CodigoCargoDependencia = cardep.CodigoCargo
                     INNER JOIN SiacPlanificacion.dbo.Unidades uni on ite.CodigoUnidad = uni.CodigoUnidad
                     LEFT JOIN SiacPlanificacion.dbo.Unidades unipad on uni.CodigoUnidadPadre = unipad.CodigoUnidad
                     INNER JOIN SectoresTrabajo sec on car.CodigoSectorTrabajo = sec.CodigoSectorTrabajo";*/
        $instruccion = $dbRRHH->createCommand($consulta);
        $lector = $instruccion->query();
        $items = [];
        while ($item = $lector->readObject(ItemObj::className(), [])) {
            $items[] = $item;
        }
        return $items;
    }

    /*=============================================
    BUSCA ITEM
    =============================================*/
    static public function buscaItem($tipo, $nroItem)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT ite.NroItem, ite.NroItemRrhh, ite.NroItemPlanillas, sec.CodigoSectorTrabajo, sec.NombreSectorTrabajo, car.CodigoCargo, car.NombreCargo, ite.CodigoCargoDependencia, cardep.NombreCargo AS  NombreCargoDependencia,
                     uni.CodigoUnidad, uni.NombreUnidad, isnull(unipad.CodigoUnidad,'') AS CodigoUnidadPadre, isnull(unipad.NombreUnidad,'') AS NombreUnidadPadre, ite.CodigoEstado, ite.FechaHoraRegistro, ite.CodigoUsuario
                     FROM Items ite
                     INNER JOIN Cargos car on ite.CodigoCargo = car.CodigoCargo
                     LEFT JOIN Cargos cardep on ite.CodigoCargoDependencia = cardep.CodigoCargo
                     INNER JOIN Unidades uni on ite.CodigoUnidad = uni.CodigoUnidad
                     LEFT JOIN Unidades unipad on uni.CodigoUnidadPadre = unipad.CodigoUnidad
                     INNER JOIN SectoresTrabajo sec on car.CodigoSectorTrabajo = sec.CodigoSectorTrabajo
                     WHERE NroItem = :nroItem ";
        /*$consulta = "SELECT ite.NroItem, ite.NroItemRrhh, ite.NroItemPlanillas, sec.CodigoSectorTrabajo, sec.NombreSectorTrabajo, car.CodigoCargo, car.NombreCargo, ite.CodigoCargoDependencia, cardep.NombreCargo AS  NombreCargoDependencia,
                     uni.CodigoUnidad, uni.NombreUnidad, isnull(unipad.CodigoUnidad,'') AS CodigoUnidadPadre, isnull(unipad.NombreUnidad,'') AS NombreUnidadPadre, ite.CodigoEstado, ite.FechaHoraRegistro, ite.CodigoUsuario
                     FROM Items ite
                     INNER JOIN SiacPlanificacion.dbo.Cargos car on ite.CodigoCargo = car.CodigoCargo
                     LEFT JOIN SiacPlanificacion.dbo.Cargos cardep on ite.CodigoCargoDependencia = cardep.CodigoCargo
                     INNER JOIN SiacPlanificacion.dbo.Unidades uni on ite.CodigoUnidad = uni.CodigoUnidad
                     LEFT JOIN SiacPlanificacion.dbo.Unidades unipad on uni.CodigoUnidadPadre = unipad.CodigoUnidad
                     INNER JOIN SectoresTrabajo sec on car.CodigoSectorTrabajo = sec.CodigoSectorTrabajo
                     WHERE NroItem = :nroItem";*/
        if ($tipo == "array") {
            $item = $dbRRHH->createCommand($consulta)
                ->bindParam(":nroItem", $nroItem, PDO::PARAM_INT)
                ->queryOne();
            return $item;
        } else {
            $instruccion = $dbRRHH->createCommand($consulta)
                ->bindParam(":nroItem", $nroItem, PDO::PARAM_INT);
            $lector = $instruccion->query();
            $item = $lector->readObject(ItemObj::className(), []);
            return $item;
        }
    }
}