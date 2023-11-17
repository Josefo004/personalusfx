<?php

use yii\helpers\Html;

?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= \yii\helpers\Url::home() ?>" class="nav-link">Inicio</a>
        </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">

    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <li class="nav-item">
            <?= Html::a('<i class="fas fa-sign-out-alt"></i>', ['/site/logout'], ['data-method' => 'post', 'class' => 'nav-link']) ?>
        </li>
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="<?=$assetDir?>/img/usuarios/user.png" alt="Imagen Usuario" class="user-image img-circle elevation-2">
                <span class="d-none d-md-inline"><?= ucwords( strtolower (Yii::$app->user->identity->CodigoUsuario)) ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                    <img src="<?=$assetDir?>/img/usuarios/<?=rtrim(Yii::$app->user->identity->CodigoUsuario)?>.png" class="img-circle elevation-2" alt="User Image">
                    <p>
                        <?= ucwords( strtolower (Yii::$app->user->identity->CodigoUsuario ) )?>
                        <small><?=  Yii::$app->user->identity->rol->NombreRol ?></small>
                    </p>
                </li>
                <!-- Menu Body -->
                <!--<li class="user-body">
                    <div class="row">
                        <div class="col-4 text-center">
                            <a href="#">Followers</a>
                        </div>
                        <div class="col-4 text-center">
                            <a href="#">Sales</a>
                        </div>
                        <div class="col-4 text-center">
                            <a href="#">Friends</a>
                        </div>
                    </div>
                </li>-->
                <!-- Menu Footer-->
                <li class="user-footer">
                    <!--<a href="<?= Yii::$app->urlManager->createUrl('listas/index')?>" class="btn btn-default btn-flat">Profile</a>-->
                    <?= Html::a('Salir', ['/site/logout'], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat float-right']) ?>
                </li>
            </ul>
        </li>

    </ul>
</nav>