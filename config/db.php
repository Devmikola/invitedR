<?php

if(YII_ENV_DEV) {
    $ret_arr = [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=127.0.0.1;dbname=invitedR',
        'username' => 'root',
        'password' => '9379992',
        'charset' => 'utf8',
    ];
}
elseif(YII_ENV_PROD)
{

    $ret_arr = [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=sql7.freesqldatabase.com;port=3306;dbname=sql7115941',
        'username' => 'sql7115941',
        'password' => 'jxTdpbka7g',
        'charset' => 'utf8',
    ];
}


return $ret_arr;