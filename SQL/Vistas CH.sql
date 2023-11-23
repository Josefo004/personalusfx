/*VISTA QUE DEVUELVE LA CARGA HORARIA VIGENTE (MES ACTUAL) DE ACUERDO A CRONOGRAMA*/
CREATE VIEW vCargaHorariaVigente
AS
SELECT detCh.GestionAcademica, fac.CodigoFacultad, fac.NombreFacultad, car.CodigoCarrera, car.NombreCarrera, sed.CodigoSede AS CodigoSedeAcad, upper(sed.NombreSede) AS NombreSedeAcad, mat.Curso, mat.NumeroPlanEstudios, mat.SiglaMateria, mat.NombreMateria, detCh.Grupo, detCh.CodigoTipoGrupo AS TipoGrupo, CASE detCh.CodigoTipoGrupo WHEN 'T' THEN mat.HorasTeoria WHEN 'P' THEN mat.HorasPractica WHEN 'L' THEN mat.HorasLaboratorio ELSE 0 END AS HorasSemana,
       per.IdPersona, tra.CodigoTrabajador, per.Paterno, per.Materno, per.Nombres, conLab.CodigoCondicionLaboral, conLab.NombreCondicionLaboral, detCh.FechaInicio, detCh.FechaFinal
FROM [172.17.1.20].Academica.dbo.DetalleCargaHoraria detCh
INNER JOIN [172.17.1.20].Academica.dbo.Materias mat ON detCh.CodigoCarrera = mat.CodigoCarrera AND detCh.NumeroPlanEstudios = mat.NumeroPlanEstudios AND detCh.SiglaMateria = mat.SiglaMateria
INNER JOIN [172.17.1.20].Academica.dbo.Carreras car ON mat.CodigoCarrera = car.CodigoCarrera
INNER JOIN [172.17.1.20].Academica.dbo.Facultades fac ON car.CodigoFacultad = fac.CodigoFacultad
INNER JOIN [172.17.1.20].Academica.dbo.Sedes sed ON detCh.CodigoSede = sed.CodigoSede
INNER JOIN Trabajadores tra ON detCh.IdPersona COLLATE Modern_Spanish_CI_AS = tra.IdPersona
INNER JOIN Personas per ON tra.IdPersona = per.IdPersona
INNER JOIN CargaHorariaConfiguraciones chConf ON detCh.GestionAcademica = chConf.GestionAcademica COLLATE Modern_Spanish_CI_AS AND detCh.CodigoCarrera = chConf.CodigoCarrera AND detCh.CodigoSede COLLATE Modern_Spanish_CI_AS = chConf.CodigoSedeAcad
INNER JOIN CarrerasUnidades carUni ON detCh.CodigoCarrera = carUni.CodigoCarrera AND detCh.CodigoSede COLLATE Modern_Spanish_CI_AS = carUni.CodigoSedeAcad
INNER JOIN Unidades uni ON carUni.CodigoUnidad = uni.CodigoUnidad
INNER JOIN Items ite ON uni.CodigoUnidad = ite.CodigoUnidad
INNER JOIN AsignacionesDocentes asigDoc ON ite.NroItem = asigDoc.NroItem AND tra.CodigoTrabajador = asigDoc.CodigoTrabajador
INNER JOIN CondicionesLaborales conLab ON asigDoc.CodigoCondicionLaboral = conLab.CodigoCondicionLaboral
WHERE chConf.CodigoEstado = 'V'
   AND (asigDoc.FechaFin IS NULL OR asigDoc.FechaFin >= GETDATE() OR
        asigDoc.FechaFin BETWEEN '01/' + CAST(MONTH(GETDATE()) AS varchar) + '/' + CAST(YEAR(GETDATE()) AS varchar) AND DATEADD(dd, - 1, DATEADD(mm, 1, CAST('01/' + CAST(MONTH(GETDATE()) AS varchar) + '/' + CAST(YEAR(GETDATE()) AS varchar) AS datetime))))
   AND (detCh.FechaFinal >= GETDATE() OR
        detCh.FechaFinal BETWEEN '01/' + CAST(MONTH(GETDATE()) AS varchar) + '/' + CAST(YEAR(GETDATE()) AS varchar) AND DATEADD(dd, - 1, DATEADD(mm, 1, CAST('01/' + CAST(MONTH(GETDATE()) AS varchar) + '/' + CAST(YEAR(GETDATE()) AS varchar) AS datetime))))
