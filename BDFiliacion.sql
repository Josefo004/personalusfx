/*IF EXISTS (SELECT name FROM sys.databases WHERE name = N'RecursosHumanos')
    DROP DATABASE [RecursosHumanos]
GO
USE master;
CREATE DATABASE RecursosHumanos;
GO*/
USE RecursosHumanos;

CREATE TABLE Personas(
	IdPersona char(15) PRIMARY KEY,
	CodigoLugarEmision char(2) NOT NULL,
	Paterno varchar(25),
	Materno varchar(25) NOT NULL,
	Nombres varchar(50) NOT NULL,
	FechaNacimiento date NOT NULL,
	Sexo char(1) NOT NULL,
	Discapacidad char(1) NOT NULL,
	CodigoLugarNacimiento int NOT NULL,
	CodigoEstado char(1) NOT NULL,
	FechaHoraRegistro datetime DEFAULT getdate(),
	CodigoUsuario char(3) NOT NULL,
	FOREIGN KEY(CodigoLugarNacimiento) REFERENCES Lugares(CodigoLugar),
	FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
	FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE CambiosIdentidad(
 IdPersona char(15) PRIMARY KEY,
 IdPersonaAntes char(15) NOT NULL,
 FechaModificacion date NOT NULL,
 Observacion varchar(150),
 FechaHoraRegistro datetime DEFAULT getdate(),
 CodigoUsuario char(3) NOT NULL,
 FOREIGN KEY(IdPersonaAntes) REFERENCES Personas(IdPersona),
 FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE Trabajadores(
 CodigoTrabajador char(10) PRIMARY KEY,
 IdPersona char(15) UNIQUE NOT NULL,
 FechaIngreso date NOT NULL,
 FechaSalida date,
 ResolucionDocente varchar(50),
 FechaResolucionDocente date,
 FechaCalculoDocente date,
 ResolucionAdministrativo varchar(50),
 FechaResolucionAdministrativo date,
 FechaCalculoAdministrativo date,
 CodigoNivelAcademico char(3) NOT NULL,
 CodigoAfp char(1) NOT NULL,
 Cua char(15),
 CodigoSeguroSalud char(3) NOT NULL,
 CodigoEstado char(1) NOT NULL,
 FechaHoraRegistro datetime DEFAULT getdate(),
 CodigoUsuario char(3) NOT NULL,
 FOREIGN KEY(IdPersona) REFERENCES Personas(IdPersona),
 FOREIGN KEY(CodigoNivelAcademico) REFERENCES NivelesAcademicos(CodigoNivelAcademico),
 FOREIGN KEY(CodigoAfp) REFERENCES Afps(CodigoAfp),
 FOREIGN KEY(CodigoSeguroSalud) REFERENCES SegurosSalud(CodigoSeguroSalud),
 FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
 FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE TrabajadoresDatos(
 CodigoTrabajador char(10) PRIMARY KEY,
 CodigoNacionalidad int NOT NULL,
 CodigoEstadoCivil char(1) NOT NULL,
 ApellidoEsposo varchar(50),
 Direccion varchar(100),
 NumeroDireccion varchar(6),
 Telefono varchar(25) ,
 Celular varchar(35),
 Email varchar(50),
 Observaciones text,
 FechaHoraRegistro datetime DEFAULT getdate(),
 CodigoUsuario char(3) NOT NULL,
 FOREIGN KEY(CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),
 FOREIGN KEY(CodigoNacionalidad) REFERENCES Nacionalidades(CodigoNacionalidad),
 FOREIGN KEY(CodigoEstadoCivil) REFERENCES EstadosCiviles(CodigoEstadoCivil),
 FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE TrabajadoresIdiomas(
  CodigoTrabajador char(10) NOT NULL,
  CodigoIdioma int NOT NULL,
  CodigoNivelOral char(1) NOT NULL,
  CodigoNivelEscrito char(1) NOT NULL,
  Observaciones varchar(300),
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  PRIMARY KEY(CodigoTrabajador, CodigoIdioma),
  FOREIGN KEY(CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),
  FOREIGN KEY(CodigoIdioma) REFERENCES Idiomas(CodigoIdioma),
  FOREIGN KEY(CodigoNivelOral) REFERENCES NivelesIdiomas(CodigoNivelIdioma),
  FOREIGN KEY(CodigoNivelEscrito) REFERENCES NivelesIdiomas(CodigoNivelIdioma),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE TrabajadoresTitulos(
  CodigoTrabajador char(10) NOT NULL,
  CodigoTitulo int NOT NULL,
  CodigoInstitucion int NOT NULL,
  CodigoEstadoTitulo char(1) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  PRIMARY KEY(CodigoTrabajador, CodigoTitulo),
  FOREIGN KEY(CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),
  FOREIGN KEY(CodigoTitulo) REFERENCES Titulos(CodigoTitulo),
  FOREIGN KEY(CodigoInstitucion) REFERENCES Instituciones(CodigoInstitucion),
  FOREIGN KEY(CodigoEstadoTitulo) REFERENCES EstadosTitulos(CodigoEstadoTitulo),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE TrabajadoresInstituciones(
  CodigoTrabajador char(10) NOT NULL,
  CodigoInstitucion int NOT NULL,
  CodigoSectorTrabajo char(3) NOT NULL,
  Puesto varchar(100) NOT NULL,
  FechaInicio date NOT NULL,
  Fechafin date,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  PRIMARY KEY(CodigoTrabajador, CodigoInstitucion, FechaInicio),
  FOREIGN KEY(CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),
  FOREIGN KEY(CodigoInstitucion) REFERENCES Instituciones(CodigoInstitucion),
  FOREIGN KEY(CodigoSectorTrabajo) REFERENCES SectoresTrabajo(CodigoSectorTrabajo),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE TrabajadoresInvestigaciones(
  CodigoTrabajador char(10) NOT NULL,
  TituloInvestigacion varchar(100) NOT NULL,
  DescripcionInvestigacion varchar (300),
  LugarPublicacion varchar(100),
  FechaPublicacion date NOT NULL,
  Referencia varchar(100),
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  PRIMARY KEY(CodigoTrabajador, TituloInvestigacion),
  FOREIGN KEY(CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE TrabajadoresDistinciones(
  CodigoTrabajador char(10) NOT NULL,
  CodigoInstitucion int NOT NULL,
  FechaDistincion date NOT NULL,
  DescripcionDistincion varchar(200),
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  PRIMARY KEY(CodigoTrabajador, FechaDistincion),
  FOREIGN KEY(CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),
  FOREIGN KEY(CodigoInstitucion) REFERENCES Instituciones(CodigoInstitucion),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE TrabajadoresCertificados(
  CodigoTrabajador char(10) NOT NULL,
  FechaCertificacion date NOT NULL,
  CodigoTipoAsistencia char(1) NOT NULL,
  NombreCertificacion varchar(200) NOT NULL,
  CodigoInstitucion int NOT NULL,
  CargaHoraria int,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  PRIMARY KEY(CodigoTrabajador, FechaCertificacion, CodigoTipoAsistencia),
  FOREIGN KEY(CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),
  FOREIGN KEY(CodigoTipoAsistencia) REFERENCES TiposAsistencias(CodigoTipoAsistencia),
  FOREIGN KEY(CodigoInstitucion) REFERENCES Instituciones(CodigoInstitucion)
);
GO

CREATE TABLE TrabajadoresOtrasInstituciones(
 CodigoTrabajador char(10) NOT NULL,
 CodigoInstitucion int NOT NULL,
 CodigoSectorTrabajo char(3) NOT NULL,
 Puesto varchar(100) NOT NULL,
 FechaInicio date NOT NULL,
 FechaFin date,
 HaberBasico float,
 TotalGanado float,
 LiquidoPagable float,
 FechaHoraRegistro datetime DEFAULT getdate(),
 CodigoUsuario char(3) NOT NULL,
 PRIMARY KEY(CodigoTrabajador, CodigoInstitucion, FechaInicio),
 FOREIGN KEY(CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),
 FOREIGN KEY(CodigoInstitucion) REFERENCES Instituciones(CodigoInstitucion),
 FOREIGN KEY(CodigoSectorTrabajo) REFERENCES SectoresTrabajo(CodigoSectorTrabajo),
 FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE AsignacionesAdministrativos(
 CodigoAsignacion char(8) PRIMARY KEY,
 CodigoTrabajador char(10) NOT NULL,
 NroItem int NOT NULL,
 FechaInicio date NOT NULL,
 FechaFin date,
 Jefatura int NOT NULL,
 NroDocumento varchar(50) NOT NULL,
 FechaDocumento date NOT NULL,
 Interinato int NOT NULL,
 CodigoTiempoTrabajo char(2) NOT NULL,
 CodigoNivelSalarial int NOT NULL,
 CodigoCondicionLaboral char(3) NOT NULL,
 CodigoTipoDocumento char(4) NOT NULL,
 CodigoEstado char(1) NOT NULL,
 FechaHoraRegistro datetime DEFAULT getdate(),
 CodigoUsuario char(3) NOT NULL,
 FOREIGN KEY(CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),
 FOREIGN KEY(NroItem) REFERENCES Items(NroItem),
 FOREIGN KEY(CodigoNivelSalarial) REFERENCES NivelesSalariales(CodigoNivelSalarial),
 FOREIGN KEY(CodigoCondicionLaboral) REFERENCES CondicionesLaborales(CodigoCondicionLaboral),
 FOREIGN KEY(CodigoUnidad) REFERENCES Unidades(CodigoUnidad),
 FOREIGN KEY(CodigoCargo) REFERENCES Cargos(CodigoCargo),
 FOREIGN KEY(CodigoTipoDocumento) REFERENCES TiposDocumentos(CodigoTipoDocumento),
 FOREIGN KEY(CodigoTiempoTrabajo) REFERENCES TiemposTrabajo(CodigoTiempoTrabajo),
 FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
 FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE AsignacionesDocentes(
 CodigoAsignacion char(8) PRIMARY KEY,
 CodigoTrabajador char(10) NOT NULL,
 NroItem int NOT NULL,
 FechaInicio date NOT NULL,
 FechaFin date,
 Jefatura int NOT NULL,
 Interinato int NOT NULL,
 CodigoTiempoTrabajo char(2) NOT NULL,
 CodigoNivelSalarial int NOT NULL,
 CodigoCondicionLaboral char(3) NOT NULL,
 CodigoEstado char(1) NOT NULL,
 FechaHoraRegistro datetime DEFAULT getdate(),
 CodigoUsuario char(3) NOT NULL,
 FOREIGN KEY(CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),
 FOREIGN KEY(NroItem) REFERENCES Items(NroItem),
 FOREIGN KEY(CodigoNivelSalarial) REFERENCES NivelesSalariales(CodigoNivelSalarial),
 FOREIGN KEY(CodigoCondicionLaboral) REFERENCES CondicionesLaborales(CodigoCondicionLaboral),
 FOREIGN KEY(CodigoUnidad) REFERENCES Unidades(CodigoUnidad),
 FOREIGN KEY(CodigoTiempoTrabajo) REFERENCES TiemposTrabajo(CodigoTiempoTrabajo),
 FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
 FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO