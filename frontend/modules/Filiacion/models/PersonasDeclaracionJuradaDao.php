<?php

namespace app\modules\Filiacion\models;

use yii\db\mssql\PDO;
use Yii;

class PersonasDeclaracionJuradaDao
{
    /*=============================================
        LISTA PERSONAS DECLARACION JURADA
        =============================================*/
    static public function listaPersonasDeclaracionJurada()
    {
        $dbRRHH = Yii::$app->dbDecJu;
        $consulta = "SELECT rtrim(per.id_persona) AS IdPersona, rtrim(lugar_emision) As Emision, per.nombres as Nombres, per.apellido_paterno AS Paterno, per.apellido_materno AS Materno,
                            isnull(per.apellido_paterno,'')+' '+isnull(per.apellido_materno,'')+' '+per.Nombres AS NombreCompleto, per.fecha_nacimiento AS FechaNacimiento,Sexo,
                             CASE Sexo  WHEN 'M' then 'MASCULINO' ELSE 'FEMENINO' END as SexoLiteral, discapacidad, rtrim(per.estado_civil) AS estadocivil, per.direccion 
                     FROM persona per
                     WHERE PER.id_persona NOT IN (SELECT IdPersona COLLATE Modern_Spanish_CI_AS
					 FROM SiacPersonal.dbo.Personas
					 WHERE CodigoEstado = 'v' ) and
					 nombres IS NOT NULL AND nombres <> '' AND nombres <> '.' AND apellido_paterno <> '.' AND apellido_materno <> '.'
					 ORDER BY Paterno, Materno,Nombres";
        $instruccion = $dbRRHH->createCommand($consulta);
        $lector = $instruccion->query();
        $personas = [];
        while ($persona = $lector->readObject(PersonaDeclaracionJuradaObj::className(), [])){
            $personas[] = $persona;
        }
        return $personas;
    }

}