<?php

namespace app\modules\Filiacion\models;

use yii\db\Query;
use yii\db\mssql\PDO;
use Yii;

class AsignacionesDao
{

    /*==================================================
    LISTA ASIGNACIONES
    ==================================================*/
    static public function listaAsignaciones()
    {
        $dbRRHH = Yii::$app->db;
        /*$consulta = "SELECT a.CodigoAsignacion, a.CodigoTrabajador, p.IdPersona, p.Paterno, p.Materno, p.Nombres, isnull(p.Paterno,'')+' '+isnull(p.Materno,'')+' '+p.Nombres AS NombreCompleto,
                            i.CodigoUnidad, u.NombreUnidad, u.CodigoUnidadPadre, isnull(u2.NombreUnidad,'') AS NombreUnidadPadre, cl.CodigoSectorTrabajo, s.NombreSectorTrabajo, a.CodigoCondicionLaboral, 
                            cl.NombreCondicionLaboral, isnull(s.NombreSectorTrabajo,'')+'/ '+isnull(cl.NombreCondicionLaboral,'') AS Sector, 
                            i.CodigoCargo, c.NombreCargo,a.NroItem, i.NroItemRrhh, i.NroItemPlanillas, a.CodigoNivelSalarial, n.NombreNivelSalarial, (n.HaberBasico * a.HorasTrabajadas)/160 AS HaberBasico,
                            a.CodigoTiempoTrabajo, tt.NombreTiempoTrabajo, a.FechaInicio, a.FechaFin, 
                            a.Jefatura,case a.Jefatura when 0 then 'SI' else 'NO' end AS JefaturaLiteral,a.Interinato, case a.Interinato when 0 then 'SI' else 'NO' end AS InterinatoLiteral,  a.NroDocumento, 
                            a.FechaDocumento, td.CodigoTipoDocumento ,td.NombreTipoDocumento,a.HorasTrabajadas, a.FechaHoraRegistro, a. CodigoUsuario, a.CodigoEstado
                     FROM AsignacionesAdministrativos a
                     INNER JOIN Trabajadores t on(a.CodigoTrabajador = t.CodigoTrabajador)
                     INNER JOIN Items i on (a.NroItem = i.NroItem)
					 INNER JOIN Unidades u on (i.CodigoUnidad = u.CodigoUnidad)
                     LEFT JOIN Unidades u2 on (u.CodigoUnidadPadre = u2.CodigoUnidad)
                     INNER JOIN CondicionesLaborales cl on (cl.CodigoCondicionLaboral = a.CodigoCondicionLaboral)
                     INNER JOIN SectoresTrabajo s on (s.CodigoSectorTrabajo = cl.CodigoSectorTrabajo)
                     INNER JOIN Cargos c on (c.CodigoCargo = i.CodigoCargo)
                     INNER JOIN NivelesSalariales n on (a.CodigoNivelSalarial = n.CodigoNivelSalarial)
                     INNER JOIN Personas p ON t.IdPersona = p.IdPersona
                     INNER JOIN TiposDocumentos td on (a.CodigoTipoDocumento = td.CodigoTipoDocumento) 
                     INNER JOIN TiemposTrabajo tt on (a.CodigoTiempoTrabajo = tt.CodigoTiempoTrabajo)
                     ORDER BY Paterno, Materno, Nombres ";*/
        $consulta = "SELECT a.CodigoAsignacion, a.CodigoTrabajador, p.IdPersona, p.Paterno, p.Materno, p.Nombres, isnull(p.Paterno,'')+' '+isnull(p.Materno,'')+' '+p.Nombres AS NombreCompleto,
                            i.CodigoUnidad, u.NombreUnidad, u.CodigoUnidadPadre, isnull(u2.NombreUnidad,'') AS NombreUnidadPadre, cl.CodigoSectorTrabajo, s.NombreSectorTrabajo, a.CodigoCondicionLaboral, 
                            cl.NombreCondicionLaboral, isnull(s.NombreSectorTrabajo,'')+'/ '+isnull(cl.NombreCondicionLaboral,'') AS Sector, 
                            i.CodigoCargo, c.NombreCargo,a.NroItem, i.NroItemRrhh, i.NroItemPlanillas, a.CodigoNivelSalarial, n.NombreNivelSalarial, n.HaberBasico,
                            a.CodigoTiempoTrabajo, tt.NombreTiempoTrabajo, a.FechaInicio, a.FechaFin, 
                            a.Jefatura,case a.Jefatura when 0 then 'SI' else 'NO' end AS JefaturaLiteral,a.Interinato, case a.Interinato when 0 then 'SI' else 'NO' end AS InterinatoLiteral,  a.NroDocumento, 
                            a.FechaDocumento, td.CodigoTipoDocumento ,td.NombreTipoDocumento, a.FechaHoraRegistro, a. CodigoUsuario, a.CodigoEstado
                     FROM AsignacionesAdministrativos a
                     INNER JOIN Trabajadores t on(a.CodigoTrabajador = t.CodigoTrabajador)
                     INNER JOIN Items i on (a.NroItem = i.NroItem)
					 INNER JOIN Unidades u on (i.CodigoUnidad = u.CodigoUnidad)
                     LEFT JOIN Unidades u2 on (u.CodigoUnidadPadre = u2.CodigoUnidad)
                     INNER JOIN CondicionesLaborales cl on (cl.CodigoCondicionLaboral = a.CodigoCondicionLaboral)
                     INNER JOIN SectoresTrabajo s on (s.CodigoSectorTrabajo = cl.CodigoSectorTrabajo)
                     INNER JOIN Cargos c on (c.CodigoCargo = i.CodigoCargo)
                     INNER JOIN NivelesSalariales n on (a.CodigoNivelSalarial = n.CodigoNivelSalarial)
                     INNER JOIN Personas p ON t.IdPersona = p.IdPersona
                     INNER JOIN TiposDocumentos td on (a.CodigoTipoDocumento = td.CodigoTipoDocumento) 
                     INNER JOIN TiemposTrabajo tt on (a.CodigoTiempoTrabajo = tt.CodigoTiempoTrabajo)
                     ORDER BY Paterno, Materno, Nombres";
        $instruccion = $dbRRHH->createCommand($consulta);
        $lector = $instruccion->query();
        $asignaciones = [];
        while ($asignacion = $lector->readObject(AsignacionObj::className(), [])) {
            $asignaciones[] = $asignacion;
        }
        return $asignaciones;
    }

