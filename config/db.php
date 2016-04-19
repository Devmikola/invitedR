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
    $clearDB = parse_url(getenv("CLEARDB_DATABASE_URL"));

    $server = $clearDB["host"];
    $username = $clearDB["user"];
    $password = $clearDB["pass"];
    $db = substr($clearDB["path"], 1);
    $ret_arr = [
        'class' => 'yii\db\Connection',
        'dsn' => "mysql:host=$server;dbname=$db",
        'username' => $username,
        'password' => $password,
        'port' => '3306',
        'charset' => 'utf8',
    ];
}


return $ret_arr;