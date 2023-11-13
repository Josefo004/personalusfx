<?php

namespace app\modules\Filiacion\models;

use yii\db\Query;
use yii\db\mssql\PDO;
use Yii;

class DocentesDao
{
    /*==================================================
    LISTA ASIGNACIONES
    ==================================================*/
    static public function listaDocentes()
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT doc.IdFuncionario, fu.IdPersona, per.PrimerNombre, per.SegundoNombres, per.TercerNombre, per.ApellidoPaterno, per.ApellidoMaterno, 
                            isnull(per.ApellidoPaterno,'')+' '+isnull(per.ApellidoMaterno,'')+' '+per.PrimerNombre +' '+per.SegundoNombres+' '+per.TercerNombre AS NombreCompleto,
                            doc.FechaIngreso, doc.CodigoNivelSalarial, ns.NombreNivelSalarial, doc.CodigoCondicionLaboral, cl.NombreCondicionLaboral, 
                            doc.FechaSalida, doc.Observaciones, doc.CodigoEstado, doc.CodigoUsuario, 
                            doc.FechaHoraRegistro, fu.CodigoSectorTrabajo, st.NombreSectorTrabajo
                     FROM Docentes doc
                     INNER JOIN Funcionarios fu ON doc.IdFuncionario = fu.IdFuncionario
                     INNER JOIN Personas per ON fu.IdPersona = per.IdPersona
                     --INNER JOIN Items i ON doc.IdItem = i.IdItem
                     INNER JOIN NivelesSalariales ns ON doc.CodigoNivelSalarial = ns.CodigoNivelSalarial
                     INNER JOIN CondicionesLaborales cl ON doc.CodigoCondicionLaboral = cl.CodigoCondicionLaboral
					 INNER JOIN SectoresTrabajo st ON fu.CodigoSectorTrabajo = st.CodigoSectorTrabajo
					ORDER BY per.ApellidoPaterno, per.ApellidoMaterno, per.PrimerNombre, per.SegundoNombres, per.TercerNombre";
        $instruccion = $dbRRHH->createCommand($consulta);
        $lector = $instruccion->query();
        $docentes = [];
        while ($docente = $lector->readObject(DocenteObj::className(), [])) {
            $docentes[] = $docente;
        }
        return $docentes;
    }

    /*==================================================
    LISTA TODOS LOS FUNCIONARIOS
    ==================================================*/
    static public function listaFuncionarios()
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT fu.IdFuncionario, per.IdPersona, per.PrimerNombre, per.SegundoNombres, per.TercerNombre, per.ApellidoPaterno, per.ApellidoMaterno, isnull(per.ApellidoPaterno,'')+' '+isnull(per.ApellidoMaterno,'')+' '+per.PrimerNombre +' '+per.SegundoNombres+' '+per.TercerNombre AS NombreCompleto,
                            per.FechaNacimiento, per.Sexo, case per.Sexo when 'M' then 'MASCULINO' else 'FEMENINO' end AS SexoLiteral, fu.CodigoSectorTrabajo, st.NombreSectorTrabajo,
							per.CodigoEstado, per.FechaHoraRegistro, per.CodigoUsuario                             
                     FROM Personas per
					 INNER JOIN Funcionarios fu on per.IdPersona = fu.IdPersona
					 INNER JOIN SectoresTrabajo st ON fu.CodigoSectorTrabajo = st.CodigoSectorTrabajo
					 WHERE fu.IdFuncionario NOT IN (SELECT IdFuncionario FROM Docentes) AND fu.CodigoSectorTrabajo = 'DOC'
                     ORDER BY per.ApellidoPaterno, per.ApellidoMaterno, per.PrimerNombre, per.SegundoNombres, per.TercerNombre";
        $instruccion = $dbRRHH->createCommand($consulta);
        $lector = $instruccion->query();
        $funcionarios = [];
        while ($funcionario = $lector->readObject(DocenteObj::className(), [])) {
            $funcionarios[] = $funcionario;
        }
        return $funcionarios;
    }

    /*=============================================
       BUSCA DOCENTE
       =============================================*/
    static public function buscaDocente($tipo, $idFuncionario, /*$idItem,*/ $fechaIngreso/*, $sectorTrabajo*/)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT doc.IdFuncionario, fu.IdPersona, per.PrimerNombre, per.SegundoNombres, per.TercerNombre, per.ApellidoPaterno, per.ApellidoMaterno, 
                            isnull(per.ApellidoPaterno,'')+' '+isnull(per.ApellidoMaterno,'')+' '+per.PrimerNombre +' '+per.SegundoNombres+' '+per.TercerNombre AS NombreCompleto,
                            doc.FechaIngreso, doc.CodigoNivelSalarial, ns.NombreNivelSalarial, doc.CodigoCondicionLaboral, cl.NombreCondicionLaboral, 
                            doc.FechaSalida, doc.Observaciones, doc.CodigoEstado, doc.CodigoUsuario, 
                            doc.FechaHoraRegistro, fu.CodigoSectorTrabajo, st.NombreSectorTrabajo
                     FROM Docentes doc
                     INNER JOIN Funcionarios fu ON doc.IdFuncionario = fu.IdFuncionario
                     INNER JOIN Personas per ON fu.IdPersona = per.IdPersona
                     --INNER JOIN Items i ON doc.IdItem = i.IdItem
                     INNER JOIN NivelesSalariales ns ON doc.CodigoNivelSalarial = ns.CodigoNivelSalarial
                     INNER JOIN CondicionesLaborales cl ON doc.CodigoCondicionLaboral = cl.CodigoCondicionLaboral
					 INNER JOIN SectoresTrabajo st ON fu.CodigoSectorTrabajo = st.CodigoSectorTrabajo
                     WHERE doc.IdFuncionario = :idFuncionario /*AND ad.IdItem = :idItem*/ AND doc.FechaIngreso = :fechaIngreso /*AND fu.CodigoSectorTrabajo :sectorTrabajo*/  ";
        if ($tipo == "array") {
            $persona = $dbRRHH->createCommand($consulta)
                ->bindParam(":idFuncionario", $idFuncionario, PDO::PARAM_STR)
                //->bindParam(":idItem", $idItem, PDO::PARAM_STR)
                ->bindParam(":fechaIngreso", $fechaIngreso, PDO::PARAM_STR)
                //->bindParam(":sectorTrabajo", $sectorTrabajo, PDO::PARAM_STR)
                ->queryOne();
            return $persona;
        } else {
            $instruccion = $dbRRHH->createCommand($consulta)
                ->bindParam(":idFuncionario", $idFuncionario, PDO::PARAM_STR)
                //->bindParam(":idItem", $idItem, PDO::PARAM_STR)
                ->bindParam(":fechaIngreso", $fechaIngreso, PDO::PARAM_STR)
                /*->bindParam(":sectorTrabajo", $sectorTrabajo, PDO::PARAM_STR)*/;
            $lector = $instruccion->query();
            $trabajador = $lector->readObject(DocenteObj::className(), []);
            return $trabajador;
        }
    }
}