    /*=============================================
    BUSCA ASIGNACION
    =============================================*/
    static public function buscaAsignacion($tipo, $campo, $valor)
    {
        $dbRRHH = Yii::$app->db;
        /*$consulta = "SELECT a.CodigoAsignacion, a.CodigoTrabajador, p.IdPersona, p.Paterno, p.Materno, p.Nombres, isnull(p.Paterno,'')+' '+isnull(p.Materno,'')+' '+p.Nombres AS NombreCompleto,
                            a.CodigoUnidad, u.NombreUnidad, u.CodigoUnidadPadre, isnull(u2.NombreUnidad,'') AS NombreUnidadPadre, cl.CodigoSectorTrabajo, s.NombreSectorTrabajo, a.CodigoCondicionLaboral, 
                            cl.NombreCondicionLaboral, isnull(s.NombreSectorTrabajo,'')+'/ '+isnull(cl.NombreCondicionLaboral,'') AS Sector, 
                            i.CodigoCargo, c.NombreCargo,a.NroItem, i.NroItemRrhh, i.NroItemPlanillas, a.CodigoNivelSalarial, n.NombreNivelSalarial, (n.HaberBasico * a.HorasTrabajadas)/160 AS HaberBasico, 
                            a.CodigoTiempoTrabajo, tt.NombreTiempoTrabajo, a.FechaInicio, a.FechaFin, 
                            a.Jefatura,case a.Jefatura when 0 then 'SI' else 'NO' end AS JefaturaLiteral,a.Interinato, case a.Interinato when 0 then 'SI' else 'NO' end AS InterinatoLiteral,  a.NroDocumento, 
                            a.FechaDocumento, td.CodigoTipoDocumento ,td.NombreTipoDocumento,a.HorasTrabajadas, a.FechaHoraRegistro, a. CodigoUsuario, a.CodigoEstado
                     FROM Asignaciones a
                     INNER JOIN Trabajadores t on(a.CodigoTrabajador = t.CodigoTrabajador)
                     INNER JOIN Unidades u on (a.CodigoUnidad = u.CodigoUnidad)
                     LEFT JOIN Unidades u2 on (u.CodigoUnidadPadre = u2.CodigoUnidad)
                     INNER JOIN CondicionesLaborales cl on (cl.CodigoCondicionLaboral = a.CodigoCondicionLaboral)
                     INNER JOIN SectoresTrabajo s on (s.CodigoSectorTrabajo = cl.CodigoSectorTrabajo)
                     INNER JOIN Items i on (a.NroItem = i.NroItem)
                     INNER JOIN Cargos c on (c.CodigoCargo = i.CodigoCargo)
					 INNER JOIN NivelesSalariales n on (a.CodigoNivelSalarial = n.CodigoNivelSalarial)
                     INNER JOIN Personas p ON t.IdPersona = p.IdPersona
                     INNER JOIN TiposDocumentos td on (a.CodigoTipoDocumento = td.CodigoTipoDocumento)  
                     INNER JOIN TiemposTrabajo tt on (a.CodigoTiempoTrabajo = tt.CodigoTiempoTrabajo)
                     WHERE $campo = :$campo ";*/
        $consulta = "SELECT a.CodigoAsignacion, a.CodigoTrabajador, p.IdPersona, p.Paterno, p.Materno, p.Nombres, isnull(p.Paterno,'')+' '+isnull(p.Materno,'')+' '+p.Nombres AS NombreCompleto,
                            i.CodigoUnidad, u.NombreUnidad, u.CodigoUnidadPadre, isnull(u2.NombreUnidad,'') AS NombreUnidadPadre, cl.CodigoSectorTrabajo, s.NombreSectorTrabajo, a.CodigoCondicionLaboral, 
                            cl.NombreCondicionLaboral, isnull(s.NombreSectorTrabajo,'')+'/ '+isnull(cl.NombreCondicionLaboral,'') AS Sector, 
                            i.CodigoCargo, c.NombreCargo,a.NroItem, i.NroItemRrhh, i.NroItemPlanillas, a.CodigoNivelSalarial, n.NombreNivelSalarial, HaberBasico, 
                            a.CodigoTiempoTrabajo, tt.NombreTiempoTrabajo, a.FechaInicio, a.FechaFin, 
                            a.Jefatura,case a.Jefatura when 0 then 'SI' else 'NO' end AS JefaturaLiteral,a.Interinato, case a.Interinato when 0 then 'SI' else 'NO' end AS InterinatoLiteral,  a.NroDocumento, 
                            a.FechaDocumento, td.CodigoTipoDocumento ,td.NombreTipoDocumento, a.FechaHoraRegistro, a. CodigoUsuario, a.CodigoEstado
                     FROM AsignacionesAdministrativos a
                     INNER JOIN Trabajadores t on(a.CodigoTrabajador = t.CodigoTrabajador)
                     INNER JOIN Items i on (a.NroItem = i.NroItem)
					 INNER JOIN Unidades u on (i.CodigoUnidad = u.CodigoUnidad)
                     LEFT JOIN Unidades u2 on (u.CodigoUnidadPadre = u2.CodigoUnidad)
                     INNER JOIN CondicionesLaborales cl on (cl.CodigoCondicionLaboral = a.CodigoCondicionLaboral)
                     INNER JOIN SectoresTrabajo s on (s.CodigoSectorTrabajo = cl.CodigoSectorTrabajo)
                     INNER JOIN Cargos c on (c.CodigoCargo = i.CodigoCargo)
					 INNER JOIN NivelesSalariales n on (a.CodigoNivelSalarial = n.CodigoNivelSalarial)
                     INNER JOIN Personas p ON t.IdPersona = p.IdPersona
                     INNER JOIN TiposDocumentos td on (a.CodigoTipoDocumento = td.CodigoTipoDocumento)  
                     INNER JOIN TiemposTrabajo tt on (a.CodigoTiempoTrabajo = tt.CodigoTiempoTrabajo)
                     WHERE $campo = :$campo";
        if ($tipo == "array") {
            $persona = $dbRRHH->createCommand($consulta)
                ->bindParam(":" . $campo, $valor, PDO::PARAM_STR)
                ->queryOne();
            return $persona;
        } else {
            $instruccion = $dbRRHH->createCommand($consulta)
                ->bindParam(":" . $campo, $valor, PDO::PARAM_STR);
            $lector = $instruccion->query();
            $trabajador = $lector->readObject(AsignacionObj::className(), []);
            return $trabajador;
        }
    }

