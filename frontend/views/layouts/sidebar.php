<aside class="main-sidebar sidebar-light-primary elevation-0">
    <!-- Brand Logo -->
    <a href="<?=\yii\helpers\Url::home()?>" class="brand-link">
        <img src="<?=$assetDir?>/img/icono.png" alt="UrrhhSoft Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light"><?=Yii::$app->name?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            if (Yii::$app->user->identity->CodigoRol == 'ADS'){
                echo \hail812\adminlte3\widgets\Menu::widget([
                    'items' => [
                        /*[
                            'label' => 'Administración',
                            'icon' => 'th',
                            'badge' => '<span class="right badge badge-info">5</span>',
                            'items' => [
                                ['label' => 'Paises', 'url' => ['/Administracion/paises/index'], 'iconStyle' => 'far'],
                                ['label' => 'Departamentos', 'url' => ['/Administracion/departamentos/index'], 'iconStyle' => 'far'],
                                ['label' => 'Provincias', 'url' => ['/Administracion/provincias/index'], 'iconStyle' => 'far'],
                                ['label' => 'Lugares', 'url' => ['/Administracion/lugares/index'], 'iconStyle' => 'far'],
                                ['label' => 'Items', 'url' => ['/Administracion/items/index'], 'iconStyle' => 'far'],
                                ['label' => 'Niveles Salariales', 'url' => ['/Administracion/niveles-salariales/index'], 'iconStyle' => 'far'],
                            ]
                        ],*/
                        [
                            'label' => 'Filiacion',
                            'icon' => 'th',
                            'badge' => '<span class="right badge badge-info">5</span>',
                            'items' => [
                                ['label' => 'Personas', 'url' => ['/Filiacion/personas/index'], 'iconStyle' => 'far'],
                                ['label' => 'Funcionarios', 'url' => ['/Filiacion/trabajadores/index'], 'iconStyle' => 'far'],
                                ['label' => 'Administrativos', 'url' => ['/Filiacion/administrativos/index'], 'iconStyle' => 'far'],
                                ['label' => 'Docentes', 'url' => ['/Filiacion/docentes/index'], 'iconStyle' => 'far'],
                                ['label' => 'Transferencias', 'url' => ['/Filiacion/transferencia-administrativo/index'], 'iconStyle' => 'far'],
                            ]
                        ],
                        /*[
                            'label' => 'Contraloria General',
                            'icon' => 'th',
                            'badge' => '<span class="right badge badge-info">3</span>',
                            'items' => [
                                ['label' => 'Tipos Declaraciones ', 'url' => ['/Contraloria/tipos-declaraciones-juradas/index'], 'iconStyle' => 'far'],
                                ['label' => 'Declaraciones Trabajadores', 'url' => ['/Contraloria/trabajadores-declaraciones-juradas/index'], 'iconStyle' => 'far'],
                                ['label' => 'Reportes Dec. Juradas',
                                    'iconStyle' => 'far',
                                    'badge' => '<span class="right badge badge-info"></span>',
                                    'items' => [
                                        ['label' => 'Dec. Juradas Trabajadores','url' => ['/Contraloria/reportes-declaraciones-juradas/index'], ],
                                        ['label' => 'Dec. Juradas Presentadas','url' => ['/Contraloria/reportes-dec-ju-presentadas/index'], ]
                                    ],
                                ]
                            ]
                        ],*/
                        [
                            'label' => 'Planillas',
                            'icon' => 'th',
                            'badge' => '<span class="right badge badge-info">1</span>',
                            'items' => [
                                ['label' => 'Aportes de Ley ', 'url' => ['/Planillas/aportes-ley/index'], 'iconStyle' => 'far'],

                            ]
                        ],
                        /*[
                            'label' => 'Sesiones',
                            'icon' => 'th',
                            'badge' => '<span class="right badge badge-info">4</span>',
                            'items' => [
                                ['label' => 'Asignaciones', 'url' => ['asignaciones/index'], 'iconStyle' => 'far'],
                            ]
                        ],*/
                        /*['label' => 'Simple Link', 'icon' => 'th', 'badge' => '<span class="right badge badge-danger">New</span>'],
                        ['label' => 'Yii2 PROVIDED', 'header' => true],
                        ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest],
                        ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
                        ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],
                        ['label' => 'MULTI LEVEL EXAMPLE', 'header' => true],
                        ['label' => 'Level1'],
                        [
                            'label' => 'Level1',
                            'items' => [
                                ['label' => 'Level2', 'iconStyle' => 'far'],
                                [
                                    'label' => 'Level2',
                                    'iconStyle' => 'far',
                                    'items' => [
                                        ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                        ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                                        ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle']
                                    ]
                                ],
                                ['label' => 'Level2', 'iconStyle' => 'far']
                            ]
                        ],
                        ['label' => 'Level1'],
                        ['label' => 'LABELS', 'header' => true],
                        ['label' => 'Important', 'iconStyle' => 'far', 'iconClassAdded' => 'text-danger'],
                        ['label' => 'Warning', 'iconClass' => 'nav-icon far fa-circle text-warning'],
                        ['label' => 'Informational', 'iconStyle' => 'far', 'iconClassAdded' => 'text-info'],*/
                    ],
                ]);
            }elseif (Yii::$app->user->identity->CodigoRol == 'RHE'){
            }elseif (Yii::$app->user->identity->CodigoRol == 'RHJ'){
            }
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>