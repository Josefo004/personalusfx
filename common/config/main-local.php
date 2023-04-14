<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            //'dsn' => 'dblib:host=172.17.1.30:1433;dbname=RecursosHumanos',
            'dsn' => 'sqlsrv:Server=172.17.1.30;Database=RecursosHumanos',
            //'username' => 'usrwebrrhh',
            //'password' => 'r3c%r505',
            'username' => 'dticgerzon',
            'password' => 'gbc437966',
            'charset' => 'utf8',
        ],
        'dbAcad' => [
            'class' => 'yii\db\Connection',
            //'dsn' => 'dblib:host=172.17.1.20:1433;dbname=Academica',
            'dsn' => 'sqlsrv:Server=172.17.1.20;Database=Academica',
            //'username' => 'usrwebrrhh',
            //'password' => 'r3c%r505',
            'username' => 'dticgerzon',
            'password' => 'gbc437966',
            'charset' => 'utf8',
        ],        
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
