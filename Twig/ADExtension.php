<?php
/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 14-08-15
 * Time: 3:18
 */

namespace AscensoDigital\ComponentBundle\Twig;


use AscensoDigital\ComponentBundle\Util\StrUtil;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ADExtension extends \Twig_Extension {

    private $layout;
    private $version;

    public function __construct($layout,$version) {
        $this->layout=$layout;
        $this->version=$version;
    }

    public function getFunctions()
    {
        return array(
            new TwigFunction('ad_component_get_layout',array($this,'getLayout')),
            new TwigFunction('ad_component_get_bootstrap_version',array($this,'getVersion')),

        );
    }

    public function getFilters()
    {
        return array(
            new TwigFilter('utf8_decode', 'utf8_decode'),
            new TwigFilter('utf8_encode', 'utf8_encode'),
            new TwigFilter('nl2br','nl2br'),
            new TwigFilter('is_numeric','is_numeric'),
            new TwigFilter('ucfirst','ucfirst'),
            new TwigFilter('ucwords','ucwords'),
            new TwigFilter('bool2str',[$this,'bool2str']),
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

    public function getVersion() {
        return $this->version;
    }

    public function bool2str($bool) {
        return StrUtil::bool2str($bool);
    }

    public function getName() {
        return 'ad_extension';
    }
}
