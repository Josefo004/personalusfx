USE SiacPersonal;

CREATE TABLE Estados(
 CodigoEstado char(1) PRIMARY KEY,
 NombreEstado varchar(50) UNIQUE NOT NULL,
);
GO
INSERT INTO Estados VALUES('V', 'VIGENTE');
INSERT INTO Estados VALUES('C', 'CADUCADO');
INSERT INTO Estados VALUES('P', 'PENDIENTE');
INSERT INTO Estados VALUES('F', 'FINALIZADO');

CREATE TABLE NivelesAcademicos(
 CodigoNivelAcademico char(3) PRIMARY KEY,
 NombreNivelAcademico char(250) UNIQUE NOT NULL,
 NombreCortoNivelAcademico char(150),
 Orden int NOT NULL,
);
GO
INSERT INTO NivelesAcademicos VALUES('NIN','NINGUNO', 'NINGUNO', 9);
INSERT INTO NivelesAcademicos VALUES('BHU','BACHILLER EN HUMANIDADES', 'BACHILLER', 8);
INSERT INTO NivelesAcademicos VALUES('TMU','TECNICO MEDIO UNIVERSITARIO', 'TECNICO MEDIO', 7);
INSERT INTO NivelesAcademicos VALUES('TSU','TECNICO SUPERIOR UNIVERSITARIO', 'TECNICO SUPERIOR', 6);
INSERT INTO NivelesAcademicos VALUES('LIC','LICENCIATURA', 'LICENCIATURA', 5);
INSERT INTO NivelesAcademicos VALUES('DIP','DIPLOMADO', 'DIPLOMADO', 4);
INSERT INTO NivelesAcademicos VALUES('ESP','ESPECIALIDAD', 'ESPECIALIDAD', 3);
INSERT INTO NivelesAcademicos VALUES('MAE','MAESTRIA', 'MAESTRIA', 2);
INSERT INTO NivelesAcademicos VALUES('DOC','DOCTORADO', 'DOCTORADO', 1);

