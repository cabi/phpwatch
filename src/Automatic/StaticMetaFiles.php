<?php

/**
 * StaticMetaFiles.
 */

declare(strict_types=1);

namespace PhpWatch\Automatic;

/**
 * StaticMetaFiles.
 */
class StaticMetaFiles extends AbstractAutomatic
{
    /**
     * Meta files.
     *
     * @var array
     */
    protected $metaFiles = [
        'sitemap.xml' => 'XML Sitemap for URLs of the website',
        'robots.txt' => 'Craler information for indexing process',
        'browserconfig.xml' => 'Microsoft tile configuration for touch interfaces',
        'autodiscover/autodiscover.xml' => 'Microsoft exchange file for AD information',
        'favicon.ico' => 'Default favicon path',
        'apple-touch-icon.png' => 'Default apple touch icon, if there are no meta information',
    ];
}
