<?php

/**
 * Sender.
 */
declare(strict_types=1);

namespace PhpWatch\Mail;

use Swift_Mailer;
use Swift_SmtpTransport;

/**
 * Sender.
 */
class Sender
{
    /**
     * Send the email.
     *
     * @param Message $message
     *
     * @return bool
     */
    public function send(Message $message): bool
    {
        $transport = (new Swift_SmtpTransport('mailhog', 1025));
        $mailer = new Swift_Mailer($transport);

        return (bool) $mailer->send($message);
    }
}
