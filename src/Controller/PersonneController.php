<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\PersonneType;
use App\Repository\UsersRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


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

    #[Route('/edit/{id?0}', name: 'personne.edit')]
    public function addPersonne(Users $personne = null, ManagerRegistry $doctrine, Request $req, SluggerInterface $slugger): Response
    {
        $new = false;

        if(!$personne)
        {
            $new = true;
            $personne = new Users;
        }

        $form = $this->createForm(PersonneType::class, $personne);

        $form->handleRequest($req);

        if($form->isSubmitted())
        {
            $photo = $form->get('photo')->getData();

            if ($photo) 
            {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();

                try 
                {
                    $photo->move(
                        $this->getParameter('personne_directory'),
                        $newFilename
                    );
                }
                catch (FileException $e) 
                {

                }

                $personne->setImage($newFilename);
            }

            $manager = $doctrine->getManager();
            $manager->persist($personne);

            $manager->flush();

            if($new)
            {
                $message = "a été ajouté avec succès";
            }
            else
            {
                $message = "a été modifié avec succès";
            }

            $this->addFlash('succes', $personne->getName(). $message);

            return $this->redirectToRoute('personne.list.all');
        }
        else
        {
            return $this->render('personne/add-personne.html.twig', [
                'form' => $form->createView()
            ]);
        }
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
