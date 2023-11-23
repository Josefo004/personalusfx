IF EXISTS (SELECT name FROM sys.databases WHERE name = N'SiacPersonal')
    DROP DATABASE [SiacPersonal]
GO
USE master;
CREATE DATABASE SiacPersonal;
GO
USE SiacPlanificacion;
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

CREATE TABLE Roles(
 CodigoRol char(3) PRIMARY KEY,
 NombreRol char(50) UNIQUE NOT NULL,
 NumeroRol int NOT NULL
);
GO

INSERT INTO Roles VALUES('ADS', 'ADMINISTRADOR  DEL SISTEMA', 0);
INSERT INTO Roles VALUES('EPA', 'ENCARGADO PERSONAL ADMINISTRATIVO', 1);
INSERT INTO Roles VALUES('EPD', 'ENCARGADO PERSONAL DOCENTE', 2);
INSERT INTO Roles VALUES('JDA', 'JEFE PERSONAL DOCENTE - ADMINISTRATIVO', 3);
INSERT INTO Roles VALUES('JRH', 'JEFE RECURSOS HUMANOS', 4);
INSERT INTO Roles VALUES('TPA', 'TRABAJADOR PERSONAL ADMINISTRATIVO', 5);
INSERT INTO Roles VALUES('TPD', 'TRABAJADOR PERSONAL DOCENTE', 6);
INSERT INTO Roles VALUES('TDA', 'TRABAJADOR PERSONAL DOCENTE - ADMINISTRATIVO', 7);

CREATE TABLE Usuarios(
 CodigoUsuario char(3) PRIMARY KEY,
 CodigoTrabajador char(10),
 IdPersona char(15),
 Login varchar(20) UNIQUE NOT NULL,
 Llave char(32) UNIQUE NOT NULL,
 Email varchar(100) UNIQUE NOT NULL,
 Pwd varchar(100) NOT NULL,
 Foto varchar(100) NOT NULL,
 CodigoRol char(3) NOT NULL,
 CodigoEstado char(1) NOT NULL,
 FechaHoraRegistro datetime DEFAULT getdate(),
 FOREIGN KEY (IdPersona) REFERENCES Personas(IdPersona),
 FOREIGN KEY (CodigoRol) REFERENCES Roles(CodigoRol),
 FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
);
GO

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

CREATE TABLE Afps(
  CodigoAfp char(1) PRIMARY KEY,
  NombreAfp varchar(50) UNIQUE NOT NULL
);
GO
INSERT INTO Afps VALUES('F','FUTURO DE BOLIVIA S.A.');
INSERT INTO Afps VALUES('P','PREVISION BBVA');

CREATE TABLE SegurosSalud(
  CodigoSeguroSalud char(3) PRIMARY KEY,
  NombreSeguroSalud varchar(100) UNIQUE NOT NULL
);
GO
INSERT INTO SegurosSalud VALUES('SSU','SEGURO SOCIAL UNIVERSITARIO');
INSERT INTO SegurosSalud VALUES('CNS','CAJA NACIONAL DE SALUD');
INSERT INTO SegurosSalud VALUES('CPS','CAJA PETROLERA DE SALUD');