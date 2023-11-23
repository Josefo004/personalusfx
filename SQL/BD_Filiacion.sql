CREATE TABLE Paises(
  CodigoPais INT PRIMARY KEY,
  NombrePais VARCHAR (50) UNIQUE NOT NULL,
  CodigoPaisAcad CHAR (2) NOT NULL,
  Nacionalidad VARCHAR (50) NOT NULL,
  CodigoEstado CHAR (1) NOT NULL,
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado)
);
GO

CREATE TABLE Departamentos(
  CodigoDepartamento INT PRIMARY KEY,
  NombreDepartamento VARCHAR(50) NOT NULL,
  CodigoPais INT NOT NULL,
  CodigoPaisAcad CHAR(2) NOT NULL,
  CodigoDepartamentoAcad CHAR(2) NOT NULL,
  CodigoEstado CHAR(1) NOT NULL,
  FOREIGN KEY(CodigoPais) REFERENCES Paises(CodigoPais),
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado)
);
GO

CREATE TABLE Provincias(
  CodigoProvincia INT PRIMARY KEY,
  NombreProvincia CHAR(50) NOT NULL,
  CodigoDepartamento INT NOT NULL,
  CodigoPaisAcad CHAR(2) NOT NULL,
  CodigoDepartamentoAcad CHAR(2) NOT NULL,
  CodigoProvinciaAcad CHAR(2) NOT NULL,
  CodigoEstado CHAR(1) NOT NULL,
  FOREIGN KEY(CodigoDepartamento) REFERENCES Departamentos(CodigoDepartamento),
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado)
);
GO

CREATE TABLE Lugares(
  CodigoLugar INT NOT NULL PRIMARY KEY,
  NombreLugar CHAR(50) NOT NULL,
  CodigoProvincia INT NOT NULL,
  CodigoPaisAcad CHAR(2) NOT NULL,
  CodigoDepartamentoAcad CHAR(2) NOT NULL,
  CodigoProvinciaAcad CHAR(2) NOT NULL,
  CodigoLugarAcad CHAR(2) NOT NULL,
  IdLugar INT NOT NULL,
  CodigoEstado CHAR(1) NOT NULL,
  FOREIGN KEY(CodigoProvincia) REFERENCES Provincias(CodigoProvincia),
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado)
);
GO

CREATE TABLE LugaresEmision(
 CodigoLugarEmision char(2) PRIMARY KEY,
 NombreLugarEmision char(25) NOT NULL,
 CodigoEstado char(1) NOT NULL,
 CodigoUsuario char(3) NOT NULL,
 FechaHoraRegistro datetime DEFAULT getdate(),
 FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
 FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE Personas(
	IdPersona char(15) PRIMARY KEY,
	CodigoLugarEmision char(2) NOT NULL,
	Paterno varchar(50),
	Materno varchar(50) NOT NULL,
	Nombres varchar(50) NOT NULL,
	FechaNacimiento datetime NOT NULL,
	Sexo char(1) NOT NULL,
	Discapacidad char(2) NOT NULL,
	CantidadDependientesDiscapacidad int NOT NULL,
	CodigoEstado char(1) NOT NULL,
	FechaHoraRegistro datetime DEFAULT getdate(),
	CodigoUsuario char(3) NOT NULL,
	FOREIGN KEY(CodigoLugarEmision) REFERENCES LugaresEmision(CodigoLugarEmision),
	FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
	FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario),
);
GO

CREATE TABLE PersonasDatos(
  IdPersona char(15) PRIMARY KEY,
  CodigoLugar INT NOT NULL,
  CodigoEstadoCivil char(1) NOT NULL,
  ApellidoEsposo varchar(50),
  Direccion varchar(100),
  Telefono varchar(25) ,
  Celular varchar(35),
  FOREIGN KEY(CodigoLugar) REFERENCES Lugares(CodigoLugar),
  FOREIGN KEY(CodigoEstadoCivil) REFERENCES EstadosCiviles(CodigoEstadoCivil),
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