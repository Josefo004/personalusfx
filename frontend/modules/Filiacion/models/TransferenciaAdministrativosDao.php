<?php

namespace app\modules\Filiacion\models;

use backend\models\NivelSalarialObj;
use yii\db\mssql\PDO;
use Yii;
use yii\db\Query;

class TransferenciaAdministrativosDao
{
    /*=============================================
    CORRELATIVO MAXIMO DE LAS TRANSFERENCIAS ADMINISTRATIVOS
    =============================================*/
    static public function maximoTransferenciasAdministrativos()
    {
        $consulta = new Query();
        $arrayMaximo = $consulta->select('max(CodigoTransferencia) AS Maximo')
            ->from('TransferenciasAdministrativos')
            ->one();
        if (!$arrayMaximo) {
            return 0;
        } else {
            return $arrayMaximo['Maximo'];
        }
    }

    /*=============================================
    BUSCA TRANSFERENCIA ADMINISTRATIVOS
    =============================================*/
    static public function buscaTransferenciaAdministrativo($tipo, $codigoTransferencia)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT CodigoTransferencia, Motivo, FechaInicioTransferencia, FechaFinAsignacion, CodigoEstado,FechahoraRegistro, CodigoUsuario
                     FROM TransferenciasAdministrativos
                     WHERE CodigoTransferencia = :codigoTransferencia ";
        if ($tipo == "array") {
            $transferenciaAdministrativo = $dbRRHH->createCommand($consulta)
                ->bindParam(":codigoTransferencia", $codigoTransferencia, PDO::PARAM_STR)
                ->queryOne();
            return $transferenciaAdministrativo;
        }
    }

    /*==================================================
    LISTAR NIVELES SALARIALES
    ==================================================*/
    static public function listaNivelesSalariales()
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT CodigoNivelSalarial, NombreNivelSalarial, DescripcionNivelSalarial, HaberBasico, 
                            PuntosEscalafon, CodigoSectorTrabajo, CodigoEstado, FechaHoraRegistro, CodigoUsuario
                     FROM NivelesSalariales
                     WHERE CodigoSectorTrabajo = 'ADM'";
        $instruccion = $dbRRHH->createCommand($consulta);
        $lector = $instruccion->query();
        $nivelesSalariales = [];
        while ($nivelSalarial = $lector->readObject(NivelSalarialObj::className(), [])) {
            $nivelesSalariales[] = $nivelSalarial;
        }
        return $nivelesSalariales;
    }

    /*==================================================
    LISTA ASIGNACIONES
    ==================================================*/
    static public function listaAsignacionesAdministrativos()
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
					 where a.CodigoTrabajador 
					 not in ( select codigotrabajador from TransferenciasDetalleAdministrativos where codigoestado = 'V' ) 
                     ORDER BY Paterno, Materno, Nombres";*/
        /*$consulta = "SELECT a.IdFuncionario, p.IdPersona, p.ApellidoPaterno, p.ApellidoMaterno, p.PrimerNombre, p.SegundoNombres, p.TercerNombre,
						    isnull(p.ApellidoPaterno,'')+' '+isnull(p.ApellidoMaterno,'')+' '+isnull(p.PrimerNombre,'')+' '+isnull(p.SegundoNombres,'')+' '+isnull(p.TercerNombre,'') AS NombreCompleto,
                            i.CodigoUnidad, u.NombreUnidad, u.CodigoUnidadPadre, isnull(u2.NombreUnidad,'') AS NombreUnidadPadre, cl.CodigoSectorTrabajo, s.NombreSectorTrabajo, a.CodigoCondicionLaboral, 
                            cl.NombreCondicionLaboral, isnull(s.NombreSectorTrabajo,'')+'/ '+isnull(cl.NombreCondicionLaboral,'') AS Sector, 
                            i.CodigoCargo, c.NombreCargo,a.IdItem, i.NroItem, i.NroItemPlanillas, a.CodigoNivelSalarial, n.NombreNivelSalarial, n.HaberBasico,
                            a.CodigoTiempoTrabajo, tt.NombreTiempoTrabajo, a.FechaIngreso, a.FechaSalida, 
                            a.NroMemorando, a.FechaHoraRegistro, a. CodigoUsuario, a.CodigoEstado
                     FROM Administrativos a
                     INNER JOIN Funcionarios t on(a.IdFuncionario = t.IdFuncionario)
                     INNER JOIN Items i on (a.IdItem = i.NroItem)
					 INNER JOIN Unidades u on (i.CodigoUnidad = u.CodigoUnidad)
                     LEFT JOIN Unidades u2 on (u.CodigoUnidadPadre = u2.CodigoUnidad)
                     INNER JOIN CondicionesLaborales cl on (cl.CodigoCondicionLaboral = a.CodigoCondicionLaboral)
                     INNER JOIN SectoresTrabajo s on (s.CodigoSectorTrabajo = cl.CodigoSectorTrabajo)
                     INNER JOIN Cargos c on (c.CodigoCargo = i.CodigoCargo)
                     INNER JOIN NivelesSalariales n on (a.CodigoNivelSalarial = n.CodigoNivelSalarial)
                     INNER JOIN Personas p ON t.IdPersona = p.IdPersona
                     --INNER JOIN TiposDocumentos td on (a.CodigoTipoDocumento = td.CodigoTipoDocumento) 
                     INNER JOIN TiemposTrabajo tt on (a.CodigoTiempoTrabajo = tt.CodigoTiempoTrabajo)
					 where a.IdFuncionario 
					 not in ( select IdFuncionario from TransferenciasDetalleAdministrativos where codigoestado = 'V' ) 
                     ORDER BY a.IdFuncionario, p.IdPersona, p.ApellidoPaterno, p.ApellidoMaterno, p.PrimerNombre, p.SegundoNombres, p.TercerNombre";*/
        $consulta = "SELECT a.IdFuncionario, p.IdPersona, p.ApellidoPaterno, p.ApellidoMaterno, p.PrimerNombre, p.SegundoNombres, p.TercerNombre, 
						    isnull(p.ApellidoPaterno,'')+' '+isnull(p.ApellidoMaterno,'')+' '+isnull(p.PrimerNombre,'')+' '+isnull(p.SegundoNombres,'')+' '+isnull(p.TercerNombre,'') AS NombreCompleto,
							a.IdItem, i.NroItem, i.CodigoUnidad--, u.NombreUnidad

