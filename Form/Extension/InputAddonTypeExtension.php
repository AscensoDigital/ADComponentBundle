<?php
/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 02-02-16
 * Time: 15:26
 */

namespace AscensoDigital\ComponentBundle\Form\Extension;


use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InputAddonTypeExtension extends AbstractTypeExtension {

    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return FormType::class;
    }

    /**
     * Add the [pre_addon|post_addon] option
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefined('pre_addon')
            ->setDefined('post_addon');
    }

    /**
     * Pass the help to the view
     *
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options) {
        if(isset($options['pre_addon'])) {
            $view->vars['pre_addon'] = $options['pre_addon'];
        }
        if(isset($options['post_addon'])) {
            $view->vars['post_addon'] = $options['post_addon'];
        }
    }
}