<?php
/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 02-02-16
 * Time: 15:26
 */

namespace AscensoDigital\ComponentBundle\Form\Extension;


use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Exception\LogicException;
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
    public static function getExtendedType()
    {
        return FormType::class;
    }

    /**
     * Add the [pre_addon|post_addon] option
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefined('ad_component_addon') # pre|post|both
            ->setDefined('ad_component_addon_type') # text|button|icon
            ->setDefined('ad_component_addon_content_type') # text|icon
            ->setDefined('ad_component_addon_content')
            ->setDefined('ad_component_addon_attr');
        $resolver->setDefaults([
           'ad_component_addon_type' => ['pre' => 'text', 'post' => 'text'],
            'ad_component_addon_content_type' => ['pre' => 'text', 'post' => 'text']
        ]);
    }

    /**
     * Pass the help to the view
     *
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options) {
        if(isset($options['ad_component_addon'])) {
            switch ($options['ad_component_addon']) {
                case 'pre':
                case 'post':
                    $addons=[$options['ad_component_addon']];
                    break;
                case 'both':
                    $addons=['pre','post'];
                    break;
                default:
                    throw new LogicException('Valor "'.$options['ad_component_addon'].'" parámetro "ad_component_addon" no válido. Valores permitidos: pre|post|both');
            }
            foreach ($addons as $addon) {
                $view->vars['ad_component_addon_type_'.$addon] = is_array($options['ad_component_addon_type']) ?
                    (isset($options['ad_component_addon_type'][$addon]) ? $options['ad_component_addon_type'][$addon] : null) :
                    $options['ad_component_addon_type'];
                if(is_null($view->vars['ad_component_addon_type_'.$addon])){
                    throw new LogicException('Falta parámetro "ad_component_addon_type" para "'.$addon.'" addon');
                }
                elseif(!in_array($view->vars['ad_component_addon_type_'.$addon], ['text','button','icon'])){
                    throw new LogicException('Valor "'.$view->vars['ad_component_addon_type_'.$addon].'" parámetro "ad_component_addon_type" para "'.$addon.'" addon no válido. Valores permitidos: text|button|icon');
                }

                $view->vars['ad_component_addon_content_type_'.$addon] = is_array($options['ad_component_addon_content_type']) ?
                    (isset($options['ad_component_addon_content_type'][$addon]) ? $options['ad_component_addon_content_type'][$addon] : null) :
                    $options['ad_component_addon_content_type'];
                if($view->vars['ad_component_addon_type_'.$addon]=='button') {
                    if(is_null($view->vars['ad_component_addon_content_type_'.$addon])) {
                        throw new LogicException('Falta Parámetro "ad_component_addon_content_type" para "' . $addon . '" addon');
                    }
                    elseif(!in_array($view->vars['ad_component_addon_content_type_'.$addon], ['text','icon'])) {
                        throw new LogicException('Valor "'.$view->vars['ad_component_addon_content_type_'.$addon].'" parámetro "ad_component_addon_content_type" para "'.$addon.'" addon no válido. Valores permitidos: text|icon');
                    }
                }

                $view->vars['ad_component_addon_content_'.$addon] = is_array($options['ad_component_addon_content']) ?
                    (isset($options['ad_component_addon_content'][$addon]) ? $options['ad_component_addon_content'][$addon] : null) :
                    $options['ad_component_addon_content'];
                if(is_null($view->vars['ad_component_addon_content_'.$addon])){
                    throw new LogicException('Falta Parámetro "ad_component_addon_content" para "'.$addon.'" addon');
                }

                $view->vars['ad_component_addon_attr_'.$addon] = isset($options['ad_component_addon_attr']) ?
                    (isset($options['ad_component_addon_attr'][$addon]) ? $options['ad_component_addon_attr'][$addon] : $options['ad_component_addon_attr']) :
                    array();
            }
        }
    }
}