UNION
SELECT detCh.GestionAcademica, fac.CodigoFacultad, fac.NombreFacultad, car.CodigoCarrera, car.NombreCarrera, sed.CodigoSede AS CodigoSedeAcad, upper(sed.NombreSede) AS NombreSedeAcad, mat.Curso, mat.NumeroPlanEstudios, mat.SiglaMateria, mat.NombreMateria, detCh.Grupo, detCh.CodigoTipoGrupo AS TipoGrupo, CASE detCh.CodigoTipoGrupo WHEN 'T' THEN mat.HorasTeoria WHEN 'P' THEN mat.HorasPractica WHEN 'L' THEN mat.HorasLaboratorio ELSE 0 END AS HorasSemana,
       per.IdPersona, tra.CodigoTrabajador, per.Paterno, per.Materno, per.Nombres, CodigoCondicionLaboral = 'DCO', NombreCondicionLaboral = 'DOCENTE CONTRATO FIJO', detCh.FechaInicio, detCh.FechaFinal
FROM [172.17.1.20].Academica.dbo.DetalleCargaHoraria detCh
INNER JOIN [172.17.1.20].Academica.dbo.Materias mat ON detCh.CodigoCarrera = mat.CodigoCarrera AND detCh.NumeroPlanEstudios = mat.NumeroPlanEstudios AND detCh.SiglaMateria = mat.SiglaMateria
INNER JOIN [172.17.1.20].Academica.dbo.Carreras car ON mat.CodigoCarrera = car.CodigoCarrera
INNER JOIN [172.17.1.20].Academica.dbo.Facultades fac ON car.CodigoFacultad = fac.CodigoFacultad
INNER JOIN [172.17.1.20].Academica.dbo.Sedes sed ON detCh.CodigoSede = sed.CodigoSede
INNER JOIN Trabajadores tra ON detCh.IdPersona COLLATE Modern_Spanish_CI_AS = tra.IdPersona
INNER JOIN Personas per ON tra.IdPersona = per.IdPersona
INNER JOIN CargaHorariaConfiguraciones chConf ON detCh.GestionAcademica = chConf.GestionAcademica COLLATE Modern_Spanish_CI_AS AND detCh.CodigoCarrera = chConf.CodigoCarrera AND detCh.CodigoSede COLLATE Modern_Spanish_CI_AS = chConf.CodigoSedeAcad
WHERE chConf.CodigoEstado = 'V' AND detCh.IdPersona = 'ACE0001'
   AND (detCh.FechaFinal >= GETDATE() OR
        detCh.FechaFinal BETWEEN '01/' + CAST(MONTH(GETDATE()) AS varchar) + '/' + CAST(YEAR(GETDATE()) AS varchar) AND DATEADD(dd, - 1, DATEADD(mm, 1, CAST('01/' + CAST(MONTH(GETDATE()) AS varchar) + '/' + CAST(YEAR(GETDATE()) AS varchar) AS datetime))))

