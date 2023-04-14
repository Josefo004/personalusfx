/*IF EXISTS (SELECT name FROM sys.databases WHERE name = N'RecursosHumanos')
    DROP DATABASE [RecursosHumanos]
GO
USE master;
CREATE DATABASE RecursosHumanos;
GO*/
USE RecursosHumanos;

CREATE TABLE TiposDeclaracionesJuradas(
  CodigoTipoDeclaracionJurada char(6) PRIMARY KEY,
  NombreTipoDeclaracionJurada varchar(150) UNIQUE NOT NULL,
  Frecuencia varchar(15) NOT NULL,
  CodigoEstado char(1) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  FOREIGN KEY (CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE TiposDeclaracionesJuradasTrabajadores(
  CodigoTipoDeclaracionJurada char(6) NOT NULL,
  CodigoTrabajador char(10) NOT NULL,
  FechaInicioRecordatorio date NOT NULL,
  FechaFinRecordatorio date NOT NULL,
  CodigoEstado char(1) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  PRIMARY KEY (CodigoTipoDeclaracionJurada, CodigoTrabajador),
  FOREIGN KEY (CodigoTipoDeclaracionJurada) REFERENCES TiposDeclaracionesJuradas(CodigoTipoDeclaracionJurada),
  FOREIGN KEY (CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),
  FOREIGN KEY (CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE DeclaracionesJuradas(
  CodigoDeclaracionJurada varchar(30) PRIMARY KEY,
  Gestion int NOT NULL,
  Mes int NOT NULL,
  FechaNotificacion date NOT NULL,
  FechaRecepcion date NOT NULL,
  Observacion varchar(100),
  CodigoTrabajador char(10) NOT NULL,
  CodigoTipoDeclaracionJurada char(6) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  FOREIGN KEY (CodigoTipoDeclaracionJurada, CodigoTrabajador) REFERENCES TiposDeclaracionesJuradasTrabajadores(CodigoTipoDeclaracionJurada, CodigoTrabajador),
  FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO