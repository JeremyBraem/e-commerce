<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ToDoController extends AbstractController
{
    #[Route('/todo', name: 'todo')]
    public function index(Request $req): Response
    {
        $session = $req->getSession();
        //Afficher le tab de ToDo
        //si j'ai le tab de toDo dans la session je ne fais que l'afficher 
        if(!$session->has('todos'))
        {
            $todos = [];

            $session->set('todos', $todos);
            $this->addFlash('info', "La liste est des trucs à faire viens d'être initialisé");
        }
        //sinon je l'initialise

        return $this->render('to_do/index.html.twig', [
            'controller_name' => 'ToDoController',
        ]);
    }

    #[Route('/todo/add/{name}/{content}', name: 'add.todo')]
    public function addToDo(Request $req, $name, $content): RedirectResponse
    {
        $session = $req->getSession();

        if($session->has('todos'))
        {
            $todos = $session->get('todos');
            if(isset($todos[$name]))
            {
                $this->addFlash('error', "Le truc a faire existe déjà");
            }
            else
            {
                $todos[$name] = $content;
                $this->addFlash('success', "Le truc a faire est ajouté");
                $session->set('todos', $todos);
            }
        }
        else
        {
            $this->addFlash('error', "La liste des trucs à faire n'est pas initialisé");

        }

        return $this->redirectToRoute('todo');
    }

    #[Route('/todo/update/{name}/{content}', name: 'update.todo')]
    public function updateToDo(Request $req, $name, $content): RedirectResponse
    {
        $session = $req->getSession();

        if($session->has('todos'))
        {
            $todos = $session->get('todos');
            if(!isset($todos[$name]))
            {
                $this->addFlash('error', "Le truc a faire n'existe pas");
            }
            else
            {
                $todos[$name] = $content;
                $this->addFlash('success', "Le truc a faire est update");
                $session->set('todos', $todos);
            }
        }
        else
        {
            $this->addFlash('error', "La liste des trucs à faire n'est pas initialisé");

        }

        return $this->redirectToRoute('todo');
    }

    #[Route('/todo/delete/{name}', name: 'delete.todo')]
    public function deleteToDo(Request $req, $name): RedirectResponse
    {
        $session = $req->getSession();

        if($session->has('todos'))
        {
            $todos = $session->get('todos');
            if(!isset($todos[$name]))
            {
                $this->addFlash('error', "Le truc a faire n'existe pas");
            }
            else
            {
                unset($todos[$name]);
                $session->set('todos', $todos);
                $this->addFlash('success', "Le truc a faire est supprimé");
            }
        }
        else
        {
            $this->addFlash('error', "La liste des trucs à faire n'est pas initialisé");

        }

        return $this->redirectToRoute('todo');
    }

    #[Route('/todo/reset', name: 'reset.todo')]
    public function resetToDo(Request $req): RedirectResponse
    {
        $session = $req->getSession();

        $session->remove('todos');

        return $this->redirectToRoute('todo');
    }

}
