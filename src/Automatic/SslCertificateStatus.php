<?php

/**
 * SslCertificateStatus.
 */

declare(strict_types=1);

namespace PhpWatch\Automatic;

use AcmePhp\Ssl\Parser\CertificateParser;
use PhpWatch\Database\DatabaseManager;

/**
 * SslCertificateStatus.
 */
class SslCertificateStatus extends AbstractAutomatic
{
    /**
     * Get implementation name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'SSL Certificate Status';
    }

    /**
     * Run the service.
     *
     * @param int $pageId
     *
     * @throws \Doctrine\DBAL\DBALException
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

        $uri = \rtrim($page['uri'], '/');

        $schema = 'ssl';
        $port = 443;
        $remoteSocket = \sprintf('%s://%s:%s', $schema, \parse_url($uri, PHP_URL_HOST), $port);

        try {
            $configuration = \stream_context_create(['ssl' => ['capture_peer_cert' => true]]);
            $client = \stream_socket_client($remoteSocket, $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $configuration);
            $content = \stream_context_get_params($client);

            \openssl_x509_export($content['options']['ssl']['peer_certificate'], $pem);

            $parser = new CertificateParser();
            $rawCertificate = new \AcmePhp\Ssl\Certificate($pem);
            $parsedCertificate = $parser->parse($rawCertificate);
            echo '<pre>';
            \var_dump($parsedCertificate->getSubject());
            \var_dump($parsedCertificate->getIssuer());
            \var_dump($parsedCertificate->isSelfSigned());
            \var_dump($parsedCertificate->getValidFrom());
            \var_dump($parsedCertificate->getValidTo());
            \var_dump($parsedCertificate->getSerialNumber());
            \var_dump($parsedCertificate->getSubjectAlternativeNames());
            \var_dump($parsedCertificate->isExpired());
        } catch (\Exception $ex) {
            \var_dump($ex->getMessage());
        }
    }
}
