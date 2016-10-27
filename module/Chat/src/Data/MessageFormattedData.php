<?php

namespace Chat\Data;

use Chat\Entity\Message;

class MessageFormattedData implements MessageFormattedDataInterface
{
    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $createdAtString;

    public function __construct(Message $message)
    {
        $this->content = $message->getContent();
        $this->createdAtString = ($message->getCreatedAt() instanceof \DateTime) ? $message->getCreatedAt()->format('Y-m-d H:i:s') : '';
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getCreatedAtString()
    {
        return $this->createdAtString;
    }
}
