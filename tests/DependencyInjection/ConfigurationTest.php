<?php

namespace AscensoDigital\ComponentBundle\Tests\DependencyInjection;

use AscensoDigital\ComponentBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    public function testDefaultConfiguration()
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration($configuration, []);

        $this->assertArrayHasKey('bootstrap_layout', $config);
        $this->assertEquals('horizontal', $config['bootstrap_layout']);
    }

    public function testCustomBootstrapLayout()
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration($configuration, [[
            'bootstrap_layout' => 'vertical',
        ]]);

        $this->assertEquals('vertical', $config['bootstrap_layout']);
    }

    public function testInvalidBootstrapLayoutThrowsException()
    {
        $this->expectException(\Symfony\Component\Config\Definition\Exception\InvalidConfigurationException::class);

        $processor = new Processor();
        $configuration = new Configuration();

        $processor->processConfiguration($configuration, [[
            'bootstrap_layout' => 'invalido',
        ]]);
    }

}
