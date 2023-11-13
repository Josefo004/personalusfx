<?php

namespace app\modules\Administracion\assets;

use yii\web\AssetBundle;

class AdministracionAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/Administracion/assets';
    public $css = [
        '../../plugins/sweetalert2/sweetalert2.css',
        '../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css',
        '../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css',
        '../../plugins/jquerytreeview/jqtree.css',
        '../../plugins/select2/css/select2.css',
        'css/Administracion.css',
    ];
    public $js = [
        '../../plugins/sweetalert2/sweetalert2.all.js',
        '../../plugins/datatables/jquery.dataTables.min.js',
        '../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js',
        '../../plugins/datatables-responsive/js/dataTables.responsive.min.js',
        '../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js',
        '../../plugins/jquery-validation/jquery.validate.min.js',
        '../../plugins/jquerytreeview/tree.jquery.js',
        '../../plugins/select2/js/select2.js',
        'js/Validacion.js',
        'js/Administracion.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}