/*COPIA EL CRONOGRAMA VIGENTE Y CREA UN NUEVO CRONOGRAMA FUTURO CADUCADO*/
INSERT INTO CargaHorariaConfiguraciones
SELECT GestionAcademica=CASE CodigoModalidadCurso WHEN 'NA' THEN '2022' ELSE '1/2022' END,
       CodigoCarrera, CodigoSedeAcad, GestionAnterior, MesAnterior, GestionAcademicaAnterior, GestionAcademicaPlanificacion, CodigoModalidadCurso,
	     FechaInicioPlanificacion='01/02/2022', FechaFinPlanificacion='31/03/2022',
       FechaInicioContrataciones='01/04/2022', FechaFinContrataciones=CASE CodigoModalidadCurso WHEN 'NA' THEN '31/03/2023' ELSE '31/08/2022' END,
	     FechaInicioInformes='01/04/2022', FechaFinInformes=CASE CodigoModalidadCurso WHEN 'NA' THEN '31/03/2023' ELSE '31/08/2022' END,
	     DiaInicioInformes, DiaFinInformes, CodigoEstado='C', FechaHoraRegistro=getdate(), CodigoUsuario='BGC'
FROM CargaHorariaConfiguraciones
WHERE CodigoEstado='V'
/*CONSULTA QUE COPIA LAS DECLARATORIAS (AUSENCIAS)*/
INSERT INTO CargaHorariaAusencias
SELECT DISTINCT NroDocumento=CodigoTrabajador, FechaDocumento='01/01/2021', CodigoTrabajador,
       CodigoTipoAusencia=CASE IdTipoDeclaratoria WHEN 1 THEN 1 WHEN 2 THEN 2 WHEN 3 THEN 3 WHEN 4 THEN 4 WHEN 5 THEN 8 WHEN 6 THEN 5 WHEN 7 THEN 6 ELSE 0 END,
       FechaInicio='01/01/2021', FechaFin='30/11/2022', FechaHoraRegistro=getdate(), CodigoUsuario='BGC'
FROM RRHH.dbo.vdeclaratorias vdec
INNER JOIN RRHH.dbo.Personas per ON vdec.IdPersona = per.IdPersona
LEFT JOIN Trabajadores tra ON per.IdPersona = tra.IdPersona
WHERE per.idpersona in(SELECT DISTINCT Idpersona FROM RRHH.dbo.vDeclaratoriasDocentes)
/*CONSULTA QUE COPIA LOS DETALLES DE LAS DECLARATORIAS (AUSENCIAS)*/
INSERT INTO CargaHorariaDetalleAusencias
SELECT NroDocumento=CodigoTrabajador, CodigoCarrera, CodigoSedeAcad='SU', NumeroPlanEstudios, SiglaMateria, Grupo, TipoGrupo,
       FechaInicio, FechaFin, FechaHoraRegistro=getdate(), CodigoUsuario='BGC'
FROM RRHH.dbo.vdeclaratorias vdec
INNER JOIN RRHH.dbo.Personas per ON vdec.IdPersona = per.IdPersona
LEFT JOIN Trabajadores tra ON per.IdPersona = tra.IdPersona
WHERE per.idpersona in(SELECT DISTINCT Idpersona FROM RRHH.dbo.vDeclaratoriasDocentes)
/*CONSULTA QUE ACTUALIZA LA CANTIDAD DE GRUPOS DE ACUERDO AL DETALLE DE CARGA HORARIA*/
UPDATE CargaHoraria
SET CantidadGruposTeoriaProgramado=ch1.GrpTeoria, CantidadGruposTeoria=ch1.GrpTeoria,
    CantidadGruposPracticaProgramado=ch1.GrpPractica, CantidadGruposPractica=ch1.GrpPractica,
		CantidadGruposLaboratorioProgramado=ch1.GrpLaboratorio, CantidadGruposLaboratorio=ch1.GrpLaboratorio
