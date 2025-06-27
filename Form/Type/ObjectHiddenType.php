<?php

namespace AscensoDigital\ComponentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AscensoDigital\ComponentBundle\Form\DataTransformer\ObjectToIdTransformer;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of ObjectHiddenType
 *
 * @author claudio
 */
class ObjectHiddenType extends AbstractType {
    /**
     * @var ObjectManager
     */
    private $om;
    
   /**
    * 
    * @param \Doctrine\Common\Persistence\ObjectManager $om
    */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new ObjectToIdTransformer($this->om,$options['object_class']);
        $builder->addModelTransformer($transformer);
    }

    public function getParent()
    {
        return HiddenType::class;
    }

    public function getBlockPrefix()
    {
        return 'object_hidden';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(array(
            'object_class',
        ));
    }
}
