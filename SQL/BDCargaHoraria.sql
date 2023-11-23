/*IF EXISTS (SELECT name FROM sys.databases WHERE name = N'RecursosHumanos')
    DROP DATABASE [RecursosHumanos]
GO
USE master;
CREATE DATABASE RecursosHumanos;
GO*/
USE RecursosHumanos;

CREATE TABLE CargaHorariaConfiguraciones(
 GestionAcademica char(6) NOT NULL,
 CodigoCarrera int NOT NULL,
 CodigoSedeAcad char(2) NOT NULL,
 GestionAnterior int NOT NULL,
 MesAnterior int NOT NULL,
 GestionAcademicaAnterior varchar(6) NOT NULL,
 GestionAcademicaPlanificacion varchar(6) NOT NULL,
 CodigoModalidadCurso char(2) NOT NULL,
 FechaInicioPlanificacion date NOT NULL,
 FechaFinPlanificacion date NOT NULL,
 FechaInicioContratacion date NOT NULL,
 FechaFinContratacion date NOT NULL,
 FechaInicioInformes date NOT NULL,
 FechaFinInformes date NOT NULL,
 DiaInicioInformes int NOT NULL,
 DiaFinInformes int NOT NULL,
 CodigoEstado char(1) NOT NULL,
 FechaHoraRegistro datetime DEFAULT getdate(),
 CodigoUsuario char(3) NOT NULL,
 PRIMARY KEY(GestionAcademica, CodigoCarrera, CodigoSede),
 FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
 FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario),
);
GO

