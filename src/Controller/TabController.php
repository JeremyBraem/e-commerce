<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TabController extends AbstractController
{
    #[Route('/tab/users', name: 'tab.users')]
    public function users(): Response
    {
        $users = 
        [
            ['nom' => 'Braem', 'prenom' => 'Jérémy', 'age' => 23,],
            ['nom' => 'Braem', 'prenom' => 'Jérémy', 'age' => 23,],
            ['nom' => 'Braem', 'prenom' => 'Jérémy', 'age' => 23,],
        ];

        return $this->render('tab/index.html.twig', 
        [
            'controller_name' => 'TabController',
            'users' => $users
        ]);
    }
}
