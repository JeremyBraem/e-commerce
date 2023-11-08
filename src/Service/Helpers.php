<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class Helpers 
{
    public function __construct(private LoggerInterface $logger, Security $security)
    {
        
    }
    public function sayCc():string
    {
        return 'cc';
    }

    public function getUser()
    {
        return $this->getUser();
    }
}