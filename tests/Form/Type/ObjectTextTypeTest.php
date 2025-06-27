<?php

namespace ADComponentBundle\Tests\Form\Type;

use AscensoDigital\ComponentBundle\Form\Type\ObjectTextType;
use AscensoDigital\ComponentBundle\Form\DataTransformer\ObjectToIdTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Validator\Validation;

class ObjectTextTypeTest extends TestCase
{
    private $factory;
    private $om;
    private $repo;

    protected function setUp(): void
    {
        $this->om = $this->createMock(ObjectManager::class);
        $this->repo = $this->createMock(\Doctrine\Common\Persistence\ObjectRepository::class);

        $this->om->method('getRepository')
            ->with(DummyEntityForText::class)
            ->willReturn($this->repo);

        $this->factory = Forms::createFormFactoryBuilder()
            ->addExtensions([
                new PreloadedExtension([new ObjectTextType($this->om)], []),
                new ValidatorExtension(Validation::createValidator())
            ])
            ->getFormFactory();
    }

    public function testParentIsText()
    {
        $type = new ObjectTextType($this->om);
        $this->assertEquals(TextType::class, $type->getParent());
    }

    public function testTransformEntityToId()
    {
        $form = $this->factory->create(ObjectTextType::class, null, [
            'object_class' => DummyEntityForText::class,
        ]);

        $entity = new DummyEntityForText(777);
        $form->setData($entity);

        $view = $form->createView();
        $this->assertEquals(777, $view->vars['value']);
    }

    public function testSubmitValidIdReturnsEntity()
    {
        $entity = new DummyEntityForText(123);
        $this->repo
            ->expects($this->once())
            ->method('find')
            ->with(123)
            ->willReturn($entity);

        $form = $this->factory->create(ObjectTextType::class, null, [
            'object_class' => DummyEntityForText::class,
        ]);

        $form->submit('123');

        $this->assertTrue($form->isSynchronized());
        $this->assertSame($entity, $form->getData());
    }

    public function testSubmitIdWithSinDigitoTrimsLastDigit()
    {
        $entity = new DummyEntityForText(456);
        $this->repo
            ->expects($this->once())
            ->method('find')
            ->with(456)
            ->willReturn($entity);

        $form = $this->factory->create(ObjectTextType::class, null, [
            'object_class' => DummyEntityForText::class,
            'sin_digito' => true,
        ]);

        $form->submit('4569'); // Should be trimmed to '456'
        $this->assertSame($entity, $form->getData());
    }
}

class DummyEntityForText
{
    private $id;
    public function __construct($id) { $this->id = $id; }
    public function getId() { return $this->id; }
}
