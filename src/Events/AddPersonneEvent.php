<?php

namespace App\Events;

use App\Entity\Users;
use Symfony\Contracts\EventDispatcher\Event;

class AddPersonneEvent extends Event
{
    const ADD_PERSONNE_EVENT = 'personne.add';

    public function __construct(private Users $personne) {}

    public function getPersonne()
    {
        return $this->personne;
    }
}