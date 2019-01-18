<?php

/**
 * TwigExtension.
 */

declare(strict_types=1);

namespace PhpWatch\View;

use Comsolit\HTMLBuilder\HTMLBuilder;
use GuzzleHttp\Client;
use Leafo\ScssPhp\Compiler;
use MatthiasMullie\Minify\CSS;
use PhpWatch\Cache\GeneralCache;
use PhpWatch\Time\TimeService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * TwigExtension.
 */
class TwigExtension extends AbstractExtension
{
    /**
     * Get functions.
     *
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('icon', [$this, 'icon'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * Get tests.
     *
     * @return array
     */
    public function getTests(): array
    {
        return [];
    }

    /**
     * Get filters.
     *
     * @return array|\Twig_Filter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('resource', [$this, 'resource'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * Render icon.
     *
     * @param string $name
     * @param string $size sx, sm, lg
     *
     * @return string
     */
    public function icon(string $name, string $size = 'sm'): string
    {
        return '<span class="oi oi-' . $name . ' icon icon-' . $size . '"></span>';
    }

    /**
     * Render resource.
     *
     * @param string $resource
     *
     * @throws \PhpWatch\Exception
     * @throws \Exception
     *
     * @return string
     *
     * @todo complile this filter
     */
    public function resource(string $resource): string
    {
        $pathInfo = \pathinfo($resource);
        switch (\mb_strtolower($pathInfo['extension'])) {
            case 'js':
            case 'html': // @todo change route to local JS to js
                $builder = new HTMLBuilder('script');
                $builder->addAttribute('src', $resource);
                break;
            case 'css':
                $builder = new HTMLBuilder('link');
                $builder->setVoid()
                    ->addAttribute('href', $resource)
                    ->addAttribute('rel', 'stylesheet');
                break;
            case 'scss':
                $builder = new HTMLBuilder('link');

                $sourceAbsolute = APPLICATION_ROOT . 'web' . $resource;
                if (!\is_file($sourceAbsolute)) {
                    break;
                }

                $targetRelative = '/css/' . $pathInfo['filename'] . '.' . \filemtime($sourceAbsolute) . '.css';
                $targetAbsolute = APPLICATION_ROOT . 'web' . $targetRelative;

                if (!\is_file($targetAbsolute)) {
                    $scss = new Compiler();
                    $minifier = new CSS($scss->compile(\file_get_contents($sourceAbsolute)));
                    \file_put_contents($targetAbsolute, $minifier->minify());
                }

                $builder->setVoid()
                    ->addAttribute('href', $targetRelative)
                    ->addAttribute('rel', 'stylesheet');
                break;
            default:
                return '';
        }

        $builder->addAttribute('crossorigin', 'anonymous');
        if (!$this->isLocalResource($resource)) {
            $cache = new GeneralCache();
            $integrity = $cache->cache('sri_' . \md5($resource), function () use ($resource) {
                $content = $this->getContent($resource);

                return $this->hashResource($content);
            }, TimeService::DAY * 30);
            $builder->addAttribute('integrity', $integrity);
        }

        return $builder->build();
    }

    /**
     * Check if resource is local.
     *
     * @param string $resource
     *
     * @return bool
     */
    protected function isLocalResource(string $resource): bool
    {
        $domain = \parse_url($resource, PHP_URL_HOST);

        return '' === \trim((string) $domain) || $_SERVER['SERVER_NAME'] === $domain;
    }

    /**
     * Get file content.
     *
     * @param string $resource
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return string
     */
    protected function getContent(string $resource): string
    {
        $client = new Client();
        $res = $client->request('GET', $resource);

        return $res->getBody()
            ->getContents();
    }

    /**
     * Get SRI hash.
     *
     * @param string $content
     *
     * @return string
     */
    protected function hashResource(string $content): string
    {
        return 'sha384-' . \base64_encode(\hash('sha384', $content, true));
    }
}
