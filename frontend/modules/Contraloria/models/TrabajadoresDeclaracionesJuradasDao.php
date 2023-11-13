<?php

namespace app\modules\Contraloria\models;

use yii\db\mssql\PDO;
use Yii;

class TrabajadoresDeclaracionesJuradasDao
{
    /*=============================================
    BUSCA TRABAJADOR DECLARACION JURADA
    =============================================*/
    static public function buscaTrabajadorDeclaracionJurada($tipo, $codigoDeclaracionJurada)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT tradec.CodigoDeclaracionJurada, tradec.CodigoTrabajador, per.IdPersona, per.Paterno, per.Materno, per.Nombres, isnull(per.Paterno,'')+' '+isnull(per.Materno,'')+' '+per.Nombres AS NombreCompleto,
					 tipo.CodigoTipoDeclaracionJurada, tipo.NombreTipoDeclaracionJurada, tradec.Gestion, tradec.Mes, tradec.FechaInicioRecordatorio, tradec.FechaFinRecordatorio, tradec.FechaNotificacion, tradec.FechaRecepcion,
					 tradec.Observacion, tradec.FechaHoraRegistro, tradec.CodigoUsuario
					 FROM TrabajadoresDeclaracionesJuradas tradec
					 INNER JOIN Trabajadores tra ON tra.CodigoTrabajador = tradec.CodigoTrabajador
					 INNER JOIN Personas per ON tra.IdPersona = per.IdPersona
					 INNER JOIN TiposDeclaracionesJuradas tipo ON tradec.CodigoTipoDeclaracionJurada = tipo.CodigoTipoDeclaracionJurada
                     WHERE CodigoDeclaracionJurada = :codigoDeclaracionJurada ";
        if ($tipo == "array") {
            $trabajadorDeclaracionJurada = $dbRRHH->createCommand($consulta)
                ->bindParam(":codigoDeclaracionJurada", $codigoDeclaracionJurada, PDO::PARAM_STR)
                ->queryOne();
            return $trabajadorDeclaracionJurada;
        } else {
            $instruccion = $dbRRHH->createCommand($consulta)
                ->bindParam(":codigoDeclaracionJurada", $codigoDeclaracionJurada, PDO::PARAM_STR);
            $lector = $instruccion->query();
            $trabajadorDeclaracionJurada = $lector->readObject(TrabajadorDeclaracionJuradaObj::className(), []);
            return $trabajadorDeclaracionJurada;
        }

