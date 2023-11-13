<?php

namespace app\modules\Filiacion\models;

use yii\db\mssql\PDO;
use Yii;

class TrabajadoresDao
{
    /*=============================================
    BUSCA TRABAJADOR
    =============================================*/
    static public function buscaTrabajador($tipo, $idFuncionario, $idPersona, $fechaActualizacion)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT tra.IdFuncionario, per.IdPersona, per.ApellidoPaterno, per.ApellidoMaterno, per.PrimerNombre, per.SegundoNombres, per.TercerNombre, 
                            isnull(per.ApellidoPaterno,'')+' '+isnull(per.ApellidoMaterno,'')+' '+isnull(per.PrimerNOmbre,'')+' ' +isnull(per.SegundoNombres,'')+' '+isnull(per.TercerNombre,'') AS NombreCompleto, 
                            per.FechaNacimiento, tra.CodigoSectorTrabajo, dpf.FechaActualizacion,
                            tra.FechaIngreso, tra.FechaSalida, tra.FechaCalculoAntiguedad, tra.FechaCalculoVacaciones, tra.FechaFiniquito, dpf.FechaActualizacion,
                            dpf.ResolucionAFP,dpf.FechaRegistroAFP,dpf.PrimerMesRegistroAFP,dpf.UltimoMesRegistroAFP, dpf.ExclusionVoluntariaAFP, dpf.CodigoBanco, eb.NombreBanco,
                            dpf.CodigoAFP, afp.NombreAfp, dpf.NUA, dpf.CodigoSeguroSocial, ss.NombreSeguroSocial,
							dpf.CodigoTipoRenta, tr.NombreTipoRenta, tra.CodigoEstadoFuncionario, tra.FechaHoraRegistro, tra.CodigoUsuario                             
                     FROM Funcionarios tra
                     INNER JOIN Personas per ON tra.IdPersona = per.IdPersona
                     LEFT JOIN DatosPersonasFuncionarios dpf on tra.IdPersona = dpf.IdPersona
                     INNER JOIN Afps afp ON dpf.CodigoAfp = afp.CodigoAfp
					 INNER JOIN EntidadesBancarias eb ON dpf.CodigoBanco = eb.CodigoBanco
					 LEFT JOIN SegurosSociales ss ON dpf.CodigoSeguroSocial = ss.CodigoSeguroSocial
					 LEFT JOIN TiposRenta tr ON dpf.CodigoTipoRenta = tr.CodigoTipoRenta
                     WHERE tra.IdFuncionario = :idFuncionario AND dpf.IdPersona = :idPersona AND dpf.FechaActualizacion = :fechaActualizacion ";
        if ($tipo == "array") {
            $persona = $dbRRHH->createCommand($consulta)
                ->bindParam(":idFuncionario", $idFuncionario, PDO::PARAM_STR)
                ->bindParam(":idPersona", $idPersona, PDO::PARAM_STR)
                ->bindParam(":fechaActualizacion", $fechaActualizacion, PDO::PARAM_STR)
                /*->bindParam(":" . $campo1, $valor1, PDO::PARAM_STR)
                ->bindParam(":" . $campo2, $valor2, PDO::PARAM_STR)
                ->bindParam(":" . $campo3, $valor3, PDO::PARAM_STR)*/
                ->queryOne();
            return $persona;
        } else {
            $instruccion = $dbRRHH->createCommand($consulta)
                ->bindParam(":idFuncionario", $idFuncionario, PDO::PARAM_STR)
                ->bindParam(":idPersona", $idPersona, PDO::PARAM_STR)
                ->bindParam(":fechaActualizacion", $fechaActualizacion, PDO::PARAM_STR)
                /*->bindParam(":" . $campo1, $valor1, PDO::PARAM_STR)
                ->bindParam(":" . $campo2, $valor2, PDO::PARAM_STR)
                ->bindParam(":" . $campo3, $valor3, PDO::PARAM_STR)*/;
            $lector = $instruccion->query();
            $trabajador = $lector->readObject(TrabajadorObj::className(), []);
            return $trabajador;
        }
    }

    /*==================================================
    LISTA TODOS LOS TRABAJADORES VIGENTES Y EN FUNCIONES
    ==================================================*/
    static public function listaTrabajadores()
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT fu.IdFuncionario, per.IdPersona, per.PrimerNombre, per.SegundoNombres, per.TercerNombre, per.ApellidoPaterno, per.ApellidoMaterno, isnull(per.ApellidoPaterno,'')+' '+isnull(per.ApellidoMaterno,'')+' '+per.PrimerNombre +' '+per.SegundoNombres+' '+per.TercerNombre AS NombreCompleto,
						    per.FechaNacimiento,
                            fu.FechaIngreso, fu.FechaSalida, fu.FechaCalculoAntiguedad, fu.FechaCalculoVacaciones, fu.FechaFiniquito, dpf.FechaActualizacion,
							dpf.ResolucionAFP,dpf.FechaRegistroAFP,dpf.PrimerMesRegistroAFP,dpf.UltimoMesRegistroAFP, dpf.ExclusionVoluntariaAFP, dpf.CodigoBanco, eb.NombreBanco,
                            dpf.CodigoAfp, afp.NombreAfp, dpf.NUA, dpf.CodigoSeguroSocial, ss.NombreSeguroSocial, fu.CodigoEstadoFuncionario, fu.FechaHoraRegistro, fu.CodigoUsuario
                     FROM Funcionarios fu
                     INNER JOIN Personas per ON fu.IdPersona = per.IdPersona
					 INNER JOIN DatosPersonasFuncionarios dpf on fu.IdPersona = dpf.IdPersona
                     INNER JOIN Afps afp ON dpf.CodigoAfp = afp.CodigoAfp
					 INNER JOIN EntidadesBancarias eb ON dpf.CodigoBanco = eb.CodigoBanco
					 LEFT JOIN SegurosSociales ss ON dpf.CodigoSeguroSocial = ss.CodigoSeguroSocial
                     --INNER JOIN NivelesAcademicos niv ON tra.CodigoNivelAcademico = niv.CodigoNivelAcademico
                     --LEFT JOIN SegurosSalud seg ON tra.CodigoSeguroSalud = seg.CodigoSeguroSalud
					 --where tra.CodigoTrabajador not in (select a.CodigoTrabajador from AsignacionesAdministrativos a)
                     ORDER BY per.ApellidoPaterno, per.ApellidoMaterno,per.PrimerNombre, per.SegundoNombres, per.TercerNombre ";
        /*$consulta = "SELECT fu.IdFuncionario, per.IdPersona, per.PrimerNombre, per.SegundoNombres, per.TercerNombre, per.ApellidoPaterno, per.ApellidoMaterno, isnull(per.ApellidoPaterno,'')+' '+isnull(per.ApellidoMaterno,'')+' '+per.PrimerNombre +' '+per.SegundoNombres+' '+per.TercerNombre AS NombreCompleto,
						    per.FechaNacimiento, 
                            fu.FechaIngreso, fu.FechaSalida, fu.FechaCalculoAntiguedad, fu.FechaCalculoVacaciones, fu.FechaFiniquito,
                            afp.CodigoAfp, afp.NombreAfp, dpf.NUA, dpf.CodigoSeguroSocial ,fu.CodigoEstadoFuncionario, fu.FechaHoraRegistro, fu.CodigoUsuario
                     FROM Funcionarios fu
                     INNER JOIN Personas per ON fu.IdPersona = per.IdPersona
					 INNER JOIN DatosPersonaFuncionario dpf on fu.IdPersona = dpf.IdPersona
                     INNER JOIN Afps afp ON dpf.CodigoAfp = afp.CodigoAfp
                     --INNER JOIN NivelesAcademicos niv ON tra.CodigoNivelAcademico = niv.CodigoNivelAcademico
                     --LEFT JOIN SegurosSalud seg ON tra.CodigoSeguroSalud = seg.CodigoSeguroSalud
					 --where tra.CodigoTrabajador not in (select a.CodigoTrabajador from AsignacionesAdministrativos a)                     
                     ORDER BY per.ApellidoPaterno, per.ApellidoMaterno,per.PrimerNombre, per.SegundoNombres, per.TercerNombre";*/
        /*$consulta = "SELECT fu.IdFuncionario, per.IdPersona, per.PrimerNombre, per.SegundoNombres, per.TercerNombre, per.ApellidoPaterno, per.ApellidoMaterno, isnull(per.ApellidoPaterno,'')+' '+isnull(per.ApellidoMaterno,'')+' '+per.PrimerNombre +' '+per.SegundoNombres+' '+per.TercerNombre AS NombreCompleto,
						    per.FechaNacimiento,fu.CodigoEstadoFuncionario
                     FROM Funcionarios fu
                     INNER JOIN Personas per ON fu.IdPersona = per.IdPersona
					 /*INNER JOIN DatosPersonaFuncionario dpf on fu.IdPersona = dpf.IdPersona
                     INNER JOIN Afps afp ON dpf.CodigoAfp = afp.CodigoAfp
                     --INNER JOIN NivelesAcademicos niv ON tra.CodigoNivelAcademico = niv.CodigoNivelAcademico
                     --LEFT JOIN SegurosSalud seg ON tra.CodigoSeguroSalud = seg.CodigoSeguroSalud
					 --where tra.CodigoTrabajador not in (select a.CodigoTrabajador from AsignacionesAdministrativos a)                     
                     ORDER BY per.ApellidoPaterno, per.ApellidoMaterno,per.PrimerNombre, per.SegundoNombres, per.TercerNombre";*/
        $instruccion = $dbRRHH->createCommand($consulta);
        $lector = $instruccion->query();
        $trabajadores = [];
        while ($trabajador = $lector->readObject(TrabajadorObj::className(), [])) {
            $trabajadores[] = $trabajador;
        }
        return $trabajadores;
    }

    /*==================================================
    LISTA TODAS LAS PERSONAS
    ==================================================*/
    static public function listaPersonas()
    {
        $dbRRHH = Yii::$app->db;
        /*$consulta = "SELECT per.IdPersona, per.CodigoLugarEmision, per.Nombres, per.Paterno, per.Materno, isnull(per.Paterno,'')+' '+isnull(per.Materno,'')+' '+per.Nombres AS NombreCompleto,
                            per.FechaNacimiento, per.Sexo, case per.Sexo when 'M' then 'MASCULINO' else 'FEMENINO' end AS SexoLiteral, per.Discapacidad, case per.Discapacidad when 'S' then 'SI' else 'NO' end AS DiscapacidadLiteral, 
                            rtrim(lug.CodigoLugar) AS CodigoLugarNacimiento, rtrim(lug.NombreLugar) AS NombreLugar,  rtrim(pro.CodigoProvincia) AS CodigoProvincia, rtrim(pro.NombreProvincia) AS NombreProvincia,
                            rtrim(dep.CodigoDepartamento) AS CodigoDepartamento, rtrim(dep.NombreDepartamento) AS NombreDepartamento,  rtrim(pai.CodigoPais) AS CodigoPais, rtrim(pai.NombrePais) AS NombrePais,
                            tra.CodigoTrabajador, 
							per.CodigoEstado, per.FechaHoraRegistro, per.CodigoUsuario                             
                     FROM Personas per
					 INNER JOIN PersonasDatos perdat ON perdat.IdPersona = per.IdPersona
                     INNER JOIN Lugares lug ON perdat.CodigoLugar = lug.CodigoLugar
                     INNER JOIN Provincias pro ON lug.CodigoProvincia = pro.CodigoProvincia
                     INNER JOIN Departamentos dep ON pro.CodigoDepartamento = dep.CodigoDepartamento --AND lug.CodigoDepartamento = dep.CodigoDepartamento
                     INNER JOIN Paises pai ON dep.CodigoPais = pai.CodigoPais --AND lug.CodigoPais = pai.CodigoPais
                     LEFT JOIN Trabajadores tra ON per.IdPersona = tra.IdPersona
					 WHERE per.IdPersona NOT IN (SELECT IdPersona FROM Trabajadores) 
                     ORDER BY Paterno, Materno, Nombres ";*/
        $consulta = "SELECT per.IdPersona, per.PrimerNombre, per.SegundoNombres, per.TercerNombre, per.ApellidoPaterno, per.ApellidoMaterno, isnull(per.ApellidoPaterno,'')+' '+isnull(per.ApellidoMaterno,'')+' '+per.PrimerNombre +' '+per.SegundoNombres+' '+per.TercerNombre AS NombreCompleto,
                            per.FechaNacimiento, per.Sexo, case per.Sexo when 'M' then 'MASCULINO' else 'FEMENINO' end AS SexoLiteral,
							per.CodigoEstado, per.FechaHoraRegistro, per.CodigoUsuario                             
                     FROM Personas per
					 WHERE per.IdPersona NOT IN (SELECT IdPersona FROM Funcionarios) 
                     ORDER BY per.ApellidoPaterno, per.ApellidoMaterno, per.PrimerNombre, per.SegundoNombres, per.TercerNombre";
        $instruccion = $dbRRHH->createCommand($consulta);
        $lector = $instruccion->query();
        $trabajadores = [];
        while ($trabajador = $lector->readObject(TrabajadorObj::className(), [])) {
            $trabajadores[] = $trabajador;
        }
        return $trabajadores;
    }

    /*==================================================
    LISTA TODOS LOS TRABAJADORES VIGENTES Y EN FUNCIONES
    ==================================================*/
    static public function listaTrabajadoresVigentes()
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT tra.CodigoTrabajador, per.IdPersona, per.Paterno, per.Materno, per.Nombres, isnull(per.Paterno,'')+' '+isnull(per.Materno,'')+' '+per.Nombres AS NombreCompleto, per.FechaNacimiento, 
                            tra.FechaIngreso, tra.FechaSalida, tra.ResolucionDocente, tra.FechaResolucionDocente, tra.FechaCalculoDocente, tra.ResolucionAdministrativo, tra.FechaResolucionAdministrativo, tra.FechaCalculoAdministrativo,
                            afp.CodigoAfp, afp.NombreAfp, tra.Cua, seg.CodigoSeguroSalud,seg.NombreSeguroSalud, niv.CodigoNivelAcademico, niv.NombreNivelAcademico, tra.CodigoEstado, tra.FechaHoraRegistro, tra.CodigoUsuario, null AS CodigoTipoDeclaracionJurada, null AS NombreTipoDeclaracionJurada                             
                     FROM Trabajadores tra
                     INNER JOIN Personas per ON tra.IdPersona = per.IdPersona
                     INNER JOIN Afps afp ON tra.CodigoAfp = afp.CodigoAfp
                     INNER JOIN NivelesAcademicos niv ON tra.CodigoNivelAcademico = niv.CodigoNivelAcademico                     
                     INNER JOIN Asignaciones asi ON tra.CodigoTrabajador = asi.CodigoTrabajador
                     LEFT JOIN SegurosSalud seg ON tra.CodigoSeguroSalud = seg.CodigoSeguroSalud   
                     WHERE asi.FechaFin = null OR asi.FechaFin >= getdate()
                     ORDER BY Paterno, Materno, Nombres ";
        $instruccion = $dbRRHH->createCommand($consulta);
        $lector = $instruccion->query();
        $trabajadores = [];
        while ($trabajador = $lector->readObject(TrabajadorObj::className(), [])) {
            $trabajadores[] = $trabajador;
        }
        return $trabajadores;
    }

    /*=================================================
    LISTA TRABAJADORES DE UN TIPO DE DECLARACION JURADA
    ==================================================*/
    static public function listaTrabajadoresTipoDeclaracionJurada($codigoTipoDeclaracionJurada)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT tra.CodigoTrabajador, per.IdPersona, per.Paterno, per.Materno, per.Nombres, isnull(per.Paterno,'')+' '+isnull(per.Materno,'')+' '+per.Nombres AS NombreCompleto, per.FechaNacimiento, 
                            tra.FechaIngreso, tra.FechaSalida, tra.ResolucionDocente, tra.FechaResolucionDocente, tra.FechaCalculoDocente, tra.ResolucionAdministrativo, tra.FechaResolucionAdministrativo, tra.FechaCalculoAdministrativo, 
                            afp.CodigoAfp, afp.NombreAfp, tra.Cua, seg.CodigoSeguroSalud,seg.NombreSeguroSalud, niv.CodigoNivelAcademico, niv.NombreNivelAcademico, tiptra.CodigoEstado, tra.FechaHoraRegistro, tra.CodigoUsuario, tiptra.CodigoTipoDeclaracionJurada                             
                     FROM Trabajadores tra
                     INNER JOIN Personas per ON tra.IdPersona = per.IdPersona
                     INNER JOIN Afps afp ON tra.CodigoAfp = afp.CodigoAfp
                     INNER JOIN NivelesAcademicos niv ON tra.CodigoNivelAcademico = niv.CodigoNivelAcademico
                     LEFT JOIN SegurosSalud seg ON tra.CodigoSeguroSalud = seg.CodigoSeguroSalud   
                     INNER JOIN TiposDeclaracionesJuradasTrabajadores tiptra ON tra.CodigoTrabajador = tiptra.CodigoTrabajador
                     INNER JOIN TiposDeclaracionesJuradas tipdec ON tiptra.CodigoTipoDeclaracionJurada = tipdec.CodigoTipoDeclaracionJurada
                     WHERE tiptra.CodigoTipoDeclaracionJurada = :codigoTipoDeclaracionJurada
                     ORDER BY Paterno, Materno, Nombres ";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":codigoTipoDeclaracionJurada", $codigoTipoDeclaracionJurada, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $trabajadores = [];
        while ($trabajador = $lector->readObject(TrabajadorObj::className(), [])) {
            $trabajadores[] = $trabajador;
        }
        return $trabajadores;
    }

    /*=============================================
    OBTIENE CODIGO DEL TRABAJADOR
    =============================================
    static public function obtieneCodigoTrabajador($idPersona, $tipo)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "";
        if ($tipo == "dia") {
            $consulta = "SELECT substring(isnull(paterno, ''),1,1)+substring(isnull(materno, ''),1,1)+substring(isnull(nombres, ''),1,1)+
                         rtrim(cast(year(FechaNacimiento) as varchar))+case when day(FechaNacimiento)<10 then '0'+rtrim(cast(day(FechaNacimiento) as varchar)) else rtrim(cast(day(FechaNacimiento) as varchar)) end AS CodigoTrabajador
                         FROM Personas per
                         WHERE IdPersona = :idPersona";
        } else {
            $consulta = "SELECT substring(isnull(paterno, ''),1,1)+substring(isnull(materno, ''),1,1)+substring(isnull(nombres, ''),1,1)+
                         rtrim(cast(year(FechaNacimiento) as varchar))+case when month(FechaNacimiento)<10 then '0'+rtrim(cast(month(FechaNacimiento) as varchar)) else rtrim(cast(month(FechaNacimiento) as varchar)) end AS CodigoTrabajador
                         FROM Personas per
                         WHERE IdPersona = :idPersona";
        }
        $arrayCodigoTrabajador = $dbRRHH->createCommand($consulta)
            ->bindParam(":idPersona", $idPersona, PDO::PARAM_STR)
            ->queryOne();
        return $arrayCodigoTrabajador["CodigoTrabajador"];
    }*/

    /*=============================================
    GENERA NUEVO CODIGO FUNCIONARIO
    =============================================*/
    static public function generarIdFuncionario()
    {
        $dbSiacPersonal = Yii::$app->db;
        $consulta = "SELECT max(IdFuncionario) AS UltimoIdFuncionario
                     FROM Funcionarios";
        $instruccion = $dbSiacPersonal->createCommand($consulta);
        $arrayMaximo = $instruccion->queryOne();
        if (!$arrayMaximo) {
            return 1;
        } else {
            return $arrayMaximo['UltimoIdFuncionario'] + 1;
        }
    }
}