    /*=============================================
        EXISTE ASIGNACION TRABAJADOR
        =============================================*/
    static public function existeAsignacionTrabajador($codigoTrabajador, $codigoCondicionLaboral)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT *                             
                     FROM AsignacionesAdministrativos a 
                     INNER JOIN CondicionesLaborales c ON (a.CodigoCondicionLaboral = c.CodigoCondicionLaboral)
                     INNER JOIN SectoresTrabajo s ON (a.CodigoSectorTrabajo = s.CodigoSectorTrabajo)
					 WHERE a.CodigoTrabajador = :codigoTrabajador and s.CodigoSectorTrabajo = :codigoSectorTrabajo and ((GETDATE() between a.FechaInicio and a.FechaFin) or a.FechaFin is null)";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":codigoTrabajador", $codigoTrabajador, PDO::PARAM_STR)
            ->bindParam(":codigoSectorTrabajo", $codigoSectorTrabajo, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $asignaciones = [];
        while ($asignacion = $lector->readObject(AsignacionObj::className(), [])) {
            $asignaciones[] = $asignacion;
        }
        return $asignaciones;
    }

    /*=============================================
     CORRELATIVO MAXIMO DE LAS ASIGNACIONES
     =============================================*/
    static public function maximoAsignaciones()
    {
        $consulta = new Query();
        $arrayMaximo = $consulta->select('max(cast(substring(CodigoAsignacion, len(CodigoAsignacion)-4,len(CodigoAsignacion)) AS int)) AS Maximo')
            ->from('AsignacionesAdministrativos')
            ->one();
        if (!$arrayMaximo) {
            return 0;
        } else {
            return $arrayMaximo['Maximo'];
        }
    }

}