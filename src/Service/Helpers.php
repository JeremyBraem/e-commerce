<?php

namespace App\Service;

use App\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class Helpers 
{
    public function __construct(private LoggerInterface $logger, private Security $security)
    {
        
    }
    public function sayCc():string
    {
        return 'cc';
    }

    public function getUser(): mixed
    {
        if($this->security->isGranted('ROLE_ADMIN'))
        {
            $user = $this->security->getUser();
            if($user instanceof User)
            {
                return $user;
            }
        }
    }
}