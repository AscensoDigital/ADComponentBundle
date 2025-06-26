<?php

namespace ADComponentBundle\Tests\Form\DataTransformer;

use AscensoDigital\ComponentBundle\Form\DataTransformer\ObjectToIdTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Exception\TransformationFailedException;
use PHPUnit\Framework\TestCase;

class ObjectToIdTransformerTest extends TestCase
{
    private $om;
    private $repo;

    protected function setUp(): void
    {
        $this->om = $this->createMock(ObjectManager::class);
        $this->repo = $this->createMock(\Doctrine\Common\Persistence\ObjectRepository::class);

        $this->om
            ->method('getRepository')
            ->with(DummyEntityForId::class)
            ->willReturn($this->repo);
    }

    public function testTransformConObjeto()
    {
        $obj = new DummyEntityForId(123);
        $transformer = new ObjectToIdTransformer($this->om, DummyEntityForId::class);

        $this->assertEquals(123, $transformer->transform($obj));
    }

    public function testTransformConNull()
    {
        $transformer = new ObjectToIdTransformer($this->om, DummyEntityForId::class);
        $this->assertEquals('', $transformer->transform(null));
    }

    public function testReverseTransformConIdValido()
    {
        $obj = new DummyEntityForId(123);
        $this->repo->expects($this->once())
            ->method('find')
            ->with(123)
            ->willReturn($obj);

        $transformer = new ObjectToIdTransformer($this->om, DummyEntityForId::class);
        $this->assertSame($obj, $transformer->reverseTransform('123'));
    }

    public function testReverseTransformConSinDigito()
    {
        $obj = new DummyEntityForId(123);
        $this->repo->expects($this->once())
            ->method('find')
            ->with(123)
            ->willReturn($obj);

        $transformer = new ObjectToIdTransformer($this->om, DummyEntityForId::class, true);
        $this->assertSame($obj, $transformer->reverseTransform('1234')); // recorta a '123'
    }

    public function testReverseTransformIdNoEncontrado()
    {
        $this->repo->expects($this->once())
            ->method('find')
            ->with(999)
            ->willReturn(null);

        $transformer = new ObjectToIdTransformer($this->om, DummyEntityForId::class);

        $this->expectException(TransformationFailedException::class);
        $transformer->reverseTransform('999');
    }

    public function testReverseTransformConIdVacio()
    {
        $transformer = new ObjectToIdTransformer($this->om, DummyEntityForId::class);
        $this->assertNull($transformer->reverseTransform(null));
        $this->assertNull($transformer->reverseTransform(''));
    }
}

class DummyEntityForId
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}