CREATE TABLE SectoresTrabajo(
 CodigoSectorTrabajo char(3) PRIMARY KEY,
 NombreSectorTrabajo char(25) UNIQUE NOT NULL,
 CodigoEstado char(1) NOT NULL,
 CodigoUsuario char(3) NOT NULL,
 FechaHoraRegistro datetime DEFAULT getdate(),
 FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
 FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO
INSERT INTO SectoresTrabajo VALUES('DOC','DOCENTE','V','BGC',getdate());
INSERT INTO SectoresTrabajo VALUES('ADM','ADMINISTRATIVO','V','BGC',getdate());
INSERT INTO SectoresTrabajo VALUES('AUT','AUTORIDAD ELECTA','V','BGC',getdate());

CREATE TABLE CondicionesLaborales(
  CodigoCondicionLaboral char(3) PRIMARY KEY,
  NombreCondicionLaboral varchar(150) UNIQUE NOT NULL,
  CodigoSectorTrabajo char(3) NOT NULL,
  CodigoEstado char(1) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  FOREIGN KEY(CodigoSectorTrabajo) REFERENCES SectoresTrabajo(CodigoSectorTrabajo),
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO
INSERT INTO CondicionesLaborales VALUES('DOC','DOCENTE ORDINARIO','DOC','V');
INSERT INTO CondicionesLaborales VALUES('NDI','DOCENTE CONTINUO','DOC','V');
INSERT INTO CondicionesLaborales VALUES('DCO','DOCENTE CONTRATO FIJO','DOC','V');
INSERT INTO CondicionesLaborales VALUES('DSU','DOCENTE SUPLENTE','DOC','V');
INSERT INTO CondicionesLaborales VALUES('ADM','ADMINISTRATIVO PERMANENTE','ADM','V');
INSERT INTO CondicionesLaborales VALUES('ACO','ADMINISTRATIVO CONTRATO','ADM','V');
INSERT INTO CondicionesLaborales VALUES('ADR','ADMINISTRATIVO RECIENTES','ADM','V');

CREATE TABLE TiposInstituciones(
 CodigoTipoInstitucion char(1) PRIMARY KEY,
 NombreTipoInstitucion varchar(150) UNIQUE NOT NULL
);
GO
INSERT INTO TiposInstituciones VALUES('P', 'PUBLICA');
INSERT INTO TiposInstituciones VALUES('R', 'PRIVADA');

CREATE TABLE EstadosCiviles(
  CodigoEstadoCivil char(1) PRIMARY KEY,
  NombreEstadoCivil varchar(50) UNIQUE NOT NULL
);
GO
INSERT INTO EstadosCiviles VALUES('S','SOLTERO(A)');
INSERT INTO EstadosCiviles VALUES('C','CASADO(A)');
INSERT INTO EstadosCiviles VALUES('D','DIVORCIADO(A)');
INSERT INTO EstadosCiviles VALUES('V','VIUDO(A)');
INSERT INTO EstadosCiviles VALUES('O','CONCUBINO(A)');

CREATE TABLE TiposAsistenciasCursos(
  CodigoTipoAsistencia char(1) PRIMARY KEY,
  NombreTipoAsistencia varchar(50) UNIQUE NOT NULL
);
GO
INSERT INTO TiposAsistenciasCursos VALUES('E','EXPOSITOR');
INSERT INTO TiposAsistenciasCursos VALUES('O','ORGANIZADOR');
INSERT INTO TiposAsistenciasCursos VALUES('P','PARTICIPANTE');

CREATE TABLE NivelesIdiomas(
  CodigoNivelIdioma char(1) PRIMARY KEY,
  NombreNivelIDioma varchar(50) UNIQUE NOT NULL
);
GO
INSERT INTO NivelesIdiomas VALUES('B','BASICO');
INSERT INTO NivelesIdiomas VALUES('M','MEDIO');
INSERT INTO NivelesIdiomas VALUES('A','AVANZADO');

CREATE TABLE TiposTitulos(
  CodigoTipoTitulo char(1) PRIMARY KEY,
  NombreTipoTitulo varchar(50) UNIQUE NOT NULL
);
GO
INSERT INTO TiposTitulos VALUES('A','DIPLOMA ACADEMICO');
INSERT INTO TiposTitulos VALUES('P','TITULO EN PROVISION NACIONAL');

CREATE TABLE EstadosTitulos(
  CodigoEstadoTitulo char(1) PRIMARY KEY,
  NombreEstadoTitulo varchar(50) UNIQUE NOT NULL
);
GO
INSERT INTO EstadosTitulos VALUES('F','FINALIZADO');
INSERT INTO EstadosTitulos VALUES('C','EN CURSO');

CREATE TABLE Afps(
  CodigoAfp char(1) PRIMARY KEY,
  NombreAfp varchar(50) UNIQUE NOT NULL
);
GO
INSERT INTO Afps VALUES('F','FUTURO DE BOLIVIA S.A.');
INSERT INTO Afps VALUES('P','PREVISION BBVA');
INSERT INTO Afps VALUES('G','GESTORA PUBLICA');

CREATE TABLE SegurosSalud(
  CodigoSeguroSalud char(3) PRIMARY KEY,
  NombreSeguroSalud varchar(100) UNIQUE NOT NULL
);
GO
INSERT INTO SegurosSalud VALUES('SSU','SEGURO SOCIAL UNIVERSITARIO');
INSERT INTO SegurosSalud VALUES('CNS','CAJA NACIONAL DE SALUD');
INSERT INTO SegurosSalud VALUES('CPS','CAJA PETROLERA DE SALUD');

CREATE TABLE TiposDocumentos(
 CodigoTipoDocumento char(4) PRIMARY KEY,
 NombreTipoDocumento char(25) UNIQUE NOT NULL,
 CodigoEstado char(1) NOT NULL,
 CodigoUsuario char(3) NOT NULL,
 FechaHoraRegistro datetime DEFAULT getdate(),
 FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
 FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO
INSERT INTO TiposDocumentos VALUES('MEMO','MEMORANDUM','V', 'BGC',getdate());
INSERT INTO TiposDocumentos VALUES('CONT','CONTRATO','V', 'BGC',getdate());
INSERT INTO TiposDocumentos VALUES('COMU','COMUNICACION INTERNA','V', 'BGC',getdate());

CREATE TABLE TiemposTrabajo(
 CodigoTiempoTrabajo char(2) PRIMARY KEY,
 NombreTiempoTrabajo varchar(50) UNIQUE NOT NULL,CodigoUsuario char(3) NOT NULL,
 CodigoUsuario char(3) NOT NULL,
 FechaHoraRegistro datetime DEFAULT getdate(),
);
GO
INSERT INTO TiemposTrabajo VALUES('TC', 'TIEMPO COMPLETO','BGC',getdate());
INSERT INTO TiemposTrabajo VALUES('MT', 'MEDIO TIEMPO','BGC',getdate());
INSERT INTO TiemposTrabajo VALUES('TH', 'TIEMPO HORARIO','BGC',getdate());

CREATE TABLE Instituciones(
 CodigoInstitucion int PRIMARY KEY,
 NombreInstitucion varchar(150) UNIQUE NOT NULL,
 CodigoTipoInstitucion char(1) NOT NULL,
 CodigoEstado char(1) NOT NULL,
 FechaHoraRegistro datetime DEFAULT getdate(),
 CodigoUsuario char(3) NOT NULL,
 FOREIGN KEY(CodigoTipoInstitucion) REFERENCES TiposInstituciones(CodigoTipoInstitucion),
 FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
 FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE Idiomas(
  CodigoIdioma int PRIMARY KEY,
  NombreIdioma varchar(50) UNIQUE NOT NULL,
  CodigoEstado char(1) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE Titulos(
  CodigoTitulo int PRIMARY KEY,
  NombreTitulo varchar(150) UNIQUE NOT NULL,
  CodigoTipoTitulo char(1) NOT NULL,
  CodigoNivelAcademico char(3) NOT NULL,
  CodigoEstado char(1) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  FOREIGN KEY(CodigoTipoTitulo) REFERENCES TiposTitulos(CodigoTipoTitulo),
  FOREIGN KEY(CodigoNivelAcademico) REFERENCES NivelesAcademicos(CodigoNivelAcademico),
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
  );
GO

CREATE TABLE Unidades(
 CodigoUnidad char(6) PRIMARY KEY,
 NombreUnidad varchar(150) NOT NULL,
 NombreCortoUnidad varchar(100),
 CodigoUnidadPadre char(6),
 CodigoEstado char(1) NOT NULL,
 FechaHoraRegistro datetime DEFAULT getdate(),
 CodigoUsuario char(3) NOT NULL,
 FOREIGN KEY(CodigoUnidadPadre) REFERENCES Unidades(CodigoUnidad),
 FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
 FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE AperturasProgramaticas(
 CodigoUnidad char(6) NOT NULL,
 IdApertura char(14) NOT NULL,
 FechaInicio date NOT NULL,
 FechaFin date,
 CodigoEstado char(1) NOT NULL,
 FechaHoraRegistro datetime DEFAULT getdate(),
 CodigoUsuario char(3) NOT NULL,
 PRIMARY KEY(CodigoUnidad, IdApertura, FechaInicio),
 FOREIGN KEY(CodigoUnidad) REFERENCES Unidades(CodigoUnidad),
 FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
 FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE Cargos(
 CodigoCargo char(6) PRIMARY KEY,
 NombreCargo varchar(150) UNIQUE NOT NULL,
 DescripcionCargo Varchar(500),
 RequisitosPrincipales varchar(500),
 RequisitosOpcionales varchar(500),
 ArchivoManualFunciones varchar(150),
 CodigoSectorTrabajo char(3) NOT NULL,
 CodigoEstado char(1) NOT NULL,
 FechaHoraRegistro datetime DEFAULT getdate(),
 CodigoUsuario char(3) NOT NULL,
 FOREIGN KEY(CodigoSectorTrabajo) REFERENCES SectoresTrabajo(CodigoSectorTrabajo),
 FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
 FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE Items(
 NroItem int PRIMARY KEY,
 NroItemPlanillas varchar(10),
 NroItemRrhh varchar(10),
 CodigoCargo char(6) NOT NULL,
 CodigoCargoDependencia char(6) NOT NULL,
 CodigoUnidad char(6) NOT NULL,
 CodigoEstado char(1) NOT NULL,
 FechaHoraRegistro datetime DEFAULT getdate(),
 CodigoUsuario char(3) NOT NULL,
 FOREIGN KEY(CodigoCargo) REFERENCES Cargos(CodigoCargo),
 FOREIGN KEY(CodigoUnidad) REFERENCES Unidades(CodigoUnidad),
 FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
 FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE Listas(
  CodigoLista char(6) PRIMARY KEY,
  NombreLista varchar(150) UNIQUE NOT NULL,
  CodigoUnidad char(6) NOT NULL,
  CodigoEstado char(1) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  FOREIGN KEY(CodigoUnidad) REFERENCES Unidades(CodigoUnidad),--Unidad a la que pertenece la lista
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE ListasTrabajadores(
  CodigoLista char(6) NOT NULL,
  CodigoTrabajador char(10) NOT NULL,
  Observacion varchar(100),
  CodigoEstado char(1) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  PRIMARY KEY(CodigoLista, CodigoTrabajador),
  FOREIGN KEY(CodigoLista) REFERENCES Listas(CodigoLista),
  FOREIGN KEY(CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE Roles(
 CodigoRol char(3) PRIMARY KEY,
 NombreRol char(15) UNIQUE NOT NULL,
 NumeroRol int NOT NULL
);
GO

CREATE TABLE Usuarios(
 CodigoUsuario char(3) PRIMARY KEY,
 IdPersona char(15) UNIQUE NOT NULL,
 Login varchar(20) UNIQUE NOT NULL,
 Llave char(32) UNIQUE NOT NULL,
 Email varchar(100) UNIQUE NOT NULL,
 Pwd varchar(100) NOT NULL,
 Foto varchar(100) NOT NULL,
 CodigoRol char(3) NOT NULL,
 CodigoEstado char(1) NOT NULL,
 FechaHoraRegistro datetime DEFAULT getdate(),
 FOREIGN KEY(IdPersona) REFERENCES Personas(IdPersona),
 FOREIGN KEY(CodigoRol) REFERENCES Roles(CodigoRol),
 FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
);
GO

CREATE TABLE UsuariosCarreras(
	CodigoUsuario char(3) NOT NULL,
	CodigoCarrera int NOT NULL,
	CodigoSede int NOT NULL,
	CodigoUsuarioAutoridad char(3),
	CodigoEstado char(1) NOT NULL,
	FechaHoraRegistro datetime DEFAULT getdate(),
	CodigoUsuarioRegistra char(3) NOT NULL,
	PRIMARY KEY(CodigoUsuario, CodigoCarrera, CodigoSede),
	FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario),
	FOREIGN KEY(CodigoUsuarioAutoridad) REFERENCES Usuarios(CodigoUsuario),
	FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
	FOREIGN KEY(CodigoUsuarioRegistra) REFERENCES Usuarios(CodigoUsuario)
);
GO