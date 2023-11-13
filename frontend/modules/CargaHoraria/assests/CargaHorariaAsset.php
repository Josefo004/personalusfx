<?php
namespace app\modules\CargaHoraria\assests;
use yii\web\AssetBundle;
class CargaHorariaAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/CargaHoraria/assests';
    public $css = [
        '../../plugins/sweetalert2/sweetalert2.css',
        '../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css',
        '../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css',
    ];
    public $js = [
        '../../plugins/sweetalert2/sweetalert2.all.js',
        '../../plugins/datatables/jquery.dataTables.min.js',
        '../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js',
        '../../plugins/datatables-responsive/js/dataTables.responsive.min.js',
        '../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js',
        '../../plugins/ckeditor/ckeditor/ckeditor.js',
        'js/CargaHoraria.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}


