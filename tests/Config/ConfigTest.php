<?php

use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Consolidare\Config\Config;

class ConfigTest extends TestCase
{
    public function testLoadsDefaultConfig()
    {
        $config = Config::loadConfig();
        $this->assertTrue(is_array($config));
    }

    public function testDefaultConfigContainsLogger()
    {
        $config = Config::loadConfig();
        $logger = $config['logger']();

        $this->assertTrue(in_array(LoggerInterface::class, class_implements($logger)));
    }
}
