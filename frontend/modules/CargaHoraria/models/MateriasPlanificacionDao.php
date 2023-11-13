<?php

namespace app\modules\CargaHoraria\models;

use yii\db\mssql\PDO;
use Yii;

class MateriasPlanificacionDao
{
    /*==============================================================
    LISTA MATERIAS DE UN CURSO DE UN PLAN DE ESTUDIOS DE UNA CARRERA
    ================================================================*/
    static public function listaMateriasCursoProgramados($codigoCarrera, $codigoSede, $codigoSedeAcad, $numeroPlanEstudios, $curso)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT fac.CodigoFacultad, fac.NombreFacultad, car.CodigoCarrera, car.NombreCarrera, car.NombreCortoCarrera, mat.NumeroPlanEstudios, mat.Curso, mat.SiglaMateria, mat.NombreMateria, 
                            isnull(mat.HorasTeoria,0) AS HorasTeoria, isnull(mat.HorasPractica,0) AS HorasPractica, isnull(mat.HorasLaboratorio,0) AS HorasLaboratorio, chConf.GestionAcademicaAnterior, chConf.GestionAcademicaPlanificacion AS GestionAcademicaActual, 
                            isnull(chPlaAnt.CantGrpsTeoria,0) AS CantGrpsTeoriaAnterior, isnull(chPlaAnt.CantGrpsPractica,0) AS CantGrpsPracticaAnterior, isnull(chPlaAnt.CantGrpsLaboratorio,0) AS CantGrpsLaboratorioAnterior,
                            isnull(chPlaVig.CantGrpsTeoria,0) AS CantGrpsTeoriaActual, isnull(chPlaVig.CantGrpsPractica,0) AS CantGrpsPracticaActual, isnull(chPlaVig.CantGrpsLaboratorio,0) AS CantGrpsLaboratorioActual,
                            CASE WHEN mat.HorasTeoria>0 THEN isnull(estAnt.EstudiantesTeoria,0) WHEN mat.HorasTeoria is null AND mat.HorasPractica>0 THEN isnull(estAnt.EstudiantesPractica,0) WHEN mat.HorasTeoria is null AND mat.HorasPractica is null AND mat.HorasLaboratorio>0 THEN isnull(estAnt.EstudiantesLaboratorio,0) END AS NumEstAnterior,                             
                            CASE WHEN mat.HorasTeoria>0 THEN isnull(estVig.EstudiantesTeoria,0) WHEN mat.HorasTeoria is null AND mat.HorasPractica>0 THEN isnull(estVig.EstudiantesPractica,0) WHEN mat.HorasTeoria is null AND mat.HorasPractica is null AND mat.HorasLaboratorio>0 THEN isnull(estVig.EstudiantesLaboratorio,0) END AS NumEstActual
                     FROM Materias mat                     
                     INNER JOIN PlanesEstudios pla ON mat.CodigoCarrera = pla.CodigoCarrera AND mat.NumeroPlanEstudios = pla.NumeroPlanEstudios 
                     INNER JOIN Carreras car ON pla.CodigoCarrera = car.CodigoCarrera
                     INNER JOIN Facultades fac ON car.CodigoFacultad = fac.CodigoFacultad
                     INNER JOIN CargaHorariaConfiguraciones chConf ON car.CodigoCarrera = chConf.CodigoCarrera
                     LEFT JOIN (SELECT CodigoCarrera, NumeroPlanEstudios, SiglaMateria, GestionAcademica, CantGrpsTeoria, CantGrpsPractica, CantGrpsLaboratorio 
                                FROM CargaHorariaPlanificacion
                                WHERE CodigoCarrera = :codigoCarreraAnt AND NumeroPlanEstudios = :numeroPlanEstudiosAnt AND CodigoSede = :codigoSedeAnt
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
                                WHERE CodigoCarrera = :codigoCarreraVig AND NumeroPlanEstudios = :numeroPlanEstudiosVig AND CodigoSede = :codigoSedeVig
                                ) AS chPlaVig ON mat.CodigoCarrera = chPlaVig.CodigoCarrera AND mat.NumeroPlanEstudios = chPlaVig.NumeroPlanEstudios AND mat.SiglaMateria = chPlaVig.SiglaMateria COLLATE Modern_Spanish_CI_AS AND chConf.GestionAcademicaPlanificacion = chPlaVig.GestionAcademica
                     LEFT JOIN (SELECT CodigoCarrera, NumeroPlanEstudios, SiglaMateria, GestionAcademica, CodigoModalidadCurso, sum(EstudiantesTeoria) AS EstudiantesTeoria, sum(EstudiantesPractica) AS EstudiantesPractica, sum(EstudiantesLaboratorio) AS EstudiantesLaboratorio  
                                FROM (SELECT CodigoCarrera, NumeroPlanEstudios, SiglaMateria, CodigoTipoGrupoMateria, GestionAcademica, CodigoModalidadCurso,
                                             CASE CodigoTipoGrupoMateria WHEN 'T' THEN sum(isnull(NumeroEstudiantesProgramados,0)) ELSE 0 END AS EstudiantesTeoria,
                                             CASE CodigoTipoGrupoMateria WHEN 'P' THEN sum(isnull(NumeroEstudiantesProgramados,0)) ELSE 0 END AS EstudiantesPractica,
                                             CASE CodigoTipoGrupoMateria WHEN 'L' THEN sum(isnull(NumeroEstudiantesProgramados,0)) ELSE 0 END AS EstudiantesLaboratorio 
                                      FROM MateriasDocentes
                                      WHERE CodigoCarrera = :codigoCarreraEstVig AND NumeroPlanEstudios = :numeroPlanEstudiosEstVig AND CodigoSede = :codigoSedeEstVig
                                      GROUP BY CodigoCarrera, NumeroPlanEstudios, SiglaMateria, CodigoTipoGrupoMateria, GestionAcademica, CodigoModalidadCurso
                                     ) AS estVigTemp
                                GROUP BY CodigoCarrera, NumeroPlanEstudios, SiglaMateria, GestionAcademica, CodigoModalidadCurso
                                ) AS estVig ON mat.CodigoCarrera = estVig.CodigoCarrera AND mat.NumeroPlanEstudios = estVig.NumeroPlanEstudios AND mat.SiglaMateria = estVig.SiglaMateria COLLATE Modern_Spanish_CI_AS AND chConf.GestionAcademicaPlanificacion = estVig.GestionAcademica COLLATE Modern_Spanish_CI_AS AND chConf.CodigoModalidadCurso = estVig.CodigoModalidadCurso COLLATE Modern_Spanish_CI_AS                     
                     WHERE mat.CodigoCarrera = :codigoCarrera AND chConf.CodigoSede = :codigoSede AND mat.NumeroPlanEstudios = :numeroPlanEstudios AND mat.Curso = :curso AND mat.CodigoEstadoMateria = 'A' AND chConf.CodigoEstado = 'V'
                     ORDER BY mat.SiglaMateria ";
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
            ->bindParam(":numeroPlanEstudiosEstVig", $numeroPlanEstudios, PDO::PARAM_STR)
            ->bindParam(":codigoSedeEstVig", $codigoSedeAcad, PDO::PARAM_STR)
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

