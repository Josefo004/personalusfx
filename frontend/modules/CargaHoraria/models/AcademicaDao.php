<?php

namespace app\modules\CargaHoraria\models;

use yii\db\mssql\PDO;
use Yii;

class AcademicaDao
{
    /*=============================================
    LISTA FACULTADES USUSARIO
    =============================================*/
    static public function listaFacultadesUsuario($codigoUsuario)
    {
        $dbAcad = Yii::$app->dbAcad;
        $consulta = "SELECT DISTINCT fac.CodigoFacultad, fac.NombreFacultad
                     FROM Facultades fac
					 inner join Carreras ca on fac.CodigoFacultad = ca.CodigoFacultad
					 inner join ConfiguracionesUsuariosCarreras cuc on ca.CodigoCarrera = cuc.CodigoCarrera 
                     WHERE fac.CodigoFacultad not in('CE') and cuc.CodigoUsuario = :codigoUsuario                     
                     ORDER BY fac.NombreFacultad";
        $instruccion = $dbAcad->createCommand($consulta)
            ->bindParam(":codigoUsuario", $codigoUsuario, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $facultades = [];
        while ($facultad = $lector->readObject(FacultadObj::className(), [])) {
            $facultades[] = $facultad;
        }
        return $facultades;
    }

    /*=============================================
    LISTA FACULTADES
    =============================================*/
    static public function listaFacultades()
    {
        $dbAcad = Yii::$app->dbAcad;
        $consulta = "SELECT fac.CodigoFacultad, fac.NombreFacultad
                     FROM Facultades fac
					 inner join Carreras ca on fac.CodigoFacultad = ca.CodigoFacultad
                     WHERE fac.CodigoFacultad not in('CE')                    
                     ORDER BY fac.NombreFacultad";
        $instruccion = $dbAcad->createCommand($consulta);
        $lector = $instruccion->query();
        $facultades = [];
        while ($facultad = $lector->readObject(FacultadObj::className(), [])) {
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
        $carreras = [];
        while ($carrera = $lector->readObject(CarreraObj::className(), [])) {
            $carreras[] = $carrera;
        }
        return $carreras;
    }

    /*=============================================
    LISTA CARRERAS DE UN USUARIO
    =============================================*/
    static public function listaCarrerasUsuario($codigoUsuario)
    {
        $dbAcad = Yii::$app->dbAcad;
        $consulta = "SELECT car.CodigoCarrera, car.NombreCarrera
                     FROM Carreras car
					 inner join ConfiguracionesUsuariosCarreras cuc on car.CodigoCarrera = cuc.CodigoCarrera
                     WHERE car.CodigoCarrera not in(10, 15, 16, 29, 39, 46, 47, 48, 53, 58, 59, 60, 63, 65, 66, 68, 71, 73, 75, 76, 77, 83, 85, 86, 87, 88, 89, 90, 91, 93, 94, 97, 98, 102, 113)
                     and cuc.CodigoUsuario = :codigoUsuario
                     ORDER BY car.NombreCarrera";
        $instruccion = $dbAcad->createCommand($consulta)
            ->bindParam(":codigoUsuario", $codigoUsuario, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $carreras = [];
        while ($carrera = $lector->readObject(CarreraObj::className(), [])) {
            $carreras[] = $carrera;
        }
        return $carreras;
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

    /*=============================================
    LISTA PLANES DE ESTUDIO VIGENTES DE UNA CARRERA
    =============================================*/
    static public function listaPlanesEstudioCarrera($codigoCarrera)
    {
        $dbAcad = Yii::$app->dbAcad;
        $consulta = "SELECT pla.CodigoCarrera, pla.NumeroPlanEstudios, pla.CodigoSistema
                     FROM PlanesEstudios pla
                     WHERE pla.CodigoCarrera = :codigoCarrera AND pla.CodigoEstadoPlanEstudios = 'V'                                                                     
                     ORDER BY pla.NumeroPlanEstudios ";
        $instruccion = $dbAcad->createCommand($consulta)
            ->bindParam(":codigoCarrera", $codigoCarrera, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $planesEstudios = [];
        while ($planEstudio = $lector->readObject(PlanEstudioObj::className(), [])) {
            $planesEstudios[] = $planEstudio;
        }
        return $planesEstudios;
    }

    /*================================================
    LISTA CURSOS DE UN PLAN DE ESTUDIOS DE UNA CARRERA
    =================================================*/
    static public function listaCursos($codigoCarrera, $numeroPlanEstudios)
    {
        $dbAcad = Yii::$app->dbAcad;
        $consulta = "SELECT DISTINCT mat.Curso
                     FROM Materias mat
                     INNER JOIN PlanesEstudios pla ON mat.NumeroPlanEstudios = pla.NumeroPlanEstudios AND mat.CodigoCarrera = pla.CodigoCarrera
                     WHERE mat.CodigoCarrera = :codigoCarrera AND mat.NumeroPlanEstudios = :numeroPlanEstudios AND mat.CodigoEstadoMateria = 'A'                                                                     
                     ORDER BY mat.Curso ";
        $instruccion = $dbAcad->createCommand($consulta)
            ->bindParam(":codigoCarrera", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":numeroPlanEstudios", $numeroPlanEstudios, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $cursos = [];
        while ($curso = $lector->readObject(CursoObj::className(), [])) {
            $cursos[] = $curso;
        }
        return $cursos;
    }

    static public function listaMateriasCursoProyectados($codigoCarrera, $codigoSede, $codigoSedeAcad, $numeroPlanEstudios, $curso)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT fac.CodigoFacultad, fac.NombreFacultad, car.CodigoCarrera, car.NombreCarrera, car.NombreCortoCarrera, mat.NumeroPlanEstudios, mat.Curso, mat.SiglaMateria, mat.NombreMateria, 
                            isnull(mat.HorasTeoria,0) AS HorasTeoria, isnull(mat.HorasPractica,0) AS HorasPractica, isnull(mat.HorasLaboratorio,0) AS HorasLaboratorio, chConf.GestionAcademicaAnterior, chConf.GestionAcademicaPlanificacion AS GestionAcademicaActual, 
                            isnull(chPlaAnt.CantGrpsTeoria,0) AS CantGrpsTeoriaAnterior, isnull(chPlaAnt.CantGrpsPractica,0) AS CantGrpsPracticaAnterior, isnull(chPlaAnt.CantGrpsLaboratorio,0) AS CantGrpsLaboratorioAnterior,
                            isnull(chPlaVig.CantGrpsTeoria,0) AS CantGrpsTeoriaActual, isnull(chPlaVig.CantGrpsPractica,0) AS CantGrpsPracticaActual, isnull(chPlaVig.CantGrpsLaboratorio,0) AS CantGrpsLaboratorioActual,
                            CASE WHEN mat.HorasTeoria>0 THEN isnull(estAnt.EstudiantesTeoria,0) WHEN mat.HorasTeoria is null AND mat.HorasPractica>0 THEN isnull(estAnt.EstudiantesPractica,0) WHEN mat.HorasTeoria is null AND mat.HorasPractica is null AND mat.HorasLaboratorio>0 THEN isnull(estAnt.EstudiantesLaboratorio,0) END AS NumEstAnterior, 0 AS NumEstActual
                     FROM Materias mat                     
                     INNER JOIN PlanesEstudios pla ON mat.CodigoCarrera = pla.CodigoCarrera AND mat.NumeroPlanEstudios = pla.NumeroPlanEstudios 
                     INNER JOIN Carreras car ON pla.CodigoCarrera = car.CodigoCarrera
                     INNER JOIN Facultades fac ON car.CodigoFacultad = fac.CodigoFacultad
                     INNER JOIN CargaHorariaConfiguraciones chConf ON car.CodigoCarrera = chConf.CodigoCarrera
                     LEFT JOIN (SELECT CodigoCarrera, NumeroPlanEstudios, SiglaMateria, GestionAcademica, CantGrpsTeoria, CantGrpsPractica, CantGrpsLaboratorio 
                                FROM CargaHorariaPlanificacion
                                WHERE CodigoCarrera = :codigoCarreraAnt AND NumeroPlanEstudios = :numeroPlanEstudiosAnt AND CodigoSedeAcad = :codigoSedeAnt
                                ) AS chPlaAnt ON mat.CodigoCarrera = chPlaAnt.CodigoCarrera AND mat.NumeroPlanEstudios = chPlaAnt.NumeroPlanEstudios AND mat.SiglaMateria = chPlaAnt.SiglaMateria COLLATE Modern_Spanish_CI_AS AND chConf.GestionAcademicaAnterior = chPlaAnt.GestionAcademica
                     LEFT JOIN (SELECT CodigoCarrera, NumeroPlanEstudios, SiglaMateria, GestionAcademica, CodigoModalidadCurso, sum(EstudiantesTeoria) AS EstudiantesTeoria, sum(EstudiantesPractica) AS EstudiantesPractica, sum(EstudiantesLaboratorio) AS EstudiantesLaboratorio  
                                FROM (SELECT CodigoCarrera, NumeroPlanEstudios, SiglaMateria, CodigoTipoGrupoMateria, GestionAcademica, CodigoModalidadCurso,
                                             CASE CodigoTipoGrupoMateria WHEN 'T' THEN sum(isnull(NumeroEstudiantesProgramados,0)) ELSE 0 END AS EstudiantesTeoria,
                                             CASE CodigoTipoGrupoMateria WHEN 'P' THEN sum(isnull(NumeroEstudiantesProgramados,0)) ELSE 0 END AS EstudiantesPractica,
                                             CASE CodigoTipoGrupoMateria WHEN 'L' THEN sum(isnull(NumeroEstudiantesProgramados,0)) ELSE 0 END AS EstudiantesLaboratorio 
                                      FROM MateriasDocentes
                                      WHERE CodigoCarrera = :codigoCarreraEstAnt AND NumeroPlanEstudios = :numeroPlanEstudiosEstAnt AND CodigoSede = :codigoSedeEstAnt
                                      GROUP BY CodigoCarrera, NumeroPlanEstudios, SiglaMateria, CodigoTipoGrupoMateria, GestionAcademica, CodigoModalidadCurso
                                     ) AS estAntTemp
                                GROUP BY CodigoCarrera, NumeroPlanEstudios, SiglaMateria, GestionAcademica, CodigoModalidadCurso                                                              
                                ) AS estAnt ON mat.CodigoCarrera = estAnt.CodigoCarrera AND mat.NumeroPlanEstudios = estAnt.NumeroPlanEstudios AND mat.SiglaMateria = estAnt.SiglaMateria COLLATE Modern_Spanish_CI_AS AND chConf.GestionAcademicaAnterior = estAnt.GestionAcademica COLLATE Modern_Spanish_CI_AS AND chConf.CodigoModalidadCurso = estAnt.CodigoModalidadCurso COLLATE Modern_Spanish_CI_AS
                     LEFT JOIN (SELECT CodigoCarrera, NumeroPlanEstudios, SiglaMateria, GestionAcademica, CantGrpsTeoria, CantGrpsPractica, CantGrpsLaboratorio 
                                FROM CargaHorariaPlanificacion
                                WHERE CodigoCarrera = :codigoCarreraVig AND NumeroPlanEstudios = :numeroPlanEstudiosVig AND CodigoSedeAcad = :codigoSedeVig
                                ) AS chPlaVig ON mat.CodigoCarrera = chPlaVig.CodigoCarrera AND mat.NumeroPlanEstudios = chPlaVig.NumeroPlanEstudios AND mat.SiglaMateria = chPlaVig.SiglaMateria COLLATE Modern_Spanish_CI_AS AND chConf.GestionAcademicaPlanificacion = chPlaVig.GestionAcademica
                     LEFT JOIN (SELECT CodigoCarrera, SiglaMateria, GestionAcademica  
                                FROM vCargaHorariaVigente
                                WHERE CodigoCarrera = :codigoCarreraEstVig AND CodigoSedeAcad = :codigoSedeAcadEstVig                               
                                ) AS estVig ON mat.CodigoCarrera = estVig.CodigoCarrera AND mat.SiglaMateria = estVig.SiglaMateria COLLATE Modern_Spanish_CI_AS AND chConf.GestionAcademicaPlanificacion = estVig.GestionAcademica COLLATE Modern_Spanish_CI_AS 
                     WHERE mat.CodigoCarrera = :codigoCarrera AND chConf.CodigoSedeAcad = :codigoSede AND mat.NumeroPlanEstudios = :numeroPlanEstudios AND mat.Curso = :curso AND mat.CodigoEstadoMateria = 'A' AND chConf.CodigoEstado = 'V'
                     ORDER BY mat.SiglaMateria  ";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":codigoCarreraAnt", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":numeroPlanEstudiosAnt", $numeroPlanEstudios, PDO::PARAM_STR)
            ->bindParam(":codigoSedeAnt", $codigoSede, PDO::PARAM_STR)
            ->bindParam(":codigoCarreraEstAnt", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":numeroPlanEstudiosEstAnt", $numeroPlanEstudios, PDO::PARAM_STR)
            ->bindParam(":codigoSedeEstAnt", $codigoSedeAcad, PDO::PARAM_STR)
            ->bindParam(":codigoCarreraVig", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":numeroPlanEstudiosVig", $numeroPlanEstudios, PDO::PARAM_STR)
            ->bindParam(":codigoSedeVig", $codigoSede, PDO::PARAM_STR)
            ->bindParam(":codigoCarreraEstVig", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":codigoSedeAcadEstVig", $codigoSedeAcad, PDO::PARAM_STR)
            ->bindParam(":codigoCarrera", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":codigoSede", $codigoSede, PDO::PARAM_STR)
            ->bindParam(":numeroPlanEstudios", $numeroPlanEstudios, PDO::PARAM_STR)
            ->bindParam(":curso", $curso, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $materias = [];
        while ($materia = $lector->readObject(MateriaPlanificacionObj::className(), [])) {
            $materias[] = $materia;
        }
        return $materias;
    }

    /*====================
    LISTA DOCENTES DATOS ACTUAL
    =======================*/
    static public function listaDocentesMateria($codigoCarrera, $codigoSede, $numeroPlanEstudios, $siglaMateria)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT IdPersona, isnull(Paterno,'') AS Paterno, isnull(Materno,'') AS Materno, Nombres, isnull(Paterno,'')+' '+isnull(Materno,'')+' '+Nombres AS NombreCompleto, --upper(CondicionLaboral) AS CondicionLaboral,
                            sum(CantGrpsTeoria) AS CantGrpsTeoria, sum(CantGrpsPractica) AS CantGrpsPractica, sum(CantGrpsLaboratorio) AS CantGrpsLaboratorio, sum(HorasMesTeoria) AS HorasMesTeoria, sum(HorasMesPractica) AS HorasMesPractica, sum(HorasMesLaboratorio) AS HorasMesLaboratorio, sum(TotalHorasMes) AS TotalHorasMes
                     FROM(
                         SELECT per.IdPersona, per.Paterno, per.Materno, per.Nombres, --CondicionLaboral, 
                                0 AS CantGrpsTeoria, 0 AS CantGrpsPractica, 0 AS CantGrpsLaboratorio, 0 AS HorasMesTeoria, 0 AS HorasMesPractica, 0 AS HorasMesLaboratorio, sum(HorasSemana*4) AS TotalHorasMes
                         FROM vCargaHorariaVigente chAct
                         INNER JOIN Personas per ON chAct.IdPersona = per.IdPersona                         
                         WHERE CodigoCarrera = :codigoCarreraTot AND NumeroPlanEstudios = :numeroPlanEstudiosTot AND SiglaMateria = :siglaMateriaTot --AND CodigoCondicionLaboral <> 'DCS' 
						 AND CodigoSedeAcad = :codigoSedeTot AND 
                               (FechaInicio < getDate()) AND (FechaFinal IS NULL OR FechaFinal > getDate())
                         GROUP BY per.IdPersona, per.Paterno, per.Materno, per.Nombres--, CondicionLaboral
                         UNION
                         SELECT IdPersona, Paterno, Materno, Nombres, --CondicionLaboral, 
                                isnull([T],0) AS CantGrpsTeoria, isnull([P],0) AS CantGrpsPractica, isnull([L],0) AS CantGrpsLaboratorio, 0 AS HorasMesTeoria, 0 AS HorasMesPractica, 0 AS HorasMesLaboratorio, 0 AS TotalHorasMes
                         FROM(                         
                             SELECT per.IdPersona, per.Paterno, per.Materno, per.Nombres,-- CondicionLaboral, 
							 TipoGrupo, Grupo
                             FROM vCargaHorariaVigente chAct
                             INNER JOIN Personas per ON chAct.IdPersona = per.IdPersona                             
                             WHERE CodigoCarrera = :codigoCarreraGrps AND NumeroPlanEstudios = :numeroPlanEstudiosGrps AND SiglaMateria = :siglaMateriaGrps --AND CodigoCondicionLaboral <> 'DCS' 
							 AND CodigoSedeAcad = :codigoSedeGrps AND 
                                   (FechaInicio < getDate()) AND (FechaFinal IS NULL OR FechaFinal > getDate())
                             ) AS TablaFuente
                         PIVOT  
                             (count(Grupo)
                              FOR TipoGrupo IN ([T], [P], [L])  
                             ) AS TablaPivot
                         UNION
                         SELECT IdPersona, Paterno, Materno, Nombres,-- CondicionLaboral, 
                                0 AS CantGrpsTeoria, 0 AS CantGrpsPractica, 0 AS CantGrpsLaboratorio, isnull([T],0) AS HorasMesTeoria, isnull([P],0) AS HorasMesPractica, isnull([L],0) AS HorasMesLaboratorio, 0 AS TotalHorasMes
                         FROM(                         
                             SELECT per.IdPersona, per.Paterno, per.Materno, per.Nombres, --CondicionLaboral, 
							 TipoGrupo, HorasSemana*4 AS HorasMes
                             FROM vCargaHorariaVigente chAct
                             INNER JOIN Personas per ON chAct.IdPersona = per.IdPersona                             
                             WHERE CodigoCarrera = :codigoCarreraHrs AND NumeroPlanEstudios = :numeroPlanEstudiosHrs AND SiglaMateria = :siglaMateriaHrs AND --CodigoCondicionLaboral <> 'DCS' AND 
							 CodigoSedeAcad = :codigoSedeHrs AND 
                                   (FechaInicio < getDate()) AND (FechaFinal IS NULL OR FechaFinal > getDate())
                             ) AS TablaFuente
                         PIVOT  
                             (sum(HorasMes)
                              FOR TipoGrupo IN ([T], [P], [L])  
                             ) AS TablaPivot                                                     
                         ) AS doc
                     GROUP BY IdPersona, Paterno, Materno, Nombres--, CondicionLaboral";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":codigoCarreraTot", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":codigoCarreraGrps", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":codigoCarreraHrs", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":numeroPlanEstudiosTot", $numeroPlanEstudios, PDO::PARAM_STR)
            ->bindParam(":numeroPlanEstudiosGrps", $numeroPlanEstudios, PDO::PARAM_STR)
            ->bindParam(":numeroPlanEstudiosHrs", $numeroPlanEstudios, PDO::PARAM_STR)
            ->bindParam(":siglaMateriaTot", $siglaMateria, PDO::PARAM_STR)
            ->bindParam(":siglaMateriaGrps", $siglaMateria, PDO::PARAM_STR)
            ->bindParam(":siglaMateriaHrs", $siglaMateria, PDO::PARAM_STR)
            ->bindParam(":codigoSedeTot", $codigoSede, PDO::PARAM_STR)
            ->bindParam(":codigoSedeGrps", $codigoSede, PDO::PARAM_STR)
            ->bindParam(":codigoSedeHrs", $codigoSede, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $docentes = [];
        while ($docente = $lector->readObject(DocenteMateriaObj::className(), [])) {
            $docentes[] = $docente;
        }
        return $docentes;
    }

    /*==============================================================
    LISTA DOCENTES DATOS POR MATERIA ANTERIOR
    ================================================================*/
    static public function listaDocentesMateriaAnterior($codigoCarrera, $codigoSede, $numeroPlanEstudios, $siglaMateria, $gestion, $mes)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT CodigoTrabajador, IdPersona, Paterno, Materno, Nombres, NombreCompleto, CondicionLaboral, 
                            sum(CantGrpsTeoria) AS CantGrpsTeoria, sum(CantGrpsPractica) AS CantGrpsPractica, sum(CantGrpsLaboratorio) AS CantGrpsLaboratorio,
                            sum(HorasMesTeoria) AS HorasMesTeoria, sum(HorasMesPractica) AS HorasMesPractica, sum(HorasMesLaboratorio) AS HorasMesLaboratorio, sum(HorasMesTeoria + HorasMesPractica + HorasMesLaboratorio) AS TotalHorasMes
                     FROM(
                         SELECT tra.CodigoTrabajador, per.IdPersona, isnull(Paterno,'') AS Paterno, isnull(Materno,'') AS Materno, Nombres, isnull(Paterno,'')+' '+isnull(Materno,'')+' '+Nombres AS NombreCompleto, upper(Categoria) AS CondicionLaboral,
                                CASE WHEN GruposTeoria > 0 THEN count(DISTINCT GrupoMateria) ELSE 0 END AS CantGrpsTeoria, 
                                CASE WHEN GruposPractica > 0 THEN count(DISTINCT GrupoMateria) ELSE 0 END AS CantGrpsPractica, 
                                CASE WHEN GruposLaboratorio > 0 THEN count(DISTINCT GrupoMateria) ELSE 0 END AS CantGrpsLaboratorio, 
                                CASE WHEN GruposTeoria > 0 THEN sum(HorasMesTeoria) ELSE 0 END AS HorasMesTeoria, 
                                CASE WHEN GruposPractica > 0 THEN sum(HorasMesPractica) ELSE 0 END AS HorasMesPractica, 
                                CASE WHEN GruposLaboratorio > 0 THEN sum(HorasMesLaboratorio) ELSE 0 END AS HorasMesLaboratorio,
                                0 AS TotalHorasMes
                        FROM vCargaHorariaMensual chMen
                        INNER JOIN Trabajadores tra ON chMen.IdPersona = tra.IdPersona
                        INNER JOIN Personas per ON tra.IdPersona = per.IdPersona
                        WHERE CodigoCarrera = :codigoCarrera AND NumeroPlanEstudios = :numeroPlanEstudios AND SiglaMateria = :siglaMateria AND Sede = :codigoSede AND Gestion = :gestion AND Mes = :mes                    
                        GROUP BY tra.CodigoTrabajador, per.IdPersona, Paterno, Materno, Nombres, Categoria, GruposTeoria, GruposPractica, GruposLaboratorio 
                     ) AS chMenTemp
                     GROUP BY CodigoTrabajador, IdPersona, Paterno, Materno, Nombres, NombreCompleto, CondicionLaboral";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":codigoCarrera", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":numeroPlanEstudios", $numeroPlanEstudios, PDO::PARAM_STR)
            ->bindParam(":siglaMateria", $siglaMateria, PDO::PARAM_STR)
            ->bindParam(":codigoSede", $codigoSede, PDO::PARAM_STR)
            ->bindParam(":gestion", $gestion, PDO::PARAM_STR)
            ->bindParam(":mes", $mes, PDO::PARAM_STR);
        echo $instruccion->getRawSql();
        $lector = $instruccion->query();
        $docentes = [];
        while ($docente = $lector->readObject(DocenteMateriaObj::className(), [])) {
            $docentes[] = $docente;
        }
        return $docentes;
    }

    /*==============================================================
    LISTA MATERIAS DE UN CURSO DE UN PLAN DE ESTUDIOS DE UNA CARRERA (ANTERIOR)
    ================================================================*/
    static public function listaMateriasDocentes($codigoCarrera, $codigoSede, $codigoSedeAcad, $numeroPlanEstudios, $siglaMateria, $tipoGrupo, $gestionAcademica)
    {
        $dbRRHH = Yii::$app->dbAcad;
        $consulta = "SELECT fac.CodigoFacultad, fac.NombreFacultad, car.CodigoCarrera, car.NombreCarrera, car.NombreCortoCarrera, mat.NumeroPlanEstudios, mat.Curso, mat.SiglaMateria, mat.NombreMateria, matDoc.Grupo, matDoc.CodigoTipoGrupoMateria AS TipoGrupo,
                            per.IdPersona, isnull(Paterno,'') AS Paterno, isnull(Materno,'') AS Materno, Nombres, isnull(Paterno,'')+' '+isnull(Materno,'')+' '+Nombres AS NombreCompleto, NumeroEstudiantesLimite, NumeroEstudiantesProgramados, CASE TransferidoCargaHoraria WHEN 0 THEN 'NO' WHEN 1 THEN 'SI' ELSE 'ERROR' END AS InformadoCargaHoraria
                     FROM MateriasDocentes matDoc
                     INNER JOIN Materias mat ON matDoc.CodigoCarrera = mat.CodigoCarrera AND matDoc.NumeroPlanEstudios = mat.NumeroPlanEstudios AND matDoc.SiglaMateria = mat.SiglaMateria
                     INNER JOIN PlanesEstudios pla ON mat.CodigoCarrera = pla.CodigoCarrera AND mat.NumeroPlanEstudios = pla.NumeroPlanEstudios 
                     INNER JOIN Carreras car ON pla.CodigoCarrera = car.CodigoCarrera
                     INNER JOIN Facultades fac ON car.CodigoFacultad = fac.CodigoFacultad
                     INNER JOIN [172.17.1.30].[RecursosHumanos].dbo.CargaHorariaConfiguraciones chConf ON car.CodigoCarrera = chConf.CodigoCarrera AND matDoc.CodigoModalidadCurso = chConf.CodigoModalidadCurso COLLATE Modern_Spanish_CI_AS
                     INNER JOIN [172.17.1.30].[RecursosHumanos].dbo.Personas per ON matDoc.IdPersona = per.IdPersona COLLATE Modern_Spanish_CI_AS                     
                     WHERE mat.CodigoCarrera = :codigoCarrera AND matDoc.CodigoSede = :codigoSedeAcad AND mat.NumeroPlanEstudios = :numeroPlanEstudios AND matDoc.SiglaMateria = :siglaMateria AND matDoc.CodigoTipoGrupoMateria = :tipoGrupo AND matDoc.GestionAcademica = :gestionAcademica AND mat.CodigoEstadoMateria = 'A' AND chConf.CodigoEstado = 'V' AND TransferidoCargaHoraria = 1
                     ORDER BY mat.SiglaMateria ";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":codigoCarrera", $codigoCarrera, PDO::PARAM_STR)
            //->bindParam(":codigoSede", $codigoSede, PDO::PARAM_STR)
            ->bindParam(":codigoSedeAcad", $codigoSedeAcad, PDO::PARAM_STR)
            ->bindParam(":numeroPlanEstudios", $numeroPlanEstudios, PDO::PARAM_STR)
            ->bindParam(":siglaMateria", $siglaMateria, PDO::PARAM_STR)
            ->bindParam(":tipoGrupo", $tipoGrupo, PDO::PARAM_STR)
            ->bindParam(":gestionAcademica", $gestionAcademica, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $materias = [];
        while ($materia = $lector->readObject(MateriaAcademicaObj::className(), [])) {
            $materias[] = $materia;
        }
        return $materias;
    }

    /*==============================================================
LISTA MATERIAS DE UN CURSO DE UN PLAN DE ESTUDIOS DE UNA CARRERA (ACTUAL)
================================================================*/
    static public function listaMateriasDocentesActual($codigoCarrera, $codigoSede, $codigoSedeAcad, $numeroPlanEstudios, $siglaMateria, $tipoGrupo, $gestionAcademica)
    {
        $dbRRHH = Yii::$app->dbAcad;
        $consulta = "SELECT fac.CodigoFacultad, fac.NombreFacultad, car.CodigoCarrera, car.NombreCarrera, car.NombreCortoCarrera, mat.NumeroPlanEstudios, mat.Curso, mat.SiglaMateria, mat.NombreMateria, matDoc.Grupo, matDoc.CodigoTipoGrupoMateria AS TipoGrupo,
                            per.IdPersona, isnull(Paterno,'') AS Paterno, isnull(Materno,'') AS Materno, Nombres, isnull(Paterno,'')+' '+isnull(Materno,'')+' '+Nombres AS NombreCompleto, NumeroEstudiantesLimite, NumeroEstudiantesProgramados, CASE TransferidoCargaHoraria WHEN 0 THEN 'NO' WHEN 1 THEN 'SI' ELSE 'ERROR' END AS InformadoCargaHoraria
                     FROM MateriasDocentes matDoc
                     INNER JOIN Materias mat ON matDoc.CodigoCarrera = mat.CodigoCarrera AND matDoc.NumeroPlanEstudios = mat.NumeroPlanEstudios AND matDoc.SiglaMateria = mat.SiglaMateria
                     INNER JOIN PlanesEstudios pla ON mat.CodigoCarrera = pla.CodigoCarrera AND mat.NumeroPlanEstudios = pla.NumeroPlanEstudios 
                     INNER JOIN Carreras car ON pla.CodigoCarrera = car.CodigoCarrera
                     INNER JOIN Facultades fac ON car.CodigoFacultad = fac.CodigoFacultad
                     INNER JOIN [172.17.1.30].[RecursosHumanos].dbo.CargaHorariaConfiguraciones chConf ON car.CodigoCarrera = chConf.CodigoCarrera AND matDoc.CodigoModalidadCurso = chConf.CodigoModalidadCurso COLLATE Modern_Spanish_CI_AS
                     INNER JOIN [172.17.1.30].[RecursosHumanos].dbo.Personas per ON matDoc.IdPersona = per.IdPersona COLLATE Modern_Spanish_CI_AS                     
                     WHERE mat.CodigoCarrera = :codigoCarrera AND matDoc.CodigoSede = :codigoSedeAcad AND mat.NumeroPlanEstudios = :numeroPlanEstudios AND matDoc.SiglaMateria = :siglaMateria AND matDoc.CodigoTipoGrupoMateria = :tipoGrupo AND matDoc.GestionAcademica = :gestionAcademica AND mat.CodigoEstadoMateria = 'A' AND chConf.CodigoEstado = 'V' AND TransferidoCargaHoraria = 1
                     ORDER BY mat.SiglaMateria ";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":codigoCarrera", $codigoCarrera, PDO::PARAM_STR)
            //->bindParam(":codigoSede", $codigoSede, PDO::PARAM_STR)
            ->bindParam(":codigoSedeAcad", $codigoSedeAcad, PDO::PARAM_STR)
            ->bindParam(":numeroPlanEstudios", $numeroPlanEstudios, PDO::PARAM_STR)
            ->bindParam(":siglaMateria", $siglaMateria, PDO::PARAM_STR)
            ->bindParam(":tipoGrupo", $tipoGrupo, PDO::PARAM_STR)
            ->bindParam(":gestionAcademica", $gestionAcademica, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $materias = [];
        while ($materia = $lector->readObject(MateriaAcademicaObj::className(), [])) {
            $materias[] = $materia;
        }
        return $materias;
    }

    /*==============================
    LISTA ACEFALIAS POR CARRERA
    ================================*/
    static public function listaAcefaliasResumen($codigoCarrera, $codigoSede, $gestionAcademica)
    {
        $dbRRHH = Yii::$app->dbAcad;
        $consulta = "select R.CodigoCarrera, C.NombreCarrera, R.CodigoSede, S.NombreSede, R.NumeroPlanEstudios, M.Curso, R.SiglaMateria, M.NombreMateria, R.CargaHoraria AS HorasMesCh, R.propuesta AS HorasMesProp
                    from (select Vigente.CodigoCarrera, Vigente.CodigoSede, Vigente.NumeroPlanEstudios,Vigente.SiglaMateria,Vigente.CargaHoraria,isnull(Propuesta.CargaHoraria,0) as propuesta
                        from (select ch.CodigoCarrera,ch.CodigoSede,ch.NumeroPlanEstudios,ch.SiglaMateria,
                                    (SUM(ch.HorasTeoria)+SUM(ch.HorasPractica)+SUM(ch.HorasLaboratorio))*4 CargaHoraria
                                from (select Dch.CodigoCarrera,Dch.CodigoSede,Dch.NumeroPlanEstudios,M.SiglaMateria,
                                        CASE WHEN dch.CodigoTipoGrupo='T'  THEN sum(M.HorasTeoria) ELSE 0 END AS HorasTeoria,
                                        CASE WHEN dch.CodigoTipoGrupo='P'  THEN sum(M.HorasPractica) ELSE 0 END AS HorasPractica,
                                        CASE WHEN dch.CodigoTipoGrupo='L'  THEN sum(M.HorasLaboratorio) ELSE 0 END AS  HorasLaboratorio
                                    from DetalleCargaHoraria Dch 
                                    inner join Materias M on M.CodigoCarrera = Dch.CodigoCarrera and Dch.SiglaMateria = M.SiglaMateria
                                    where Dch.IdPersona = 'ACE0001' and Dch.GestionAcademica = :gestionAcademica1 and Dch.CodigoCarrera = :codigoCarrera1 and Dch.CodigoSede = :codigoSede1
                                    group by Dch.CodigoCarrera,Dch.CodigoSede,Dch.NumeroPlanEstudios,M.SiglaMateria,dch.CodigoTipoGrupo) as ch 
                                group by ch.CodigoCarrera,ch.CodigoSede,ch.NumeroPlanEstudios,ch.SiglaMateria) Vigente  
                        left join 
                            (select	ch.CodigoCarrera,ch.CodigoSede,ch.NumeroPlanEstudios,ch.SiglaMateria,
                                    (SUM(ch.HorasTeoria)+SUM(ch.HorasPractica)+SUM(ch.HorasLaboratorio))*4 CargaHoraria
                                from (select Dch.CodigoCarrera,Dch.CodigoSede,Dch.NumeroPlanEstudios,M.SiglaMateria,
                                        CASE WHEN dch.CodigoTipoGrupo='T'  THEN sum(M.HorasTeoria) ELSE 0 END AS HorasTeoria,
                                        CASE WHEN dch.CodigoTipoGrupo='P'  THEN sum(M.HorasPractica) ELSE 0 END AS HorasPractica,
                                        CASE WHEN dch.CodigoTipoGrupo='L'  THEN sum(M.HorasLaboratorio) ELSE 0 END AS  HorasLaboratorio
                                    from DetalleCargaHoraria Dch 
                                    inner join Materias M on M.CodigoCarrera = Dch.CodigoCarrera and Dch.SiglaMateria = M.SiglaMateria
                                    where Dch.IdPersona = 'ACE0001' and Dch.GestionAcademica = :gestionAcademica2 and Dch.CodigoCarrera = :codigoCarrera2 and Dch.CodigoSede = :codigoSede2
                                    group by Dch.CodigoCarrera,Dch.CodigoSede,Dch.NumeroPlanEstudios,M.SiglaMateria,dch.CodigoTipoGrupo) as ch 
                                group by ch.CodigoCarrera,ch.CodigoSede,ch.NumeroPlanEstudios,ch.SiglaMateria) Propuesta on Vigente.CodigoCarrera = Propuesta.CodigoCarrera and 
                                Vigente.CodigoSede = Propuesta.CodigoSede and Vigente.NumeroPlanEstudios = Propuesta.NumeroPlanEstudios
                        union 
                        select Vigente.CodigoCarrera, Vigente.CodigoSede, Vigente.NumeroPlanEstudios,Vigente.SiglaMateria,Vigente.CargaHoraria,isnull(Propuesta.CargaHoraria,0) as propuesta
                        from(select 
                                    ch.CodigoCarrera,ch.CodigoSede,ch.NumeroPlanEstudios,ch.SiglaMateria,
                                    (SUM(ch.HorasTeoria)+SUM(ch.HorasPractica)+SUM(ch.HorasLaboratorio))*4 CargaHoraria
                                from (select Dch.CodigoCarrera,Dch.CodigoSede,Dch.NumeroPlanEstudios,M.SiglaMateria,
                                        CASE WHEN dch.CodigoTipoGrupo='T'  THEN sum(M.HorasTeoria) ELSE 0 END AS HorasTeoria,
                                        CASE WHEN dch.CodigoTipoGrupo='P'  THEN sum(M.HorasPractica) ELSE 0 END AS HorasPractica,
                                        CASE WHEN dch.CodigoTipoGrupo='L'  THEN sum(M.HorasLaboratorio) ELSE 0 END AS  HorasLaboratorio
                                    from DetalleCargaHoraria Dch 
                                    inner join Materias M on M.CodigoCarrera = Dch.CodigoCarrera and Dch.SiglaMateria = M.SiglaMateria
                                    where Dch.IdPersona = 'ACE0001' and Dch.GestionAcademica = :gestionAcademica3 and Dch.CodigoCarrera = :codigoCarrera3 and Dch.CodigoSede = :codigoSede3
                                    group by Dch.CodigoCarrera,Dch.CodigoSede,Dch.NumeroPlanEstudios,M.SiglaMateria,dch.CodigoTipoGrupo) as ch 
                                group by ch.CodigoCarrera,ch.CodigoSede,ch.NumeroPlanEstudios,ch.SiglaMateria) Propuesta  
                        left join 
                            (select ch.CodigoCarrera,ch.CodigoSede,ch.NumeroPlanEstudios,ch.SiglaMateria,
                                    (SUM(ch.HorasTeoria)+SUM(ch.HorasPractica)+SUM(ch.HorasLaboratorio))*4 CargaHoraria
                                from (select Dch.CodigoCarrera,Dch.CodigoSede,Dch.NumeroPlanEstudios,M.SiglaMateria,
                                      CASE WHEN dch.CodigoTipoGrupo='T'  THEN sum(M.HorasTeoria) ELSE 0 END AS HorasTeoria,
                                      CASE WHEN dch.CodigoTipoGrupo='P'  THEN sum(M.HorasPractica) ELSE 0 END AS HorasPractica,
                                      CASE WHEN dch.CodigoTipoGrupo='L'  THEN sum(M.HorasLaboratorio) ELSE 0 END AS  HorasLaboratorio
                                    from DetalleCargaHoraria Dch inner join Materias M on M.CodigoCarrera = Dch.CodigoCarrera and Dch.SiglaMateria = M.SiglaMateria
                                    where Dch.IdPersona = 'ACE0001' and Dch.GestionAcademica = :gestionAcademica4 and Dch.CodigoCarrera = :codigoCarrera4 and Dch.CodigoSede = :codigoSede4
                                    group by Dch.CodigoCarrera,Dch.CodigoSede,Dch.NumeroPlanEstudios,M.SiglaMateria,dch.CodigoTipoGrupo) as ch 
                                group by ch.CodigoCarrera,ch.CodigoSede,ch.NumeroPlanEstudios,ch.SiglaMateria) Vigente on Propuesta.CodigoCarrera = Vigente.CodigoCarrera and 
                                Propuesta.CodigoSede = Vigente.CodigoSede and Propuesta.NumeroPlanEstudios = Vigente.NumeroPlanEstudios ) R 
                            inner join Carreras C on R.CodigoCarrera = C.CodigoCarrera
                            inner join Sedes S on R.CodigoSede = S.CodigoSede
                            inner join Materias M on M.CodigoCarrera = R.CodigoCarrera and M.NumeroPlanEstudios = R.NumeroPlanEstudios  and R.SiglaMateria = M.SiglaMateria";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":codigoCarrera1", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":codigoCarrera2", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":codigoCarrera3", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":codigoCarrera4", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":codigoSede1", $codigoSede, PDO::PARAM_STR)
            ->bindParam(":codigoSede2", $codigoSede, PDO::PARAM_STR)
            ->bindParam(":codigoSede3", $codigoSede, PDO::PARAM_STR)
            ->bindParam(":codigoSede4", $codigoSede, PDO::PARAM_STR)
            ->bindParam(":gestionAcademica1", $gestionAcademica, PDO::PARAM_STR)
            ->bindParam(":gestionAcademica2", $gestionAcademica, PDO::PARAM_STR)
            ->bindParam(":gestionAcademica3", $gestionAcademica, PDO::PARAM_STR)
            ->bindParam(":gestionAcademica4", $gestionAcademica, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $acefalias = [];
        while ($acefalia = $lector->readObject(MateriaAcefaliaResumenObj::className(), [])) {
            $acefalias[] = $acefalia;
        }
        return $acefalias;
    }

    static public function listaAcefaliasDetalle($codigoCarrera, $codigoSede, $gestionAcademica)
    {
        $dbRRHH = Yii::$app->dbAcad;
        $consulta = "select R.CodigoCarrera, C.NombreCarrera, R.CodigoSede, S.NombreSede, R.NumeroPlanEstudios, M.Curso, R.SiglaMateria, M.NombreMateria,R.Grupo,
                          CASE R.CodigoTipoGrupo WHEN 'T' THEN 'TEORIA'  WHEN 'P' THEN 'PRACTICA' WHEN 'L' THEN 'LABORATORIO' ELSE NULL END AS TipoGrupoLiteral, 
                          R.HorasSemana*4 AS HorasMesCh, R.propuesta*4 AS HorasMesProp
                      from (select Vigente.CodigoCarrera, Vigente.CodigoSede, Vigente.NumeroPlanEstudios,Vigente.SiglaMateria,Vigente.CodigoTipoGrupo, Vigente.HorasSemana,isnull(Propuesta.HorasSemana,0) as propuesta, Vigente.Grupo
                          from(select Dch.CodigoCarrera,Dch.CodigoSede,Dch.NumeroPlanEstudios,M.SiglaMateria,Dch.CodigoTipoGrupo, Dch.Grupo,
                                      CASE WHEN dch.CodigoTipoGrupo='T'  THEN (M.HorasTeoria) WHEN dch.CodigoTipoGrupo='P' then (M.HorasPractica) WHEN dch.CodigoTipoGrupo='L' then (M.HorasLaboratorio) ELSE 0 END AS HorasSemana				
                               from DetalleCargaHoraria Dch inner join Materias M on M.CodigoCarrera = Dch.CodigoCarrera and Dch.SiglaMateria = M.SiglaMateria and Dch.NumeroPlanEstudios = M.NumeroPlanEstudios
                               where Dch.IdPersona = 'ACE0001' and Dch.GestionAcademica = :gestionAcademica1 and Dch.CodigoCarrera = :codigoCarrera1 AND Dch.CodigoSede = :codigoSede1) Vigente  
                      left join 
                         (select Dch.CodigoCarrera,Dch.CodigoSede,Dch.NumeroPlanEstudios,M.SiglaMateria,Dch.CodigoTipoGrupo, Dch.Grupo,
                                  CASE WHEN dch.CodigoTipoGrupo='T'  THEN (M.HorasTeoria) WHEN dch.CodigoTipoGrupo='P' then (M.HorasPractica) WHEN dch.CodigoTipoGrupo='L' then (M.HorasLaboratorio) ELSE 0 END AS HorasSemana				
                           from DetalleCargaHoraria Dch inner join Materias M on M.CodigoCarrera = Dch.CodigoCarrera and Dch.SiglaMateria = M.SiglaMateria and Dch.NumeroPlanEstudios = M.NumeroPlanEstudios
                           where Dch.IdPersona = 'ACE0001' and Dch.GestionAcademica = :gestionAcademica2 and Dch.CodigoCarrera = :codigoCarrera2 and Dch.CodigoSede = :codigoSede2) Propuesta 
                              on Vigente.CodigoCarrera = Propuesta.CodigoCarrera and Vigente.CodigoSede = Propuesta.CodigoSede and Vigente.NumeroPlanEstudios = Propuesta.NumeroPlanEstudios and Vigente.SiglaMateria = Propuesta.SiglaMateria and  Vigente.CodigoTipoGrupo = Propuesta.CodigoTipoGrupo
                      union 
                      select Vigente.CodigoCarrera, Vigente.CodigoSede, Vigente.NumeroPlanEstudios,Vigente.SiglaMateria,Vigente.CodigoTipoGrupo,Vigente.HorasSemana,isnull(Propuesta.HorasSemana,0) as propuesta, Vigente.Grupo
                      from(select Dch.CodigoCarrera,Dch.CodigoSede,Dch.NumeroPlanEstudios,M.SiglaMateria,Dch.CodigoTipoGrupo, Dch.Grupo,
                           CASE WHEN dch.CodigoTipoGrupo='T'  THEN (M.HorasTeoria) WHEN dch.CodigoTipoGrupo='P' then (M.HorasPractica) WHEN dch.CodigoTipoGrupo='L' then (M.HorasLaboratorio) ELSE 0 END AS HorasSemana				
                           from DetalleCargaHoraria Dch inner join Materias M on M.CodigoCarrera = Dch.CodigoCarrera and Dch.SiglaMateria = M.SiglaMateria and Dch.NumeroPlanEstudios = M.NumeroPlanEstudios
                           where Dch.IdPersona = 'ACE0001' and Dch.GestionAcademica = :gestionAcademica3 and Dch.CodigoCarrera = :codigoCarrera3 and Dch.CodigoSede = :codigoSede3) Propuesta 
                      left join 
                          (select Dch.CodigoCarrera,Dch.CodigoSede,Dch.NumeroPlanEstudios,M.SiglaMateria,Dch.CodigoTipoGrupo, Dch.Grupo,
                           CASE WHEN dch.CodigoTipoGrupo='T'  THEN (M.HorasTeoria) WHEN dch.CodigoTipoGrupo='P' then (M.HorasPractica) WHEN dch.CodigoTipoGrupo='L' then (M.HorasLaboratorio) ELSE 0 END AS HorasSemana				
                           from DetalleCargaHoraria Dch inner join Materias M on M.CodigoCarrera = Dch.CodigoCarrera and Dch.SiglaMateria = M.SiglaMateria and Dch.NumeroPlanEstudios = M.NumeroPlanEstudios
                           where Dch.IdPersona = 'ACE0001' and Dch.GestionAcademica = :gestionAcademica4 and Dch.CodigoCarrera = :codigoCarrera4 and Dch.CodigoSede = :codigoSede4) Vigente  
                              on Propuesta.CodigoCarrera = Vigente.CodigoCarrera and Propuesta.CodigoSede = Vigente.CodigoSede and Propuesta.NumeroPlanEstudios = Vigente.NumeroPlanEstudios and Propuesta.SiglaMateria = Vigente.SiglaMateria and Propuesta.CodigoTipoGrupo = Vigente.CodigoTipoGrupo
                              ) R inner join Carreras C on R.CodigoCarrera = C.CodigoCarrera
                          inner join Sedes S on R.CodigoSede = S.CodigoSede
                          inner join Materias M on M.CodigoCarrera = R.CodigoCarrera and M.NumeroPlanEstudios = R.NumeroPlanEstudios  and R.SiglaMateria = M.SiglaMateria 
                          ORDER BY Curso, NumeroPlanEstudios, SiglaMateria, TipoGrupoLiteral DESC";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":codigoCarrera1", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":codigoSede1", $codigoSede, PDO::PARAM_STR)
            ->bindParam(":codigoCarrera2", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":codigoSede2", $codigoSede, PDO::PARAM_STR)
            ->bindParam(":codigoCarrera3", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":codigoSede3", $codigoSede, PDO::PARAM_STR)
            ->bindParam(":codigoCarrera4", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":codigoSede4", $codigoSede, PDO::PARAM_STR)
            ->bindParam(":gestionAcademica1", $gestionAcademica, PDO::PARAM_STR)
            ->bindParam(":gestionAcademica3", $gestionAcademica, PDO::PARAM_STR)
            ->bindParam(":gestionAcademica2", $gestionAcademica, PDO::PARAM_STR)
            ->bindParam(":gestionAcademica4", $gestionAcademica, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $acefalias = [];
        while ($acefalia = $lector->readObject(MateriaAcefaliaDetalleObj::className(), [])) {
            $acefalias[] = $acefalia;
        }
        return $acefalias;
    }

    /*==============================
    LISTA SUPLENCIAS POR CARRERA
    ================================*/
    static public function listaSuplenciasResumen($codigoCarrera, $codigoSede)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT CodigoCarrera, NumeroPlanEstudios, Curso, SiglaMateria, NombreMateria, 
                            per.IdPersona, isnull(per.Paterno,'') AS Paterno, isnull(per.Materno,'') AS Materno, per.Nombres, isnull(per.Paterno,'')+' '+isnull(per.Materno,'')+' '+per.Nombres AS NombreCompleto,
                            upper(CondicionLaboral) AS CondicionLaboral, TipoDeclaratoria, FechaInicio, FechaFin, sum(HorasSemana*4) AS HorasMes
                     FROM vCargaHorariaDeclaratorias chDec
                     INNER JOIN Personas per ON chDec.IdPersona = per.IdPersona
                     WHERE CodigoCarrera = :codigoCarrera AND Sede = :codigoSede AND (FechaInicio < getDate()) AND (FechaFin IS NULL OR FechaFin > getDate())
                     GROUP BY CodigoCarrera, NumeroPlanEstudios, Curso, SiglaMateria, NombreMateria, per.IdPersona, isnull(per.Paterno,''), isnull(per.Materno,''), per.Nombres, isnull(per.Paterno,'')+' '+isnull(per.Materno,'')+' '+per.Nombres, CondicionLaboral, TipoDeclaratoria, FechaInicio, FechaFin
                     ORDER BY Curso, NumeroPlanEstudios, SiglaMateria";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":codigoCarrera", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":codigoSede", $codigoSede, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $suplencias = [];
        while ($suplencia = $lector->readObject(MateriaSuplenciaResumenObj::className(), [])) {
            $suplencias[] = $suplencia;
        }
        return $suplencias;
    }

    static public function listaSuplenciasDetalle($codigoCarrera, $codigoSede)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT CodigoCarrera, NumeroPlanEstudios, Curso, SiglaMateria, NombreMateria, Grupo, CASE TipoGrupo WHEN  'T' THEN 'TEORIA' WHEN  'P' THEN 'PRACTICA' WHEN  'L' THEN 'LABORATORIO' ELSE NULL END AS TipoGrupoLiteral, 
                     per.IdPersona, isnull(per.Paterno,'') AS Paterno, isnull(per.Materno,'') AS Materno, per.Nombres, isnull(per.Paterno,'')+' '+isnull(per.Materno,'')+' '+per.Nombres AS NombreCompleto, 
                     upper(CondicionLaboral) AS CondicionLaboral, TipoDeclaratoria, FechaInicio, FechaFin, HorasSemana*4 AS HorasMes
                     FROM vCargaHorariaDeclaratorias chDec
                     INNER JOIN Personas per ON chDec.IdPersona = per.IdPersona
                     WHERE CodigoCarrera = :codigoCarrera AND Sede = :codigoSede AND (FechaInicio < getDate()) AND (FechaFin IS NULL OR FechaFin > getDate())
                     ORDER BY Curso, NumeroPlanEstudios, SiglaMateria, TipoGrupoLiteral DESC";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":codigoCarrera", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":codigoSede", $codigoSede, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $suplencias = [];
        while ($suplencia = $lector->readObject(MateriaSuplenciaDetalleObj::className(), [])) {
            $suplencias[] = $suplencia;
        }
        return $suplencias;
    }

    /*====================
    LISTA DOCENTES DATOS
    =======================*/
    static public function listaDocentesCarrera($codigoCarrera, $codigoSede, $gestionAcademica)
    {
        $dbRRHH = Yii::$app->dbPrue;
        $consulta = "SELECT IdPersona, upper(isnull(Paterno,'')) AS Paterno, upper(isnull(Materno,'')) AS Materno, upper(Nombres) AS Nombres, upper(isnull(Paterno,'')+' '+isnull(Materno,'')+' '+Nombres) AS NombreCompleto, upper(CondicionLaboral) AS CondicionLaboral,
					        sum(TotalHorasMesCh) AS TotalHorasMesCh, isnull(sum(TotalHorasMesProp),0) AS TotalHorasMesProp
					 FROM(SELECT per.IdPersona, per.Paterno, per.Materno, per.Nombres, cl.NombreCondicionLaboral AS CondicionLaboral, sum(HorasTeoria+HorasPractica+HorasLaboratorio)*4 AS TotalHorasMesCh, 0 AS TotalHorasMesProp
					      FROM DetalleCargaHoraria	act
					      INNER JOIN Personas per ON act.IdPersona = per.IdPersona
						  INNER JOIN [RecursosHumanos].dbo.Trabajadores tra ON per.IdPersona = tra.IdPersona collate SQL_Latin1_General_CP1_CI_AS
						  INNER JOIN Materias mat ON act.SiglaMateria = mat.SiglaMateria
						  INNER JOIN [RecursosHumanos].dbo.AsignacionesDocentes ad ON tra.CodigoTrabajador = ad.CodigoTrabajador
						  INNER JOIN [RecursosHumanos].dbo.CondicionesLaborales cl ON ad.CodigoCondicionLaboral = cl.CodigoCondicionLaboral
					      WHERE act.CodigoCarrera = :codigoCarrera1 AND CodigoSede = :codigoSede1 AND act.IdPersona <> 'ACE0001'
					      GROUP BY per.IdPersona, per.Paterno, per.Materno, per.Nombres, cl.NombreCondicionLaboral
					      UNION
					      SELECT per.IdPersona, Paterno, Materno, Nombres, NombreCondicionLaboral, 0 AS TotalHorasMesCh, sum(HorasTeoria+HorasPractica+HorasLaboratorio)*4 AS TotalHorasMesProp
					      FROM DetalleCargaHoraria pro
					      INNER JOIN [RecursosHumanos].dbo.Trabajadores tra ON pro.IdPersona = tra.IdPersona collate SQL_Latin1_General_CP1_CI_AS
					      INNER JOIN Personas per ON tra.IdPersona = per.IdPersona collate SQL_Latin1_General_CP1_CI_AS
						  INNER JOIN Materias mat ON pro.SiglaMateria = mat.SiglaMateria
						  INNER JOIN [RecursosHumanos].dbo.AsignacionesDocentes ad ON tra.CodigoTrabajador = ad.CodigoTrabajador
						  INNER JOIN [RecursosHumanos].dbo.CondicionesLaborales cl ON ad.CodigoCondicionLaboral = cl.CodigoCondicionLaboral
					      INNER JOIN (SELECT DISTINCT per.IdPersona, CodigoCondicionLaboral
					   			      FROM DetalleCargaHoraria dch
									  INNER JOIN Personas per on dch.IdPersona = per.IdPersona
									  INNER JOIN [RecursosHumanos].dbo.Trabajadores tra ON per.IdPersona = tra.IdPersona collate SQL_Latin1_General_CP1_CI_AS
									  INNER JOIN [RecursosHumanos].dbo.AsignacionesDocentes ad ON tra.CodigoTrabajador = ad.CodigoTrabajador
									  WHERE per.IdPersona <> 'ACE0001' AND CodigoCondicionLaboral <> 'AUT'
									 ) AS cond ON per.IdPersona = cond.IdPersona
						  WHERE pro.CodigoCarrera = :codigoCarrera2 AND CodigoSede = :codigoSede2 AND GestionAcademica = :gestionAcademica2 AND pro.IdPersona <> 'ACE0001'
						  GROUP BY per.IdPersona, Paterno, Materno, Nombres, NombreCondicionLaboral
						 ) AS Comp
					 GROUP BY IdPersona, isnull(Paterno,''), isnull(Materno,''), Nombres, isnull(Paterno,'')+' '+isnull(Materno,'')+' '+Nombres, upper(CondicionLaboral)
					 ORDER BY CondicionLaboral DESC, NombreCompleto";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":codigoCarrera1", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":codigoCarrera2", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":codigoSede1", $codigoSede, PDO::PARAM_STR)
            ->bindParam(":codigoSede2", $codigoSede, PDO::PARAM_STR)
            ->bindParam(":gestionAcademica2", $gestionAcademica, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $docentes = [];
        while ($docente = $lector->readObject(DocenteCarreraObj::className(), [])) {
            $docentes[] = $docente;
        }
        return $docentes;
    }

    static public function listaDocentesUniversidad($codigoCarrera, $codigoSede, $gestionAcademica)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT IdPersona, isnull(Paterno,'') AS Paterno, isnull(Materno,'') AS Materno, Nombres, isnull(Paterno,'')+' '+isnull(Materno,'')+' '+Nombres AS NombreCompleto, upper(CondicionLaboral) AS CondicionLaboral,
					        sum(TotalHorasMesCh) AS TotalHorasMesCh, isnull(sum(TotalHorasMesProp),0) AS TotalHorasMesProp
					 FROM(SELECT per.IdPersona, per.Paterno, per.Materno, per.Nombres, CondicionLaboral, sum(HorasSemana*4) AS TotalHorasMesCh, 0 AS TotalHorasMesProp
					      FROM vCargaHorariaActual	act
					      INNER JOIN Personas per ON act.IdPersona = per.IdPersona 
					      WHERE CodigoCarrera > 0 AND 
					            act.IdPersona in(SELECT DISTINCT IdPersona 
					                             FROM vCargaHorariaActual
												 WHERE CodigoCarrera = :codigoCarrera1 AND Sede = :codigoSede1 AND IdPersona <> 'ACE0001'
												 UNION
												 SELECT DISTINCT tra.IdPersona	  
										         FROM CargaHorariaPropuesta pro
										         INNER JOIN Trabajadores tra ON pro.CodigoTrabajador = tra.CodigoTrabajador
												 WHERE CodigoCarrera = :codigoCarrera2 AND CodigoSede = :codigoSede2 AND pro.CodigoTrabajador <> '000000000'
												) 								
					      GROUP BY per.IdPersona, per.Paterno, per.Materno, per.Nombres, CondicionLaboral
					      UNION
					      SELECT per.IdPersona, Paterno, Materno, Nombres, CondicionLaboral, 0 AS TotalHorasMesCh, sum(HorasSemana*4) AS TotalHorasMesProp
					      FROM CargaHorariaPropuesta pro
					      INNER JOIN Trabajadores tra ON pro.CodigoTrabajador = tra.CodigoTrabajador
					      INNER JOIN Personas per ON tra.IdPersona = per.IdPersona
					      INNER JOIN (SELECT DISTINCT IdPersona, CondicionLaboral
					   			      FROM vCargaHorariaActual
									  WHERE IdPersona <> 'ACE0001' AND CodigoCondicionLaboral <> 'AUT'
									 ) AS cond ON per.IdPersona = cond.IdPersona
						  WHERE pro.GestionAcademica in('2021','1/2021') AND
						        per.IdPersona in(SELECT DISTINCT IdPersona 
						                         FROM vCargaHorariaActual
												 WHERE CodigoCarrera = :codigoCarrera3 AND Sede = :codigoSede3 AND IdPersona <> 'ACE0001'
												 UNION
												 SELECT DISTINCT tra.IdPersona	  
										         FROM CargaHorariaPropuesta pro
										         INNER JOIN Trabajadores tra ON pro.CodigoTrabajador = tra.CodigoTrabajador
												 WHERE CodigoCarrera = :codigoCarrera4 AND CodigoSede = :codigoSede4 AND pro.CodigoTrabajador <> '000000000'
												)
						  GROUP BY per.IdPersona, Paterno, Materno, Nombres, CondicionLaboral
						 ) AS Comp
					 GROUP BY IdPersona, isnull(Paterno,''), isnull(Materno,''), Nombres, isnull(Paterno,'')+' '+isnull(Materno,'')+' '+Nombres, upper(CondicionLaboral)
					 ORDER BY CondicionLaboral DESC, NombreCompleto ";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":codigoCarrera1", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":codigoCarrera2", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":codigoCarrera3", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":codigoCarrera4", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":codigoSede1", $codigoSede, PDO::PARAM_STR)
            ->bindParam(":codigoSede2", $codigoSede, PDO::PARAM_STR)
            ->bindParam(":codigoSede3", $codigoSede, PDO::PARAM_STR)
            ->bindParam(":codigoSede4", $codigoSede, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $docentes = [];
        while ($docente = $lector->readObject(DocenteCarreraObj::className(), [])) {
            $docentes[] = $docente;
        }
        return $docentes;
    }

    /*==============================
    LISTA EXTRAORDINARIAS POR CARRERA
    ================================*/
    static public function listaExtraordinariasResumen($codigoCarrera, $codigoSede)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT CodigoCarrera, NumeroPlanEstudios, Curso, SiglaMateria, NombreMateria, 
                            per.IdPersona, isnull(per.Paterno,'') AS Paterno, isnull(per.Materno,'') AS Materno, per.Nombres, isnull(per.Paterno,'')+' '+isnull(per.Materno,'')+' '+per.Nombres AS NombreCompleto,
                            upper(CondicionLaboral) AS CondicionLaboral, sum(HorasSemana*4) AS HorasMes
                     FROM vCargaHorariaActual act
                     INNER JOIN Personas per ON act.IdPersona = per.IdPersona
                     WHERE CodigoCarrera = :codigoCarrera AND Sede = :codigoSede AND (FechaInicio < getDate()) AND (FechaFin IS NULL OR FechaFin > getDate()) AND NumeroPlanEstudios = 0
                     GROUP BY CodigoCarrera, NumeroPlanEstudios, Curso, SiglaMateria, NombreMateria, per.IdPersona, isnull(per.Paterno,''), isnull(per.Materno,''), per.Nombres, isnull(per.Paterno,'')+' '+isnull(per.Materno,'')+' '+per.Nombres, CondicionLaboral
                     ORDER BY Curso, NumeroPlanEstudios, per.IdPersona DESC, SiglaMateria";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":codigoCarrera", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":codigoSede", $codigoSede, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $extraordinarias = [];
        while ($extraordinaria = $lector->readObject(MateriaExtraordinariaResumenObj::className(), [])) {
            $extraordinarias[] = $extraordinaria;
        }
        return $extraordinarias;
    }

    /*=============
    LISTA DOCENTES
    ===============*/
    static public function listaDocentes()
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT DISTINCT tra.CodigoTrabajador, per.IdPersona, isnull(upper(per.Paterno),'') AS Paterno, isnull(upper(per.Materno),'') AS Materno, upper(per.Nombres)AS Nombres, isnull(per.Paterno,'')+' '+isnull(per.Materno,'')+' '+per.Nombres AS NombreCompleto--, upper(ad.CodigoCondicionLaboral) AS CondicionLaboral                                                 
                     FROM Personas per 
                     INNER JOIN Trabajadores tra ON per.Idpersona = tra.IdPersona
					 INNER JOIN AsignacionesDocentes ad ON tra.CodigoTrabajador = ad.CodigoTrabajador 
                     WHERE ad.CodigoCondicionLaboral <> 'AUT' AND (FechaInicio < getDate()) AND (FechaFin IS NULL OR FechaFin > getDate()) 
                     ORDER BY tra.CodigoTrabajador, isnull(upper(per.Paterno),''), isnull(upper(per.Materno),''), upper(per.Nombres)";
        $instruccion = $dbRRHH->createCommand($consulta);
        $lector = $instruccion->query();
        $docentes = [];
        while ($docente = $lector->readObject(DocenteObj::className(), [])) {
            $docentes[] = $docente;
        }
        return $docentes;
    }

    /*==============================================================
    LISTA DOCENTES CARGA HORARIA PLANIFICACION (PROPUESTA)
    ================================================================*/
    static public function listaCargasHorariasPropuestas($codigoCarrera, $codigoSede, $numeroPlanEstudios, $siglaMateria, $gestionAcademica)
    {
        $dbRRHH = Yii::$app->dbAcad;
        $consulta = "SELECT tra.CodigoTrabajador,dch.IdPersona, upper(isnull(Paterno,'')) AS Paterno, upper(isnull(Materno,'')) AS Materno, upper(Nombres)As Nombres, upper(isnull(Paterno,'')+' '+isnull(Materno,'')+' '+Nombres) AS NombreCompleto,
                            NombreCondicionLaboral as CondicionLaboral,	
                            dch.GestionAcademica, dch.CodigoCarrera, dch.NumeroPlanEstudios, dch.SiglaMateria, dch.Grupo, dch.CodigoTipoGrupo, CASE dch.CodigoTipoGrupo WHEN  'T' THEN 'TEORIA' WHEN  'P' THEN 'PRACTICA' WHEN  'L' THEN 'LABORATORIO' ELSE NULL END AS TipoGrupoLiteral
                            ,CASE dch.CodigoTipoGrupo WHEN  'T' THEN mat.HorasTeoria WHEN  'P' THEN mat.HorasPractica WHEN  'L' THEN mat.HorasLaboratorio ELSE NULL END AS HorasSemana
                      FROM DetalleCargaHoraria dch
                      INNER JOIN [172.17.1.30].[RecursosHumanos].dbo.Trabajadores tra ON dch.IdPersona = tra.IdPersona collate SQL_Latin1_General_CP1_CI_AS
                      INNER JOIN [172.17.1.30].[RecursosHumanos].dbo.Personas per ON per.IdPersona = dch.IdPersona collate SQL_Latin1_General_CP1_CI_AS
                      INNER JOIN Materias mat ON mat.SiglaMateria = dch.SiglaMateria AND mat.NumeroPlanEstudios = dch.NumeroPlanEstudios AND mat.CodigoCarrera = dch.CodigoCarrera
                      LEFT JOIN (SELECT DISTINCT ad.CodigoTrabajador, ad.CodigoCondicionLaboral, cl.NombreCondicionLaboral 
                                 FROM [172.17.1.30].[RecursosHumanos].dbo.asignacionesDocentes ad
				                 INNER JOIN [172.17.1.30].[RecursosHumanos].dbo.CondicionesLaborales cl on cl.CodigoCondicionLaboral = ad.CodigoCondicionLaboral
                                 WHERE ad.CodigoCondicionLaboral <> 'AUT'
                               ) AS con ON tra.CodigoTrabajador = con.CodigoTrabajador
                       WHERE dch.CodigoCarrera = :codigoCarrera AND dch.NumeroPlanEstudios = :numeroPlanEstudios AND dch.SiglaMateria = :siglaMateria AND dch.CodigoSede = :codigoSede AND dch.GestionAcademica = :gestionAcacemica
                      ORDER BY CodigoTipoGrupo DESC, CASE isnumeric(Grupo) WHEN 1 THEN Convert(integer, Grupo) WHEN 0 THEN ASCII(Grupo) END";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":codigoCarrera", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":numeroPlanEstudios", $numeroPlanEstudios, PDO::PARAM_STR)
            ->bindParam(":siglaMateria", $siglaMateria, PDO::PARAM_STR)
            ->bindParam(":codigoSede", $codigoSede, PDO::PARAM_STR)
            ->bindParam(":gestionAcacemica", $gestionAcademica, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $cargasHorariasPropuestas = [];
        while ($chPropuesta = $lector->readObject(CargaHorariaPropuestaObj::className(), [])) {
            $cargasHorariasPropuestas[] = $chPropuesta;
        }
        return $cargasHorariasPropuestas;
    }

    /*==============================================================
LISTA DOCENTES CARGA HORARIA PLANIFICACION (PROPUESTA)
================================================================*/
    static public function listaCargasHorariasPropuestasTipo($codigoCarrera, $codigoSede, $numeroPlanEstudios, $siglaMateria, $gestionAcademica, $tipoGrupo)
    {
        $dbRRHH = Yii::$app->dbAcad;
        $consulta = "SELECT tra.CodigoTrabajador,dch.IdPersona, upper(isnull(Paterno,'')) AS Paterno, upper(isnull(Materno,'')) AS Materno, upper(Nombres)As Nombres, upper(isnull(Paterno,'')+' '+isnull(Materno,'')+' '+Nombres) AS NombreCompleto,
                            NombreCondicionLaboral as CondicionLaboral,	
                            dch.GestionAcademica, dch.CodigoCarrera, dch.NumeroPlanEstudios, dch.SiglaMateria, dch.Grupo, dch.CodigoTipoGrupo, CASE dch.CodigoTipoGrupo WHEN  'T' THEN 'TEORIA' WHEN  'P' THEN 'PRACTICA' WHEN  'L' THEN 'LABORATORIO' ELSE NULL END AS TipoGrupoLiteral
                            ,CASE dch.CodigoTipoGrupo WHEN  'T' THEN mat.HorasTeoria WHEN  'P' THEN mat.HorasPractica WHEN  'L' THEN mat.HorasLaboratorio ELSE NULL END AS HorasSemana
                      FROM DetalleCargaHoraria dch
                      INNER JOIN [172.17.1.30].[RecursosHumanos].dbo.Trabajadores tra ON dch.IdPersona = tra.IdPersona collate SQL_Latin1_General_CP1_CI_AS
                      INNER JOIN [172.17.1.30].[RecursosHumanos].dbo.Personas per ON per.IdPersona = dch.IdPersona collate SQL_Latin1_General_CP1_CI_AS
                      INNER JOIN Materias mat ON mat.SiglaMateria = dch.SiglaMateria AND mat.NumeroPlanEstudios = dch.NumeroPlanEstudios AND mat.CodigoCarrera = dch.CodigoCarrera
                      LEFT JOIN (SELECT DISTINCT ad.CodigoTrabajador, ad.CodigoCondicionLaboral, cl.NombreCondicionLaboral 
                                 FROM [172.17.1.30].[RecursosHumanos].dbo.asignacionesDocentes ad
				                 INNER JOIN [172.17.1.30].[RecursosHumanos].dbo.CondicionesLaborales cl on cl.CodigoCondicionLaboral = ad.CodigoCondicionLaboral
                                 WHERE ad.CodigoCondicionLaboral <> 'AUT'
                               ) AS con ON tra.CodigoTrabajador = con.CodigoTrabajador
                       WHERE dch.CodigoCarrera = :codigoCarrera AND dch.NumeroPlanEstudios = :numeroPlanEstudios AND dch.SiglaMateria = :siglaMateria AND dch.CodigoSede = :codigoSede AND dch.GestionAcademica = :gestionAcacemica AND dch.CodigoTipoGrupo = :tipoGrupo
                      ORDER BY CodigoTipoGrupo DESC, CASE isnumeric(Grupo) WHEN 1 THEN Convert(integer, Grupo) WHEN 0 THEN ASCII(Grupo) END";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":codigoCarrera", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":numeroPlanEstudios", $numeroPlanEstudios, PDO::PARAM_STR)
            ->bindParam(":siglaMateria", $siglaMateria, PDO::PARAM_STR)
            ->bindParam(":codigoSede", $codigoSede, PDO::PARAM_STR)
            ->bindParam(":gestionAcacemica", $gestionAcademica, PDO::PARAM_STR)
            ->bindParam(":tipoGrupo", $tipoGrupo, PDO::PARAM_STR);
        //print_r($instruccion->getRawSql());
        //exit();
        $lector = $instruccion->query();

        $cargasHorariasPropuestas = [];
        while ($chPropuesta = $lector->readObject(CargaHorariaPropuestaObj::className(), [])) {
            $cargasHorariasPropuestas[] = $chPropuesta;
        }
        return $cargasHorariasPropuestas;
    }

    /*=============================================
    BUSCA CARGA HORARIA CONFIGURACION VIGENTE
    =============================================*/
    static public function buscaCargaHorariaConfiguracion($tipo, $codigoCarrera, $codigoSede)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT GestionAcademica, CodigoCarrera, CodigoSedeAcad, GestionAnterior, MesAnterior, GestionAcademicaAnterior, GestionAcademicaAnterior, GestionAcademicaPlanificacion, CodigoModalidadCurso, FechaInicioPlanificacion, FechaFinPlanificacion, CodigoEstadoPlanificacion, FechaInicioContrataciones, FechaFinContrataciones, DiaInicioInformes, DiaFinInformes, CodigoEstado, FechaHoraRegistro, CodigoUsuario 
                     FROM CargaHorariaConfiguraciones
                     WHERE CodigoCarrera = :codigoCarrera AND CodigoSedeAcad = :codigoSede AND CodigoEstado = 'V' ";
        if ($tipo == "array") {
            $configuracion = $dbRRHH->createCommand($consulta)
                ->bindParam(":codigoCarrera", $codigoCarrera, PDO::PARAM_STR)
                ->bindParam(":codigoSede", $codigoSede, PDO::PARAM_STR)
                ->queryOne();
            return $configuracion;
        } else {
            $instruccion = $dbRRHH->createCommand($consulta)
                ->bindParam(":codigoCarrera", $codigoCarrera, PDO::PARAM_STR)
                ->bindParam(":codigoSede", $codigoSede, PDO::PARAM_STR);
            $lector = $instruccion->query();
            $configuracion = $lector->readObject(CargaHorariaConfiguracionObj::className(), []);
            return $configuracion;
        }
    }
}
