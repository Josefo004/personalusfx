<?php

namespace app\modules\CargaHoraria\models;

use yii\db\mssql\PDO;
use Yii;

class CargaHorariaconfiguracionesDao
{
    /*=============================================
    BUSCA CARGA HORARIA CONFIGURACION VIGENTE
    =============================================*/
    static public function buscaCargaHorariaConfiguracion($tipo, $codigoCarrera, $codigoSede)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT GestionAcademica, CodigoCarrera, CodigoSede, CodigoSedeAcad, GestionAnterior, MesAnterior, GestionAcademicaAnterior, GestionAcademicaPlanificacion, CodigoModalidadCurso, FechaInicioPlanificacion, FechaFinPlanificacion, FechaInicioContrataciones, FechaFinContrataciones, DiaInicioInformes, DiaFinInformes, CodigoEstado, FechaHoraRegistro, CodigoUsuario 
                     FROM CargaHorariaConfiguraciones
                     WHERE CodigoCarrera = :codigoCarrera AND CodigoSedeAcad = :codigoSede AND CodigoEstado = 'V' ";
        if ($tipo == "array") {
            $configuracion = $dbRRHH->createCommand($consulta)
                ->bindParam(":codigoCarrera", $codigoCarrera, PDO::PARAM_STR)
                ->bindParam(":codigoSede", $codigoSede, PDO::PARAM_STR)
                ->queryOne();
            return $configuracion;
        } else {
            $instruccion = $dbRRHH->createCommand($consulta)
                ->bindParam(":codigoCarrera", $codigoCarrera, PDO::PARAM_STR)
                ->bindParam(":codigoSede", $codigoSede, PDO::PARAM_STR);
            $lector = $instruccion->query();
            $configuracion = $lector->readObject(CargaHorariaConfiguracionObj::className(), []);
            return $configuracion;
        }
    }
}