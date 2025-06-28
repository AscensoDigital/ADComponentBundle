<?php

namespace AscensoDigital\ComponentBundle\Tests\Twig;

use AscensoDigital\ComponentBundle\Twig\ADExtension;
use PHPUnit\Framework\TestCase;

class ADExtensionTest extends TestCase
{
    public function testGetLayoutReturnsValue()
    {
        $ext = new ADExtension('default_layout');
        $this->assertEquals('default_layout', $ext->getLayout());
    }

    public function testGetName()
    {
        $ext = new ADExtension('layout');
        $this->assertEquals('ad_extension', $ext->getName());
    }

    public function testRegisteredFunction()
    {
        $ext = new ADExtension('layout');
        $functions = $ext->getFunctions();

        $found = false;
        foreach ($functions as $function) {
            if ($function instanceof \Twig_SimpleFunction && $function->getName() === 'ad_component_get_layout') {
                $found = true;
                break;
            }
        }
        $this->assertTrue($found, 'Function ad_component_get_layout not found.');
    }

    public function testRegisteredFilters()
    {
        $ext = new ADExtension('layout');
        $filters = $ext->getFilters();

        $expected = ['utf8_decode', 'utf8_encode', 'nl2br', 'is_numeric'];
        $found = [];

        foreach ($filters as $filter) {
            if ($filter instanceof \Twig_SimpleFilter) {
                $found[] = $filter->getName();
            }
        }

        foreach ($expected as $name) {
            $this->assertContains($name, $found, "Filter {$name} not registered.");
        }
    }

    public function testOperatorsDefinition()
    {
        $ext = new ADExtension('layout');
        list($unary, $binary) = $ext->getOperators();

        $this->assertArrayHasKey('!', $unary);
        $this->assertEquals('Twig_Node_Expression_Unary_Not', $unary['!']['class']);

        $this->assertArrayHasKey('||', $binary);
        $this->assertEquals('Twig_Node_Expression_Binary_Or', $binary['||']['class']);

        $this->assertArrayHasKey('&&', $binary);
        $this->assertEquals('Twig_Node_Expression_Binary_And', $binary['&&']['class']);
    }
}
