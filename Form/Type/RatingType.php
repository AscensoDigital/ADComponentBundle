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
            'rating_max', 'rating_min', 'rating_step', 'rating_labels', 'rating_label_empty',
            'rating_icon_base', 'rating_icon_check'
        ])
        ->setDefaults([
            'rating_icon_base' => 'fa-star-o',
            'rating_icon_check' => 'fa-star',
            'rating_max' => 5,
            'rating_min' => 1,
            'rating_step' => 1,
            'rating_label_empty' => '(Haz click para puntuar)',
            'rating_labels' => [1 => 'Pésimo', 2 => 'Malo', 3 => 'Normal', 4 => 'Muy Bueno', 5 => 'Excelente']
        ]);
    }

    public function getParent()
    {
        return FormType::class;
    }

    public function buildView(FormView $view, FormInterface $form, array $options) {

        $view->vars['rating_values']=[];
        for($i=$options['rating_min'];$i<=$options['rating_max'];$i+=$options['rating_step']){
            $view->vars['rating_values'][]=$i;
        }
        $view->vars['rating_min']=$options['rating_min'];
        $view->vars['rating_labels']=$options['rating_labels'];
        $view->vars['rating_label_empty']=$options['rating_label_empty'];

        $view->vars['rating_icon_base']=$options['rating_icon_base'];
        $view->vars['rating_icon_check']=$options['rating_icon_check'];
    }
}