/*VISTA QUE DEVUELVE LA CARGA HORARIA PLANIFICADA (GESTION DE PLANIFICACION) DE ACUERDO A CRONOGRAMA*/
CREATE VIEW vCargaHorariaPlanificada
AS
SELECT detCh.GestionAcademica, fac.CodigoFacultad, fac.NombreFacultad, car.CodigoCarrera, car.NombreCarrera, sed.CodigoSede AS CodigoSedeAcad, upper(sed.NombreSede) AS NombreSedeAcad, mat.Curso, mat.NumeroPlanEstudios, mat.SiglaMateria, mat.NombreMateria, detCh.Grupo, detCh.CodigoTipoGrupo AS TipoGrupo, CASE detCh.CodigoTipoGrupo WHEN 'T' THEN mat.HorasTeoria WHEN 'P' THEN mat.HorasPractica WHEN 'L' THEN mat.HorasLaboratorio ELSE 0 END AS HorasSemana,
       per.IdPersona, tra.CodigoTrabajador, per.Paterno, per.Materno, per.Nombres, isnull(condLab.CodigoCondicionLaboral,'DCO') AS CodigoCondicionLaboral, isnull(condLab.NombreCondicionLaboral,'DOCENTE CONTRATO FIJO') AS NombreCondicionLaboral, detCh.FechaInicio, detCh.FechaFinal
FROM [172.17.1.20].Academica.dbo.DetalleCargaHoraria detCh
INNER JOIN [172.17.1.20].Academica.dbo.Materias mat ON detCh.CodigoCarrera = mat.CodigoCarrera AND detCh.NumeroPlanEstudios = mat.NumeroPlanEstudios AND detCh.SiglaMateria = mat.SiglaMateria
INNER JOIN [172.17.1.20].Academica.dbo.Carreras car ON mat.CodigoCarrera = car.CodigoCarrera
INNER JOIN [172.17.1.20].Academica.dbo.Facultades fac ON car.CodigoFacultad = fac.CodigoFacultad
INNER JOIN [172.17.1.20].Academica.dbo.Sedes sed ON detCh.CodigoSede = sed.CodigoSede
INNER JOIN Trabajadores tra ON detCh.IdPersona COLLATE Modern_Spanish_CI_AS = tra.IdPersona
INNER JOIN Personas per ON tra.IdPersona = per.IdPersona
INNER JOIN CargaHorariaConfiguraciones chConf ON detCh.GestionAcademica = chConf.GestionAcademicaPlanificacion COLLATE Modern_Spanish_CI_AS AND detCh.CodigoCarrera = chConf.CodigoCarrera AND detCh.CodigoSede COLLATE Modern_Spanish_CI_AS = chConf.CodigoSedeAcad
LEFT JOIN (SELECT DISTINCT CodigoTrabajador, condLab.CodigoCondicionLaboral, condLab.NombreCondicionLaboral
           FROM AsignacionesDocentes asigDoc
		   INNER JOIN CondicionesLaborales condLab ON asigDoc.CodigoCondicionLaboral = condLab.CodigoCondicionLaboral
		   WHERE asigDoc.CodigoEstado='V' AND FechaFin IS NULL
		  ) AS condLab ON tra.CodigoTrabajador = condLab.CodigoTrabajador
WHERE chConf.CodigoEstado = 'V'

/*VISTA QUE DEVUELVE LA VARIACIÓN DE CARGA HORARIA VIGENTE VS CARGA HORARIAPLANIFICADA*/
SELECT vChVigente.GestionAcademica, vChVigente.CodigoFacultad, vChVigente.NombreFacultad, vChVigente.CodigoCarrera, vChVigente.NombreCarrera, vChVigente.CodigoSedeAcad, vChVigente.NombreSedeAcad, vChVigente.Curso, vChVigente.NumeroPlanEstudios, vChVigente.SiglaMateria, vChVigente.NombreMateria, vChVigente.Grupo, vChVigente.TipoGrupo, vChVigente.HorasSemana,
       vChVigente.IdPersona, vChVigente.CodigoTrabajador, vChVigente.Paterno, vChVigente.Materno, vChVigente.Nombres, vChVigente.CodigoCondicionLaboral, vChVigente.NombreCondicionLaboral, CodigoTipoMovimiento = 'E', NombreTipoMovimiento = 'DEJA'
FROM (SELECT GestionAcademica, CodigoFacultad, NombreFacultad, CodigoCarrera, NombreCarrera, CodigoSedeAcad, NombreSedeAcad, Curso, NumeroPlanEstudios, SiglaMateria, NombreMateria, Grupo, TipoGrupo, HorasSemana,
             IdPersona, CodigoTrabajador, Paterno, Materno, Nombres, CodigoCondicionLaboral, NombreCondicionLaboral
      FROM vCargaHorariaVigente
     ) AS vChVigente
