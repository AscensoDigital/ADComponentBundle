<?php

namespace AscensoDigital\ComponentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of ObjectHiddenType
 *
 * @author claudio
 */
class DateTimeHiddenType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new DateTimeToStringTransformer(null,null,$options['format']);
        $builder->addModelTransformer($transformer);
    }

    public function getParent()
    {
        return HiddenType::class;
    }

    public function getBlockPrefix()
    {
        return 'datetime_hidden';
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(array(
            'format'));
        $resolver->setDefaults(array(
            'format' => 'Y-m-d H:i:s',
        ));
    }
}
