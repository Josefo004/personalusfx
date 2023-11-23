IF EXISTS (SELECT name FROM sys.databases WHERE name = N'RecursosHumanos')
    DROP DATABASE [RecursosHumanos]
GO
USE master;
CREATE DATABASE RecursosHumanos;
GO
USE RecursosHumanos;
--TABLAS QUE SON UTILIZADAS SOLO COMO LLAVES FORANEAS 
-----------------------------------------------------
CREATE TABLE Estados(
 CodigoEstado char(1) PRIMARY KEY,
 NombreEstado varchar(50) UNIQUE NOT NULL, 
);
GO
INSERT INTO Estados VALUES('V', 'VIGENTE');
INSERT INTO Estados VALUES('C', 'CADUCADO');
INSERT INTO Estados VALUES('P', 'PENDIENTE');
INSERT INTO Estados VALUES('F', 'FINALIZADO');
INSERT INTO Estados VALUES('E', 'EJECUTADO');
INSERT INTO Estados VALUES('Z', 'NO EJECUTADO');

CREATE TABLE NivelesAcademicos(
 CodigoNivelAcademico char(3) PRIMARY KEY,
 NombreNivelAcademico char(250) UNIQUE NOT NULL,
 NombreCortoNivelAcademico char(150) 
);
GO
INSERT INTO NivelesAcademicos VALUES('NIN','NINGUNO', 'NINGUNO');
INSERT INTO NivelesAcademicos VALUES('BHU','BACHILLER EN HUMANIDADES', 'BACHILLER');
INSERT INTO NivelesAcademicos VALUES('TMU','TECNICO MEDIO UNIVERSITARIO', 'TECNICO MEDIO');
INSERT INTO NivelesAcademicos VALUES('TSU','TECNICO SUPERIOR UNIVERSITARIO', 'TECNICO SUPERIOR');
INSERT INTO NivelesAcademicos VALUES('LIC','LICENCIATURA', 'LICENCIATURA');
INSERT INTO NivelesAcademicos VALUES('DIP','DIPLOMADO', 'DIPLOMADO');
INSERT INTO NivelesAcademicos VALUES('ESP','ESPECIALIDAD', 'ESPECIALIDAD');
INSERT INTO NivelesAcademicos VALUES('MAE','MAESTRIA', 'MAESTRIA');
INSERT INTO NivelesAcademicos VALUES('DOC','DOCTORADO', 'DOCTORADO');

CREATE TABLE SectoresTrabajo(
 CodigoSectorTrabajo char(3) PRIMARY KEY,
 NombreSectorTrabajo char(25) UNIQUE NOT NULL,
 CodigoEstado char(1) NOT NULL,
 FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado)
);
GO
INSERT INTO SectoresTrabajo VALUES('DOC','Docente','V');
INSERT INTO SectoresTrabajo VALUES('ADM','Administrativo','V');

CREATE TABLE CondicionesLaborales(
  CodigoCondicionLaboral char(3) PRIMARY KEY,
  NombreCondicionLaboral varchar(150) UNIQUE NOT NULL,
  CodigoSectorTrabajo char(3) NOT NULL,
  CodigoEstado char(1) NOT NULL,
  FOREIGN KEY(CodigoSectorTrabajo) REFERENCES SectoresTrabajo(CodigoSectorTrabajo),
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado)
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

CREATE TABLE TiposRetiros(
 CodigoTipoRetiro char(3) PRIMARY KEY,
 NombreTipoRetiro varchar(150) UNIQUE NOT NULL
);
INSERT INTO TiposRetiros VALUES('FIN', 'FINALIZACION CONTRATACION');
INSERT INTO TiposRetiros VALUES('REN', 'RENUNCIA VOLUNTARIA');
INSERT INTO TiposRetiros VALUES('JUB', 'JUBILACION');
INSERT INTO TiposRetiros VALUES('PRO', 'PROCESO ADMINISTRATIVO');
INSERT INTO TiposRetiros VALUES('FAL', 'FALLECIMIENTO');

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

