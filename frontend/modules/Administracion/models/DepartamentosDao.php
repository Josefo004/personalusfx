<?php

namespace app\modules\Administracion\models;

use yii\db\mssql\PDO;
use Yii;
use yii\db\Query;

class DepartamentosDao
{
    /*=============================================
    GENERA UN NUEVO CODIGO DE DEPARTAMENTO
    =============================================*/
    static public function generarCodigoDepartamento()
    {
        $dbSiacPersonal = Yii::$app->db;
        $consulta = "SELECT max(CodigoDepartamento) AS UltimoCodigoDepartamento
                     FROM Departamentos";
        $instruccion = $dbSiacPersonal->createCommand($consulta);
        $arrayMaximo = $instruccion->queryOne();
        if (!$arrayMaximo) {
            return 1;
        } else {
            return $arrayMaximo['UltimoCodigoDepartamento'] + 1;
        }
    }

    /*=============================================
     LISTA DEPARTAMENTOS SIAC PERSONAL
     =============================================*/
    static public function listaDepartamentos()
    {        
        $dbSiacPersonal = Yii::$app->db;
        $consulta = "SELECT dep.CodigoDepartamento, dep.NombreDepartamento, dep.CodigoPais, dep.CodigoPaisAcad, dep.CodigoDepartamentoAcad, dep.CodigoEstado, pai.NombrePais, pai.Nacionalidad
                     FROM Departamentos dep
                     INNER JOIN Paises pai on dep.CodigoPais = pai.CodigoPais 
                     ORDER BY pai.NombrePais, dep.NombreDepartamento ";
        $instruccion = $dbSiacPersonal->createCommand($consulta);
        $lector = $instruccion->query();
        $departamentos = [];
        while ($departamento = $lector->readObject(DepartamentoObj::className(), [])) {
            $departamentos[] = $departamento;
        }
        return $departamentos;
    }
}