--SELECT *
FROM(
	SELECT CodigoCarrera, CodigoSede, NumeroPlanEstudios, SiglaMateria, sum(GrpTeoria) AS GrpTeoria, sum(GrpPractica) AS GrpPractica, sum(GrpLaboratorio) AS GrpLaboratorio
	FROM(
		SELECT CodigoCarrera, CodigoSede, NumeroPlanEstudios, SiglaMateria, count(Grupo) AS GrpTeoria, 0 AS GrpPractica, 0 AS GrpLaboratorio
		FROM DetalleCargaHoraria
		WHERE GestionAcademica in('2021','2/2021') AND FechaFinal='31/03/2022' AND CodigoTipoGrupo='T'
		GROUP BY CodigoCarrera, CodigoSede, NumeroPlanEstudios, SiglaMateria
		UNION
		SELECT CodigoCarrera, CodigoSede, NumeroPlanEstudios, SiglaMateria, 0 AS GrpTeoria, count(Grupo) AS GrpPractica, 0 AS GrpLaboratorio
		FROM DetalleCargaHoraria
		WHERE GestionAcademica in('2021','2/2021') AND FechaFinal='31/03/2022' AND CodigoTipoGrupo='P'
		GROUP BY CodigoCarrera, CodigoSede, NumeroPlanEstudios, SiglaMateria
		UNION
		SELECT CodigoCarrera, CodigoSede, NumeroPlanEstudios, SiglaMateria, 0 AS GrpTeoria, 0 AS GrpPractica, count(Grupo) AS GrpLaboratorio
		FROM DetalleCargaHoraria
		WHERE GestionAcademica in('2021','2/2021') AND FechaFinal='31/03/2022' AND CodigoTipoGrupo='L'
		GROUP BY CodigoCarrera, CodigoSede, NumeroPlanEstudios, SiglaMateria
		) AS ch
	GROUP BY CodigoCarrera, CodigoSede, NumeroPlanEstudios, SiglaMateria
	) AS ch1
INNER JOIN CargaHoraria ch2 ON ch1.CodigoCarrera=ch2.CodigoCarrera AND ch1.CodigoSede=ch2.CodigoSede AND ch1.NumeroPlanEstudios=ch2.NumeroPlanEstudios ANd ch1.SiglaMateria=ch2.SiglaMateria
WHERE ch2.GestionAcademica in('2021','2/2021') AND ((ch1.GrpTeoria<>ch2.CantidadGruposTeoria) OR (ch1.GrpPractica<>ch2.CantidadGruposPractica) OR (ch1.GrpLaboratorio<>ch2.CantidadGruposLaboratorio))
/*CONSULTA QUE REALIZA EL VOLCADO DE FIN DE UNA GESTION ACADEMICA A UNA NUEVA*/
INSERT INTO CargaHoraria
SELECT GestionAcademica=CASE GestionAcademica WHEN '2021' THEN '2022' ELSE '1/2022' END, Gestion='2022', CodigoSede, CodigoCarrera, NumeroPlanEstudios, SiglaMateria, EsMatricial=0, NroUnivProyectados, CantidadGruposTeoriaProgramado, CantidadGruposPracticaProgramado, CantidadGruposLaboratorioProgramado, CantidadGruposTeoria, CantidadGruposPractica, CantidadGruposLaboratorio, CodigoUsuario='BGC', FechaHoraRegistro=getdate()
FROM CargaHoraria
WHERE GestionAcademica in('2021','2/2021')

INSERT INTO DetalleCargaHoraria
SELECT GestionAcademica=CASE GestionAcademica WHEN '2021' THEN '2022' ELSE '1/2022' END, Gestion='2022', CodigoCarrera, CodigoSede, NumeroPlanEstudios, SiglaMateria, Grupo, CodigoTipoGrupo, IdPersona, FechaInicio='01/04/2022', FechaFinal=CASE GestionAcademica WHEN '2021' THEN '31/03/2023' ELSE '31/08/2022' END, CodigoUsuario='BGC', FechaHoraRegistro=getdate()
FROM DetalleCargaHoraria
WHERE GestionAcademica in('2021','2/2021') AND FechaFinal='31/03/2022'
/*CONSULTA QUE REALIZA EL VOLCADO DE FIN DE UNA GESTION ACADEMICA A UNA NUEVA*/