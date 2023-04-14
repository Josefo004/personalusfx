/*IF EXISTS (SELECT name FROM sys.databases WHERE name = N'RecursosHumanos')
    DROP DATABASE [RecursosHumanos]
GO
USE master;
CREATE DATABASE RecursosHumanos;
GO*/
USE RecursosHumanos;

CREATE TABLE NivelesSalariales(
  CodigoNivelSalarial int PRIMARY KEY,
  NombreNivelSalarial varchar(10) UNIQUE NOT NULL,
  DescripcionNivelSalarial VARCHAR(50) NOT NULL,
  HaberBasico float NOT NULL,
  PuntosEscalafon float,
  CodigoSectorTrabajo char(3) NOT NULL,
  CodigoEstado char(1) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  FOREIGN KEY(CodigoSectorTrabajo) REFERENCES SectoresTrabajo(CodigoSectorTrabajo),
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE DocumentosIncrementosSalariales(
  NroDocumento varchar(50) PRIMARY KEY,
  FechaDocumento date NOT NULL,
  FechaAplicacion date NOT NULL,
  PorcentajeIncremento float NOT NULL,
  Detalle varchar(500),
  CodigoEstado char(1) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  FOREIGN KEY(CodigoCondicionLaboral) REFERENCES CondicionesLaborales(CodigoCondicionLaboral),
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE IncrementosSalariales(
  NroDocumento varchar(50) NOT NULL,
  CodigoNivelSalarial int NOT NULL,
  HaberBasicoAntes float NOT NULL,
  PorcentajeIncremento float NOT NULL,
  HaberBasicoDespues float NOT NULL,
  CodigoEstado char(1) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  PRIMARY KEY(NroDocumento, CodigoNivelSalarial),
  FOREIGN KEY(NroDocumento) REFERENCES DocumentosIncrementosSalariales(NroDocumento),
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE SalariosMinimos(
  CodigoSalarioMinimo int PRIMARY KEY,
  NroDocumento varchar(50) NOT NULL,
  FechaDocumento date NOT NULL,
  FechaInicioAplicacion date NOT NULL,
  FechaFinAplicacion date,
  Monto float NOT NULL,
  Observaciones varchar(150),
  CodigoEstado char(1) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE AportesLey(
  CodigoAporteLey int PRIMARY KEY,
  NombreAporteLey varchar(150) NOT NULL,
  TipoAporte varchar(15) NOT NULL,
  Porcentaje float NOT NULL,
  MontoSalario float,
  Observaciones varchar(150),
  CodigoEstado char(1) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE TiposAportantes(
  CodigoTipoAportante int PRIMARY KEY  NOT NULL,
  CodigoAportantePlanillas char(1) NOT NULL,
  CodigoAportanteAfp char(1) NOT NULL,
  NombreTipoAportante varchar(150) NOT NULL,
  Descripcion varchar(250) NOT NULL,
  CodigoEstado char(1) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE TiposAportantesAportesLey(
  CodigoTipoAportante int NOT NULL,
  CodigoAporteLey int NOT NULL,
  CodigoEstado char(1) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  PRIMARY KEY (CodigoTipoAportante, CodigoAporteLey),
  FOREIGN KEY(CodigoTipoAportante) REFERENCES TiposAportantes(CodigoTipoAportante),
  FOREIGN KEY(CodigoAporteLey) REFERENCES AportesLey(CodigoAporteLey),
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE TiposAportantesTrabajadores(
  CodigoTipoAportante int NOT NULL,
  CodigoTrabajador char(10) NOT NULL,
  FechaInicio date NOT NULL,
  FechaFin date,
  DocumentoRespaldo varchar(100),
  FechaDocumentoRespaldo date,
  Observaciones varchar(250),
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  PRIMARY KEY(CodigoTipoAportante, CodigoTrabajador),
  FOREIGN KEY(CodigoTipoAportante) REFERENCES TiposAportantes(CodigoTipoAportante),
  FOREIGN KEY(CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE UnidadesDescuentos(
  CodigoUnidad char(6) PRIMARY KEY,
  NombreUnidad varchar(200) NOT NULL,
  NombreResponsable varchar(200) NOT NULL,
  Direccion varchar(100),
  Telefono varchar(15),
  Celular varchar(15),
  Email varchar(100),
  CodigoEstado char(1) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE UnidadesDescuentosUsuarios(
  CodigoUnidad char(6) NOT NULL,
  CodigoUsuarioUnidad char(3) NOT NULL,
  CodigoEstado char(1) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  PRIMARY KEY(CodigoUnidad, CodigoUsuarioUnidad),
  FOREIGN KEY(CodigoUnidad) REFERENCES UnidadesDescuentos(CodigoUnidad),
  FOREIGN KEY(CodigoUsuarioUnidad) REFERENCES Usuarios(CodigoUsuario),
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario),
);
GO

CREATE TABLE DocumentosDescuentos(
    NroDocumento varchar(50) PRIMARY KEY,
    Detalle varchar(200) NOT NULL,
    FrecuenciaDescuento varchar(20) NOT NULL,
    TipoDescuento varchar(10) NOT NULL,
    Descuento float,
    UnidadRemitente char(6) NOT NULL,
    CodigoSectorTrabajo char(3) NOT NULL,
    CodigoEstado char(1) NOT NULL,
    FechaHoraRegistro datetime DEFAULT getdate(),
    CodigoUsuario char(3) NOT NULL,
    FOREIGN KEY (UnidadRemitente) REFERENCES UnidadesDescuentos(CodigoUnidad),
    FOREIGN KEY (CodigoSectorTrabajo) REFERENCES SectoresTrabajo(CodigoSectorTrabajo),
    FOREIGN KEY (CodigoEstado) REFERENCES Estados(CodigoEstado),
    FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE DocumentosDescuentosTrabajadores(
    NroDocumento varchar(50) NOT NULL,
    CodigoTrabajador char(10) NOT NULL,
    Observacion varchar(100),
    CodigoEstado char(1) NOT NULL,
    FechaHoraRegistro datetime DEFAULT getdate(),
    CodigoUsuario char(3) NOT NULL,
    PRIMARY KEY (NroDocumento, CodigoTrabajador),
    FOREIGN KEY (NroDocumento) REFERENCES DocumentosDescuentos(NroDocumento),
    FOREIGN KEY (CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),
    FOREIGN KEY (CodigoEstado) REFERENCES Estados(CodigoEstado),
    FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE PlanillasDescuentosMensuales(
    CodigoPlanillaDescuento int PRIMARY KEY identity(1,1),
    FechaPlanillaDescuento date,
    Gestion int NOT NULL,
    Mes int NOT NULL,
    PersonaAutoriza varchar(150) NOT NULL,
    NroDocumento varchar(50) NOT NULL,
    CodigoEstado char(1) NOT NULL,
    FechaHoraRegistro datetime DEFAULT getdate(),
    CodigoUsuario char(3) NOT NULL,
    FOREIGN KEY (NroDocumento) REFERENCES DocumentosDescuentos(NroDocumento),
    FOREIGN KEY (CodigoEstado) REFERENCES Estados(CodigoEstado),
    FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE PlanillasDescuentosMensualesDetalle(
    CodigoPlanillaDescuento int NOT NULL,
    CodigoTrabajador char(10) NOT NULL,
    DescuentoPropuesto float,
    DescuentoReal float,
    Observacion varchar(100),
    CodigoEstado char(1) NOT NULL,
    FechaHoraRegistro datetime DEFAULT getdate(),
    CodigoUsuario char(3) NOT NULL,
    PRIMARY KEY (CodigoPlanillaDescuento, CodigoTrabajador),
    FOREIGN KEY (CodigoPlanillaDescuento) REFERENCES PlanillaDescuentosMensual(CodigoPlanillaDescuento),
    FOREIGN KEY (CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),
    FOREIGN KEY (CodigoEstado) REFERENCES Estados(CodigoEstado),
    FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE PlanillasDatosMensuales(
  Gestion int NOT NULL,
  Mes int NOT NULL,
  CodigoTrabajador char(10) NOT NULL,
  CodigoCondicionLaboral char(3) NOT NULL,
  CodigoNivelSalarial  int NOT NULL,
  HaberBasico FLOAT NOT NULL,
  CodigoSalarioMinimo int NOT NULL,
  Monto float NOT NULL,
  FechaCalculo date,
  Antiguedad float ,
  BonoAntiguedad float NOT NULL,
  TotalGanado float NOT NULL,
  CodigoEstado char(1) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  PRIMARY KEY(Gestion, Mes, CodigoTrabajador),
  FOREIGN KEY(CodigoTrabajador) REFERENCES Trabajadores(CodigoTrabajador),
  FOREIGN KEY(CodigoCondicionLaboral) REFERENCES CondicionesLaborales(CodigoCondicionLaboral),
  FOREIGN KEY(CodigoNivelSalarial) REFERENCES NivelesSalariales(CodigoNivelSalarial),
  FOREIGN KEY(CodigoSalarioMinimo) REFERENCES SalariosMinimos(CodigoSalarioMinimo),
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
);
GO

CREATE TABLE PlanillasSsu(
  Gestion int NOT NULL,
  Mes int NOT NULL,
  CodigoTipoPlanilla varchar(3) NOT NULL,
  CodigoTrabajador char(10) NOT NULL,
  CodigoCondicionLaboral char(3) NOT NULL,
  NroItem int NOT NULL,
  IdApertura char(14) NOT NULL,
  CodigoUnidad char(6) NOT NULL,
  FechaInicio date,
  CodigoAporteLey int NOT NUll,
  TotalGanado float NOT NULL,
  Fss Float NOT NULL,
  CodigoEstado char(1) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  PRIMARY KEY(Gestion, Mes, CodigoTipoPlanilla, CodigoTrabajador),
  FOREIGN KEY(Gestion, Mes, CodigoTrabajador) REFERENCES PlanillaDatosMensuales(Gestion, Mes, CodigoTrabajador),
  FOREIGN KEY(CodigoUnidad, IdApertura, FechaInicio) REFERENCES AperturasProgramaticas(CodigoUnidad, IdApertura, FechaInicio),
  FOREIGN KEY(CodigoAporteLey) REFERENCES AportesLey(CodigoAporteLey),
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE PlanillasProViv(
  Gestion int NOT NULL,
  Mes int NOT NULL,
  CodigoTipoPlanilla varchar(3) NOT NULL,
  CodigoTrabajador char(10) NOT NULL,
  CodigoCondicionLaboral char(3) NOT NULL,
  NroItem int NOT NULL,
  IdApertura char(14) NOT NULL,
  CodigoUnidad char(6) NOT NULL,
  FechaInicio date,
  CodigoAporteLey int NOT NUll,
  TotalGanado float NOT NULL,
  ProViv Float NOT NULL,
  CodigoEstado char(1) NOT NULL,
  FechaHoraRegistro datetime DEFAULT getdate(),
  CodigoUsuario char(3) NOT NULL,
  PRIMARY KEY(Gestion, Mes, CodigoTipoPlanilla, CodigoTrabajador),
  FOREIGN KEY(Gestion, Mes, CodigoTrabajador) REFERENCES PlanillaDatosMensuales(Gestion, Mes, CodigoTrabajador),
  FOREIGN KEY(CodigoUnidad, IdApertura, FechaInicio) REFERENCES AperturasProgramaticas(CodigoUnidad, IdApertura, FechaInicio),
  FOREIGN KEY(CodigoAporteLey) REFERENCES AportesLey(CodigoAporteLey),
  FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO