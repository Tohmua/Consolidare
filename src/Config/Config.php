<?php

namespace Consolidare\Config;

class Config
{
    public static function loadConfig()
    {
        return array_merge(
            require __DIR__ . '/../../config/global.php',
            require __DIR__ . '/../../config/local.php'
        );
    }
}