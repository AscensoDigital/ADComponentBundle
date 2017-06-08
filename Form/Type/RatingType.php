<?php
/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 08-06-17
 * Time: 1:01
 */

namespace AscensoDigital\ComponentBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RatingType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined([
            'max_rating'
        ])
        ->setDefaults([
            'max_rating' => 5
        ]);
    }

    public function getParent()
    {
        return FormType::class;
    }

    public function buildView(FormView $view, FormInterface $form, array $options) {
        $view->vars['max_rating']=$options['max_rating'];
    }
}