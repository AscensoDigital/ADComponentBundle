<?php

namespace ADComponentBundle\Tests\Form\DataTransformer;

use AscensoDigital\ComponentBundle\Form\DataTransformer\ObjectToCampoTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ObjectToCampoTransformerTest extends TestCase
{
    private $om;
    private $repo;
    private $transformer;

    protected function setUp(): void
    {
        $this->om = $this->createMock(ObjectManager::class);
        $this->repo = $this->createMock(\Doctrine\Common\Persistence\ObjectRepository::class);

        $this->om
            ->method('getRepository')
            ->with(DummyEntity::class)
            ->willReturn($this->repo);

        $this->transformer = new ObjectToCampoTransformer($this->om, DummyEntity::class, 'nombre');
    }

    public function testTransformConObjetoValido()
    {
        $obj = new DummyEntity('Claudio');
        $this->assertEquals('Claudio', $this->transformer->transform($obj));
    }

    public function testTransformConNull()
    {
        $this->assertEquals('', $this->transformer->transform(null));
    }

    public function testReverseTransformConValorEncontrado()
    {
        $obj = new DummyEntity('Claudio');

        $this->repo
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['nombre' => 'Claudio'])
            ->willReturn($obj);

        $result = $this->transformer->reverseTransform('Claudio');
        $this->assertSame($obj, $result);
    }

    public function testReverseTransformConValorNoEncontrado()
    {
        $this->repo
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['nombre' => 'Inexistente'])
            ->willReturn(null);

        $this->expectException(TransformationFailedException::class);
        $this->transformer->reverseTransform('Inexistente');
    }

    public function testReverseTransformConValorVacio()
    {
        $this->assertNull($this->transformer->reverseTransform(''));
        $this->assertNull($this->transformer->reverseTransform(null));
    }
}

class DummyEntity
{
    private $nombre;

    public function __construct($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
}