CREATE TABLE TiposAsistencias(
  CodigoTipoAsistencia char(1) PRIMARY KEY,
  NombreTipoAsistencia varchar(50) UNIQUE NOT NULL
);
GO
INSERT INTO TiposAsistencias VALUES('E','EXPOSITOR');
INSERT INTO TiposAsistencias VALUES('O','ORGANIZADOR');
INSERT INTO TiposAsistencias VALUES('P','PARTICIPANTE');

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

--TABLAS LUGARES DE ORIGEN
--------------------------
CREATE TABLE Paises(
  CodigoPais int PRIMARY KEY,
  NombrePais char(150) UNIQUE NOT NULL,
  CodigoEstado char(1) NOT NULL,
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado)
);
GO
INSERT INTO Paises VALUES(51, 'Peru');
INSERT INTO Paises VALUES(54, 'Argentina');
INSERT INTO Paises VALUES(55, 'Brasil');
INSERT INTO Paises VALUES(56, 'Chile');
INSERT INTO Paises VALUES(57, 'Colombia');
INSERT INTO Paises VALUES(85, 'Venezuela');
INSERT INTO Paises VALUES(591, 'Bolivia');
INSERT INTO Paises VALUES(593, 'Ecuador');
INSERT INTO Paises VALUES(598, 'Uruguay');

CREATE TABLE Departamentos(
  CodigoPais int NOT NULL,
  CodigoDepartamento char(2) NOT NULL,  
  NombreDepartamento char(150) NOT NULL,
  CodigoEstado char(1) NOT NULL,
  PRIMARY KEY(CodigoPais, CodigoDepartamento),
  FOREIGN KEY(CodigoPais) REFERENCES Paises(CodigoPais),
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado)
);
GO
INSERT INTO Departamentos VALUES(591, 'BE',	'Beni');
INSERT INTO Departamentos VALUES(591, 'CH',	'Chuquisaca');
INSERT INTO Departamentos VALUES(591, 'CO',	'Cochabamba');
INSERT INTO Departamentos VALUES(591, 'LP',	'La Paz');
INSERT INTO Departamentos VALUES(591, 'OR',	'Oruro');
INSERT INTO Departamentos VALUES(591, 'PA',	'Pando');
INSERT INTO Departamentos VALUES(591, 'PO',	'Potosi');
INSERT INTO Departamentos VALUES(591, 'SC',	'Santa Cruz');
INSERT INTO Departamentos VALUES(591, 'TA',	'Tarija');

CREATE TABLE Provincias(
  CodigoPais int NOT NULL,
  CodigoDepartamento char(2) NOT NULL,
  CodigoProvincia char(2) NOT NULL,
  NombreProvincia char(150) NOT NULL,
  CodigoEstado char(1) NOT NULL,
  PRIMARY KEY(CodigoPais, CodigoDepartamento, CodigoProvincia),
  FOREIGN KEY(CodigoPais, CodigoDepartamento) REFERENCES Departamentos(CodigoPais, CodigoDepartamento),
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado)
);
GO
INSERT INTO Provincias
SELECT 591, CodigoDepartamento, CodigoProvincia, NombreProvincia
FROM RRHH.dbo.Provincias
WHERE CodigoPais='BO'
CREATE TABLE Lugares(
  CodigoPais int NOT NULL,
  CodigoDepartamento char(2) NOT NULL,
  CodigoProvincia char(2) NOT NULL,
  CodigoLugar int NOT NULL PRIMARY KEY,
  NombreLugar char(150) NOT NULL,
  CodigoEstado char(1) NOT NULL,
  FOREIGN KEY(CodigoPais, CodigoDepartamento, CodigoProvincia) REFERENCES Provincias(CodigoPais, CodigoDepartamento, CodigoProvincia),
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado)
);
GO
INSERT INTO Lugares
SELECT 591, CodigoDepartamento, CASE WHEN CodigoProvincia='B' THEN 'BA' ELSE CodigoProvincia END, ROW_NUMBER() over(ORDER BY CodigoDepartamento, CodigoProvincia), NombreLugar
FROM RRHH.dbo.Lugares
WHERE CodigoPais='BO'
ORDER BY CodigoDepartamento, CodigoProvincia


