<?php

namespace ADComponentBundle\Tests\Form\Type;

use AscensoDigital\ComponentBundle\Form\Type\ObjectTextCampoType;
use AscensoDigital\ComponentBundle\Form\DataTransformer\ObjectToCampoTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Validator\Validation;

class ObjectTextCampoTypeTest extends TestCase
{
    private $factory;
    private $om;
    private $repo;

    protected function setUp(): void
    {
        $this->om = $this->createMock(ObjectManager::class);
        $this->repo = $this->createMock(\Doctrine\Common\Persistence\ObjectRepository::class);

        $this->om->method('getRepository')
            ->with(DummyEntityForCampo::class)
            ->willReturn($this->repo);

        $this->factory = Forms::createFormFactoryBuilder()
            ->addExtensions([
                new PreloadedExtension([new ObjectTextCampoType($this->om)], []),
                new ValidatorExtension(Validation::createValidator())
            ])
            ->getFormFactory();
    }

    public function testParentIsText()
    {
        $type = new ObjectTextCampoType($this->om);
        $this->assertEquals(TextType::class, $type->getParent());
    }

    public function testTransformEntityToCampo()
    {
        $form = $this->factory->create(ObjectTextCampoType::class, null, [
            'object_class' => DummyEntityForCampo::class,
            'campo' => 'rut'
        ]);

        $entity = new DummyEntityForCampo(1, '12.345.678-k');
        $form->setData($entity);

        $view = $form->createView();
        $this->assertEquals('12.345.678-k', $view->vars['value']);
    }

    public function testSubmitCampoReturnsEntity()
    {
        $entity = new DummyEntityForCampo(1, '12.345.678-k');
        $this->repo
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['rut' => '12.345.678-k'])
            ->willReturn($entity);

        $form = $this->factory->create(ObjectTextCampoType::class, null, [
            'object_class' => DummyEntityForCampo::class,
            'campo' => 'rut'
        ]);

        $form->submit('12.345.678-k');

        $this->assertTrue($form->isSynchronized());
        $this->assertSame($entity, $form->getData());
    }

    public function testDefaultCampoIsId()
    {
        $entity = new DummyEntityForCampo(7, '11111111-1');

        $this->repo
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => '7'])
            ->willReturn($entity);

        $form = $this->factory->create(ObjectTextCampoType::class, null, [
            'object_class' => DummyEntityForCampo::class,
        ]);

        $form->submit('7');
        $this->assertSame($entity, $form->getData());
    }
}

class DummyEntityForCampo
{
    private $id;
    private $rut;

    public function __construct($id, $rut)
    {
        $this->id = $id;
        $this->rut = $rut;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRut()
    {
        return $this->rut;
    }
}
