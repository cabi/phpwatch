<?php

/**
 * WeekReport.
 */

declare(strict_types=1);

namespace PhpWatch\Automatic;

use PhpWatch\Database\DatabaseManager;
use PhpWatch\Mail\Message;
use PhpWatch\Mail\Sender;

/**
 * WeekReport.
 */
class WeekReport extends AbstractAutomatic
{
    /**
     * Get implementation name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'Week Report';
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
        $users = DatabaseManager::getQuery()
            ->select('*')
            ->from('users')
            ->execute()
            ->fetchAll();

        $sender = new Sender();
        foreach ($users as $user) {
            $message = (new Message())
                ->setFrom(['phpwatch@website.org' => 'PHP Watch service'])
                ->setTo([$user['email']])
                ->setBody('Just a test email');
            $sender->send($message);
        }
    }
}
