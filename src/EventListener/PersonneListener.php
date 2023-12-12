<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;

class PersonneListener
{
    public function __construct(private LoggerInterface $logger){}

    public function onPersonneAdd()
    {
        $this->logger->debug('cc je suis l\'event écouté');
    }
}