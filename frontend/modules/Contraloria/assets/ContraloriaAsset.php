<?php

namespace app\modules\Contraloria\assets;

use yii\web\AssetBundle;

class ContraloriaAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/Contraloria/assets';
    public $css = [
        '../../plugins/sweetalert2/sweetalert2.css',
        '../../plugins/select2/css/select2.css',
        '../../plugins/jquery-ui/jquery-ui.css',
        '../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css',
        '../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css',

    ];
    public $js = [
        '../../plugins/sweetalert2/sweetalert2.all.js',
        '../../plugins/select2/js/select2.js',
        '../../plugins/datatables/jquery.dataTables.min.js',
        '../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js',
        '../../plugins/datatables-responsive/js/dataTables.responsive.min.js',
        '../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js',
        'js/Contraloria.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
