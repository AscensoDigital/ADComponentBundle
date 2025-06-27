<?php

namespace ADComponentBundle\Tests\Form\Type;

use AscensoDigital\ComponentBundle\Form\Type\ObjectHiddenType;
use AscensoDigital\ComponentBundle\Form\DataTransformer\ObjectToIdTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Validator\Validation;

class ObjectHiddenTypeTest extends TestCase
{
    /**
     * @var FormFactoryInterface
     */
    private $factory;
    private $om;
    private $repo;

    protected function setUp(): void
    {
        $this->om = $this->createMock(ObjectManager::class);
        $this->repo = $this->createMock(\Doctrine\Common\Persistence\ObjectRepository::class);
        $this->om->method('getRepository')
            ->with(DummyEntityForHidden::class)
            ->willReturn($this->repo);

        $this->factory = Forms::createFormFactoryBuilder()
            ->addExtensions([
                new PreloadedExtension([new ObjectHiddenType($this->om)], []),
                new ValidatorExtension(Validation::createValidator())
            ])
            ->getFormFactory();
    }

    public function testParentIsHidden()
    {
        $type = new ObjectHiddenType($this->om);
        $this->assertEquals(HiddenType::class, $type->getParent());
    }

    public function testSubmitValidIdReturnsObject()
    {
        $entity = new DummyEntityForHidden(123);

        $this->repo
            ->expects($this->once())
            ->method('find')
            ->with(123)
            ->willReturn($entity);

        $form = $this->factory->create(ObjectHiddenType::class, null, [
            'object_class' => DummyEntityForHidden::class,
        ]);

        $form->submit('123');

        $this->assertTrue($form->isSynchronized());
        $this->assertSame($entity, $form->getData());
    }

    public function testSubmitNullReturnsNull()
    {
        $form = $this->factory->create(ObjectHiddenType::class, null, [
            'object_class' => DummyEntityForHidden::class,
        ]);

        $form->submit('');

        $this->assertNull($form->getData());
    }

    public function testTransformObjectToId()
    {
        $form = $this->factory->create(ObjectHiddenType::class, null, [
            'object_class' => DummyEntityForHidden::class,
        ]);

        $entity = new DummyEntityForHidden(456);
        $form->setData($entity);

        $view = $form->createView();
        $this->assertEquals(456, $view->vars['value']);
    }
}

class DummyEntityForHidden
{
    private $id;

    public function __construct($id) { $this->id = $id; }
    public function getId() { return $this->id; }
}
