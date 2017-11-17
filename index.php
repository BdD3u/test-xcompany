<?php
require_once __DIR__ . '/Core/Autoload.php';
new \Core\Autoload(__DIR__);
\Core\Application::run(require __DIR__ . '/config.php');