    static public function listaMateriasCursoProyectados($codigoCarrera, $codigoSede, $codigoSedeAcad, $numeroPlanEstudios, $curso)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT fac.CodigoFacultad, fac.NombreFacultad, car.CodigoCarrera, car.NombreCarrera, car.NombreCortoCarrera, mat.NumeroPlanEstudios, mat.Curso, mat.SiglaMateria, mat.NombreMateria, 
                            isnull(mat.HorasTeoria,0) AS HorasTeoria, isnull(mat.HorasPractica,0) AS HorasPractica, isnull(mat.HorasLaboratorio,0) AS HorasLaboratorio, chConf.GestionAcademicaAnterior, chConf.GestionAcademicaPlanificacion AS GestionAcademicaActual, 
                            isnull(chPlaAnt.CantGrpsTeoria,0) AS CantGrpsTeoriaAnterior, isnull(chPlaAnt.CantGrpsPractica,0) AS CantGrpsPracticaAnterior, isnull(chPlaAnt.CantGrpsLaboratorio,0) AS CantGrpsLaboratorioAnterior,
                            isnull(chPlaVig.CantGrpsTeoria,0) AS CantGrpsTeoriaActual, isnull(chPlaVig.CantGrpsPractica,0) AS CantGrpsPracticaActual, isnull(chPlaVig.CantGrpsLaboratorio,0) AS CantGrpsLaboratorioActual,
                            CASE WHEN mat.HorasTeoria>0 THEN isnull(estAnt.EstudiantesTeoria,0) WHEN mat.HorasTeoria is null AND mat.HorasPractica>0 THEN isnull(estAnt.EstudiantesPractica,0) WHEN mat.HorasTeoria is null AND mat.HorasPractica is null AND mat.HorasLaboratorio>0 THEN isnull(estAnt.EstudiantesLaboratorio,0) END AS NumEstAnterior,                             
                            estVig.CantidadProyeccion AS NumEstActual
                     FROM Materias mat                     
                     INNER JOIN PlanesEstudios pla ON mat.CodigoCarrera = pla.CodigoCarrera AND mat.NumeroPlanEstudios = pla.NumeroPlanEstudios 
                     INNER JOIN Carreras car ON pla.CodigoCarrera = car.CodigoCarrera
                     INNER JOIN Facultades fac ON car.CodigoFacultad = fac.CodigoFacultad
                     INNER JOIN CargaHorariaConfiguraciones chConf ON car.CodigoCarrera = chConf.CodigoCarrera
                     LEFT JOIN (SELECT CodigoCarrera, NumeroPlanEstudios, SiglaMateria, GestionAcademica, CantGrpsTeoria, CantGrpsPractica, CantGrpsLaboratorio 
                                FROM CargaHorariaPlanificacion
                                WHERE CodigoCarrera = :codigoCarreraAnt AND NumeroPlanEstudios = :numeroPlanEstudiosAnt AND CodigoSede = :codigoSedeAnt
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
                                WHERE CodigoCarrera = :codigoCarreraVig AND NumeroPlanEstudios = :numeroPlanEstudiosVig AND CodigoSede = :codigoSedeVig
                                ) AS chPlaVig ON mat.CodigoCarrera = chPlaVig.CodigoCarrera AND mat.NumeroPlanEstudios = chPlaVig.NumeroPlanEstudios AND mat.SiglaMateria = chPlaVig.SiglaMateria COLLATE Modern_Spanish_CI_AS AND chConf.GestionAcademicaPlanificacion = chPlaVig.GestionAcademica
                     LEFT JOIN (SELECT CodigoCarrera, SiglaMateria, GestionAcademica, CantidadProyeccion  
                                FROM vProyecciones
                                WHERE CodigoCarrera = :codigoCarreraEstVig AND CodigoSede = :codigoSedeAcadEstVig                               
                                ) AS estVig ON mat.CodigoCarrera = estVig.CodigoCarrera AND mat.SiglaMateria = estVig.SiglaMateria COLLATE Modern_Spanish_CI_AS AND chConf.GestionAcademicaPlanificacion = estVig.GestionAcademica COLLATE Modern_Spanish_CI_AS 
                     WHERE mat.CodigoCarrera = :codigoCarrera AND chConf.CodigoSede = :codigoSede AND mat.NumeroPlanEstudios = :numeroPlanEstudios AND mat.Curso = :curso AND mat.CodigoEstadoMateria = 'A' AND chConf.CodigoEstado = 'V'
                     ORDER BY mat.SiglaMateria ";
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
}