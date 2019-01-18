<?php

/**
 * Message.
 */
declare(strict_types=1);

namespace PhpWatch\Mail;

use Swift_Message;

/**
 * Message.
 */
class Message extends Swift_Message
{
    /**
     * Message constructor.
     *
     * @param string|null $subject
     * @param string|null $body
     * @param string|null $contentType
     * @param string|null $charset
     */
    public function __construct(?string $subject = null, ?string $body = null, ?string $contentType = null, ?string $charset = null)
    {
        parent::__construct($subject, $body, $contentType, $charset);
        $this->setSubject('PHP Watch');
    }
}
