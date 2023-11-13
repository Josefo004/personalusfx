<?php
namespace app\modules\CargaHoraria\models;
use Yii;
use yii\db\mssql\PDO;
class DetalleCargaHorariaDao
{
    static public function gestionAcademicaVigente($codigoUsuario)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT chc.GestionAcademica as Gestion
                     FROM CargaHorariaConfiguraciones chc
                     INNER JOIN
                     (SELECT CodigoCarrera, CodigoSede from [172.17.1.20].[Academica].dbo.ConfiguracionesUsuariosCarreras 
                     WHERE CodigoUsuario= :codigoUsuario) AS car
                     ON chc.CodigoCarrera= car.CodigoCarrera AND chc.CodigoSedeAcad=car.CodigoSede collate SQL_Latin1_General_CP1_CI_AS
                     WHERE GETDATE() BETWEEN chc.FechaInicioInformes AND FechaFinInformes
                     ";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":codigoUsuario", $codigoUsuario, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $gestiones = [];
        while ($gestion = $lector->readObject(DetalleCargaHorariaObj::className(), [])) {
            $gestiones[] = $gestion;
        }
        return $gestiones;
    }
    static public function verificaCronogramaInformes($codigoUsuario)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "select chc.DiaInicioInformes, chc.DiaFinInformes
                     from CargaHorariaConfiguraciones chc
                     INNER JOIN
                     (select CodigoCarrera, CodigoUnidad
                     from [172.17.1.20].[Academica].dbo.ConfiguracionesUsuariosCarreras
                     where CodigoUsuario='ERE') car
                     ON chc.CodigoCarrera=car.CodigoCarrera AND chc.CodigoSedeAcad=car.CodigoSede collate SQL_Latin1_General_CP1_CI_AS
                     where  5 BETWEEN chc.DiaInicioInformes AND chc.DiaFinInformes  AND GestionAcademica='1/2021'";
        $instruccion = $dbRRHH->createCommand($consulta)
            ->bindParam(":codigoUsuario", $codigoUsuario, PDO::PARAM_STR)
            ->bindParam(":gestionAcademica", $gestionAcademica, PDO::PARAM_STR);
        $lector = $instruccion->query();
        if (!empty($respuesta)) {
            return true;
        } else {
            return false;
        }
    }
}

