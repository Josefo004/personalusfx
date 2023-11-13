<?php


namespace app\modules\CargaHoraria\models;
use Yii;
use yii\db\mssql\PDO;

class VCargaHorariaVigenteDao
{
    /*=============================================
      LISTA NOMBRES DE DOCENTES POR CARRERA POR DIRECTOR EN GESTION ACTUAL
      =============================================*/
    static public function listaDocentesDirectorMes($codigoUsuario)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT DISTINCT vch.IdPersona, isnull(upper(vch.Paterno),'') AS Paterno, isnull(upper(vch.Materno),'') AS Materno, 
                     upper(vch.Nombres)AS Nombres, isnull(vch.Paterno,'')+' '+isnull(vch.Materno,'')+' '+vch.Nombres AS NombreCompleto
                     FROM VCargaHorariaVigente vch
                     INNER JOIN 
                     (SELECT CodigoCarrera, CodigoSede
                     from  [172.17.1.20].[Academica].dbo.ConfiguracionesUsuariosCarreras
                     WHERE CodigoUsuario= :codigoUsuario) AS car
                     ON vch.CodigoCarrera=car.CodigoCarrera AND vch.CodigoSedeAcad=car.CodigoSede
                     ORDER BY NombreCompleto";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":codigoUsuario", $codigoUsuario, PDO::PARAM_STR);
        //print_r($instruccion->getRawSql());
        // exit;
        $lector = $instruccion->query();
        $docentesCarrera = [];
        while ($docenteCarrera = $lector->readObject(VCargaHorariaVigenteObj::className(), [])) {
            $docentesCarrera[] = $docenteCarrera;
        }
        return $docentesCarrera;
    }
   /*=============================================
  LISTA LAS MATERIAS DE UN DOCENTE POR DIRECTOR
  =============================================*/
    static public function mostrarMateriasDocente($codigoUsuario, $idPersona)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT vcv.GestionAcademica, vcv.CodigoCarrera, vcv.NombreCarrera,
                     vcv.CodigoSedeAcad, vcv.NombreSedeAcad, vcv.NumeroPlanEstudios, 
	                 vcv.Curso, vcv.SiglaMateria, vcv.NombreMateria, vcv.Grupo, 
	                 SUM(vcv.HorasSemana) AS HorasSemana, SUM(vcv.HorasSemana)*4 AS HorasMes,
	                  vcv.IdPersona, isnull(UPPER(vcv.Paterno),'') AS Paterno, 
	                  isnull(UPPER(vcv.Materno),'') AS Materno,
                     UPPER(vcv.Nombres)AS Nombres, 
					 isnull(vcv.Paterno,'')+' '+isnull(vcv.Materno,'')+' '+Nombres AS NombreCompleto, 
					 vcv.CodigoTrabajador
                     FROM vCargaHorariaVigente vcv
                     INNER JOIN
                    (SELECT CodigoCarrera, CodigoSede FROM [172.17.1.20].[Academica].dbo.ConfiguracionesUsuariosCarreras 
                     WHERE CodigoUsuario= :codigoUsuario) car
                     ON vcv.CodigoCarrera=car.CodigoCarrera AND vcv.CodigoSedeAcad=car.CodigoSede
                     WHERE IdPersona=:idPersona
                     GROUP BY vcv.GestionAcademica, vcv.CodigoCarrera, vcv.NombreCarrera,
                     vcv.CodigoSedeAcad, vcv.NombreSedeAcad, vcv.NumeroPlanEstudios, 
	                 vcv.Curso, vcv.SiglaMateria,vcv.NombreMateria, vcv.Grupo, vcv.IdPersona,
	                 vcv.Paterno, vcv.Materno, vcv.Nombres, vcv.CodigoTrabajador";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":idPersona", $idPersona, PDO::PARAM_STR)
            ->bindParam(":codigoUsuario", $codigoUsuario, PDO::PARAM_STR);
        //print_r($instruccion->getRawSql());
        //exit;
        $lector = $instruccion->query();
        $docentesCarrera = [];
        while ($docenteCarrera = $lector->readObject(VCargaHorariaVigenteObj::className(), [])) {
            $docentesCarrera[] = $docenteCarrera;
        }
        return $docentesCarrera;
    }
}