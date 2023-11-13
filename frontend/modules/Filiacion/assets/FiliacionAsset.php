<?php

namespace app\modules\Filiacion\assets;

use yii\web\AssetBundle;

class FiliacionAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/Filiacion/assets';
    public $css = [
        '../../plugins/select2/css/select2.css',
        '../../plugins/jquery-ui/jquery-ui.css',
        '../../plugins/sweetalert2/sweetalert2.css',
        '../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css',
        '../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css',

    ];
    public $js = [
        '../../plugins/select2/js/select2.js',
        '../../plugins/jquery-ui/jquery-ui.js',
        '../../plugins/sweetalert2/sweetalert2.all.js',
        '../../plugins/datatables/jquery.dataTables.min.js',
        '../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js',
        '../../plugins/datatables-responsive/js/dataTables.responsive.min.js',
        '../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js',
        'js/Filiacion.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}