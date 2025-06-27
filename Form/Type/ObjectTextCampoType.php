<?php

namespace AscensoDigital\ComponentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AscensoDigital\ComponentBundle\Form\DataTransformer\ObjectToCampoTransformer;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of ObjectTextCampoType
 *
 * @author claudio
 */
class ObjectTextCampoType extends AbstractType {
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
        $transformer = new ObjectToCampoTransformer($this->om,$options['object_class'],$options['campo']);
        $builder->addModelTransformer($transformer);
    }

    public function getParent()
    {
        return TextType::class;
    }

    public function getBlockPrefix()
    {
        return 'object_text_campo';
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(array(
            'campo',
        ));
        $resolver->setRequired(array(
            'object_class',
        ));
        $resolver->setDefaults(array(
            'campo' => 'id',
        ));
    }
}
