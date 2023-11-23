USE RecursosHumanosPrueba;

DROP TABLE dbo.AportesLey;

CREATE TABLE dbo.AportesLey(
	codigoAporteLey INT PRIMARY KEY IDENTITY (1, 1),
	nombreAporteLey VARCHAR(150) NOT NULL, 
	tipoAporte VARCHAR(15) NOT NULL, 
	porcentaje FLOAT NOT NULL,
	montoSalario FLOAT DEFAULT 0 NOT NULL,
	observaciones VARCHAR(150) NULL,
	codigoEstado CHAR(1) DEFAULT 'V' NOT NULL,
	fechaInicio DATE DEFAULT (getdate()) NOT NULL,
	fechaFin DATE NULL,
	fechaRegistro DATETIME DEFAULT (getdate()) NOT NULL,
	codigoUsuario CHAR(3) NOT NULL,
	CONSTRAINT FK_codigoEstado FOREIGN KEY (codigoEstado) REFERENCES dbo.Estados(CodigoEstado),
	CONSTRAINT FK_codigoUsuario FOREIGN KEY (codigoUsuario) REFERENCES dbo.Usuarios(CodigoUsuario)
);

INSERT INTO AportesLey (nombreAporteLey, tipoAporte, porcentaje, montoSalario, observaciones, fechaInicio, fechaRegistro, codigoUsuario) VALUES('APORTE DE VEJEZ - COTIZACION MENSUAL', 'LABORAL', 10, 0, '', GETDATE(), GETDATE(), 'LNN'); 
INSERT INTO AportesLey (nombreAporteLey, tipoAporte, porcentaje, montoSalario, observaciones, fechaInicio, fechaRegistro, codigoUsuario) VALUES('PRIMA RIESGO COMUN', 'LABORAL', 1.71, 0, '', GETDATE(), GETDATE(), 'LNN'); 
INSERT INTO AportesLey (nombreAporteLey, tipoAporte, porcentaje, montoSalario, observaciones, fechaInicio, fechaRegistro, codigoUsuario) VALUES('AP. COMISION  ADM. AFP', 'LABORAL', 0.5, 0, '', GETDATE(), GETDATE(), 'LNN'); 
INSERT INTO AportesLey (nombreAporteLey, tipoAporte, porcentaje, montoSalario, observaciones, fechaInicio, fechaRegistro, codigoUsuario) VALUES('AP. SOLIDARIO (ASEGURADO) ', 'LABORAL', 0.5, 0, '', GETDATE(), GETDATE(), 'LNN'); 
INSERT INTO AportesLey (nombreAporteLey, tipoAporte, porcentaje, montoSalario, observaciones, fechaInicio, fechaRegistro, codigoUsuario) VALUES('APORTE NACIONAL SOLIDARIO', 'LABORAL', 1, 13000, 'Se aplica para sueldos mayores a 13.000 Bs.', GETDATE(), GETDATE(), 'LNN'); 
INSERT INTO AportesLey (nombreAporteLey, tipoAporte, porcentaje, montoSalario, observaciones, fechaInicio, fechaRegistro, codigoUsuario) VALUES('APORTE FONDO DE VIVIENDA ', 'PATRONAL', 2, 0, '', GETDATE(), GETDATE(), 'LNN'); 
INSERT INTO AportesLey (nombreAporteLey, tipoAporte, porcentaje, montoSalario, observaciones, fechaInicio, fechaRegistro, codigoUsuario) VALUES('SEGURO RIESGO PROFESIONAL ', 'PATRONAL', 1.71, 0, '', GETDATE(), GETDATE(), 'LNN'); 
INSERT INTO AportesLey (nombreAporteLey, tipoAporte, porcentaje, montoSalario, observaciones, fechaInicio, fechaRegistro, codigoUsuario) VALUES('APORTE PATRONAL FONDO SOLIDARIO', 'PATRONAL', 3, 0, '', GETDATE(), GETDATE(), 'LNN'); 
INSERT INTO AportesLey (nombreAporteLey, tipoAporte, porcentaje, montoSalario, observaciones, fechaInicio, fechaRegistro, codigoUsuario) VALUES('APORTE AL SSO A CORTO PLAZO', 'PATRONAL', 10, 0, '', GETDATE(), GETDATE(), 'LNN'); 


select * from AportesLey;
select * from Estados;

SELECT apl.codigoAporteLey, apl.nombreAporteLey, UPPER(apl.tipoAporte) as tipoAporte, FORMAT(apl.porcentaje, 'N', 'en-us') porcentaje, apl.montoSalario, 
apl.observaciones, apl.codigoEstado, est.NombreEstado, apl.fechaInicio, apl.fechaFin, apl.fechaRegistro, apl.codigoUsuario 
FROM AportesLey apl   
JOIN Estados est ON apl.codigoEstado = est.CodigoEstado