<?php

/**
 * LocalizationMiddleware.
 */
declare(strict_types=1);

namespace PhpWatch\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * LocalizationMiddleware.
 */
class LocalizationMiddleware extends \Boronczyk\LocalizationMiddleware
{
    /**
     * Support local webserver.
     *
     * @param Request $req
     *
     * @return string
     */
    protected function localeFromPath(Request $req): string
    {
        $parts = \explode('/', $req->getUri()->getPath());
        foreach ($parts as $part) {
            $lang = $this->filterLocale($part);
            if ('' !== $lang) {
                return $lang;
            }
        }

        return '';
    }

    /**
     * Parse the locale
     * Like the parent, but check the locale with '' in front.
     *
     * @param string $header
     *
     * @return array
     */
    protected function parse(string $header): array
    {
        // the value may contain multiple languages separated by commas,
        // possibly as locales (ex: en_US) with quality (ex: en_US;q=0.5)
        $values = [];
        foreach (\explode(',', $header) as $lang) {
            @list($locale, $quality) = \explode(';', $lang, 2);
            if ('' === $locale) {
                continue;
            }
            $val = $this->parseLocale($locale);
            $val['quality'] = $this->parseQuality($quality ?? '');
            $values[] = $val;
        }

        return $values;
    }
}
