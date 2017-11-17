<?php
ob_start();
    require __DIR__ . '/init-db.sql';
$connQuery = ob_get_clean();

return [
    'rootDir' => __DIR__,
    'uploadDir' => __DIR__ . '/upload',
    'cssDir' => __DIR__ . '/css/css',
    'jsDir' => __DIR__ . '/js',
    'db' => [
        'dsn' => 'mysql:host=127.0.0.1', // !!!  по ТЗ: таблицы в БД должны сами создаваться при первом запуске
        'user' => 'root',
        'password' => '123456',
        'connQuery' => $connQuery,
    ],
    'routeTo404' => 'App\Controllers\IndexController::err404Action',
    'routesByNs' => [
        'App\Controllers' => '/'
    ],
    'debug' => true,
    'email' => 'artyom@art.suse',
    'emailAdmin' => 'artyom@art.suse',
];