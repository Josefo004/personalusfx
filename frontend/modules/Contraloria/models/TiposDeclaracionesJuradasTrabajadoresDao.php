<?php

namespace app\modules\Contraloria\models;

use yii\db\mssql\PDO;
use Yii;

class TiposDeclaracionesJuradasTrabajadoresDao
{
    /*=============================================
    BUSCA TIPO DECLARACION JURADA TRABAJADOR
    =============================================*/
    static public function buscaTipoDeclaracionJuradaTrabajador($tipo, $codigoTipoDeclaracionJurada, $codigoTrabajador)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT tip.CodigoTipoDeclaracionJurada, tip.NombreTipoDeclaracionJurada, tip.Frecuencia, tra.CodigoTrabajador, per.IdPersona, per.Paterno, per.Materno, per.Nombres, isnull(per.Paterno,'')+' '+isnull(per.Materno,'')+' '+per.Nombres AS NombreCompleto, per.FechaNacimiento, 
                     tiptra.FechaInicioRecordatorio, tiptra.FechaFinRecordatorio, tiptra.CodigoEstado, tiptra.FechaHoraRegistro, tiptra.CodigoUsuario 
                     FROM TiposDeclaracionesJuradasTrabajadores tiptra
                     INNER JOIN TiposDeclaracionesJuradas tip ON tiptra.CodigoTipoDeclaracionJurada = tip.CodigoTipoDeclaracionJurada
                     INNER JOIN Trabajadores tra ON tiptra.CodigoTrabajador = tra.CodigoTrabajador
                     INNER JOIN Personas per ON tra.IdPersona = per.IdPersona
                     WHERE  tiptra.CodigoTipoDeclaracionJurada = :codigoTipoDeclaracionJurada AND tiptra.CodigoTrabajador = :codigoTrabajador ";
        if ($tipo == "array") {
            $tipoDeclaracionJuradaTrabajador = $dbRRHH->createCommand($consulta)
                ->bindParam(":codigoTipoDeclaracionJurada", $codigoTipoDeclaracionJurada, PDO::PARAM_STR)
                ->bindParam(":codigoTrabajador", $codigoTrabajador, PDO::PARAM_STR)
                ->queryOne();
            return $tipoDeclaracionJuradaTrabajador;
        } else {
            $instruccion = $dbRRHH->createCommand($consulta)
                ->bindParam(":codigoTipoDeclaracionJurada", $codigoTipoDeclaracionJurada, PDO::PARAM_STR)
                ->bindParam(":codigoTrabajador", $codigoTrabajador, PDO::PARAM_STR);
            $lector = $instruccion->query();
            $tipoDeclaracionJuradaTrabajador = $lector->readObject(TipoDeclaracionJuradaTrabajadorObj::className(), []);
            return $tipoDeclaracionJuradaTrabajador;
        }
    }
/*==================================================
LISTA TODOS LOS TRABAJADORES VIGENTES Y EN FUNCIONES
==================================================*/
    static public function listaDeclaracionJuradaTrabajador($mes, $gestion)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT t.CodigoTrabajador, p.IdPersona, p.Paterno,
				p.Materno, p.Nombres, isnull(p.Paterno,'')+' '+isnull(p.Materno,'')+' '+p.Nombres AS NombreCompleto, djp.Celular, p.FechaNacimiento, 
                      tdjt.FechaInicioRecordatorio,tdjt.FechaFinRecordatorio
                FROM Personas p
                INNER JOIN Trabajadores AS t ON (p.IdPersona = t.IdPersona)
                INNER JOIN DeclaracionJuradaRRHH.dbo.persona djp ON (t.Idpersona = djp.id_persona)
                INNER JOIN TiposDeclaracionesJuradasTrabajadores AS tdjt ON(t.CodigoTrabajador = tdjt.CodigoTrabajador )
                INNER JOIN TiposDeclaracionesJuradas AS tidj ON(tdjt.CodigoTipoDeclaracionJurada = tidj.CodigoTipoDeclaracionJurada)
				WHERE MONTH(p.FechaNacimiento) = :mes AND YEAR(tdjt.FechaFinRecordatorio) = :gestion
                ORDER BY DAY(p.FechaNacimiento), p.Paterno, p.Materno, p.Nombres";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":mes", $mes, PDO::PARAM_STR)
            ->bindParam(":gestion", $gestion, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $reportes = [];
        while ($reporte = $lector->readObject(TipoDeclaracionJuradaTrabajadorObj::className(), [])) {
            $reportes[] = $reporte;
        }
        return $reportes;
    }
}