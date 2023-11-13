<?php

namespace app\modules\Filiacion\models;

use yii\db\mssql\PDO;
use Yii;

class PersonasDao
{
    /*=============================================
    BUSCA PERSONA
    =============================================*/
    static public function buscaPersona($tipo, $idPersona)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT per.IdPersona, per.NumeroDocumento, per.NroComplemento, per.PrimerNombre, per.SegundoNombres, per.TercerNombre, per.ApellidoPaterno, per.ApellidoMaterno, isnull(per.ApellidoPaterno,'')+' '+isnull(per.ApellidoMaterno,'')+' '+per.PrimerNombre +' '+per.SegundoNombres+' '+per.TercerNombre AS NombreCompleto,
                            per.TipoDocumento, td.NombreDocumento, per.LugarExpedicion ,per.FechaNacimiento, per.Sexo, case per.Sexo when 'M' then 'MASCULINO' else 'FEMENINO' end AS SexoLiteral,
							per.CodigoEstadoCivil, ec.NombreEstadoCivil, per.Domicilio, per. LibretaServicioMilitar, per.CodigoEstado, per.FechaHoraRegistro, per.CodigoUsuario                             
                     FROM Personas per
					 INNER JOIN EstadosCiviles ec ON per.CodigoEstadoCivil = ec.CodigoEstadoCivil
					 INNER JOIN TiposDocumentos td ON per.TipoDocumento = td.TipoDocumento
					 WHERE per.IdPersona = :idPersona
					 ORDER BY per.ApellidoPaterno, per.ApellidoMaterno, per.PrimerNombre, per.SegundoNombres, per.TercerNombre";
        if ($tipo == "array") {
            $persona = $dbRRHH->createCommand($consulta)
                ->bindParam(":idPersona", $idPersona, PDO::PARAM_STR)
                ->queryOne();
            return $persona;
        } else {
            $instruccion = $dbRRHH->createCommand($consulta)
                ->bindParam(":idPersona", $valor, PDO::PARAM_STR);
            $lector = $instruccion->query();
            $persona = $lector->readObject(PersonaObj::className(), []);
            return $persona;
        }
    }

    /*=============================================
    LISTA PERSONAS
    =============================================*/
    static public function listaPersonas()
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT per.IdPersona, per.NumeroDocumento, per.NroComplemento, per.PrimerNombre, per.SegundoNombres, per.TercerNombre, per.ApellidoPaterno, per.ApellidoMaterno, isnull(per.ApellidoPaterno,'')+' '+isnull(per.ApellidoMaterno,'')+' '+per.PrimerNombre +' '+per.SegundoNombres+' '+per.TercerNombre AS NombreCompleto,
                            per.TipoDocumento, td.NombreDocumento, per.LugarExpedicion ,per.FechaNacimiento, per.Sexo, case per.Sexo when 'M' then 'MASCULINO' else 'FEMENINO' end AS SexoLiteral,
							per.CodigoEstadoCivil, ec.NombreEstadoCivil, per.CodigoEstado, per.FechaHoraRegistro, per.CodigoUsuario                             
                     FROM Personas per
					 INNER JOIN EstadosCiviles ec ON per.CodigoEstadoCivil = ec.CodigoEstadoCivil
					 INNER JOIN TiposDocumentos td ON per.TipoDocumento = td.TipoDocumento
					 ORDER BY per.ApellidoPaterno, per.ApellidoMaterno, per.PrimerNombre, per.SegundoNombres, per.TercerNombre";
        $instruccion = $dbRRHH->createCommand($consulta);
        $lector = $instruccion->query();
        $personas = [];
        while ($persona = $lector->readObject(PersonaObj::className(), [])){
            $personas[] = $persona;
        }
        return $personas;
    }

    /*=============================================
    LISTA PERSONAS DECLARACION JURADA
    =============================================
    static public function listaPersonasDeclaracionJurada()
    {
        $dbRRHH = Yii::$app->dbDecJu;
        $consulta = "SELECT per.id_persona AS IdPersona, lugar_emision As Emision, per.nombres as Nombres, per.apellido_paterno AS Paterno, per.apellido_materno AS Materno,
                            isnull(per.apellido_paterno,'')+' '+isnull(per.apellido_materno,'')+' '+per.Nombres AS NombreCompleto, per.fecha_nacimiento AS FechaNacimiento,Sexo,
                             CASE Sexo  WHEN 'M' then 'MASCULINO' ELSE 'FEMENINO' END as SexoLiteral, Discapacidad 
                     FROM persona per
                     WHERE nombres IS NOT NULL AND nombres <> '' AND nombres <> '.' AND apellido_paterno <> '.' AND apellido_materno <> '.' ";
        $instruccion = $dbRRHH->createCommand($consulta);
        $lector = $instruccion->query();
        $personas = [];
        while ($persona = $lector->readObject(PersonaObj::className(), [])){
            $personas[] = $persona;
        }
        return $personas;
    }*/
}