LEFT JOIN
     (SELECT GestionAcademica, CodigoFacultad, NombreFacultad, CodigoCarrera, NombreCarrera, CodigoSedeAcad, NombreSedeAcad, Curso, NumeroPlanEstudios, SiglaMateria, NombreMateria, Grupo, TipoGrupo, HorasSemana,
             IdPersona, CodigoTrabajador, Paterno, Materno, Nombres, CodigoCondicionLaboral, NombreCondicionLaboral
      FROM vCargaHorariaPlanificada
     ) AS vChPlanificada
ON vChVigente.CodigoCarrera = vChPlanificada.CodigoCarrera AND vChVigente.NumeroPlanEstudios = vChPlanificada.NumeroPlanEstudios AND
   vChVigente.SiglaMateria = vChPlanificada.SiglaMateria AND vChVigente.Grupo = vChPlanificada.Grupo AND vChVigente.TipoGrupo = vChPlanificada.TipoGrupo AND
   vChVigente.IdPersona = vChPlanificada.IdPersona
WHERE vChPlanificada.GestionAcademica IS NULL

UNION

SELECT vChPlanificada.GestionAcademica, vChPlanificada.CodigoFacultad, vChPlanificada.NombreFacultad, vChPlanificada.CodigoCarrera, vChPlanificada.NombreCarrera, vChPlanificada.CodigoSedeAcad, vChPlanificada.NombreSedeAcad, vChPlanificada.Curso, vChPlanificada.NumeroPlanEstudios, vChPlanificada.SiglaMateria, vChPlanificada.NombreMateria, vChPlanificada.Grupo, vChPlanificada.TipoGrupo, vChPlanificada.HorasSemana,
       vChPlanificada.IdPersona, vChPlanificada.CodigoTrabajador, vChPlanificada.Paterno, vChPlanificada.Materno, vChPlanificada.Nombres, vChPlanificada.CodigoCondicionLaboral, vChPlanificada.NombreCondicionLaboral, CodigoTipoMovimiento = 'A', NombreTipoMovimiento = 'ASUME'
FROM (SELECT GestionAcademica, CodigoFacultad, NombreFacultad, CodigoCarrera, NombreCarrera, CodigoSedeAcad, NombreSedeAcad, Curso, NumeroPlanEstudios, SiglaMateria, NombreMateria, Grupo, TipoGrupo, HorasSemana,
             IdPersona, CodigoTrabajador, Paterno, Materno, Nombres, CodigoCondicionLaboral, NombreCondicionLaboral
      FROM vCargaHorariaPlanificada
     ) AS vChPlanificada
LEFT JOIN
     (SELECT GestionAcademica, CodigoFacultad, NombreFacultad, CodigoCarrera, NombreCarrera, CodigoSedeAcad, NombreSedeAcad, Curso, NumeroPlanEstudios, SiglaMateria, NombreMateria, Grupo, TipoGrupo, HorasSemana,
             IdPersona, CodigoTrabajador, Paterno, Materno, Nombres, CodigoCondicionLaboral, NombreCondicionLaboral
      FROM vCargaHorariaVigente
     ) AS vChVigente
ON vChPlanificada.CodigoCarrera = vChVigente.CodigoCarrera AND vChPlanificada.NumeroPlanEstudios = vChVigente.NumeroPlanEstudios AND
   vChPlanificada.SiglaMateria = vChVigente.SiglaMateria AND vChPlanificada.Grupo = vChVigente.Grupo AND vChPlanificada.TipoGrupo = vChVigente.TipoGrupo AND
   vChPlanificada.IdPersona = vChVigente.IdPersona
WHERE vChVigente.GestionAcademica IS NULL
ORDER BY CodigoCondicionLaboral, Paterno, Materno, Nombres, Curso, NombreMateria