<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/first/{name}', name: 'first')]

    public function first(HttpFoundationRequest $req, $name): Response
    {
        // dd($req);
        return $this->render('first/index.html.twig', [
            'controller_name' => 'FirstController',
            'name' => $name,
        ]);
    }

    #[Route('/multi/{nb1}/{nb2}', name: 'multi', requirements:['nb1' => '\d+', 'nb2' => '\d+'])]
    public function multiplication($nb1, $nb2)
    {
        $result = $nb1 * $nb2;
        return $this->render('first/index.html.twig', [
            'result' => $result
        ]);
    }

}
