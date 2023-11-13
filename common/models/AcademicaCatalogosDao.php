<?php

namespace common\models;

use yii\db\mssql\PDO;
use Yii;
use app\modules\Administracion\models\PaisAcadObj;
use app\modules\Administracion\models\DepartamentoAcadObj;
use app\modules\Administracion\models\ProvinciaAcadObj;
use app\modules\Administracion\models\LugarAcadObj;

class AcademicaCatalogosDao
{    
    /*=============================================
     LISTA PAISES ACADEMICA
     =============================================*/
    static public function listaPaisesAcad()
    {
        $dbAcad = Yii::$app->dbAcad;
        $consulta = "SELECT CodigoPais, CodigoISO3166, NumeroPais, upper(rtrim(NombrePais)) AS NombrePais, Gentilicio, upper(rtrim(Nacionalidad)) AS Nacionalidad
                     FROM Paises
					 WHERE CodigoPais NOT IN (SELECT CodigoPaisAcad COLLATE Modern_Spanish_CI_AS 
					                          FROM SiacPersonal.dbo.Paises					                          
					                          )";
        /*$consulta = "SELECT CodigoPais, CodigoISO3166, NumeroPais, upper(rtrim(NombrePais)) AS NombrePais, Gentilicio, upper(rtrim(Nacionalidad)) AS Nacionalidad
                     FROM Paises
					 WHERE CodigoPais NOT IN (SELECT CodigoPaisAcad COLLATE Modern_Spanish_CI_AS 
					                          FROM [172.16.1.250].SiacPersonal.dbo.Paises
					                          )";*/

        $instruccion = $dbAcad->createCommand($consulta);
        $lector = $instruccion->query();
        $paises = [];
        while ($pais = $lector->readObject(PaisAcadObj::className(), [])) {
            $paises[] = $pais;
        }
        return $paises;
    }

    /*=============================================
     LISTA DEPARTAMENTOS PAIS ACAD
     =============================================*/
    static public function listaDepartamentosPaisAcad($codigoPaisAcad)
    {
        $dbAcad = Yii::$app->dbAcad;
        $consulta = "SELECT p.CodigoPais, NombrePais, p.CodigoPaisAcad, Nacionalidad, p.CodigoEstado,
	                        da.CodigoPais, da.CodigoDepartamento, UPPER(RTRIM(da.NombreDepartamento))AS NombreDepartamento 
                     FROM SiacPersonal.dbo.Paises p
                     INNER JOIN Departamentos da ON p.CodigoPaisAcad = da.CodigoPais COLLATE Modern_Spanish_CI_AS
                     WHERE CodigoDepartamento NOT IN (SELECT CodigoDepartamentoAcad COLLATE Modern_Spanish_CI_AS 
					 FROM SiacPersonal.dbo.Departamentos
					 WHERE codigoestado = 'V' ) and p.CodigoPais = :codigoPaisAcad";
        $instruccion = $dbAcad->createCommand($consulta)
            ->bindParam(":codigoPaisAcad", $codigoPaisAcad, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $departamentos = [];
        while ($departamento = $lector->readObject(DepartamentoAcadObj::className(), [])) {
            $departamentos[] = $departamento;
        }
        return $departamentos;
    }

    /*=============================================
     LISTA PROVINCIAS DEPARTAMENTO ACAD
     =============================================*/
    static public function listaProvinciasDepartamentoAcad($codigoDepartamentoAcad)
    {
        $dbAcad = Yii::$app->dbAcad;
        $consulta = "SELECT d.CodigoDepartamento, NombreDepartamento, d.CodigoPaisAcad, d.CodigoDepartamentoAcad, d.CodigoEstado,
							pa.CodigoPais, pa.CodigoDepartamento, pa.CodigoProvincia, UPPER(RTRIM(pa.NombreProvincia))AS NombreProvincia
					 FROM SiacPersonal.dbo.Departamentos d
					 INNER JOIN Provincias pa ON d.CodigoDepartamentoAcad = pa.CodigoDepartamento COLLATE Modern_Spanish_CI_AS
					 WHERE CodigoProvincia NOT IN (SELECT CodigoProvinciaAcad COLLATE Modern_Spanish_CI_AS
					 FROM SiacPersonal.dbo.Provincias
					 WHERE CodigoEstado = 'V') AND d.CodigoDepartamento = :codigoDepartamentoAcad";
        $instruccion = $dbAcad->createCommand($consulta)
            ->bindParam(":codigoDepartamentoAcad", $codigoDepartamentoAcad, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $provincias = [];
        while ($provincia = $lector->readObject(ProvinciaAcadObj::className(), [])) {
            $provincias[] = $provincia;
        }
        return $provincias;
    }

    /*=============================================
     LISTA LUGARES DEPARTAMENTO ACAD
     =============================================*/
    static public function listaLugaresProvinciaAcad($codigoProvinciaAcad)
    {
        $dbAcad = Yii::$app->dbAcad;
        $consulta = "SELECT p.CodigoProvincia, NombreProvincia, p.CodigoPaisAcad, p.CodigoDepartamentoAcad, p.CodigoProvinciaAcad, p.CodigoEstado,
							la.CodigoPais, la.CodigoDepartamento, la.CodigoProvincia, la.CodigoLugar, UPPER(RTRIM(la.NombreLugar))AS NombreLugar, la.IdLugar
					 FROM SiacPersonal.dbo.provincias p
					 INNER JOIN Lugares la ON p.CodigoProvinciaAcad = la.CodigoProvincia COLLATE Modern_Spanish_CI_AS
					 WHERE CodigoLugar NOT IN (SELECT CodigoLugarAcad COLLATE Modern_Spanish_CI_AS
					 FROM SiacPersonal.dbo.Lugares
					 WHERE CodigoEstado = 'V') AND p.CodigoProvincia = :codigoProvinciaAcad";
        $instruccion = $dbAcad->createCommand($consulta)
            ->bindParam(":codigoProvinciaAcad", $codigoProvinciaAcad, PDO::PARAM_STR);
        $lector = $instruccion->query();
        $lugares = [];
        while ($lugar = $lector->readObject(LugarAcadObj::className(), [])) {
            $lugares[] = $lugar;
        }
        return $lugares;
    }
}
