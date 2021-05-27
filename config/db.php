<?php

return [
    'class' => 'yii\db\Connection',
    'driverName' => 'sqlsrv',
    'dsn' => 'sqlsrv:Server=localhost;Database=Borodin_303_4',
    // Credentials are not required if using Windows Authentication method
    'username' => 'sa',
    'password' => 'SuperAdmin1234',
    'charset' => 'utf8'

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
