<?php
$session = Yii::$app->session;
$userID =  Yii::$app->user->identity['CodigoUsuario'];
?>

<table width='100%'>
    <tr >
        <td width='50%' style="font-size:12px; line-height: 18px; text-align: left; border: none;"  >{DATE j-m-Y}<br><?= 'Usuario: '.$userID;?></td>
        <td width='50%' align='right' style="font-size:12px; border: none;">{PAGENO}/{nbpg}</td>
    </tr>
</table>
