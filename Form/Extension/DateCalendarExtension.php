<?php

namespace AscensoDigital\ComponentBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateCalendarExtension extends AbstractTypeExtension
{
    public static function getExtendedTypes(): iterable
    {
        return [ DateType::class ];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined('ad_component_widget')
            ->setDefault('widget','single_text')
            ->setDefault('ad_component_widget','')
            ->addAllowedValues('ad_component_widget',['','calendar']);
    }

    /**
     * Pass the help to the view
     *
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options) {
        if (array_key_exists('ad_component_widget', $options)) {
            $view->vars['ad_component_widget'] = $options['ad_component_widget'];
        }
    }

    public function getBlockPrefix()
    {
        return 'adcomponent_date_calendar_extension';
    }
}
