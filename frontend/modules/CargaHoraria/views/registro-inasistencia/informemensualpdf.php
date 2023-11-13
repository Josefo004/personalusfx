<style type="text/css" >
    table {
        border-collapse: collapse;
    }
    th,
    td {
        border-top: 1px solid;
        border-left: 1px solid;
        border-right: 1px solid;
        border-bottom: 1px solid;
        padding: 5px;
        text-align: center;
    }
    th {
        text-align: left;
        padding: 12px;
    }
</style>
<br>
<p style="border-top: 1px solid; border-bottom: 1px solid; padding: 12px; " align="center"><b><?= $informeInasistencias[0]->NombreCarrera; ?> <br> SEDE: <?= $informeInasistencias[0]->NombreSede; ?></b></p>
<table>
    <tr style="background-color: #E0E0E0;">
        <th>#</th>
        <th>Docente</th>
        <th>Materia</th>
        <th>Fecha</th>
        <th>Grupo</th>
        <th>Horas</th>
        <th>Inasistencia</th>
        <th>Observaciones</th>
    </tr>
    <?php $j = 0; ?>
    <?php foreach ($informeInasistencias as $fila) { ?>

        <tr >
            <th width="20px"><?= $j = $j + 1; ?></th>
            <td ><?= $fila->NombreCompleto  ?></td>
            <td ><?= $fila->SiglaMateria ?></td>
            <td><?php $fecha = date_format(date_create($fila->Fecha), 'd/m/Y');  echo $fecha;?> </td>
            <td><?= $fila->Grupo  ?></td>
            <td><?= $fila->Horas  ?></td>
            <td><?= $fila->NombreTipoInasistencia  ?></td>
            <td><?= $fila->Observacion  ?></td>
        </tr>
    <?php } ?>
</table>
<br>
<br>
<br>
<br>
<p align="center"><?= \Yii::$app->user->identity->persona->NombreCompleto; ?><br><b><?= $cargo ?></b></p>