from Administrativos a
inner join Funcionarios f on a.IdFuncionario = f.IdFuncionario
inner join Personas p on f.IdPersona = p.IdPersona
inner join items i on a.IdItem = i.IdItem 
					 where a.IdFuncionario 
					 not in ( select IdFuncionario from TransferenciasDetalleAdministrativos where codigoestado = 'V' ) 
                     ORDER BY a.IdFuncionario, p.IdPersona, p.ApellidoPaterno, p.ApellidoMaterno, p.PrimerNombre, p.SegundoNombres, p.TercerNombre";
        $instruccion = $dbRRHH->createCommand($consulta);
        $lector = $instruccion->query();
        $asignaciones = [];
        while ($asignacion = $lector->readObject(TransferenciaDetalleAdministrativoObj::className(), [])) {
            $asignaciones[] = $asignacion;
        }
        return $asignaciones;
    }

    /*============================================================
    LISTA TRABAJADORES DETALLE ADMINISTRATIVOS
    ===========================================================*/
    static public function listaTransferenciaDetalleAdministrativo($codigoTransferencia)
    {
        $dbRRHH = Yii::$app->db;
        /*$consulta = "SELECT tda.CodigoTransferencia, tda.CodigoTrabajador, per.IdPersona, per.Paterno, per.Materno, per.Nombres,
                            isnull(per.Paterno,'')+' '+isnull(per.Materno,'')+' '+per.Nombres AS NombreCompleto, 
                            tda.NroItem, i.NroItemPlanillas, tda.CodigoNivelSalarial, ns.NombreNivelSalarial, c.CodigoCargo, c.NombreCargo, 
                            u.CodigoUnidad ,u.NombreUnidad, 
                            tda.TipoTransferencia, tda.CodigoEstado, tda.FechaHoraRegistro, tda.CodigoUsuario 
                     FROM TransferenciasDetalleAdministrativos tda
					 INNER JOIN Trabajadores tra on tda.CodigoTrabajador = tra.CodigoTrabajador
					 INNER JOIN Personas per ON tra.IdPersona = per.IdPersona
					 INNER JOIN NivelesSalariales ns ON tda.CodigoNivelSalarial = ns.CodigoNivelSalarial
					 INNER JOIN Items i ON tda.NroItem = i.NroItem
					 INNER JOIN Cargos c ON i.CodigoCargo = c.CodigoCargo
					 INNER JOIN Unidades u ON i.CodigoUnidad = u.CodigoUnidad
                     WHERE CodigoTransferencia = :codigoTransferencia ";*/
        $consulta = "SELECT tda.CodigoTransferencia, tda.IdFuncionario, per.IdPersona, per.ApellidoPaterno, per.ApellidoMaterno, per.PrimerNombre, per.SegundoNombres, per.TercerNombre ,
                            isnull(per.ApellidoPaterno,'')+' '+isnull(per.ApellidoMaterno,'')+' '+isnull(per.PrimerNombre,'')+' '+isnull(per.SegundoNombres,'')+' '+isnull(per.TercerNombre,'') AS NombreCompleto, 
                            tda.IdItem, i.NroItemPlanillas, tda.CodigoNivelSalarial, ns.NombreNivelSalarial, c.CodigoCargo, c.NombreCargo, 
                            u.CodigoUnidad ,u.NombreUnidad, 
                            tda.TipoTransferencia, tda.CodigoEstado, tda.FechaHoraRegistro, tda.CodigoUsuario 
                     FROM TransferenciasDetalleAdministrativos tda
					 INNER JOIN Funcionarios tra on tda.IdFuncionario = tra.IdFuncionario
					 INNER JOIN Personas per ON tra.IdPersona = per.IdPersona
					 INNER JOIN NivelesSalariales ns ON tda.CodigoNivelSalarial = ns.CodigoNivelSalarial
					 INNER JOIN Items i ON tda.IdItem = i.IdItem
					 INNER JOIN Cargos c ON i.CodigoCargo = c.CodigoCargo
					 INNER JOIN Unidades u ON i.CodigoUnidad = u.CodigoUnidad
                     WHERE CodigoTransferencia = :codigoTransferencia";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":codigoTransferencia", $codigoTransferencia, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $trabajadores = [];
        while ($trabajador = $lector->readObject(TransferenciaDetalleAdministrativoObj::className(), [])) {
            $trabajadores[] = $trabajador;
        }
        return $trabajadores;
    }

    /*============================================================
    LISTA NIVELES DE TRABAJADORES SELECCIONADOS
    ===========================================================*/
    static public function ObtenerNivelTrabajador($CodigoTrabajador)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT tda.CodigoTransferencia, tda.CodigoTrabajador, per.IdPersona, per.Paterno, per.Materno, per.Nombres, 
                            isnull(per.Paterno,'')+' '+isnull(per.Materno,'')+' '+per.Nombres AS NombreCompleto, 
                            tda.NroItem, i.NroItemPlanillas, tda.CodigoNivelSalarial, ns.NombreNivelSalarial, c.CodigoCargo, c.NombreCargo, 
                            u.CodigoUnidad ,u.NombreUnidad, 
                            tda.TipoTransferencia, tda.CodigoEstado, tda.FechaHoraRegistro, tda.CodigoUsuario 
                     FROM TransferenciasDetalleAdministrativos tda
					 INNER JOIN Trabajadores tra on tda.CodigoTrabajador = tra.CodigoTrabajador
					 INNER JOIN Personas per ON tra.IdPersona = per.IdPersona
					 INNER JOIN NivelesSalariales ns ON tda.CodigoNivelSalarial = ns.CodigoNivelSalarial
					 INNER JOIN Items i ON tda.NroItem = i.NroItem
					 INNER JOIN Cargos c ON i.CodigoCargo = c.CodigoCargo
					 INNER JOIN Unidades u ON i.CodigoUnidad = u.CodigoUnidad
                     WHERE tda.CodigoTrabajador = :codigoTrabajador";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":codigoTrabajador", $CodigoTrabajador, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $trabajador = $lector->readObject(TransferenciaDetalleAdministrativoObj::className(), []);
        return $trabajador;;

    }
}