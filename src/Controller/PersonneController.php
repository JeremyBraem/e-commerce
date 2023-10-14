<?php

namespace App\Controller;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('personne')]
class PersonneController extends AbstractController
{
    #[Route('/', name: 'personne.list')]
    public function index(ManagerRegistry $doc): Response
    {
        $repository = $doc->getRepository(Users::class);
        $personnes = $repository->findAll();

        // dd($personnes);
        return $this->render('personne/index.html.twig', ['personnes' => $personnes]);
    }

    #[Route('/age/{ageMin}/{ageMax}', name: 'personne.list.age')]
    public function age(UsersRepository $repo, $ageMin, $ageMax): Response
    {
        $personnes = $repo->findByAge($ageMin, $ageMax);
        return $this->render('personne/index.html.twig', ['personnes' => $personnes]);
    }

    #[Route('/stat/age/{ageMin}/{ageMax}', name: 'personne.list.stat.age')]
    public function stat(UsersRepository $repo, $ageMin, $ageMax): Response
    {
        $stat = $repo->statPersonne($ageMin, $ageMax);
        return $this->render('personne/stat.html.twig', ['stat' => $stat[0], 'ageMin' => $ageMin, 'ageMax' => $ageMax]);
    }

    #[Route('/all/{page?1}', name: 'personne.list.all')]
    public function all(ManagerRegistry $doc, $page): Response
    {
        $nbr = 15;
        $repository = $doc->getRepository(Users::class);

        $nbPersonne = count($repository->findAll());
        $nbPage = ceil($nbPersonne/$nbr);

        $personnes = $repository->findBy([], [], $nbr, (($page -1) * $nbr));

        return $this->render('personne/index.html.twig', 
        [
            'personnes' => $personnes, 
            'isPaginated' => true,
            'nbPage' => $nbPage,
            'page' => $page,
            'nbr' => $nbr
        ]);
    }

    #[Route('/{id<\d+>}', name: 'personne.detail')]
    public function detail(Users $personne = null): Response
    {
        if(!$personne)
        {
            $this->addFlash('error', 'la personne n\'existe pas');
            return $this->redirectToRoute('personne.list');
        }
        
        return $this->render('personne/detail.html.twig', ['personne' => $personne]);

    }

    #[Route('/add', name: 'personne.add')]
    public function addPersonne(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $personne = new Users();
        $personne->setFistname('Braem');
        $personne->setName('Jérémy');
        $personne->setAge('23');

        //Ajout
        $entityManager->persist($personne);

        //Execute
        $entityManager->flush();

        return $this->render('personne/detail.html.twig', [
            'personne' => $personne,
        ]);
    }

    #[Route('/delete/{id}', name: 'personne.delete')]
    public function deletePersonne(ManagerRegistry $doc ,Users $personne = null): RedirectResponse
    {
        if($personne)
        {
            $manager = $doc->getManager();
            $manager->remove($personne);
            $manager->flush();

            $this->addFlash('success', 'La personne a été supprimer avec succés');
        }
        else
        {
            $this->addFlash('error', 'La personne n\'éxiste pas');
        }

        return $this->redirectToRoute('personne.list.all');
    }

    #[Route('/update/{id}/{name}/{firstname}/{age}', name: 'personne.update')]
    public function updatePersonne(ManagerRegistry $doc, Users $personne = null, $name, $firstname, $age): RedirectResponse
    {
        if($personne)
        {
            $personne->setName($name);
            $personne->setFistname($firstname);
            $personne->setAge($age);

            $manager = $doc->getManager();
            $manager->persist($personne);
            $manager->flush();

            $this->addFlash('success', 'La personne a été modifier avec succés');
        }
        else
        {
            $this->addFlash('error', 'La personne n\'éxiste pas');
        }

        return $this->redirectToRoute('personne.list.all');
    }
}
