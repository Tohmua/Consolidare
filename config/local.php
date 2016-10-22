<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

return [
    'logger' => function () {
        $logger = new Logger('name');
        $logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/consolidare.log', Logger::INFO));
        return $logger;
    }
];