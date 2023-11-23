CREATE TABLE PerfilesProfesionales(
  CodigoPerfilProfesional int PRIMARY KEY,
  DescripcionPerfilProfesional varchar(500) NOT NULL,
  CodigoEstado char(1) NOT NULL,
	FechaHoraRegistro datetime DEFAULT getdate(),
	CodigoUsuario char(3) NOT NULL,
	FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE PublicacionesDoc(
  CodigoPublicacion int PRIMARY KEY,
  Gestion int NOT NULL,
  CorrelativoGestion int NOT NULL,
  FechaPublicacion date NOT NULL,
  FechaHoraAperturaRecepcion datetime NOT NULL,
  FechaHoraCierreRecepcion datetime NOT NULL,
  Observaciones varchar(200),
  CodigoEstado char(1) NOT NULL,
	FechaHoraRegistro datetime DEFAULT getdate(),
	CodigoUsuario char(3) NOT NULL,
	FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE ConvocatoriasDoc(
  CodigoConvocatoria int PRIMARY KEY,
  GestionAcademica char(6) NOT NULL,
  NroCiteDireccion varchar(200),
  NroCiteDecanato varchar(200),
  NroCiteResultados varchar(200),
  Observaciones varchar(200),
  CodigoPublicacion int,
  CodigoEstado char(1) NOT NULL,
	FechaHoraRegistro datetime DEFAULT getdate(),
	CodigoUsuario char(3) NOT NULL,
	FOREIGN KEY(CodigoPublicacion) REFERENCES Publicaciones(CodigoPublicacion),
	FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE AgrupacionesMateriasDoc(
  CodigoConvocatoria int NOT NULL,
  CodigoSedeAcad Char(2) NOT NULL,
  CodigoCarrera int NOT NULL,
  NumeroPlanEstudios int NOT NULL,
  SiglaMateria char(6) NOT NULL,
  Agrupacion int NOT NULL,(0)
  Evalua int NOT NULL,(1)
  CodigoPerfilProfesional int NOT NULL,
  CodigoEstado char(1) NOT NULL,
	FechaHoraRegistro datetime DEFAULT getdate(),
	CodigoUsuario char(3) NOT NULL,
	PRIMARY KEY(CodigoConvocatoria, CodigoSedeAcad, CodigoCarrera, NumeroPlanEstudios, SiglaMateria),
	FOREIGN KEY(CodigoConvocatoria) REFERENCES Convocatorias(CodigoConvocatoria),
	FOREIGN KEY(CodigoSede) REFERENCES Convocatorias(CodigoConvocatoria),
	FOREIGN KEY(CodigoPerfilProfesional) REFERENCES PerfilesProfesionales(CodigoPerfilProfesional),
	FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE DetalleMateriasDoc(
  CodigoConvocatoria int NOT NULL,
  CodigoSede int NOT NULL,
  CodigoCarrera int NOT NULL,
  NumeroPlanEstudios int NOT NULL,
  SiglaMateria char(6) NOT NULL,
  Grupo int NOT NULL,
  TipoGrupo int NOT NULL,
  HorasSemana int NOT NULL,
  GrupoDetalle int NOT NULL,(0)
  IdPersona char(15),
  CodigoEstado char(1) NOT NULL,
	FechaHoraRegistro datetime DEFAULT getdate(),
	CodigoUsuario char(3) NOT NULL,
	PRIMARY KEY(CodigoConvocatoria, CodigoSede, CodigoCarrera, NumeroPlanEstudios, SiglaMateria, Grupo, TipoGrupo),
	FOREIGN KEY(CodigoConvocatoria, CodigoSede, CodigoCarrera, NumeroPlanEstudios, SiglaMateria) REFERENCES AgrupacionesMateriasDoc(CodigoConvocatoria, CodigoSede, CodigoCarrera, NumeroPlanEstudios, SiglaMateria),
	FOREIGN KEY(IdPersona) REFERENCES Personas(IdPersona),
	FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE TiposActividades(
  CodigoTipoActividad int PRIMARY KEY,
  NombreTipoActividad varchar(25) UNIQUE NOT NULL,
  CodigoEstado char(1) NOT NULL,
	FechaHoraRegistro datetime DEFAULT getdate(),
	CodigoUsuario char(3) NOT NULL,
	FOREIGN KEY(CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY(CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE Procesos(
  CodigoProceso int PRIMARY KEY,
  NombreProceso varchar(25) NOT NULL,
  Observaciones varchar(200),
  CodigoEstado char(1) NOT NULL,
	FechaHoraRegistro datetime DEFAULT getdate(),
	CodigoUsuario char(3) NOT NULL,
	FOREIGN KEY (CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE Actividades(
  CodigoActividad int PRIMARY KEY,
  NombreActividad varchar(50) NOT NULL,
  CantActividadesAnt int NOT NULL,
  CantActividadesSig int NOT NULL,
  CodigoProceso int NOT NULL,
  CodigoRol char(3) NOT NULL,
  CodigoEstado char(1) NOT NULL,
	FechaHoraRegistro datetime DEFAULT getdate(),
	CodigoUsuario char(3) NOT NULL,
	FOREIGN KEY (CodigoProceso) REFERENCES Procesos(CodigoProceso),
	FOREIGN KEY (CodigoRol) REFERENCES Roles(CodigoRol),
	FOREIGN KEY (CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE ActividadesAdyacentes(
  CodigoActividadPrincipal int NOT NULL,
  CodigoActividadAdyacente int NOT NULL,
  TipoAdyacente varchar(50) NOT NULL,
  CodigoEstado char(1) NOT NULL,
	FechaHoraRegistro datetime DEFAULT getdate(),
	CodigoUsuario char(3) NOT NULL,
	FOREIGN KEY (CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE Tramites(
  CodigoTramite int PRIMARY KEY,
  CodigoConvocatoria int,
  IdPersona char(15),
  CodigoEstado char(1) NOT NULL,
	FechaHoraRegistro datetime DEFAULT getdate(),
	CodigoUsuario char(3) NOT NULL,
	FOREIGN KEY (CodigoConvocatoria) REFERENCES Convocatorias(CodigoConvocatoria),
	FOREIGN KEY (IdPersona) REFERENCES Personas(IdPersona),
	FOREIGN KEY (CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO

CREATE TABLE TramitesActividades(
  CodigoTramite int NOT NULL,
  CodigoActividad int NOT NULL,
  FechaHoraRecepcion datetime,
  FechaHoraDespacho datetime,
  Proveido varchar(500),
  CodigoEstado char(1) NOT NULL,
	FechaHoraRegistro datetime DEFAULT getdate(),
	CodigoUsuario char(3) NOT NULL,
  PRIMARY KEY(CodigoTramite, CodigoActividad, FechaHoraRecepcion),
  FOREIGN KEY (CodigoTramite) REFERENCES Tramites(CodigoTramite),
  FOREIGN KEY (CodigoActividad) REFERENCES Actividades(CodigoActividad),
  FOREIGN KEY (CodigoEstado) REFERENCES Estados(CodigoEstado),
  FOREIGN KEY (CodigoUsuario) REFERENCES Usuarios(CodigoUsuario)
);
GO