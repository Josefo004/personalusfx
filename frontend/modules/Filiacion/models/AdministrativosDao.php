<?php

namespace app\modules\Filiacion\models;

use yii\db\Query;
use yii\db\mssql\PDO;
use Yii;

class AdministrativosDao
{
    /*==================================================
    LISTA ASIGNACIONES
    ==================================================*/
    static public function listaAdministrativos()
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT ad.IdFuncionario, fu.IdPersona, per.PrimerNombre, per.SegundoNombres, per.TercerNombre, per.ApellidoPaterno, per.ApellidoMaterno, 
                            isnull(per.ApellidoPaterno,'')+' '+isnull(per.ApellidoMaterno,'')+' '+per.PrimerNombre +' '+per.SegundoNombres+' '+per.TercerNombre AS NombreCompleto,
                            ad.IdItem, i.NroItem,ad.FechaIngreso, ad.CodigoNivelSalarial, ns.NombreNivelSalarial, ad.CodigoCondicionLaboral, cl.NombreCondicionLaboral, 
                            ad.FechaSalida, ad.NroMemorando, ad.Observaciones, ad.CodigoTiempoTrabajo, tt.NombreTiempoTrabajo, ad.CodigoEstado, ad.CodigoUsuario, ad.FechaHoraRegistro,
							fu.CodigoSectorTrabajo, st.NombreSectorTrabajo							
                     FROM Administrativos ad
                     INNER JOIN Funcionarios fu ON ad.IdFuncionario = fu.IdFuncionario
                     INNER JOIN Personas per ON fu.IdPersona = per.IdPersona
                     INNER JOIN Items i ON ad.IdItem = i.IdItem
                     INNER JOIN NivelesSalariales ns ON ad.CodigoNivelSalarial = ns.CodigoNivelSalarial
                     INNER JOIN CondicionesLaborales cl ON ad.CodigoCondicionLaboral = cl.CodigoCondicionLaboral
					 INNER JOIN SectoresTrabajo st ON fu.CodigoSectorTrabajo = st.CodigoSectorTrabajo
                     INNER JOIN TiemposTrabajo tt ON ad.CodigoTiempoTrabajo = tt.CodigoTiempoTrabajo
                     ORDER BY per.ApellidoPaterno, per.ApellidoMaterno, per.PrimerNombre, per.SegundoNombres, per.TercerNombre";
        $instruccion = $dbRRHH->createCommand($consulta);
        $lector = $instruccion->query();
        $administrativos = [];
        while ($administrativo = $lector->readObject(AdministrativoObj::className(), [])) {
            $administrativos[] = $administrativo;
        }
        return $administrativos;
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
					 WHERE fu.IdFuncionario NOT IN (SELECT IdFuncionario FROM Administrativos) AND fu.CodigoSectorTrabajo = 'ADM'
                     ORDER BY per.ApellidoPaterno, per.ApellidoMaterno, per.PrimerNombre, per.SegundoNombres, per.TercerNombre";
        $instruccion = $dbRRHH->createCommand($consulta);
        $lector = $instruccion->query();
        $funcionarios = [];
        while ($funcionario = $lector->readObject(AdministrativoObj::className(), [])) {
            $funcionarios[] = $funcionario;
        }
        return $funcionarios;
    }

    /*=============================================
    BUSCA ADMINISTRATIVO
    =============================================*/
    static public function buscaAdministrativo($tipo, $idFuncionario, $idItem, $fechaIngreso/*, $sectorTrabajo*/)
    {
        $dbRRHH = Yii::$app->db;
        $consulta = "SELECT ad.IdFuncionario, fu.IdPersona, per.PrimerNombre, per.SegundoNombres, per.TercerNombre, per.ApellidoPaterno, per.ApellidoMaterno, 
                            isnull(per.ApellidoPaterno,'')+' '+isnull(per.ApellidoMaterno,'')+' '+per.PrimerNombre +' '+per.SegundoNombres+' '+per.TercerNombre AS NombreCompleto,
                            ad.IdItem, i.NroItem,ad.FechaIngreso, ad.CodigoNivelSalarial, ns.NombreNivelSalarial, ad.CodigoCondicionLaboral, cl.NombreCondicionLaboral, 
                            ad.FechaSalida, ad.NroMemorando, ad.Observaciones, ad.CodigoTiempoTrabajo, tt.NombreTiempoTrabajo, ad.CodigoEstado, ad.CodigoUsuario, 
                            ad.FechaHoraRegistro, fu.CodigoSectorTrabajo, st.NombreSectorTrabajo, i.CodigoCargo, ca.NombreCargo							
                     FROM Administrativos ad
                     INNER JOIN Funcionarios fu ON ad.IdFuncionario = fu.IdFuncionario
                     INNER JOIN Personas per ON fu.IdPersona = per.IdPersona
                     INNER JOIN Items i ON ad.IdItem = i.IdItem
                     INNER JOIN NivelesSalariales ns ON ad.CodigoNivelSalarial = ns.CodigoNivelSalarial
                     INNER JOIN CondicionesLaborales cl ON ad.CodigoCondicionLaboral = cl.CodigoCondicionLaboral
					 INNER JOIN SectoresTrabajo st ON fu.CodigoSectorTrabajo = st.CodigoSectorTrabajo
                     INNER JOIN TiemposTrabajo tt ON ad.CodigoTiempoTrabajo = tt.CodigoTiempoTrabajo
					 INNER JOIN Cargos ca ON i.CodigoCargo = ca.CodigoCargo
                     WHERE ad.IdFuncionario = :idFuncionario AND ad.IdItem = :idItem AND ad.FechaIngreso = :fechaIngreso /*AND fu.CodigoSectorTrabajo :sectorTrabajo*/  ";
        if ($tipo == "array") {
            $persona = $dbRRHH->createCommand($consulta)
                ->bindParam(":idFuncionario", $idFuncionario, PDO::PARAM_STR)
                ->bindParam(":idItem", $idItem, PDO::PARAM_STR)
                ->bindParam(":fechaIngreso", $fechaIngreso, PDO::PARAM_STR)
                //->bindParam(":sectorTrabajo", $sectorTrabajo, PDO::PARAM_STR)
                ->queryOne();
            return $persona;
        } else {
            $instruccion = $dbRRHH->createCommand($consulta)
                ->bindParam(":idFuncionario", $idFuncionario, PDO::PARAM_STR)
                ->bindParam(":idItem", $idItem, PDO::PARAM_STR)
                ->bindParam(":fechaIngreso", $fechaIngreso, PDO::PARAM_STR)
                /*->bindParam(":sectorTrabajo", $sectorTrabajo, PDO::PARAM_STR)*/;
            $lector = $instruccion->query();
            $trabajador = $lector->readObject(AdministrativoObj::className(), []);
            return $trabajador;
        }
    }
}