<?php

namespace AscensoDigital\ComponentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AscensoDigital\ComponentBundle\Form\DataTransformer\ObjectToIdTransformer;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of ObjectTextType
 *
 * @author claudio
 */
class ObjectTextType extends AbstractType {
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
        $transformer = new ObjectToIdTransformer($this->om,$options['object_class'],$options['sin_digito']);
        $builder->addModelTransformer($transformer);
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'object_text';
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(array(
            'sin_digito',
        ));
        $resolver->setRequired(array(
            'object_class',
        ));
        $resolver->setDefaults(array(
            'sin_digito' => false,
        ));
    }
}
