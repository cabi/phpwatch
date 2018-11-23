<?php

/**
 * Twig.
 */
declare(strict_types=1);

namespace PhpWatch\View;

use Slim\Views\TwigExtension as CoreTwigExtension;
use Twig\Extension\DebugExtension;

/**
 * Twig.
 */
class Twig extends \Slim\Views\Twig
{
    /**
     * Twig constructor.
     *
     * @param string $path
     * @param array  $settings
     */
    public function __construct(string $path = APPLICATION_ROOT . 'templates/', array $settings = [])
    {
        $isProduction = true;
        $config = [
            'cache' => $isProduction ? APPLICATION_ROOT . 'var/tmp/view/' : false,
            'strict_variables' => true,
            'debug' => $isProduction ? false : true,
        ];
        parent::__construct($path, $config);
    }

    /**
     * Build up the view object.
     *
     * @param $container
     */
    public function init($container): void
    {
        $this->addExtension(new CoreTwigExtension($container['router'], $container['request']->getUri()));
        $this->addExtension(new TwigExtension());
        $this->addExtension(new DebugExtension());
        $this->addExtension(new \nochso\HtmlCompressTwig\Extension());
    }
}
