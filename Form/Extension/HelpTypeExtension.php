<?php
/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 02-02-16
 * Time: 14:55
 */

namespace AscensoDigital\ComponentBundle\Form\Extension;


use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HelpTypeExtension extends AbstractTypeExtension
{
    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType() {
        return FormType::class;
    }

    /**
     * Add the help option
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefined('ad_component_help');
    }

    /**
     * Pass the help to the view
     *
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options) {
        if (array_key_exists('ad_component_help', $options)) {
            $view->vars['ad_component_help'] = $options['ad_component_help'];
        }
    }
}
