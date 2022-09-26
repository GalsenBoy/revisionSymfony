<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Form\TodoType;
use App\Repository\TodoRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/todo')]
class TodoController extends AbstractController
{
    #[Route('/create', name: 'create_todo')]
    public function createTodo(ManagerRegistry $doctrine, Request $request): Response
    {
        $em = $doctrine->getManager();
        $todos = $doctrine->getRepository(Todo::class)->findBy([]);
        $todo = new Todo();
        $todoForm = $this->createForm(TodoType::class, $todo);
        $todoForm->handleRequest($request);

        if ($todoForm->isSubmitted() && $todoForm->isValid()) {
            $em->persist($todo);
            $em->flush();
            return $this->redirectToRoute('create_todo');
        }
        return $this->render('todo/index.html.twig', [
            'dataForm' => $todoForm->createView(),
            'formName' => 'Mon todo liste',
            'todos' => $todos,

        ]);
    }

    #[Route('/update/{todoId}', name: 'update_todo')]
    public function updateTodo(ManagerRegistry $doctrine, Request $request, $todoId): Response
    {
        $em = $doctrine->getManager();
        $todos = $doctrine->getRepository(Todo::class)->find($todoId);
        $todoForm = $this->createForm(TodoType::class, $todos);
        $todoForm->handleRequest($request);

        if ($todoForm->isSubmitted() && $todoForm->isValid()) {
            $em->persist($todos);
            $em->flush();
            return $this->redirectToRoute('create_todo');
        }
        return $this->render('todo/index.html.twig', [
            'dataForm' => $todoForm->createView(),
            'formName' => 'Mon todo liste',
            'todos' => $todos,

        ]);
    }
}