--TABLAS DE USUARIOS Y PERSONAS
-------------------------------
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

CREATE TABLE Roles(
 CodigoRol char(3) PRIMARY KEY,
 NombreRol char(15) UNIQUE NOT NULL
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
 FOREIGN KEY (IdPersona) REFERENCES Personas(IdPersona),
 FOREIGN KEY (CodigoRol) REFERENCES Roles(CodigoRol)
);
GO

CREATE TABLE UsuariosRoles(
 CodigoUsuario char(3),
 CodigoRol char(3),
 PRIMARY KEY(CodigoUsuario, CodigoRol)
);
GO
INSERT INTO UsuariosRoles VALUES('BGC','ADM');
INSERT INTO UsuariosRoles VALUES('CSP','ADM');
INSERT INTO UsuariosRoles VALUES('OTR','ADM');

CREATE TABLE UsuariosExternos(
 IdUsuario int IDENTITY PRIMARY KEY,
 IdPersona char(15) UNIQUE NOT NULL,
 Email varchar(50) UNIQUE NOT NULL, 
 Clave varchar(100),
 Foto varchar(150),
 Modo char(10),
 FOREIGN KEY(IdPersona) REFERENCES Personas(IdPersona)
);
GO

CREATE TABLE Nacionalidades(
  CodigoNacionalidad int PRIMARY KEY,
  NombreNacionalidad varchar(50) UNIQUE NOT NULL,
  CodigoEstado char(1) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

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

CREATE TABLE Trabajadores(
 CodigoTrabajador char(10) PRIMARY KEY,
 IdPersona char(15) UNIQUE NOT NULL,
 FechaIngreso date NOT NULL,
 FechaSalida date,
 ResolucionDocente varchar(50),
 FechaResolucionDocente date,
 ResolucionAdministrativo varchar(50),
 FechaResolucionAdministrativo date,
 CodigoNivelAcademico char(3) NOT NULL,
 CodigoAfp char(1) NOT NULL,
 CodigoEstado char(1) NOT NULL,
 FechaHoraRegistro datetime DEFAULT getdate(),
 CodigoUsuario char(3) NOT NULL,
 FOREIGN KEY(IdPersona) REFERENCES Personas(IdPersona),
 FOREIGN KEY(CodigoNivelAcademico) REFERENCES NivelesAcademicos(CodigoNivelAcademico),
 FOREIGN KEY(CodigoAfp) REFERENCES Afps(CodigoAfp),
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

--TABLAS DE ORGANIGRAMA
-----------------------

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

/*CREATE TABLE AperturasProgramaticas(
 CodigoUnidad char(6),
 IdApertura char(14),
 FechaInicio date,
 FechaFin date,
 FechaHoraRegistro datetime DEFAULT getdate(),
 CodigoUsuario char(3),
 PRIMARY KEY(CodigoUnidad, IdApertura),
 FOREIGN KEY(CodigoUnidad) REFERENCES Unidades(CodigoUnidad),
 FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO*/

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
INSERT INTO Cargos VALUES('DOC001','DOCENTE ORDINARIO','Docente Titular','Antigüedad o experiencia profesional no menor a dos años.'+CHAR(13)+CHAR(10)+'Curso básico de formación docente, diplomado en Educación Superior como mínimo','','DOC001.pdf',NULL,'DOC','V', getdate(), 'BGC');
INSERT INTO Cargos VALUES('DOC002','DOCENTE CONTRATO CONTINUO','Docente con continuidad','Antigüedad o experiencia profesional no menor a dos años.'+CHAR(13)+CHAR(10)+'Curso básico de formación docente, diplomado en Educación Superior como mínimo','','DOC001.pdf',NULL,'DOC','V', getdate(), 'BGC');
INSERT INTO Cargos VALUES('DOC003','DOCENTE CONTRATO FIJO','Docente a contrato fijo','Antigüedad o experiencia profesional no menor a dos años.'+CHAR(13)+CHAR(10)+'Curso básico de formación docente, diplomado en Educación Superior como mínimo','','DOC001.pdf',NULL,'DOC','V', getdate(), 'BGC');
INSERT INTO Cargos VALUES('DOC004','DOCENTE SUPLENTE','Docente suplente','Antigüedad o experiencia profesional no menor a dos años.'+CHAR(13)+CHAR(10)+'Curso básico de formación docente, diplomado en Educación Superior como mínimo','','DOC001.pdf',NULL,'DOC','V', getdate(), 'BGC');

CREATE TABLE Items(
 NroItem int PRIMARY KEY,
 CodigoCargo char(6) NOT NULL,
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

CREATE TABLE NivelesSalariales(
  CodigoNivelSalarial int PRIMARY KEY,
  NombreNivelSalarial varchar(10) UNIQUE NOT NULL,  
  HaberBasico float NOT NULL,
  CodigoCondicionLaboral char(3) NOT NULL,
  CodigoEstado char(1) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  FOREIGN KEY(CodigoCondicionLaboral) REFERENCES CondicionesLaborales(CodigoCondicionLaboral),
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE Asignaciones(
 CodigoAsignacion char(6) PRIMARY KEY,
 CodigoTrabajador char(10) NOT NULL, 
 NroItem int NOT NULL,
 FechaInicio date NOT NULL,
 FechaFin date,
 Jefatura int NOT NULL,
 CodigoNivelSalarial int NOT NULL,
 FechaHoraRegistro datetime DEFAULT getdate(),
 CodigoUsuario char(3), 
 FOREIGN KEY (CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),
 FOREIGN KEY (NroItem) REFERENCES Items(NroItem), 
 FOREIGN KEY (CodigoNivelSalarial) REFERENCES NivelesSalariales(CodigoNivelSalarial),
 FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE DocumentosRetiros(
  NroCite varchar(50) PRIMARY KEY,
  Referencia varchar(100),
  Detalle varchar(300),
  FechaDocumento date NOT NULL,  
  FechaRetiro date NOT NULL,
  CodigoTrabajador char(10) NOT NULL,      
  CodigoTipoRetiro char(3) NOT NULL,
  CodigoEstado char(1) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  FOREIGN KEY (CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),    
  FOREIGN KEY (CodigoTipoRetiro) REFERENCES TiposRetiros(CodigoTipoRetiro),
  FOREIGN KEY (CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE TrabajadoresRetiros(
  NroCite varchar(50) NOT NULL,  
  NroItem int NOT NULL,
  RetiroTotal int NOT NULL,
  Observacion varchar(500),
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  PRIMARY KEY (NroCite, NroItem),
  FOREIGN KEY (NroCite) REFERENCES DocumentosRetiros(NroCite),  
  FOREIGN KEY (NroItem) REFERENCES Items(NroItem),  
  FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

--TABLAS DE PLANILLAS
---------------------
CREATE TABLE TiposPlanillas(
  CodigoTipoPlanillas char(3) PRIMARY KEY,
  NombrePlanilla varchar(150) UNIQUE NOT NULL,
  CodigoEstado char(1) NOT NULL,
  FOREIGN KEY (CodigoEstado) REFERENCES Estados(CodigoEstado)
);
GO

CREATE TABLE Sanciones(
  CodigoSancion int PRIMARY KEY,
  NombreSancion varchar(100) NOT NULL,
  NombreCortoSancion varchar(25) NOT NULL,
  CodigoEstado char(1) NOT NULL,  
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  FOREIGN KEY (CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO
INSERT INTO Sanciones VALUES(1, 'Falta con Licencia', 'F. Sin/Lic', 'V', getdate(), 'BGC');
INSERT INTO Sanciones VALUES(2, 'Falta con Licencia', 'F. Con/Lic', 'V', getdate(), 'BGC');
INSERT INTO Sanciones VALUES(3, 'Atraso', 'Atraso', 'V', getdate(), 'BGC');
INSERT INTO Sanciones VALUES(4, 'Media Falta', 'Med/Falt', 'V', getdate(), 'BGC');
INSERT INTO Sanciones VALUES(5, 'Omision en Registro', 'Omi/Reg', 'V', getdate(), 'BGC');

CREATE TABLE DocumentosSanciones(
  NroCite varchar(50) PRIMARY KEY,
  Referencia varchar(100),
  Detalle varchar(300),
  Gestion int NOT NULL,
  Mes int NOT NULL,
  CodigoSectorTrabajo char(3) NOT NULL,
  CodigoEstado char(1) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  FOREIGN KEY (CodigoSectorTrabajo) REFERENCES SectoresTrabajo(CodigoSectorTrabajo),
  FOREIGN KEY (CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE TrabajadoresSanciones(
  NroCite varchar(50) NOT NULL,
  CodigoTrabajador char(10) NOT NULL,
  CodigoSancion int NOT NULL,
  Dias int,
  Horas int,
  Monto float,
  Observacion varchar(100),  
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  PRIMARY KEY (NroCite, CodigoTrabajador, CodigoSancion),
  FOREIGN KEY (NroCite) REFERENCES DocumentosDescuentos(NroCite),
  FOREIGN KEY (CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),  
  FOREIGN KEY (CodigoSancion) REFERENCES Sanciones(CodigoSancion),  
  FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)  
);
GO







/*Tablas añadidas el 30/04/2021 */

CREATE TABLE SalariosMinimos(
  CodigoSalarioMinimo int PRIMARY KEY,
  Gestion  int NOT NULL,
  Monto float NOT NULL,
  DecretoSupremo varchar(10) NOT NULL,
  FechaPromulgacion date NOT NULL,
  FechaAplicacion date NOT NULL,
  CodigoEstado char(1) NOT NULL,
  CodigoUsuario char(3) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);

CREATE TABLE AsignacionesFamiliares(
  CodigoAsignacionFamiliar int PRIMARY KEY,
  Monto float NOT NULL,
  ResolucionMinisterial varchar(10) NOT NULL,
  FechaPromulgacion date NOT NULL,
  FechaInicioAplicacion date NOT NULL,
  FechaFinAplicacion date NOT NULL,
  CodigoEstado char(1)NOT NULL,
  CodigoUsuario char(3),
  FechaHoraRegistro datetime DEFAULT getdate(),
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);

--TABLAS DE CARGA HORARIA
-------------------------


/*TABLAS PARA LOS MANUALES DE USUARIO (PENDIENTE)*/
CREATE TABLE FuncionesCargo(
 CodigoCargo char(5),
 Correlativo int,
 DescripcionFuncion Varchar(500) not null, 
 FechaHoraRegistro datetime not null,
 CodigoUsuario char(3) not null, 
 PRIMARY KEY (CodigoCargo, Correlativo),
 FOREIGN KEY (CodigoCargo) REFERENCES Cargos(CodigoCargo),  
 FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO
CREATE TABLE ResponsabilidadesCargo(
 CodigoCargo char(5),
 Correlativo int,
 DescripcionResponsabilidad Varchar(500) not null,  
 FechaHoraRegistro datetime not null,
 CodigoUsuario char(3) not null, 
 PRIMARY KEY (CodigoCargo, Correlativo),
 FOREIGN KEY (CodigoCargo) REFERENCES Cargos(CodigoCargo),  
 FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO
CREATE TABLE FormacionesCargo(
 CodigoCargo char(5),
 CodigoFormacion char(5), 
 FechaHoraRegistro datetime not null,
 CodigoUsuario char(3) not null,
 PRIMARY KEY (CodigoCargo, CodigoFormacion),
 FOREIGN KEY (CodigoCargo) REFERENCES Cargos(CodigoCargo),  
 FOREIGN KEY (CodigoFormacion) REFERENCES Formaciones(CodigoFormacion),  
 FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE PuestosTrabajo(
 CodigoUnidad char(5),
 CodigoCargo char(5),
 Correlativo int, 
 CodigoEstado char(1),
 FechaHoraRegistro datetime,
 CodigoUsuario char(3),
 PRIMARY KEY (CodigoUnidad, CodigoCargo, Correlativo),
 FOREIGN KEY (CodigoUnidad) REFERENCES Unidades(CodigoUnidad),
 FOREIGN KEY (CodigoCargo) REFERENCES Cargos(CodigoCargo),
 FOREIGN KEY (CodigoEstado) REFERENCES Estados(CodigoEstado),
 FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO
create table Roles
(
CodigoRol varchar(20) primary key,
NombreRol varchar(50) not null,
CodigoEstado char(1) not null default 'V',
fechaRegistro datetime not null default getdate(),
CodigoUsuario char(3) not null,
foreign key(CodigoUsuario) references Usuarios(CodigoUsuario),
foreign key(CodigoEstado) references Estados(CodigoEstado)
)

create table Permisos
(
CodigoPermiso int identity(1,1) primary key,
Identificador varchar(10) not null,
Descripcion varchar(100) not null,
CodigoEstado char(1) not null default 'V',
fechaRegistro datetime not null default getdate(),
CodigoUsuario char(3) not null,
foreign key(CodigoUsuario) references Usuarios(CodigoUsuario),
foreign key(CodigoEstado) references Estados(CodigoEstado)
)

create table PermisosRol(
CodigoRol varchar(20) not null,
CodigoPermiso int not null,
primary key(CodigoRol,CodigoPermiso),
Asignado int not null default 0,
CodigoEstado char(1) not null default 'V',
fechaRegistro datetime not null default getdate(),
CodigoUsuario char(3) not null,
foreign key (CodigoRol) references Roles(CodigoRol),
foreign key (CodigoPermiso) references Permisos(CodigoPermiso),
foreign key(CodigoUsuario) references Usuarios(CodigoUsuario),
foreign key(CodigoEstado) references Estados(CodigoEstado)
)

create table UsuariosRoles (
CodigoUsuario char(3) not null,
CodigoRol varchar(20) not null,
primary key(CodigoUsuario,CodigoRol),
CodigoEstado char(1) not null default 'V',
fechaRegistro datetime not null default getdate(),
Alta char(3) not null,
foreign key (CodigoUsuario) references usuarios(CodigoUsuario),
foreign key (CodigoRol) references Roles(CodigoRol),
foreign key(Alta) references Usuarios(CodigoUsuario),
foreign key(CodigoEstado) references Estados(CodigoEstado)
)

insert into roles Values('DCECO','Director de carrera economia',default,default,'BGC')
insert into Permisos values('LOGADM','acceso al backend',default,default,'BGC')
insert into Permisos values('MNPersona','Acceso al menu personas',default,default,'BGC')
insert into PermisosRol values('DCECO',1,default,default,default,'BGC')
insert into PermisosRol values('DCECO',2,default,default,default,'BGC')
insert into UsuariosRoles values('BGC','DCECO',default,default,'VZS')


select * from Roles
select * from Permisos
select * from PermisosRol
select * from UsuariosRoles


update PermisosRol set Asignado = 1 where CodigoPermiso = 2


CREATE TABLE CargaHorariaInasistenciasMes(
  Gestion varchar(4) NOT NULL,
  Mes int NOT NULL,
  CodigoCarrera tinyint NOT NULL,
  NumeroPlanEstudios tinyint NOT NULL,
  SiglaMateria char(6) NOT NULL,
  Grupo char(2) NOT NULL,
  Fecha date NOT NULL,
  CodigoTrabajador char(10) NOT NULL,
  CodigoTipoInasistencia int NOT NULL,
  Horas int NOT NULL,
  Observaciones varchar(100),
  CodigoUsuario char(3) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  PRIMARY KEY(Gestion, Mes, CodigoCarrera, NumeroPlanEstudios, SiglaMateria, Grupo, Fecha, CodigoTrabajador, CodigoTipoInasistencia),    
  FOREIGN KEY(CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),
  FOREIGN KEY(CodigoTipoInasistencia) REFERENCES TiposInasistencia(CodigoTipoInasistencia),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);


CREATE TABLE TiposInasistencia(
  CodigoTipoInasistencia int PRIMARY KEY,
  Descripcion varchar(70) NOT NULL,
  Sancion float NOT NULL,
  CodigoEstado char(1) NOT NULL,
  CodigoUsuario char(3) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);

