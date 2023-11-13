<?php

namespace app\modules\CargaHoraria\models;

use Yii;
use yii\db\mssql\PDO;
use yii\db\Query;

class CargaHorariaInasistenciasMesDao
{
    static public function buscaInasistencia($tipo, $codigoCarrera, $codigoSedeAcad, $numeroPlanEstudios, $siglaMateria, $grupo, $gestion, $mes, $codigoTrabajador)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT *
                     FROM CargaHorariaInasistenciasMes
                     WHERE CodigoCarrera = :codigoCarrera AND CodigoSedeAcad = :codigoSedeAcad 
                     AND NumeroPlanEstudios = :numeroPlanEstudios AND SiglaMateria = :siglaMateria 
                     AND Grupo = :grupo AND Gestion= :gestion AND Mes= :mes
                     AND CodigoTrabajador= :codigoTrabajador";
        if ($tipo == "array") {
            $inasistencia = $dbRRHH->createCommand($consulta)
                ->bindParam(":codigoCarrera", $codigoCarrera, PDO::PARAM_INT)
                ->bindParam(":codigoSedeAcad", $codigoSedeAcad, PDO::PARAM_STR)
                ->bindParam(":numeroPlanEstudios", $numeroPlanEstudios, PDO::PARAM_INT)
                ->bindParam(":siglaMateria", $siglaMateria, PDO::PARAM_STR)
                ->bindParam(":grupo", $grupo, PDO::PARAM_INT)
                ->bindParam(":gestion", $gestion, PDO::PARAM_INT)
                ->bindParam(":mes", $mes, PDO::PARAM_INT)
                ->bindParam(":codigoTrabajador", $codigoTrabajador, PDO::PARAM_STR)
                ->queryOne();
            return $inasistencia;
        } else {
            $instruccion = $dbRRHH->createCommand($consulta)
                ->bindParam(":codigoCarrera", $codigoCarrera, PDO::PARAM_INT)
                ->bindParam(":codigoSedeAcad", $codigoSedeAcad, PDO::PARAM_STR)
                ->bindParam(":numeroPlanEstudios", $numeroPlanEstudios, PDO::PARAM_INT)
                ->bindParam(":siglaMateria", $siglaMateria, PDO::PARAM_STR)
                ->bindParam(":grupo", $grupo, PDO::PARAM_INT)
                ->bindParam(":gestion", $gestion, PDO::PARAM_INT)
                ->bindParam(":mes", $mes, PDO::PARAM_INT)
                ->bindParam(":codigoTrabajador", $codigoTrabajador, PDO::PARAM_STR);
            $lector = $instruccion->query();
            $inasistencia = $lector->readObject(CargaHorariaInasistenciaMesObj::className(), []);
            return $inasistencia;
        }
        return $inasistencia;
    }

    /*=============================================
         LISTA INASISTENCIAS REGISTRADAS POR DOCENTE
      =============================================*/
    static public function inasistenciasRegistradas($codigoCarrera, $codigoSedeAcad, $numeroPlanEstudios, $siglaMateria, $grupo, $gestion, $mes, $codigoTrabajador)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT chim.CodigoCarrera, chim.CodigoSedeAcad, chim.NumeroPlanEstudios, chim.SiglaMateria, chim.Grupo, 
                         chim.Gestion, chim.Mes, chim.Fecha, chim.Horas, chim.Observacion,chim.CodigoTrabajador, ti.NombreTipoInasistencia
                     FROM CargaHorariaInasistenciasMes chim
                     INNER JOIN TiposInasistencias ti ON chim.CodigoTipoInasistencia=ti.codigoTipoInasistencia
                     WHERE chim.CodigoCarrera= :codigoCarrera AND chim.CodigoSedeAcad = :codigoSedeAcad AND chim.NumeroPlanEstudios= :numeroPlanEstudios
                           AND chim.SiglaMateria= :siglaMateria  AND chim.Grupo= :grupo AND chim.Gestion= :gestion AND chim.Mes= :mes
                           AND chim.CodigoTrabajador= :codigoTrabajador";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":codigoCarrera", $codigoCarrera, PDO::PARAM_INT)
            ->bindParam(":codigoSedeAcad", $codigoSedeAcad, PDO::PARAM_STR)
            ->bindParam(":numeroPlanEstudios", $numeroPlanEstudios, PDO::PARAM_INT)
            ->bindParam(":siglaMateria", $siglaMateria, PDO::PARAM_STR)
            ->bindParam(":grupo", $grupo, PDO::PARAM_INT)
            ->bindParam(":gestion", $gestion, PDO::PARAM_INT)
            ->bindParam(":mes", $mes, PDO::PARAM_INT)
            ->bindParam(":codigoTrabajador", $codigoTrabajador, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $inasistencias = [];
        while ($inasistencia = $lector->readObject(CargaHorariaInasistenciaMesObj::className(), [])) {
            $inasistencias[] = $inasistencia;
        }
        return $inasistencias;
    }

    /*=============================================
     CANTIDAD DE HORAS TOTALES A SER REGISTRADAS
     =============================================*/
    static public function validarHoras()
    {
        $consulta = new Query();
        $horasInasistenciaRegistradas = $consulta->select('sum(Horas) AS TotalHoras')
            ->from('CargaHorariaInasistenciasMes')
            ->where(["CodigoCarrera" => $_POST["codigocarrera"]])
            ->andWhere(["CodigoSedeAcad" => $_POST["codigosedeacad"]])
            ->andWhere(["NumeroPlanEstudios" => $_POST["numeroplanestudios"]])
            ->andWhere(["SiglaMateria" => $_POST["siglamateria"]])
            ->andWhere(["Grupo" => $_POST["grupo"]])
            ->andWhere(["Gestion" => $_POST["gestion"]])
            ->andWhere(["Mes" => $_POST["mes"]])
            ->andWhere(["CodigoTrabajador" => $_POST["codigotrabajador"]])
            ->One();
        if (!$horasInasistenciaRegistradas) {
            return 0;
        } else {
            return $horasInasistenciaRegistradas['TotalHoras'];
        }
    }

    /*========================================================
     LISTA INASISTENCIAS REGISTRADAS POR CARRERA PARA REPORTE
     =========================================================*/
    static public function verInasistenciasRegistradas($codigoCarrera, $codigoSede, $gestion, $mes)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT chim.CodigoCarrera, chim.CodigoTrabajador, chim.CodigoSedeAcad, chim.NumeroPlanEstudios, 
                     chim.SiglaMateria, chim.Grupo, chim.Fecha, chim.Horas, chim.Observacion,
                     per.IdPersona, isnull(upper(per.Paterno),'') AS Paterno, isnull(upper(per.Materno),'') 
                     AS Materno, upper(per.Nombres)AS Nombres, isnull(per.Paterno,'')+' '+isnull(per.Materno,'')+' '+per.Nombres AS NombreCompleto, 
					 car.NombreCarrera, ti.NombreTipoInasistencia, sed.NombreSede
       FROM CargaHorariaInasistenciasMes chim
	   INNER JOIN Trabajadores as tra ON (chim.CodigoTrabajador=tra.CodigoTrabajador)
	   INNER JOIN Personas as per ON (tra.IdPersona= per.IdPersona)
	   INNER JOIN TiposInasistencias ti ON chim.CodigoTipoInasistencia=ti.codigoTipoInasistencia
	   INNER JOIN [172.17.1.20].[Academica].dbo.Carreras car ON chim.CodigoCarrera=car.CodigoCarrera
	   INNER JOIN [172.17.1.20].[Academica].dbo.Sedes  sed ON chim.CodigoSedeAcad=sed.CodigoSede collate SQL_Latin1_General_CP1_CI_AS
	   Where chim.Gestion= :gestion AND chim.Mes= :mes  AND chim.CodigoCarrera= :codigoCarrera AND CodigoSedeAcad= :codigoSede ";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":gestion", $gestion, PDO::PARAM_INT)
            ->bindParam(":mes", $mes, PDO::PARAM_INT)
            ->bindParam(":codigoCarrera", $codigoCarrera, PDO::PARAM_INT)
            ->bindParam(":codigoSede", $codigoSede, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $inasistencias = [];
        while ($inasistencia = $lector->readObject(CargaHorariaInasistenciaMesObj::className(), [])) {
            $inasistencias[] = $inasistencia;
        }
        return $inasistencias;
    }
    /*========================================================
     SACA EL CARGO DE LA PERSONA ES SESIÓN
     =========================================================*/
    static public function obtenerCargo($idPersona)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT car.NombreCargo
                     FROM Trabajadores tra
                     INNER JOIN AsignacionesDocentes asd ON tra.CodigoTrabajador=asd.CodigoTrabajador
                     INNER JOIN Items itm ON asd.NroItem=itm.NroItem
                     INNER JOIN Cargos car ON itm.CodigoCargo=car.CodigoCargo
                     WHERE IdPersona = :idPersona AND car.CodigoCargo = 'DOC003'";
        $cargo = $dbRRHH->createCommand($consulta)
            ->bindParam(":idPersona", $idPersona, PDO::PARAM_STR)
            ->queryOne();
        return $cargo;
    }
}