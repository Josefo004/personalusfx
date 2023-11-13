<?php

namespace app\modules\CargaHoraria\models;;

use yii\db\mssql\PDO;
use Yii;

class PlanesEstudiosDao
{
    /*=============================================
    LISTA PLANES DE ESTUDIO VIGENTES DE UNA CARRERA
    =============================================*/
    static public function listaPlanesEstudioCarrera($codigoCarrera)
    {
        $dbAcad = Yii::$app->dbAcad;
        $consulta = "SELECT pla.CodigoCarrera, pla.NumeroPlanEstudios, pla.CodigoSistema
                     FROM PlanesEstudios pla
                     WHERE pla.CodigoCarrera = :codigoCarrera AND pla.CodigoEstadoPlanEstudios = 'V'                                                                     
                     ORDER BY pla.NumeroPlanEstudios ";
        $instruccion = $dbAcad->createCommand($consulta)
            ->bindParam(":codigoCarrera", $codigoCarrera, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $planesEstudios = [];
        while ($planEstudio = $lector->readObject(PlanEstudioObj::className(), [])) {
            $planesEstudios[] = $planEstudio;
        }
        return $planesEstudios;
    }

    /*================================================
    LISTA CURSOS DE UN PLAN DE ESTUDIOS DE UNA CARRERA
    =================================================*/
    static public function listaCursos($codigoCarrera, $numeroPlanEstudios)
    {
        $dbAcad = Yii::$app->dbAcad;
        $consulta = "SELECT DISTINCT mat.Curso
                     FROM Materias mat
                     INNER JOIN PlanesEstudios pla ON mat.NumeroPlanEstudios = pla.NumeroPlanEstudios AND mat.CodigoCarrera = pla.CodigoCarrera
                     WHERE mat.CodigoCarrera = :codigoCarrera AND mat.NumeroPlanEstudios = :numeroPlanEstudios AND mat.CodigoEstadoMateria = 'A'                                                                     
                     ORDER BY mat.Curso ";
        $instruccion = $dbAcad->createCommand($consulta)
            ->bindParam(":codigoCarrera", $codigoCarrera, PDO::PARAM_STR)
            ->bindParam(":numeroPlanEstudios", $numeroPlanEstudios, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $cursos = [];
        while ($curso = $lector->readObject(CursoObj::className(), [])) {
            $cursos[] = $curso;
        }
        return $cursos;
    }
}