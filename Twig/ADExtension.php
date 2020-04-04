<?php
/**
 * Created by PhpStorm.
 * User: claudio
 * Date: 14-08-15
 * Time: 3:18
 */

namespace AscensoDigital\ComponentBundle\Twig;


use AscensoDigital\ComponentBundle\Util\StrUtil;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ADExtension extends AbstractExtension {

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
            new TwigFunction('ad_component_get_env',array($this,'getEnv'))
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
        return [
            [
                '!' => ['precedence' => 50, 'class' => \Twig\Node\Expression\Unary\NotUnary::class],
            ],
            [
                '||' => ['precedence' => 10, 'class' => \Twig\Node\Expression\Binary\OrBinary::class, 'associativity' => \Twig\ExpressionParser::OPERATOR_LEFT],
                '&&' => ['precedence' => 15, 'class' => \Twig\Node\Expression\Binary\AndBinary::class, 'associativity' => \Twig\ExpressionParser::OPERATOR_LEFT],
            ],
        ];
    }

    public function getLayout() {
        return $this->layout;
    }

    public function getVersion() {
        return $this->version;
    }

    public function getEnv($varname) {
        $var = getenv($varname);
        return $var ? $var : null;
    }

    public function bool2str($bool) {
        return StrUtil::bool2str($bool);
    }

    public function getName() {
        return 'ad_extension';
    }
}