        if ($tipo == "array") {
            $trabajador = $dbRRHH->createCommand($consulta)
                ->bindParam(":" , $valor, PDO::PARAM_STR)
                ->queryOne();
            return $trabajador;
        } else {
            $trabajadordj = new TrabajadorDeclaracionJuradaObj();
            $trabajadordj = $dbRRHH->createCommand($consulta)
                ->bindParam(":" . $campo, $valor, PDO::PARAM_STR)
                ->queryOne(PDO::FETCH_OBJ);
            return $trabajadordj;
        }
    }

    /*=============================================
    LISTA TRABAJADORES DECLARACIONES JURADAS
    =============================================*/
    static public function listaTrabajadoresDeclaracionesJuradas()
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT tradec.CodigoTrabajador, per.IdPersona, per.Paterno, per.Materno, per.Nombres, isnull(per.Paterno,'')+' '+isnull(per.Materno,'')+' '+per.Nombres AS NombreCompleto,
					 tip.CodigoTipoDeclaracionJurada, tip.NombreTipoDeclaracionJurada, tradec.CodigoDeclaracionJurada, tradec.Gestion, tradec.Mes, tradec.FechaNotificacion, tradec.FechaRecepcion,
					 tradec.Observacion, tradec.FechaHoraRegistro, tradec.CodigoUsuario
					 FROM TrabajadoresDeclaracionesJuradas tradec
					 INNER JOIN Trabajadores tra ON tra.CodigoTrabajador = tradec.CodigoTrabajador
					 INNER JOIN Personas per ON tra.IdPersona = per.IdPersona
					 INNER JOIN TiposDeclaracionesJuradas tip ON tradec.CodigoTipoDeclaracionJurada = tip.CodigoTipoDeclaracionJurada
					 ORDER BY Paterno, Materno, Nombres ";
        $instruccion = $dbRRHH->createCommand($consulta);
        $lector = $instruccion->query();
        $trabajadoresDeclaracionesJuradas = [];
        while ($trabajadorDeclaracionJurada = $lector->readObject(TrabajadorDeclaracionJuradaObj::className(), [])) {
            $trabajadoresDeclaracionesJuradas[] = $trabajadorDeclaracionJurada;
        }
        return $trabajadoresDeclaracionesJuradas;
    }

    /*==================================================
LISTA TODOS LOS TRABAJADORES VIGENTES Y EN FUNCIONES PRESENTARON
==================================================*/
    static public function listaDeclaracionJuradaPresentadaTriUno(/*$mes,*/ $gestion)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT p.Paterno, p.Materno, p.Nombres, isnull(p.Paterno,'')+' '+isnull(p.Materno,'')+' '+p.Nombres AS NombreCompleto,
				p.IdPersona,'POR DEFINIR' as Cargo, 'OTRO' as Funcion, 'SI' Reside, P.FechaNacimiento, tdj.CodigoDeclaracionJurada,
				tdj.FechaRecepcion
				FROM Personas p
				INNER JOIN Trabajadores as t on (p.IdPersona = t.IdPersona)
				INNER JOIN TrabajadoresDeclaracionesJuradas as tdj on (t.CodigoTrabajador = tdj.CodigoTrabajador)
				WHERE month(tdj.FechaRecepcion) between '01' and '03' and year(tdj.FechaRecepcion) = :gestion and month(p.FechaNacimiento) between '01' and '03'
				ORDER BY P.Paterno";
        $instruccion = $dbRRHH->createCommand($consulta)
            //->bindParam(":mes", $mes, PDO::PARAM_STR)
            ->bindParam(":gestion", $gestion, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $reportes = [];
        while ($reporte = $lector->readObject(TrabajadorDeclaracionJuradaObj::className(), [])) {
            $reportes[] = $reporte;
        }
        return $reportes;
    }

    static public function listaDeclaracionJuradaPresentadaTriDos(/*$mes,*/ $gestion)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT p.Paterno, p.Materno, p.Nombres, isnull(p.Paterno,'')+' '+isnull(p.Materno,'')+' '+p.Nombres AS NombreCompleto,
				p.IdPersona,'POR DEFINIR' as Cargo, 'OTRO' as Funcion, 'SI' Reside, P.FechaNacimiento, tdj.CodigoDeclaracionJurada,
				tdj.FechaRecepcion
				FROM Personas p
				INNER JOIN Trabajadores as t on (p.IdPersona = t.IdPersona)
				INNER JOIN TrabajadoresDeclaracionesJuradas as tdj on (t.CodigoTrabajador = tdj.CodigoTrabajador)
				WHERE month(tdj.FechaRecepcion) between '04' and '06' and year(tdj.FechaRecepcion) = :gestion and month(p.FechaNacimiento) between '04' and '06'
				ORDER BY P.Paterno";
        $instruccion = $dbRRHH->createCommand($consulta)
            //->bindParam(":mes", $mes, PDO::PARAM_STR)
            ->bindParam(":gestion", $gestion, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $reportes = [];
        while ($reporte = $lector->readObject(TrabajadorDeclaracionJuradaObj::className(), [])) {
            $reportes[] = $reporte;
        }
        return $reportes;
    }

    static public function listaDeclaracionJuradaPresentadaTriTres(/*$mes,*/ $gestion)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT p.Paterno, p.Materno, p.Nombres, isnull(p.Paterno,'')+' '+isnull(p.Materno,'')+' '+p.Nombres AS NombreCompleto,
				p.IdPersona,'POR DEFINIR' as Cargo, 'OTRO' as Funcion, 'SI' Reside, P.FechaNacimiento, tdj.CodigoDeclaracionJurada,
				tdj.FechaRecepcion
				FROM Personas p
				INNER JOIN Trabajadores as t on (p.IdPersona = t.IdPersona)
				INNER JOIN TrabajadoresDeclaracionesJuradas as tdj on (t.CodigoTrabajador = tdj.CodigoTrabajador)
				WHERE month(tdj.FechaRecepcion) between '07' and '09' and year(tdj.FechaRecepcion) = :gestion and month(p.FechaNacimiento) between '07' and '09'
				ORDER BY P.Paterno";
        $instruccion = $dbRRHH->createCommand($consulta)
            //->bindParam(":mes", $mes, PDO::PARAM_STR)
            ->bindParam(":gestion", $gestion, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $reportes = [];
        while ($reporte = $lector->readObject(TrabajadorDeclaracionJuradaObj::className(), [])) {
            $reportes[] = $reporte;
        }
        return $reportes;
    }

    static public function listaDeclaracionJuradaPresentadaTriCuatro(/*$mes,*/ $gestion)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT p.Paterno, p.Materno, p.Nombres, isnull(p.Paterno,'')+' '+isnull(p.Materno,'')+' '+p.Nombres AS NombreCompleto,
				p.IdPersona,'POR DEFINIR' as Cargo, 'OTRO' as Funcion, 'SI' Reside, P.FechaNacimiento, tdj.CodigoDeclaracionJurada,
				tdj.FechaRecepcion
				FROM Personas p
				INNER JOIN Trabajadores as t on (p.IdPersona = t.IdPersona)
				INNER JOIN TrabajadoresDeclaracionesJuradas as tdj on (t.CodigoTrabajador = tdj.CodigoTrabajador)
				WHERE month(tdj.FechaRecepcion) between '10' and '12' and year(tdj.FechaRecepcion) = :gestion and month(p.FechaNacimiento) between '10' and '12'
				ORDER BY P.Paterno";
        $instruccion = $dbRRHH->createCommand($consulta)
            //->bindParam(":mes", $mes, PDO::PARAM_STR)
            ->bindParam(":gestion", $gestion, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $reportes = [];
        while ($reporte = $lector->readObject(TrabajadorDeclaracionJuradaObj::className(), [])) {
            $reportes[] = $reporte;
        }
        return $reportes;
    }

    static public function listaDeclaracionJuradaFueraPlazoTriUno(/*$mes,*/ $gestion)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT p.Paterno, p.Materno, p.Nombres, isnull(p.Paterno,'')+' '+isnull(p.Materno,'')+' '+p.Nombres AS NombreCompleto,
				p.IdPersona,'POR DEFINIR' as Cargo, 'OTRO' as Funcion, 'SI' Reside, P.FechaNacimiento, tdj.CodigoDeclaracionJurada,
				tdj.FechaRecepcion
				FROM Personas p
				INNER JOIN Trabajadores as t on (p.IdPersona = t.IdPersona)
				INNER JOIN TrabajadoresDeclaracionesJuradas as tdj on (t.CodigoTrabajador = tdj.CodigoTrabajador)
				WHERE month(p.FechaNacimiento) between '01' and '03' and year(tdj.FechaRecepcion) = :gestion and month(p.FechaNacimiento) < month(tdj.FechaRecepcion) 
				ORDER BY tdj.FechaRecepcion";
        $instruccion = $dbRRHH->createCommand($consulta)
            //->bindParam(":mes", $mes, PDO::PARAM_STR)
            ->bindParam(":gestion", $gestion, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $reportes = [];
        while ($reporte = $lector->readObject(TrabajadorDeclaracionJuradaObj::className(), [])) {
            $reportes[] = $reporte;
        }
        return $reportes;
    }

    static public function listaDeclaracionJuradaFueraPlazoTriDos(/*$mes,*/ $gestion)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT p.Paterno, p.Materno, p.Nombres, isnull(p.Paterno,'')+' '+isnull(p.Materno,'')+' '+p.Nombres AS NombreCompleto,
				p.IdPersona,'POR DEFINIR' as Cargo, 'OTRO' as Funcion, 'SI' Reside, P.FechaNacimiento, tdj.CodigoDeclaracionJurada,
				tdj.FechaRecepcion
				FROM Personas p
				INNER JOIN Trabajadores as t on (p.IdPersona = t.IdPersona)
				INNER JOIN TrabajadoresDeclaracionesJuradas as tdj on (t.CodigoTrabajador = tdj.CodigoTrabajador)
				WHERE month(p.FechaNacimiento) between '04' and '06' and year(tdj.FechaRecepcion) = :gestion and month(p.FechaNacimiento) < month(tdj.FechaRecepcion) 
				ORDER BY tdj.FechaRecepcion";
        $instruccion = $dbRRHH->createCommand($consulta)
            //->bindParam(":mes", $mes, PDO::PARAM_STR)
            ->bindParam(":gestion", $gestion, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $reportes = [];
        while ($reporte = $lector->readObject(TrabajadorDeclaracionJuradaObj::className(), [])) {
            $reportes[] = $reporte;
        }
        return $reportes;
    }

    static public function listaDeclaracionJuradaFueraPlazoTriTres(/*$mes,*/ $gestion)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT p.Paterno, p.Materno, p.Nombres, isnull(p.Paterno,'')+' '+isnull(p.Materno,'')+' '+p.Nombres AS NombreCompleto,
				p.IdPersona,'POR DEFINIR' as Cargo, 'OTRO' as Funcion, 'SI' Reside, P.FechaNacimiento, tdj.CodigoDeclaracionJurada,
				tdj.FechaRecepcion
				FROM Personas p
				INNER JOIN Trabajadores as t on (p.IdPersona = t.IdPersona)
				INNER JOIN TrabajadoresDeclaracionesJuradas as tdj on (t.CodigoTrabajador = tdj.CodigoTrabajador)
				WHERE month(p.FechaNacimiento) between '07' and '09' and year(tdj.FechaRecepcion) = :gestion and month(p.FechaNacimiento) < month(tdj.FechaRecepcion) 
				ORDER BY tdj.FechaRecepcion";
        $instruccion = $dbRRHH->createCommand($consulta)
            //->bindParam(":mes", $mes, PDO::PARAM_STR)
            ->bindParam(":gestion", $gestion, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $reportes = [];
        while ($reporte = $lector->readObject(TrabajadorDeclaracionJuradaObj::className(), [])) {
            $reportes[] = $reporte;
        }
        return $reportes;
    }

    static public function listaDeclaracionJuradaFueraPlazoTriCuatro(/*$mes,*/ $gestion)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT p.Paterno, p.Materno, p.Nombres, isnull(p.Paterno,'')+' '+isnull(p.Materno,'')+' '+p.Nombres AS NombreCompleto,
				p.IdPersona,'POR DEFINIR' as Cargo, 'OTRO' as Funcion, 'SI' Reside, P.FechaNacimiento, tdj.CodigoDeclaracionJurada,
				tdj.FechaRecepcion
				FROM Personas p
				INNER JOIN Trabajadores as t on (p.IdPersona = t.IdPersona)
				INNER JOIN TrabajadoresDeclaracionesJuradas as tdj on (t.CodigoTrabajador = tdj.CodigoTrabajador)
				WHERE month(p.FechaNacimiento) between '10' and '12' and year(tdj.FechaRecepcion) = :gestion and month(p.FechaNacimiento) < month(tdj.FechaRecepcion) 
				ORDER BY tdj.FechaRecepcion";
        $instruccion = $dbRRHH->createCommand($consulta)
            //->bindParam(":mes", $mes, PDO::PARAM_STR)
            ->bindParam(":gestion", $gestion, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $reportes = [];
        while ($reporte = $lector->readObject(TrabajadorDeclaracionJuradaObj::className(), [])) {
            $reportes[] = $reporte;
        }
        return $reportes;
    }
}
