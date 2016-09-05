<?php

return [
    'class' => 'yii\db\Connection',
    //'dsn' => 'mysql:host=localhost;dbname=yii2basic',
	//'dsn' => 'sqlite:/wwwroot/ly/protected/db/ly.db', // SQLite
	'dsn' => 'sqlite:/home/www/ly/protected/db/ly.db', // SQLite
    'username' => '',
    'password' => '',
    'charset' => 'utf8',
	'tablePrefix'=>'ly_'
];
