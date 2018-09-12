<?php

namespace AscensoDigital\ComponentBundle\Form\Extension;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateCalendarExtension extends AbstractType
{
    public function getExtendedType() {
        return DateType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->addAllowedValues('widget','calendar');
    }

    public function getBlockPrefix()
    {
        return 'adcomponent_date_calendar_extension';
    }
}
