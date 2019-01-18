<?php

/**
 * StaticMetaFiles.
 */

declare(strict_types=1);

namespace PhpWatch\Automatic;

use GuzzleHttp\Client;
use PhpWatch\Database\DatabaseManager;

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

    /**
     * Get implementation name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'Static Meta files';
    }

    /**
     * Run the service.
     *
     * @param int $pageId
     */
    public function run(int $pageId)
    {
        $page = DatabaseManager::getQuery()
            ->select('*')
            ->from('pages')
            ->where('id = ?')
            ->setParameter(0, $pageId)
            ->execute()
            ->fetchAll()[0];

        foreach ($this->metaFiles as $key => $metaFile) {
            $testUri = \rtrim($page['uri'], '/') . '/' . $key;

            try {
                $client = new Client();
                $res = $client->request('GET', $testUri);
                if (200 === $res->getStatusCode()) {
                    continue;
                }
                \var_dump($res->getStatusCode());
            } catch (\Exception $ex) {
                \var_dump($ex->getMessage());
            }
        }

        echo 'Run for ' . $pageId;
        die();
    }
}
