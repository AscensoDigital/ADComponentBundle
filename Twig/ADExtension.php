<?php
/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 14-08-15
 * Time: 3:18
 */

namespace AscensoDigital\ComponentBundle\Twig;


class ADExtension extends \Twig_Extension {

    private $layout;

    public function __construct($layout) {
        $this->layout=$layout;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('ad_component_get_layout',array($this,'getLayout'))
        );
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('utf8_decode', 'utf8_decode'),
            new \Twig_SimpleFilter('utf8_encode', 'utf8_encode'),
            new \Twig_SimpleFilter('nl2br','nl2br'),
            new \Twig_SimpleFilter('is_numeric','is_numeric'),
        );
    }

    public function getOperators()
    {
        return array(
            array(
                '!' => array('precedence' => 50, 'class' => 'Twig_Node_Expression_Unary_Not'),
            ),
            array(
                '||' => array('precedence' => 10, 'class' => 'Twig_Node_Expression_Binary_Or', 'associativity' => \Twig_ExpressionParser::OPERATOR_LEFT),
                '&&' => array('precedence' => 15, 'class' => 'Twig_Node_Expression_Binary_And', 'associativity' => \Twig_ExpressionParser::OPERATOR_LEFT),
            ),
        );
    }

    public function getLayout() {
        return $this->layout;
    }
    
    public function getName() {
        return 'ad_extension';
    }
}