CREATE TABLE TiposInasistencias(
  CodigoTipoInasistencia int PRIMARY KEY,
  NombreTipoInasistencia varchar(25) NOT NULL,
  Descripcion varchar(100),
  Sancion float NOT NULL,
  CodigoEstado char(1) NOT NULL,
  CodigoUsuario char(3) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE CargaHorariaInasistenciasMes(
 CodigoCarrera int NOT NULL,
 CodigoSedeAcad char(2) NOT NULL,
 NumeroPlanEstudios int NOT NULL,
 SiglaMateria char(6) NOT NULL,
 Grupo char(2) NOT NULL,
 Gestion int NOT NULL,
 Mes int NOT NULL,
 Fecha date NOT NULL,
 Horas int NOT NULL,
 Observacion varchar(100),
 CodigoTrabajador char(10) NOT NULL,
 CodigoTipoInasistencia int NOT NULL,
 FechaHoraRegistro datetime DEFAULT getdate(),
 CodigoUsuario char(3),
 PRIMARY KEY(CodigoCarrera, CodigoSedeAcad, NumeroPlanEstudios, SiglaMateria, Grupo, Gestion, Mes, Fecha, CodigoTrabajador),
 FOREIGN KEY(CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),
 FOREIGN KEY(CodigoTipoInasistencia) REFERENCES TiposInasistencias(CodigoTipoInasistencia),
 FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE CargaHorariaComplementarias(
  GestionAcademica char(6) NOT NULL,
  CodigoCarrera tinyint NOT NULL,
  CodigoSedeAcad char(2) NOT NULL,
  CodigoTrabajador char(10) NOT NULL,
  FechaInicio date NOT NULL,
  FechaFin date NOT NULL,
  TotalHoras int,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  PRIMARY KEY(GestionAcademica, CodigoCarrera, CodigoSedeAcad, CodigoTrabajador, FechaInicio),
  FOREIGN KEY(CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE TiposAusencias(
  CodigoTipoAusencia int PRIMARY KEY,
  NombreTipoAusencia varchar(25) NOT NULL,
  Descripcion varchar(200),
  GoceHaber int NOT NULL,
  CodigoEstado char(1) NOT NULL,
  CodigoUsuario char(3) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE CargaHorariaAusencias(
  NroDocumento varchar(50) NOT NULL PRIMARY KEY,
  FechaDocumento date NOT NULL,
  CodigoTrabajador char(10) NOT NULL,
  CodigoTipoAusencia int NOT NULL,
  FechaInicio date NOT NULL,
  FechaFin date NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  FOREIGN KEY(CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),
  FOREIGN KEY(CodigoTipoAusencia) REFERENCES TiposAusencias(CodigoTipoAusencia),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE CargaHorariaDetalleAusencias(
  NroDocumento varchar(50) NOT NULL,
  CodigoCarrera int NOT NULL,
  CodigoSedeAcad char(2) NOT NULL,
  NumeroPlanEstudios int NOT NULL,
  SiglaMateria char(6) NOT NULL,
  Grupo char(2) NOT NULL,
  TipoGrupo char(1) NOT NULL,
  FechaInicio date NOT NULL,
  FechaFin date NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  PRIMARY KEY(NroDocumento, CodigoCarrera, CodigoSedeAcad, NumeroPlanEstudios, SiglaMateria, Grupo, TipoGrupo, FechaInicio),
  FOREIGN KEY(NroDocumento) REFERENCES CargaHorariaAusencias(NroDocumento),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE CargaHoraria(
  NroDocumento varchar(50) NOT NULL,
  );
  GO

CREATE TABLE CargaHorariaMovimientos(
  NroMovimiento int NOT NULL PRIMARY KEY,
  NroDocumento varchar(50),
  FechaDocumento date,
  CodigoTrabajador char(10) NOT NULL,
  CodigoCondicionLaboral char(3) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  FOREIGN KEY(CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),
  FOREIGN KEY(CodigoCondicionLaboral) REFERENCES CondicionesLaborales(CodigoCondicionLaboral),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE CargaHorariaDetalleMovimientos(
  NroMovimiento varchar(50) NOT NULL,
  CodigoCarrera int NOT NULL,
  CodigoSedeAcad char(2) NOT NULL,
  NumeroPlanEstudios int NOT NULL,
  SiglaMateria char(6) NOT NULL,
  Grupo char(2) NOT NULL,
  TipoGrupo char(1) NOT NULL,
  FechaInicioAsume date NOT NULL,
  FechaFinDeja date NOT NULL,
  CodigoEstado char(1) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  PRIMARY KEY(NroMovimiento, CodigoCarrera, CodigoSedeAcad, NumeroPlanEstudios, SiglaMateria, Grupo, TipoGrupo),
  FOREIGN KEY(NroMovimiento) REFERENCES CargaHorariaMovimientos(NroMovimiento),
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

/*No utilizado porque se implemento en la Academica*/
CREATE TABLE CargaHorariaPlanificacion(
 GestionAcademica char(6) NOT NULL,
 CodigoCarrera int NOT NULL,
 NumeroPlanEstudios int NOT NULL,
 SiglaMateria char(6) NOT NULL,
 CodigoSede int NOT NULL,
 NumeroPlanificacion int NOT NULL,
 CantGrpsTeoria int NOT NULL,
 CantGrpsPractica int NOT NULL,
 CantGrpsLaboratorio int NOT NULL,
 CodigoEstado char(1) NOT NULL,
 FechaHoraRegistro datetime DEFAULT getdate(),
 CodigoUsuario char(3),
 PRIMARY KEY (CodigoCarrera, NumeroPlanEstudios, SiglaMateria, GestionAcademica, CodigoSede, NumeroPlanificacion),
 FOREIGN KEY (CodigoSede) REFERENCES Sedes(CodigoSede),
 FOREIGN KEY (CodigoEstado) REFERENCES Estados(CodigoEstado),
 FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO
/*No utilizado porque se implemento en la Academica*/
CREATE TABLE CargaHorariaPropuesta(
 GestionAcademica char(6) NOT NULL,
 CodigoCarrera int NOT NULL,
 NumeroPlanEstudios int NOT NULL,
 SiglaMateria char(6) NOT NULL,
 Grupo char(2) NOT NULL,
 TipoGrupo char(1) NOT NULL,
 CodigoSede int NOT NULL,
 CodigoTrabajador char(10) NOT NULL,
 CodigoEstado char(1) NOT NULL,
 HorasSemana int NOT NULL,
 Observaciones varchar(500),
 FechaHoraRegistro datetime DEFAULT getdate(),
 FechaHoraModificacion datetime,
 CodigoUsuario char(3) NOT NULL,
 PRIMARY KEY (GestionAcademica, CodigoCarrera, NumeroPlanEstudios, SiglaMateria, Grupo, TipoGrupo, CodigoSede),
 FOREIGN KEY (CodigoSede) REFERENCES Sedes(CodigoSede),
 FOREIGN KEY (CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),
 FOREIGN KEY (CodigoEstado) REFERENCES Estados(CodigoEstado),
 FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE CargaHorariaGestion(
 GestionAcademica char(6),
 CodigoCarrera int NOT NULL,
 NumeroPlanEstudios int NOT NULL,
 SiglaMateria char(6) NOT NULL,
 Grupo char(2) NOT NULL,
 TipoGrupo char(1) NOT NULL,
 CodigoSede int NOT NULL,
 CodigoAsignacion char(8) NOT NULL,
 HorasSemana int NOT NULL,
 FechaHoraRegistro datetime DEFAULT getdate(),
 FechaHoraModificacion datetime,
 CodigoUsuario char(3) NOT NULL,
 PRIMARY KEY (GestionAcademica, CodigoCarrera, NumeroPlanEstudios, SiglaMateria, Grupo, TipoGrupo, CodigoSede),
 FOREIGN KEY (CodigoSede) REFERENCES Sedes(CodigoSede),
 FOREIGN KEY (CodigoAsignacion) REFERENCES AsignacionesDocentes(CodigoAsignacion),
 FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE CargaHorariaEnvios(
 CodigoCarrera int,
 Gestion int NOT NULL,
 Mes int NOT NULL,

)
GO

CREATE TABLE CargaHorariaHistorica(
 GestionAcademica char(6),
 CodigoCarrera int,
 NumeroPlanEstudios int,
 SiglaMateria char(6),
 Grupo char(2),
 TipoGrupo char(1),
 CodigoTrabajador char(10),
 CodigoSede int,
 CodigoCondicionLaboral char(3),
 FechaInicio date,
 FechaFin date,
 HorasSemana int,
 Observaciones varchar(500),
 FechaHoraModificacion datetime,
 CodigoUsuario char(3),
 PRIMARY KEY (GestionAcademica, CodigoCarrera, NumeroPlanEstudios, SiglaMateria, Grupo, TipoGrupo, CodigoCondicionLaboral),
 FOREIGN KEY (CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),
 FOREIGN KEY (CodigoSede) REFERENCES Sedes(CodigoSede),
 FOREIGN KEY (CodigoCondicionLaboral) REFERENCES CondicionesLaborales(CodigoCondicionLaboral),
 FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO